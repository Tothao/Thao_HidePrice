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

        if ($postValue) {
            // Lấy thông tin email từ cấu hình hệ thống
            $adminEmail = $this->scopeConfig->getValue(
                'contact/email/recipient_email',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );

            $senderEmail = $this->scopeConfig->getValue(
                'trans_email/ident_general/email',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );

            $senderName = $this->scopeConfig->getValue(
                'trans_email/ident_general/name',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );

            $sender = [
                'name' => $senderName,
                'email' => $senderEmail,
            ];

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
                    ->setTemplateIdentifier('hide_price_contact_email') // ID của template email
                    ->setTemplateVars($templateVars) // Dữ liệu mẫu
                    ->setFrom($sender) // Email gửi từ cấu hình hệ thống
                    ->addTo($adminEmail) // Địa chỉ email người nhận (admin)
                    ->setTemplateOptions(
                        [
                            'area' => \Magento\Framework\App\Area::AREA_FRONTEND, // Khu vực frontend
                            'store' => $this->storeManager->getStore()->getId(),
                        ]
                    )
                    ->getTransport();

                $transport->sendMessage(); // Gửi email

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
