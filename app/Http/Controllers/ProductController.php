<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function allproduct()
    {
        $product = Product::get();

        return response()->json(['product' => $product]);
    }

    public function saveproduct(Request $request)
    {

        $msg = [
            'product_name.required' => 'Product Name is required',
            'product_title.required' => 'Product Title is required',
            'product_desc.required' => 'Product Description is required',
            'product_image.required' => 'Product Image is required',

        ];
        $validator = Validator::make($request->all(), [
            'product_name' => 'required', 'product_title' => 'required',
            'product_desc' => 'required',
        ], $msg);

        $product_name = $request->get('product_name');
        $product_title = $request->get('product_title');
        $product_desc = $request->get('product_desc');
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $despath = public_path() . "/uploads/";
            $image->move($despath, $imageName);
        }else {
            $imageName = 'no_img';
        }
        if ($validator->passes()) {
            $products = new Product();
            $products->product_name = $product_name;
            $products->product_image = "http://localhost/apitest/public/uploads/" . $imageName;
            $products->product_title = $product_title;
            $products->product_desc = $product_desc;
            $products->save();
            return response()->json(['status' => "success", 'products' => $products, 'msg' => "product added successfull"]);
        } else {
            return response()->json(['status' => "error",'error' => $validator->errors()->getMessageBag()->toArray()], 401);
        }
    }

    public function showproduct($id)
    {
        $show = Product::find($id);

        return response()->json(['show' => $show], 200);
    }

    public function updateproduct(Request $request, $id)
    {
        $product_name = $request->get('product_name');
        $product_title = $request->get('product_title');
        $product_desc = $request->get('product_desc');

        $old = Product::find($id)->product_image;
        if ($request->hasFile('product_image')) {
            $path = public_path() . '/uploads/' . $old;
            if (file_exists($path)) {
                unlink($path);
            }
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $despath = public_path() . '/uploads/';
            $image->move($despath, $imageName);
            $profile = "http://localhost/apitest/public/uploads/" . $imageName;
        } else {
            $profile = $old;
        }

        $update = Product::where('id', $id)->first();
        $update->product_name = $product_name;
        $update->product_image = $profile;
        $update->product_title = $product_title;
        $update->product_desc = $product_desc;
        $update->save();
        return response()->json(['status' => "success", 'products' => $update, 'msg' => "Product update successfull"]);
        //        return response()->json(['status'=>"success" ,'msg'=>$profile]);
    }

    public  function deleteproduct($id)
    {
        $deletes = Product::where('id', $id)->first();
        $path = public_path() . '/uploads/' . $deletes->product_image;
        $paths = "http://localhost/apitest/public/uploads/" . $path;
        if (file_exists($paths)) {
            unlink($paths);
        }
        $deletes->delete();
        return response()->json(['delete' => $deletes, 'msg' => "product delete successfull"], 200);
    }

    public function searchproduct($name)
    {
        $result = Product::where('product_name', 'LIKE', '%' . $name . '%')->get();

        if (count($result)) {
            return Response()->json(['result' => $result], 200);
        } else {
            return response()->json(['Result' => 'No Data not found'], 404);
        }
    }

    public function Status(Request $request, $id)
    {
        try {
            $status = Product::where('id', $id)->first();
            if ($status->status == "Active") {
                $status->status = "Inactive";
            } else {
                $status->status = "Active";
            }
            $status->save();
            return response()->json(['status' => "success", 'msg' => "Status change successfully"]);
        } catch (Exception $e) {
            return response()->json(['status' => "error", 'msg' => $e->getMessage()]);
        }
    }
}
