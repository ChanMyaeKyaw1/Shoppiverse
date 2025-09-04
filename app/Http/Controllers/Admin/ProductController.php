<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

use function PHPUnit\Framework\fileExists;

class ProductController extends Controller
{
    // create page
    public function createPage() {
        $categories = Category::select('id', 'name')-> get();
        return view('admin.product.create', compact('categories'));
    }

    // create
    public function create(Request $request) {
        $this->checkValidation($request, 'create');
        $data = $this->getData($request);

        if($request->hasFile('image')) {
            $fileName = uniqid(). $request->file("image")->getClientOriginalName();
            $request->file("image")->move( public_path(). "/productImage/", $fileName );
            $data['image'] = $fileName;
        }

        Product::create($data);

        Alert::success('Success Title', 'Product Created Successfully');
        return back();
    }

    // product list
    public function list($action = "default") {
        $products = Product::select('products.id', 'products.name', 'products.image', 'products.price', 'products.stock', 'products.category_id', 'categories.name as category_name')
                        ->leftJoin('categories', 'products.category_id', 'categories.id')
                        ->orderBy('products.created_at', 'desc')

                         ->when($action == 'lowAmt', function($query) {
                            $query->where('products.stock', '<=', 3);
                        })

                        ->when(request('searchKey'), function($query) {
                            $query->whereAny(['products.name', 'products.price', 'categories.name'], 'like',
                            '%'.request('searchKey').'%');
                        })
                        -> get();
        return view('admin.product.list', compact('products'));
    }

    // edit
    public function edit($id) {
        $categories = Category::get();
        $product = Product::where('id', $id)->first();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    // delete
    public function delete($id) {
        Product::where('id', $id)->delete();
        return back();
    }

    // get product data
    public function getData($request) {
        return [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->categoryId,
            'stock' => $request->stock,
            'image' => $request->image,
        ];
    }

    // update product
    public function update(Request $request, $id) {
        $this->checkValidation($request, 'update');
        $data = $this->getData($request);

        // if user choose image file
        if($request->hasFile('image')) {
            $oldImageName = $request->productImage;

            if( fileExists( public_path('productImage/' .$oldImageName) ) ) {
                unlink( public_path( 'productImage/' .$oldImageName ) ); // delete the old image
            }
            // add new image instead of old
            $fileName = uniqid(). $request->file("image")->getClientOriginalName();
            $request->file("image")->move( public_path(). "/productImage/", $fileName );
            $data['image'] = $fileName;
        } else {
            $data['image'] = $request->productImage; // if user didn't choose image, still old image
        }

        Product::where('id', $id)->update($data);
        Alert::success('Success Title', 'Product Updated Successfully');
        return to_route('product#list');
    }

    // check validation
    private function checkValidation($request, $action) {
        $rules = [
            'name' => 'required|min:1|max:50|unique:products,name,' .$request->productId,
            'categoryId' => 'required',
            'price' => 'required |numeric |min:10', // eg. 10 dollars
            'stock' => 'required |numeric |min:1 |max:999',
            'description' => 'required |min:10 |max:2000',
        ];
        $rules['image'] = $action == 'create' ? 'required|file|mimes:png,jpg,jpeg,webp,svg,gif' : 'file|mimes:png,jpg,jpeg,webp,svg,gif';

        $message = [];

        $request->validate($rules, $message);
    }
}
