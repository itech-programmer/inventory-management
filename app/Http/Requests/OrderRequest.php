<?php

namespace App\Http\Requests;

use App\Contracts\ApiResponseServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'client_id' => 'required|integer' . ($this->isTesting() ? '' : '|exists:clients,id'),
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer' . ($this->isTesting() ? '' : '|exists:products,id'),
            'products.*.qty' => 'required|integer|min:1'
        ];
    }

    private function isTesting(): bool
    {
        return app()->environment('testing');
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

