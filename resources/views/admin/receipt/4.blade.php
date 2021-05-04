<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk</title>
</head>
<body>
    <p>&nbsp; &nbsp; &nbsp; &nbsp;PERTAMINA "PASTI PAS"</p>
    <p></p><pre>{{ $data->receipt_number }}</pre><p></p>
    <p></p><pre>{{ $data->spbu->address }}</pre><p></p>
    <table width="100%">
        <tbody>
            <tr>
                <td><pre>{{ date('d/m/Y', strtotime($data->date)) }}</pre></td>
                <td style="text-align: right; "><pre>{{ date('H:i:s', strtotime($data->date)) }}</pre><br></td>
            </tr>
            <tr>
                <td>Receipt No. : <pre>{{ $data->receipt }}</pre></td>
                <td style="text-align: right; "><br></td>
            </tr>
        </tbody>
    </table>
    <p><br></p>
    <table width="100%">
        <tbody>
            <tr>
                <td>Pump No.</td>
                <td style="text-align: right; "><pre>{{ $data->pump_number }}</pre></td>
            </tr>
            <tr>
                <td>Grade</td>
                <td style="text-align: right; "><pre>{{ $data->product }}</pre></td>
            </tr>
            <tr>
                <td>Volume</td>
                <td style="text-align: right; "><pre>{{ $data->volume }}</pre></td>
            </tr>
            <tr>
                <td>Unit Price</td>
                <td style="text-align: right; "><pre>{{ $data->price }}</pre></td>
            </tr>
            <tr>
                <td><b>Amount</b></td>
                <td style="text-align: right; "><b><pre>{{ $data->price }}</pre></b></td>
            </tr>
            <tr>
                <td><br></td>
                <td><br></td>
            </tr>
            <tr>
                <td>Vehicle No.</td>
                <td style="text-align: right; "><pre>{{ $data->vehicle_number }}</pre></td>
            </tr>
        </tbody>
    </table>
    <p><br></p>
    <p>TERIMA KASIH DAN SELAMAT JALAN</p>
</body>
</html>