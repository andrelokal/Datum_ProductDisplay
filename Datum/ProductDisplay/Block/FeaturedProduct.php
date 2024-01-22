<?php

namespace Datum\ProductDisplay\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Datum\ProductDisplay\Helper\Data;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

/**
 * Featured Product Block class.
 *
 * @category Datum
 * @package  Datum_ProductDisplay
 * @author   Andre Martos (andrelokal@gmail.com)
 */
class FeaturedProduct extends Template
{
    /**
     * Product collection factory.
     *
     * @var CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     * Helper object.
     *
     * @var Data
     */
    protected $_helper;

    /**
     * Image helper.
     *
     * @var ImageHelper
     */
    protected $_imageHelper;

    /**
     * Price helper.
     *
     * @var PriceHelper
     */
    protected $_priceHelper;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param Data $helper
     * @param ImageHelper $imageHelper
     * @param PriceHelper $priceHelper
     * @param array $data
     */
    public function __construct(
        Context           $context,
        CollectionFactory $productCollectionFactory,
        Data              $helper,
        ImageHelper       $imageHelper,
        PriceHelper       $priceHelper,
        array             $data = []
    )
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_helper = $helper;
        $this->_imageHelper = $imageHelper;
        $this->_priceHelper = $priceHelper;
        parent::__construct($context, $data);
    }

    /**
     * Retrieves the featured product.
     *
     * @return ProductInterface|null
     */
    public function getFeaturedProduct(): ?ProductInterface
    {
        if (!$this->_helper->isModuleEnabled()) {
            return null;
        }

        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('datum_featured_product', 1)
            ->setPageSize(1);

        return $collection->getFirstItem();
    }

    /**
     * Get product image URL.
     *
     * @param ProductInterface $product
     * @return string
     */
    public function getProductImageUrl(ProductInterface $product): string
    {
        return $this->_imageHelper->init($product, 'product_base_image')->getUrl();
    }

    /**
     * Get formatted product price.
     *
     * @param ProductInterface $product
     * @return string
     */
    public function getFormattedPrice(ProductInterface $product): string
    {
        return $this->_priceHelper->currency($product->getPrice(), true, false);
    }

    /**
     * Get product URL.
     *
     * @param ProductInterface $product
     * @return string
     */
    public function getProductUrl(ProductInterface $product): string
    {
        return $product->getProductUrl();
    }
}
