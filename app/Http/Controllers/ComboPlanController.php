<?php

namespace App\Http\Controllers;

use App\Models\ComboPlan;
use App\Models\Plan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\ComboPlanResource;

class ComboPlanController extends Controller
{
    public function index(Request $request) {
        $search = $request->query('search');
        $plansQuery = ComboPlan::query();
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
        return Inertia::render('ComboPlan/Index', [
            'comboPlans' => ComboPlanResource::collection($plans),
            'meta' => $meta, 
        ]);
    }
    


    public function create()
    {
        $plans = Plan::all(); 
        return Inertia::render('ComboPlan/Create', [
            'plans' => $plans
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:combo_plans,name',
            'description' => 'required',
            'price' => 'required|numeric',
            'selectedPlans' => 'required|array',
        ]);


        $comboPlan = ComboPlan::create($request->only('name', 'description', 'price'));
        $comboPlan->plans()->attach($request->selectedPlans); 

        return redirect()->route('combo-plans.index')->with('success', 'Combo Plan created successfully!');
    }


    public function edit($id)
    {
        $comboPlan = ComboPlan::with('plans')->findOrFail($id);
        $plans = Plan::all();
        return Inertia::render('ComboPlan/Create', [
            'comboPlan' => $comboPlan,
            'plans' => $plans
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:combo_plans,name,' . $id,
            'description' => 'required',
            'price' => 'required|numeric',
            'selectedPlans' => 'required|array',
        ]);

        $comboPlan = ComboPlan::findOrFail($id);
        $comboPlan->update($request->only('name', 'description', 'price'));
        $comboPlan->plans()->sync($request->selectedPlans); 

        return redirect()->route('combo-plans.index')->with('success', 'Combo Plan updated successfully!');
    }


    public function destroy($id)
    {
        $comboPlan = ComboPlan::findOrFail($id);
        $comboPlan->delete();
        return redirect()->route('combo-plans.index')->with('success', 'Combo Plan deleted successfully!');
    }
}
