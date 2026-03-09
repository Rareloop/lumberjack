<?php

namespace App\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Rareloop\Lumberjack\Exceptions\Handler as LumberjackHandler;
use Rareloop\Lumberjack\Facades\Config;
use Rareloop\Lumberjack\Facades\Log;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Timber\Timber;
use Psr\Http\Message\ServerRequestInterface;

class Handler extends LumberjackHandler
{
    #[\Override]
    protected $dontReport = [];

    #[\Override]
    public function report(Exception $e)
    {
        parent::report($e);
    }

    #[\Override]
    public function render(ServerRequestInterface $request, Exception $e): ResponseInterface
    {
        // Provide a customisable error rendering when not in debug mode
        try {
            if (Config::get('app.debug') === false) {
                $data = Timber::context();
                $data['exception'] = $e;

                return new TimberResponse('templates/errors/whoops.twig', $data, 500);
            }
        } catch (Exception $customRenderException) {
            // Something went wrong in the custom renderer, log it and show the default rendering
            Log::error($customRenderException);
        }

        return parent::render($request, $e);
    }
}
