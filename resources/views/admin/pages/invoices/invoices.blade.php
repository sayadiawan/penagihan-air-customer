<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Invoice</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .invoice-box table tr.top .title {
            flex: 1;
        }

        .invoice-box table tr.top .title img {
            width: 100px;
        }

        .invoice-box table tr.top .info {
            flex: 2;
            text-align: right;
        }

        .invoice-box table tr.information {
            margin-top: 20px;
        }

        .invoice-box table tr.information td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.heading {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top {
                flex-direction: column;
                text-align: center;
            }

            .invoice-box table tr.information {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td class="title">
                    <img src="{{ public_path('images/logo.png') }}" />
                </td>

                <td class="info">
                    Invoice #: 123<br />
                    Created: {{ $today }}<br />
                </td>
            </tr>

            <tr class="information">
                <td>
                    Nama Pelanggan: {{ $tagihan->user->name }}<br />
                    ID Pelanggan: {{ $tagihan->user_id }}<br />
                </td>

                <td>
                    Tagihan Bulan : {{ $tagihan->bulan }}
                </td>
            </tr>

            <tr class="heading">
                <td>Tarif</td>
                <td>Check #</td>
            </tr>

            <tr class="details">
                <td>Tarif :</td>
                <td>{{ $tagihan->tarif }} m³</td>
            </tr>

            <tr class="heading">
                <td>Materan</td>
                <td>Check #</td>
            </tr>

            <tr class="details">
                <td>Awal :</td>
                <td>{{ $tagihan->dataAwal->awal }} m³</td>
            </tr>

            <tr class="details">
                <td>Akhir :</td>
                <td>{{ $tagihan->akhir }} m³</td>
            </tr>

            <tr class="heading">
                <td>Pakai</td>
                <td>Check #</td>
            </tr>

            <tr class="details">
                <td>Pemakain :</td>
                <td>{{ $tagihan->pakai }} m³</td>
            </tr>

            <tr class="heading">
                <td>Tagihan</td>
                <td>Harga</td>
            </tr>

            <tr class="item">
                <td>Tagihan Bulan Ini :</td>
                <td>Rp. {{ $tagihan->tagihan }}</td>
            </tr>

            <tr class="item">
                <td>Tuggakan :</td>
                <td>Rp. {{ $tagihan->dataAwal->tunggakan }}</td>
            </tr>

            <tr class="item last">
                <td>Denda :</td>
                <td>Rp. {{ $tagihan->dataAwal->denda }}</td>
            </tr>
            <tr class="item last">
                <td>Kebersihan :</td>
                <td>-</td>
            </tr>
            <tr class="item last">
                <td>Keamanan :</td>
                <td>-</td>
            </tr>
            <tr class="item last">
                <td>Lain-Lain :</td>
                <td>-</td>
            </tr>

            <tr class="total">
                <td></td>
                <td>Rp. {{ $tagihan->total_tagihan }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
