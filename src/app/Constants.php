<?php
declare(strict_types=1);

namespace App;

use App\Merchant\Merchants\TestMerchant;

/**
 * Interface Constants
 * @package App
 */
interface Constants
{

    /**
     * @var int
     */
    const MERCHANT_ID = Merchants::KRAGUJEVAC_TEST;
    /**
     * @var int
     */
    const MERCHANT_CONFIGURATION = TestMerchant::class;
    /**
     * @var int
     */
    const LANGUAGE = Languages::SERBIAN_CYRILLIC;
    /**
     * @var string
     */
    const APPLICATION_OWNER = 'Градска агенција за саобраћај';
    /**
     * @var string
     */
    const BASE_URL = 'https://itopup-kgbus.rs:9999/';
    /**
     * @var string
     */
    const SERVICE_BASE_URL = 'https://www.busplus.rs/wsApexPublic/';
    /**
     * @var string
     */
    const APPLICATION_OWNER_HOME_PAGE = 'https://www.kgbus.rs/';
    /**
     * @var string
     */
    const FAVICON_PATH = 'https://www.kgbus.rs/wp-content/uploads/2019/03/favicon-gas.png';
}
