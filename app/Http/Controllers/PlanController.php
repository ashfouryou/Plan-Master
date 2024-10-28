<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Http\Resources\PlanResource;
use Inertia\Inertia;
use Illuminate\Http\Request; 

class PlanController extends Controller
{
    public function index(Request $request) {
        $search = $request->query('search');
        $plansQuery = Plan::query();
        if ($search) {
            $plansQuery->where('name', 'LIKE', "%{$search}%");
        }
        $plans = $plansQuery->paginate($request->input('perPage', 10));
        $meta = [
            'total' => $plans->total(),
            'current_page' => $plans->currentPage(), 
            'last_page' => $plans->lastPage(), 
            'per_page' => $plans->perPage(), 
        ];
        return Inertia::render('Plan/Index', [
            'plans' => PlanResource::collection($plans),
            'meta' => $meta, 
        ]);
    }
    

    public function create(){
        return Inertia::render('Plan/Create');
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status'=>'required|bool',
        ]);

        Plan::create($validated); 

        return redirect()->route('plan.index')->with('success', 'Plan created successfully');
    }

    public function edit(Plan $plan){
        return Inertia::render('Plan/Create', ['plan' => $plan]); 
    }

    public function update(Request $request, Plan $plan){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status'=>'required|bool',
        ]);

        $plan->update($validated); 

        return redirect()->route('plan.index')->with('success', 'Plan updated successfully');
    }

    public function destroy(Plan $plan){
        $plan->delete(); 
        return redirect()->route('plan.index')->with('success', 'Plan deleted successfully');
    }




    
}
