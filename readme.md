# Composer GravityForms

This composer plugin enables installation of [GravityForms](https://gravityforms.com) WordPress plugin and its addons.

## Example

```shell
$ composer require gravityforms/gravityforms:*
$ composer require gravityforms/gravityformscli:*
```

**NOTE:** Package name can be any GravityForms addon [slug](https://docs.gravityforms.com/gravity-forms-add-on-slugs/).

## Installation

1. Add the plugin as a global composer requirement:

```shell
$ composer global require piotrpress/composer-gravityforms
```

2. Allow the plugin execution:

```shell
$ composer config -g allow-plugins.piotrpress/composer-gravityforms true
```

3. Provide GravityForms [license key](https://www.gravityforms.com/my-account/licenses/):

```shell
$ composer config --global http-basic.gravityapi.com key <license_key>
```

**NOTE:** using `--global` option is recommended to keep credentials outside of project's files.

## Usage

The GravityForms plugin and its addons have a type set to `wordpress-plugin` and can be installed in custom location using for example [Composer Installers](https://github.com/composer/installers): 

```json
{
  "require": {
    "gravityforms/gravityforms": "*",
    "gravityforms/gravityformscli": "*",
    "composer/installers": "^2.0"
  },
  "config": {
    "allow-plugins": {
      "composer/installers": true
    }
  },
  "extra": {
    "installer-paths": {
      "wp-content/plugins/{$name}/": [
        "type:wordpress-plugin"
      ]
    }
  }
}
```

## Requirements

- PHP >= `7.4` version.
- Composer ^`2.0` version.

## License

[MIT](license.txt)