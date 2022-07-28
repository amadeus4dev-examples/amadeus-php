## Development and Testing

To run the project locally, clone the repository and install the dependencies.

```
git clone https://github.com/amadeus4dev/amadeus-php.git
cd amadeus-php
composer install
```

Make sure you have [Composer](https://getcomposer.org/) installed as well.

### Static Analysis

To find errors before running test, simply run `vendor/bin/phpstan analyse src tests --level 4`.

### Running tests

To run tests, simply run the `vendor/bin/phpunit tests`.

### Code coverage

To generate the code coverage report in HTML format, simply run `vendor/bin/phpunit ----coverage-html=coverage tests`

We are trying to keep 100% coverage, so keep an eye on the report to review the code coverage.

### Code style fixing

To fix the code follow standard, simply run the following commands

```
vendor/bin/php-cs-fixed fix src 
vendor/bin/php-cs-fixed fix tests
```

### Using a library locally

To use a library locally as a dependency, use Composer's [_repositories_](https://getcomposer.org/doc/05-repositories.md#path) feature.

Then specify the local path of the local library.

## How to contribute to the Amadeus PHP SDK

#### **Did you find a bug?**

* **Ensure the bug was not already reported** by searching on GitHub under Issues.

* If you're unable to find an open issue addressing the problem, open a new one. Be sure to include a **title and clear description**, as much relevant information as possible, and a **code sample** or an **executable test case** demonstrating the expected behavior that is not occurring.

#### **Did you write a patch that fixes a bug?**

* Open a new GitHub pull request with the patch.

* Ensure the PR description clearly describes the problem and solution. Include the relevant issue number if applicable.

#### **Do you intend to add a new feature or change an existing one?**

* Suggest your change in a new issue and start writing code.

* Make sure your new code does not break any tests and include new tests.

* With good code comes good documentation. Try to copy the existing documentation and adapt it to your needs.

* Close the issue or mark it as inactive if you decide to discontinue working on the code.

#### **Do you have questions about the source code?**

* Ask any question about how to use the library by raising a new issue.

