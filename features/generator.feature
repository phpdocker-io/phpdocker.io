Feature:
  Generator tests

  Scenario: Home page redirects to generator
    When I load "/"
    Then it should permanently redirect to "http://localhost/generator"

  Scenario: Generator page loads correctly
    When I load "/generator"
    Then the response code should be 200

  Scenario: Generator requires a project name
    Given I am on "/generator"
    And I press "Generate project archive"
    Then the "#container_for_name" element should contain "This value should not be blank."

  Scenario: Generator requires a base port
    Given I am on "/generator"
    And I fill in "project_basePort" with ""
    And I press "Generate project archive"
    Then the "#container_for_basePort" element should contain "This value should not be blank."

  Scenario: Generate a project only with the name (checks ports and upload limit defaults work)
    Given I am on "/generator"
    When I fill in "project_name" with "my project"
    And I press "Generate project archive"
    Then the response code should be 200
    And I should receive a zip file named "my-project.zip"
#    And show last response
