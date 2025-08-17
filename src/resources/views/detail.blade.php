@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
  <div class="detail-content">
    <div class="route__link">
      <a href="/products" class="products__link">商品一覧</a>
      <span class="location__link">> {{ $product['name'] }}</span>
    </div>
    <form action="" method="post" enctype="multipart/form-data" class="edit-form">
      @method('PATCH')
      @csrf
      <input type="hidden" name="id" value="{{ $product['id'] }}">
      <div class="form-wrap">
        <div class="form-image">
          <img class="form-input__img" src="{{ asset('storage/' . $product['image']) }}" alt="画像">
          <label for="image"><input type="file" name="image" id="image" value="{{ $product['image'] }}"><span class="file-select__button">ファイルを選択</span><span class="file-selected__name">{{ $product['image'] }}</span></label>
          <div class="form__error">
            @if($errors->has('image'))
              @foreach($errors->get('image') as $error)
                <div class="form__error-message">{{ $error }}</div>
              @endforeach
            @endif
          </div>
        </div>
        <div class="form-items">
          <div class="form-item">
            <div class="form-input__title">商品名</div>
            <input type="text" name="name" class="form-input__text" placeholder="商品名を入力" value="{{ old('name', $product['name']) }}">
            <div class="form__error">
              @if($errors->has('name'))
                @foreach($errors->get('name') as $error)
                  <div class="form__error-message">{{ $error }}</div>
                @endforeach
              @endif
            </div>
          </div>
          <div class="form-item">
            <div class="form-input__title">値段</div>
            <input type="text" name="price" class="form-input__text" placeholder="値段を入力" value="{{ old('price', $product['price']) }}">
            <div class="form__error">
              @if($errors->has('price'))
                @foreach($errors->get('price') as $error)
                  <div class="form__error-message">{{ $error }}</div>
                @endforeach
              @endif
            </div>
          </div>
          <div class="form-item">
            <div class="form-input__title">季節</div>
            <div class="form-input__checkbox">
              @foreach($seasons as $season)
              <label for="{{ $season['id'] }}"><input id="{{ $season['id'] }}" type="checkbox" name="season[]" value="{{ $season->id }}"
              @if(( is_array(old('season')) && in_array($season->id, old('season')))||(isset($product) && $product->seasons->contains($season->id))) checked @endif>
              <span class="check-custom"></span>{{ $season['name'] }}</label>
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
      </div>
      <div class="form-description">
        <label class="form-input__title">商品説明</label>
        <textarea name="description" rows="8" class="form-input__textarea" placeholder="商品の説明を入力">{{ old('description', $product['description']) }}</textarea>
        <div class="form__error">
          @if($errors->has('description'))
            @foreach($errors->get('description') as $error)
              <div class="form__error-message">{{ $error }}</div>
            @endforeach
          @endif
        </div>
      </div>
      <div class="form__button">
        <div class="edit-form__button">
          <button class="edit-form__button-back" formaction="/products" formmethod="get">戻る</button>
          <button class="edit-form__button-submit" formaction="/products/{{$product['id']}}/update" formmethod="post">変更を保存</button>
        </div>
      </div>
    </form>
    <form action="/products/{{$product['id']}}/delete" method="post" class="delete-form">
    @method('DELETE')
    @csrf
      <div class="delete-form__button">
        <button class="delete-form__button-submit"><img src="{{ asset('storage/react-icons/ti/TiTrash.png') }}" alt=""></button>
      </div>
    </form>
  </div>
@endsection