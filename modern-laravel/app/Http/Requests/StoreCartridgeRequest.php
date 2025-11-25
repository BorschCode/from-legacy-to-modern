<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartridgeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'owner' => 'required|string|max:50',
            'brand' => 'required|string|max:50',
            'marks' => 'required|string|max:50',
            'code' => 'required|string|max:30',
            'servicename' => 'nullable|string|max:30',
            'technical_life' => 'required|integer|in:0,1',
            'comments' => 'nullable|string|max:50',
            'weight_before' => 'required|integer|min:0',
            'weight_after' => 'required|integer|min:0',
            'date_outcome' => 'nullable|date',
            'date_income' => 'nullable|date',
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated();
        
        // Auto-calculate service status
        $validated['inservice'] = 0;
        if (isset($validated['date_outcome']) && isset($validated['date_income'])) {
            $validated['inservice'] = $validated['date_income'] < $validated['date_outcome'] ? 1 : 0;
        }

        return $validated;
    }
}