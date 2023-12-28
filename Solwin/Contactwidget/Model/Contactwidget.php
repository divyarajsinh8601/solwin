<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Model;

use Magento\Framework\Model\AbstractModel;
use Solwin\Contactwidget\Api\Data\ContactwidgetInterface;

class Contactwidget extends AbstractModel implements ContactwidgetInterface
{

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(ResourceModel\Contactwidget::class);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getContactwidgetId()
    {
        return $this->getData(self::CONTACTWIDGET_ID);
    }

    /**
     * @param $contactwidgetId
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setContactwidgetId($contactwidgetId)
    {
        return $this->setData(self::CONTACTWIDGET_ID, $contactwidgetId);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param $name
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @param $contactwidgetId
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    /**
     * @param $contactwidgetId
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getCheckedNumber()
    {
        return $this->getData(self::CHECKED_NUMBER);
    }

    /**
     * @param $contactwidgetId
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setCheckedNumber($checkedNumber)
    {
        return $this->setData(self::CHECKED_NUMBER, $checkedNumber);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getChooseMovie()
    {
        return $this->getData(self::CHOOSE_MOVIE);
    }

    /**
     * @param $contactwidgetId
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setChooseMovie($chooseMovie)
    {
        return $this->setData(self::CHOOSE_MOVIE, $chooseMovie);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getFavoriteName()
    {
        return $this->getData(self::FAVORITE_NAME);
    }

    /**
     * @param $contactwidgetId
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setFavoriteName($favoriteName)
    {
        return $this->setData(self::FAVORITE_NAME, $favoriteName);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getDatepicker()
    {
        return $this->getData(self::DATEPICKER);
    }

    /**
     * @param $datepicker
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setDatepicker($datepicker)
    {
        return $this->setData(self::DATEPICKER, $datepicker);
    }


    /**
     * @return array|mixed|string|null
     */
    public function getIntrested()
    {
        return $this->getData(self::INTRESTED);
    }

    /**
     * @param $intrested
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setIntrested($intrested)
    {
        return $this->setData(self::INTRESTED, $intrested);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getAttachment()
    {
        return $this->getData(self::ATTACHMENT);
    }

    /**
     * @param $attachment
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setAttachment($attachment)
    {
        return $this->setData(self::ATTACHMENT, $attachment);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getSubject()
    {
        return $this->getData(self::SUBJECT);
    }

    /**
     * @param $subject
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setSubject($subject)
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getComment()
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * @param $comment
     * @return ContactwidgetInterface|Contactwidget
     */
    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }
}

