# Execute tests

Run `composer install` in extension folder.

Maybe some platform requiremnts are missing.

For me that was the install command wich was working

    composer install --ignore-platform-req=ext-dom --ignore-platform-req=ext-xml --ignore-platform-req=ext-xmlwriter

Execute test

    Build/Scripts/runTests.sh -p 7.4 -s functional -d sqlite -v

Change PHP version (`-p`) if necessary.
