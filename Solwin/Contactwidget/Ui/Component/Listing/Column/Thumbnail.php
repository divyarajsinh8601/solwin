<?php
namespace Solwin\Contactwidget\Ui\Component\Listing\Column;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column
{
    public const NAME = 'thumbnail';
    public const ALT_FIELD = 'name';

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private UrlInterface $urlBuilder,
        private StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                if ($item['attachment']) {
                    $filename = $item['attachment'];
                    $item[$fieldName . '_src'] =  $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . '/Solwin_Contactwidget/' . $filename;
                    $item[$fieldName . '_alt'] = $this->getAlt($item) ?: $filename;
                    $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                        'solwin_contactwidget/contactwidget/form',
                        ['contactwidget_id' => $item['contactwidget_id']]
                    );
                    $item[$fieldName . '_orig_src'] = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . '/Solwin_Contactwidget/' . $filename;
                } else {
                }
            }
        }
        return $dataSource;
    }

    /**
     * Get Alter Image
     *
     * @param array $row
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
