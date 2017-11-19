<?php

namespace CSC\Server\Request\Exception;

use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Class ValidationServerRequestException
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class ValidationServerRequestException extends ServerRequestException
{
    /**
     * @return array
     */
    public function normalize(): array
    {
        $details = [];

        foreach ($this->details as $detail) {
            /** @var ConstraintViolationInterface $detail */
            $details[] = [
                'field' => $detail->getPropertyPath(),
                'message' => $detail->getMessage(),
            ];
        }

        $exceptionDetails = [
            'error' => $this->getErrorType(),
            'description' => $this->getMessage(),
            'details' => $details,
            'status' => $this->getStatusCode(),
        ];

        return $exceptionDetails;
    }
}