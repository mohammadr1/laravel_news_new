<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $newsList = $tag->news()->latest()->paginate(10);
        return view('tags.show', compact('tag', 'newsList'));
    }

}
