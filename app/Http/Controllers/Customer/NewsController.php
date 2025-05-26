<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show(News $news)
    {
        return view('customer.news.show', compact('news'));
    }
}
