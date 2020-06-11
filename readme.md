# Manu test plugin

Plugin for Manu:Team

## Installation

Import plugin folder to Wordpress site through admin panel

## Usage

Add developer (uses POST request)
```
[wordpress site link]/index.php/wp-json/manu/developers/add-developer/
```
Required data: **name, position, stack**


Show JSON file, which contain developer's info (uses GET request)
```
[wordpress site link]/index.php/wp-json/manu/developers/get-all
```
