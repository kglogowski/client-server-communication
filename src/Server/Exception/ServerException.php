<?php

namespace CSC\Server\Exception;

use CSC\Component\Normalizer\Normalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class ServerException
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class ServerException extends \Exception implements HttpExceptionInterface, Normalizer
{
    /**
     * Resource not found.
     */
    const ERROR_TYPE_RESOURCE_NOT_FOUND = 'resource_not_found';

    /**
     * Access forbidden.
     */
    const ERROR_TYPE_ACCESS_FORBIDDEN = 'access_forbidden';

    /**
     * Bad parameter in request
     */
    const ERROR_TYPE_INVALID_PARAMETER = 'invalid_parameter';

    /**
     * Validation error
     */
    const ERROR_TYPE_VALIDATION_FAILED = 'validation_failed';

    /**
     * Authorization failed
     */
    const ERROR_TYPE_AUTHORIZATION_FAILED = 'authorization_failed';

    /**
     * Something is busy
     */
    const ERROR_TYPE_BUSY = 'busy_failed';

    /**
     * General error
     */
    const ERROR_SYSTEM_ERROR = 'system_error';

    /**
     * @var array
     */
    protected $headers;

    /**
     * Typ błedu np access_forbidden
     *
     * @var string
     */
    protected $errorType;

    /**
     * @var mixed
     */
    protected $details;

    /**
     * ServerException constructor.
     *
     * @param string          $errorType
     * @param string          $message
     * @param mixed           $details
     * @param int             $code
     * @param \Exception|null $previous
     * @param array           $headers
     */
    public function __construct(
        string $errorType,
        string $message = '',
        $details = null,
        int $code = 0,
        \Exception $previous = null,
        array $headers = array()
    )
    {
        if (0 === $code) {
            $code = Response::HTTP_BAD_REQUEST;
        }

        $this->headers = $headers;
        $this->errorType = $errorType;
        $this->details = $details;

        parent::__construct($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->getCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return array
     */
    public function normalize(): array
    {
        return [
            'error' => $this->getErrorType(),
            'description' => $this->getMessage(),
            'details' => $this->getDetails(),
            'status' => $this->getStatusCode(),
        ];
    }
}