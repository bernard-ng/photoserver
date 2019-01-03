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
$current = __DIR__;

$server = new \Ng\Photoserver\Server(compact('main', 'current'));
$server->render();
```

## Run the server
after installing and configuring, you have to run the server, if you are using **Xampp**, **Wampp**, etc.. , the installation of the photoserver
should be in the **htdocs** or **www** directory.
photoserver 2.0.0 is only running on **apache server**

## Usage
to use your new photoserver, juste load this url if your are using **Xampp** or else :
``` http://localhost/photoserver_path```

or create a virtual host

## Help
need to make this greater than it is, so your contributions are welcome
