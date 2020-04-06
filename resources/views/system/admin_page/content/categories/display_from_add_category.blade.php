@extends('system.admin_page.admin')

@section('form_add_category')
    <form class="add_content_from addCategoryFrom" method="post" action="{{route('addCategory')}}">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="bg_detail">
                    <div class="wrap_chain">
                        <a class="a_category" href="{{route('list_categories')}}">
                            Категории
                        </a>
                        <a class="a_detail" href="javascript:void(0)">
                            Добавление категории
                        </a>
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
            <div class="col-md-3 bg_detail selectAddCategory">
                <p>
                    Родительские категории
                </p>
                <select name="parent_category">
                    <option selected disabled></option>
                    @foreach($arCategories as $arItem)
                        <option value="{{$arItem->id}}">{{$arItem->name}}</option>
                    @endforeach
                </select>
            </div>
    </div>
    </form>
@endsection
