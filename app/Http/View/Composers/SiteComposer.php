<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\News;
use App\Models\Message;
use App\Models\SiteSetting;
use Carbon\Carbon;

class SiteComposer
{
    public function compose(View $view)
    {
        $sliders = News::where('position', 'slider')
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
            ->where('published_at', '<=', now())
            ->latest()
            ->take(2)
            ->get();

        $setting = SiteSetting::first();

        $view->with(compact('sliders', 'leftSliderNews', 'bottomSliderNews', 'messages', 'setting'));
    }
}
