<div class="col py-4 px-0 px-md-3">

    <div class="col d-sm-flex justify-content-between align-items-center mb-4">
        <p class="acct_cont_header mb-3 mb-sm-0">Edit Package</p>
        <a href="{{ route('plans')}}" class="text-decoration-none"> <button type="button" class="acct_btn2"> <i
                    class="fas fa-arrow-left mr-2"></i> Back</button> </a>
    </div>

    <div class="col">
        <form wire:submit.prevent="UpdatePlan()" class="col acct_newdep_cont shadow-sm ">
            <div class="col d-lg-flex px-0">
                <div class="col px-0 mr-lg-5">
                    <div class="mb-3">
                        <label class="acct_label">Package Title</label>
                        <input type="text" wire:model.lazy="title" class="acct_modal_box" min="1"
                            placeholder="Enter package title">
                        @error('title') <span class="acct_box_error">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="acct_label">Sub Title</label>
                        <input type="text" wire:model.lazy="sub_title" class="acct_modal_box" min="1"
                            placeholder="Eg. Basic Plan">
                        @error('sub_title') <span class="acct_box_error">{{ $message }}</span> @enderror
                    </div>
                    <div class="d-md-flex ">
                        <div class="col px-0 mr-md-3 mb-3">
                            <label class="acct_label">Minimum Investment</label>
                            <input type="number" wire:model.lazy="min_investment" class="acct_modal_box" min="1"
                                placeholder="eg. 1000">
                            @error('min_investment') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col px-0 mb-3">
                            <label class="acct_label">Maximum Investment</label>
                            <input type="number" wire:model.lazy="max_investment" class="acct_modal_box" min="1"
                                placeholder="eg. 10000">
                            @error('max_investment') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col mb-3 px-0">
                            <div class="custom-control custom-radio custom-control-inline d-block">
                                <input type="radio" id="customRadioInline1" wire:model.lazy="rate_type" value="fixed"
                                    class="custom-control-input" checked>
                                <label class="custom-control-label acct_label" for="customRadioInline1">Fixed
                                    Rate</label>
                            </div>
                            @error('rate_type') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col mb-3 px-0">
                            <div class="custom-control custom-radio custom-control-inline d-block">
                                <input type="radio" id="customRadioInline2" wire:model.lazy="rate_type" value="percent"
                                    class="custom-control-input">
                                <label class="custom-control-label acct_label" for="customRadioInline2">Percentage
                                    Rate</label>
                            </div>
                            @error('rate_type') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="d-md-flex ">
                        <div class="col px-0 mr-md-3 mb-3">
                            <label class="acct_label">Interest Rate</label>
                            <input type="number" wire:model.lazy="rate_number" class="acct_modal_box" min="1" step="any"
                                placeholder="eg. 50">
                            @error('rate_number') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col px-0 mb-3">
                            <label class="acct_label">Interest Period</label>
                            <select wire:model.lazy="interest_period" class="acct_modal_sel">
                                <option value="" selected>Choose Here</option>
                                @foreach (App\Enums\InterestPeriod::cases() as $item)
                                <option value="{{$item->value}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('interest_period') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="acct_label">Maturity</label>
                        <select wire:model.lazy="maturity" class="acct_modal_sel">
                            <option value="">Choose Here</option>
                            @foreach (App\Enums\Maturity::cases() as $item)
                            <option value="{{$item->value}}">Maturity after a {{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('maturity') <span class="acct_box_error">{{ $message }}</span> @enderror
                    </div>



                </div>
                <div class="col px-0">
                    <div class="custom-control custom-checkbox mb-2">
                        <input wire:model.lazy="return_capital_amount" type="checkbox" class="custom-control-input"
                            id="customCheck1" value="true">
                        <label class="custom-control-label acct_label" for="customCheck1">Principal return
                            after the end of the period <br>
                            <small class="font-weight-bold">If checked the initial deposit amount will be available
                                at the end of the period for either withdrawal or reinvestment</small>
                        </label>
                    </div>
                    <div class="custom-control custom-checkbox mb-2">
                        <input wire:model.lazy="status" type="checkbox" class="custom-control-input" id="customCheck2"
                            value="true">
                        <label class="custom-control-label acct_label" for="customCheck2">Display to client
                            <br>
                            <small class="font-weight-bold">If checked this plan will be displayed to clients or the
                                front-page of your site.</small>
                        </label>
                    </div>
                    <div class="custom-control custom-checkbox mb-2">
                        <input wire:model="payout_buiness_days_only" type="checkbox" class="custom-control-input"
                            id="customCheck3" value="true">
                        <label class="custom-control-label acct_label" for="customCheck3">Payout on business
                            days only <br>
                            <small class="font-weight-bold">If checked the profits will be paid only on week
                                days.</small>
                        </label>
                    </div>

                </div>
            </div>
            <div class="mt-4">
                <button wire:loading wire:target="UpdatePlan" type="button" class="acct_modal_btn disabled"
                    disabled>Processing...</button>
                <button wire:loading.remove wire:target="UpdatePlan" type="submit"
                    class="acct_modal_btn">Submit</button>
            </div>
        </form>
    </div>

</div>