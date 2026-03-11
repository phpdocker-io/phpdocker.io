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

  Scenario: Default zip contains all expected files
    Given I am on "/"
    When I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip should contain the file "docker-compose.yml"
    And the zip should contain the file "phpdocker/php-fpm/Dockerfile"
    And the zip should contain the file "phpdocker/php-fpm/php-ini-overrides.ini"
    And the zip should contain the file "phpdocker/nginx/nginx.conf"
    And the zip should contain the file "phpdocker/README.md"
    And the zip should contain the file "phpdocker/README.html"

  Scenario: Webserver and php-fpm are always present in docker-compose.yml
    Given I am on "/"
    When I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should contain "webserver:"
    And the zip file "docker-compose.yml" should contain "php-fpm:"

  Scenario: PHP 8.2 is reflected in Dockerfile
    Given I am on "/"
    When I select "8.2" from "project_phpOptions_version"
    And I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip file "phpdocker/php-fpm/Dockerfile" should contain "phpdockerio/php:8.2-fpm"

  Scenario: PHP 8.5 is reflected in Dockerfile
    Given I am on "/"
    When I select "8.5" from "project_phpOptions_version"
    And I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip file "phpdocker/php-fpm/Dockerfile" should contain "phpdockerio/php:8.5-fpm"

  Scenario: Check MySQL validation works
    Given I am on "/"
    When I check "MySQL"
    And I press "Generate project archive"
    Then the "#container_for_mysql_rootPassword" element should contain "This value should not be blank."
    And the "#container_for_mysql_databaseName" element should contain "This value should not be blank."
    And the "#container_for_mysql_username" element should contain "This value should not be blank."
    And the "#container_for_mysql_password" element should contain "This value should not be blank."

  Scenario: Check MariaDB validation works
    Given I am on "/"
    When I check "MariaDB"
    And I press "Generate project archive"
    Then the "#container_for_mariadb_rootPassword" element should contain "This value should not be blank."
    And the "#container_for_mariadb_databaseName" element should contain "This value should not be blank."
    And the "#container_for_mariadb_username" element should contain "This value should not be blank."
    And the "#container_for_mariadb_password" element should contain "This value should not be blank."

  Scenario: Check PostgreSQL validation works
    Given I am on "/"
    When I check "Postgres"
    And I press "Generate project archive"
    Then the "#container_for_postgres_rootUser" element should contain "This value should not be blank."
    And the "#container_for_postgres_rootPassword" element should contain "This value should not be blank."
    And the "#container_for_postgres_databaseName" element should contain "This value should not be blank."

  Scenario: MySQL config works correctly
    Given I am on "/"
    When I check "MySQL"
    And I fill in "project_mysqlOptions_rootPassword" with "root pass"
    And I fill in "project_mysqlOptions_databaseName" with "db name"
    And I fill in "project_mysqlOptions_username" with "user"
    And I fill in "project_mysqlOptions_password" with "pass"
    When I press "Generate project archive"
    Then the response code should be 200
    And I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should contain "mysql:"
    And the zip file "docker-compose.yml" should contain "MYSQL_ROOT_PASSWORD=root pass"
    And the zip file "docker-compose.yml" should contain "MYSQL_DATABASE=db name"
    And the zip file "docker-compose.yml" should contain "MYSQL_USER=user"
    And the zip file "docker-compose.yml" should contain "MYSQL_PASSWORD=pass"

  Scenario: MariaDB config works correctly
    Given I am on "/"
    When I check "MariaDB"
    And I fill in "project_mariadbOptions_rootPassword" with "root pass"
    And I fill in "project_mariadbOptions_databaseName" with "db name"
    And I fill in "project_mariadbOptions_username" with "user"
    And I fill in "project_mariadbOptions_password" with "pass"
    When I press "Generate project archive"
    Then the response code should be 200
    And I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should contain "mariadb:"
    And the zip file "docker-compose.yml" should contain "MYSQL_ROOT_PASSWORD=root pass"
    And the zip file "docker-compose.yml" should contain "MYSQL_DATABASE=db name"
    And the zip file "docker-compose.yml" should contain "MYSQL_USER=user"
    And the zip file "docker-compose.yml" should contain "MYSQL_PASSWORD=pass"

  Scenario: PostgreSQL config works correctly
    Given I am on "/"
    When I check "Postgres"
    And I fill in "project_postgresOptions_rootUser" with "root user"
    And I fill in "project_postgresOptions_rootPassword" with "root pass"
    And I fill in "project_postgresOptions_databaseName" with "db name"
    When I press "Generate project archive"
    Then the response code should be 200
    And I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should contain "postgres:"
    And the zip file "docker-compose.yml" should contain "POSTGRES_USER=root user"
    And the zip file "docker-compose.yml" should contain "POSTGRES_PASSWORD=root pass"
    And the zip file "docker-compose.yml" should contain "POSTGRES_DB=db name"

  Scenario: Redis is included when enabled
    Given I am on "/"
    When I check "Redis"
    And I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should contain "redis:"

  Scenario: Memcached is included when enabled
    Given I am on "/"
    When I check "Memcached"
    And I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should contain "memcached:"

  Scenario: Mailhog is included when enabled
    Given I am on "/"
    When I check "Mailhog"
    And I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should contain "mailhog:"

  Scenario: Clickhouse is included when enabled
    Given I am on "/"
    When I check "Clickhouse"
    And I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should contain "clickhouse:"

  Scenario: Optional services are absent by default
    Given I am on "/"
    When I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should not contain "redis:"
    And the zip file "docker-compose.yml" should not contain "memcached:"
    And the zip file "docker-compose.yml" should not contain "mailhog:"
    And the zip file "docker-compose.yml" should not contain "clickhouse:"
    And the zip file "docker-compose.yml" should not contain "mysql:"
    And the zip file "docker-compose.yml" should not contain "mariadb:"
    And the zip file "docker-compose.yml" should not contain "postgres:"
    And the zip file "docker-compose.yml" should not contain "elasticsearch:"

  Scenario: All optional services enabled simultaneously
    Given I am on "/"
    When I check "Redis"
    And I check "Memcached"
    And I check "Mailhog"
    And I check "Clickhouse"
    And I check "MySQL"
    And I fill in "project_mysqlOptions_rootPassword" with "root pass"
    And I fill in "project_mysqlOptions_databaseName" with "db name"
    And I fill in "project_mysqlOptions_username" with "user"
    And I fill in "project_mysqlOptions_password" with "pass"
    And I check "MariaDB"
    And I fill in "project_mariadbOptions_rootPassword" with "root pass"
    And I fill in "project_mariadbOptions_databaseName" with "db name"
    And I fill in "project_mariadbOptions_username" with "user"
    And I fill in "project_mariadbOptions_password" with "pass"
    And I check "Postgres"
    And I fill in "project_postgresOptions_rootUser" with "root user"
    And I fill in "project_postgresOptions_rootPassword" with "root pass"
    And I fill in "project_postgresOptions_databaseName" with "db name"
    And I press "Generate project archive"
    Then I should receive a zip file named "phpdocker.zip"
    And the zip file "docker-compose.yml" should contain "redis:"
    And the zip file "docker-compose.yml" should contain "memcached:"
    And the zip file "docker-compose.yml" should contain "mailhog:"
    And the zip file "docker-compose.yml" should contain "clickhouse:"
    And the zip file "docker-compose.yml" should contain "mysql:"
    And the zip file "docker-compose.yml" should contain "MYSQL_ROOT_PASSWORD=root pass"
    And the zip file "docker-compose.yml" should contain "MYSQL_DATABASE=db name"
    And the zip file "docker-compose.yml" should contain "MYSQL_USER=user"
    And the zip file "docker-compose.yml" should contain "MYSQL_PASSWORD=pass"
    And the zip file "docker-compose.yml" should contain "mariadb:"
    And the zip file "docker-compose.yml" should contain "postgres:"
    And the zip file "docker-compose.yml" should contain "POSTGRES_USER=root user"
    And the zip file "docker-compose.yml" should contain "POSTGRES_PASSWORD=root pass"
    And the zip file "docker-compose.yml" should contain "POSTGRES_DB=db name"
