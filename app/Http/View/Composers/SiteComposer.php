<?php

namespace App\Http\View\Composers;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Message;
use App\Models\Category;
use Illuminate\View\View;
use App\Models\SiteSetting;
use Illuminate\Support\Str;

class SiteComposer
{
    public function compose(View $view)
    {
        $sliders = News::where('position', 'slider')
            ->where('status', 1)
            ->where('published_at', '<=', Carbon::now('Asia/Tehran'))
            ->orderBy('published_at', 'desc')
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

        $messages = Message::where('status', true)
            ->where('status', 1)
            ->where('published_at', '<=', now())
            ->latest()
            ->take(2)
            ->get();

        $setting = SiteSetting::first();
    
        // decode JSON to array
        $socials = $setting->footer_social_links;

        $categories = Category::where('status', 1)->withCount('news')->get();


    // add https to url
    foreach ($socials as &$social) {
        if (!Str::startsWith($social['url'], ['http://', 'https://'])) {
            $social['url'] = 'https://' . $social['url'];
        }
    }
        $view->with(compact('sliders', 'leftSliderNews', 'bottomSliderNews', 'messages', 'setting', 'socials', 'categories'));
    }
}
