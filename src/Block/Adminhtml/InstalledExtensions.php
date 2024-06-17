<?php
declare(strict_types=1);

namespace Team23\Core\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Team23\Core\Model\ModuleListProcessor;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class InstalledExtensions extends Field
{
    /**
     * @var string
     */
    protected $_template = 'Team23_Core::extensions.phtml';

    /**
     * @param Context $context
     * @param SerializerInterface $serializer
     * @param ModuleListProcessor $moduleListProcessor
     * @param array $data
     * @param SecureHtmlRenderer|null $secureHtmlRenderer
     */
    public function __construct(
        Context $context,
        private readonly SerializerInterface $serializer,
        private readonly ModuleListProcessor $moduleListProcessor,
        array $data = [],
        ?SecureHtmlRenderer $secureHtmlRenderer = null
    ) {
        parent::__construct(
            $context,
            $data,
            $secureHtmlRenderer
        );
    }

    /**
     * Retrieve module data
     *
     * @return string
     */
    public function getModulesData(): string
    {
        return $this->serializer->serialize($this->moduleListProcessor->execute());
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }
}
