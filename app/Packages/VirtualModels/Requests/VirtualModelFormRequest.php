<?php
namespace App\Packages\VirtualModels\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class VirtualModelFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['string', 'required'],
            'table_name' => ['string', 'nullable'],
            'endpoint' => ['string', 'required']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $arr = [];
        if ($this->expectsJson()) {
            $errors = (new ValidationException($validator))->errors();
            foreach ($errors as $index => $error) {
                $arr[$index] = $error[0];
            }
            throw new HttpResponseException(
                response()->json(['data' => $arr], 422)
            );
        }

        parent::failedValidation($validator);
    }
}
