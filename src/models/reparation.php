<?php
namespace MyWorkshop\models;

use DateTime;

class reparation
{
    private string $uuid;
    private string $name;
    private DateTime $registerDate;
    private string $licensePlate;
    private string $image;

    private string $email;

    public function __construct($uuid, $name, $registerDate, $licensePlate, $email)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->registerDate = new DateTime($registerDate);
        $this->licensePlate = $licensePlate;
        $this->image = "imagentest";
        $this->email = $email;
    }


    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of registerDate
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * Set the value of registerDate
     *
     * @return  self
     */
    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * Get the value of licensePlate
     */
    public function getLicensePlate()
    {
        return $this->licensePlate;
    }

    /**
     * Set the value of licensePlate
     *
     * @return  self
     */
    public function setLicensePlate($licensePlate)
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set the value of uuid
     *
     * @return  self
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
