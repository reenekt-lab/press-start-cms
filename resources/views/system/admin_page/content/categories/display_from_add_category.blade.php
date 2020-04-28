@extends('system.admin_page.admin')

@section('form_add_category')
    <form class="add_content_from addCategoryFrom" method="post" action="{{route('addCategory',$id)}}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="bg_detail">
                    <div class="wrap_chain">
                        @foreach($arChain as $key=>$value)
                            <a
                                @if($key=='/')
                                    href="{{route('list_categories')}}"
                                @else
                                    href=""
                                @endif
                            >
                                {{$value}}
                            </a>
                        @endforeach
                    </div>
                    @if ($errors->any())
                        <div class="error_list">
                            <p class="title_error">
                                Ошибка:
                            </p>
                            @error('name_category')
                            <p>
                                {{$message}}
                            </p>
                            @enderror
                        </div>
                    @endif
                    <div>
                        <p class="add_content_title">
                            Название
                        </p>
                        <input name="name_category" type="text" value="{{old('name_category')}}">
                    </div>
                    @if(Gate::allows('access_to_edit'))
                        <input class="btn btn-primary btn_preloader" type="submit" value="Сохранить">
                    @endif
                </div>
            </div>
        </div>
    </form>
@endsection
