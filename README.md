![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)

# Gravity Forms Prevent Database Storing

A Gravity Forms plugin to let the form creator decide if the values should be saved to database or not.

## Installation

```
composer require devgeniem/wp-gravityforms-db-prevent
```
Then activate the plugin from the WordPress dashboard or with the WP-CLI.

```
wp plugin activate wp-gravityforms-db-prevent
```

## Usage

This plugins adds a checkbox to the Gravity Forms form settings that prevents form entries to be stored in the database.

Technically the entries do get stored in the database, but they are deleted from there immediately after all the emails regarding the entry are sent. This is due to technical restrictions in the way Gravity Forms has been created.

## Changelog

[CHANGELOG.md](CHANGELOG.md)

## Contributors

-  [Geniem](https://github.com/devgeniem)
-  [Miika Arponen](https://github.com/nomafin)
