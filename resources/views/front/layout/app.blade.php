@if (!session()->get('session_short_name'))
    @php
        $current_short_name = $global_short_name;
    @endphp
@else    
    @php
        $current_short_name = session()->get('session_short_name');
    @endphp
@endif

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>News Portal Website</title>

    <link rel="icon" type="image/png" href="{{ asset('uploads/favicon.png') }}">

    @include('front.layout.styles')

    @include('front.layout.scripts')

    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6212352ed76fda0a"></script>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-84213520-6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-84213520-6');
    </script>

</head>

<body>
    <div class="top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li class="today-text">{{TODAY}}: {{  \Carbon\Carbon::now()->format('d m Y H:i:s')  }}</li>
                        <li class="email-text">adminhk@dev.com</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="right">
                        @php
                            $current_lang_id = \App\Models\Language::where('short_name',$current_short_name)->first()?->id;
                            $page_data = \App\Models\Page::where('id',$current_lang_id)->first();
                        @endphp
                        @if($page_data?->faq_status == 'Show')
                        <li class="menu"><a href="{{ route('faq') }}">{{$page_data->faq_title }}</a></li>
                        @endif
                        @if($page_data?->about_status == 'Show')
                        <li class="menu"><a href="{{ route('about') }}">{{ $page_data->about_title }}</a></li>
                        @endif

                        @if($page_data?->contact_status == 'Show')
                        <li class="menu"><a href="{{ route('contact') }}">{{ $page_data->contact_title }}</a></li>
                        @endif
                        @if($page_data?->login_status == 'Show')
                        <li class="menu"><a href="{{ route('login') }}">{{ $page_data->login_title }}</a></li>
                        @endif
                         {{-- Change language  --}}
                        <li>
                            <div class="language-switch">
                                <form action="{{ route('front_language') }}" method="post">
                                    @csrf
                                    <select name="short_name" onchange="this.form.submit()">
                                        @foreach ($global_language_data as $item)
                                        <option value="{{ $item->short_name}}" @if($item->short_name == $current_short_name) selected @endif>
                                            {{$item->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </li>
                        {{-- end change language --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="heading-area">
        <div class="container">
            <div class="row">
                <div class="col-md-4 d-flex align-items-center">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('uploads/logo.png') }}" alt="" >
                        </a>
                    </div>
                </div>
                {{-- Top Advertisements --}}
                <div class="col-md-8">
                    @if($global_top_ad_data->top_ad_status == 'Show')
                    <div class="ad-section-1">
                        @if($global_top_ad_data->top_ad_url == '')
                        <a href="">
                            <img src="{{ asset('uploads/' .$global_top_ad_data->top_ad) }}" alt="">
                        </a>
                        @else
                        <a href="{{ $global_top_ad_data->top_ad_url}}">
                            <img src="{{ asset('uploads/' .$global_top_ad_data->top_ad)  }}" alt="">
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                {{-- End :Top Advertisements  --}}
            </div>
        </div>
    </div>

    @include('front.layout.nav')

    @yield('main_content')



    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="item">
                        <h2 class="heading">{{ FOOTER_COL_1_HEADING }}</h2>
                        <p>
                            {{FOOTER_COL_1_TEXT}}
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="item">
                        <h2 class="heading">{{FOOTER_COL_2_HEADING}}</h2>
                        <ul class="useful-links">
                            <li><a href="{{ route('home') }}">{{HOME}}</a></li>
                            @php
                            $current_lang_id = \App\Models\Language::where('short_name',$current_short_name)->first()?->id;
                            $page_data = \App\Models\Page::where('id',$current_lang_id)->first();
                            @endphp
                            @if($page_data?->terms_status == 'Show')
                            <li><a href="{{ route('terms') }}">{{ $page_data->terms_title}}</a></li>
                            @endif
                            @if($page_data?->privacy_status == 'Show')
                            <li><a href="{{ route('privacy') }}">{{ $page_data->privacy_title}}</a></li>
                            @endif
                            @if($page_data?->disclaimer_status == 'Show')
                            <li><a href="{{ route('disclaimer') }}">{{ $page_data->disclaimer_title}}</a></li>
                            @endif
                            @if($page_data?->contact_status == 'Show')
                            <li><a href="{{ route('contact') }}">{{ $page_data->contact_title}}</a></li>
                            @endif
                            
                            
                        </ul>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="item">
                        <h2 class="heading">{{FOOTER_COL_3_HEADING}}</h2>
                        <div class="list-item">
                            <div class="left">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="right">
                                {{ FOOTER_ADDRESS }}
                            </div>
                        </div>
                        <div class="list-item">
                            <div class="left">
                                <i class="far fa-envelope"></i>
                            </div>
                            <div class="right">
                                {{FOOTER_EMAIL}}
                            </div>
                        </div>
                        <div class="list-item">
                            <div class="left">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="right">
                                {{FOOTER_PHONE}}
                            </div>
                        </div>
                        <ul class="social">
                            @foreach ($global_social_item_data as $item)
                            <li><a href="{{ $item->url }}" target="_blank"><i class="{{ $item->icon }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="item">
                        <h2 class="heading">{{ FOOTER_COL_4_HEADING }}</h2>
                        <p>
                            {{ NEWSLETTER_TEXT }}
                        </p>
                        <form action="{{ route('subcribe')}}" method="" class="form_subcribe_ajax">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="email" class="form-control"
                                placeholder="{{ EMAIL_ADRESS }}">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="{{SUBCRIBE_NOW}}">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="copyright">
        {{ COPYRIGHT }}
    </div>

    <div class="scroll-top">
        <i class="fas fa-angle-up"></i>
    </div>

    @include('front.layout.scripts_footer')

    {{-- Ajax Start --}}
    <script>
        (function($){
                    $(".form_subscribe_ajax").on('submit', function(e){
                        e.preventDefault();
                        $('#loader').show();
                        var form = this;
                        $.ajax({
                            url:$(form).attr('action'),
                            method:$(form).attr('method'),
                            data:new FormData(form),
                            processData:false,
                            dataType:'json',
                            contentType:false,
                            beforeSend:function(){
                                $(form).find('span.error-text').text('');
                            },
                            success:function(data)
                            {
                                $('#loader').hide();
                                if(data.code == 0)
                                {
                                    $.each(data.error_message, function(prefix, val) {
                                        $(form).find('span.'+prefix+'_error').text(val[0]);
                                    });
                                }
                                else if(data.code == 1)
                                {
                                    $(form)[0].reset();
                                    iziToast.success({
                                        title: '',
                                        position: 'topRight',
                                        message: data.success_message,
                                    });
                                }

                            }
                        });
                    });
                })(jQuery);
    </script>
    <div id="loader"></div>

    {{-- Ajax End --}}

    @if($errors->any())
    @foreach($errors->all() as $error)
    <script>
        iziToast.error({
            title: '',
            position: 'bottomRight',
            message: '{{ $error }}',
            });
    </script>
    @endforeach
    @endif

    @if(session()->get('error'))
    <script>
        iziToast.error({
            title: '',
            position: 'bottomRight',
            message: '{{ session()->get('error') }}',
    });

    </script>
    @endif

    @if(session()->get('success'))
        <script>
            iziToast.success({
                    title: '',
                    position: 'topRight',
                    message: '{{ session()->get('success') }}',
        });

        </script>
    @endif
    


    @yield('map_scripts')


</body>

</html>
