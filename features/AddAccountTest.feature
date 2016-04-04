Feature: Add Account
    In order to track account of my expenditures
    As a user
    I want to add my bank accounts to the program

    Scenario: Invalid Account Upload
    	Given that I am on the homepage
    	And I attach the file "invalidFile.png" to "Choose File"
    	And I press "Add Account"
    	Then I should see "Account import failed."

	Scenario: Valid Account Upload
		Given that I am on the homepage
    	And I attach the file "validFile.csv" to "Choose File"
    	And I press "Add Account"
    	Then the number of items in the "transactions" field should increase by at least one

    Scenario: Hiding an Account's Transactions
    	Given that I am on the homepage
    	And I uncheck the "visible" checkbox for the "American Express" account
    	Then the number of items in the "transactions" field should decrease by at least one
