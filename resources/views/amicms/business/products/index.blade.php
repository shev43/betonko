@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Продукція</h4>
                    @include('amicms.business._partial.navbar', ['business_id'=>$business_id])

                </div>
                <div class="col">
                    <div class="card-body">
                        <div class="mb-4 d-md-flex align-items-center justify-content-between">
                            <div>
                                <h4>Персональна інформація</h4>
                                <p>Основна інформація в цьому обліковому записі.</p>
                            </div>
                            <a class="btn btn-outline-primary" href="{{ route('amicms::business.products.create', ['business_id'=>$business_id]) }}">Додати запис</a>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th width="100">#</th>
                                            <th width="150">Назва заводу</th>
                                            <th>Продукт</th>
                                            <th width="100">Ціна</th>
                                            <th width="150">Створено</th>
                                            <th width="50"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products_array as $product)
                                            <tr>
                                                <td>{{ $product->product_number }}</td>
                                                <td>{{ $product->factory->name }}</td>
                                                <td>
                                                    <div><strong>Марка: </strong>{{ Config::get('product.mark.' . $product->mark) }}</div>
                                                    <div><strong>Клас: </strong>{{ Config::get('product.class.' . $product->class) }}</div>
                                                    <div><strong>Водостійкість: </strong>{{ Config::get('product.water_resistance.' . $product->water_resistance) }}</div>
                                                    <div><strong>Зимова добавка: </strong>{{ Config::get('product.winter_supplement.' . $product->winter_supplement) }}</div>
                                                </td>
                                                <td>{{ $product->price }}</td>
                                                <td>
                                                <span>
                                                    @if($product->deleted_at)
                                                        <s>{{ $product->created_at }}</s>
                                                    @else
                                                        {{ $product->created_at }} @endif
                                                </span>
                                                    <br>
                                                    {{ $product->deleted_at }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <a href="#" class="px-2" data-bs-toggle="dropdown">
                                                            <i class="feather icon-more-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @if($product->deleted_at == null)
                                                                <li>
                                                                    <a href="{{ route('amicms::business.products.edit', ['business_id'=>$business_id, 'product_id'=>$product->id]) }}" class="dropdown-item">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="feather icon-user-plus"></i>
                                                                            <span class="ms-2">Переглянути запис</span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" data-href="{{ route('amicms::business.products.destroy', ['business_id'=>$business_id, 'product_id'=>$product->id]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete" class="dropdown-item">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="feather icon-trash-2"></i>
                                                                            <span class="ms-2">Видалити запис</span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <a href="{{ route('amicms::business.products.restore', ['business_id'=>$business_id, 'product_id'=>$product->id]) }}" class="dropdown-item">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="feather icon-trash-2"></i>
                                                                            <span class="ms-2">Відновити запис</span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            @endif


                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


