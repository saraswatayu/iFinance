Feature: Add Account
    In order to track the account of my expenditures
    As a user
    I want to view my different assets and types of accounts

    Scenario: Accounts Sorted Into Categories
        Given I am logged in
        And I have three accounts
        Then my accounts should be "Credit Cards", "Savings", and "Loans"

    Scenario: Accounts Sorted Alphabetically
        Given I am logged in
        Then my accounts should be sorted alphabetically

    Scenario: Proper Account Information
        Given I am logged in
        Then I should see the name, balance, and a butotn to toggle each account 
