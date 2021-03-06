<?php

namespace App\Infrastructure\Exceptions;

use App\Domains\Authentication\Exceptions\RoleDtoException;
use App\Domains\Authentication\Exceptions\UserActionException;
use App\Domains\Authentication\Exceptions\UserDtoException;
use App\Infrastructure\Exceptions\BaseCustomException;
use App\Support\Http\ApiResponserTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
        // $this->reportable(function (Throwable $e) {});

        /** CUSTOM */
        // $this->renderable(fn (UserActionException $e, $request) => $this->throwableResponse($e));
        $this->renderable(fn (BaseCustomException $e, $request) => $this->throwableResponse($e));
        $this->renderable(fn (UnauthorizedException $e, $request) => $this->throwableResponse($e, 403));

        /** BUILT IN */
        $this->renderable(fn (AccessDeniedHttpException $e, $request) => $this->throwableResponse($e, 403));
        $this->renderable(fn (AuthorizationException $e, $request) => $this->throwableResponse($e, $e->getCode()));
        $this->renderable(fn (ModelNotFoundException $e, $request) => $this->throwableResponse($e, $e->getCode()));
        $this->renderable(fn (NotFoundHttpException $e, $request) => $this->errorResponse('Resource not found', 404));

        $this->renderable(
            function (ValidationException $e, $request) {
                if ($request->expectsJson()) {
                    return $this->throwableResponse(
                        error: $e,
                        code: 422,
                        data: $e->validator->getMessageBag()
                    );
                }
            }
        );

        $this->renderable(function (\PDOException $e, $request) {
            if (config('app.env') != 'local') {
                return $this->errorResponse('Something went wrong, please try again later.', 500);
            }
        });

        $this->renderable(function (Exception $e, $request) {
            if (config('app.env') != 'local') {
                return $this->errorResponse($e->getMessage() ?? 'Something went wrong', $e->getCode());
            }
        });
    }
}
