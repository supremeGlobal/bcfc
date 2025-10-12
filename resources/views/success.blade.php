@extends('layouts.app2')

<style>
    .center-box {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    table {
        margin: 0 auto;
        width: auto;
    }
</style>

@section('content')
	<div class="container center-box mt-4 pb-2 w-50">    
        <table class="table table-bordered">
            <tr>
                <th>Student Registered:</th>
                <td>{{ $student->name }}</td>
            </tr>
			<tr>
				<th>Reg No:</th>
				<td>{{ $student->reg_number }}</td>
			</tr>
			<tr>
				<th>Mobile No:</th>
				<td>{{ $student->mobile }}</td>
			</tr>
			<tr>
				<th>Date of birth:</th>
				<td>{{ $student->dob }}</td>
			</tr>
			<tr>
				<td colspan="2">
					<a href="{{ route('student.print', $student->id) }}" target="_blank" class="btn btn-primary w-100">
						<i class="bi bi-printer pe-2"></i> Print Registration
					</a>
				</td>
			</tr>
        </table>
    </div>
@endsection
