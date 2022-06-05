# XmlImport
Goal
We would like to see a command-line program, based on the Symfony CLI component
(https://symfony.com/doc/current/components/console.html). The program should process a local or remote XML file
and store the data in a CSV file. Build the code in a way that we can easily add another storage adapter if we want to
store the data somewhere else (SQlite, Google Spreadsheet, JSON file etc).
Bonus: Ideally, you deliver this program as an executable Docker container or phar file.
Specifications
1. The program should read in a local or remote XML file (configurable as a parameter)
2. Errors should be written to a logfile
3. Once you are done with the assignment create a github public repository, push your code to it and send the
repository link to us. Please do not send zip files or google share drive.

Coding Style
Of course, your code has to work, but we are especially interested in how you have solved the task.
● Which patterns have been used?
● How easy is it to set up the environment and run your code?
● How is your code structured?
● How performant is your code?
● Have you applied SOLID and/or CLEAN CODE principles?
● Are PHPUnit tests available and how have they been set up?
● How exceptions are handled.
● Are the coding standards followed?
● Comments as required and the Documentation (README.md) explaining how the code should be executed.


php application.php app:xmlimport --source_file='project_folder/coffee_feed.xml'
default export_to is set to csv 
php application.php app:xmlimport --source_file='project_folder/coffee_feed.xml' --export_to='csv'

php unit test 
php ./vendor/bin/phpunit tests/XmlImportCommandTest.php
