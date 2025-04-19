<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Log\Logger;
use Illuminate\Http\Request;

use function Illuminate\Log\log;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

   public function index(){
        $categories = Category::all();

        return view('category.index',compact('categories'));
    }

    public function categoryDatatable(Request $request){
        if($request->ajax()){
            $model = Category::query();
            return DataTables::of($model)
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('d-m-Y h:i:s A');
            })
            ->editColumn('updated_at', function ($model) {
                return $model->updated_at->format('d-m-Y h:i:s A');
            })
            ->addColumn('actions', function ($model) {
                return view('category.action', compact('model'));
            })
            ->toJson();
        }
    }





    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return response()->json(['message' => 'Category created successfully']);
    }


        public function destroy($id)
        {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(['message' => 'Deleted successfully']);
        }



        public function update(Request $request, Category $category)
        {

            $request->validate([
                        'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
                ]);


            $category->name = $request->name;
            $category->save();

            return response()->json([
                'message' => 'Category updated successfully.'
            ]);
        }


        public function show($id)
        {
            $category = Category::find($id);

            if (!$category) {
                return response()->json(['message' => 'Category not found'], 404);
            }

            return response()->json($category);
        }




}
