<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Laporan')</title>
    <style>
        html,
        body {
            font-family: sans-serif;
            font-size: 12px;
            padding-top: 150px;
            padding-bottom: 50px;
        }

        .header {
            position: fixed;
            top: 0;
            width: 100%;
            height: 100px;
            text-align: center;
        }

        .pagenum:before {
            content: counter(page);
        }

        table#dat {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table#kop {
            border: none !important;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        h2,
        p {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <table id="kop">
            <tr>
                <td style="width: 60px; border:none">
                    <img src="{{ $logoBase64 }}" alt="{{ $company->name }}" height="80">
                </td>
                <td style="text-align: center; border: none">
                    <h1 style="margin: 0;">{{ $company->name }}</h1>
                    <p style="margin: 0; font-size: 14px">
                        {{ $company->address }}
                        {{ $company->phone ? '. ' . $company->phone : '' }}
                        {{ $company->email ? '. ' . $company->email : '' }}
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <h2>Laporan Data Periode: {{ $start }} - {{ $end }}</h2>
    </div>

    @yield('content')

</body>

</html>
