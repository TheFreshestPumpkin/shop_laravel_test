<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['id_parent', 'name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_group');
    }

    public function subgroups()
    {
        return $this->hasMany(Group::class, 'id_parent');
    }

    public function parent()
    {
        return $this->belongsTo(Group::class, 'id_parent');
    }

    public function allSubgroupIds()
    {
        $ids = [$this->id];
        foreach ($this->subgroups as $subgroup) {
            $ids = array_merge($ids, $subgroup->allSubgroupIds());
        }
        return $ids;
    }

    public function getTotalProductsCountAttribute()
    {
        $ids = $this->allSubgroupIds();
        return Product::whereIn('id_group', $ids)->count();
    }

}
