<?php
namespace App\Http\Controllers;

use App\Models\EligibilityCriteria;
use Illuminate\Http\Request;
use App\Http\Resources\EligibilityCriteriaResource;

class EligibilityCriteriaController extends Controller
{
    public function index()
    {
        $criteria = EligibilityCriteria::paginate(10); // Adjust pagination as needed
        return inertia('EligibilityCriteria/Index', [
            'eligibilityCriteria' => EligibilityCriteriaResource::collection($criteria),
        ]);
    }

    public function create()
    {
        return inertia('EligibilityCriteria/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age_less_than' => 'nullable|integer',
            'age_greater_than' => 'nullable|integer',
            'last_login_days_ago' => 'nullable|integer',
            'income_less_than' => 'nullable|numeric',
            'income_greater_than' => 'nullable|numeric',
        ]);

        EligibilityCriteria::create($validated);
        return redirect()->route('eligibility-criteria.index')->with('success', 'Eligibility criteria created successfully.');
    }

    public function edit(EligibilityCriteria $eligibilityCriteria)
    {
        return inertia('EligibilityCriteria/Create', ['eligibilityCriteria' => $eligibilityCriteria]);
    }

    public function update(Request $request, EligibilityCriteria $eligibilityCriteria)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age_less_than' => 'nullable|integer',
            'age_greater_than' => 'nullable|integer',
            'last_login_days_ago' => 'nullable|integer',
            'income_less_than' => 'nullable|numeric',
            'income_greater_than' => 'nullable|numeric',
        ]);

        $eligibilityCriteria->update($validated);
        return redirect()->route('eligibility-criteria.index')->with('success', 'Eligibility criteria updated successfully.');
    }

    public function destroy(EligibilityCriteria $eligibilityCriteria)
    {
        $eligibilityCriteria->delete();
        return redirect()->route('eligibility-criteria.index')->with('success', 'Eligibility criteria deleted successfully.');
    }
}
