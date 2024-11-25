<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nameSP' => 'required|string|max:255',
            'priceSP' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'flash_sale_price' => 'nullable|numeric|min:0',
            'product_category_idSP' => 'required|exists:product_categories,id',
            'descriptionSP' => 'required|string',
        ];
    }
    /**
     * Các thông báo lỗi tùy chỉnh cho các quy tắc validate.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nameSP.required' => 'Tên sản phẩm không được để trống.',
            'nameSP.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'nameSP.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'priceSP.required' => 'Giá sản phẩm không được để trống.',
            'priceSP.numeric' => 'Giá sản phẩm phải là một số.',
            'priceSP.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'sale_price.numeric' => 'Giá khuyến mãi phải là một số.',
            'sale_price.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'flash_sale_price.numeric' => 'Giá siêu khuyến mãi phải là một số.',
            'flash_sale_price.min' => 'Giá siêu khuyến mãi phải lớn hơn hoặc bằng 0.',
            'product_category_idSP.required' => 'Danh mục sản phẩm không được để trống.',
            'product_category_idSP.exists' => 'Danh mục sản phẩm không tồn tại.',
            'descriptionSP.required' => 'Mô tả sản phẩm không được để trống.',
            'descriptionSP.string' => 'Mô tả sản phẩm phải là chuỗi ký tự.',
        ];
    }
}
