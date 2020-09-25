<?php

namespace Market\Http\Controllers;

use Market\Http\Controllers\Controller;
use Market\Services\PlanService;

class PlanController extends Controller
{
    protected $service;

    public function __construct(PlanService $service)
    {
        if (!config('commerce.subscriptions')) {
            return back()->send();
        }
        $this->service = $service;
    }

    /**
     * Display all plan entries.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $plans = $this->service->allEnabled();

        if (empty($plans)) {
            abort(404);
        }

        return view('market::plans.all')->with('plans', $plans);
    }

    /**
     * Display the specified plan.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $plan = $this->service->findByUuid($id);

        if (empty($plan)) {
            abort(404);
        }

        return view('market::plans.show')->with('plan', $plan);
    }
}
