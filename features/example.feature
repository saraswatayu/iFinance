Feature: Testing
    In order to learn Behat
    As a learner
    I want to see how to test a feature

    Scenario: Home Page
        Given I am on "http://localhost:8000"
        Then print current URL
        Then I should see "Email"