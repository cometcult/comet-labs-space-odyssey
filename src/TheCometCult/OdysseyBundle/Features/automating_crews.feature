Feature: Automated crews
    In order to ship volunteers faster
    As a travel agency employee
    I want the crews to be automatically cerated

    Scenario: Automeated crew creation
        When crew volunteers limit is reached
        Then a ready to fly crew should be created
        And misson start time should start countdown