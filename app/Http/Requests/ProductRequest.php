<?php

namespace App\Http\Requests;

use App\Contracts\ApiResponseServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|numeric|min:0',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            app(ApiResponseServiceInterface::class)->validationErrorResponse(
                $validator->errors()->toArray(),
                $this->validationData()
            )
        );
    }
}

