Feature: UI Test
    In order to effectively use the program
    As a user
    I want to experience a functional and effective user interface

    Scenario: Correct Background Color on Login
    	Given I am on the login page
    	Then the background color should be #333333

	Scenario: Correct Background Color on Main Page
		Given I am logged in
		Then the background color should be #333333

	Scenario: Correct Background Color for Modules
        Given I am logged in
        Then the element "panel-body" should have a background color of "#DDDDDD"

    Scenario: Correct Text Color
        Given I am logged in
        Then the text in the element "panel-body" should be the color #333333