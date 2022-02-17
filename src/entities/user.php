<?php

class User{

    function __construct(
        public string $username,
        public string $email,
        public string $password,
        public string $about,
        public string $profileURL = ''
        ){}
}