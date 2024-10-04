<?php

namespace App\View\Components;

use App\Models\Item;
use App\Models\Department;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Quotation;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dashboard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user = User::where('status', 1)->where('role_id', '!=', 5)->count();
        view()->share('user',$user);
        
        $item = Item::where('status', 1)->count();
        view()->share('item',$item);
        
        $supplier = Supplier::where('status', 1)->count();
        view()->share('supplier',$supplier);
        
        $department = Department::where('status', 1)->count();
        view()->share('department',$department);
        
        $openQuotations = Quotation::where('status', 1)->count();
        view()->share('openQuotations',$openQuotations);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard');
    }
}
