<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
      'name' => 'required',
      'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
      'password' => 'required|confirmed',
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'El campo es obligatorio.',
      'email.required' => 'El campo es obligatorio.',
      'email.unique' => 'El correo eletrónico ya está en uso.',
      'password.required' => 'El campo es obligatorio.',
      'password.confirmed' => 'Debe confirmar la contraseña.'
    ];
  }
}
