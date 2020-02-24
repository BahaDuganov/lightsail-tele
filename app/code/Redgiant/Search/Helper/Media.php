<?php
namespace Redgiant\Search\Helper;

use Magento\Catalog\Helper\ImageFactory;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Redgiant\Core\Helper\Media as CoreMedia;

/**
 * Class Media
 * @package Redgiant\Search\Helper
 */
class Media extends CoreMedia
{
    const TEMPLATE_MEDIA_PATH = 'redgiant/search';

    /**
     * @var \Magento\Catalog\Helper\ImageFactory
     */
    protected $imageFactory;

    /**
     * Media constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     * @param \Magento\Framework\Image\AdapterFactory $adapterFactory
     * @param \Magento\Catalog\Helper\ImageFactory $imageFactory
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        ImageFactory $imageFactory
    )
    {
        parent::__construct($context, $objectManager, $storeManager, $filesystem, $uploaderFactory, $adapterFactory);

        $this->imageFactory = $imageFactory;
    }

    /**
     * Retrieve product image
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $imageId
     * @return string
     */
    public function getProductImage($product, $imageId = 'rgsearch_image')
    {
        $imageUrl = $this->imageFactory->create()
            ->init($product, $imageId)
            ->getUrl();

        $baseMediaUrl = $this->getSearchMediaUrl();
        if (strpos($imageUrl, $baseMediaUrl) === 0) {
            $imageUrl = substr($imageUrl, strlen($baseMediaUrl));
        }

        return $imageUrl;
    }

    /**
     * @return string
     */
    public function getSearchMediaUrl()
    {
        return $this->getBaseMediaUrl() . '/catalog/product/';
    }

    /**
     * @param $fileName
     * @param $content
     */
    public function createJsFile($fileName, $content)
    {
        try {
            $this->mediaDirectory->writeFile($fileName, $content);
        } catch (\Exception $e) {
            $this->_logger->critical($e->getMessage());
        }
    }

    /**
     * @return $this
     */
    public function removeJsPath()
    {
        $this->removePath(self::TEMPLATE_MEDIA_PATH);

        return $this;
    }
}