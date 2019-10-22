@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="container">
        @auth
            <div class="row">
                <div class="col-8">
                    <div class="mb-3 d-flex justify-content-center">
                        <a href="{{ route('post.create') }}" class="btn btn-primary">{{ __('Добавить новую запись') }}</a>
                    </div>
                </div>
                <div class="col-4">

                </div>
            </div>
        @endauth
        <div class="row">
            <div class="col-12">
                <post-editor :read-only="true"
                             content="{{ $post->content }}"
                             title="{{ $post->title }}"
                             author="{{ $post->author->name }}"
                             created-at="{{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->format('d.m.Y H:i:s') }}"
                             link="{{ route('post.index') }}"
                             link-name="Назад"
                ></post-editor>
            </div>
        </div>
    </div>
@endsection
