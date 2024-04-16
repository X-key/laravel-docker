<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

final class DemoTestActivationRequest extends FormRequest
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
            'refs' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $object) {
                        $existsAndInActive = DB::table('demo_test')
                            ->where('ref', $object)
                            ->where('is_active', false)
                            ->exists();

                        if ($existsAndInActive) {
                            $fail('At least one object is inactive and exist in the database.');
                        }
                    }
                },
            ],
            'refs.*' => 'required|string',
        ];
    }
}
