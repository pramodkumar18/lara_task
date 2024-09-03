<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('attributes')->findOrFail($id); // Eager load attributes
        return view('products.show', compact('product'));
    }


    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::all();
        return view('products.create', compact('categories', 'attributes'));
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'attributes' => 'nullable|array',
        ]);

        // Create the product
        $product = Product::create($request->only('name', 'description', 'price', 'category_id'));

        // Attach attributes to the product
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attributeId => $value) {
                // Handle multi-select case
                if (is_array($value)) {
                    foreach ($value as $val) {
                        $product->attributes()->attach($attributeId, ['value' => $val]);
                    }
                } else {
                    $product->attributes()->attach($attributeId, ['value' => $value]);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $attributes = Attribute::all();
        return view('products.edit', compact('product', 'categories', 'attributes'));
    }

    public function update2(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->save();

        $product->attributes()->detach();
        foreach ($request->attributes as $attributeId => $value) {
            $productAttribute = new ProductAttribute();
            $productAttribute->product_id = $product->id;
            $productAttribute->attribute_id = $attributeId;
            $productAttribute->value = $value;
            $productAttribute->save();
        }

        return redirect()->route('products.index');
    }


    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'attributes' => 'array',
            'attributes.*.id' => 'exists:attributes,id',
            'attributes.*.value' => 'string|nullable',
        ]);

        // Find the product
        $product = Product::findOrFail($id);

        // Update product details
        $product->update($request->only(['name', 'description', 'price', 'category_id']));

        // Sync attributes to the product
        if ($request->has('attributes')) {
            // Detach existing attributes and attach new ones
            $product->attributes()->detach(); // Optional: Clear existing relationships
            foreach ($request->attributes as $attr) {
                $product->attributes()->attach($attr['id'], ['value' => $attr['value']]);
            }
        }

        // Redirect or return response
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }


    public function destroy($id)

    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index');
    }


    public function attachAttributes(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'attributes' => 'required|array',
            'value' => 'required|array',
            'value.*' => 'string|nullable', // Validate each value
        ]);

        // Find the product
        $product = Product::findOrFail($id);

        // Attach attributes to the product
        foreach ($request->attributes as $index => $attributeId) {
            $product->attributes()->attach($attributeId, ['value' => $request->value[$index]]);
        }

        // Redirect or return response
        return redirect()->route('products.index')->with('success', 'Attributes attached successfully.');
    }
}