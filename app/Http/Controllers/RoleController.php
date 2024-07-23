<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::latest()->get();

        // Memisahkan super admin dari roles lainnya
        $partitioned = $roles->partition(function ($role) {
            return $role->name === 'super admin';
        });

        // Menggabungkan kembali dengan super admin di atas
        $sortedRoles = $partitioned->first()->merge($partitioned->last());

        return view('master.role.index', ['title' => 'Role'], compact('sortedRoles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        $menus = [];

        foreach ($permissions as $permission) {
            $nameParts = explode(' ', $permission->name);
            $action = $nameParts[0];
            $menu = $nameParts[1];

            if (!isset($menus[$menu])) {
                $menus[$menu] = [];
            }
            // Menambahkan action ke menu yang sesuai
            $menus[$menu][] = $action;
        }

        return view('master.role.create', ['title' => 'Role'], compact('menus'));
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
        ], [
            'name.required' => "Nama role tidak boleh kosong",
            'name.unique' => "Nama role sudah ada"
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            $role = Role::create([
                'name' => strtolower($request->name),
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            Alert::success('Sukses', 'Data Berhasil ditambahkan!');

            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil ditambah!'
            ]);
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermission = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        $menus = [];

        foreach ($permissions as $permission) {
            $nameParts = explode(' ', $permission->name);
            $action = $nameParts[0];
            $menu = $nameParts[1];

            if (!isset($menus[$menu])) {
                $menus[$menu] = [];
            }
            // Menambahkan action ke menu yang sesuai
            $menus[$menu][] = $action;
        }

        return view('master.role.edit', ['title' => 'Role'], compact('permissions', 'role', 'rolePermission', 'menus'));
    }

    public function update(Request $request, Role $role)
    {

        $validasi = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => "Nama role tidak boleh kosong",
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            $role->update([
                'name' => strtolower($request->name),
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            Alert::success('Sukses', 'Data Berhasil diperbarui!');

            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diperbarui!'
            ]);
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('role.index');
    }
}
