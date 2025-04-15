<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .credit-value {
            color: #dc3545;
        }

        .debit-value {
            color: #198754;
        }

        h1 {
            text-align: center;
        }

        .table-container {
            margin: 0 15px;
        }
    </style>
</head>

<body>

    <h1>Riwayat Transaksi</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mutasi as $item)
                    <tr>
                        <td>{{ $item->user->name ?? 'Unknown' }}</td>
                        <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="debit-value">
                            {{ $item->debit > 0 ? 'Rp ' . number_format($item->debit, 0, ',', '.') : '-' }}
                        </td>
                        <td class="credit-value">
                            {{ $item->credit > 0 ? 'Rp ' . number_format($item->credit, 0, ',', '.') : '-' }}
                        </td>
                        <td>
                            @if($item->status === 'done')
                                Selesai
                            @elseif($item->status === 'process')
                                Diproses
                            @elseif($item->status === 'rejected')
                                Ditolak
                            @else
                                Tidak diketahui
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>