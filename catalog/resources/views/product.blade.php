@extends('layout')

@section('title', $product->name)

@section('content')
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
            @foreach($breadcrumbs as $crumb)
                <li class="breadcrumb-item">
                    <a href="{{ route('group', $crumb->id) }}">{{ $crumb->name }}</a>
                </li>
            @endforeach
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">{{ $product->name }}</h3>
            @if(isset($product->price))
                <p class="card-text fs-4 fw-bold">{{ $product->price->price}} </p>
            @endif
            <p >Группа: {{ $product->group->name }}</p>
        </div>
    </div>
@endsection
