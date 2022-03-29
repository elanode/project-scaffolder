<?php

namespace App\Exceptions;

use App\Domains\Authentication\Exceptions\UserActionException;
use App\Domains\Authentication\Exceptions\UserDtoException;
use App\Support\Http\ApiResponserTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponserTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        // });

        /** CUSTOM */
        $this->renderable(fn (UserDtoException $e, $request) => $this->throwableResponse($e));
        $this->renderable(fn (UserActionException $e, $request) => $this->throwableResponse($e));

        /** BUILT IN */
        $this->renderable(fn (AuthorizationException $e, $request) => $this->throwableResponse($e, $e->getCode()));
        $this->renderable(fn (ModelNotFoundException $e, $request) => $this->throwableResponse($e, $e->getCode()));
        $this->renderable(fn (NotFoundHttpException $e, $request) => $this->errorResponse('Route not found', 404));

        $this->renderable(
            fn (ValidationException $e, $request) => $this->throwableResponse(
                error: $e,
                code: 422,
                data: $e->validator->getMessageBag()
            )
        );

        $this->renderable(function (QueryException $e, $request) {
            if (config('app.env') != 'local') {
                return $this->errorResponse('Something went wrong, please try again later.', 500);
            }
        });

        $this->renderable(function (\PDOException $e, $request) {
            if (config('app.env') != 'local') {
                return $this->errorResponse('Something went wrong, please try again later.', 500);
            }
        });
    }
}
