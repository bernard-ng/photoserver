<?php
namespace Ng\Photoserver;


/**
 * Class Server
 * @package Ng\Photoserver
 */
class Server 
{

    /**
     * Server constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }
}