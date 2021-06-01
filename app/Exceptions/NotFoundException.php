<?php
 
namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Throwable;

class NotFoundException extends Exception
{

    /*
     * var $message
     */
    protected $message;
    /*
     * var $code
     */
    protected $code;
    /*
     * var $previous
     */
    protected $previous;

    /**
     * NotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = "This entity not found!",
        $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }
 
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {

        return response()->json([
            'type'    => 'error',
            'code'    => $this->code,
            'message' => $this->message,
        ], $this->code);
    }
}