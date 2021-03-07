<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPriceValidation;
use App\Http\Requests\ProductStockRequest;
use App\Models\Brand as BrandModel;
use App\Models\Category as CategoryModel;
use App\Models\Image as ImageModel;
use App\Models\Product as ProductModel;
use App\Models\Tag as TagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class ProductsController extends Controller
{

    public function index()
    {
        $products = ProductModel::select('id', 'slug', 'price', 'created_at')->paginate(PAGINATION_COUNT);
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

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $product = ProductModel::create([
                'slug' => $request->slug,
                'brand_id' => $request->brand_id,
                'is_active' => $request->is_active,
            ]);
            //save translations

            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->save();

            //save product categories

            $product->categories()->attach($request->categories);

            //save product tags

            DB::commit();
            return redirect()->route('admin.products')->with(['success' => 'تم ألاضافة بنجاح']);
        } catch (\Exception $ex) {
            return $ex;
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
        if ($price) {

            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);
        } else {
            return redirect()->route('admin.products')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
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

    public function addImages($product_id)
    {
        return view('dashboard.products.images.create')->withId($product_id);
    }

    //to save images to folder only
    public function saveProductImages(Request $request)
    {

        $file = $request->file('dzfile');
        $filename = uploadImage('products', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }

    public function saveProductImagesDB(ProductImagesRequest $request)
    {

        // save dropzone images
        if ($request->has('document') && count($request->document) > 0) {
            foreach ($request->document as $image) {
                ImageModel::create([
                    'product_id' => $request->product_id,
                    'photo' => $image,
                ]);
            }
            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);

        } else {

            return redirect()->route('admin.products')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
    }

    public function edit($id)
    {

        //get specific categories and its translations
        $category = CategoryModel::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('admin.mainCategories')->with(['error' => 'هذا القسم غير موجود ']);

        return view('dashboard.categories.edit', compact('category'));

    }

    public function update($id, MainCategoryRequest $request)
    {
        try {

            $category = CategoryModel::find($id);

            if (!$category)
                return redirect()->route('admin.mainCategories')->with(['error' => 'هذا القسم غير موجود']);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.mainCategories')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.mainCategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $category = CategoryModel::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('admin.mainCategories')->with(['error' => 'هذا القسم غير موجود ']);

            $category->delete();

            return redirect()->route('admin.mainCategories')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.mainCategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
