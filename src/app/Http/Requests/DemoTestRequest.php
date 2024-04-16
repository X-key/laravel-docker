<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DemoTestRequest
 * @package App\Http\Requests
 */
final class DemoTestRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'objects' => 'required|array|max:2000',
            'objects.*.ref' => 'required|string',
            'objects.*.name' => 'required|string',
            'objects.*.description' => 'nullable|string',
        ];
    }
}
