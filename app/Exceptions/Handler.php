<?php

    namespace App\Exceptions;
    
    use Exception;
    use PDOException;
    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    use Illuminate\Http\Exceptions\PostTooLargeException;

    class Handler extends ExceptionHandler
    {
        /**
         * A list of the exception types that are not reported.
         *
         * @var array
         */
        protected $dontReport = [
            //
        ];
    
        /**
         * A list of the inputs that are never flashed for validation exceptions.
         *
         * @var array
         */
        protected $dontFlash = [
            'password',
            'password_confirmation',
        ];
    
        /**
         * Report or log an exception.
         *
         * @param  \Exception  $exception
         * @return void
         */
        public function report(Exception $exception)
        {
            parent::report($exception);
        }
    
        /**
         * Render an exception into an HTTP response.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Exception  $e
         * @return \Illuminate\Http\Response
         */
        public function render($request, Exception $e)
        {
            if ($e instanceof PostTooLargeException) {
                return response()->json([
                    'result' => false,
                    'error' => trans('errors.tooBigImage')
                ]);
            }
            else if ($this->isHttpException($e)) {
                if ($e->getCode() === 404) {
                    return response()->view('errors.404', [], 404);
                }
            }
            else if ($e instanceof PDOException) {
                return response()->view('errors.500', [], 500);
            }
            
            return parent::render($request, $e);
        }
    }
