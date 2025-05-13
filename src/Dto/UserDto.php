<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    #[Assert\NotBlank(message: 'Name is mandatory')]
    #[Assert\Email(message: 'Invalid email address')]
    public string $username;

    #[Assert\NotBlank(message: 'Password is mandatory')]
    #[Assert\Length(min: 6)]
    public string $password;
}
