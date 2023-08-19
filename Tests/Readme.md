# Execute tests

Run `composer install` in extension folder.

Maybe some platform requiremnts are missing.

For me that was the install command wich was working

    composer install --ignore-platform-req=ext-dom --ignore-platform-req=ext-xml --ignore-platform-req=ext-xmlwriter

Today I tried `composer instal` inside ddev Container. That works. The Script `runTests` must be executed outside
the ddev container on my local machine due to missing docker / docker-compose.

Execute test

    Build/Scripts/runTests.sh -p 7.4 -s functional -d sqlite -v

Now use mariadb due to erros with missinf `FROM_UNIXTIME` in SQLite. 

    Build/Scripts/runTests.sh -p 8.1 -s functional -d mariadb -v

Change PHP version (`-p`) if necessary.

# use composer Script to execute tests

Got inside ddev/docker container, switch to `operations` folder. Execute:

    composer testUnit

or

    composer testFunctional

## CodeCoverage

* activate xdebug `ddev xdebug`
* set env variable to activate xdebug mode `export XDEBUG_MODE=coverage`
* execute command with codecoverage and filter option

  .Build/bin/phpunit -c Build/UnitTests.xml --coverage-html Build/Reports/CodeCoverage/ --coverage-filter "Classes/*"
