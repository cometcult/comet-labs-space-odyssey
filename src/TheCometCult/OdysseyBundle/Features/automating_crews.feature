Feature: Automated crews
    In order to ship volunteers faster
    As a travel agency employee
    I want the crews to be automatically cerated

    Background:
        Given there are admitted volunteers:
        |email                |
        | volunteer1@test.com |
        | volunteer2@test.com |
        | volunteer3@test.com |
        | volunteer4@test.com |

    Scenario: Automeated crew creation
        Given I am on homepage
        When I apply with "volunteer5@test.com" email
        Then a ready to fly crew should be created
        And volunteers should be assigned to crew:
        |email                |
        | volunteer1@test.com |
        | volunteer2@test.com |
        | volunteer3@test.com |
        | volunteer4@test.com |
        | volunteer5@test.com |
        And misson launch time should start countdown