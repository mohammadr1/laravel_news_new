<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class NewsController extends Controller
{
    public function show(News $news)
    {
        $news->load('tags');

        $categories = Category::where('status', 1)->withCount('news')->get();

        $news->increment('views');
        


        return view('customer.news.show', compact('news', 'categories'));
    }


}
