@extends('layout')

@section('title', 'Каталог товаров')

@section('content')
    <h1 class="mb-4">Каталог товаров</h1>

    <div class="row mb-3">
        <div class="col-md-8">
            <h5>Разделы</h5>
            <ul class="list-group">
                @foreach ($groups as $group)
                    <div>
                        <a href="{{ route('group', $group->id) }}">
                            {{ $group->name }}
                        </a>
                        <span>({{ $group->total_products_count }})</span>
                    </div>
                @endforeach
            </ul>
        </div>

    </div>
    <div class="d-flex mb-3">
        <span class="me-2">Сортировать:</span>
        <a href="?sort=price_asc" class="btn btn-sm ">По цене ↑</a>
        <a href="?sort=price_desc" class="btn btn-sm ">По цене ↓</a>
        <a href="?sort=name_asc" class="btn btn-sm">По названию ↑</a>
        <a href="?sort=name_desc" class="btn btn-sm">По названию ↓</a>
        <form method="GET" class="d-flex align-items-center mb-3">
            <label class="me-2">Показывать по:</label>
            <select name="per_page" class="form-select" style="width: auto;" onchange="this.form.submit()">
                <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                <option value="18" {{ $perPage == 18 ? 'selected' : '' }}>18</option>
            </select>
        </form>
    </div>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('product', $product->id) }}">
                                {{ $product->name }}
                            </a>
                        </h5>
                        <p class="card-text fw-bold">{{ $product->price->price}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
@endsection
