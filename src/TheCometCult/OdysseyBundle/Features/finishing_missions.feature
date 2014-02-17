Feature: Finishing missions
    In to analize misson success
    As Mars Travel Agency
    I want to conclude missions to mars

    Background:
        Given a ready to fly crew exists
        And average mission ETA is 3 days

    Scenario: Successfuly landed
        Given daily status report states "landed"
        And the mission has started 3 days ago
        When mission status is checked
        Then the mission should be finished
        And log about finished mission should exist

    Scenario: Crashed on landing
        Given daily status report states "crashed"
        And the mission has started 3 days ago
        When mission status is checked
        Then the mission should be finished
        And log about crashed mission should exist

    Scenario: Mission crashed during flight
        Given daily status report states "crashed"
        And the mission has started 1 days ago
        When mission status is checked
        Then the mission should be finished
        And log about crashed mission should exist

    Scenario: Mission is assumed to be ongoing
        Given daily status report states "unknown"
        And the mission has started 2 days ago
        When mission status is checked
        Then the mission should not be finished