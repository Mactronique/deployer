# Deployer

[![Dependency Status](https://www.versioneye.com/user/projects/55c48bd7653762001700351d/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55c48bd7653762001700351d)


## config

Place .deployer.yaml on root of project with content :

``` yaml
project:
    name: My Project
    sources:
        -
            type: svn # only svn suported.
            base_url: http://svn.source.com/svn/project/
            default_source: tags # can specicy all existing folder after base url. But if tags, the version is the next folder.
            project_target: .
        -
            type: svn-export
            base_url: http://svn.source.com/svn/project/
            default_source: config
            project_target: app/config/
    shared:
        - /app/config
        - /vendor
        - /app/logs
    commands:
        pre:
            - app/console cache:clear -e=prod --no-warmup
        post:
            - app/console cache:clear -e=prod
            - rm -rf docker behat build
    target:
        - 
            name: dev
            server: myserver
            env: dev # the plateform environment (dev, preprod, prod)
            source: trunk #if you want overwrite the source
            folder_dest: /var/www/project
            allow_backup: false #if true, the folder project is copied before update
            shared: [/app/config] # folder or file refered at the project root

```


## Command

This is the goal :

Init the project and create the configuration (from the dev workstation) :
``` shell
php deployer.phar init
```

Deploy in the server :
``` shell
php deployer.phar deploy <path to project>
```

Project in management in this server :

``` shell
php deployer.phar projects
```

Update an managed project :

``` shell
php deployer.phar update <project name>
```

Show if the managed project can update :

``` shell
php deployer.phar update <project name> --dry-run
```

Show all managed projects can be updated :

``` shell
php deployer.phar update --dry-run
```

This command is forbiden for security reason :
``` shell
php deployer.phar update
```
Effect : update all managed projects can be updated.