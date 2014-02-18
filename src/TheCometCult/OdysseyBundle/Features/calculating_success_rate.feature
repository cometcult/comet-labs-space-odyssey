Feature: Calculating success rate
    In order to estimate next flight risk
    As Mars Travel Agency
    I want to know current success rate

    Scenario: Mission landed success rate update
        Given there are 1 logs "mission landed"
        And there are 0 logs "mission crashed"
        When I am on homepage
        Then I should see "Our success rate is 100%"

    Scenario: Mission crashed success rate update
        Given there are 1 logs "mission landed"
        And there are 1 logs "mission crashed"
        When I am on homepage
        Then I should see "Our success rate is 50%"

    Scenario: Success rate when no missions finished
        Given there are 0 logs "mission landed"
        And there are 0 logs "mission crashed"
        When I am on homepage
        Then I should see "Our success rate is 0%"
