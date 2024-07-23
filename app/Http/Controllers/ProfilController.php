<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    public function index()
    {
        return view('master.profil.index', ['title' => 'Profil']);
    }

    public function update(Request $request)
    {
        $data = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $data->id,
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|max:13',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048',
            'account_owner' => 'nullable|string|max:255',
            'account_number' => 'nullable|numeric',
            'bank_name' => 'nullable|string|max:255',
            'logo' => 'image|mimes:jpg,png,jpeg|max:2048',
            'structure_image' => 'image|mimes:jpg,png,jpeg|max:2048',
            'name_organization' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'phone.max' => 'Nomor Telepon maksimal 13 karakter',
            'image.image' => 'Foto harus berupa gambar',
            'image.mimes' => 'Foto harus berupa jpg, png, atau jpeg',
            'image.max' => 'Foto maksimal 2MB',
            'account_owner.string' => 'Nama Pemilik Rekening harus berupa string',
            'account_owner.max' => 'Nama Pemilik Rekening maksimal 255 karakter',
            'account_number.numeric' => 'Nomor Rekening harus berupa angka',
            'bank_name.string' => 'Nama Bank harus berupa string',
            'bank_name.max' => 'Nama Bank maksimal 255 karakter',
            'logo.image' => 'Logo harus berupa gambar',
            'logo.mimes' => 'Logo harus berupa jpg, png, atau jpeg',
            'logo.max' => 'Logo maksimal 2MB',
            'structure_image.image' => 'Foto Struktur harus berupa gambar',
            'structure_image.mimes' => 'Foto Struktur harus berupa jpg, png, atau jpeg',
            'structure_image.max' => 'Foto Struktur maksimal 2MB',
            'name_organization.string' => 'Nama Organisasi harus berupa string',
            'description.string' => 'Deskripsi Organisasi harus berupa string',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'account_owner' => $request->account_owner,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            // Storage::delete('public/image-profil/' . $data->image);
            $name = $request->file('image');
            $fileName = 'Profil_' . time() . '.' . $name->getClientOriginalExtension();
            $request->file('image')->storeAs('public/image-profil', $fileName);
            $updateData['image'] = $fileName;
        }

        $data->update($updateData);

        $organizationData = [
            'name' => $request->name_organization,
            'description' => $request->description,
        ];

        if ($request->hasFile('logo')) {
            // Storage::delete('public/image-organizations/' . $data->organization->logo);
            $logo = $request->file('logo');
            $logoFileName = 'Logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $request->file('logo')->storeAs('public/image-organizations', $logoFileName);
            $organizationData['logo'] = $logoFileName;
        }

        if ($request->hasFile('structure_image')) {
            // Storage::delete('public/image-organizations/' . $data->organization->structure_image);
            $structureImage = $request->file('structure_image');
            $structureImageFileName = 'Structure_' . time() . '.' . $structureImage->getClientOriginalExtension();
            $request->file('structure_image')->storeAs('public/image-organizations', $structureImageFileName);
            $organizationData['structure_image'] = $structureImageFileName;
        }

        $data->organization->update($organizationData);

        Alert::success('Sukses', 'Profil dan data organisasi berhasil diperbarui!');
        return redirect()->route('profil');
    }
}
