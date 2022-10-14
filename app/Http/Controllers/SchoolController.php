<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function all()
    {
       return view('school');
    }

    public function submit(Request $request)
    {
        $name = $request->get('name');

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $despath = public_path().'/uploads/image/';
            $image->move($despath,$imageName);
        }

        $schools = new School();
        $schools->name = $name;
        $schools->image = $imageName;
        $schools->save();
        return response()->json(['status'=>"success" ,'msg'=>"successfull"]);
    }
}
