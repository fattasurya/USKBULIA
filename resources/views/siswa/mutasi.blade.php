<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
       
        :root {
            --green-primary: #2e7d32;
            --green-light: #66bb6a;
            --green-dark: #1b5e20;
            --black: #212529;
            --white: #ffffff;
            --light-gray: #f8f9fa;
        }

        body {
            background-color: var(--light-gray);
            color: var(--black);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h4 {
            color: var(--green-dark);
            font-weight: 600;
            border-bottom: 2px solid var(--green-light);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background-color: var(--green-primary);
            color: var(--white);
        }

        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 500;
        }

        .table tbody tr:nth-child(odd) {
            background-color: var(--white);
        }

        .table tbody tr:nth-child(even) {
            background-color: var(--light-gray);
        }

        .table tbody td {
            padding: 12px 15px;
            border-color: #e9ecef;
        }

        .btn-back {
            background-color: var(--green-primary);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: var(--green-dark);
            color: var(--white);
        }

        .alert-no-transaction {
            background-color: rgba(46, 125, 50, 0.1);
            color: var(--green-dark);
            border-color: var(--green-light);
            border-radius: 8px;
            padding: 15px;
        }

        .credit-value {
            color: #dc3545;
        }

        .debit-value {
            color: #198754;
        }

    </style>
</head>

<body>
    <div class="container mt-5">
        <h4 class="mb-4">
            <i class="fas fa-history me-2"></i>
            Riwayat Transaksi Saya
        </h4>

        @if($mutasi->isEmpty())
            <div class="alert alert-no-transaction">
                <i class="fas fa-info-circle me-2"></i>
                Tidak ada transaksi.
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-calendar-alt me-2"></i>Tanggal</th>
                            <th><i class="fas fa-file-alt me-2"></i>Deskripsi</th>
                            <th><i class="fas fa-arrow-down me-2"></i>Tarik Tunai</th>
                            <th><i class="fas fa-arrow-up me-2"></i>Top-up</th>
                            <th><i class="fas fa-check-circle me-2"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mutasi as $item)
                            <tr>
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
        <a href="{{ route('export.pdf') }}" class="btn btn-back mt-3 me-2">
            <i class="fas fa-file-pdf me-1"></i> Download PDF
        </a>

        <a href="{{ route('home') }}" class="btn btn-back mt-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>
</body>
</html>