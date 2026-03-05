<div class="row seller_profile-persons-item">
    <div class="col-4 col-md-3">
        <div class="seller_profile-persons-img">
            <img src="@if(!empty($contact->photo)){{ asset('storage/users/'.$contact->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" alt="">
        </div>
    </div>
    <div class="col-8 col-md-9">
        <div class="seller_profile-persons-name">{{$contact->name}}</div>
        <div class="seller_profile-persons-post">{{$contact->position}}</div>
        <div class="seller_profile-persons-phone">
            {{$contact->phoneSmall}}
            <a class="btn-action-contact-person-phone show-phone-number" href="#" data-phone="{{ $contact->phoneFormatted }}">показати</a>

        </div>

    </div>
</div>
