Feature: Contact page
  In order to send bug reports and feature requests
  As a user
  I need to have a functioning contact page

  Scenario: Contact page exists
    Given I am on "/contact"
    Then I should have a contact form

  Scenario Outline: Contact page doesn't accept dodgy emails
    Given I am on "/contact"
    When I fill in "contact_request[senderEmail]" with "<email>"
    When I fill in "contact_request[message]" with "foo"
    When I press "Send your message"
    Then I should be on "/contact"
    Then I should see "<error>"

    Examples:
      | email   | error                     |
      | lalala  | not a valid email address |
      | 909     | not a valid email address |
      |         | should not be blank       |
      | foo@bar | not a valid email address |

  Scenario Outline: Contact page doesn't accept empty message
    Given I am on "/contact"
    When I fill in "contact_request[senderEmail]" with "foo@bar.com"
    When I fill in "contact_request[message]" with "<message>"
    When I press "Send your message"
    Then I should be on "/contact"
    Then I should see "should not be <error>"

    Examples:
      | message | error |
      |         | blank |
      |         | null  |

  Scenario: Contact page sends email with valid data
    Given I am on "/contact"
    When I fill in "contact_request[senderEmail]" with "foo@bar.com"
    When I fill in "contact_request[message]" with "lerele"
    When I press "Send your message"
    Then I should be on "/contact"
    Then I should see "Thank you"
