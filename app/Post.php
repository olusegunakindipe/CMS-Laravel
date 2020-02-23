<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facade\Storage;

class Post extends Model
{

    use SoftDeletes;

    protected $dates = [
        'published_at'
    ];

    protected $fillable = [
        'title','content','description','image','published_at','category_id','user_id'
    ];


    //delete post image from storage
    public function deleteImage(){
        Storage::delete($this->image);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){ 

        return $this->belongsToMany(Tag::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query){
        return $query->where('published_at', '<=', now());
    }
    public function scopeSearched($query){

        $search = request()->query('search');

        if (!$search){
            return $query->published();
        }
        return $query->published()->where('title', 'LIKE', "%{$search}%");
    }
   

}
