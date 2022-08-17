<?php

declare(strict_types=1);

namespace App\Api\Decorator;

use Apitte\Core\Decorator\IErrorDecorator;
use Apitte\Core\ErrorHandler\SimpleErrorHandler;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Apitte\Core\Exception\ApiException;
use GuzzleHttp\Psr7\Response;
use Tracy\Debugger;
use Tracy\ILogger;
use function GuzzleHttp\Psr7\stream_for;
use Throwable;

class SimpleApiErrorDecorator implements IErrorDecorator
{
	public function decorateError(ApiRequest $request, ApiResponse $response, Throwable $error): ApiResponse
	{
		return $this->createResponseFromError($response, $error);
	}

	protected function createResponseFromError(ApiResponse $response, Throwable $error): ApiResponse
	{
        Debugger::log($error, ILogger::EXCEPTION);

		$code = $error->getCode();

		$data = [
			'status' => 'error',
			'code' => $code,
			'message' => $error instanceof ApiException ? $error->getMessage() : 'Application encountered an internal error. Please try again later.',
		];

		if ($error instanceof ApiException && ($context = $error->getContext()) !== null) {
			$data['context'] = $context;
		}

		$body = stream_for(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | (defined('JSON_PRESERVE_ZERO_FRACTION') ? JSON_PRESERVE_ZERO_FRACTION : 0)));

		return $response
			->withStatus($code)
			->withHeader('Content-Type', 'application/json')
			->withBody($body);
	}
}