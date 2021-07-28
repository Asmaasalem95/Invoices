<?php

namespace  Modules\Invoice\Http\Requests;

use App\Traits\CommonMethods;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CreateInvoiceRequest extends FormRequest
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
            'creditor_id' => ['required','integer',Rule::exists('companies','id')->where('type','creditor')],
            'debtor_id' => ['required','integer',Rule::exists('companies','id')->where('type','debtor')],
            'total_amount'=> 'required|numeric',
            'due_date' => 'required|date|after:today'
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
