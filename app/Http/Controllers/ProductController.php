<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function show(){                //show data

        $data = Product::all();
        return $data;
    }


    function create(Request $request){      //create
        $obj = new Product();
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->stock = $request->stock;
        $obj->category_id = $request->category_id;

        $obj->save();
        return response()->json($obj);

    }


    function delete(Request $request){          // delete
        
        $record = Product::find($request->id);
        if($record){
            $record->delete();
            return "deleted id: $record->id  with name: $record->name ";
        }
        return "record not found";
    }   

    function update(Request $request){              // update
        $record = Product::find($request->id);
        if($record)
            $temp = $record->name;
            $record->name = $request->name;
            $record->update(); 
            return "Name updated from $temp to $request->name";
    }

}
