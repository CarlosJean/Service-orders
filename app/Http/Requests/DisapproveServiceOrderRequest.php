<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisapproveServiceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        //TODO: Solo encargado y gerente de mantenimiento tien acceso a este formulario.
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
            'observations' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'order_number.required' => 'Debe especificar un número de orden correcto.',
            'observations.required' => 'Debe especificar una razón por la cual desaprueba esta orden.',
        ];
    }
}
