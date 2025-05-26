<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\News;
use App\Models\Message;
use App\Models\SiteSetting;
use Carbon\Carbon;
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

    // add https to url
    foreach ($socials as &$social) {
        if (!Str::startsWith($social['url'], ['http://', 'https://'])) {
            $social['url'] = 'https://' . $social['url'];
        }
    }
        $view->with(compact('sliders', 'leftSliderNews', 'bottomSliderNews', 'messages', 'setting', 'socials'));
    }
}
