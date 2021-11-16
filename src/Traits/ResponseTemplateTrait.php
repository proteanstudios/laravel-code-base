<?php

namespace Pros\CodeBase\Traits;

trait ResponseTemplateTrait
{
    /**
     *
     * @param string $message
     * @param mixed  $code
     */
    public function jsonError(string $message = '', $status = 'ERR', $code = 401)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message
        ], $code);
    }

    /**
     *
     * @param string $message
     * @param mixed  $code
     * @param mixed  $data
     */
    public function jsonSuccess($data = [], $status = 'OK', $code = 200)
    {
        return response()->json([
            'status' => $status,
            'data'   => $data
        ], $code);
    }

    /**
     *
     * @param mixed $code
     */
    public function jsonSuccessNoContent($status = 'OK', $code = 204)
    {
        return response()->json([
            'status' => $status
        ], $code);
    }
}
