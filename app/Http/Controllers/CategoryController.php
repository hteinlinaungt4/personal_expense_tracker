<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        return view('category.index');
    }

    public function create(){
        return view('category.create');
    }

    public function store(Request $request){
        $categories = new Category();
        $categories->name = $request->name;
        $categories->save();
        return view('category.store');
    }

    public function destory(Category $category){
        $category->delete();
        return view('category.index');
    }

    public function edit(Category $category){
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category){
        $category->name = $request->name;
        $category->save();
        return view('category.update');
    }


}
