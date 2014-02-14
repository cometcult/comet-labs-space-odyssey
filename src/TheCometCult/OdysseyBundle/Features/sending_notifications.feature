Feature: Sending notifications
    In order to notify volunteers about various misson details
    As Mars Travel Agency
    I want to send them automatic email notifications

    Background:
        Given there are admitted volunteers:
        |email                |
        | volunteer1@test.com |
        | volunteer2@test.com |
        | volunteer3@test.com |
        | volunteer4@test.com |
        And content of email with packing instructions sent to "volunteer1@test.com" should be:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """
        And content of email with packing instructions sent to "volunteer2@test.com" should be:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """
        And content of email with packing instructions sent to "volunteer3@test.com" should be:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """
        And content of email with packing instructions sent to "volunteer4@test.com" should be:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """
        And content of email with packing instructions sent to "volunteer5@test.com" should be:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """

    Scenario: Packing instructions
        Given I am on homepage
        When I apply with "volunteer5@test.com" email
