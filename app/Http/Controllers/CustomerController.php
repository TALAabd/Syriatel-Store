<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;

        $this->middleware('permission:manage users');
    }

    public function index()
    {
        $customers = $this->customerRepository->all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $user->assignRole('customer');

            $customerData = $request->only(['phone', 'address']);
            $customerData['user_id'] = $user->id;

            $this->customerRepository->create($customerData);

            DB::commit();

            return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $customer = $this->customerRepository->find($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $customer = $this->customerRepository->find($id);

            $this->customerRepository->update($id, $request->only(['phone', 'address']));

            if ($customer->user) {
                $customer->user->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                ]);

                if ($request->filled('password')) {
                    $customer->user->update([
                        'password' => Hash::make($request->input('password')),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(\App\Models\Customer $customer)
    {
        DB::transaction(function () use ($customer) {
            if ($customer->user) {
                $customer->user->delete();
            }
            $customer->delete();
        });

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}
