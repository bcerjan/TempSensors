# NGINX Files
This directory contains a pair of `server` block definitions suitable for NGINX. Note that you'll want to modify them for your host and create a
`users.txt` file in the `web` directory for [HTTP Basic Auth](https://www.digitalocean.com/community/tutorials/how-to-set-up-basic-http-authentication-with-nginx-on-centos-7).

By tradition, these should go in your `/etc/nginx/sites-available` directory and then get linked to `/etc/nginx/sites-enabled` for use.
