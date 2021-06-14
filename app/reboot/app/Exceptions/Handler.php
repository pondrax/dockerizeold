<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $exception
     *
     * @throws \Exception
     *
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception)
    {
        $debugEnabled = env('APP_DEBUG');
        // var_dump($debugEnabled);
        $code = $this->isHttpException($exception) ? $exception->getStatusCode() : 500;

        if ($exception instanceof NotFoundHttpException) {
            return response(view('errors.404'), 404);
        }
        /*
         * Handle validation errors thrown using ValidationException.
         */
        if ($exception instanceof ValidationException) {
            $code = 422;
            $response = [
                'message' => __('exception.validation.message', [
                    'error' => implode(',', $exception->validator->messages()->all()),
                ]),
                'errors' => $exception->validator->errors()->getMessages(),
            ];
        }

        /*
         * Handle database errors thrown using QueryException.
         * Prevent sensitive information from leaking in the error message.
         */
        elseif ($exception instanceof QueryException) {
            if ($debugEnabled) {
                $errors = $exception->getMessage();
            } else {
                $errors = __('exception.query.error');
            }
            $response = [
                'message' => __('exception.query.message'),
                'errors'  => $errors,
            ];
        } else {
            $response = [
                'message' => __('exception.default.message'),
                'errors'  => $exception->getMessage(),
            ];
        }
        $response['status'] = [
            'success' => strpos((string) $code, '2'),
            'code'    => $code,
            'text'    => __('status.'.$code),
        ];
        if ($debugEnabled) {
            $response['exception'] = get_class($exception);
            $response['trace'] = explode("\n", $exception->getTraceAsString());
        }

        return response()->json($response, $code);
    }
}
