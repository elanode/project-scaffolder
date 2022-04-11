<?php

namespace App\Infrastructure\Http\Requests\Contracts;

interface WithAvailableQueryStringOptionsContract
{
    public function getQueryStringOptions(): array;
    public function queryStringInformationFormatter(string $queryParam, array $options, null|string $description = null, bool $canChooseMultiple = false, string $multipleSeperator = ','): array;
}
