Feature: Login
    In order to see if my login works properly
    As a user
    I want to login to the application

    Scenario: Loading the Login Page
        Given I am on "http://localhost:8000"
        Then I should see "hi"

    Scenario: Successfully Logging In to Program
    	Given I am on "http://localhost:8000"
    	And I fill in "emailInput" with "default@default.com"
    	And I fill in "password" with "default"
    	And I press "Login"
    	Then I should be on "http://localhost:8000/dashboard"

    Scenario: Incorrect Login to Program
        Given I am on "http://localhost:8000"
        And I fill in "email" with "notdefault@default.com"
        And I fill in "password" with "notdefault"
        And I press "Login"
        Then I should see "These credentials do not match our records."
        And I should not see "Add Account"

    Scenario: Four Incorrect Login Attempts
        Given I am on "http://localhost:8000"
        And I try to use incorrect login information four times
        Then I should see "Too many login attempts. Please try again in 60 seconds."

        