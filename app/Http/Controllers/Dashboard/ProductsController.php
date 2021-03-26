<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\ProductsType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Http\Requests\Dashboard\GeneralProductRequest;
use App\Http\Requests\Dashboard\ProductPriceValidation;
use App\Http\Requests\Dashboard\ProductStockRequest;
use App\Models\Brand as BrandModel;
use App\Models\Category as CategoryModel;
use App\Models\Product as ProductModel;
use App\Models\Tag as TagModel;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function index()
    {
        $products = ProductModel::select('id', 'slug', 'photo', 'price', 'created_at')->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.products.general.index', compact('products'));
    }

    public function create()
    {
        $data = [];
        $data['brands'] = BrandModel::active()->select('id')->get();
        $data['tags'] = TagModel::select('id')->get();
        $data['categories'] = CategoryModel::active()->select('id')->get();
        return view('dashboard.products.general.create', $data);
    }

    public function store(GeneralProductRequest $request)
    {
        try {
            DB::beginTransaction();
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => ProductsType::UnActiveProduct]);
            } else {
                $request->request->add(['is_active' => ProductsType::ActiveProduct]);
            }
            $fileName = "";
            if ($request->has('photo')) {
                ###helper###
                $fileName = uploadImage('products', $request->photo);
            }

            $product = ProductModel::create([
                'slug' => $request->slug,
                'brand_id' => $request->brand_id,
                'is_active' => $request->is_active,
                'photo' => $fileName,
            ]);
            //save translations

            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;

            $product->save();

            //save product categories

            $product->categories()->attach($request->categories);

            DB::commit();
            return redirect()->route('admin.products')->with(['success' => 'تم ألاضافة بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.products.general.create')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function getPrice($product_id)
    {
        return view('dashboard.products.prices.create')->with('id', $product_id);
    }

    public function saveProductPrice(ProductPriceValidation $request)
    {
        $price = ProductModel::whereId($request->product_id);

        $price->update($request->except('_token', 'product_id'));
        if ($price)
            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);

        return redirect()->route('admin.products')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

    }

    public function getStock($product_id)
    {
        return view('dashboard.products.stock.create')->with('id', $product_id);
    }

    public function saveProductStock(ProductStockRequest $request)
    {
        ProductModel::whereId($request->product_id)->update($request->except(['_token', 'product_id']));

        return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);
    }

    public function edit($id)
    {
        //
    }

    public function update($id, CategoryRequest $request)
    {
        //
    }

    public function destroy($id)
    {

        //
    }

}
