NextTripTicket
==============
###### WORK IN PROGRESS

A new adventure start for travel lovers!

* Documentation: http://goo.gl/5lbSK

## Tree

### ws: The web service

* The web service is in the `ws` folder.
* The API of the web service is documented in the documentation linked above.
* The database is handled using MySQL.
* The source code of the web service is in PHP, using PDO for sql queries.

### site: The website

* The website is in the `site` folter.
* The full documentation of the website is linked above.
* On server-side, the website use PHP to deliver pages.
* On client-side, the website use Javascript, JQuery and JSONP to get information from the database.
* The design of the website is made using LESS, then compiled in CSS.

### misc

* `misc/images` contains logos and images of the project.
* `misc/scripts` contains useful scripts to fill the database or help you install the project on your own computer.

## Install, launch, test

On your server, you will need to install:
* A web server, like [Apache](http://httpd.apache.org/) or [NGinX](http://nginx.org/)
* PHP (>= 5)
* MySQL

Get the project sources from this repository:
```shell
wget https://github.com/db0company/NextTripTicket/archive/master.zip
unzip master.zip
rm master.zip
cd NextTripTicket-master/
```

Install some external dependencies:
* JQuery
* Bootstrap (with js and responsive)
* LESS CSS (for production website only)
* JQuery-JSONP (https://github.com/jaubourg/jquery-jsonp)

```shell
wget http://twitter.github.com/bootstrap/assets/bootstrap.zip
unzip bootstrap.zip
rm bootstrap.zip

wget http://code.jquery.com/jquery-latest.min.js
mv jquery-latest.min.js js/jquery.js

wget https://raw.github.com/jaubourg/jquery-jsonp/master/src/jquery.jsonp.js
mv jquery.jsonp.js js/
```

Edit the configuration file `conf.php` with your settings.
```shell
$EDITOR conf.php
```

Open the website and the web service in your browser!

_If something goes wrong during your installation or if you note
any unexpected behavior, please [open a new issue on Github](https://github.com/db0company/NextTripTicket/issues)._

## Copyright/License


     Copyright 2013 Barbara Lepage

     Licensed under the Apache License, Version 2.0 (the "License");
     you may not use this file except in compliance with the License.
     You may obtain a copy of the License at

         http://www.apache.org/licenses/LICENSE-2.0

     Unless required by applicable law or agreed to in writing, software
     distributed under the License is distributed on an "AS IS" BASIS,
     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     See the License for the specific language governing permissions and
     limitations under the License.


### Author

* Made by __db0__
* Website: http://db0.fr/
* Contact: db0company@gmail.com


### Up to date

Latest version of this project is on GitHub:
* https://github.com/db0company/NextTripTicket/
