<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Group;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    public function indexFinishedGoods(Request $request)
    {
        $request->merge(['material_type' => 'finished_good']);
        return $this->index($request, 'Finished Goods Hub');
    }

    public function indexRawMaterials(Request $request)
    {
        $request->merge(['material_type' => 'raw_material']);
        return $this->index($request, 'Raw Materials Warehouse');
    }

    public function indexPackagingMaterials(Request $request)
    {
        $request->merge(['material_type' => 'packaging']);
        return $this->index($request, 'Packaging Library');
    }

    public function index(Request $request, $pageTitle = 'Master Inventory Catalog')
    {
        $query = Product::with(['brand', 'group', 'category', 'unit']);

        // Filter by Group
        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        // Filter by Brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Filter by Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Filter by Material Type
        if ($request->filled('material_type')) {
            $query->where('material_type', $request->material_type);
        }

        $products = $query->latest()->get();

        return view('products.index', compact('products', 'pageTitle'));
    }

    public function create()
    {
        $groups = Group::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('products.create', compact('groups', 'brands', 'categories', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group_id' => 'required_if:material_type,finished_good|nullable|exists:groups,id',
            'brand_id' => 'required_if:material_type,finished_good|nullable|exists:brands,id',
            'category_id' => 'required_if:material_type,finished_good|nullable|exists:categories,id',
            'material_type' => 'required|in:raw_material,packaging,finished_good',
            'unit_id' => 'required|exists:units,id',
            'cost_price' => 'numeric|min:0',
            'sale_price' => 'numeric|min:0',
            'reorder_point' => 'numeric|min:0',
            'expiry_date' => 'nullable|date',
        ]);

        $product = Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
    
    public function show(Product $product)
    {
        $product->load(['brand', 'category', 'unit', 'stockMovements' => function($q) {
            $q->latest('transaction_date');
        }]);

        // Calculate some basic stats for the detail page
        $totalIn = $product->stockMovements->where('type', 'in')->sum('quantity');
        $totalOut = $product->stockMovements->where('type', 'out')->sum('quantity');
        $valuation = $product->current_stock * $product->sale_price;

        return view('products.show', compact('product', 'totalIn', 'totalOut', 'valuation'));
    }

    public function edit(Product $product)
    {
        $groups = Group::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('products.edit', compact('product', 'groups', 'brands', 'categories', 'units'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group_id' => 'required_if:material_type,finished_good|nullable|exists:groups,id',
            'brand_id' => 'required_if:material_type,finished_good|nullable|exists:brands,id',
            'category_id' => 'required_if:material_type,finished_good|nullable|exists:categories,id',
            'material_type' => 'required|in:raw_material,packaging,finished_good',
            'unit_id' => 'required|exists:units,id',
            'cost_price' => 'numeric|min:0',
            'sale_price' => 'numeric|min:0',
            'reorder_point' => 'numeric|min:0',
            'expiry_date' => 'nullable|date',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function generateCataloguePDF(Request $request)
    {
        $query = Product::with(['brand', 'category', 'unit']);

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('material_type')) {
            $query->where('material_type', $request->material_type);
        }

        $products = $query->latest()->get();

        $pdf = Pdf::loadView('products.catalogue_pdf', compact('products'))
                  ->setPaper('a4', 'landscape');
        
        return $pdf->stream("product_catalogue_" . date('Y-m-d') . ".pdf");
    }

    public function exportPdf(Product $product)
    {
        $product->load(['brand', 'category', 'unit', 'stockMovements' => function($q) {
            $q->latest('transaction_date');
        }]);

        $totalIn = $product->stockMovements->where('type', 'in')->sum('quantity');
        $totalOut = $product->stockMovements->where('type', 'out')->sum('quantity');
        $valuation = $product->current_stock * $product->cost_price;

        $pdf = Pdf::loadView('products.pdf', compact('product', 'totalIn', 'totalOut', 'valuation'));
        
        return $pdf->stream("audit_report_{$product->id}.pdf");
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function batchIndex()
    {
        $products = Product::with(['brand', 'category', 'unit'])->orderBy('name')->get();
        return view('products.batch', compact('products'));
    }

    public function batchUpdate(Request $request)
    {
        $request->validate([
            'stocks' => 'required|array',
            'stocks.*' => 'numeric|min:0',
        ]);

        foreach ($request->stocks as $id => $quantity) {
            $product = Product::find($id);
            if ($product && $product->current_stock != $quantity) {
                // Record the adjustment as a movement
                $diff = $quantity - $product->current_stock;
                $product->stockMovements()->create([
                    'type' => $diff > 0 ? 'in' : 'out',
                    'quantity' => abs($diff),
                    'transaction_date' => now(),
                    'reference_no' => 'BATCH_ADJ_' . date('Ymd_His'),
                    'notes' => 'Bulk stock adjustment from Command Center.'
                ]);

                $product->update(['current_stock' => $quantity]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Bulk stock adjustment completed successfully.');
    }

    public function getBatches($id)
    {
        $product = Product::findOrFail($id);
        $batches = $product->batches()
            ->where('current_quantity', '>', 0)
            ->where('status', 'active')
            ->get();
        return response()->json($batches);
    }
}
