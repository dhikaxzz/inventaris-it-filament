<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Peminjaman Barang</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            background-color: #f8f9fa; 
            margin: 0; 
            padding: 20px;
        }
        .container { 
            width: 100%; 
            max-width: 400px; 
            margin: 0 auto; 
            background: #ffffff; 
            padding: 20px; 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }
        .header { 
            font-size: 20px; 
            font-weight: bold; 
            text-align: center; 
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #FFD700;
            color: #333; 
        }
        .info { 
            font-size: 14px;
            margin-bottom: 15px;
        }
        .info p { 
            margin: 5px 0;
            line-height: 1.5;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
            background: #ffffff;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left;
            font-size: 12px;
        }
        th { 
            background: #FFD700; 
            color: #333; 
            text-align: center;
            font-weight: bold;
        }
        tr:nth-child(even) { 
            background: #FFF3CD; 
        }
        .footer { 
            margin-top: 20px; 
            font-size: 12px; 
            text-align: center; 
            color: #555;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .footer p { 
            margin: 5px 0;
        }
        .highlight {
            color: #FFC107;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Struk Peminjaman Barang</div>

        <div class="info">
            <p><strong>Nama Peminjam:</strong> <span class="">{{ $peminjaman->nama_peminjam }}</span></p>
            <p><strong>Unit:</strong> {{ $peminjaman->unit }}</p>
            <p><strong>Tempat:</strong> {{ $peminjaman->tempat }}</p>
            <p><strong>Acara:</strong> {{ $peminjaman->acara }}</p>
            <p><strong>Tanggal Pinjam:</strong> <span class="">{{ date('d M Y', strtotime($peminjaman->tanggal_pinjam)) }}</span></p>
            <p><strong>Tanggal Kembali:</strong> <span class="">{{ date('d M Y', strtotime($peminjaman->tanggal_kembali)) }}</span></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman->detailPeminjaman as $detail)
                    <tr>
                        <td>{{ $detail->barang->kode_barang }}</td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Terima kasih telah melakukan peminjaman.</p>
            <p>Harap kembalikan barang tepat waktu.</p>
        </div>
    </div>
</body>
</html>