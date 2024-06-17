<?php
declare(strict_types=1);

namespace Team23\Core\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Phrase;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class GetSupport extends Field
{
    private const GITHUB_URL = 'https://github.com/team23';

    /**
     * @var string
     */
    protected $_template = 'Team23_Core::support.phtml';

    /**
     * Retrieve support message
     *
     * @return Phrase|string
     */
    public function getSupportMessage(): Phrase|string
    {
        return __(
            'If you need any help, guidance or found an issue within our extensions. Feel free to find us '
            . 'on <a href="%1" target="_blank">GitHub</a>',
            $this->getSupportUrl()
        );
    }

    /**
     * Retrieve GitHub / Support URL
     *
     * @return string
     */
    public function getSupportUrl(): string
    {
        return self::GITHUB_URL;
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
