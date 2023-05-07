<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Helper\Helpers;

class TagController extends Controller
{
    public function show($tag_name)
    {
        Helpers::read_json();
        $aLl_posts = Tag::where('tag_name',$tag_name)->get();
        $all_posts_ids = [];
        foreach($aLl_posts as $row)
        {
            $all_posts_ids[] = $row->post_id;
        }

        $all_posts = Post::orderBy('id','desc')->get();

        return view('front.tag',compact('all_posts_ids','all_posts','tag_name'));
    }
}
