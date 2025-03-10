<?php

namespace App\Http\Requests;

use App\Contracts\ApiResponseServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'provider_id' => 'nullable|exists:providers,id',
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
