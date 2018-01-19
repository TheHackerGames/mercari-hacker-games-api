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
- NLP / Tokenization & Stemming

## Live

You can see the live API swagger docs here:
- http://178.79.129.186/doc

You can see our API doc debugger area here to aid client engineers:
- http://178.79.129.186/_profiler

It is deployed on a Linode.com base instance for demo purposes.

## NLP

We began research into auto mapping skills and jobs to each other...

To do this we decided to use NLP tokenization and stemming.

The following libraries were leveraged:

- https://packagist.org/packages/yooper/php-text-analysis
- https://packagist.org/packages/markfullmer/porter2

You can see our stem commands by running the console command in vanilla:

```
$ bin/console stem:skill
advanced first aid | ["advanced","aid","sophisticated","innovative","modern","high","progressive","st","beginning","inaugural","initial","opening","assistance","assist","helping","care"]
driving | ["driving","motoring","dynamic","impulsive","energetic","dynamical"]
...
```
```
# bin/console stem:jobs
Probation Officer | {"0":"probation","1":"officer","2":"misdemeanor","5":"southeast","6":"corrections",
...
```

Once stems are generated we can map stems to jobs using simple text look-ups:

```
$ bin/console job:skill:match
...
Connected the following skill and job...
Job: Quality Operations Director
Skill: leadership
Connected the following skill and job...
Job: Quality Operations Director
Skill: message processing procedures
Connected the following skill and job...
Job: Quality Operations Director
Skill: process analysis and improvement
Connected the following skill and job...
Job: Quality Operations Director
Skill: project/program management
Connected the following skill and job...
Job: Quality Operations Director
Skill: soft skills
Connected the following skill and job...
Job: Quality Operations Director
Skill: music performance
Connected the following skill and job...
Job: Quality Operations Director
Skill: endurance training
Connected the following skill and job...
Job: Learning and Development Coordinator
Skill: firearm handling and maintenance
Connected the following skill and job...
Job: Learning and Development Coordinator
Skill: schedule/itinerary planning
Connected the following skill and job...
Job: Learning and Development Coordinator
Skill: surveying and mapping methods
Connected the following skill and job...
Job: Learning and Development Coordinator
Skill: process analysis and improvement
Connected the following skill and job...
Job: Learning and Development Coordinator
Skill: endurance training
...
```

## Thesaurus

To extend upon basic tokenization and stemming we expanded incoming searched tokens with synonyms/thesaurus.

This is integrated into the `skill:stem` command using the following API:
- https://api.datamuse.com/words?ml=management

```
[
   {
      word:"managing",
      score:39861,
      tags:[
         "syn",
         "n"
      ]
   },
   {
      word:"direction",
      score:27881,
      tags:[
         "syn",
         "n"
      ]
   },
   {
      word:"managment",
      score:23099,
      tags:[
         "n"
      ]
   },
   {
      word:"managers",
      score:17912,
      tags:[
         "n"
      ]
   },
...
```
