<?php

namespace App\View\Components;

use App\Models\Conversion;
use Illuminate\View\Component;

class Balance extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $balance = Conversion::where('student_id', auth()->user()->id)->where('status', 'approved')->where('paid', false)->sum('payout');
        return view('components.balance', compact('balance'));
    }
}
