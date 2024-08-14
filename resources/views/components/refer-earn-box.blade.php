<div class="col dash_ref_con overflow-hidden p-3 p-sm-4 mt-4">
    <p class="dash_ref_header">Refer & Earn</p>
    <p class="dash_ref_head">Refer friends, earn 10% commission on their first deposit.</p>
    <p class="dash_ref_head d-none">Referral Link: <span id="referral_link" class="dash_ref_text">{{route('register')
            }}?referral={{auth()->user()->referral_code}}</span> </p>
    <form action="#" method="post">
        <input type="email" name="friend_email" class="dash_ref_box mb-3"
            value="{{route('register')}}?referral={{auth()->user()->referral_code}}" placeholder="Enter Email Address"
            readonly>
        <div class="d-sm-flex">
            {{-- <button type="submit" class="col dash_ref_btn mb-2 mb-sm-0 mr-sm-4">Invite
                Friends</button> --}}
            <button id="referral_btn" type="button" class="col dash_ref_btn2">Copy Referral
                Link</button>
        </div>
    </form>
</div>
