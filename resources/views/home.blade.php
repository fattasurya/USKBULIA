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

        :root {
            --primary: #007bff;
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --light: #f5f7fa;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        body {
            background: var(--light);
            font-family: 'Roboto', sans-serif;
            color: #333;
            min-height: 100vh;
            margin: 0;
        }

        .navbar {
            background: #fff;
            box-shadow: var(--shadow);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.4rem;
        }

        .container-main {
            max-width: 1200px;
            margin: 20px auto;
            padding: 15px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .panel {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: var(--shadow);
            transition: box-shadow 0.3s;
        }

        .panel:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .panel-header {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 8px;
        }

        .stat-panel {
            background: var(--primary);
            color: #fff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .stat-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .balance-panel {
            background: linear-gradient(135deg, #001276, #69a9da);
            color: #fff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
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

        .credit { background: #e6ffed; color: var(--success); }
        .debit { background: #ffe6e6; color: var(--danger); }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .btn-primary { background: var(--primary); border: none; }
        .btn-primary:hover { background: #0056b3; }
        .btn-danger { background: var(--danger); border: none; }
        .btn-danger:hover { background: #b02a37; }
        .btn-warning { background: var(--warning); border: none; color: #333; }
        .btn-warning:hover { background: #e0a800; }
        .btn-info { background: var(--info); border: none; color: #fff; }
        .btn-info:hover { background: #138496; }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
        }

        thead th {
            background: var(--primary);
            color: #fff;
            padding: 10px;
        }

        tbody tr:hover { background: #f8f9fa; }
        tbody td { padding: 10px; }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .modal-content {
            border-radius: 8px;
        }

        .badge.bg-success { background: var(--success) !important; color: #fff; }
        .badge.bg-warning { background: var(--warning) !important; color: #333; }
        .badge.bg-danger { background: var(--danger) !important; color: #fff; }

        .scrollable {
            max-height: 250px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--primary) #e9ecef;
        }

        .scrollable::-webkit-scrollbar {
            width: 6px;
        }

        .scrollable::-webkit-scrollbar-track { background: #e9ecef; }
        .scrollable::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 3px; }

        .bank-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons .btn {
            padding: 4px 8px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">PayFlow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto"></ul>
                <div class="d-flex align-items-center">
                    <span class="me-3">{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-main">
       
        @if (session('status') || session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') ?? session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Admin -->
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
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
                <div class="scrollable">
                    @if($users->isEmpty())
                        <p class="text-muted">Tidak Ada Pengguna.</p>
                    @else
                        <div class="list-group">
                            @foreach($users as $user)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div>{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }} | {{ ucfirst($user->role) }}</small>
                                    </div>
                                    <div class="action-buttons">
                                        @if($user->role === 'siswa')
                                            <a href="{{ route('export.pdf', $user->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
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

        <!-- Student -->
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
                <div id="recipient-info" class="mb-3 text-muted text-sm">Masukkan ID Penerima.</div>
                <form action="{{ route('transfer') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Penerima</label>
                        <input type="number" id="recipient-id" name="recepient_id" class="form-control" required>
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
                                    <td>{{ $item->debit > 0 ? 'Rp ' . number_format($item->debit, 0, ',', '.') : '-' }}</td>
                                    <td>{{ $item->credit > 0 ? 'Rp ' . number_format($item->credit, 0, ',', '.') : '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status === 'done' ? 'success' : ($item->status === 'process' ? 'warning text-dark' : ($item->status === 'rejected' ? 'danger' : 'secondary')) }}">
                                            {{ $item->status === 'done' ? 'Selesai' : ($item->status === 'process' ? 'Diproses' : ($item->status === 'rejected' ? 'Ditolak' : 'Tidak diketahui')) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @endif

        <!-- Bank -->
        @if(Auth::user()->role == 'bank')
        <h3 class="section-title">Bank Dashboard</h3>
        <div class="bank-grid">
            <div class="panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <span>Manajemen Pengguna</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus"></i> Tambah
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
                                    <div class="action-buttons">
                                        <a href="{{ route('export.pdf', $user->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-download"></i>
                                        </a>
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
            <div class="panel">
                <div class="panel-header">Transaksi Siswa</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="panel-header">Top-up</div>
                        <div id="topup-user-info" class="mb-3 text-muted text-sm"></div>
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
                        <div class="panel-header">Withdraw</div>
                        <div id="withdraw-user-info" class="mb-3 text-muted text-sm"></div>
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
            <div class="panel">
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
            <div class="panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <span>Mutasi</span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">Filter</button>
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

        <!-- Modals -->
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
            function fetchUserInfo(id, target) {
            const div = document.getElementById(target);
            if (!div) return;
            div.innerHTML = id ? `<span class="text-muted">Memuat...</span>` : `<span class="text-muted">Masukkan ID.</span>`;
            if (id) fetch(`/get-user-info/${id}`)
                .then(res => res.json())
                .then(data => div.innerHTML = data.exists
                    ? `<div class="alert alert-info p-2"><strong>Nama:</strong> ${data.name}<br><strong>Role:</strong> ${data.role}</div>`
                    : `<div class="text-danger">User tidak ditemukan.</div>`)
                .catch(() => div.innerHTML = `<div class="text-danger">Kesalahan saat mengambil data.</div>`);
        }

        Object.entries({
            'recipient-id': 'recipient-info',
            'topup-siswa-id': 'topup-user-info',
            'withdraw-siswa-id': 'withdraw-user-info'
        }).forEach(([inputId, targetId]) => {
            const el = document.getElementById(inputId);
            el?.addEventListener('input', () => fetchUserInfo(el.value, targetId));
        });
    </script>
</body>
</html>