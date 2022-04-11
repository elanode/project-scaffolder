<?php

namespace App\Domains\Authentication\Http\Requests;

use App\Infrastructure\Http\Requests\Contracts\WithAvailableQueryStringOptionsContract;
use App\Infrastructure\Http\Requests\Traits\WithAvailableQueryStringOptionsTrait;
use App\Support\Actions\Enums\SortDirectionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetAllUserRequest extends FormRequest implements WithAvailableQueryStringOptionsContract
{
    use WithAvailableQueryStringOptionsTrait;

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
            'paginate' => ['sometimes', 'numeric'],
            'order_column' => ['sometimes', 'string', Rule::in(
                [
                    'created_at',
                    'name',
                    'email'
                ]
            )],
            'sort_direction' => ['sometimes', 'string', Rule::in(
                collect(SortDirectionEnum::cases())
                    ->pluck('value')
                    ->toArray()
            )],
        ];
    }

    public function getQueryStringOptions(): array
    {
        return [
            $this->queryStringInformationFormatter('order_column', [
                'created_at',
                'name',
                'email'
            ], 'order data by this column'),
            $this->queryStringInformationFormatter('sort_direction', collect(SortDirectionEnum::cases())
                ->pluck('value')
                ->toArray(), 'sort direction'),
            $this->queryStringInformationFormatter('paginate', [], 'must be numeric')
        ];
    }
}
