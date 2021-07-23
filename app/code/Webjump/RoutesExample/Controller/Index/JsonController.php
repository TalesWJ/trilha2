<?php
declare(strict_types=1);

namespace Webjump\RoutesExample\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class Index
 */
class JsonController extends Action implements HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);

        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $result = $this->jsonFactory->create();
        $data = json_encode([
            'message' => 'Hello World! Json Routing Example',
            'value' => 10000
        ]);
        $result->setHeader('Content-Type', 'application/json');
        $result->setJsonData($data);
        return $result;
    }
}
