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

	public function saveRegister(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'        => [
				'required', 'string', 'max:255',
				Rule::unique('students')->where(function ($query) use ($request) {
					return $query->where('father', $request->father);
				}),
			],
			'father'      => ['required', 'string', 'max:255'],
			'mother'      => ['required', 'string', 'max:255'],
			'dob'         => ['required', 'date'],
			'school'      => ['required', 'string', 'max:255'],
			'mobile'      => ['required', 'string', 'max:20'],

			'image'       => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
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
			// $student->image = $this->uploadFile($request->file('image'), "student_{$student->id}_photo");
			$student->image = $this->uploadFile($request->file('image'), "{$regNumber}_photo");
		}

		if ($request->hasFile('certificate')) {
			// $student->certificate = $this->uploadFile($request->file('certificate'), "student_{$student->id}_certificate");
			$student->certificate = $this->uploadFile($request->file('certificate'), "{$regNumber}_certificate");
		}

		$student->save();
		return redirect()->route('student.success', ['id' => $student->id])->with('success', "Student registered successfully! Reg No: {$regNumber}");
	}

	public function registerSuccess($id)
	{
		$student = Student::findOrFail($id);
		return view('success', compact('student'));
	}

	public function printPDF($id)
	{
		$student = Student::findOrFail($id);
		$groups = [
			'A' => '2020-10-24',
			'B' => '2018-10-24',
			'C' => '2016-10-24',
			'D' => '2011-10-24',
		];
		$pdf = Pdf::loadView('pdf', ['student' => $student, 'groups' => $groups])
			->setPaper('a4', 'portrait');

		return $pdf->stream("student_{$student->id}.pdf");
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

	public function dashboard()
	{
		$data['types'] = [
			[
				'link'  => url('students/a'),
				'value' => Student::where('group', 'A')->count(),
				'title' => 'Group: A'
			],
			[
				'link'  => url('students/b'),
				'value' => Student::where('group', 'B')->count(),
				'title' => 'Group: B'
			],
			[
				'link'  => url('students/c'),
				'value' => Student::where('group', 'C')->count(),
				'title' => 'Group: C'
			],
			[
				'link'  => url('students/d'),
				'value' => Student::where('group', 'D')->count(),
				'title' => 'Group: D'
			],
			[
				'link'  => url('students'),
				'value' => Student::all()->count(),
				'title' => 'Total'
			],
		];
		return view('dashboard', $data);
	}

	public function studentList()
	{
		$data['students'] = Student::all();
		return view('students', $data);
	}

	public function studentGroup($group)
	{
		$data['students'] = Student::where('group', strtoupper($group))->get();
		return view('students', $data);
	}
}