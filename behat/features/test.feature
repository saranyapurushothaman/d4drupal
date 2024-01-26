Feature: Link availability
  To check the page

  @new
  Scenario:
    Given I am an anonymous user
    When I am at "/user"
    Then I should receive 404 status code

  @new
  Scenario Outline: Check the link present or not
    Given I am an anonymous user
    When I am at "<path>"
    Then I should see the link "<link>"

  Examples:
    | path            | link                 |
    | user/register   | Log in               |
    | user/login      | Reset your password  |

