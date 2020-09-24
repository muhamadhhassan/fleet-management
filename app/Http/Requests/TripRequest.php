<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return optional(auth()->user())->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bus_id' => 'required|exists:buses,id',
            'stops.*' => 'required|distinct|exists:cities,id'
        ];
    }

    public function messages()
    {
        return [
            'stops.*.distinct' => 'A city can be added once'
        ];
    }
}
