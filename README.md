# Clients-manager
Clients-manager is an awesome console application with optional input parameter (externalFile) is capable to generate a CSV file, loading clients information from external API and input file (optional)

## How it works

Execute console command at your project path
```
docker/renew-clients
```

Arguments

|#| Name                           |Type| Required | Description | Values       |
|---|--------------------------------|---|----------|-------------|--------------|
|1| --external-file                |string| false    | File path   | /path/filename.xml |
|1| --destination-file |string| false    | File name   | filename.xml |

### --external-file
File path to load clients file in XML format. We recommend put your files in linked path `./clients-manager/tmp`

### --destination-file
The name of the destination file. If its empty, generate a random one with format `YYYY-MM-DD_aaaa_clients.csv`.

## Project set up

Install and run the application.
```
git clone git@github.com:amancho/clients-manager.git
cd clients-manager
docker/composer install
docker/up
```

Examples of the use of the application.
You can use without parameters (only load data from API), with both or single one
```
docker/renew-clients /var/www/tmp/data.xml outputFile.csv
docker/renew-clients /var/www/tmp/data.xml
docker/renew-clients
```

Run tests
```
docker/test
```
