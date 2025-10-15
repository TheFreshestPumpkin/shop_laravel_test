<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name_asc');

        $groups = Group::where('id_parent', 0)
            ->withCount('products')
            ->get();
        $products = Product::with('price');
        switch ($sort) {
            case 'price_asc':
                $products->join('prices', 'products.id', '=', 'prices.id_product')
                    ->orderBy('prices.price', 'asc')
                    ->select('products.*');
                break;

            case 'price_desc':
                $products->join('prices', 'products.id', '=', 'prices.id_product')
                    ->orderBy('prices.price', 'desc')
                    ->select('products.*');
                break;

            case 'name_desc':
                $products->orderBy('products.name', 'desc');
                break;

            default:
                $products->orderBy('products.name', 'asc');
                break;
        }

        $perPage = $request->get('per_page', 6);
        $products = $products->paginate($perPage)->withQueryString();

        return view('index', compact('groups', 'products', 'sort','perPage'));
    }
}
