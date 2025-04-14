<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Financial Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
    background-color: #f4f8f4;
    font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #2c3e2e;
    line-height: 1.6;
}

.navbar {
    background-color: #1a3a1a;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 12px 0;
}

.navbar-brand {
    font-weight: 700;
    color: #ffffff;
    letter-spacing: 0.5px;
}

.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 25px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #f0f5f0;
    font-weight: 600;
    padding: 13px 20px;
    border-bottom:2px solid #e3ebe3;
    color: #1a3a1a;
}

.stat-card {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    border-left: 4px solid #2e7d32;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #1a3a1a;
    margin-bottom: 5px;
}

.stat-title {
    color: #5c8d60;
    font-size: 15px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.balance-card {
    background: linear-gradient(135deg, #2e7d32, #81c784);
    color: white;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 8px 20px rgba(46, 125, 50, 0.2);
}

.balance-value {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.credit {
    color: #e8f5e9;
    font-weight: 600;
    background-color: rgba(0, 150, 0, 0.2);
    padding: 5px 10px;
    border-radius: 20px;
    display: inline-block;
}

.debit {
    color: #ffebee;
    font-weight: 600;
    background-color: rgba(150, 0, 0, 0.2);
    padding: 5px 10px;
    border-radius: 20px;
    display: inline-block;
}

/* Adding more classic/modern elements */
.section-title {
    font-size: 22px;
    font-weight: 600;
    color: #1a3a1a;
    padding-bottom: 10px;
    border-bottom: 2px solid #81c784;
    margin-bottom: 20px;
}

.btn-primary {
    background-color: #2e7d32;
    border-color: #2e7d32;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #1b5e20;
    border-color: #1b5e20;
    box-shadow: 0 5px 15px rgba(27, 94, 32, 0.3);
}

table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

thead th {
    background-color: #2e7d32;
    color: white;
    font-weight: 600;
    padding: 15px;
}

tbody tr:nth-child(even) {
    background-color: #f0f5f0;
}

tbody tr:hover {
    background-color: #e8f5e9;
}

tbody td {
    padding: 12px 15px;
    border-top: 1px solid #e3ebe3;
}
    </style>
</head>
<body>
    <!-- Simple Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">PayFlow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="text-light me-3">{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Admin Dashboard -->
        @if(Auth::user()->role == 'admin')
        <h3 class="mb-4">Admin Dashboard</h3>
        
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value">{{ $users->count() }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-title">Students</div>
                    <div class="stat-value">{{ $users->where('role', 'siswa')->count() }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-title">Transactions</div>
                    <div class="stat-value">{{ $mutasi->count() }}</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Latest Transactions</div>
                    <div class="card-body">
                        @if($mutasi->isEmpty())
                            <p class="text-muted">No transactions found.</p>
                        @else
                            <div class="list-group">
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
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>User Management</span>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fas fa-plus"></i> Add User
                        </button>
                    </div>
                    <div class="card-body">
                        @if($users->isEmpty())
                            <p class="text-muted">No users found.</p>
                        @else
                            <div class="list-group">
                                @foreach($users->take(5) as $user)
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
        </div>
        @endif

        <!-- Student Dashboard -->
        @if(Auth::user()->role == 'siswa')
        <h3 class="mb-4">Student Dashboard</h3>
        
        <div class="row">
            <div class="col-md-6">
                <div class="balance-card">
                    <h5>Your Balance</h5>
                    <div class="balance-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-title">Total Spent</div>
                    <div class="stat-value debit">Rp {{ number_format($mutasi->sum('debit'), 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-title">Total Received</div>
                    <div class="stat-value credit">Rp {{ number_format($mutasi->sum('credit'), 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Top-up Balance</div>
                    <div class="card-body">
                        <form action="{{ route('topUp') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="credit" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Top-up</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Withdraw Balance</div>
                    <div class="card-body">
                        <form action="{{ route('withdraw') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="credit" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Withdraw</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Transfer Balance</div>
                    <div class="card-body">
                        <form action="{{ route('transfer') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Recipient</label>
                                <select name="recepient_id" class="form-select" required>
                                    @foreach($users->where('role', 'siswa') as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="amount" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Transfer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Transaction History</span>
                <div class="dropdown">
                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                        Filter
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('home', ['filter' => 'all']) }}">All</a></li>
                        <li><a class="dropdown-item" href="{{ route('home', ['filter' => 'topup']) }}">Top-up</a></li>
                        <li><a class="dropdown-item" href="{{ route('home', ['filter' => 'withdraw']) }}">Withdraw</a></li>
                        <li><a class="dropdown-item" href="{{ route('home', ['filter' => 'transfer']) }}">Transfer</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                @if($mutasi->isEmpty())
                    <p class="text-muted">No transactions yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mutasi as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->debit > 0 ? 'Rp ' . number_format($item->debit, 0, ',', '.') : '-' }}</td>
                                        <td>{{ $item->credit > 0 ? 'Rp ' . number_format($item->credit, 0, ',', '.') : '-' }}</td>
                                        <td>
                                            @if($item->status === 'done')
                                                <span class="badge bg-success">Done</span>
                                            @elseif($item->status === 'process')
                                                <span class="badge bg-warning text-dark">Processing</span>
                                            @elseif($item->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Bank Dashboard -->
        @if(Auth::user()->role == 'bank')
        <h3 class="mb-4">Bank Dashboard</h3>
        
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-title">Pending Requests</div>
                    <div class="stat-value">{{ isset($request_payment) ? count($request_payment) : 0 }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-title">Active Students</div>
                    <div class="stat-value">{{ $users->where('role', 'siswa')->count() }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-title">Total Transactions</div>
                    <div class="stat-value">{{ $mutasi->count() }}</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Payment Requests</div>
                    <div class="card-body">
                        @if(empty($request_payment) || count($request_payment) == 0)
                            <div class="text-center py-3">
                                <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                                <p>No pending requests</p>
                            </div>
                        @else
                            <div class="list-group">
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
                                                <button type="submit" class="btn btn-sm btn-primary">Accept</button>
                                            </form>
                                            <form action="{{ route('reject', $dompet->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Transaction History</span>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                                Filter
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="?filter=all">All</a></li>
                                <li><a class="dropdown-item" href="?filter=topup">Top-up</a></li>
                                <li><a class="dropdown-item" href="?filter=withdraw">Withdraw</a></li>
                                <li><a class="dropdown-item" href="?filter=transfer">Transfer</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
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
            </div>
        </div>
        @endif
    </div>

    <!-- Add User Modal -->
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

    <!-- Edit User Modals -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>