<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;

        
        $this->middleware('permission:view products')->only(['index', 'show']);
        $this->middleware('permission:create products')->only(['create', 'store']);
        $this->middleware('permission:edit products')->only(['edit', 'update']);
        $this->middleware('permission:delete products')->only(['destroy']);
    }


    public function index()
    {
        $products = $this->productRepository->all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $suppliers = [];

        if (auth()->user()->hasRole('admin')) {
            $suppliers = Supplier::all();
        }
        return view('products.create', compact('suppliers'));
    }

    public function store(ProductRequest $request)
    {
        $this->productRepository->create($request->validated());
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $suppliers = [];

        if (auth()->user()->hasRole('admin')) {
            $suppliers = Supplier::all();
        }

        $product = $this->productRepository->find($id);
        return view('products.edit', compact('product', 'suppliers'));
    }

    public function update(ProductRequest $request, $id)
    {
        $this->productRepository->update($id, $request->validated());
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
