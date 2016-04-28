Feature: Graph
    In order to track account of my expenditures
    As a user
    I want to visualize spending on a graph

    Scenario: Graph Appears
    Given I am logged in
    Then the graph of expenses should appear

    Scenario: Graph Has Correct Axes
    Given I am logged in
    Then I should see "Spending" and "Date"

    Scenario: Graph Has Date Picker
    Given I am logged in
    Then I should see the element "reportrange" 
