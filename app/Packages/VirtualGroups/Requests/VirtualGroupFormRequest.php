<?php
namespace App\Packages\VirtualGroups\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class VirtualGroupFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['string', 'required'],
            'label' => ['string', 'required'],
            'priority' => ['numeric', 'required'],
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
