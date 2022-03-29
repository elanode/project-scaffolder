<?php

namespace Domains\Authentication\Dtos;

use Domains\Authentication\Exceptions\UserDtoException;

class UserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public null|string $password = null,
    ) {
        if (empty($this->name)) {
            throw UserDtoException::missingAttribute('name');
        }

        if (empty($this->email)) {
            throw UserDtoException::missingAttribute('email');
        }
    }

    public function toArray(): array
    {
        $data =  [
            'name' => $this->name,
            'email' => $this->email
        ];

        if (!empty($this->password)) {
            $data['password'] = $this->password;
        }

        return $data;
    }
}
