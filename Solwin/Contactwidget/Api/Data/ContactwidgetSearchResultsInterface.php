<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ContactwidgetSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get Contactwidget list.
     *
     * @return ContactwidgetInterface[]
     */
    public function getItems();

    /**
     * Set Contactwidget list.
     *
     * @param ContactwidgetInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

