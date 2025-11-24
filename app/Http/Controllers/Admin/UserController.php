<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // Tampilkan semua user
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Tampilkan pending sellers untuk verifikasi
    public function pendingSellers()
    {
        $pendingSellers = User::where('role', 'seller')
            ->where('seller_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.pending-sellers', compact('pendingSellers'));
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
            'role' => ['required', 'in:admin,seller,buyer'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate!');
    }

    // Delete user
    public function destroy(User $user)
    {
        // Tidak bisa delete diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}