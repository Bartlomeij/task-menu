<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MenuUpdateRequest
 * @package App\Http\Requests
 */
class MenuUpdateRequest extends MenuRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('PATCH')) {
            return [
                'field' => 'nullable',
                'max_depth' => 'nullable|numeric',
                'max_children' => 'nullable|numeric',
            ];
        } else {
            return [
                'field' => 'required',
                'max_depth' => 'required|numeric',
                'max_children' => 'required|numeric',
            ];
        }

    }
}
