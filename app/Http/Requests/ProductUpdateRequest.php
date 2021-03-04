<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
      'name' => ['required',Rule::unique('products')->ignore($this->product)->whereNull('deleted_at')],
      'category_id' => 'required',
      'price' => 'required|numeric|min:1',
      'stock' => 'required|min:1'
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'El campo es obligatorio.',
      'name.unique' => 'El nombre ya está en uso.',
      'price.required' => 'El campo es obligatorio.',
      'price.numeric' => 'Debe contener solo números',
      'price.min' => 'El precio debe ser minimo :min',
      'stock.required' => 'El campo es obligatorio.',
      'stock.min' => 'El stock debe ser mínimo :min'
    ];
  }
}
