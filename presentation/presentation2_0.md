### Presentation2.0

Presentation2.0 is a Web App that helps you quickly prepare and present presentation simply from Markdown file.


### Features

- Instantly prepare slide simply from Markdown file
- Seamless slide sync amongst all the devices connected to the network with WebSocket
- Control slide from any devices connected to the network. Yup presenting presentation in team is possible ;)
- Mobile friendly design
- Supports Bootstrap themes
- Supports Velocity transition effects


### Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Presentation2.0. Make sure you have installed php-sqlite extension.

```bash
$ composer create-project deepsadhi/presentation2.0 presentation2.0
```

This will install Presentation2.0 and all required dependencies. Presentation2.0 requires PHP 5.5.0 or newer with sqlite extension.


### Usage

Run Presentation 2.0 daemon:
```bash
$ cd presentation2.0
$ php bin/server.php
```

Make Presentation2.0 live to all devices connected to the network:
```bash
$ cd presentation2.0
$ php -S 0.0.0.0:8000 -t public
```


### Open Presentation2.0 in presenter mode

* Open http://localhost:8000/login in your browser
* Login with _admin_ and _admin_ as default username and password
* Click on presentation2_0.md
* Click on Start button to broadcast presentation to viewers (*the all devices connected to the network*)
* Control the slide with Prev button, Next, Swipe Left touch, Swipe Right touch, Left Key or Right Key


### Open Presentation2.0 in viewer mode

*  Open server http://Server_IP_Address:8000 in your browser


### Documentation

* [API Docs](http://bctians.com/presentation2.0/docs/)
* [User guide](http://localhost:8000/admin/presentation/USER_GUIDE_md/show)


### License

Presentation2.0 is licensed under the GPLv3 license. See [License File](https://github.com/deepsadhi/presentation2.0/blob/master/LICENSE) for more information.
