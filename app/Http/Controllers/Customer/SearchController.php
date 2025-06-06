<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use App\Models\Tag;


class SearchController extends Controller
{
        public function index(Request $request)
    {
        $query = $request->input('q');

         if (!$query) {
            return back()->with('warning', 'لطفاً عبارتی برای جستجو وارد کنید.');
        }else{
        
            // جستجو در خبرها
            $newsResults = News::where('title', 'like', "%{$query}%")
                ->orWhere('body', 'like', "%{$query}%")
                ->latest()
                ->take(10)
                ->get();

            // جستجو در دسته‌بندی‌ها
            $categoryResults = Category::where('title', 'like', "%{$query}%")
                ->latest()
                ->take(10)
                ->get();

            // جستجو در تگ‌ها
            $tagResults = Tag::where('name', 'like', "%{$query}%")
                ->latest()
                ->take(10)
                ->get();

            return view('customer.search.index', compact('query', 'newsResults', 'categoryResults', 'tagResults'));
        }
    }
}
