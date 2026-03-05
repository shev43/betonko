<div class="item col-12 col-lg-6    ">
    @if(Auth::guard('business')->check())
        <a class="stretched-link" href="{{ route('business::catalog.view', ['lang'=>app()->getLocale(), 'factory_id'=>$factories->id]) }}"></a>
    @else
        <a class="stretched-link" href="{{ route('frontend::catalog.view', ['lang'=>app()->getLocale(), 'factory_id'=>$factories->id]) }}"></a>
    @endif

    <div class="offer-plant">
        <div class="row align-items-center mb-0">
            <div class="col-4 col-md-3">
                <div class="offer-plant-logo">
                    <img src="@if(!empty($factories->photo)){{ asset('storage/factory/'.$factories->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" alt="">
                </div>
            </div>
            <div class="col-8 col-md-9">
                <h3 class="heading offer-plant-info">{{ $factories->name }}</h3>
                <div class="mt-md-3 mt-1 offer-plant-info"><b>{{ $factories->address }}</b></div>
            </div>

        </div>

    </div>
</div>
