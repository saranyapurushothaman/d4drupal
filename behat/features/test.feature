Feature: Link availability
  To check the page

  Scenario:
    Given I am an anonymous user
    When I am at "/user"
    Then I should receive 200 status code
