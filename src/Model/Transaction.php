<?php

namespace App\Model;

class Transaction {

    protected $_fromAddress;

    protected $_toAddress;

    protected $_amount;

    public function __construct($fromAddress, $toAddress, $amount)
    {
        $this->_fromAddress = $fromAddress;
        $this->_toAddress = $toAddress;
        $this->_amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getFromAddress()
    {
        return $this->_fromAddress;
    }

    /**
     * @param mixed $fromAddress
     */
    public function setFromAddress($fromAddress)
    {
        $this->_fromAddress = $fromAddress;
    }

    /**
     * @return mixed
     */
    public function getToAddress()
    {
        return $this->_toAddress;
    }

    /**
     * @param mixed $toAddress
     */
    public function setToAddress($toAddress)
    {
        $this->_toAddress = $toAddress;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

}