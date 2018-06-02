<?php

namespace App\Model;

class Block {

    protected $_timestamp;

    /** @var Transaction[] $_transactions */
    protected $_transactions;

    protected $_previousHash;

    protected $_hash;

    protected $_nonce;

    public function __construct(
        $timestamp,
        $transactions,
        $previousHash
    ) {
        $this->_timestamp = $timestamp;
        $this->_transactions = $transactions;
        $this->_previousHash = $previousHash;
        $this->_hash = $this->calculateHash();
        $this->_nonce = 0;
    }


    public function calculateHash(){
        return hash( 'sha256', $this->_previousHash . $this->_timestamp . json_encode($this->_transactions) . $this->_nonce);
    }

    public function mineBlock($difficulty) {
        while(substr($this->_hash, 0, $difficulty) !== str_pad('', $difficulty, '0')) {
            $this->_nonce++;
            $this->_hash = $this->calculateHash();
        };
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->_timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->_timestamp = $timestamp;
    }

    /**
     * @return Transaction[]
     */
    public function getTransactions()
    {
        return $this->_transactions;
    }

    /**
     * @param mixed $transactions
     */
    public function setTransactions($transactions)
    {
        $this->_transactions = $transactions;
    }

    /**
     * @return mixed
     */
    public function getPreviousHash()
    {
        return $this->_previousHash;
    }

    /**
     * @param mixed $previousHash
     */
    public function setPreviousHash($previousHash)
    {
        $this->_previousHash = $previousHash;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->_hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->_hash = $hash;
    }

    /**
     * @return int
     */
    public function getNonce()
    {
        return $this->_nonce;
    }

    /**
     * @param int $nonce
     */
    public function setNonce($nonce)
    {
        $this->_nonce = $nonce;
    }



}