<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            background: #f5f7fa;
            font-family: 'Roboto', sans-serif;
            color: #333;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            color: #007bff;
            font-size: 1.4rem;
        }

        .navbar .btn-outline-light {
            border-color: #007bff;
            color: #007bff;
        }

        .navbar .btn-outline-light:hover {
            background: #007bff;
            color: #fff;
        }

        .container-main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 15px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 15px;
        }

        .panel {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }

        .panel:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .panel-header {
            font-size: 1.1rem;
            font-weight: 500;
            color: #007bff;
            margin-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 8px;
        }

        .stat-panel {
            background: #007bff;
            color: #fff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .balance-panel {
            background: #28a745;
            color: #fff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .balance-value {
            font-size: 2rem;
            font-weight: 700;
        }

        .credit, .debit {
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 12px;
            display: inline-block;
        }

        .credit {
            background: #e6ffed;
            color: #28a745;
        }

        .debit {
            background: #ffe6e6;
            color: #dc3545;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: #007bff;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-danger {
            background: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background: #b02a37;
        }

        .btn-warning {
            background: #ffc107;
            border: none;
            color: #333;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        thead th {
            background: #007bff;
            color: #fff;
            font-weight: 500;
            padding: 10px;
        }

        tbody tr {
            border-bottom: 1px solid #e9ecef;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        tbody td {
            padding: 10px;
            color: #333;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
            background: #fff;
            color: #333;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .modal-content {
            background: #fff;
            border-radius: 8px;
            color: #333;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
        }

        .modal-title {
            color: #007bff;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
        }

        .list-group-item {
            background: transparent;
            border: none;
            border-bottom: 1px solid #e9ecef;
            color: #333;
        }

        .badge {
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 10px;
        }

        .badge.bg-success {
            background: #28a745 !important;
            color: #fff;
        }

        .badge.bg-warning {
            background: #ffc107 !important;
            color: #333;
        }

        .badge.bg-danger {
            background: #dc3545 !important;
            color: #fff;
        }

        .alert-info {
            background: #e7f1ff;
            border: none;
            color: #333;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .scrollable {
            max-height: 250px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #007bff #e9ecef;
        }

        .scrollable::-webkit-scrollbar {
            width: 6px;
        }

        .scrollable::-webkit-scrollbar-track {
            background: #e9ecef;
        }

        .scrollable::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 3px;
        }

        /* Bank Dashboard Specific */
        .bank-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .bank-panel {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .bank-panel .panel-header {
            font-size: 1.1rem;
            font-weight: 500;
            color: #007bff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">PayFlow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto"></ul>
                <div class="d-flex align-items-center">
                    <span class="text-dark me-3">{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-main">
        <!-- Admin Dashboard -->
        @if(Auth::user()->role == 'admin')
        <h3 class="section-title">Admin Dashboard</h3>
        <div class="dashboard-grid">
            <div class="stat-panel">
                <div class="stat-title">Total Pengguna</div>
                <div class="stat-value">{{ $users->count() }}</div>
            </div>
            <div class="stat-panel">
                <div class="stat-title">Siswa</div>
                <div class="stat-value">{{ $users->where('role', 'siswa')->count() }}</div>
            </div>
            <div class="stat-panel">
                <div class="stat-title">Total Transaksi</div>
                <div class="stat-value">{{ $mutasi->count() }}</div>
            </div>
        </div>
        <div class="dashboard-grid mt-4">
            <div class="panel">
                <div class="panel-header">Transaksi Terakhir</div>
                @if($mutasi->isEmpty())
                    <p class="text-muted">Tidak Ada Transaksi.</p>
                @else
                    <div class="list-group scrollable">
                        @foreach($mutasi->take(5) as $mutation)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div>{{ $mutation->description }}</div>
                                    <small class="text-muted">{{ $mutation->created_at->format('d M Y, H:i') }}</small>
                                </div>
                                <span class="{{ $mutation->credit > 0 ? 'credit' : 'debit' }}">
                                    {{ $mutation->credit > 0 ? '+' : '-' }} Rp {{ number_format($mutation->credit > 0 ? $mutation->credit : $mutation->debit, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('mutasi.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                    </div>
                @endif
            </div>
            <div class="panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <span>Manajemen Pengguna</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus"></i> Tambah Pengguna
                    </button>
                </div>
                <div class="scrollable">
                    @if($users->isEmpty())
                        <p class="text-muted">Tidak Ada Pengguna.</p>
                    @else
                        <div class="list-group">
                            @foreach($users->take(10000) as $user)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div>{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }} | {{ ucfirst($user->role) }}</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('delete-user', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Student Dashboard -->
        @if(Auth::user()->role == 'siswa')
        <h3 class="section-title">Siswa Dashboard</h3>
        <div class="dashboard-grid">
            <div class="balance-panel">
                <h5>Saldo</h5>
                <div class="balance-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
            </div>
            <div class="panel">
                <div class="panel-header">Top-up</div>
                <form action="{{ route('topUp') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="credit" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Top-up</button>
                </form>
            </div>
            <div class="panel">
                <div class="panel-header">Tarik Tunai</div>
                <form action="{{ route('withdraw') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="credit" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Tarik Tunai</button>
                </form>
            </div>
            <div class="panel">
                <div class="panel-header">Transfer</div>
                <div id="recipient-info" class="mb-3 text-sm text-muted">Masukkan ID Penerima untuk melihat info.</div>
                <form action="{{ route('transfer') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Penerima</label>
                        <input type="number" id="recipient-id" name="recepient_id" class="form-control" placeholder="Masukkan ID Penerima" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Transfer</button>
                </form>
            </div>
        </div>
        <div class="panel mt-4">
            <div class="panel-header d-flex justify-content-between align-items-center">
                <span>Riwayat Transaksi</span>
                <a href="{{ route('siswa.mutasi') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            @if($mutasi->isEmpty())
                <p class="text-muted">Tidak ada transaksi.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Tarik Tunai</th>
                                <th>Top-up</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mutasi->take(5) as $item)
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
            @endif
        </div>
        @endif

        <!-- Bank Dashboard -->
        @if(Auth::user()->role == 'bank')
        <h3 class="section-title">Bank Dashboard</h3>
        <div class="bank-grid">
            <div class="bank-panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <span>Manajemen Pengguna</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </button>
                </div>
                <div class="scrollable">
                    @if($users->where('role', 'siswa')->isEmpty())
                        <p class="text-muted">Belum ada user.</p>
                    @else
                        <div class="list-group">
                            @foreach($users->where('role', 'siswa') as $user)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div>{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }} | {{ ucfirst($user->role) }}</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('delete-user', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="bank-panel">
                <div class="panel-header">Transaksi Siswa</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="panel-header">Top-up ke Siswa</div>
                        <div id="topup-user-info" class="mb-3 text-sm text-muted"></div>
                        <form action="{{ route('bank.topup') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">ID Siswa</label>
                                <input type="number" name="siswa_id" id="topup-siswa-id" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nominal</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="amount" class="form-control" required min="10000">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Top-up</button>
                        </form>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="panel-header">Withdraw untuk Siswa</div>
                        <div id="withdraw-user-info" class="mb-3 text-sm text-muted"></div>
                        <form action="{{ route('bank.withdraw') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">ID Siswa</label>
                                <input type="number" name="siswa_id" id="withdraw-siswa-id" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nominal</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="amount" class="form-control" required min="10000">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Withdraw</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="bank-grid mt-4">
            <div class="bank-panel">
                <div class="panel-header">Permintaan</div>
                @if(empty($request_payment) || count($request_payment) == 0)
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle fa-2x text-muted mb-2"></i>
                        <p>No pending requests</p>
                    </div>
                @else
                    <div class="list-group scrollable">
                        @foreach($request_payment as $dompet)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div>{{ $dompet->description }}</div>
                                        <small class="text-muted">{{ $dompet->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                    <div class="fw-bold">
                                        Rp {{ number_format($dompet->credit - $dompet->debit, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <form action="{{ route('approve', $dompet->id) }}" method="POST" class="me-2">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Terima</button>
                                    </form>
                                    <form action="{{ route('reject', $dompet->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="bank-panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <span>Mutasi</span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                            Filter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="?filter=all">All</a></li>
                            <li><a class="dropdown-item" href="?filter=topup">Top-up</a></li>
                            <li><a class="dropdown-item" href="?filter=withdraw">Tarik Tunai</a></li>
                            <li><a class="dropdown-item" href="?filter=transfer">Transfer</a></li>
                        </ul>
                    </div>
                </div>
                @if($mutasi->isEmpty())
                    <p class="text-muted">No transactions found.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mutasi->take(5) as $item)
                                    <tr>
                                        <td>{{ $item->user->name ?? 'Unknown' }}</td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td class="{{ $item->credit > 0 ? 'credit' : 'debit' }}">
                                            {{ $item->credit > 0 ? '+' : '-' }} Rp {{ number_format($item->credit > 0 ? $item->credit : $item->debit, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('mutasi.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Modals for Admin -->
        @if(Auth::user()->role == 'admin')
        <div class="modal fade" id="addUserModal" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('add-user') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="siswa">Siswa</option>
                                    <option value="admin">Admin</option>
                                    <option value="bank">Bank</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- Modals for Bank -->
        @if(Auth::user()->role == 'bank')
        <div class="modal fade" id="addUserModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <input type="hidden" name="role" value="siswa">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @foreach($users->where('role', 'siswa') as $user)
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('update-user', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password (kosongkan jika tidak diganti)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                                <input type="hidden" name="role" value="siswa">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        @endif

        <!-- Edit User Modal for Admin -->
        @if(Auth::user()->role == 'admin')
        @foreach($users as $user)
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('update-user', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password (optional)</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function fetchUserInfo(id, target) {
            if (id) {
                fetch(`/get-user-info/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const targetDiv = document.getElementById(target);
                        if (data.exists) {
                            targetDiv.innerHTML = `
                                <div class="alert alert-info p-2">
                                    <strong>Nama:</strong> ${data.name}<br>
                                    <strong>Role:</strong> ${data.role}
                                </div>`;
                        } else {
                            targetDiv.innerHTML = `<div class="text-danger">User tidak ditemukan.</div>`;
                        }
                    });
            } else {
                document.getElementById(target).innerHTML = `<span class="text-muted">Masukkan ID untuk melihat info.</span>`;
            }
        }

        document.getElementById('recipient-id')?.addEventListener('input', function () {
            fetchUserInfo(this.value, 'recipient-info');
        });

        document.getElementById('topup-siswa-id')?.addEventListener('input', function () {
            fetchUserInfo(this.value, 'topup-user-info');
        });

        document.getElementById('withdraw-siswa-id')?.addEventListener('input', function () {
            fetchUserInfo(this.value, 'withdraw-user-info');
        });
    </script>
</body>
</html>