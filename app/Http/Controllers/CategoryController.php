<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return view('categories.index', compact('categories'));
    }


    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('categories.create');
    }


    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:categories,name',
                ],

                'description' => [
                    'nullable',
                    'string',
                ],
            ],
            [
                'name.required' => 'Nama kategori wajib diisi.',
                'name.unique' => 'Nama kategori sudah digunakan.',
            ]
        );


        $category = Category::create($validated);


        /*
        |--------------------------------------------------------------------------
        | CATAT AKTIVITAS
        |--------------------------------------------------------------------------
        */

        ActivityLog::create([

            'user_id' =>
                Auth::id(),

            'action' =>
                'menambahkan kategori',

            'description' =>
                $category->name,

            'reference_type' =>
                'Category',

            'reference_id' =>
                $category->id,

        ]);


        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan form edit kategori.
     */
    public function edit(Category $kategori)
    {
        return view(
            'categories.edit',
            [
                'category' => $kategori
            ]
        );
    }


    /**
     * Memperbarui kategori.
     */
    public function update(
        Request $request,
        Category $kategori
    ) {

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:categories,name,' . $kategori->id,
                ],

                'description' => [
                    'nullable',
                    'string',
                ],
            ],
            [
                'name.required' => 'Nama kategori wajib diisi.',
                'name.unique' => 'Nama kategori sudah digunakan.',
            ]
        );


        $kategori->update($validated);


        /*
        |--------------------------------------------------------------------------
        | CATAT AKTIVITAS
        |--------------------------------------------------------------------------
        */

        ActivityLog::create([

            'user_id' =>
                Auth::id(),

            'action' =>
                'memperbarui kategori',

            'description' =>
                $kategori->name,

            'reference_type' =>
                'Category',

            'reference_id' =>
                $kategori->id,

        ]);


        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil diperbarui.'
            );
    }


    /**
     * Menghapus kategori.
     */
    public function destroy(Category $kategori)
    {
        $categoryName = $kategori->name;

        $categoryId = $kategori->id;


        $kategori->delete();


        /*
        |--------------------------------------------------------------------------
        | CATAT AKTIVITAS
        |--------------------------------------------------------------------------
        */

        ActivityLog::create([

            'user_id' =>
                Auth::id(),

            'action' =>
                'menghapus kategori',

            'description' =>
                $categoryName,

            'reference_type' =>
                'Category',

            'reference_id' =>
                $categoryId,

        ]);


        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil dihapus.'
            );
    }
}

