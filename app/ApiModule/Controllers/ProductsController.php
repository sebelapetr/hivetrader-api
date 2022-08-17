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
use Nette\Utils\Json;
use Tracy\Debugger;
use Tracy\ILogger;

/**
 * @Path("/products")
 */
class ProductsController extends BaseV1Controller
{
    /**
     * @Path("/")
     * @Method("GET")
     */
    public function default(ApiRequest $request, ApiResponse $response): ApiResponse
    {
        $apiHash = $this->getApiHash($request);
        $this->showTracyBar();
        try {
            $productsData = $this->getProductsData($apiHash);
            $body = Utils::streamFor($productsData);
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

    /**
     * @Path("/stock")
     * @Method("GET")
     */
    public function stock(ApiRequest $request, ApiResponse $response): ApiResponse
    {
        $apiHash = $this->getApiHash($request);
        $this->showTracyBar();
        try {
            $productsStock = $this->getProductsStock($apiHash);
            $body = Utils::streamFor($productsStock);
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

    private function getProductsData(string $apiHash): string
    {
        $data = [];
        $marketId = $this->connection->query("SELECT id FROM markets WHERE api_hash = %s", $apiHash)->fetchField();
        if ($marketId) {
            $marketProducts = $this->connection->query("SELECT * FROM market_products WHERE market_id = %i", $marketId);
            if ($marketProducts) {
                foreach ($marketProducts as $marketProduct) {
                    $data[$marketProduct->number] = [
                        "name" => $marketProduct->name,
                        "created_at" => $marketProduct->created_at,
                        "price_without_vat" => $marketProduct->price_without_vat,
                        "price_with_vat" => $marketProduct->price_with_vat,
                        "vat" => $marketProduct->vat,
                    ];
                }
            }
        }

        return Json::encode($data);
    }

    private function getProductsStock(string $apiHash): string
    {
        $data = [];
        $marketId = $this->connection->query("SELECT id FROM markets WHERE api_hash = %s", $apiHash)->fetchField();
        if ($marketId) {
            $marketProducts = $this->connection->query("SELECT * FROM market_products WHERE market_id = %i", $marketId);
            if ($marketProducts) {
                foreach ($marketProducts as $marketProduct) {
                    $data[$marketProduct->number] = [
                        "quantity" => 5,
                    ];
                }
            }
        }

        return Json::encode($data);
    }
}