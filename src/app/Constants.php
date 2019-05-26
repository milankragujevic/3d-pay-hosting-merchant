<?php
declare(strict_types=1);

namespace App;

use App\Merchant\Merchants\BelgradeMerchant;

/**
 * Interface Constants
 * @package App
 */
interface Constants
{

    /**
     * @var int
     */
    const MERCHANT_ID = Merchants::BELGRADE_PRODUCTION;
    /**
     * @var int
     */
    const MERCHANT_CONFIGURATION = BelgradeMerchant::class;
    /**
     * @var int
     */
    const LANGUAGE = Languages::SERBIAN_CYRILLIC;
    /**
     * @var string
     */
    const APPLICATION_OWNER = 'Bus Plus';
    /**
     * @var string
     */
    const BASE_URL = 'http://itopup.busplus.rs:8888';
    /**
     * @var string
     */
    const SERVICE_BASE_URL = 'https://www.busplus.rs/wsApexPublic/';
    /**
     * @var string
     */
    const APPLICATION_OWNER_HOME_PAGE = 'https://www.busplus.rs/';
    /**
     * @var string
     */
    const FAVICON_PATH = 'https://www2.busplus.rs/media/icons/favicon.gif';
}
