<?php
declare(strict_types=1);


namespace App\Validation;

use App\Order\Order;
use App\Validator;
use Respect\Validation\Validator as v;
use Slim\Container;
use Slim\Http\Request;

/**
 * Class AddItemValidation
 *
 * @package App\Validation
 */
class AddItemValidation
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * AliasNumberValidation constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     *
     * @return Validator
     */
    public function run(Request $request): Validator
    {
        $isUnique = function (string $aliasNumber): bool {
            $order = new Order();
            $items = $order->getOrderItemsArray();
            return empty(array_filter($items, function ($item) use ($aliasNumber) {
                return $item['alias_number'] == $aliasNumber;
            }));
        };
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->container->validator->validate($request, [
            'alias-number' => v::notEmpty()->addRule(v::digit('-'))->addRule(v::length(11, 13))
                ->addRule(v::callback($isUnique))->setName('Алиас број картице'),
            'product-id'   => v::notEmpty()->addRule(v::digit())->setName('Шифра производа')
        ]);
    }
}