Feature: Starting mission
    In order to send people to Mars
    As Mars Travel Agency
    I want to start Mars mission

    Scenario:
        Given a ready to fly crew exists
        And crew's next misson start time is reached
        When the mission starting routine is run
        Then the mission should be started
        And the crew should be flying