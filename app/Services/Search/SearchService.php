<?php

namespace App\Services\Search;

use Illuminate\Support\Facades\DB;

class SearchService
{
public function searchByTerm($model,$term,$fields = [])
    {
          if (is_null($term)) {
                return $model::paginate(10);
            }
       return $model::where(function ($query) use ($term, $fields) {
        if (is_numeric($term) ) {
           $query->where('id', $term);
        } 
        
            foreach ($fields as $field) {
                $query->orWhere(DB::raw('LOWER('.$field.')'), 'LIKE', '%' . $term . '%');
            }
    })->paginate(10);
       
    }



}


