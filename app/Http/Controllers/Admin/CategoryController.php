<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    // direct caategory list
    public function list() {
        $categories = Category::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.category.list', compact('categories'));
    }

    // category create
    public function create(Request $request) {
        $this->checkValidation($request);

        Category::create([
            'name' => $request->categoryName
        ]);

        Alert::success('Success Title', 'Category Created Successfully');
        return back();
    }

    // delete category
    public function delete($id) {
        Category::where('id', $id)->delete();
        return back();
    }

    // edit category
    public function edit($id) {
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    // update category
    public function update($id, Request $request) {
        $request['id'] = $id;
        $this->checkValidation($request);

        Category::where('id', $id)->update([
            'name' => $request->categoryName,
        ]);

        Alert::success('Success Title', 'Category Updated Successfully');
        return to_route('category#list');
    }

    // check validation
    private function checkValidation($request) {
        $request->validate([
            'categoryName' => 'required|min:2|max:30|unique:categories,name,'.$request->id // can't be same name except itself's name
        ], [
            'categoryName.required' => 'အမျိုးအစားအမည် လိုအပ်သည်။',
            'categoryName.unique' => 'အမျိုးအစားအမည်ကို ယူထားပြီးဖြစ်သည်။'
        ]);
    }


}
