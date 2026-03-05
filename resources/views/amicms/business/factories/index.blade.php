@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Заводи</h4>
                    @include('amicms.business._partial.navbar', ['business_id'=>$business_id])

                </div>
                <div class="col">
                    <div class="card-body">
                        <div class="mb-4 d-md-flex align-items-center justify-content-between">
                            <div>
                                <h4>Персональна інформація</h4>
                                <p>Основна інформація в цьому обліковому записі.</p>
                            </div>
                            <a class="btn btn-outline-primary" href="{{ route('amicms::business.factories.create', ['business_id'=>$business_id]) }}">Додати запис</a>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="100">#</th>
                                        <th>Назва заводу</th>
                                        <th width="150">Адреса заводу</th>
                                        <th width="150">Створено</th>
                                        <th width="50"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($factories_array as $factory)
                                        <tr>
                                            <td>{{ $factory->factory_number }}</td>
                                            <td>{{ $factory->name }}</td>
                                            <td>{{ $factory->address }}</td>
                                            <td><span>
                                                @if($factory->deleted_at)
                                                    <s>{{ $factory->created_at }}</s>
                                                @else {{ $factory->created_at }} @endif
                                                </span>
                                                <br>{{ $factory->deleted_at }}
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a href="#" class="px-2" data-bs-toggle="dropdown">
                                                        <i class="feather icon-more-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        @if($factory->deleted_at == null)

                                                            <li>
                                                                <a href="{{ route('amicms::business.factories.edit', ['business_id'=>$business_id, 'factory_id'=>$factory->id]) }}" class="dropdown-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-user-plus"></i>
                                                                        <span class="ms-2">Переглянути запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" data-href="{{ route('amicms::business.factories.destroy', ['business_id'=>$business_id, 'factory_id'=>$factory->id]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete" class="dropdown-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-trash-2"></i>
                                                                        <span class="ms-2">Видалити запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <a href="{{ route('amicms::business.factories.restore', ['business_id'=>$business_id, 'factory_id'=>$factory->id]) }}" class="dropdown-item">
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

@endsection

