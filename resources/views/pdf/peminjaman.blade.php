<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Peminjaman</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            background-color: #f8f9fa; 
            margin: 0; 
            padding: 20px;
        }
        .container { 
            width: 100%; 
            max-width: 600px; 
            margin: 0 auto; 
            background: #ffffff; 
            padding: 20px; 
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header { 
            font-size: 22px; 
            font-weight: bold; 
            text-align: center; 
            margin-bottom: 15px;
            border-bottom: 3px solid #FFD700;
            padding-bottom: 10px;
            color: #FFC107; 
        }
        .info { 
            font-size: 14px;
            margin-bottom: 15px;
        }
        .info p { 
            margin: 5px 0;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
            background: #ffffff;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 10px; 
            text-align: left;
        }
        th { 
            background: #FFD700; 
            color: black; 
            text-align: center;
        }
        tr:nth-child(even) { 
            background: #FFF3CD; 
        }
        .footer { 
            margin-top: 20px; 
            font-size: 12px; 
            text-align: center; 
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Struk Peminjaman Barang</div>

        <div class="info">
            <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
            <p><strong>Unit:</strong> {{ $peminjaman->unit }}</p>
            <p><strong>Tempat:</strong> {{ $peminjaman->tempat }}</p>
            <p><strong>Acara:</strong> {{ $peminjaman->acara }}</p>
            <p><strong>Tanggal Pinjam:</strong> {{ date('d M Y', strtotime($peminjaman->tanggal_pinjam)) }}</p>
            <p><strong>Tanggal Kembali:</strong> {{ date('d M Y', strtotime($peminjaman->tanggal_kembali)) }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kode Barang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman->detailPeminjaman as $detail)
                    <tr>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>{{ $detail->barang->kode_barang }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Terima kasih telah melakukan peminjaman.</p>
        </div>
    </div>
</body>
</html>
