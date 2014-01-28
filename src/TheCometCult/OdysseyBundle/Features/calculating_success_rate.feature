Feature: Calculating success rate
    In order to estimate next flight risk
    As Mars Travel Agency
    I want to know current success rate

    Scenario: Mission landed success rate update
        Given success rate is "100%"
        And there are 1 logs "landed"
        And there are 0 logs "crashed"
        When mission has finished
        And status report "landed" is logged
        Then success rate is not updated

    Scenario: Mission crashed success rate update
        Given success rate is "100%"
        And there are 1 logs "landed"
        And there are 0 logs "crashed"
        When mission has finished
        And status report "crashed" is logged
        Then success rate is updated with "50%"
