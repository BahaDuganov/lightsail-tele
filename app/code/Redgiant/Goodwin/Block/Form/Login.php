<?php

namespace Redgiant\Goodwin\Block\Form;

use Magento\Customer\Block\Form\Login as BaseLogin;

class Login extends BaseLogin
{
    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        return $this;
    }
}