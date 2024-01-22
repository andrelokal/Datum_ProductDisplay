<?php

namespace Datum\ProductDisplay\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Helper class for Datum Product Display.
 *
 * @category Datum
 * @package  Datum_ProductDisplay
 * @author   Andre Martos (andrelokal@gmail.com)
 */
class Data extends AbstractHelper
{
    /**
     * XML path for the configuration
     */
    const XML_PATH = 'datum_productdisplay/general/%s';

    /**
     * Constructor.
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Get value from store configuration.
     *
     * @param string $field
     * @return mixed
     */
    public function getConfigValue($field)
    {
        $path = sprintf(self::XML_PATH, $field);
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if the module is enabled in the store configuration.
     *
     * @return bool
     */
    public function isModuleEnabled(): bool
    {
        return $this->getConfigValue('enabled') == 1;
    }

}
