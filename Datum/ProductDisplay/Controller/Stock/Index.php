<?php

namespace Datum\ProductDisplay\Controller\Stock;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\Controller\Result\Json;

/**
 * Controller for stock index.
 *
 * @category Datum
 * @package  Datum_ProductDisplay
 * @author   Andre Martos (andrelokal@gmail.com)
 */
class Index extends Action
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var StockRegistryInterface
     */
    protected $stockRegistry;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param JsonFactory $resultJsonFactory
     * @param StockRegistryInterface $stockRegistry
     */
    public function __construct(
        Context                    $context,
        ProductRepositoryInterface $productRepository,
        JsonFactory                $resultJsonFactory,
        StockRegistryInterface     $stockRegistry
    )
    {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->stockRegistry = $stockRegistry;
    }

    /**
     * Execute action based on request and return result
     *
     * @return Json
     */
    public function execute(): Json
    {
        $result = $this->resultJsonFactory->create();
        $productId = $this->getRequest()->getParam('product_id');

        if ($productId) {
            try {
                $product = $this->productRepository->getById($productId);
                $stockItem = $this->stockRegistry->getStockItem($product->getId());
                $stockQty = $stockItem->getQty();

                return $result->setData(['qty' => $stockQty]);
            } catch (\Exception $e) {
                return $result->setData(['error' => $e->getMessage()]);
            }
        }

        return $result->setData(['error' => 'Product ID not specified']);
    }
}
