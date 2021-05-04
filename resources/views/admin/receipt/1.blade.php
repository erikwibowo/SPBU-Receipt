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
    </style>
</head>
<body>
    <p style="font-family: ristretto; line-height:5px; margin-bottom: -8px; font-size: 30px">{{ $data->spbu->number }}</p> <br>
    JL Wahidin <br><br>DS KALIGELANG <br>KEC TAMAN <br>KAB PEMALANG <br>JAWA TENGAH
    <p></p>
    <table width="100%" style="margin-bottom: 10px">
        <tbody>
            <tr>
                <td>
                    {{ date('d/m/Y', strtotime($data->date)) }}
                </td>
                <td style="text-align: right; ">
                    {{ date('H:i', strtotime($data->date)) }}<br>
                </td>
            </tr>
            <tr>
                <td>Receipt No. : {{ $data->receipt_number }}</td>
                <td style="text-align: right; "><br></td>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-bottom: 10px">
        <tbody>
            <tr>
                <td>Pump No.</td>
                <td style="text-align: right; ">{{ $data->pump_number }}</td>
            </tr>
            <tr>
                <td>Grade</td>
                <td style="text-align: right; ">{{ $data->product }}</td>
            </tr>
            <tr>
                <td>Volume</td>
                <td style="text-align: right; ">{{ $data->volume }}</td>
            </tr>
            <tr>
                <td>Unit Price</td>
                <td style="text-align: right; ">{{ $data->rate }}</td>
            </tr>
            <tr>
                <td><b>Amount</b></td>
                <td style="text-align: right; "><b>{{ $data->price }}</b></td>
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
                <td style="text-align: right; ">{{ $data->vehicle_number == null ? "Not Entered":$data->vehicle_number }}</td>
            </tr>
        </tbody>
    </table>
    <p>TERIMA KASIH <br>ATAS KUNJUNGANNYA<br>SEMOGA ANDA PUAS</p>
</body>
</html>