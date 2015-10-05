<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return response()->json(['message' => 'Bad request.', 'code' => 400], 400);
        } elseif ($e instanceof FundNotFoundException) {
            return response()->json(['message' => 'The fund could not be found.', 'code' => 404], 404);
        } elseif ($e instanceof ProvisionTypeNotFoundException) {
            return response()->json(['message' => 'The provision type could not be found.', 'code' => 404], 404);
        } elseif ($e instanceof CountryNotFoundException) {
            return response()->json(['message' => 'The country could not be found.', 'code' => 404], 404);
        } elseif ($e instanceof RegionNotFoundException) {
            return response()->json(['message' => 'The region could not be found.', 'code' => 404], 404);
        } elseif ($e instanceof LocationNotFoundException) {
            return response()->json(['message' => 'The location could not be found.', 'code' => 404], 404);
        } elseif ($e instanceof OrganisationTypeNotFoundException) {
            return response()->json(['message' => 'The organisation type could not be found.', 'code' => 404], 404);
        } elseif ($e instanceof ProviderNotFoundException) {
            return response()->json(['message' => 'The provider could not be found.', 'code' => 404], 404);
        }
//        else
//        {
//            return response()->json(['message' => 'An unexpected error occurred. Please try again later.', 'code' => 500], 500);
//        }

        return parent::render($request, $e);
    }
}
