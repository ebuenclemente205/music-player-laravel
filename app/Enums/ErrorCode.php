<?php

namespace App\Enums;

class ErrorCode
{
    const GENERAL_ERROR = 'GENERAL_ERROR';
    const VALIDATION_ERROR = 'VALIDATION_ERROR';
    const AUTHENTICATION_ERROR = 'AUTHENTICATION_ERROR';
    const AUTHORIZATION_ERROR = 'AUTHORIZATION_ERROR';
    const NOT_FOUND_ERROR = 'NOT_FOUND_ERROR';
    const SERVER_ERROR = 'SERVER_ERROR';

    /**
     * Descriptions for each error code.
     *
     * @var array
     */
    protected static $descriptions = [
        self::GENERAL_ERROR => 'A general error has occurred.',
        self::VALIDATION_ERROR => 'Validation failed for the given data.',
        self::AUTHENTICATION_ERROR => 'Authentication failed, the credentials provided are incorrect.',
        self::AUTHORIZATION_ERROR => 'You do not have permission to perform this action.',
        self::NOT_FOUND_ERROR => 'The requested resource could not be found.',
        self::SERVER_ERROR => 'An internal server error has occurred.',
    ];

    /**
     * Get the description for the given error code.
     *
     * @param int $errorCode
     * @return string|null
     */
    public static function getDescription(int $errorCode): ?string
    {
        return self::$descriptions[$errorCode] ?? null;
    }
}
