Feature:
  Generator tests

  Scenario: Home page redirects to generator
    When I load "/"
    Then it should permanently redirect to "http://localhost/generator"


  Scenario: Generator page loads correctly
    When I load "/generator"
    Then the response code should be 200



