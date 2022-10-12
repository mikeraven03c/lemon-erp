<?php
namespace App\Packages\Samples\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class SampleFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['string', 'nullable'],
            'number' => ['numeric', 'nullable'],
            'email' => ['string', 'unique:samples,email', 'required'],
            'description' => ['string', 'nullable'],
            'location' => ['string', 'nullable'],
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
