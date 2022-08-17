<?php

namespace App\Api\Decorator;

use Apitte\Core\Decorator\IRequestDecorator;
use Apitte\Core\Exception\Runtime\EarlyReturnResponseException;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use Apitte\Core\Http\RequestAttributes;
use Apitte\Core\Schema\Endpoint;
use App\Api\Exceptions\SimpleApiException;
use App\Api\V1\Controllers\UsersController;
use JsonSchema\Validator;
use Taran\Model\Utils\StringUtils;
use Nette\Utils\Strings;
use Tracy\Debugger;

class JsonSchemaDecorator implements IRequestDecorator
{
	private Validator $validator;

	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Validate json body against json schema
	 * Only available for tags that have @Tag(name="validateJsonSchema")
	 * @param ApiRequest $request
	 * @param ApiResponse $response
	 * @return ApiRequest
	 */
	public function decorateRequest(ApiRequest $request, ApiResponse $response): ApiRequest
	{
		/** @var Endpoint $endpoint Schema of matched endpoint */
		$endpoint = $request->getAttribute(RequestAttributes::ATTR_ENDPOINT);

		if ($endpoint->hasTag('validateJsonSchema')) {
			$tag = $endpoint->getTag('validateJsonSchema');
            $tag = strval($tag);
			$jsonSchemaFilePath = sprintf("%s/ApiModule/JsonSchema/%s", APP_DIR, $tag);
			// Does json schema file exists ?
			if(is_file($jsonSchemaFilePath)){
				$jsonBody = $request->getJsonBody(FALSE);
				// Is json body submitted ?
				if($request->getBody()->getSize() > 0) {
					if (json_last_error()) {
						throw new SimpleApiException(sprintf("JSON violations: %s", json_last_error_msg()), 1000);
					}
					$this->validator->validate($jsonBody, (object)['$ref' => 'file://' . realpath($jsonSchemaFilePath)]);
					if (!$this->validator->isValid()) {
						$errorMessage = '';
						foreach ($this->validator->getErrors() as $jsonError) {
							$errorMessage .= sprintf("[%s] %s. ", $jsonError['property'], $jsonError['message']);
						}
						throw new SimpleApiException($errorMessage, 1002);
					}
				}else{
					throw new SimpleApiException("Json body is required!", 1001);
				}
			}else{
				throw new SimpleApiException(sprintf("Validation tag 'ValidateJsonSchema' is defined, but json schema does not exist in path [%s]", $jsonSchemaFilePath));
			}
		}

		return $request;
	}

}