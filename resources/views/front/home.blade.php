@extends('layouts.front')

@section('title')
    السوق
@endsection
@section('slider')
    <div id="displayTop" class="displaytopthree">
        <div class="container">
            <div class="row">
                <div class="nov-row  col-lg-12 col-xs-12">
                    <div class="nov-row-wrap row">
                        <div class="nov-html col-xl-3 col-lg-3 col-md-3">
                            <div class="block">
                                <div class="block_content">

                                </div>
                            </div>
                        </div>
                        <div id="nov-slider" class="slider-wrapper theme-default col-xl-9 col-lg-9 col-md-9 col-md-12"
                             data-effect="random" data-slices="15" data-animspeed="500" data-pausetime="10000"
                             data-startslide="0" data-directionnav="false" data-controlnav="true"
                             data-controlnavthumbs="false" data-pauseonhover="true" data-manualadvance="false"
                             data-randomstart="false">
                            <div class="nov_preload">
                                <div class="process-loading active">
                                    <div class="loader">
                                        @isset($sliders)
                                            @foreach($sliders as $slider)
                                                <div class="dot"></div>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                            </div>
                            <div class="nivoSlider">
                                @isset($sliders)
                                    @foreach($sliders as $slider)
                                        <a href="#">
                                            <img
                                                src="{{$slider -> photo }}"
                                                alt="" title="#htmlcaption_42">
                                        </a>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('content')
{{--    <div id="main">--}}
{{--        <section id="content" class="page-home pagehome-three">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="nov-row spacing-30 mt-15 col-lg-12 col-xs-12">--}}
{{--                        <div class="nov-row-wrap row">--}}
{{--                            <div class="nov-image col-lg-4 col-md-4">--}}
{{--                                <div class="block">--}}
{{--                                    <div class="block_content">--}}
{{--                                        <div class="effect">--}}
{{--                                            <a href="#"> <img class="img-fluid"--}}
{{--                                                              src="assets/images/1.jpg"--}}
{{--                                                              alt="banner3-1" title="banner3-1"></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--    </div>--}}

@stop
