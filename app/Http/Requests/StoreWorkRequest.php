<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
            'title' => 'required|array',
            'title.en' => 'required|string',
            'description' => 'required|array',
            'description.en' => 'required|string',
            'status' => 'required|string',
            'assigned_to' => 'nullable|array',
            'assigned_to.*' => 'integer|exists:employees,id',
            'employee_id' => 'nullable|integer|exists:employees,id',
        ];
    }
    public function attributes()
    {
        return [
            'title.ar' => __('اختبار  بالعربية'),
            'title.en' => __(' English test'),
            'description.ar' => __('اختبار بالعربية'),
            'description.en' => __('english test '),
            'status' => __('new'),
            'assigned_to' => __(' الموضف'),
        ];
    }
}
