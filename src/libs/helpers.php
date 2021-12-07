<?php
function view(string $filename,array $data = []): void
{
    foreach($data as $key => $value){
        $$key = $value;
    }
    require_once __DIR__ .'/../inc/'.$filename.'.php';
}

function is_post_request(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

function is_get_request(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}