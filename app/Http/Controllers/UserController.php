<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('user.index', compact('users'));
    }


    /**
     * Menampilkan form tambah pengguna.
     */
    public function create()
    {
        return view('user.create');
    }


    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'role' => [
                'required',
                'in:admin,manager_gudang,staff_gudang',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ], [
            'name.required' =>
                'Nama wajib diisi.',

            'email.required' =>
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email sudah digunakan.',

            'password.required' =>
                'Password wajib diisi.',

            'password.min' =>
                'Password minimal 6 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',

            'role.required' =>
                'Role wajib dipilih.',

            'role.in' =>
                'Role tidak valid.',

            'status.required' =>
                'Status wajib dipilih.',
        ]);


        User::create([
            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'password' =>
                Hash::make(
                    $validated['password']
                ),

            'role' =>
                $validated['role'],

            'status' =>
                $validated['status'],
        ]);


        return redirect()
            ->route('pengguna.index')
            ->with(
                'success',
                'Pengguna berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan form edit pengguna.
     */
    public function edit(User $pengguna)
    {
        return view(
            'user.edit',
            compact('pengguna')
        );
    }


    /**
     * Memperbarui pengguna.
     */
    public function update(
        Request $request,
        User $pengguna
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $pengguna->id,
            ],

            'role' => [
                'required',
                'in:admin,manager_gudang,staff_gudang',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ], [
            'name.required' =>
                'Nama wajib diisi.',

            'email.required' =>
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email sudah digunakan.',

            'role.required' =>
                'Role wajib dipilih.',

            'role.in' =>
                'Role tidak valid.',

            'status.required' =>
                'Status wajib dipilih.',

            'password.min' =>
                'Password minimal 6 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA
        |--------------------------------------------------------------------------
        */

        $pengguna->name =
            $validated['name'];

        $pengguna->email =
            $validated['email'];

        $pengguna->role =
            $validated['role'];

        $pengguna->status =
            $validated['status'];


        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $validated['password']
            )
        ) {
            $pengguna->password =
                Hash::make(
                    $validated['password']
                );
        }


        $pengguna->save();


        return redirect()
            ->route('pengguna.index')
            ->with(
                'success',
                'Pengguna berhasil diperbarui.'
            );
    }


    /**
     * Menghapus pengguna.
     */
    public function destroy(User $pengguna)
    {
        /*
        |--------------------------------------------------------------------------
        | TIDAK BOLEH MENGHAPUS AKUN SENDIRI
        |--------------------------------------------------------------------------
        */

        if (
            auth()->check() &&
            auth()->id() === $pengguna->id
        ) {
            return back()
                ->with(
                    'error',
                    'Anda tidak dapat menghapus akun sendiri.'
                );
        }


        $pengguna->delete();


        return redirect()
            ->route('pengguna.index')
            ->with(
                'success',
                'Pengguna berhasil dihapus.'
            );
    }
}