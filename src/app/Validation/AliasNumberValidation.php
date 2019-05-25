<?php
declare(strict_types=1);

namespace App\Validation;

use App\Validator;
use Respect\Validation\Validator as v;
use Slim\Container;
use Slim\Http\Request;

/**
 * Class AliasNumberValidation
 * @package App\Validation
 */
class AliasNumberValidation
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * AliasNumberValidation constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return Validator
     */
    public function run(Request $request): Validator
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->container->validator->validate($request, [
            'alias-number' => v::notEmpty()->addRule(v::digit('-'))->addRule(v::length(11, 13))
                ->setName('Алиас број картице')
        ]);
    }
}