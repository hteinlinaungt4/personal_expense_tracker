<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;

use function Illuminate\Log\log;

class CategoryController extends Controller
{

   public function index(){
        $categories = Category::all();

        return view('category.index',compact('categories'));
    }



    public function store(Request $request){

        Logger($request->all());
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
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'message' => 'Category updated successfully.',
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'created_at' => $category->created_at->format('d-m-Y h:i:s A'),
                    'updated_at' => $category->updated_at->format('d-m-Y h:i:s A'),
                ],
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
