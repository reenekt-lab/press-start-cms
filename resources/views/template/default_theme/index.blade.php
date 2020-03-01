@extends(Helper::usingTheme('header'))

@section('content')
    {{--Просто секция хз с чем--}}
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 bg_carousel">
                    <div class="row">
                        <div class="col-md-6 d-flex align-items-center">
                            <div>
                                <div class="wrap_carousel_title">
                                    @if($arResult!=null)
                                        <p>
                                            {{$arResult->title}}
                                        </p>
                                    @endif
                                </div>
                                <div class="wrap_anons_text">
                                    @if($arResult!=null)
                                        <p>
                                            {!! Helper::cutText($arResult->content,143,'...') !!}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" style="padding-top: 30px">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row wrap_block_under_poster w-100" style="display: flex;flex-wrap: wrap">
                                <div class="col-8 col_block_under_poster">
                                    <div>
                                        @if($arCategoryFirstBlock!=null)
                                            <h3>
                                                <b>
                                                    {{$arCategoryFirstBlock->name}}
                                                </b>
                                            </h3>
                                        @endif
                                        @if($arContentFirstBlock!=null)
                                            @foreach($arContentFirstBlock as $arFirstContent)
                                                <p class="title_shit">
                                                    {{$arFirstContent->title}}
                                                </p>
                                                <p>
                                                    {!! $arFirstContent->content !!}
                                                </p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4 d-flex justify-content-center align-items-center col_block_under_poster_another">
                                    JUST TEXT
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row w-100 wrap_block_under_poster" style="display: flex;flex-wrap: wrap">
                                <div class="col-8 col_block_under_poster">
                                    <div>
                                        @if($arCategorySecondBlock!=null)
                                            <h3>
                                                <b>
                                                    {{$arCategorySecondBlock->name}}
                                                </b>
                                            </h3>
                                        @endif
                                        @if($arContentSecondBlock!=null)
                                            @foreach($arContentSecondBlock as $arItem)
                                                <p class="title_shit">
                                                    {{$arItem->title}}
                                                </p>
                                                <p>
                                                    {!! $arItem->content !!}
                                                </p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4 d-flex justify-content-center align-items-center col_block_under_poster_another">
                                    JUST TEXT
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--Секция с блогом--}}
    <section>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="wrap_title">
                        @if($arGreatePeople!=null)
                            <h3>{{$arGreatePeople->name}}</h3>
                        @endif
                    </div>
                    @if($arContent!=null)
                        @foreach($arContent as $arItem)
                            <div class="wrap_content_help">
                                <h5>
                                    {{$arItem->title}}
                                </h5>
                                <p>
                                    {!! $arItem->content !!}
                                </p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
