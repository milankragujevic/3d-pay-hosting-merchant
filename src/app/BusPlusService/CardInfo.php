<?php
declare(strict_types=1);

namespace App\BusPlusService;

use DateTime;
use Exception;
use RuntimeException;
use stdClass;

/**
 * Class CardInfo
 *
 * @package App\BusPlusService
 */
final class CardInfo extends Service
{

    /**
     * @var string
     */
    private $aliasNumber;
    /**
     * @var bool
     */
    private $exists;
    /**
     * @var bool
     */
    private $suspended;
    /**
     * @var int|null
     */
    private $cardCategoryId;
    /**
     * @var string|null
     */
    private $cardCategoryName;
    /**
     * @var bool|null
     */
    private $cardIsDisabled;
    /**
     * @var DateTime|null
     */
    private $categoryExpiryDate;
    /**
     * @var DateTime|null
     */
    private $cardExpiryDate;
    /**
     * @var array|null
     */
    private $availableRechargeTypes;
    /**
     * @var array|null
     */
    private $availableZones;

    /**
     * CardInfo constructor.
     * @param string $aliasNumber
     */
    public function __construct(string $aliasNumber)
    {
        $this->aliasNumber = $aliasNumber;
        parent::__construct($this->cardInfoServiceURI($aliasNumber));
    }

    /**
     * @return string|null
     */
    public function getAliasNumber(): ?string
    {
        return $this->aliasNumber;
    }

    /**
     * @return int|null
     */
    public function getCardCategoryId(): ?int
    {
        return $this->cardCategoryId;
    }

    /**
     * @return string|null
     */
    public function getCardCategoryName(): ?string
    {
        return $this->cardCategoryName;
    }

    /**
     * @return bool|null
     */
    public function getCardIsDisabled(): ?bool
    {
        return $this->cardIsDisabled;
    }

    /**
     * @return DateTime|null
     */
    public function getCategoryExpiryDate(): ?DateTime
    {
        return $this->categoryExpiryDate;
    }

    /**
     * @return DateTime|null
     */
    public function getCardExpiryDate(): ?DateTime
    {
        return $this->cardExpiryDate;
    }

    /**
     * @return array|null
     */
    public function getAvailableRechargeTypes(): ?array
    {
        return $this->availableRechargeTypes;
    }

    /**
     * @return array|null
     */
    public function getAvailableZones(): ?array
    {
        return $this->availableZones;
    }

    /**
     * @param stdClass $responseData
     *
     * @return void
     *
     * @throws Exception
     */
    protected function responseData(stdClass $responseData): void
    {
        $this->setExists($responseData->exists);
        if ($this->getExists()) {
            $this->setSuspended($responseData->suspended);
            if (!$this->getSuspended()) {
                $this->setCardCategoryId($responseData->card_details->card_category_id);
                $this->setCardCategoryName($responseData->card_details->card_category_name);
                $this->setCardIsDisabled($responseData->card_details->card_is_disabled);
                $this->setCategoryExpiryDate($responseData->card_details->category_expiry_date);
                $this->setCardExpiryDate($responseData->card_details->card_expiry_date);
                $this->setAvailableRechargeTypes($responseData->available_recharge_types);
                $this->setAvailableZones($responseData->available_zones);
            }
        }
    }

    /**
     * @param bool|null $exists
     *
     * @return void
     */
    private function setExists(?bool $exists): void
    {
        $this->exists = $exists;
    }

    /**
     * @return bool|null
     */
    public function getExists(): ?bool
    {
        return $this->exists;
    }

    /**
     * @param bool|null $suspended
     *
     * @return void
     */
    private function setSuspended(?bool $suspended): void
    {
        $this->suspended = $suspended;
    }

    /**
     * @return bool|null
     */
    public function getSuspended(): ?bool
    {
        return $this->suspended;
    }

    /**
     * @param int|null $cardCategoryId
     *
     * @return void
     */
    private function setCardCategoryId(?int $cardCategoryId): void
    {
        $this->cardCategoryId = $cardCategoryId;
    }

    /**
     * @param string|null $cardCategoryName
     *
     * @return void
     */
    private function setCardCategoryName(?string $cardCategoryName): void
    {
        $this->cardCategoryName = $cardCategoryName;
    }

    /**
     * @param bool|null $cardIsDisabled
     *
     * @return void
     */
    private function setCardIsDisabled(?bool $cardIsDisabled): void
    {
        $this->cardIsDisabled = $cardIsDisabled;
    }

    /**
     * @param string|null $categoryExpiryDate
     *
     * @return void
     *
     * @throws RuntimeException
     */
    private function setCategoryExpiryDate(?string $categoryExpiryDate): void
    {
        try {
            $this->categoryExpiryDate = new DateTime($categoryExpiryDate);
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param string|null $cardExpiryDate
     *
     * @return void
     *
     * @throws RuntimeException
     */
    private function setCardExpiryDate(?string $cardExpiryDate): void
    {
        try {
            $this->cardExpiryDate = new DateTime($cardExpiryDate);
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param array|null $availableRechargeTypes
     *
     * @return void
     */
    private function setAvailableRechargeTypes(?array $availableRechargeTypes): void
    {
        $this->availableRechargeTypes = $availableRechargeTypes;
    }

    /**
     * @param array|null $availableZones
     *
     * @return void
     */
    private function setAvailableZones(?array $availableZones): void
    {
        $this->availableZones = $availableZones;
    }
}
