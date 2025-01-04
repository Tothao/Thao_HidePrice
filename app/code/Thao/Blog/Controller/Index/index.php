<?php
namespace Thao\Blog\Controller\Index;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory; // Thêm để sử dụng ForwardFactory
use Magento\Framework\App\Config\ScopeConfigInterface;

class Index extends Action{
    protected $resultPageFactory;
    protected $resultForwardFactory;
    protected $scopeConfig;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);

    }
    public function execute(){
        $isMenuEnabled = $this->scopeConfig->isSetFlag(
            'blog/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if (!$isMenuEnabled) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute'); // Chuyển hướng đến trang 404
        }

        // Nếu module bật, trả về layout hiển thị bài viết
        return $this->resultPageFactory->create();

    }


}
