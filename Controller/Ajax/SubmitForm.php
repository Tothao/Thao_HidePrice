<?php
namespace Vendor\Module\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class SubmitForm extends Action
{
    protected $resultJsonFactory;

    // Khai báo ResultJsonFactory
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // Lấy dữ liệu từ POST
        $postData = $this->getRequest()->getPostValue();

        if (!$postData) {
            $result = ['success' => false, 'message' => 'No data received'];
            return $this->jsonResponse($result);
        }

        // Lấy thông tin từ form
        $productId = $postData['product_id'];
        $fullName = $postData['full_name'];
        $email = $postData['email'];
        $phone = $postData['phone'];
        $message = $postData['message'];

        // Xử lý dữ liệu (Ví dụ: lưu vào database, gửi email, v.v.)
        // Bạn có thể thêm mã xử lý ở đây như lưu vào database hoặc gửi email.

        // Trả về phản hồi thành công
        $result = ['success' => true, 'message' => 'Form submitted successfully'];
        return $this->jsonResponse($result);
    }

    // Trả về phản hồi JSON
    protected function jsonResponse($data)
    {
        $result = $this->resultJsonFactory->create();
        return $result->setData($data);
    }
}
