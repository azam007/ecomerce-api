<?php
namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

trait ExceptionTrait
{
    public function apiException($request, $e)
    {
        if($this->isModel($e)){
            return $this->modelResponse();
        }
        if($this->isHttp($e)){
            return $this->httpResponse();
        }

        return parent::render($request, $e);

    }

    protected function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isHttp($exception)
    {
        return $exception instanceof NotFoundHttpException;
    }

    protected function modelResponse(){
        return response()->json([
            'errors' => 'Not Found'
        ], Response::HTTP_NOT_FOUND);
    }

    protected function httpResponse(){
        return response()->json([
            'errors' => 'Incorrect Route!'
        ], Response::HTTP_NOT_FOUND);
    }
}