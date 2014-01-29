Feature: Applying
    In order to go to Mars
    As a visitor
    I want to apply for the misson

        @wip
        Scenario: Successful applying
            When visitor applies with "visitor@test.com" email
            Then visitor "visitor@test.com" should be registered

        @wip
        Scenario: Duplicate user applying
            Given visitor "visitor@test.com" is already registered
            When visitor applies with "visitor@test.com" email
            Then visitor should see "Already applied" error

        @wip
        Scenario: Aplying with invalid email
            When visitor applies with "visitor.com" email
            Then visitor should see "Invalid email" error
