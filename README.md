# Presentation2.0

Presentation2.0 prepares your slide simply from Markdown and syncs slide across
all devices (Laptop, Smart phones, PC, Tablets ...) connected to the network.
All your GitHub repository README is ready to present on Presentation2.0.

## Installation

```bash
$ git clone https://github.com/deepsadhi/presentation2.0.git
$ cd presentation2.0
$ composer install
```

## Usage

Run Presentation 2.0 daemon:
```bash
$ cd Presentation2.0
$ php bin/server.php
```

Make Presentation 2.0 live on your network:
```bash
$ cd Presentation2.0
$ php -S 0.0.0.0:8000 -t public
```

For presenter:
* Open http://localhost:8000/login in your browser
* Login with admin and admin as default username and password
* Click on bootstrap.md
* Click on Start to broadcast presentation to viewer
* Control the slide with Left, Right, Swipe Left, Swipe Right, Left Key or Right Key


For Viewer:
- Open server http://Server IP Address:8000


## License

Presentation2.0 is licensed under the GPLv3 license. See [License File](LICENSE)
 for more information.
