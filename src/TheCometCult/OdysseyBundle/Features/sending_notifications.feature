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

    Scenario: Packing instructions
        Given I am on homepage
        And EMAIL SENDER expects to send mail to "volunteer1@test.com" with:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """
        And EMAIL SENDER expects to send mail to "volunteer2@test.com" with:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """
        And EMAIL SENDER expects to send mail to "volunteer3@test.com" with:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """
        And EMAIL SENDER expects to send mail to "volunteer4@test.com" with:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """
        And EMAIL SENDER expects to send mail to "volunteer5@test.com" with:
            """
            Crew packing instructions
            Hi. Please pack your socks.
            """
        When I apply with "volunteer5@test.com" email