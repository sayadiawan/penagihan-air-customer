<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Invoice {{ $tagihan->kode_invoice }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #555;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: left;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .logo {
            width: 150px;
            height: auto;
            display: block;
            margin: 0 auto 20px auto;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <h1>Invoice</h1>
        <!-- Centered logo -->
        <img src="{{ $base64Logo }}" alt="Logo" class="logo">

        <h2>Invoice #: {{ $tagihan->kode_invoice }}</h2>
        <p>Tanggal: {{ $today }}</p>
        <p>Nama Pelanggan: {{ $tagihan->user->name }}</p>
        <p>ID Pelanggan: {{ $tagihan->user_id }}</p>
        <p>Tagihan Bulan: {{ $tagihan->bulan }}, {{ $week }}</p>

        <table>
            <tr>
                <th>Deskripsi</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <td>Tagihan Bulan Ini</td>
                <td>Rp. {{ number_format($tagihan->tagihan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunggakan</td>
                <td>Rp. {{ number_format($tagihan->dataAwal->tunggakan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Denda</td>
                <td>Rp. {{ number_format($tagihan->dataAwal->denda, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Deposit</td>
                <td>Rp. {{ number_format($tagihan->deposit, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td>Total Tagihan</td>
                <td>Rp. {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Terima kasih atas pembayaran Anda!</p>
        </div>
    </div>
</body>

</html>
