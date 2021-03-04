<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
  
  use ApiResponser;
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

    $this->renderable(function (ValidationException $e, $request) {
      return $this->convertValidationExceptionToResponse($e, $request);
    });

    $this->renderable(function (ModelNotFoundException $e) {
      $modelo = strtolower(class_basename($e->getModel()));
      return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id especificado", 404);
    });

    $this->renderable(function (AuthenticationException $e, $request) {
      return $this->unauthenticated($request, $e);
    });

    $this->renderable(function (AuthorizationException $e) {
      return $this->errorResponse('No posee permisos para ejecutar esta acción', 403);
    });

    $this->renderable(function (NotFoundHttpException $e) {
      return $this->errorResponse('No se encontró la URL especificada', 404);
    });

    $this->renderable(function (MethodNotAllowedHttpException $e) {
      return $this->errorResponse('El método especificado en la petición no es válido', 405);
    });

    $this->renderable(function (HttpException $e) {
      return $this->errorResponse($e->getMessage(), $e->getStatusCode());
    });


    $this->renderable(function (QueryException $e) {
      $codigo = $e->errorInfo[1];

      if ($codigo == 1451) {
        return $this->errorResponse('No se puede eliminar de forma permamente el recurso porque está relacionado con algún otro.', 409);
      }
    });

    $this->renderable(function (Throwable $e) {
      return $this->errorResponse($e->getMessage(), 500);
    });
  }

  protected function convertValidationExceptionToResponse(ValidationException $e, $request)
  {
    $errors = $e->validator->errors()->getMessages();

    return $this->errorResponse($errors, 422);

  }

  protected function unauthenticated($request, AuthenticationException $exception)
  {
    return $this->errorResponse('No autenticado.', 401);
  }
}
