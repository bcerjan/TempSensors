# Website Files
Here are the files for running the webserver which both serves a simple web page for browsing temperature data and receives `POST` requests from the
ESP8266 units.

You will need to create a `db_config.php` file with a username and password for PHP to use to connect to your database (also, you need to create a database).

Additionally, you'll want to add `secret_key.php` with the same secret key from `/firmware/include/WiFiDetails.h` which is a low-rent way of making sure
your `POST` requests are valid.
