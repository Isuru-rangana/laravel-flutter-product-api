<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCategoryRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true; 
    }

   
    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255|unique:product_categories,name',  
            'active' => 'required|boolean',                                        
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data'    => $validator->errors(),
        ], 422));
    }
}