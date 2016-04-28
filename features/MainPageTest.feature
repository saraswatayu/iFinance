Feature: Home Page
    In order to see my spending
    As a user
    I want to access functionality on the home page

    Scenario: Automatic Logout
        Given I am logged in
    	And I am idle for two minutes
		Then I should remain on the homepage

    Scenario: Intentional Logout
        Given I am logged in
    	And I Log Out
    	Then I should be returned to the homepage

	Scenario: View Accounts
        Given I am logged in
		Then I should see "Credit Cards", "Savings", and "Loans" in the "Accounts" section
		
	Scenario: View Account Information
        Given I am logged in
		And I have imported my account
		Then the "AmericanExpress-Balance" field should contain a value above 0

	Scenario: View Transactions
        Given I am logged in
		And I have imported my account
		Then the first column of the "Transactions" table should be filled with names
		And the second column of the "Transactions" table should be filled with categories
		And the third column of the "Transactions" table should be filled with values
		And the fourth column of the "Transactions" table should be filled with dates
	
	Scenario: Sort Transactions by Amount
        Given I am logged in
		And I sort by Merchant
		Then the first column of the "Transactions" table should be sorted alphabetically

	Scenario: Sort Transactions by Amount
        Given I am logged in
		And I sort by Category
		Then the second column of the "Transactions" table should be sorted alphabetically

	Scenario: Sort Transactions by Price
        Given I am logged in
		And I sort by Price
		Then the third column of the "Transactions" table should be sorted from least to greatest

	Scenario: Sort Transactions by Date
        Given I am logged in
		And I sort by Date
		Then the fourth column of the "Transactions" table should be sorted chronologically

	Scenario: View Monthly Budgets
        Given I am logged in
		And I have imported my account
		Then I should see my budgets
