<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e7f1ff, #f5f7fa);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
            padding: 2rem;
        }

        .container {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            width: 100%;
            max-width: 1200px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 0.5s ease-out;
        }

        .container:hover {
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h4 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0056b3;
            letter-spacing: 0.5px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            background-color: #fff;
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: #fff;
        }

        .table thead th {
            padding: 15px;
            font-weight: 500;
            font-size: 0.95rem;
            border: none;
            text-align: left;
        }

        .table tbody tr {
            transition: background 0.3s, transform 0.2s;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #fafafa;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .table tbody tr:hover {
            background-color: #e7f1ff;
            transform: translateY(-1px);
        }

        .table tbody td {
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

        .badge {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .btn-back {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            background: linear-gradient(to right, #007bff, #0056b3);
            color: #fff;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
            margin-right: 10px;
        }

        .btn-back:hover {
            background: linear-gradient(to right, #0056b3, #003d80);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .btn-back:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
        }

        .alert-no-transaction {
            background: #e7f1ff;
            color: #0056b3;
            border: 1px solid #dfe6e9;
            border-radius: 8px;
            padding: 15px;
            font-size: 0.9rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .page-link {
            border-radius: 6px;
            margin: 0 3px;
            font-size: 0.9rem;
            color: #007bff;
            transition: background 0.3s, color 0.3s;
        }

        .page-link:hover {
            background: #e7f1ff;
            color: #0056b3;
        }

        .page-item.active .page-link {
            background: #007bff;
            border-color: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h4>
            <i class="fas fa-history"></i>
            Semua Riwayat Transaksi
        </h4>

        @if($mutasi->isEmpty())
            <div class="alert alert-no-transaction">
                <i class="fas fa-info-circle"></i>
                Tidak ada transaksi.
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user me-2"></i>User</th>
                            <th><i class="fas fa-calendar-alt me-2"></i>Tanggal</th>
                            <th><i class="fas fa-file-alt me-2"></i>Deskripsi</th>
                            <th><i class="fas fa-arrow-down me-2"></i>Keluar</th>
                            <th><i class="fas fa-arrow-up me-2"></i>Masuk</th>
                            <th><i class="fas fa-check-circle me-2"></i>Status</th>
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
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($item->status === 'process')
                                        <span class="badge bg-warning text-dark">Diproses</span>
                                    @elseif($item->status === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak diketahui</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $mutasi->links('pagination::bootstrap-5') }}
            </div>
        @endif
        <div class="d-flex justify-content-start mt-4">
            <a href="{{ route('export.pdf') }}" class="btn btn-back">
                <i class="fas fa-file-pdf me-1"></i> Download PDF
            </a>
            <a href="{{ route('home') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>

</html>