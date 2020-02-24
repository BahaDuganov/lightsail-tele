<?php
namespace Redgiant\Goodwin\Plugin;

use Magento\Framework\App\ResponseInterface;

class UpdateBodyClass
{
	private $context;
	protected $helper;

	public function __construct(
		\Magento\Framework\View\Element\Context $context,
		\Redgiant\Goodwin\Helper\Data $helper
	) {
		$this->context = $context;
		$this->helper = $helper;
	}

	public function beforeRenderResult(\Magento\Framework\View\Result\Page $subject, ResponseInterface $response) {
		
		$boxed_layout = $this->helper->getConfig('goodwin_settings/general/boxed_layout');
		if($boxed_layout){
			$subject->getConfig()->addBodyClass('boxed-layout');
		}

		return [$response];
	}
}