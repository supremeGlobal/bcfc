<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>

    <style>
        @page {
            margin: 40px 30px;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 13px;
            color: #000;
        }

        /* Header */
        .header-container {
            width: 600px;
            /* set header width */
            margin: 0 auto;
            /* center horizontally */
        }

        .header-table {
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
            /* vertically center logo and text */
        }

        .logo {
            width: 100px;
            height: auto;
            display: block;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #00723b;
            margin: 0 0 2px 0;
            text-transform: uppercase;
        }

        .company-address,
        .company-contact {
            font-size: 11px;
            margin: 1px 0;
            color: #444;
        }

        /* Top Section */
        .top-section {
            width: 100%;
            margin: 15px 0;
        }

        .photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

		.title-top{
			display: inline-block;
			font-size: 30px;
			font-weight: 700;
			color: #fff;
			background: #000;
			text-align: center;
			padding: 0px 10px;
		}

        .title {
			margin-top: 2px;
            font-size: 15px;
            font-weight: 700;           
            text-align: center;
        }

        .group-cell {
            text-align: center;
            vertical-align: middle;
            padding: 5px;
        }

        .group {
            font-size: 28px;
            font-weight: 800;
            color: #1a237e;
            margin: 0;
            border: 1px dashed;
            padding: 2px;
        }

        .regno {
            font-size: 18px;
			font-weight: 800;
            margin-top: 5px;
            display: inline-block;
        }

        /* Info Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .student-info th,
        .student-info td,

		.group-range th,
        .group-range td
		{
            border: 1px solid #777;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            width: 30%;
            background: #f2f2f2;
            font-weight: 600;
        }

        /* Signature */
        .signature {
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
        }

        .sig-left,
        .sig-right {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }

        .line {
            border-top: 1px dashed #000;
            margin-bottom: 5px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #666;
            border: 1px dashed;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header-container">
        <table class="header-table" width="100%">
            <tr>
                <td style="width: 100px; padding: 0;">
                    <img src="{{ public_path('uploads/bcfc.png') }}" class="logo">
                </td>

                <td style="padding-left: 10px; text-align: center;">
                    <div class="company-name">Bangladesh-China Friendship Center</div>
                    <div class="company-address">Tropical Mollah Tower, Level 13th, 15/1-5 Pragati Sarani, Middle Badda,
                        Dhaka-1212</div>
                    <div class="company-contact">Contact: 01322846635, 01322846651</div>
                </td>
            </tr>
        </table>
    </div>

    <hr style="border: 0.7px dashed; margin-top: 10px; width: 100%;">

    <!-- Top Row -->
    <table class="top-section">
        <tr>
            <td width="100">
                <img src="{{ public_path($student->image ?? 'uploads/profile.jpg') }}" class="photo">
            </td>
            <td align="center">
                <div class="title-top">
					 NI HAO! CHINA
				</div>
				<div class="title">
					The 24<sup>th</sup> Bangladesh Children Art Competition-2025
				</div>
            </td>
            <td width="100" class="group-cell">
                <div class="group">Group - {{ $student->group }}</div>
                <div class="regno">Reg No: {{ $student->reg_number }}</div>
            </td>
        </tr>
    </table>

    <!-- Student Info -->
    <table class="student-info">
        <tr>
            <th>Student Name</th>
            <td>{{ $student->name }}</td>
        </tr>
        <tr>
            <th>Father's Name</th>
            <td>{{ $student->father }}</td>
        </tr>
        <tr>
            <th>Mother's Name</th>
            <td>{{ $student->mother }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td style="position: relative;">
                @php
                    $dob = \Carbon\Carbon::parse($student->dob);
                    $today = \Carbon\Carbon::now();
                    // $age = $dob->diff($today);
                    $age = $dob->diff('2025-10-24');
                @endphp

                <span style="float:left;">
                    {{ $dob->format('F-d, Y') }}
                </span>

                <span style="float:right; font-weight: bold;">
                    Age: (Year: {{ $age->y }}, Month: {{ $age->m }}, Day: {{ $age->d }})
                </span>

                <div style="clear:both;"></div>
            </td>
        </tr>

        <tr>
            <th>School / Institute</th>
            <td>{{ $student->school }}</td>
        </tr>
        <tr>
            <th>Mobile</th>
            <td>{{ $student->mobile }}</td>
        </tr>
    </table>

	{{-- <div class="group-reminder" style="margin-top: 15px; font-size: 11.5px;">
		@foreach($groups as $group => $date)
			<strong>Group {{ $group }}: Upto {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</strong>
			@if (!$loop->last)
				| 
			@endif
		@endforeach
	</div> --}}

	<table class="group-range" style="width: 100%; font-size: 12px; margin-top: 15px; border-collapse: collapse; text-align: center">
		<tr>
			<td style="width: 50%; padding: 5px;">
				24/10/2020 - 24/10/2025 -- <strong>A</strong>
			</td>
			<td style="width: 50%; padding: 5px;">
				24/10/2017 - 23/10/2020 -- <strong>B</strong>
			</td>
		</tr>
		<tr>
			<td style="width: 50%; padding: 5px;">
				24/10/2014 - 23/10/2017 -- <strong>C</strong>
			</td>
			<td style="width: 50%; padding: 5px;">
				24/10/2011 - 23/10/2014 -- <strong>D</strong>
			</td>
		</tr>
	</table>

    <!-- Signature Section -->
    <table class="signature">
        <tr>
            <td class="sig-left">
                <div class="line"></div>
                Student's Signature
            </td>
            <td style="width:40%;"></td> <!-- spacer -->
            <td class="sig-right">
                <div class="line"></div>
                Authorized Signatory
				{{-- <br>Bangladesh-China Friendship Center --}}
            </td>
        </tr>
    </table>	

    <!-- Footer -->
    <div class="footer">
        Thank you for participating in the Children Art Competition 2025<br>
        Printed on: {{ now()->format('F-d, Y') }}
    </div>
</body>

</html>
