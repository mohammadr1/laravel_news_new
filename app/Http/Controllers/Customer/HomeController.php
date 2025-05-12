<?php

namespace App\Http\Controllers\Customer;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home(){
        $sliders = Slider::where('is_active', true)
        ->orderBy('publish_date', 'desc')
        ->take(5)
        ->get();

        $leftSliderNews = News::where('position', 'slider_side')
        ->where('status', 1)
        ->where('published_at', '<=', Carbon::now('Asia/Tehran'))
        ->orderBy('published_at', 'desc')
        ->take(2)
        ->get();

    $bottomSliderNews = News::where('position', 'slider_bottom')
        ->where('status', 1)
        ->where('published_at', '<=', Carbon::now('Asia/Tehran'))
        ->orderBy('published_at', 'desc')
        ->take(4)
        ->get();

        
        return view('customer.home', compact('sliders', 'leftSliderNews', 'bottomSliderNews'));
    }
}
