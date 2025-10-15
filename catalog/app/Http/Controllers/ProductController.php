<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('price', 'group')->findOrFail($id);
        $breadcrumbs = $this->getBreadcrumbs($product->group);

        return view('product', compact('product', 'breadcrumbs'));
    }

    private function getBreadcrumbs($group)
    {
        $breadcrumbs = [];
        while ($group) {
            array_unshift($breadcrumbs, $group);
            $group = $group->parent;
        }
        return $breadcrumbs;
    }
}
