<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Assets;
use App\BusPlusService\CardInfo;
use App\BusPlusService\ProductSearch;
use App\Validation\AliasNumberValidation;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class CardController
 *
 * @package App\Http\Controllers
 */
final class CardController
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * CardController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function getCardInfo(Request $request, Response $response): Response
    {
        $aliasNumberValidation = new AliasNumberValidation($this->container);
        if (!$aliasNumberValidation->run($request)->failed()) {
            $cardInfo = new CardInfo(Assets::cleanUpAliasNumber($request->getParam('alias-number')));
            $fields = [
                'exists'                   => $cardInfo->getExists(),
                'suspended'                => $cardInfo->getSuspended(),
                'alias_number'             => $cardInfo->getAliasNumber(),
                'card_type_id'             => $cardInfo->getCardCategoryId(),
                'category_name'            => $cardInfo->getCardCategoryName(),
                'category_expiry_date'     => $cardInfo->getCategoryExpiryDate(),
                'card_expiry_date'         => $cardInfo->getCardExpiryDate(),
                'card_is_disabled'         => $cardInfo->getCardIsDisabled(),
                'available_recharge_types' => $cardInfo->getAvailableRechargeTypes(),
                'available_zones'          => $cardInfo->getAvailableZones()
            ];
        }
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->container->view->render($response, 'search/index.twig', [
            'title'  => 'Допуна персонализованих картица',
            'fields' => isset($fields) ? $fields : []
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return string
     */
    public function getProductProfile(Request $request, Response $response): string
    {
        $aliasNumber = $request->getParam('alias-number');
        $rechargeTypeId = intval($request->getParam('recharge-type-id'));
        $zoneId = intval($request->getParam('zone-id'));
        $product = new ProductSearch($aliasNumber, $rechargeTypeId, $zoneId);
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->container->view->fetch('search/partial/product-profile-form.twig', [
            'fields' => [
                'alias_number'  => $product->getAliasNumber(),
                'product_id'    => $product->getProductId(),
                'product_price' => $product->getProductPrice(),
                'valid_from'    => $product->getValidFrom(),
                'valid_until'   => $product->getValidUntil()
            ]
        ]);
    }
}
