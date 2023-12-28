<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Solwin\Contactwidget\Api\ContactwidgetRepositoryInterface;
use Solwin\Contactwidget\Api\Data\ContactwidgetInterface;
use Solwin\Contactwidget\Api\Data\ContactwidgetInterfaceFactory;
use Solwin\Contactwidget\Api\Data\ContactwidgetSearchResultsInterface;
use Solwin\Contactwidget\Api\Data\ContactwidgetSearchResultsInterfaceFactory;
use Solwin\Contactwidget\Model\ResourceModel\Contactwidget as ResourceContactwidget;
use Solwin\Contactwidget\Model\ResourceModel\Contactwidget\CollectionFactory as ContactwidgetCollectionFactory;

class ContactwidgetRepository implements ContactwidgetRepositoryInterface
{
    /**
     * @param ResourceContactwidget $resource
     * @param ContactwidgetInterfaceFactory $contactwidgetFactory
     * @param ContactwidgetCollectionFactory $contactwidgetCollectionFactory
     * @param ContactwidgetSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        private ResourceContactwidget $resource,
        private ContactwidgetInterfaceFactory $contactwidgetFactory,
        private ContactwidgetCollectionFactory $contactwidgetCollectionFactory,
        private ContactwidgetSearchResultsInterfaceFactory $searchResultsFactory,
        private CollectionProcessorInterface $collectionProcessor
    ) {
    }

    /**
     * Save ContactWidget
     *
     * @param ContactwidgetInterface $contactwidget
     * @return ContactwidgetInterface
     * @throws CouldNotSaveException
     */
    public function save(ContactwidgetInterface $contactwidget)
    {
        try {
            $this->resource->save($contactwidget);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the contactwidget: %1',
                $exception->getMessage()
            ));
        }
        return $contactwidget;
    }

    /**
     * Get ContactWidget
     *
     * @param $contactwidgetId
     * @return ContactwidgetInterface
     * @throws NoSuchEntityException
     */
    public function get($contactwidgetId)
    {
        $contactwidget = $this->contactwidgetFactory->create();
        $this->resource->load($contactwidget, $contactwidgetId);
        if (!$contactwidget->getId()) {
            throw new NoSuchEntityException(__('Contactwidget with id "%1" does not exist.', $contactwidgetId));
        }
        return $contactwidget;
    }

    /**
     * GetList ContactWidget
     *
     * @param SearchCriteriaInterface $criteria
     * @return ContactwidgetSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->contactwidgetCollectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete ContactWidget
     *
     * @param ContactwidgetInterface $contactwidget
     * @return true
     * @throws CouldNotDeleteException
     */
    public function delete(ContactwidgetInterface $contactwidget)
    {
        try {
            $contactwidgetModel = $this->contactwidgetFactory->create();
            $this->resource->load($contactwidgetModel, $contactwidget->getContactwidgetId());
            $this->resource->delete($contactwidgetModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Contactwidget: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete ContactWidget by id
     *
     * @param $contactwidgetId
     * @return bool
     * @throws LocalizedException
     */
    public function deleteById($contactwidgetId)
    {
        return $this->delete($this->get($contactwidgetId));
    }
}

