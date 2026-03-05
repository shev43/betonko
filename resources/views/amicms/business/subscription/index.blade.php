@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Підписки</h4>
                    @include('amicms.business._partial.navbar', ['business_id'=>$business->id])

                </div>
                <div class="col">
                    <div class="card-body">
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Основна інформація</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th class="py-3">Власник</th>
                                            <td class="py-3">
                                                <p>{{ $business->seller->first_name }} {{ $business->seller->last_name }}<br>{{ $business->seller->email }}<br>{{ $business->seller->phone }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Бізнес</th>
                                            <td class="py-3">
                                                <p>{{ $business->name }}</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="py-3">План:</th>
                                            <td class="py-3">
                                                @if(!empty($business->subscription) && $business->subscription->isActive())
                                                    Експерт
                                                @else
                                                    Базовий
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="py-3">
                                                @if(!empty($business->subscription) && $business->subscription->isActive())
                                                    Активний до
                                                @else
                                                    Активировать на
                                                @endif
                                            </th>
                                            <td class="py-3">
                                                @if(!empty($business->subscription) && $business->subscription->isActive())
                                                    {{ \Carbon\Carbon::parse($business->subscription->active_to)->format('d.m.Y') }}
                                                @else
                                                    <form action="{{ route('amicms::business.subscription.subscribe', ['business_id' => $business->id]) }}" method="post">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <div class="form-group">
                                                                    <select class="selectpicker" name="period" data-style="form-control">
                                                                        @for($i=1;$i<=12;$i++)
                                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-5">
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-success">Активувати</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                @endif
                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>



                                        <br>
                                        <h4>Історія</h4>
                                        <hr>

                                        @if($business->subscription && count($business->subscription_history) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-data3">
                                                    <thead>
                                                    <tr>
                                                        <th>Ідентифікатор замовлення</th>
                                                        <th>Статус</th>
                                                        <th>Активовано до</th>
                                                        <th>Додано вручну</th>
                                                        <th>Створено</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($business->subscription_history as $history)
                                                        <tr>
                                                            <td>{{ $history->order_number }}</td>
                                                            <td>
                                                                @if($history->status == 'Approved')
                                                                    <span class="badge badge-success">Експерт план активовано</span>
                                                                @else
                                                                    <span class="badge badge-danger">Експерт план не активовано</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($history->activated_to)->format('d.m.Y') }}</td>
                                                            <td>
                                                                @if($history->added_manually == '1')
                                                                    Так
                                                                @else
                                                                    Ні
                                                                @endif
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d.m.Y h:i:s') }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-warning" role="alert">
                                                Немає історії підписок
                                            </div>
                                        @endif
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


