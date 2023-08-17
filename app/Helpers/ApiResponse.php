<?php

namespace App\Helpers;

/**
 * Reference: https://umbraco.com/knowledge-base/http-status-codes/#:~:text=What%20does%20200%20OK%20mean,in%20without%20the%20message%20body
 */
class ApiResponse
{
    public static function error($message=null, $errors=null, $data=null, $status=null)
    {
      $data = [
        'message' => $message ?? config('constants.BAD_REQUEST.MESSAGE'),
        'errors' => $errors,
        'data' => $data,
      ];

      $status = $status ?? config('constants.BAD_REQUEST.CODE');

      return response()->json($data, $status);
    }

    public static function success($message=null, $data=null, $status=null)
    {
      $data = [
        'message' => $message ?? config('constants.SUCCESS.MESSAGE'),
        'data' => $data,
      ];

      $status = $status ?? config('constants.SUCCESS.CODE');

      return response()->json($data, $status);
    }

    public static function serverError($errors=null, $data=null)
    {
      return self::error(
        config('constants.SERVER_ERROR.MESSAGE'),
        $errors,
        $data,
        config('constants.SERVER_ERROR.CODE'),
      );
    }

    public static function unauthorized($errors=null, $data=null)
    {
      return self::error(
        config('constants.UNAUTHORIZED.MESSAGE'),
        $errors,
        $data,
        config('constants.UNAUTHORIZED.CODE'),
      );
    }

    public static function forbidden($errors=null, $data=null)
    {
      return self::error(
        config('constants.FORBIDDEN.MESSAGE'),
        $errors,
        $data,
        config('constants.FORBIDDEN.CODE'),
      );
    }

    public static function created($message=null, $data=null)
    {
      return self::success(
        $message ?? config('constants.CREATED.MESSAGE'),
        $data,
        config('constants.CREATED.CODE'),
      );
    }

    public static function noContent($message=null, $data=null)
    {
      return self::success(
        $message ?? config('constants.NO_CONTENT.MESSAGE'),
        $data,
        config('constants.NO_CONTENT.CODE'),
      );
    }
}