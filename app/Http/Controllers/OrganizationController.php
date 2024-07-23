<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    public function index()
    {
        $organization = Organization::where('name', '!=', 'super admin')->latest()->get();
        return view('master.organization.index', ['title' => 'organization'], compact('organization'));
    }
    public function create()
    {
        return view('master.organization.create', ['title' => 'organization']);
    }
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|unique:organizations,name',
        ], [
            'name.required' => "Nama Organisasi harus diisi",
            'name.unique' => "Nama Organisasi sudah ada",
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {

            Organization::create([
                'name' => strtolower($request->name),
            ]);
            Alert::success('Sukses', 'Data Berhasil ditambah!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil ditambah!'
            ]);
        }
    }
    public function edit(Organization $organization)
    {
        return view('master.organization.edit', ['title' => 'organization'], compact('organization'));
    }
    public function update(Request $request, organization $organization)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => "Nama Organisasi harus diisi",
            'name.unique' => "Nama Organisasi sudah ada",
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {

            $organization->update([
                'name' => strtolower($request->name),
            ]);
            Alert::success('Sukses', 'Data Berhasil diperbarui!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diperbarui!'
            ]);
        }
    }
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organization.index');
    }
}
