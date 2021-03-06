### What is Presentation2.0?

Presentation2.0 is a Web App that helps you quickly prepare and present presentation simply from Markdown file.


### What are Presentation2.0 features?

- Instantly prepare slide simply from Markdown file
- Seamless slide sync amongst all the devices connected to the network with WebSocket
- Control slide from any devices connected to the network. Yup presenting presentation in team is possible ;)
- Mobile friendly design
- Supports Bootstrap themes
- Supports Velocity transition effects


### What are Presentation2.0 requirements?
* php >=5.5.0
* php-sqlite extension
* [Composer](https://getcomposer.org/)


### How to install?

It's recommended that you use [Composer](https://getcomposer.org/) to install Presentation2.0. Make sure you have installed php-sqlite extension.

```bash
$ composer create-project deepsadhi/presentation2.0 presentation2.0
```

This will install Presentation2.0 and all required dependencies. Presentation2.0 requires PHP 5.5.0 or newer.


### How to use?

##### Run Presentation 2.0 daemon:

```bash
$ cd presentation2.0
$ php bin/server.php
```

##### Make Presentation2.0 live to all devices connected to the network:

```bash
$ cd presentation2.0
$ php -S 0.0.0.0:8000 -t public
```


### How to open Presentation2.0 in presenter mode?

* Open http://localhost:8000/login in your browser
* Login with _admin_ and _admin_ as default username and password
* Click on presentation2_0.md
* Click on Start button to broadcast presentation to viewers (*the all devices connected to the network*)
* Control the slide with Prev button, Next, Swipe Left touch, Swipe Right touch, Left Key or Right Key


### How to open Presentation2.0 in viewer mode?

* Open server http://Server_IP_Address:8000 in your browser


### What is default username and password?

* Default username and password of Presentation2.0 is _admin_ and _admin_ respectively
* Change your username and password from settings menu


### I am not being able to login?

* Check you have installed php-sqlite extension or not

```bash
$ sudo apt-get install php5-sqlite
```

More info on php-sqlite can be found [here](http://php.net/manual/en/sqlite.installation.php)


### How to create presentation?

* Write presentation contents in [Markdown](http://daringfireball.net/projects/markdown/), [GitHub flavored Markdown](https://help.github.com/categories/writing-on-github/) or [Markdown with Extra extension file](https://michelf.ca/projects/php-markdown/extra/). Yup your GitHub Repo README file will work ;)
* Separate each block with three continuous new line
* Open http://localhost:8000/create in your browser
* Enter presentation Title and upload Markdown file

##### Example presenation content sperated by three new line
![Slide block](http://bctians.com/presentation2.0/block.png)

For more details check [Prasedown](http://parsedown.org/)


### Can I embed media files in presentation?

* Currently image files with extensions (png, jpg, jpeg, bmp, gif or svg) can be only embedded in presentation.


### How to embed image in presentation?

* Open http://localhost:8000/media in your browser
* Upload image of extensions (png, jpg, jpeg, bmp, gif or svg)
* Note URL of the media file
* Write media path in presentation content in following markdown format
```markdown
![Caption](/media/image_file_name)
```

##### URL
![Media URL](http://bctians.com/presentation2.0/media.png)


### How to take control of slide from another device?

* Open http://localhost:8000/admin/ in your browser
* Click the presentation you want to resume
* Click on Start button


### Can I control slide from my Smart-phone?

* Of course you can
* Open http://Server_IP_Address/admin/ from Web Socket compatible browsers


### I uploaded Markdown file but it's not parsing block into slide?

* Open http://localhost:8000/admin/ in your browser
* Click the presentation file which has the issue
* Click on Edit button
* Click on Update


### How to change username and password?

* Open http://localhost:8000/admin/settings in your browser


### How to change timezone?

Open presentation.20/config/app.php.
```php
"timezone" => "Asia/Kathmandu",
```
Find above line and change your timezone.


### How to change theme?

Open presentation.20/config/app.php.
```php
"theme" => ["name" => "bootswatch/paper"],
```
Find above line. Search for directory inside presentation2.0/public/theme/bootswatch and replace paper with other available directory names


### How to install more theme?

```bash
$ cd presentation.20/public/theme
```
```bash
$ rm -rf bootswatch/
```
```bash
$ composer create-project thomaspark/bootswatch
```


### Can I add my own theme?

* Yes, you can. Presentation2.0 uses bootstrap. You can use any bootstrap theme or create your own bootstrap theme
* Check presentation2.0/theme directory


### How to change transition effect?

* Presentation2.0 uses [velocity.js](http://julian.com/research/velocity/) for transition effect
* Find line
```js
container.velocity("transition.slideLeftIn");
```
in presentation2.0/public/js/script.js and presentation2.0/public/js/app.js file and replace with any velocity.js transition effect


### How to deploy Presentation2.0 on the Internet?

* Check Web Socket deployment of Ratchet [http://socketo.me/docs/deploy](http://socketo.me/docs/deploy)


### Packages used by Presentation2.0?

* [slim/csrf](https://packagist.org/packages/slim/csrf)
* [slim/flash](https://packagist.org/packages/slim/flash)
* [twig-view](https://packagist.org/packages/slim/twig-view)
* [cboden/ratchet](https://packagist.org/packages/cboden/ratchet)
* [erusev/parsedown](https://packagist.org/packages/erusev/parsedown)
* [slim/slim-skeleton](https://packagist.org/packages/slim/slim-skeleton)
* [thomaspark/bootswatch](https://packagist.org/packages/thomaspark/bootswatch)


### Where can I find Presentation2.0 documentation?

* [API Docs](http://bctians.com/presentation2.0/docs/)
* [User guide](https://github.com/deepsadhi/presentation2.0/blob/master/USER_GUIDE.md)


### License?

* Presentation2.0 is licensed under the GPLv3 license. See [License File](https://github.com/deepsadhi/presentation2.0/blob/master/LICENSE) for more information.
