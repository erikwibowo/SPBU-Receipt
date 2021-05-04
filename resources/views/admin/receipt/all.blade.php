<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk</title>
    <style>
        @font-face {
            font-family:"telidon";
            src: url("{{ asset('font/Telidon-Hv.ttf') }}") format("truetype");
        }
        @font-face {
            font-family:"ristretto";
            src: url("{{ asset('font/Ristretto_Pro_Regular.otf') }}") format("truetype");
        }
        body{
            font-family: 'telidon'
        }
        .title{
            font-family: 'ristretto'; line-height:5px; margin-bottom: -8px; font-size: 30px
        }
    </style>
</head>
<body>
    @foreach ($data as $i)
        <p class="title">{{ $i->spbu->number }}</p> <br>
        JL Wahidin <br><br>DS KALIGELANG <br>KEC TAMAN <br>KAB PEMALANG <br>JAWA TENGAH
        <p></p>
        <table width="100%" style="margin-bottom: 10px">
            <tbody>
                <tr>
                    <td>
                        {{ date('d/m/Y', strtotime($i->date)) }}
                    </td>
                    <td style="text-align: right; ">
                        {{ date('H:i', strtotime($i->date)) }}<br>
                    </td>
                </tr>
                <tr>
                    <td>Receipt No. : {{ $i->receipt_number }}</td>
                    <td style="text-align: right; "><br></td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="margin-bottom: 10px">
            <tbody>
                <tr>
                    <td>Pump No.</td>
                    <td style="text-align: right; ">{{ $i->pump_number }}</td>
                </tr>
                <tr>
                    <td>Grade</td>
                    <td style="text-align: right; ">{{ $i->product }}</td>
                </tr>
                <tr>
                    <td>Volume</td>
                    <td style="text-align: right; ">{{ $i->volume }}</td>
                </tr>
                <tr>
                    <td>Unit Price</td>
                    <td style="text-align: right; ">{{ $i->rate }}</td>
                </tr>
                <tr>
                    <td><b>Amount</b></td>
                    <td style="text-align: right; "><b>{{ $i->price }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="margin-bottom: 10px">
            <tbody>
                <tr>
                    <td>Vehicle No.</td>
                    <td style="text-align: right; ">{{ $i->vehicle_number == null ? "Not Entered":$i->vehicle_number }}</td>
                </tr>
            </tbody>
        </table>
        <p>TERIMA KASIH <br>ATAS KUNJUNGANNYA<br>SEMOGA ANDA PUAS</p>
        <div style="page-break-after:always"></div>
    @endforeach
    <script>
        window.print()
    </script>
</body>
</html>