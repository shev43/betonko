@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="justify-content-md-start">
                        <form action="" autofocus="false" method="get">
                            <div class="input-group mb-3">
                                <input class="form-control" name="q" type="text" placeholder="Пошук за назвою, номером або телефоном клієнта" autofocus="false" autocomplete="false" value="{{ \request()->get('q') }}">
                                <button class="btn btn-outline-secondary icon-search feather" type="submit" style="max-width: 50px; width: 100%;padding: 10px;"></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-grid gap-3 mb-4 d-md-flex justify-content-md-end">
                            <a class="btn btn-outline-primary" href="{{ route('amicms::clients.create') }}">Додати запис</a>
                    </div>
                </div>
            </div>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th width="100">#</th>
                        <th>Ім'я</th>
                        <th width="280">Телефон</th>
                        <th width="100" class="text-center">Створено</th>
                        <th width="50" class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients_array as $client)
                        <tr>
                            <td>{{ $client->profile_number }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="text-dark fw-bold">{{ $client->first_name }} {{ $client->last_name }}</div>
                                </div>

                            </td>
                            <td>{{ $client->phoneFormatted }}</td>
                            <td class="text-center">
                                <span>
                                    @if($client->deleted_at)
                                        <s>
                                            {{ \Carbon\Carbon::parse($client->created_at)->format('d.m.Y H:i') }}
                                        </s><br>
                                        {{ \Carbon\Carbon::parse($client->deleted_at)->format('d.m.Y H:i') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($client->created_at)->format('d.m.Y H:i') }}
                                    @endif
                                </span>
                            </td>

                            <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="px-2" data-bs-toggle="dropdown">
                                            <i class="feather icon-more-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if($client->deleted_at == null)
                                                    <li>
                                                        <a href="{{ route('amicms::clients.edit', ['client_id'=>$client->id]) }}" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <i class="feather icon-user-plus"></i>
                                                                <span class="ms-2">Редагувати запис</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-href="{{ route('amicms::clients.destroy', ['client_id'=>$client->id]) }}" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirm-delete">
                                                            <div class="d-flex align-items-center">
                                                                <i class="feather icon-trash-2"></i>
                                                                <span class="ms-2">Видалити запис</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                            @else
                                                    <li>
                                                        <a href="{{ route('amicms::clients.restore', ['client_id'=>$client->id]) }}" class="dropdown-item">
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

                <div class="d-flex justify-content-end pagination">
                    {!! $clients_array->withQueryString()->links('amicms._partials.paginate') !!}
                </div>


            </div>
        </div>
    </div>
@endsection
