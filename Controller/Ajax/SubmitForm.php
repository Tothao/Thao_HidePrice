<?php

namespace Thao\HidePrice\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;

use Magento\Framework\App\Config\ScopeConfigInterface;

class SubmitForm extends Action
{
    protected $resultJsonFactory;
    protected $transportBuilder;
    protected $storeManager;
    protected $scopeConfig;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        $postValue = $this->getRequest()->getPostValue();
        if ($postValue) {
            // Lấy email admin từ cấu hình
            $adminEmail = $this->scopeConfig->getValue('HidePrice/general/email_template', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

            // Tạo nội dung email
            $templateVars = [
                'name' => $postValue['full_name'],
                'email' => $postValue['email'],
                'phone' => $postValue['phone'],
                'message' => $postValue['message'],
                'product_id' => $postValue['product_id'], // Thêm product_id vào nội dung email
            ];

            // Cấu hình và gửi email
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('hide_price_contact_email') // ID template từ email_templates.xml
                ->setTemplateVars($templateVars)
                ->setFrom('general')
                ->addTo($adminEmail) // Gửi email đến địa chỉ admin lấy từ cấu hình
                ->setTemplateOptions([
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId(),
                ])
                ->getTransport();

            $transport->sendMessage();  // Gửi email

            return $result->setData(['success' => true, 'message' => 'Form submitted successfully!']);
        }

        return $result->setData(['success' => false, 'message' => 'Invalid request.']);
    }
}
