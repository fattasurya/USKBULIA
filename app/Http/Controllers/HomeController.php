<?php

namespace App\Http\Controllers;

use App\Models\dompet;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter');

        $filterMutasi = function ($query) use ($filter) {
            if ($filter == 'topup') {
                $query->where('description', 'like', '%Top-up%');
            } elseif ($filter == 'withdraw') {
                $query->where('description', 'like', '%Withdraw%');
            } elseif ($filter == 'transfer') {
                $query->where('description', 'like', '%Transfer%');
            }

            // Filter berdasarkan status
            if ($filter == 'done') {
                $query->where('status', 'done');
            } elseif ($filter == 'process') {
                $query->where('status', 'process');
            } elseif ($filter == 'rejected') {
                $query->where('status', 'reject');
            }

            return $query;
        };


        // Admin Section
        if ($user->role == 'admin') {
            $users = User::all();

            $mutasiQuery = Dompet::where('status', 'done');
            $mutasi = $filterMutasi($mutasiQuery)->orderBy('created_at', 'desc')->get();

            return view('home', compact('users', 'mutasi'));
        }

        // Bank Section
        if ($user->role == 'bank') {
            $dompet = Dompet::where('status', 'done')->get();
            $credit = $dompet->sum('credit');
            $debit  = $dompet->sum('debit');
            $saldo = $credit - $debit;

            $users = User::where('role', 'siswa')->get();
            $request_payment = Dompet::where('status', 'process')->orderBy('created_at', 'DESC')->get();

            $mutasiQuery = Dompet::where('status', 'done');
            $mutasi = $filterMutasi($mutasiQuery)->orderBy('created_at', 'DESC')->get();

            $allMutasi = Dompet::where('status', 'done')->count();

            return view('home', compact('saldo', 'users', 'request_payment', 'mutasi', 'allMutasi'));
        }

        // Siswa Section
        if ($user->role == 'siswa') {
            // Mengambil saldo untuk siswa
            $dompets = Dompet::where('user_id', $user->id)->where('status', 'done')->get();
            $credit = $dompets->sum('credit');
            $debit  = $dompets->sum('debit');
            $saldo = $credit - $debit;

            // Query mutasi untuk siswa dengan filter yang sesuai
            $mutasiQuery = Dompet::where('user_id', $user->id)->whereIn('status', ['done', 'process', 'rejected']);
            $mutasi = $filterMutasi($mutasiQuery)->orderBy('created_at', 'desc')->get();


            // Mengambil data siswa lain (bukan yang sedang login)
            $users = User::where('role', 'siswa')->where('id', '!=', $user->id)->get();

            // Mengirimkan data ke view
            return view('home', compact('saldo', 'mutasi', 'users'));
        }


        return redirect()->route('home');
    }
}
