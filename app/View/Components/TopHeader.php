<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $title,){
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = User::where('id', auth()->id())->withWhereHas('kyc')->first();
        
        return view('components.top-header')->with(['kyc_status' => $user ? $user->kyc->status : 'Pending']);
    }
}
