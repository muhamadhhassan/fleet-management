<?php

namespace App\Exceptions;

use Exception;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

class ValidationException extends Exception implements RendersErrorsExtensions
{
    /**
    * @var @string
    */
    protected $errors;

    protected $code = 422;

    public function __construct(string $message, array $errors = [])
    {
        parent::__construct($message);

        $this->errors = $this->mapErrors($errors);
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     *
     * @api
     * @return bool
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * Returns string describing a category of the error.
     *
     * Value "graphql" is reserved for errors produced by query parsing or validation, do not use it.
     *
     * @api
     * @return string
     */
    public function getCategory(): string
    {
        return 'custom';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function extensionsContent(): array
    {
        return [
            'some' => 'additional information',
            'reason' => $this->errors,
        ];
    }

    protected function mapErrors(array $errors)
    {
        $errorMessages = [];
        
        foreach ($errors as $field => $error) {
            $errorMessages[$field] = $error[0];
        }

        return $errorMessages;
    }
}