@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div>
                <script src="/amicms/vendors/apexcharts/dist/apexcharts.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

                        <section class="seller_cabinet-proposals">
                            <div class="row mb-4 mb-md-auto">
                                <div class="col-12 col-md-4">
                                    <h2 class="title">Статистика:</h2>
                                </div>
                                <div class="col-12 col-md-8">
                                    <form id="formStatFilter" action="" method="get">
                                        <div class="row mb-4 d-flex justify-content-end">
                                            <div class="col-5">
                                                <input type="text" id="period" name="period" class="form-control" value="{{ !empty($startDate) ? $startDate : '' }} - {{ !empty($endDate) ? $endDate : '' }}">
                                            </div>
                                            <div class="col-1 pt-2">
                                                <a class="btnStatFilter" href="#">
                                                    <svg class="form-icon" style="left: initial; right: 0px;">
                                                        <path d="M4.5 19.195l1.91-1.91 1.055 1.055-3.715 3.726L.035 18.34l1.055-1.055L3 19.195V1.5h1.5v17.695zM9 15v-1.5h6V15H9zm0-4.5V9h10.5v1.5H9zm0-6h15V6H9V4.5z" fill="#2C2E2F"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="blocklist">
                                <div class="row border-bottom mb-5">
                                    <div class="col-12">
                                        <div id="chart_total"></div>
                                    </div>
                                </div>

                            </div>

                        </section>


            </div>
        </div>
    </div>
@endsection









@section('styles')
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('amicms/vendors/daterangepicker-master/daterangepicker.css') }}">
@endsection


@section('scripts')
    <script type="text/javascript" src="/amicms/vendors/daterangepicker-master/moment.min.js"></script>
    <script type="text/javascript" src="/amicms/vendors/daterangepicker-master/daterangepicker.js"></script>


    <script>
        $('#period').daterangepicker({
            "timePicker": false,
            "ranges": {
                "за сьогодні": [
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}",
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}"
                ],
                "за тиждень": [
                    "{{ \Carbon\Carbon::now()->subDays(7)->format('m/d/Y') }}",
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}"
                ],
                "за місяць": [
                    "{{ \Carbon\Carbon::now()->subMonth()->format('m/d/Y') }}",
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}"
                ],
                "за рік": [
                    "{{ \Carbon\Carbon::now()->subMonth(12)->format('m/d/Y') }}",
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}"
                ],

            },
            "startDate": "{{ (request()->get('period')) ? \Carbon\Carbon::parse($startDate)->format('m/d/Y') : \Carbon\Carbon::now()->subDays(7)->format('m/d/Y') }}",
            "endDate": "{{ (request()->get('period')) ? \Carbon\Carbon::parse($endDate)->format('m/d/Y') : \Carbon\Carbon::now()->format('m/d/Y') }}",
        }, function(start, end, label) {
            // $('input[name=period]').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            // console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });



        var options_total = {
            series: [
                {
                    name: 'Нові користувачі',
                    data: [{
                        x: '',
                        y: '{{ $business_register_views }}',
                    }]
                 },

                {
                    name: 'Перехід на завод',
                    data: [{
                        x: '',
                        y: '{{ $business_factory_views }}',
                    }]
                },


                {
                    name: 'Перехід у профіль підприємства',
                    data: [{
                        x: '',
                        y: '{{ $business_profile_views }}',
                    }]
                },

                {
                    name: 'Перегляд email',
                    data: [{
                        x: '',
                        y: '{{ $email_views }}',
                    }]
                },

                {
                    name: 'Перегляд номеру тел',
                    data: [{
                        x: '',
                        y: '{{ $phone_views }}',
                    }]
                },

                {
                    name: 'Перехід на сайт',
                    data: [{
                        x: '',
                        y: '{{ $www_views }}',
                    }]
                },

                {
                    name: 'Перегляд контактної особи',
                    data: [{
                        x: '',
                        y: '{{ $contact_person_phone_views }}',
                    }]
                },


            ],
            chart: {
                height: 350,
                type: 'bar'
            },



        };

        var chart = new ApexCharts(document.querySelector("#chart_total"), options_total);

        chart.render();

    </script>


@endsection
