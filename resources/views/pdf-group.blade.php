<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Group : {{ strtoupper($group) }}</title>
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
        .title-top {
            display: inline-block;
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            padding: 4px 15px;
            border-radius: 4px;
        }

        .title {
            margin-top: 0px;
            font-size: 18px;
            font-weight: 700;
            text-align: center;
            color: #1a237e;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #777;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            font-weight: 600;
        }

        td {
            font-size: 13px;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px dashed #aaa;
            margin-top: 25px;
            padding-top: 5px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div style="text-align:center;">
		<span class="title-top">Group : {{ strtoupper($group) }}</span>
    </div>

	<div class="title">Student List</div>

    <table>
        <thead>
            <tr>
                <th style="width: 80px;">Reg No</th>
                <th style="width: 180px;">Name</th>
                <th style="width: 180px;">Father's Name</th>
                <th style="width: 120px;">Mobile</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $key => $student)
                <tr>
                    <td>{{ $student->reg_number }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->father }}</td>
                    <td>{{ $student->mobile }}</td>
                    <td>{{ $student->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Printed on: {{ now()->format('F d, Y (h:i A)') }}
		<span>Total: {{$students->count()}}</span>
    </div>
</body>

</html>
