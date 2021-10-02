# MYSQL-Admin-API
A simple easy to use mysql administration api.

## Features
- Manage connnection.
- Create , Remove databases.
- Run sql querries.
- Create, Remove tables.
- Insert, Remove, Search, Update table content.

## Usage

```bash
docker container create --name mysql-admin-api -p 8000:80  --mount src="MYSQL-Admin-API",target=/var/www/html,type=bind php:7.4-apache
```