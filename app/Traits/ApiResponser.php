<?php

namespace App\Traits;

trait ApiResponser {

  private function successResponse($data, $code) {
    return response()->json($data, $code);
  }

  protected function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
  }

  protected function showResponse($data, $code = 200)
	{
		return $this->successResponse($data, $code);
  }

  protected function showMessage($message, $code = 200)
	{
		return $this->successResponse(['data' => $message], $code);
	}
}