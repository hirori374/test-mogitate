<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =[
      'name',
      'price',
      'image',
      'description',
    ];
    public function seasons()
    {
      return $this->belongsToMany(Season::class, 'product_season', 'product_id', 'season_id');
    }
    public function scopeKeywordSearch($query, $keyword)
    {
      if (!empty($keyword)) {
        $query->where(function($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
        });
      }
      return $query;
    }
}
