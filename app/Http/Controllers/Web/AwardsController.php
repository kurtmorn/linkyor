<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AwardsController extends Controller
{
    public function index()
    {
        $awards = ['UXHILL' => []];
        $categories = [
            [
                'name' => 'UXHILL',
                'color' => 'red',
                'award_ids' => [1,2,3,4,5,6,7,8,9,10]
            ]
        ];

        foreach ($categories as $category)
            foreach ($category['award_ids'] as $id)
                $awards[$category['name']][] = config('awards')[$id];

        return view('web.awards.index')->with([
            'awards' => $awards,
            'categories' => $categories
        ]);
    }
}
