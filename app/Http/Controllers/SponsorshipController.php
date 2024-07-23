<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class SponsorshipController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $role = Role::where('name', 'super admin')->first();

        // Jika pengguna adalah superadmin, ambil semua pengajuan
        if ($role && $user->hasRole('super admin')) {
            $sponsorship = Sponsorship::latest()->get();
        } else {
            // Jika bukan superadmin, ambil sponsorship yang terkait dengan id pengguna
            $sponsorship = Sponsorship::where('user_id', $user->id)->latest()->get();
        }
        return view('master.sponsorship.index', ['title' => 'Sponsorship'], compact('sponsorship'));
    }

    public function create()
    {
        return view('master.sponsorship.create', ['title' => 'Sponsorship']);
    }
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required|numeric',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email',
            'address' => 'required|string',
        ], [
            'name.required' => 'Nama Perusahaan harus diisi',
            'amount.numeric' => 'Pendanaan harus berupa angka',
            'amount.required' => 'Pendanaan harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'phone.required' => 'Nomor Telepon harus diisi',
            'phone.regex' => 'Format nomor telepon tidak valid',
            'phone.min' => 'Nomor telepon harus minimal 10 digit',
            'address.required' => 'Alamat harus diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        }


        Sponsorship::create([
            "user_id" => Auth::User()->id,
            "name" => strtolower($request->name),
            "amount" => $request->amount,
            "phone" => $request->phone,
            "address" => strtolower($request->address),
            "link_sosmed" => $request->link_sosmed,
            "email" => $request->email,
        ]);

        Alert::success('Sukses', 'Data Berhasil ditambah!');
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil ditambah!'
        ]);
    }

    public function show(Sponsorship $sponsorship)
    {
        return view('master.sponsorship.show', ['title' => 'Sponsorship'], compact('sponsorship'));
    }

    public function edit(Sponsorship $sponsorship)
    {
        return view('master.sponsorship.edit', ['title' => 'Sponsorship'], compact('sponsorship'));
    }
    public function update(Request $request, Sponsorship $sponsorship)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required|numeric',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email',
            'address' => 'required|string',
        ], [
            'name.required' => 'Nama Perusahaan harus diisi',
            'amount.numeric' => 'Pendanaan harus berupa angka',
            'amount.required' => 'Pendanaan harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'phone.required' => 'Nomor Telepon harus diisi',
            'phone.regex' => 'Format nomor telepon tidak valid',
            'phone.min' => 'Nomor telepon harus minimal 10 digit',
            'address.required' => 'Alamat harus diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {


            $sponsorship->update([
                "name" => strtolower($request->name),
                "amount" => $request->amount,
                "phone" => $request->phone,
                "address" => strtolower($request->address),
                "email" => $request->email,
            ]);

            Alert::success('Sukses', 'Data Berhasil diperbarui!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diperbarui!'
            ]);
        }
    }

    public function destroy(Sponsorship $sponsorship)
    {
        $sponsorship->delete();
        return redirect()->back();
    }
}
