<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // Tampilkan semua user
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Requested Role Filter
        if ($request->has('role') && in_array($request->role, ['seller', 'buyer'])) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    // Tampilkan pending sellers untuk verifikasi
    public function sellers(Request $request)
    {
        // DATA STATISTIK GLOBAL
        $totalSellers = User::where('role', 'seller')->count();
        $approvedSellers = User::where('role', 'seller')->where('seller_status', 'approved')->count();
        $pendingSellers = User::where('role', 'seller')->where('seller_status', 'pending')->count();
        $rejectedSellers = User::where('role', 'seller')->where('seller_status', 'rejected')->count();

        $query = User::where('role', 'seller');

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhereHas('store', function($qStore) use ($search) {
                    $qStore->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        // Filter berdasarkan status seller
        if ($request->has('status')) {
            if ($request->status == 'pending') {
                $query->where('seller_status', 'pending');
            } elseif ($request->status == 'approved') {
                $query->where('seller_status', 'approved');
            } elseif ($request->status == 'rejected') {
                $query->where('seller_status', 'rejected');
            }
        }

        // Ambil data untuk tabel (Paginated)
        $sellers = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.sellers', compact('sellers', 'totalSellers', 'approvedSellers', 'pendingSellers', 'rejectedSellers'));
    }


    // Approve seller
    public function approveSeller(User $user)
    {
        if ($user->role === 'seller' && $user->seller_status === 'pending') {
            $user->update(['seller_status' => 'approved']);

            return redirect()->back()->with('success', 'Seller berhasil di-approve!');
        }

        return redirect()->back()->with('error', 'Tidak dapat approve seller ini.');
    }

    // Reject seller
    public function rejectSeller(User $user)
    {
        if ($user->role === 'seller' && $user->seller_status === 'pending') {
            $user->update(['seller_status' => 'rejected']);

            return redirect()->back()->with('success', 'Seller berhasil di-reject!');
        }

        return redirect()->back()->with('error', 'Tidak dapat reject seller ini.');
    }

    // Form edit user
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'seller_status' => ['nullable', 'in:approved,pending,rejected'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'seller_status' => $request->seller_status,
        ]);

        return redirect()->back()->with('success', 'User berhasil diupdate!');
    }

    // Delete user
    public function destroy(User $user)
    {
        // Tidak bisa delete diri sendiri
        if ($user->id === Auth::user()->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}