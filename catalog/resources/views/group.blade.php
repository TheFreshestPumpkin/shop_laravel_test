@extends('layout')

@section('title', $group->name)

@section('content')
    <h2 class="mb-4">{{ $group->name }}</h2>

    @if($subgroups->count() > 0)
        <div class="mb-4">
            <h4>Подкатегории:</h4>
            <div class="list-group">
                @foreach ($subgroups as $subgroup)
                    <div>
                        <a href="{{ route('group', $subgroup->id) }}" >
                            {{ $subgroup->name }}
                        </a>
                        <span>({{ $subgroup->total_products_count }})</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="d-flex mb-3">
        <span class="me-2">Сортировать:</span>
        <a href="?sort=price_asc" class="btn btn-sm">По цене ↑</a>
        <a href="?sort=price_desc" class="btn btn-sm">По цене ↓</a>
        <a href="?sort=name_asc" class="btn btn-sm ">По названию ↑</a>
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
                        @if(isset($product->price))
                            <p class="card-text fw-bold">{{$product->price->price}}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>

@endsection
