@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endsection

@section('content')
  <div class="products-list">
    <div class="products-list__heading">
      <h2 class="heading__title">
        @if(session()->has('keyword'))
          "{{session('keyword') ?? old('keyword')}}"の
        @endif
        商品一覧</h2>
      <form action="/register" method="get" class="register-form">
        <button class="register-form__button">+ 商品を追加</button>
      </form>
    </div>
    <div class="products-list__inner">
      <div class="display-form">
        <form action="/products/search" method="get" class="search-form">
          <input type="text" name="keyword" class="search-form__item" placeholder="商品名で検索" value="{{session('keyword') ?? old('keyword')}}">
          <button class="search-form__button">検索</button>
        </form>
        <div class="sort-form">
          <p class="sort-form__title">価格順で表示</p>
          <form class="sort-form__content" action="/products/sort" method="get">
            <select name="sort" onchange="this.form.submit()" class="sort-form__items">
              <option value="" class="sort-form__item">価格で並び替え</option>
              <option class="sort-form__item" value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順に表示</option>
              <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }} class="sort-form__item">低い順に表示</option>
            </select>
          </form>
          @if(request('sort') == 'desc')
            <form class="sort-form__status" action="/products/sort/reset" method="get">
              @csrf
              <div class="status__content">
                <p class="status-text">高い順に表示</p>
                <button class="status-delete__button">×</button>
              </div>
            </form>
          @endif
          @if(request('sort') == 'asc')
            <form class="sort-form__status" action="/products/sort/reset" method="get">
              @csrf
              <div class="status__content">
                <p class="status-text">低い順に表示</p>
                <button class="status-delete__button">×</button>
              </div>
            </form>
          @endif
        </div>
      </div>
      <div class="products-cards">
        @foreach($products as $product)
        <a href="/products/{{$product['id']}}" class="product-card">
          <div class="product__image">
            <img src="{{ asset('storage/' . $product['image']) }}" alt="画像">
          </div>
          <div class="product__text">
            <p class="product__text-item">{{ $product['name'] }}</p>
            <p class="product__text-item">¥{{$product['price']}}</p>
          </div>
        </a>
        @endforeach
        <div class="pagination">
          <div class="pagination__inner">
              {{ $products->links('vendor.pagination.default') }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection