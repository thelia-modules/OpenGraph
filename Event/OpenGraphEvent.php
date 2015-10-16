<?php

namespace OpenGraph\Event;

use Thelia\Core\Event\ActionEvent;

class OpenGraphEvent extends ActionEvent
{
    protected $id;
    protected $company_name;
    protected $twitter_company_name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * @param mixed $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }

    /**
     * @return mixed
     */
    public function getTwitterCompanyName()
    {
        return $this->twitter_company_name;
    }

    /**
     * @param mixed $twitter_company_name
     */
    public function setTwitterCompanyName($twitter_company_name)
    {
        $this->twitter_company_name = $twitter_company_name;
    }
}