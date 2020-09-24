<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && !auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'departure_stop_id' => 'required|different:arrival_stop_id',
            'arrival_stop_id' => 'required|different:departure_stop_id',
        ];
    }

    public function messages()
    {
        return [
            'departure_stop_id.required' => 'Trip departure city is required',
            'arrival_stop_id.required' => 'Trip arrival city ia required',
            'departure_stop_id.different' => 'Trip departure and arrival cannot be the same',
            'arrival_stop_id.different' => 'Trip departure and arrival cannot be the same',
        ];
    }
}
