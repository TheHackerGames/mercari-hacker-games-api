CREATE TABLE IF NOT EXISTS `militaries` (
  `id`      INTEGER(11) unsigned NOT NULL AUTO_INCREMENT,
  `name`    VARCHAR(32)          NOT NULL,
  `created` DATETIME             NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ranks` (
  `id`          INTEGER(11) unsigned NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(32)          NOT NULL,
  `military_id` INTEGER(11) unsigned NOT NULL,
  `created`     DATETIME             NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`military_id`) REFERENCES militaries(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id`          INTEGER(11) unsigned NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(32)          NOT NULL,
  `rank_id`     INTEGER(11) unsigned NOT NULL,
  `military_id` INTEGER(11) unsigned NOT NULL,
  `created`     DATETIME             NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`rank_id`) REFERENCES ranks(id),
  FOREIGN KEY (`military_id`) REFERENCES militaries(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `skills` (
  `id`      INTEGER(11) unsigned NOT NULL AUTO_INCREMENT,
  `name`    VARCHAR(32)          NOT NULL,
  `created` DATETIME             NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id`          INTEGER(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id`     INTEGER(11) unsigned NOT NULL,
  `title`       VARCHAR(64)          NOT NULL,
  `description` TEXT                 NOT NULL,
  `created`     DATETIME             NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `militaries_skills` (
  `military_id` INTEGER(11) unsigned NOT NULL,
  `skill_id`    INTEGER(11) unsigned NOT NULL,
  `created`     DATETIME             NOT NULL,
  PRIMARY KEY (`skill_id`, `military_id`),
  FOREIGN KEY (`military_id`) REFERENCES militaries(id),
  FOREIGN KEY (`skill_id`) REFERENCES skills(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users_skills` (
  `user_id`  INTEGER(11) unsigned NOT NULL,
  `skill_id` INTEGER(11) unsigned NOT NULL,
  `created`  DATETIME             NOT NULL,
  PRIMARY KEY (`user_id`, `skill_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(id),
  FOREIGN KEY (`skill_id`) REFERENCES skills(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jobs_skills` (
  `job_id`   INTEGER(11) unsigned NOT NULL,
  `skill_id` INTEGER(11) unsigned NOT NULL,
  `created`  DATETIME             NOT NULL,
  PRIMARY KEY (`job_id`, `skill_id`),
  FOREIGN KEY (`job_id`) REFERENCES jobs(id),
  FOREIGN KEY (`skill_id`) REFERENCES skills(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
