<?php

namespace App\Http\Controllers;

use App\Models\dompet;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DompetController extends Controller
{
    public function __construct()
    {
        // Middleware ini akan memeriksa role sebelum semua method dijalankan
        $this->middleware('role:admin,bank')->only('allMutasi'); // Ganti dengan role yang diizinkan
    }
    public function topup(Request $request)
    {
        $request->validate([
            'credit' => 'required|numeric|min:10000'
        ]);

        Dompet::create([
            'user_id' => Auth::id(),
            'debit' => 0,
            'credit' => $request->credit,
            'description' => 'Top-up Saldo',
            'status' => 'process'
        ]);

        return redirect()->back()->with('status', 'Permintaan Top-Up anda sedang diproses');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'credit' => 'required|numeric|min:10000'
        ]);

        $user = Auth::user();
        $totalSaldo = Dompet::where('user_id', $user->id)
            ->where('status', 'done')
            ->sum(DB::raw('credit - debit'));

        if ($totalSaldo < $request->credit) {
            return redirect()->back()->with('status', 'Saldo tidak mencukupi');
        }

        // Menambahkan transaksi withdraw langsung
        Dompet::create([
            'user_id' => $user->id,
            'debit' => $request->credit,
            'credit' => 0,
            'description' => 'Withdraw Saldo',
            'status' => 'done', // Status langsung 'done', tanpa persetujuan
        ]);

        return redirect()->back()->with('status', 'Withdraw berhasil');
    }


    public function transfer(Request $request)
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login

        // Validasi amount dan penerima
        $validated = $request->validate([
            'recepient_id' => 'required|exists:users,id', // Pastikan penerima ada di database
            'amount' => 'required|numeric|min:1', // Pastikan amount lebih dari 0
        ]);

        // Mendapatkan penerima
        $recepient = User::find($request->recepient_id);

        // Mengecek apakah pengirim memiliki saldo cukup
        $dompets = Dompet::where('user_id', $user->id)->where('status', 'done')->get();
        $credit = 0;
        $debit = 0;

        foreach ($dompets as $dompet) {
            $credit += $dompet->credit;
            $debit += $dompet->debit;
        }

        $saldoPengirim = $credit - $debit;

        if ($saldoPengirim < $request->amount) {
            return redirect()->back()->with('error', 'Saldo Anda tidak cukup untuk melakukan transfer.');
        }

        Dompet::create([
            'user_id' => $user->id,
            'credit' => 0,
            'debit' => $request->amount,
            'description' => 'Transfer ke ' . $recepient->name,
            'status' => 'done',
        ]);

        // Kredit ke penerima
        Dompet::create([
            'user_id' => $recepient->id,
            'credit' => $request->amount,
            'debit' => 0,
            'description' => 'Transfer dari ' . $user->name,
            'status' => 'done',
        ]);

        return redirect()->route('home')->with('success', 'Transfer berhasil.');
    }


    public function acceptRequest(Request $request, $dompetId)
    {
        $dompet = Dompet::findOrFail($dompetId);
        $dompet->update(['status' => 'done']);

        return redirect()->back()->with('status', 'Permintaan Berhasil disetujui');
    }

    public function rejectRequest(Request $request, $dompetId)
    {
        // Temukan wallet berdasarkan ID
        $dompet = Dompet::findOrFail($dompetId);

        // Update status menjadi 'rejected'
        $dompet->status = 'rejected';
        $dompet->save(); // Simpan perubahan status

        // Redirect atau tampilkan notifikasi bahwa transaksi ditolak
        return redirect()->back()->with('status', 'Permintaan Ditolak');
    }


    public function allMutasi()
    {
        $mutasi = Dompet::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('wallet.all', compact('mutasi'));
    }

    public function all(Request $request)
    {
        $filter = $request->input('filter');

        $query = Dompet::with('user');

        if ($filter === 'topup') {
            $query->where('description', 'Top-up');
        } elseif ($filter === 'withdraw') {
            $query->where('description', 'Withdraw');
        } elseif ($filter === 'transfer') {
            $query->where('description', 'Transfer');
        } elseif ($filter === 'rejected') {
            $query->where('status', 'rejected'); // Pastikan menambahkan filter untuk status 'rejected'
        }

        // Menampilkan semua transaksi jika tidak ada filter atau filter 'all'
        if ($filter === 'all' || !$filter) {
            // Tidak ada filter yang diterapkan, tampilkan semua transaksi
        }

        $mutasi = $query->orderBy('created_at', 'desc')->get();

        return view('wallet.all', compact('mutasi'));
    }
}
