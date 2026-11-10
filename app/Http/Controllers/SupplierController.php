<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);

        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $supplier = Supplier::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'menambahkan supplier',
            'description' => $supplier->name,
            'reference_type' => 'Supplier',
            'reference_id' => $supplier->id,
        ]);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        return redirect()->route('supplier.edit', $supplier);
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $supplier->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'memperbarui supplier',
            'description' => $supplier->name,
            'reference_type' => 'Supplier',
            'reference_id' => $supplier->id,
        ]);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplierName = $supplier->name;
        $supplierId = $supplier->id;

        $supplier->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'menghapus supplier',
            'description' => $supplierName,
            'reference_type' => 'Supplier',
            'reference_id' => $supplierId,
        ]);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}

