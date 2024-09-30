<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('master.setting.index', ['title' => 'Pengaturan'], compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'app_logo' => 'image|mimes:jpg,png,jpeg|max:2048',
            'hero_image' => 'image|mimes:jpg,png,jpeg|max:2048',
            'app_name' => 'required|max:10',
            'short_description' => 'required|max:300',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|max:20',
            'contact_address' => 'required|max:250',
            'hero_name' => 'required|max:30',
            'deadline' => 'required',
        ], [
            'app_logo.image' => 'File harus berupa gambar',
            'hero_image.image' => 'File harus berupa gambar',
            'app_name.required' => 'Nama Aplikasi harus diisi',
            'app_name.max' => 'Nama Aplikasi maksimal 10 karakter',
            'short_description.required' => 'Deskripsi Aplikasi harus diisi',
            'short_description.max' => 'Deskripsi Aplikasi maksimal 300 karakter',
            'contact_email.required' => 'Email harus diisi',
            'contact_email.email' => 'Email harus berupa email',
            'contact_phone.required' => 'Nomor Telepon harus diisi',
            'contact_phone.max' => 'Nomor Telepon maksimal 20 karakter',
            'contact_address.required' => 'Alamat harus diisi',
            'contact_address.max' => 'Alamat maksimal 150 karakter',
            'hero_name.required' => 'Nama Hero Section harus diisi',
            'hero_name.max' => 'Nama Hero Section maksimal 25 karakter',
            'deadline.required' => 'Batas Pengajuan harus diisi',
        ]);

        $setting = Setting::find($id);

        if ($request->hasFile('app_logo')) {
            Storage::delete('public/image_settings/' . $setting->app_logo);
            $fileNameLogo = 'Logo_' . time() . '.' . $request->app_logo->getClientOriginalExtension();
            $request->app_logo->storeAs('public/image_settings', $fileNameLogo);
        } else {
            $fileNameLogo = $setting->app_logo;
        }

        if ($request->hasFile('hero_image')) {
            Storage::delete('public/image_settings/' . $setting->hero_image);
            $fileNameHero = 'Hero_' . time() . '.' . $request->hero_image->getClientOriginalExtension();
            $request->hero_image->storeAs('public/image_settings', $fileNameHero);
        } else {
            $fileNameHero = $setting->hero_image;
        }

        $setting->update([
            'app_name' => $request->app_name,
            'short_description' => $request->short_description,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'contact_address' => $request->contact_address,
            'hero_name' => $request->hero_name,
            'youtube_url' => $request->youtube_url,
            'instagram_url' => $request->instagram_url,
            'facebook_url' => $request->facebook_url,
            'app_logo' => $fileNameLogo,
            'hero_image' => $fileNameHero,
            'deadline' => $request->deadline,
        ]);

        Alert::success('Sukses', 'Data Berhasil Diperbarui!!');
        return redirect()->back();
    }
}
