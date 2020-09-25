<?php

namespace Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Market\Http\Controllers\Controller;
use Market\Services\PlanService;
use Market\Http\Requests\PlanRequest;

class PlanController extends Controller
{
    public function __construct(PlanService $planService)
    {
        $this->service = $planService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->service->collectNewPlans();
        $plans = $this->service->paginated();

        return view('market::admin.plans.index')->with('plans', $plans);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $plans = $this->service->search($request->term);

        return view('market::admin.plans.index')
            ->with('term', $request->term)
            ->with('plans', $plans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('market::admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\PlanRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect(config('market.admin-route-prefix', 'admin').'/plans/'.$result->id.'/edit')->with('success', 'Successfully created');
        }

        return redirect('admin.commerce.plans')->with('error', 'Failed to create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $plan = $this->service->find($id);
        $customers = $this->service->getSubscribers($plan);

        return view('market::admin.plans.edit')
            ->with('customers', $customers)
            ->with('plan', $plan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\PlanRequest $request
     * @param int                          $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->service->update($id, $request->except('_token', '_method'));

        if ($result) {
            return back()->with('success', 'Successfully updated');
        }

        return back()->with('error', 'Failed to update');
    }

    /**
     * Disable a plan.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function stateChange(Request $request, $id)
    {
        $result = $this->service->stateChange($id, $request->state);

        if ($result) {
            return back()->with('success', 'Successfully updated');
        }

        return back()->with('error', 'Failed to update');
    }

    /**
     * Cancel a subscription.
     *
     * @param int $plan
     * @param int $userMeta
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelSubscription($plan, $userMeta)
    {
        $result = $this->service->cancelSubscription($plan, $userMeta);

        if ($result) {
            return back()->with('success', 'Successfully cancelled');
        }

        return back()->with('error', 'Failed to cancel');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $result = $this->service->destroy($id);

        if ($result) {
            return redirect(config('market.admin-route-prefix', 'admin').'/plans')->with('success', 'Successfully deleted');
        }

        return redirect(config('market.admin-route-prefix', 'admin').'/plans')->with('error', 'Failed to delete');
    }
}
