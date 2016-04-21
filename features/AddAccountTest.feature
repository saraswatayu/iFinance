Feature: Add Account
    In order to track account of my expenditures
    As a user
    I want to add my bank accounts to the program

    Scenario: Invalid Account Upload
        Given I am logged in
        And I attach my file "invalidFile.png" to the "Choose File" section
    	And I press "Add Account"
        Then my account import should fail

	Scenario: Valid Account Upload
        Given I am logged in
        And I attach my file "validFile.png" to the "Choose File" section
    	And I press "Add Account"
    	Then the number of items in the "transactions" field should increase by at least one

    Scenario: Hiding an Account's Transactions
        Given I am logged in
    	And I uncheck the "visible" checkbox for the "American Express" account
    	Then the number of items in the "transactions" field should decrease by at least one
