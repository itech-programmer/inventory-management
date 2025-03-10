<?php

namespace App\Http\Requests;

use App\Contracts\ApiResponseServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefundRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'batch_id' => 'nullable|integer|exists:batches,id',
            'order_id' => 'nullable|integer|exists:orders,id',
            'quantity' => 'required|integer|min:1',
            'refund_amount' => 'required|numeric|min:0',
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

