<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(12);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'glb_model' => 'nullable|file|mimes:glb|max:10240',
            'usdz_model' => 'nullable|file|mimes:usdz|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $productData = $request->only(['name', 'description', 'price', 'category']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/images'), $imageName);
            $productData['image'] = $imageName;
        }

        // Handle GLB model upload
        if ($request->hasFile('glb_model')) {
            $glbName = time() . '_' . $request->file('glb_model')->getClientOriginalName();
            $request->file('glb_model')->move(public_path('uploads/models'), $glbName);
            $productData['glb_model'] = $glbName;
        }

        // Handle USDZ model upload
        if ($request->hasFile('usdz_model')) {
            $usdzName = time() . '_' . $request->file('usdz_model')->getClientOriginalName();
            $request->file('usdz_model')->move(public_path('uploads/models'), $usdzName);
            $productData['usdz_model'] = $usdzName;
        }

        // Set AR enabled if models are present
        $productData['ar_enabled'] = !empty($productData['glb_model']) || !empty($productData['usdz_model']);

        $product = Product::create($productData);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'glb_model' => 'nullable|file|mimes:glb|max:10240',
            'usdz_model' => 'nullable|file|mimes:usdz|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $productData = $request->only(['name', 'description', 'price', 'category']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && file_exists(public_path('uploads/images/' . $product->image))) {
                unlink(public_path('uploads/images/' . $product->image));
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/images'), $imageName);
            $productData['image'] = $imageName;
        }

        // Handle GLB model upload
        if ($request->hasFile('glb_model')) {
            // Delete old model if exists
            if ($product->glb_model && file_exists(public_path('uploads/models/' . $product->glb_model))) {
                unlink(public_path('uploads/models/' . $product->glb_model));
            }
            $glbName = time() . '_' . $request->file('glb_model')->getClientOriginalName();
            $request->file('glb_model')->move(public_path('uploads/models'), $glbName);
            $productData['glb_model'] = $glbName;
        }

        // Handle USDZ model upload
        if ($request->hasFile('usdz_model')) {
            // Delete old model if exists
            if ($product->usdz_model && file_exists(public_path('uploads/models/' . $product->usdz_model))) {
                unlink(public_path('uploads/models/' . $product->usdz_model));
            }
            $usdzName = time() . '_' . $request->file('usdz_model')->getClientOriginalName();
            $request->file('usdz_model')->move(public_path('uploads/models'), $usdzName);
            $productData['usdz_model'] = $usdzName;
        }

        // Update AR enabled status
        $productData['ar_enabled'] = 
            (!empty($productData['glb_model']) || !empty($product->glb_model)) || 
            (!empty($productData['usdz_model']) || !empty($product->usdz_model));

        $product->update($productData);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated files
        if ($product->image && file_exists(public_path('uploads/images/' . $product->image))) {
            unlink(public_path('uploads/images/' . $product->image));
        }
        if ($product->glb_model && file_exists(public_path('uploads/models/' . $product->glb_model))) {
            unlink(public_path('uploads/models/' . $product->glb_model));
        }
        if ($product->usdz_model && file_exists(public_path('uploads/models/' . $product->usdz_model))) {
            unlink(public_path('uploads/models/' . $product->usdz_model));
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
