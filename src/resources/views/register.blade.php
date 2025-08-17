@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
  <div class="register__inner">
    <h2 class="register__title">商品登録</h2>
    <form action="/register" method="post" class="register-form" enctype="multipart/form-data">
      @csrf
      <div class="form__group">
        <div class="form__group-title">
          <span class="form__label--item">商品名</span>
          <span class="form__label--required">必須</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--text">
            <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
          </div>
          <div class="form__error">
            @if($errors->has('name'))
              @foreach($errors->get('name') as $error)
                <div class="form__error-message">{{ $error }}</div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-title">
          <span class="form__label--item">値段</span>
          <span class="form__label--required">必須</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--text">
            <input type="text" name="price" value="{{ old('price') }}"  placeholder="値段を入力">
          </div>
          <div class="form__error">
            @if($errors->has('price'))
              @foreach($errors->get('price') as $error)
                <div class="form__error-message">{{ $error }}</div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-title">
          <span class="form__label--item">商品画像</span>
          <span class="form__label--required">必須</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--file">
            <label for="image">
              <img class="form-input__img" src="{{ session('image') ? asset('storage/' . session('image')) : '' }} "alt=""><input type="file" name="image" id="image"></label>
            <span class="file-selected__name"></span>
          </div>
          <div class="form__error">
            @if($errors->has('image'))
              @foreach($errors->get('image') as $error)
                <div class="form__error-message">{{ $error }}</div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-title">
          <span class="form__label--item">季節</span>
          <span class="form__label--required">必須</span>
          <span class="form__label--possible">複数選択可</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--checkbox">
            @foreach($seasons as $season)
            <label for="{{ $season['id'] }}"><input id="{{ $season['id'] }}" type="checkbox" name="season[]" value="{{ $season['id'] }}" {{ is_array(old('season')) && in_array($season->id, old('season')) ? 'checked' : '' }}>
            <span class="check-custom"></span>
            {{ $season['name'] }}</label>
            @endforeach
          </div>
          <div class="form__error">
            @if($errors->has('season'))
              @foreach($errors->get('season') as $error)
                <div class="form__error-message">{{ $error }}</div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-title">
          <span class="form__label--item">商品説明</span>
          <span class="form__label--required">必須</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--textarea">
            <textarea name="description" rows="6" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
          </div>
          <div class="form__error">
            @if($errors->has('description'))
              @foreach($errors->get('description') as $error)
                <div class="form__error-message">{{ $error }}</div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
      <div class="form__button">
        <button formaction="/products" formmethod="get" class="form__button-back">戻る</button>
        <button class="form__button-submit">登録</button>
      </div>
    </form>
  </div>

@endsection