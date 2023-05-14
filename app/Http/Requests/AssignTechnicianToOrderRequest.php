<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTechnicianToOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //TODO: Desautorizar cualquier usuarios que no sea encargado ni gerente de mantenimiento.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'order_number' => 'required',
            'technician_id' => 'required',
        ];
    }

    public function messages(){
        return [
            'order_number.required' => 'Debe especificar un número de orden válido.',
            'technician_id.required' => 'Debe especificar un técnico.',
        ];
    }
}
