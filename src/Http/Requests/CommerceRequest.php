<?php

namespace Market\Http\Requests\Commerce;

use Illuminate\Support\Facades\Gate;
use Market\Http\Requests\Request;
use Market\Models\Feature;

abstract class CommerceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //@todo Fazer Gate::allows('has-feature', Feature::find('commerce'));
    }
}
