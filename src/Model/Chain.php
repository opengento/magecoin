<?php

namespace App\Model;

class Chain {

    /** @var Block[] $_chain */
    protected $_chain;

    protected $_difficulty;

    protected $_pendingTransactions;

    protected $_miningReward;

    public function __construct()
    {
        $this->_chain = [$this->createGenesisBlock()];
        $this->_difficulty = 5;
        $this->_pendingTransactions = [];
        $this->_miningReward = 100;
    }

    public function createGenesisBlock(){
        return new Block(time(), [], "0");
    }

    /**
     * @return Block|mixed
     */
    public function getLatestBlock(){
        $last = end($this->_chain);
        reset($this->_chain);
        return $last;
    }

    public function minePendingTransactions($miningRewardAddress) {
        $block = new Block(time(), $this->_pendingTransactions, $this->getLatestBlock()->getHash());
        $block->mineBlock($this->_difficulty);
        $this->_chain[] = $block;
        $this->_pendingTransactions = [
            new Transaction(null, $miningRewardAddress, $this->_miningReward)
        ];
    }

    public function createTransaction($transaction){
        $this->_pendingTransactions[] = $transaction;
    }
    public function getAddressBalance($address){
        $balance = 0;

        foreach ($this->_chain as $block) {
            foreach ($block->getTransactions() as $transaction){
                if($transaction->getFromAddress() === $address) {
                    $balance -= $transaction->getAmount();
                }
                if($transaction->getToAddress() === $address) {
                    $balance += $transaction->getAmount();
                }
            }
        }

        return $balance;
    }

    public function isChainValid() {
        for ($i = 1; $i < count($this->_chain); $i++){
            $currentBlock = $this->_chain[$i];
            $previousBlock = $this->_chain[$i - 1];

            if ($currentBlock->getHash() !== $currentBlock->calculateHash()) {
                return false;
            }

            if ($currentBlock->getPreviousHash() !== $previousBlock->getHash()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return Block[]
     */
    public function getChain()
    {
        return $this->_chain;
    }

    /**
     * @param Block[] $chain
     */
    public function setChain($chain)
    {
        $this->_chain = $chain;
    }

    /**
     * @return int
     */
    public function getDifficulty()
    {
        return $this->_difficulty;
    }

    /**
     * @param int $difficulty
     */
    public function setDifficulty($difficulty)
    {
        $this->_difficulty = $difficulty;
    }

    /**
     * @return array
     */
    public function getPendingTransactions()
    {
        return $this->_pendingTransactions;
    }

    /**
     * @param array $pendingTransactions
     */
    public function setPendingTransactions($pendingTransactions)
    {
        $this->_pendingTransactions = $pendingTransactions;
    }

    /**
     * @return int
     */
    public function getMiningReward()
    {
        return $this->_miningReward;
    }

    /**
     * @param int $miningReward
     */
    public function setMiningReward($miningReward)
    {
        $this->_miningReward = $miningReward;
    }


}