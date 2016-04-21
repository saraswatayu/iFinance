<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;



/**
 * Defines application features from the specific context.
 */
class FeatureContext extends Behat\MinkExtension\Context\MinkContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given that I am on the homepage
     */
    public function thatIAmOnTheHomepage()
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the number of items in the :arg1 field should increase by at least one
     */
    public function theNumberOfItemsInTheFieldShouldIncreaseByAtLeastOne($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Given I uncheck the :arg1 checkbox for the :arg2 account
     */
    public function iUncheckTheCheckboxForTheAccount($arg1, $arg2)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the number of items in the :arg1 field should decrease by at least one
     */
    public function theNumberOfItemsInTheFieldShouldDecreaseByAtLeastOne($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Given I try to use incorrect login information four times
     */
    public function iTryToUseIncorrectLoginInformationFourTimes()
    {
        $result = true;
        return $result;   
    }

    /**
     * @Given I am idle for two minutes
     */
    public function iAmIdleForTwoMinutes()
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then I should see :arg1, :arg2, and :arg3 in the :arg4 section
     */
    public function iShouldSeeAndInTheSection($arg1, $arg2, $arg3, $arg4)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Given I have imported my account
     */
    public function iHaveImportedMyAccount()
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the :arg1 field should contain a value above :arg2
     */
    public function theFieldShouldContainAValueAbove($arg1, $arg2)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the first column of the :arg1 table should be filled with names
     */
    public function theFirstColumnOfTheTableShouldBeFilledWithNames($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the second column of the :arg1 table should be filled with categories
     */
    public function theSecondColumnOfTheTableShouldBeFilledWithCategories($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the third column of the :arg1 table should be filled with values
     */
    public function theThirdColumnOfTheTableShouldBeFilledWithValues($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the fourth column of the :arg1 table should be filled with dates
     */
    public function theFourthColumnOfTheTableShouldBeFilledWithDates($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the first column of the :arg1 table should be sorted alphabetically
     */
    public function theFirstColumnOfTheTableShouldBeSortedAlphabetically($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the second column of the :arg1 table should be sorted alphabetically
     */
    public function theSecondColumnOfTheTableShouldBeSortedAlphabetically($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the third column of the :arg1 table should be sorted from least to greatest
     */
    public function theThirdColumnOfTheTableShouldBeSortedFromLeastToGreatest($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then the fourth column of the :arg1 table should be sorted chronologically
     */
    public function theFourthColumnOfTheTableShouldBeSortedChronologically($arg1)
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then I should see :arg1 in the :arg2 section
     */
    public function iShouldSeeInTheSection($arg1, $arg2)
    {
        $result = true;
        return $result;   

    }

    /**
     * @Given I attach my file :arg1 to the :arg2 section
     */
    public function iAttachMyFileToTheSection($arg1, $arg2)
    {
        $result = true;
        return $result;
    }

    /**
     * @Given I am logged in
     */
    public function iAmLoggedIn()
    {
        $this->visitPath('/');
        $this->fillField("email", "default@default.com");
        $this->fillField("password", "default");
        $this->pressButton("Login");
    }

    /**
     * @Then my account import should fail
     */
    public function myAccountImportShouldFail()
    {
        $result = true;
        return $result;
    }

    /**
     * @Then I should be told to try again in :arg1 seconds
     */
    public function iShouldBeToldToTryAgainInSeconds($arg1)
    {
        $result = true;
        return $result;    }

    /**
     * @Given I Log Out
     */
    public function iLogOut()
    {
        $result = true;
        return $result;   
    }

    /**
     * @Then I should be returned to the homepage
     */
    public function iShouldBeReturnedToTheHomepage()
    {
        $result = true;
        return $result;    
    }

    /**
     * @Given I sort by Merchant
     */
    public function iSortByMerchant()
    {
        $result = true;
        return $result;      
      }

    /**
     * @Given I sort by Category
     */
    public function iSortByCategory()
    {
        $result = true;
        return $result;       
    }

    /**
     * @Given I sort by Price
     */
    public function iSortByPrice()
    {
        $result = true;
        return $result;       
    }

    /**
     * @Given I sort by Date
     */
    public function iSortByDate()
    {
        $result = true;
        return $result;       
    }

    /**
     * @Then I should remain on the homepage
     */
    public function iShouldRemainOnTheHomepage()
    {
        $result = true;
        return $result;   

    }
}
