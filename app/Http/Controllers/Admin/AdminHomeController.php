<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Faq;
use App\Models\LiveChannel;
use App\Models\OnlinePoll;
use App\Models\Photo;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\Subcriber;
use App\Models\Video;

class AdminHomeController extends Controller
{
    public function index()
    {
        $total_category = Category::count();
        $total_subcategory = SubCategory::count();
        $total_news = Post::count();
        $total_photos = Photo::count();
        $total_videos = Video::count();
        $total_faq = Faq::count();
        $total_polls = OnlinePoll::count();
        $total_live_channels = LiveChannel::count();
        $total_subcribers = Subcriber::count();

        return view('admin.home',compact('total_category','total_subcategory','total_news',
        'total_photos','total_videos','total_faq','total_polls','total_live_channels','total_subcribers'));
    }
}
