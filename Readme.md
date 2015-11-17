# OpenGraph

This module is for Thelia 2.2.1 or greater and 2.1.7 or greater.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is OpenGraph.
* Activate it in your thelia administration panel

### Composer

Add it in your main Thelia composer.json file

```
composer require thelia/open-graph-module:~1.0
```

## Description

Add meta tags in the code of some pages to configure what will be displayed when you share the url on social medias.
Works with Facebook, Twitter, Google+ and Pinterest and concerns the folder, content, product and category pages only.

For more informations about the Open Graph protocol visit this site : http://opengraphprotocol.org/

## Usage

Configure the module by adding your company name, your alias on twitter (@openstudio for example) and the alias of the creator of the product you want to share.

Share different pages of your site on the social networks and the different fields like title, description and price will be filled automatically.
Pinterest needs a special validation on its development website : https://developers.pinterest.com/tools/url-debugger/, follow the procedure, your page will be approved and you will receive a confirmation mail.