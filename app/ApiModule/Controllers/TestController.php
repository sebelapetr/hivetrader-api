<?php declare(strict_types=1);

namespace App\Api\V1\Controllers;

use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\RequestParameters;
use Apitte\Core\Annotation\Controller\RequestParameter;
use Apitte\Core\Annotation\Controller\Tag;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use GuzzleHttp\Psr7\Utils;
use Money\Currency;
use Money\Money;
use Tracy\Debugger;
use Tracy\ILogger;

/**
 * @Path("/test")
 */
class TestController extends BaseV1Controller
{
    /**
     * @Path("/")
     * @Method("GET")
     */
    public function default(ApiRequest $request, ApiResponse $response): ApiResponse
    {
        $this->showTracyBar();
        try {
            //$parameters = $request->getJsonBody();

            $data = [
                'status' => 'success',
                'code' => ApiResponse::S200_OK,
                'message' => 'Poster generated'
            ];
            $body = Utils::streamFor('It works.');
            return $response
                ->withStatus(ApiResponse::S200_OK)
                ->withHeader('Content-Type', 'text/plain')
                ->withBody($body);

        } catch (\Exception $exception)
        {
            Debugger::log($exception, ILogger::EXCEPTION);
            return $this->throwErrorResponse($response, 'error', ApiResponse::S500_INTERNAL_SERVER_ERROR);
        }
    }
}
