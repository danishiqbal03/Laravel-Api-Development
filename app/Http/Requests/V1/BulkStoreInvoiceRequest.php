<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
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
            '*.customerId'=> ['required','integer'],
            '*.amount'=> ['required','numeric'],
            '*.status'=> ['required',Rule::in(['B','P','V','b','p','v'])],
            '*.billedDate'=> ['required','date_format:Y-m-d H:i:s'],
            '*.paidDate'=> ['date_format:Y-m-d H:i:s','nullable'],
        ];
    }

    protected function prepareForValidation(){
        $data = [];
        foreach($this->toArray() as $obj){
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['billed_dated'] = $obj['billedDate'] ?? null;
            $obj['paid_dated'] = $obj['paidDate'] ?? null;
            // unset($obj['customerId']);
            // unset($obj['billedDate']);
            // unset($obj['paidDate']);

            $data[] = $obj;
        }
        $this->merge($data);
    }
}
