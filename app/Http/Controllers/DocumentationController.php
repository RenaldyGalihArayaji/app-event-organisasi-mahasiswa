<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Documentation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DocumentationController extends Controller
{
    public function index($id)
    {
        $event = Event::with('documentation')->findOrFail($id);
        return view('master.participant.documentation', compact('event'));
    }
    public function uploadDocumentation(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'required'
        ], [
            'image.required' => 'Gambar wajib diisi',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Gambar harus berupa file JPG, PNG, atau JPEG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'description.required' => 'Deskripsi wajib diisi',
        ]);


        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        }

        $event = Event::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'Gambar_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('/public/image-documentations', $file, $fileName);
        }


        Documentation::create([
            'user_id' => Auth::user()->id,
            'event_id' => $event->id,
            'image' => $fileName,
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
            'gDrive_url' => $request->gDrive_url,
        ]);

        Alert::success('Sukses', 'Berhasil Upload Dokumentasi!');
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Upload Dokumentasi!'
        ]);
    }

    public function documentationShow($id)
    {
        $event = Event::with('documentation')->findOrFail($id);
        return view('master.participant.documentation-show', compact('event'));
    }
}
