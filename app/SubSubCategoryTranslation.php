<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubCategoryTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'category_id'];

    public function category(){
    	return $this->belongsTo(SubSubCategory::class);
    }
}
