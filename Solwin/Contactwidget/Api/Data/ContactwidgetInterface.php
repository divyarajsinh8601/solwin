<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Api\Data;

interface ContactwidgetInterface
{

    public const DATEPICKER = 'datepicker';
    public const TELEPHONE = 'telephone';
    public    const CHECKED_NUMBER = 'checked_number';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const FAVORITE_NAME = 'favorite_name';
    public const INTRESTED = 'Intrested';
    public const SUBJECT = 'subject';
    public const CONTACTWIDGET_ID = 'contactwidget_id';
    public const COMMENT = 'comment';
    public const ATTACHMENT = 'attachment';
    public const CHOOSE_MOVIE = 'choose_movie';

    /**
     * Get contactwidget_id
     *
     * @return string|null
     */
    public function getContactwidgetId();

    /**
     * Set contactwidget_id
     *
     * @param string $contactwidgetId
     * @return ContactwidgetInterface
     */
    public function setContactwidgetId($contactwidgetId);

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     *
     * @param string $name
     * @return ContactwidgetInterface
     */
    public function setName($name);

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     *
     * @param string $email
     * @return ContactwidgetInterface
     */
    public function setEmail($email);

    /**
     * Get telephone
     *
     * @return string|null
     */
    public function getTelephone();

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return ContactwidgetInterface
     */
    public function setTelephone($telephone);

    /**
     * Get checked_number
     *
     * @return string|null
     */
    public function getCheckedNumber();

    /**
     * Set checked_number
     *
     * @param string $checkedNumber
     * @return ContactwidgetInterface
     */
    public function setCheckedNumber($checkedNumber);

    /**
     * Get choose_movie
     *
     * @return string|null
     */
    public function getChooseMovie();

    /**
     * Set choose_movie
     *
     * @param string $chooseMovie
     * @return ContactwidgetInterface
     */
    public function setChooseMovie($chooseMovie);

    /**
     * Get favorite_name
     *
     * @return string|null
     */
    public function getFavoriteName();

    /**
     * Set favorite_name
     *
     * @param string $favoriteName
     * @return ContactwidgetInterface
     */
    public function setFavoriteName($favoriteName);

    /**
     * Get datepicker
     *
     * @return string|null
     */
    public function getDatepicker();

    /**
     * Set datepicker
     *
     * @param string $datepicker
     * @return ContactwidgetInterface
     */
    public function setDatepicker($datepicker);

    /**
     * Get Intrested
     *
     * @return string|null
     */
    public function getIntrested();

    /**
     * Set Intrested
     *
     * @param string $intrested
     * @return ContactwidgetInterface
     */
    public function setIntrested($intrested);

    /**
     * Get attachment
     *
     * @return string|null
     */
    public function getAttachment();

    /**
     * Set attachment
     *
     * @param string $attachment
     * @return ContactwidgetInterface
     */
    public function setAttachment($attachment);

    /**
     * Get subject
     *
     * @return string|null
     */
    public function getSubject();

    /**
     * Set subject
     *
     * @param string $subject
     * @return ContactwidgetInterface
     */
    public function setSubject($subject);

    /**
     * Get comment
     *
     * @return string|null
     */
    public function getComment();

    /**
     * Set comment
     *
     * @param string $comment
     * @return ContactwidgetInterface
     */
    public function setComment($comment);
}

