HackerGames 2018 API codebase
---

## Overview

This is a symfony3 REST API forked from my (@danb) CRUD API project here:
- https://github.com/danbelden/symfony-crud-api 

### Tools leveraged:
- PHP7 / MySQL
- Symfony3
- Composer
- Docker / Docker Compose

## Live

You can see the live API swagger docs here:
- http://178.79.129.186/doc

It is deployed on a Linode.com base instance for demo purposes.

## NLP

We began research into auto mapping skills and jobs to each other...

To do this we decided to use NLP tokenization and stemming.

The following libraries were leveraged:

- https://packagist.org/packages/yooper/php-text-analysis
- https://packagist.org/packages/markfullmer/porter2

You can see our stem commands by running the console command in vanilla:

```
BIN CONSOLE HERE
```

This had some mapping but not enough to solve the issue...

If time allowed, we would use thesaurus to expand stems and therfore increase matches.