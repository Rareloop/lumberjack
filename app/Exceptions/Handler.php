<?php

namespace App\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Rareloop\Lumberjack\Exceptions\Handler as LumberjackHandler;
use Rareloop\Lumberjack\Facades\Config;
use Rareloop\Lumberjack\Facades\Log;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Timber\Timber;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class Handler extends LumberjackHandler
{
    protected $dontReport = [];

    public function report(Throwable $e)
    {
        parent::report($e);
    }

    public function render(ServerRequestInterface $request, Throwable $e): ResponseInterface
    {
        // Provide a customisable error rendering when not in debug mode
        try {
            if (Config::get('app.debug') === false) {
                $data = Timber::get_context();
                $data['exception'] = $e;

                return new TimberResponse('templates/errors/whoops.twig', $data, 500);
            }
        } catch (Throwable $customRenderException) {
            // Something went wrong in the custom renderer, log it and show the default rendering
            Log::error($customRenderException);
        }

        return parent::render($request, $e);
    }
}
