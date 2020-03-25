<?php

namespace Wbcom\StoreLocator\Controller\Adminhtml\Store;

use Magento\Framework\Controller\ResultFactory;
use PHPUnit\Runner\Exception;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var bool
     */
    protected $resultPageFactory = false;
    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_fileUploaderFactory;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Wbcom\StoreLocator\Model\StoreFactory $storeFactory
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     * @param \Magento\Framework\Filesystem $filesystem
     */

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Wbcom\StoreLocator\Model\StoreFactory $storeFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Filesystem $filesystem
    )
    {
        parent::__construct($context);
        $this->_messageManager = $context->getMessageManager();
        $this->_resultFactory = $context->getResultFactory();
        $this->storeFactory = $storeFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_filesystem = $filesystem;
    }
    public function execute()
    {
		$files = $this->getRequest()->getFiles();
        $postData = $this->getRequest()->getParams();
        $imageName = '';
        if ($files['image']['name']) {
            try {
                $uploader = $this->_fileUploaderFactory->create(['fileId' => 'image']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $mediaUrl=$this->_filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('/images');
                $result = $uploader->save($mediaUrl);                
            } catch (\Exception $e) {                
                $this->_messageManager->addError($e->getMessage());
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                return $resultRedirect;
            }
            $imageName = 'images/'.$files['image']['name'];
        }else{
            if ((isset($postData['image'])) && (array_key_exists('value', $postData['image']))){
                $imageName = $postData['image']['value'];
            }
        }

        $imageNameLap = '';
        if ($files['imagelap']['name']) {
            try {
                $uploader = $this->_fileUploaderFactory->create(['fileId' => 'imagelap']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $mediaUrl=$this->_filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('/images1');
                $result = $uploader->save($mediaUrl);
            } catch (\Exception $e) {
                $this->_messageManager->addError($e->getMessage());
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                return $resultRedirect;
            }
            $imageNameLap = 'images1/'.$files['imagelap']['name'];
        }else{
            if ((isset($postData['imagelap'])) && (array_key_exists('value', $postData['imagelap']))){
                $imageNameLap = $postData['imagelap']['value'];
            }
        }
		
        $model = $this->storeFactory->create();
        if(isset($postData['id'])) {
            $model = $model->load($postData['id']);
        }
        try {
            $model->setStatus($postData['status']);
            $model->setStoreName($postData['store_name']);
            $model->setCountry($postData['country']);
            $model->setStoreDescription($postData['store_description']);
            $model->setLattitude($postData['lattitude']);
            $model->setLongitude($postData['longitude']);
            $model->setZoomLevel($postData['zoom_level']);
            $model->setCountry($postData['country']);
            $model->setState($postData['state']);
            $model->setCity($postData['city']);
            $model->setZipcode($postData['zipcode']);
            if ((isset($postData['image'])) || (!empty($imageName))){
                if ((isset($postData['image'])) && (array_key_exists('delete', $postData['image']))){
                    $model->setImage('');
                }else{
                    $model->setImage($imageName);
                }
            }
            if ((isset($postData['imagelap'])) || (!empty($imageNameLap))){
                if ((isset($postData['imagelap'])) && (array_key_exists('delete', $postData['imagelap']))){
                    $model->setImagelap('');
                }else{
                    $model->setImagelap($imageNameLap);
                }
            }
            $model->setAddress($postData['address']);
            $model->setStoreIds(json_encode($postData['store_ids']));
            $model->setWorkingDays(json_encode($postData['workingDays']));
            $model->setContactEmail($postData['contact_email']);
            $model->setContactNo($postData['contact_no']);
            try{
                $model->save();
                $this->_messageManager->addSuccessMessage('Store added succesfully.');
            }catch(\Exception $e){
                $this->_messageManager->addErrorMessage('Something went wrong while saving store');
            }
        } catch (Exception $e) {
            $this->_messageManager->addErrorMessage('Something went wrong '.$e->getMessage());
        }
        $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('wbstore/store/index');
        return $resultRedirect;
    }    
}
