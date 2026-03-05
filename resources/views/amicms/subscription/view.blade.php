@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="card-heading border bottom">


        </div>
        <div class="card-block">
            <div class="card-body card-block">
                <div class="form-group">
                    <h2 class="display-5 my-3">Основна інформація</h2>
                    <hr>

                    <div class="row form-group">
                        <div class="col col-md-4">
                            <label for="end_date_of_delivery" class=" form-control-label"><b>Власник</b></label>
                        </div>
                        <div class="col-12 col-md-8">
                            <p>{{ $business->seller->first_name }} {{ $business->seller->last_name }}<br>{{ $business->seller->email }}<br>{{ $business->seller->phone }}</p>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-4">
                            <label for="end_date_of_delivery" class=" form-control-label"><b>Бізнес</b></label>
                        </div>
                        <div class="col-12 col-md-8">
                            <p>{{ $business->name }}</p>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-4">
                            <label for="end_date_of_delivery" class=" form-control-label"><b>План:</b></label>
                        </div>
                        <div class="col-12 col-md-8">
                            <p>
                            @if(!empty($business->subscription) && $business->subscription->isActive())
                                Експерт
                            @else
                                Базовий
                            @endif
                            </p>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-4">
                            @if(!empty($business->subscription) && $business->subscription->isActive())
                                <label for="end_date_of_delivery" class=" form-control-label"><b>Активний до</b></label>
                            @else
                                <label for="end_date_of_delivery" class=" form-control-label"><b>Активировать на</b></label>
                            @endif
                        </div>
                        <div class="col-12 col-md-8">
                            @if(!empty($business->subscription) && $business->subscription->isActive())
                                <p><span class="font-weight-bold">{{ \Carbon\Carbon::parse($business->subscription->active_to)->format('d.m.Y') }}</span></p>
                            @else
                                <form action="{{ route('amicms::subscription.subscribe', ['business_id' => $business->id]) }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select class="custom-select form-control" name="period" data-style="">
                                                    @for($i=1;$i<=12;$i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Активувати</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            @endif

                        </div>
                    </div>

                    <br>
                    <h2 class="display-5 my-3">Історія</h2>
                    <hr>

                    @if($business->subscription && count($business->subscription_history) > 0)
                    <div class="table-responsive">
                        <table class="table table-borderless table-data3">
                            <thead>
                            <tr>
                                <th>#</th>
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
@endsection
