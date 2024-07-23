<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{

    public function index()
    {
        $category = Category::latest()->get();
        return view('master.category.index', ['title' => 'Category'], compact('category'));
    }

    public function create()
    {
        return view('master.category.create', ['title' => 'Category']);
    }
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name'
        ], [
            'name.required' => "Nama Kategori harus diisi",
            'name.unique' => "Nama Kategori sudah ada"
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            Category::create([
                'name' => strtolower($request->name),
            ]);
            Alert::success('Sukses', 'Data Berhasil ditambah!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil ditambah!'
            ]);
        }
    }

    public function edit(Category $category)
    {
        return view('master.category.edit', ['title' => 'Category'], compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|unique:categories'
        ], [
            'name.required' => "Nama Kategori harus diisi",
            'name.unique' => "Nama Kategori sudah ada",
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            $category->update([
                'name' => strtolower($request->name),
            ]);
            Alert::success('Sukses', 'Data Berhasil diperbarui!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diperbarui!'
            ]);
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index');
    }
}
