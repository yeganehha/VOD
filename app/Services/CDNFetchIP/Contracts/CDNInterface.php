<?php

namespace App\Services\CDNFetchIP\Contracts;


interface CDNInterface
{
    public function fetch():?array;
}
