<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Model\Contactwidget;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Solwin\Contactwidget\Model\ResourceModel\Contactwidget\CollectionFactory;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @inheritDoc
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;


    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        private StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getContactwidgetId()] = $model->getData();
            if ($model->getAttachment()) {
                $m['attachment'][0]['name'] = $model->getAttachment();
                $m['attachment'][0]['url'] = $this->getMediaUrl() . $model->getAttachment();
                $fullData = $this->loadedData;
                $this->loadedData[$model->getContactwidgetId()] = array_merge($fullData[$model->getContactwidgetId()], $m);
            }
        }
        $data = $this->dataPersistor->get('solwin_contactwidget_contactwidget');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getContactwidgetId()] = $model->getData();
            $this->dataPersistor->clear('solwin_contactwidget_contactwidget');
        }

        return $this->loadedData;
    }

    /**
     * Return media path for attachment
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getMediaUrl() : string
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }
}

