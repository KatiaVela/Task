<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CommonQueryScopes
{
    public function scopeSearchByTitle(Builder $query, $title)
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }

    public function scopeFilterByDate(Builder $query, $date)
    {
        return $query->whereDate('date', $date);
    }
}
