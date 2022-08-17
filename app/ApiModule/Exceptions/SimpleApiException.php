<?php

declare(strict_types=1);

namespace App\Api\Exceptions;

use Apitte\Core\Exception\ApiException;
use Throwable;

class SimpleApiException extends ApiException
{

	public function __construct(string $message = '', int $code = 400, ?Throwable $previous = null, $context = null)
	{
		parent::__construct($message, $code, $previous, $context);
	}

}