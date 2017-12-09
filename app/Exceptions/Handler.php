<?php

namespace App\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Rareloop\Lumberjack\Exceptions\Handler as LumberjackHandler;
use Zend\Diactoros\ServerRequest;

class Handler extends LumberjackHandler
{
    protected $dontReport = [];

    public function report(Exception $e)
    {
        parent::report($e);
    }

    public function render(ServerRequest $request, Exception $e) : ResponseInterface
    {
        return parent::render($request, $e);
    }
}
