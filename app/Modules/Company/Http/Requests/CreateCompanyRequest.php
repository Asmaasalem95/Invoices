<?php

namespace Modules\Company\Http\Requests;

use App\Traits\CommonMethods;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateCompanyRequest extends FormRequest
{
    use CommonMethods;
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
        throw new HttpResponseException(
            $this->apiResponse(__('messages.invalid_inputs'), Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors()->all())
        );
    }
}
