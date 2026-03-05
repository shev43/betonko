@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Власник</th>
                        <th width="280">Бізнес</th>
                        <th width="150">План</th>
                        <th width="200">Активний До</th>
                        <th width="150">Created</th>
                        <th width="100"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($business_array as $business)
                        <tr>
                            <td>
                                <div>{{ $business->subscription->order_number }}</div>
                            </td>
                            <td>
                                <div>{{ $business->seller->first_name }} {{ $business->seller->last_name }}</div>
                                <div>{{ $business->seller->phone }}</div>
                                <div>{{ $business->seller->email }}</div>
                            </td>
                            <td>{{ $business->name }}</td>
                            <td>
                                @if(!empty($business->subscription) && $business->subscription->isActive())
                                    <span class="badge badge-success pl-2 pr-2 pt-1 pb-1">{!! __('web.SUBSCRIPTION_PREMIUM_LABEL') !!}</span>

                                @else
                                    <span class="badge badge-warning pl-2 pr-2 pt-1 pb-1">Базовий</span>

                                @endif
                            </td>
                            <td><span class="heading">{{ \Carbon\Carbon::parse($business->subscription->active_to)->format('d.m.Y') }}</span></td>
                            <td><span class="heading">{{ \Carbon\Carbon::parse($business->subscription->created_at)->format('d.m.Y h:i:s') }}</span></td>


                            <td class="text-center">
                                <a class="mrg-right-10 text-info" href="{{ route('amicms::subscription.view', ['business_id'=>$business->id]) }}">
                                    <span class="icon-holder"><i class="ti-pencil"></i></span> </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end pagination">
                    {!! $business_array->withQueryString()->links('pagination/amicms') !!}
                </div>


            </div>
        </div>
    </div>
@endsection




