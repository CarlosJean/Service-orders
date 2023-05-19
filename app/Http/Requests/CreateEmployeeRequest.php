<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'identification' => 'required|max:15|min:8|regex:/^[0-9]+$/',
            'names' => 'required',
            'last_names' => 'required',
            'role_id' => 'required',
            'department_id' => 'required',
        ];
    }

    public function messages():array
    {
        return [
            'identification.required' => 'Debe indicar un número de documento de identificación.',
            'identification.max' => 'La cantidad máxima de caracteres es de 15.',
            'identification.min' => 'La cantidad mínima de caracteres es de 8.',
            'identification.regex' => 'El campo de identificación acepta números solamente.',
            'names.required' => 'Debe indicar el nombre del empleado.',
            'last_names.required' => 'Debe indicar el apellido del empleado.',
            'role_id.required' => 'Debe indicar el rol del empleado.',
            'department_id.required' => 'Debe indicar el departamento del empleado.',
        ];
    }
}
