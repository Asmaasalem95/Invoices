<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
class CreateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'required|string',
            'type' => 'required|in:debtor,creditor',
            'debtor_total_limit' => 'required_if:type,creditor|numeric'
        ];
    }
    /** override failedValidation function to customize the validation api response
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Invalid inputs!',
            'data' => $validator->errors()->all(),
        ])->setStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
