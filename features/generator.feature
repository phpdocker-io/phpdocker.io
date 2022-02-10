Feature:
  Generator tests

  Scenario: Home page redirects to generator
    When I load "/generator"
    Then it should permanently redirect to "http://localhost/"

  Scenario: Generator page loads correctly
    When I load "/"
    Then the response code should be 200

  Scenario: Generator requires a base port
    Given I am on "/"
    And I fill in "project_globalOptions_basePort" with ""
    And I press "Generate project archive"
    Then the "#container_for_basePort" element should contain "This value should not be blank."

  Scenario: Generate a project only with default settings
    Given I am on "/"
    When I press "Generate project archive"
    Then the response code should be 200
    And I should receive a zip file named "phpdocker.zip"
#    And show last response

  Scenario: Check MySQL validation works
    Given I am on "/"
    When I check "Enable MySQL"
    And I press "Generate project archive"
    Then the "#container_for_mysql_rootPassword" element should contain "This value should not be blank."
    And the "#container_for_mysql_databaseName" element should contain "This value should not be blank."
    And the "#container_for_mysql_username" element should contain "This value should not be blank."
    And the "#container_for_mysql_password" element should contain "This value should not be blank."

  Scenario: MySQL config works correctly
    Given I am on "/"
    When I check "Enable MySQL"
    And I fill in "project_mysqlOptions_rootPassword" with "root pass"
    And I fill in "project_mysqlOptions_databaseName" with "db name"
    And I fill in "project_mysqlOptions_username" with "user"
    And I fill in "project_mysqlOptions_password" with "pass"
    When I press "Generate project archive"
    Then the response code should be 200
    And I should receive a zip file named "phpdocker.zip"
