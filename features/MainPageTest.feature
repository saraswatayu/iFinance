Feature: Home Page
    In order to see my spending
    As a user
    I want to access functionality on the home page

    Scenario: Automatic Logout
    	Given that I am on the homepage
    	And I am idle for two minutes
    	Then I should be on "http://localhost:8000"

    Scenario: Intentional Logout
    	Given that I am on the homepage
    	And I press "logout"
    	Then I should be on "http://localhost:8000"

	Scenario: View Accounts
		Given that I am on the homepage
		Then I should see "Credit Cards", "Savings", and "Loans" in the "Accounts" section
		
	Scenario: View Account Information
		Given that I am on the homepage
		And I have imported my account
		Then the "AmericanExpress-Balance" field should contain a value above 0

	Scenario: View Transactions
		Given that I am on the homepage
		And I have imported my account
		Then the first column of the "Transactions" table should be filled with names
		And the second column of the "Transactions" table should be filled with categories
		And the third column of the "Transactions" table should be filled with values
		And the fourth column of the "Transactions" table should be filled with dates
	
	Scenario: Sort Transactions by Amount
		Given that I am on the homepage
		And I press "Merchant"
		Then the first column of the "Transactions" table should be sorted alphabetically

	Scenario: Sort Transactions by Amount
		Given that I am on the homepage
		And I press "Category"
		Then the second column of the "Transactions" table should be sorted alphabetically

	Scenario: Sort Transactions by Price
		Given that I am on the homepage
		And I press "Price"
		Then the third column of the "Transactions" table should be sorted from least to greatest

	Scenario: Sort Transactions by Date
		Given that I am on the homepage
		And I press "Date"
		Then the fourth column of the "Transactions" table should be sorted chronologically

	Scenario: View Monthly Budgets
		Given that I am on the homepage
		And I have imported my account
		Then I should see "You've spent $18.00 of $250.00" in the "Fast Food" section
		And I should see "You've spent $4250.00 of $100.00" in the "Tuition" section
