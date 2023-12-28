<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Solwin\Contactwidget\Api\Data\ContactwidgetInterface;
use Solwin\Contactwidget\Api\Data\ContactwidgetSearchResultsInterface;

interface ContactwidgetRepositoryInterface
{

    /**
     * Save Contactwidget
     *
     * @param ContactwidgetInterface $contactwidget
     * @return ContactwidgetInterface
     * @throws LocalizedException
     */
    public function save(
        ContactwidgetInterface $contactwidget
    );

    /**
     * Retrieve Contactwidget
     *
     * @param string $contactwidgetId
     * @return ContactwidgetInterface
     * @throws LocalizedException
     */
    public function get($contactwidgetId);

    /**
     * Retrieve Contactwidget
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ContactwidgetSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Contactwidget
     *
     * @param ContactwidgetInterface $contactwidget
     * @return bool
     * @throws LocalizedException
     */
    public function delete(
        ContactwidgetInterface $contactwidget
    );

    /**
     * Delete Contactwidget by ID
     *
     * @param string $contactwidgetId
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($contactwidgetId);
}

