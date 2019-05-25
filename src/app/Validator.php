<?php
declare(strict_types=1);

namespace App;

use Respect\Validation\Exceptions\NestedValidationException;
use Slim\Container;
use Slim\Http\Request;

/**
 * Class Validator
 * @package App
 */
class Validator
{

    /**
     * @var array
     */
    protected $errors;
    /**
     * @var Container
     */
    protected $container;

    /**
     * Validator constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param array $rules
     * @return Validator
     */
    public function validate(Request $request, array $rules): Validator
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = array_filter($e->findMessages([
                    'notEmpty' => '{{name}} не сме бити празно поље',
                    'digit'    => '{{name}} може да садржи само цифре (0-9) и " - "',
                    'length'   => '{{name}} мора бити дужине између 11 и 13'
                ]), function ($row) {
                    return !empty($row);
                });
            }
        }
        /** @noinspection PhpUndefinedFieldInspection */
        $this->container->view->getEnvironment()->addGlobal('errors', $this->errors);
        return $this;
    }

    /**
     * @return bool
     */
    public function failed(): bool
    {
        return !empty($this->errors);
    }
}