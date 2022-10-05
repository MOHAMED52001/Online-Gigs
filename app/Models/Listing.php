<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{

    protected $fillable = [
        'title', 'user_id', 'logo', 'company', 'location', 'website', 'email', 'tags', 'description'
    ];

    use HasFactory;


    public function scopeFilter($query, $filter)
    {
        if ($tag = $filter['tag'] ?? false) {
            $query->where('tags', 'like', '%' . $tag . '%');
        }

        if ($search = $filter['search'] ?? false) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '% ')
                ->orWhere('company', 'like', '%' . $search . '%');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
