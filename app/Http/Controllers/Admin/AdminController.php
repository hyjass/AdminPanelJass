<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User as Admins;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function userdata()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $data = Admins::all();
            return view('admin.userdata', ['data' => $data]);
        }
        return redirect()->route('login');
    }

    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $data = Admins::all();
            return view('admin.dashboard', ['data' => $data]);
        }
        return redirect()->route('login');
    }


    public function products()
    {
        return view(
            'admin.products',
            [
                'products' => \App\Models\Product::all()
            ]
        );
    }


    public function subcategories()
    {
        return view(
            'admin.subcategories',
            [
                'subcategories' => \App\Models\Subcategory::all()
            ]
        );
    }

    public function categories()
    {
        return view('admin.categories', [
            'categories' => \App\Models\Category::all()
        ]);
    }

    public function category(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        $category = \App\Models\Category::find($id);

        if ($category) {
            $category->name = $request->name;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $category->image = 'images/' . $imageName;
            }

            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => true, 'message' => 'Category updated successfully']);
        } else {
            $category = new \App\Models\Category();
            $category->name = $request->name;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $category->image = 'images/' . $imageName;
            }

            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => true, 'message' => 'Category created successfully']);

        }
    }

    public function subcategory(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        $subcategory = \App\Models\Subcategory::find($id);
        // dd($subcategory);
        if (isset($id) && $subcategory) {
            $subcategory->name = $request->name;
            $subcategory->category_id = $request->category_id;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $subcategory->image = 'images/' . $imageName;
            }
            $subcategory->status = $request->status;
            $subcategory->save();

            return response()->json(['success' => true, 'message' => 'Subcategory updated successfully']);
        } else {
            $subcategory = new \App\Models\Subcategory();
            $subcategory->name = $request->name;
            $subcategory->category_id = $request->category_id;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $subcategory->image = 'images/' . $imageName;
            }

            $subcategory->status = $request->status;
            $subcategory->save();

            return response()->json(['success' => true, 'message' => 'Category created successfully']);

        }
    }


    public function productstore(Request $request)
    {
        $id = $request->product_id;
        // dd($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // dd($data);
        if (isset($id)) {
            $product = \App\Models\Product::find($id);
            if ($product) {
                $product->name = $request->name;
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = $image->getClientOriginalName();
                    $image->move(public_path('images/products'), $imageName);
                    $product->image = 'images/products/' . $imageName;
                }
                $product->rate = $request->rate;
                $product->specifications = $request->specifications;
                $product->unit = $request->unit;
                $product->subcategory_id = $request->subcategory_id;
                $product->status = $request->status;
                if (isset($request->discount) && $request->discount > 0) {
                    $product->discount = $request->discount;
                }

                if (isset($request->discount) && $request->discount > 0) {
                    $product->final_amount = $request->rate - ($request->rate * ($request->discount / 100));
                } else {
                    $product->final_amount = $request->rate;
                }

                $product->save();

                return response()->json(['success' => true, 'message' => 'Product updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Product not found'], 404);
            }
        } else {
            $product = new \App\Models\Product();
            $product->name = $request->name;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images/products'), $imageName);
                $product->image = 'images/products/' . $imageName;
            }
            $product->rate = $request->rate;
            $product->specifications = $request->specifications;
            $product->unit = $request->unit;
            $product->subcategory_id = $request->subcategory_id;
            $product->status = $request->status;
            if (isset($request->discount) && $request->discount > 0) {
                $product->discount = $request->discount;
            }

            if (isset($request->discount) && $request->discount > 0) {
                $product->final_amount = $request->rate - ($request->rate * ($request->discount / 100));
            } else {
                $product->final_amount = $request->rate;
            }
            $product->save();
            return response()->json(['success' => true, 'message' => 'Product created successfully']);

        }
    }

    public function deletecategory(Request $request)
    {
        $id = $request->id;
        $category = \App\Models\Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 404);
        }
    }



    public function deleteSubCategory(Request $request)
    {
        $id = $request->id;
        // dd($id);
        $subcategory = \App\Models\Subcategory::find($id);
        if ($subcategory) {
            $subcategory->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 404);
        }
    }


    public function deleteProduct(Request $request)
    {
        $id = $request->id;
        $product = \App\Models\Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 404);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
