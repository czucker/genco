Introduction to Unit Testing with WordPress:
http://codesymphony.co/writing-wordpress-plugin-unit-tests/

How to test:
1. Get latest version of the wordpress-dev trunk
   It goes in the same directory where this wordpress installation is located in
   The dev trunk must be called "wordpress-develop"

   Example file structure:
   ~/dev/wp-config.php
   ~/dev/wp-content/plugins/hello/@tests/readme.txt
   ~/wordpress-develop/trunk

   Get the develop trunk it via:
   > mkdir ~/wordpress-develop
   > cd ~/wordpress-develop
   > svn co http://develop.svn.wordpress.org/trunk/
   > cd trunk
   > svn up

2. simply run `phpunit` from inside this directory


331762-1411588668-ai