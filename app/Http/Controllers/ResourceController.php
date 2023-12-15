<?php

namespace App\Http\Controllers;

use App\Models\Resource; 
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Category;

class ResourceController extends Controller
{
    public function index(Request $request){ 
        return Inertia::render('Resources', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resources' => Resource::with('category')->latest()->get(),
            'categories' => Category::all(),

        ]);
    }

    public function store(Request $request)
    {
        /*
        $request->validate([
            'title'=> ['required','max:255'],
            'category_id' =>['required','exists:categories.id'],
            'description'=>['required'],
            'url' =>['required','url'],
        ]);
        */
        Resource::create([
            'title'=> $request->title,
            'link'=> $request->link,
            'description'=> $request->description,
            'category_id'=> $request->category_id,
            'creator_id'=> $request-> user()->id,
        
        ]); 
        return Inertia::location('/'); 
        //return redirect('/');
        
    }
    public function search(Request $request)
    {
        return Resource::query()
        ->when(!empty($request->search),function($query) use ($request){
            return $query->where('title','like',"%$request->search%");
        }) 
        //->orWhere('description','like',"%$request->search%")
        ->when(!empty($request->category),function($query) use ($request){
            return $query->where('category_id',$request->category); 
        })
        ->with('category')
        ->get();
    }
}