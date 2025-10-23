<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\HandlesImageUpload;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
	use HandlesImageUpload;

	public function home()
	{
		return view('registration');
	}

	public function saveRegistration(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'        => [
				'required',
				'string',
				'max:255',
				Rule::unique('students')->where(function ($query) use ($request) {
					return $query->where('father', $request->father);
				}),
			],
			'father'      => ['required', 'string', 'max:255'],
			'mother'      => ['required', 'string', 'max:255'],
			'dob'         => ['required', 'date'],
			'school'      => ['required', 'string', 'max:255'],
			'mobile'      => ['required', 'string', 'max:20'],

			'image'       => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
			'certificate' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}

		$groups = [
			'A' => ['start' => '2020-10-24', 'end' => '2025-10-24'],
			'B' => ['start' => '2017-10-24', 'end' => '2020-10-23'],
			'C' => ['start' => '2014-10-24', 'end' => '2017-10-23'],
			'D' => ['start' => '2011-10-24', 'end' => '2014-10-23'],
		];

		$dob = Carbon::parse($request->dob);

		if ($dob < Carbon::parse($groups['D']['start'])) {
			return back()->with('error', 'You are not eligible.')->withInput();
		}

		$group = null;
		foreach ($groups as $key => $range) {
			if ($dob->between(Carbon::parse($range['start']), Carbon::parse($range['end']))) {
				$group = $key;
				break;
			}
		}
		$group = $group ?? 'D';

		$groupRanges = [
			'A' => ['start' => 1001, 'end' => 1999],
			'B' => ['start' => 2001, 'end' => 2999],
			'C' => ['start' => 3001, 'end' => 3999],
			'D' => ['start' => 4001, 'end' => 4999],
		];

		$lastReg = Student::where('group', $group)
			->orderBy('id', 'desc')
			->value('reg_number');

		if ($lastReg) {
			// extract only the number part (e.g. from "B-2001" → 2001)
			$lastNumber = (int) preg_replace('/[^0-9]/', '', $lastReg);
			$newNumber = $lastNumber + 1;
		} else {
			$newNumber = $groupRanges[$group]['start'];
		}

		if ($newNumber > $groupRanges[$group]['end']) {
			return back()->with('error', "Registration limit reached for Group $group.")->withInput();
		}

		$regNumber = "{$group}-{$newNumber}";

		$student = new Student();
		$student->name        = $request->name;
		$student->father      = $request->father;
		$student->mother      = $request->mother;
		$student->dob         = $request->dob;
		$student->school      = $request->school;
		$student->mobile      = $request->mobile;
		$student->group       = $group;
		$student->reg_number  = $regNumber;
		$student->save();

		if ($request->hasFile('image')) {
			$student->image = $this->uploadFile($request->file('image'), "{$regNumber}_photo");
		}

		if ($request->hasFile('certificate')) {
			$student->certificate = $this->uploadFile($request->file('certificate'), "{$regNumber}_certificate");
		}

		$student->save();
		return redirect()->route('student.success', ['id' => $student->id])->with('success', "Student registered successfully! Reg No: {$regNumber}");
	}

	public function registrationSuccess($id)
	{
		$student = Student::findOrFail($id);
		return view('success', compact('student'));
	}

	public function printPDF($id)
	{
		$student = Student::findOrFail($id);
		$pdf = Pdf::loadView('pdf', ['student' => $student])->setPaper('a4', 'portrait');

		return $pdf->stream("{$student->reg_number}.pdf");
	}

	public function search()
	{
		$groups = [
			'A' => '2020-10-24',
			'B' => '2017-10-24',
			'C' => '2014-10-24',
			'D' => '2011-10-24',
		];

		$student = Student::where('id', 10)->first();

		if (!$student) {
			abort(404, 'Student not found');
		}

		$pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf', [
			'student' => $student,
			'groups' => $groups,
		])->setPaper('a4', 'portrait');

		// 👇 This will show the PDF directly in browser
		return $pdf->stream("student_{$student->id}.pdf");
	}

	public function searchNumber(Request $request)
	{
		$request->validate([
			'mobile' => 'required|numeric',
		]);

		$data['students'] = Student::where('mobile', $request->mobile)->orderBy('id', 'desc')->get();

		return view('search', $data);
	}

	// Admin site
	public function dashboard()
	{
		$groups = ['A', 'B', 'C', 'D'];

		$data['types'] = [];

		foreach ($groups as $group) {
			$pending  = Student::where('group', $group)->where('status', 'Pending')->count();
			$accepted = Student::where('group', $group)->where('status', 'Accepted')->count();
			$rejected = Student::where('group', $group)->where('status', 'Rejected')->count();

			$data['types'][] = [
				'link'     => url("students/$group"),
				'title'    => "Group: $group",
				'pending'  => $pending,
				'accepted' => $accepted,
				'rejected' => $rejected,
			];
		}

		// Total row
		$totalPending  = Student::where('status', 'Pending')->count();
		$totalAccepted = Student::where('status', 'Accepted')->count();
		$totalRejected = Student::where('status', 'Rejected')->count();

		$data['types'][] = [
			'link'     => url("students"),
			'title'    => 'Total',
			'pending'  => $totalPending,
			'accepted' => $totalAccepted,
			'rejected' => $totalRejected,
		];

		return view('dashboard', $data);
	}

	public function students($group = null)
	{
		$students = Student::query();

		if ($group) {
			$students->where('group', strtoupper($group));
		}

		$students = $students->get()->map(function ($student) {
			$dob = Carbon::parse($student->dob);
			$diff = $dob->diff(Carbon::parse('2025-10-24'));
			$student->dob_formatted = $dob->format('F-d, Y');
			$student->age = ['y' => $diff->y, 'm' => $diff->m, 'd' => $diff->d];
			$student->image_url = $student->image ? asset($student->image) : asset('default/profile.png');
			$student->certificate_url = $student->certificate ? asset($student->certificate) : null;
			$ext = $student->certificate_url ? strtolower(pathinfo($student->certificate_url, PATHINFO_EXTENSION)) : null;
			$student->certificate_is_image = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
			$student->certificate_extension = $ext;
			return $student;
		});

		return view('students', compact('students'));
	}

	public function updateStatus(Request $request, $id)
	{
		$student = Student::findOrFail($id);
		$student->status = $request->status;
		$student->save();

		return response()->json([
			'success' => true,
			'message' => 'Status updated successfully',
			'status' => $student->status
		]);
	}
	
	// public function groupList()
	// {
	// 	$g = 'A';
	// 	$student = Student::where('group', 'A')->get();
	// 	$pdf = Pdf::loadView('pdf-group', ['student' => $student]);

	// 	return $pdf->stream("{$g}.pdf");
	// }

	public function groupList($group)
	{
		$students = Student::where('group', strtoupper($group))->get();

		$pdf = Pdf::loadView('pdf-group', compact('students', 'group'))->setPaper('a4', 'portrait');
		return $pdf->stream("group_{$group}_list.pdf");
	}
}