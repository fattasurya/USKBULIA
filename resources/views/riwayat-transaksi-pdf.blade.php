<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e7f1ff, #f5f7fa);
            color: #333;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #0056b3;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 0.5rem;
            animation: fadeIn 0.5s ease-out;
        }

        .table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 0.5s ease-out;
        }

        .table-container:hover {
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        thead {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: #fff;
        }

        th {
            padding: 15px;
            font-weight: 500;
            font-size: 0.95rem;
            text-align: left;
            border: none;
        }

        tbody tr {
            transition: background 0.3s, transform 0.2s;
        }

        tbody tr:nth-child(odd) {
            background-color: #fafafa;
        }

        tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        tbody tr:hover {
            background-color: #e7f1ff;
            transform: translateY(-1px);
        }

        td {
            padding: 15px;
            font-size: 0.9rem;
            font-weight: 400;
            color: #333;
            border: none;
            border-bottom: 1px solid #dfe6e9;
        }

        .debit-value {
            color: #dc3545;
            font-weight: 500;
        }

        .credit-value {
            color: #28a745;
            font-weight: 500;
        }

        .status-done {
            color: #28a745;
            font-weight: 500;
        }

        .status-process {
            color: #ffc107;
            font-weight: 500;
        }

        .status-rejected {
            color: #dc3545;
            font-weight: 500;
        }

        .status-unknown {
            color: #6c757d;
            font-weight: 500;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .table-container {
                box-shadow: none;
                margin: 0;
                max-width: none;
            }
            .table-container:hover {
                transform: none;
                box-shadow: none;
            }
            h1 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            th, td {
                padding: 8px;
                font-size: 0.8rem;
            }
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
                @if($mutasi->isEmpty())
                    <tr>
                        <td colspan="6" style="text-align: center; color: #6c757d; font-weight: 400;">
                            Tidak ada transaksi.
                        </td>
                    </tr>
                @else
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
                            <td class="{{ 'status-' . ($item->status ?? 'unknown') }}">
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
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>