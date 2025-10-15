<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function show($id, Request $request)
    {
        $group = Group::findOrFail($id);
        $groupIds = $this->getAllSubgroupIds($group);

        $sort = $request->get('sort', 'name_asc');
        [$field, $direction] = explode('_', $sort);

        $query = Product::with(['price', 'group'])->whereIn('id_group', $groupIds);

        if ($field === 'price') {
            $query->orderBy(
                DB::raw('(SELECT price FROM prices WHERE prices.id_product = products.id LIMIT 1)'),
                $direction
            );
        } else {
            $query->orderBy('products.name', $direction);
        }

        $perPage = $request->get('per_page', 6);
        $products = $query->paginate($perPage)->withQueryString();

        $subgroups = Group::where('id_parent', $id)->get()->map(function ($subgroup) {
            $count = $this->countProductsRecursive($subgroup);
            $subgroup->total_products = $count;
            return $subgroup;
        });

        return view('group', compact('group', 'subgroups', 'products', 'sort', 'perPage'));
    }

    private function getAllSubgroupIds($group)
    {
        $ids = [$group->id];
        foreach ($group->subgroups as $subgroup) {
            $ids = array_merge($ids, $this->getAllSubgroupIds($subgroup));
        }
        return $ids;
    }

    private function countProductsRecursive($group)
    {
        $count = $group->products()->count();
        foreach ($group->subgroups as $subgroup) {
            $count += $this->countProductsRecursive($subgroup);
        }
        return $count;
    }
}
