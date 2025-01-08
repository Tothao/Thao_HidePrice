<?php

namespace Thao\HidePrice\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;

class SubmitForm extends Action
{
    protected $resultJsonFactory;
    protected $transportBuilder;
    protected $storeManager;
    protected $scopeConfig;
    protected $_logger;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger
    ) {
        $this->_logger = $logger;
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

        if ($postValue && isset($postValue['full_name'], $postValue['email'], $postValue['phone'], $postValue['message'], $postValue['product_id'])) {
            // Lấy email admin từ cấu hình
            $adminEmail = $this->scopeConfig->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

            // Tạo nội dung email
            $templateVars = [
                'name' => $postValue['full_name'],
                'email' => $postValue['email'],
                'phone' => $postValue['phone'],
                'message' => $postValue['message'],
                'product_id' => $postValue['product_id'],
            ];

            try {
                // Cấu hình và gửi email
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier('hide_price_contact_email')
                    ->setTemplateVars($templateVars)
                    ->setFrom('general')
                    ->addTo($adminEmail)
                    ->setTemplateOptions([
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId(),
                    ])
                    ->getTransport();

                $transport->sendMessage();  // Gửi email

                return $result->setData(['success' => true, 'message' => 'Form submitted successfully!']);
            } catch (\Exception $e) {
                // Ghi log lỗi
                $this->_logger->error('Email send failed: ' . $e->getMessage());
                return $result->setData(['success' => false, 'message' => 'Email could not be sent.']);
            }
        }

        return $result->setData(['success' => false, 'message' => 'Invalid request.']);
    }
}
