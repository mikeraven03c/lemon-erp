<?php
namespace App\Packages\VirtualAttributes\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class VirtualAttributeFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['string', 'required'],
            'field' => ['string', 'nullable'],
            'type' => ['string', 'nullable'],
            'virtual_model_id' => ['required'],
            'is_required' => ['boolean', 'nullable'],
            'tab' => ['string', 'nullable'],
            'is_choices' => ['boolean'],
            'options' => ['nullable'],
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
