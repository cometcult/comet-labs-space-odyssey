Feature: Applying
    In order to go to Mars
    As a visitor
    I want to apply for the misson

        Scenario: Successful applying
            Given I am on homepage
            When I apply with "volunteer@test.com" email
            Then I should see "volunteer@test.com successfully volunteered!"

        Scenario: Duplicate user applying
            Given I am on homepage
            And volunteer "volunteer@test.com" is already applied
            When I apply with "volunteer@test.com" email
            Then I should see "Volunteer already applied."

        Scenario: Aplying with invalid email
            Given I am on homepage
            When I apply with "volunteer" email
            Then I should see "This value is not a valid email address."
