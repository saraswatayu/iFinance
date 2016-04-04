<?php
class MainControllerTest extends PHPUnit_Framework_TestCase {
    
    protected $accounts = null

    public function testShouldNotHaveAnyAccountsYetInIntitialState() {
        $this->assertEquals(0, count($this->accounts));
    }

    public function addAccountTest() {
        $this->accounts = new my_account;
        $this->accounts->addAccount('My Visa Account');
        $this->assertEquals(1, count($this->accounts));
    }
    
    public function testAfterAddingAccountWeCanRetrieveItsNameByIndex() {
        $this->accounts->addAccount('My Visa Account');
        $this->assertEquals('My Visa Account', $this->accounts->getAccount(count($this->account) - 1 ));
    }
}
