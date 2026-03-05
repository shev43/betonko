@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Контактні особи</h4>
                    @include('amicms.business._partial.navbar', ['business_id'=>$business_id])

                </div>
                <div class="col">
                    <div class="card-body">
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Персональна інформація</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>
                                </div>
                                <a class="btn btn-outline-primary" href="{{ route('amicms::business.contacts.create', ['business_id'=>$business_id]) }}">Додати запис</a>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Ім'я</th>
                                            <th>Посада</th>
                                            <th>Телефон</th>
                                            <th width="150">Створено</th>
                                            <th width="50"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($contacts_array as $contact)
                                            <tr>
                                                <td class="text-center">{{ $contact->name }}</td>
                                                <td class="text-center">{{ $contact->position }}</td>
                                                <td class="text-center">{{ $contact->phone }}</td>
                                                <td>
                                                    <span>
                                                        @if($contact->deleted_at)<s>{{ $contact->created_at }}</s> @else {{ $contact->created_at }} @endif
                                                    </span>
                                                    <br>{{ $contact->deleted_at }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <a href="#" class="px-2" data-bs-toggle="dropdown">
                                                            <i class="feather icon-more-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @if($contact->deleted_at == null)

                                                                <li>
                                                                    <a href="{{ route('amicms::business.contacts.edit', ['business_id'=>$business_id, 'contact_id'=>$contact->id]) }}" class="dropdown-item">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="feather icon-user-plus"></i>
                                                                            <span class="ms-2">Переглянути запис</span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" data-href="{{ route('amicms::business.contacts.destroy', ['business_id'=>$business_id, 'contact_id'=>$contact->id]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete" class="dropdown-item">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="feather icon-trash-2"></i>
                                                                            <span class="ms-2">Видалити запис</span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <a href="{{ route('amicms::business.restore', ['business_id'=>$business->id]) }}" class="dropdown-item">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="feather icon-trash-2"></i>
                                                                            <span class="ms-2">Відновити запис</span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" data-href="{{ route('amicms::business.contacts.destroy-with-trash', ['business_id'=>$business_id, 'contact_id'=>$contact->id]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete" class="dropdown-item">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="feather icon-trash-2"></i>
                                                                            <span class="ms-2">Видалити запис</span>
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
