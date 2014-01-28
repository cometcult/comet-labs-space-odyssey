Feature: Finishing missions
    In to analize misson success
    As Mars Travel Agency
    I want to conclude missions to mars

    Scenario: Successfuly landed
        Given mission has reached ETA
        And daily status report states "landed"
        Then mission is finished
        And status report "landed" is logged

    Scenario: Crashed on landing
        Given mission has reached ETA
        And daily status report states "crashed"
        Then mission is finished
        And status report "crashed" is logged

    Scenario: Mission crashed during flight
        Given mission has not reached ETA
        And daily status report states "crashed"
        Then mission is finished
        And status report "crashed" is logged

    Scenario: Mission is onging
        Given mission has not reached ETA
        And daily status report states "ongoing"
        Then mission is not finished
        And status report "ongoing" is logged

    Scenario: Mission is assumed to be ongoing
        Given mission has not reached ETA
        And daily status report states "unknown"
        Then mission is not finished
        And status report "ongoing" is logged