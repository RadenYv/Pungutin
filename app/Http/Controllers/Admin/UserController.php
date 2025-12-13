<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::when($search, function ($query, $search) {
        $query->where('nama', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('id_user', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        
        return view('Admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('Admin.users.create');
    }

    // show() removed per requirements

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'nullable|string|max:20',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'saldo_total' => 0,
            'poin_total' => 0,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User Ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('Admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'saldo_total' => $request->saldo_total,
            'poin_total' => $request->poin_total,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
