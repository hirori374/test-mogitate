<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function products(){
        $products = Product::all();
        session()->forget('tmp_image');
        session()->forget('keyword');
        $products = Product::Paginate(6);

        return view('products', compact('products'));
    }
    public function search(Request $request){
        $products = Product::all();
        session()->put('keyword', $request->keyword);
        $products = Product::with('seasons')->keywordSearch($request->keyword)->paginate(6)->appends($request->all());
        if ($request->filled('sort')) {
            $query->orderBy('price', $request->sort);
        }

        return view('products', compact('products'));
    }
    public function sort(Request $request){
        $products = Product::all();

        $query = Product::query();
        $keyword = session('keyword');
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
            session(['keyword' => $keyword]);
        }

        if ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        }
        $products = $query->paginate(6)->appends($request->query());

        return view('products', compact('products'));
    }
    public function reset(){
        $products = Product::all();
        $query = Product::query();
        $keyword = session('keyword');
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
            session(['keyword' => $keyword]);
        }
        $products = $query->Paginate(6);

        return view('products', compact('products'));
    }
    public function register(){
        $seasons = Season::all();
        $products = Product::with('seasons')->get();

        return view('register', compact('products', 'seasons'));
    }
    public function store(ProductRequest $request){
        $seasons = Season::all();
        $data = $request->only(['name', 'price', 'description']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }
        $product = Product::create($data);
        $product->seasons()->attach($request->season);

        return redirect('/products');
    }
    public function detail($id){
        $seasons = Season::all();
        $products = Product::with('seasons')->get();
        $product = product::find($id);
        return view('detail', compact('product', 'seasons'));
    }
    public function update(ProductRequest $request){
        $seasons = Season::all();
        $data = $request->only(['name', 'price', 'image', 'description']);
        $product = Product::find($request->id);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        if ($request->isMethod('patch') && !isset($data['image'])) {
            $data['image'] = $product->image;
        }

        Product::find($request->id)->update($data);
        $product->seasons()->sync($request->season ?? []);
        return redirect('/products');
    }
    public function delete($id){
        Product::find($id)->delete();

        return redirect('/products');
    }

}
