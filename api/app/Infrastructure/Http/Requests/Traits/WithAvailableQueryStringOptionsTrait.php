<?php

namespace App\Infrastructure\Http\Requests\Traits;

trait WithAvailableQueryStringOptionsTrait
{
    public function queryStringInformationFormatter(string $queryParam, array $options, null|string $description = null, bool $canChooseMultiple = false, string $multipleSeperator = ','): array
    {
        return [
            'query_param' => $queryParam,
            'options' => $options,
            'example' => "?$queryParam=" . $options[0] ??= "[$queryParam]",
            'description' => $description,
            'can_choose_multiple' => $canChooseMultiple,
            'multiple_seperated_by' => $canChooseMultiple ? "$multipleSeperator" : null
        ];
    }
}
