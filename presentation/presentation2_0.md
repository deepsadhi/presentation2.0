# Presentation2.0

Presentation2.0 is a PHP Web App that helps you quickly prepare and present presentation simply from Markdown file.


## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Presentation2.0.

```bash
$ composer create-project deepsadhi/presentation2.0 presentation2.0 dev-dev
```

This will install Presentation2.0 and all required dependencies. Presentation2.0 requires PHP 5.5.0 or newer.


## Usage

Run Presentation 2.0 daemon:
```bash
$ cd presentation2.0
$ php bin/server.php
```

Make Presentation2.0 live to all devices connected to the network:
```bash
$ cd Presentation2.0
$ php -S 0.0.0.0:8000 -t public/
```


## How to open Presentation2.0 in presenter mode?

* Open **http://localhost:8000/login** in your browser
* Login with **admin** and **admin** as default username and password
* Click on **presentation2_0.md**
* Click on **Start** button to broadcast presentation to viewers (*the all devices connected to the network*)
* Control the slide with **Prev** button, **Next**, **Swipe Left** touch, **Swipe Right** touch, **Left Key** or **Right Key**


## How to open Presentation2.0 in viewer mode?

*  Open server **http://Server IP Address:8000**


## License

Presentation2.0 is licensed under the GPLv3 license. See [License File](LICENSE)
 for more information.