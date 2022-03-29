<?php

namespace App\Exceptions;

use App\Support\Http\ApiResponserTrait;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e) {
            //
        });

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
