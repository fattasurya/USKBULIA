<?php

namespace App\Http\Controllers;

use App\Models\dompet;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class DompetController extends Controller
{
    public function __construct()
    {

        $this->middleware('role:admin,bank')->only('allMutasi');
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

        Dompet::create([
            'user_id' => $user->id,
            'debit' => $request->credit,
            'credit' => 0,
            'description' => 'Withdraw Saldo',
            'status' => 'process',
        ]);

        return redirect()->back()->with('status', 'Withdraw berhasil');
    }

    public function bankTopupToSiswa(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:10000',
        ]);

        Dompet::create([
            'user_id' => $request->siswa_id,
            'credit' => $request->amount,
            'debit' => 0,
            'description' => 'Top-up oleh Bank',
            'status' => 'done'
        ]);

        return redirect()->back()->with('success', 'Top-up berhasil dilakukan ke siswa.');
    }

    public function bankWithdrawFromSiswa(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:10000',
        ]);

        $totalSaldo = Dompet::where('user_id', $request->siswa_id)
            ->where('status', 'done')
            ->sum(DB::raw('credit - debit'));

        if ($totalSaldo < $request->amount) {
            return redirect()->back()->with('error', 'Saldo siswa tidak mencukupi.');
        }

        Dompet::create([
            'user_id' => $request->siswa_id,
            'credit' => 0,
            'debit' => $request->amount,
            'description' => 'Withdraw oleh Bank',
            'status' => 'done'
        ]);

        return redirect()->back()->with('success', 'Withdraw berhasil dilakukan dari siswa.');
    }



    public function transfer(Request $request)
    {
        $request->validate([
            'recepient_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $sender = Auth::user();
        $recepient = User::find($request->recepient_id);


        $saldo = Dompet::where('user_id', $sender->id)
            ->where('status', 'done')
            ->sum(DB::raw('credit - debit'));

        if ($saldo < $request->amount) {
            return redirect()->back()->with('error', 'Saldo pengirim tidak mencukupi.');
        }


        Dompet::create([
            'user_id' => $sender->id,
            'credit' => 0,
            'debit' => $request->amount,
            'description' => 'Transfer ke ' . $recepient->name,
            'status' => 'done',
        ]);

        Dompet::create([
            'user_id' => $recepient->id,
            'credit' => $request->amount,
            'debit' => 0,
            'description' => 'Transfer dari ' . $sender->name,
            'status' => 'done',
        ]);

        return redirect()->back()->with('success', 'Transfer berhasil.');
    }




    public function acceptRequest(Request $request, $dompetId)
    {
        $dompet = Dompet::findOrFail($dompetId);
        $dompet->update(['status' => 'done']);

        return redirect()->back()->with('status', 'Permintaan Berhasil disetujui');
    }

    public function rejectRequest(Request $request, $dompetId)
    {

        $dompet = Dompet::findOrFail($dompetId);
        $dompet->status = 'rejected';
        $dompet->save(); 

        
        return redirect()->back()->with('status', 'Permintaan Ditolak');
    }


    public function allMutasi()
    {
        $mutasi = Dompet::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10); 

        return view('wallet.all', compact('mutasi'));
    }

    public function mutasi()
    {
        $user = Auth::user();
        $mutasi = Dompet::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); 

        return view('siswa.mutasi', compact('mutasi'));
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
            $query->where('status', 'rejected'); 
        }

       
        if ($filter === 'all' || !$filter) {
            
        }

        $mutasi = $query->orderBy('created_at', 'desc')->get();

        return view('wallet.all', compact('mutasi'));
    }


    public function exportPDF(Request $request, $userId = null)
    {
        $user = Auth::user();

        if ($user->role === 'siswa') {
            
            $mutasi = Dompet::with('user')->where('user_id', $user->id)->get();
        } else {
           
            $mutasi = Dompet::with('user')->get();
        }

        $pdf = Pdf::loadView('riwayat-transaksi-pdf', compact('mutasi'));
        return $pdf->download('riwayat_transaksi.pdf');
    }
}
