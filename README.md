# PhotoServer

offline photoserver for development, serves randomly photos that are hosted on your computer via a web interface; 
this is a "lorem ipsum" but for photos hosted in your computer.


## Installation

the first step, is to install the photoserver sources, you can clone the project or use composer to install it.

```
composer create-project bernard-ng/photoserver photoserver_path
```

after installing sources, you have to configure the path (absolute) to your hosted images, the ``` $main``` variable must containt that path.

here is an exemple :

```
<?php
require("vendor/autoload.php");
$main = dirname(__DIR__, 3) . "Users\\Bernard-ng\\pictures\\NGPICTURES";
$server = new \Ng\Photoserver\Server($main);
$server->render();
```

## Run the server
after installing and configuring, you have to run the server, if you are using **Xampp**, **Wampp**, etc.. , the installation of the photoserver
should be in the **htdocs** or **www** directory.

if you are using **php development server** :
```
php -S localhost:4080 index.php
```
**Notice :** you can use any available port for the **php development server**.

## Usage
to use your new photoserver, juste load this url if your are using **Xampp** or else :
``` http://localhost/photoserver_path```

if you are using the php dev server just use the link below :
``` http://localhost:4080```

## Help
need to make this greater than it is, so your contributions are welcome
