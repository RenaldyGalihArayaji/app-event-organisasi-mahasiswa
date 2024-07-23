<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('organization')->latest()->get();
        return view('master.user.index', ['title' => 'User'], compact('users'));
    }

    public function create()
    {
        $role = Role::all();
        $organization = Organization::where('name', '!=', 'super admin')->get();
        return view('master.user.create', ['title' => 'User'], compact('role', 'organization'));
    }
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
            'organization_id' => 'nullable|exists:organizations,id',
        ], [
            'name.required' => 'Nama harus diisi!',
            'name.min' => 'Nama minimal 3 karakter!',
            'name.max' => 'Nama maksimal 100 karakter!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email salah!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 8 karakter!',
            'role.required' => 'Role wajib dipilih!',
            'organization_id.exists' => 'Organisasi tidak valid!',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            $user = User::create([
                'name' => strtolower($request->name),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'organization_id' => $request->organization_id
            ]);

            $user->syncRoles($request->role);

            Alert::success('Sukses', 'Data Berhasil ditambah!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil ditambah!'
            ]);
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray(); // Ambil ID role dari pengguna
        $organizations = Organization::where('id', '!=', $user->organization_id)
            ->where('name', '!=', 'super admin')
            ->get(['id', 'name']);
        return view('master.user.edit', ['title' => 'Edit User'], compact('roles', 'user', 'userRoles', 'organizations'));
    }
    public function update(Request $request, User $user)
    {
        $validasi = Validator::make($request->all(), [
            'name'          => 'required|min:3|max:100',
            'email'         => 'required|email:rfc,dns',
            'role'          => 'required',
            'organization_id' => 'required|exists:organizations,id',
            // 'password'      => 'nullable|min:6'
        ], [
            'name.required'         => 'Nama harus diisi!',
            'name.min'              => 'Nama minimal 3 karakter!',
            'name.max'              => 'Nama maksimal 100 karakter!',
            'email.required'        => 'Email wajib diisi!',
            'email.email'           => 'Format email salah!',
            'role.required'         => 'Role wajib dipilih!',
            'organization_id.required' => 'Organisasi wajib dipilih!',
            // 'password.min'          => 'Password minimal 6 karakter!'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            $user->update([
                'name' => strtolower($request->name),
                'email' => strtolower($request->email),
                'organization_id' => $request->organization_id,
            ]);

            // if (!empty($request->password)) {
            //     $data['password'] = Hash::make($request->password);
            // }

            // $user->update($data);
            $user->syncRoles($request->role);

            Alert::success('Sukses', 'Data Berhasil diupdate!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diupdate!'
            ]);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }
}
