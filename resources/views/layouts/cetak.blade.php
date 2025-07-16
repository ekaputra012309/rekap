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
                    <img src="{{ public_path('img/logo dkm.png') }}" alt="Logo" width="80">
                </td>
                <td style="text-align: center; border: none">
                    <h1 style="margin: 0;">Masjid At-Taqwa</h1>
                    <p style="margin: 0; font-size: 14px">
                        Jl. Raya Penggilingan Komplek Perkampungan Industri Kecil (PIK) Blok E Rt 09 Rw 10 Penggilingan
                        Cakung Jakarta Timur.</p>
                </td>
            </tr>
        </table>
        <hr>
        <h2>Laporan Data Periode: {{ $start }} - {{ $end }}</h2>
    </div>

    @yield('content')

</body>

</html>
