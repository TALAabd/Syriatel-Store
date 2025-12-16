<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Interfaces\SupplierRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
        $this->middleware('permission:manage users');
    }

    public function index()
    {
        $suppliers = $this->supplierRepository->all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(SupplierRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $user->assignRole('supplier');

            $supplierData = $request->only(['company_name', 'company_address', 'phone']);
            $supplierData['user_id'] = $user->id;

            $this->supplierRepository->create($supplierData);

            DB::commit();

            return redirect()
                ->route('suppliers.index')
                ->with('success', 'Supplier and user account created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withErrors(['error' => 'Failed to create supplier: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $supplier = $this->supplierRepository->find($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $supplier = $this->supplierRepository->find($id);

            $this->supplierRepository->update($id, $request->only([
                'company_name',
                'company_address',
                'phone'
            ]));

            if ($supplier->user) {
                $supplier->user->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                ]);

                if ($request->filled('password')) {
                    $supplier->user->update([
                        'password' => Hash::make($request->input('password')),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withErrors(['error' => 'Failed to update supplier: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(\App\Models\Supplier $supplier)
    {
        DB::transaction(function () use ($supplier) {
            if ($supplier->user) {
                $supplier->user->delete();
            }
            $supplier->delete();
        });

        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully!');
    }
}
