<a class="stretched-link" href="{{ route('frontend::catalog.view', ['lang'=>app()->getLocale(), 'factory_id'=>$factory->id]) }}">
    <div class="row seller_profile-factories-item align-items-center d-flex">
        <div class="col-4 col-md-3">
            <div class="seller_profile-factories-img">
                <img src="@if(!empty($factory->photo)){{ asset('storage/factory/'.$factory->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" alt="">
            </div>
        </div>
        <div class="col-8 col-md-9">
            <div class="row" style="height: 125px;">
                <div class="col-12">
                    <div class="seller_profile-factories-name">{{$factory->name}}</div>
                    <div class="seller_profile-factories-post" style="font-size: 14px;">{{$factory->address}}</div>
                </div>
            </div>
        </div>
    </div>
</a>
