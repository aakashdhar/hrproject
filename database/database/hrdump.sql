create table user_attendance
(
  attendance_id     int unsigned auto_increment
    primary key,
  user_id           int unsigned                                           not null,
  attendance_date   date                                                   not null,
  attendance_status enum ('Present', '1/2 Day', 'Absent') default 'Absent' null,
  attendance_hrs    float(4, 2)                                            null,
  created_at        timestamp default CURRENT_TIMESTAMP                    not null
  on update CURRENT_TIMESTAMP,
  updated_at        timestamp default '0000-00-00 00:00:00'                not null
);

create table user_status
(
  user_status_id     int unsigned auto_increment
    primary key,
  user_status        varchar(20)                                  not null,
  user_status_status enum ('Active', 'InActive') default 'Active' null,
  constraint user_status_user_status_uindex
  unique (user_status)
);

create table users
(
  user_id           int unsigned auto_increment
    primary key,
  user_name         varchar(50)                             not null,
  user_first_name   varchar(100)                            not null,
  user_last_name    varchar(100)                            null,
  user_email        varchar(100)                            not null,
  user_password     varchar(100)                            not null,
  user_password_raw varchar(100)                            not null,
  user_type_id      int unsigned                            null,
  user_status_id    int unsigned                            null,
  remember_token    varchar(100)                            null,
  created_at        timestamp default CURRENT_TIMESTAMP     not null
  on update CURRENT_TIMESTAMP,
  updated_at        timestamp default '0000-00-00 00:00:00' not null,
  constraint users_user_email_uindex
  unique (user_email),
  constraint users_user_name_uindex
  unique (user_name)
);

DROP TABLE `company_holiday`;
CREATE TABLE `company_holiday` (
  `holiday_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `holiday_name` varchar(100) NOT NULL,
  `holiday_start_date` date NOT NULL,
  `holiday_end_date` date NOT NULL,
  `holiday_status` enum('Active','InActive') DEFAULT 'Active',
  `holiday_created_at` timestamp NULL DEFAULT NULL,
  `holiday_updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

DROP TABLE `user_attendance`;
CREATE TABLE `user_attendance` (
  `attendance_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `attendance_date` date NOT NULL,
  `attendance_status` enum('Present','1/2 Day','Absent') DEFAULT 'Absent',
  `attendance_hrs` float(4,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

DROP TABLE `user_types`;
CREATE TABLE `user_types` (
  `user_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_type` varchar(20) NOT NULL,
  `user_type_status` enum('Active','InActive') DEFAULT 'Active',
  `user_type_created_at` timestamp NULL DEFAULT NULL,
  `user_type_updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_type_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE `user_holiday`;
CREATE TABLE `hr_project`.`user_holiday` (
  `user_holiday_id` INT NOT NULL,
  `user_id` VARCHAR(45) NULL,
  `user_holiday_from` DATE NOT NULL,
  `user_holiday_to` DATE NOT NULL,
  `user_holiday_doc` VARCHAR(255) NULL,
  `user_holiday_reason` TEXT NULL,
  `user_holiday_approval_status` VARCHAR(255) NULL DEFAULT 'Pending',
  `user_holiday_created_at` TIMESTAMP NULL,
  `user_holiday_updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`user_holiday_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;;

DROP TABLE `user_designation`;
CREATE TABLE `hr_project`.`user_designation` (
  `user_designation_id` INT NOT NULL,
  `user_designation_title` VARCHAR(45) NULL,
  `user_designation_status` VARCHAR(45) NULL DEFAULT 'Pending',
  `user_designation_created_at` TIMESTAMP NULL,
  `user_designation_updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`user_designation_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE `user_reminder`;
CREATE TABLE `user_reminder` (
  `user_reminder_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `user_reminder_details` TEXT NULL,
  `user_remind_on` DATE NULL,
  `user_reminder_status` ENUM('pending', 'completed') NULL DEFAULT 'pending',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`user_reminder_id`));

CREATE TABLE `leave_applications` (
 `leave_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `applicant_id` int(11) unsigned NOT NULL,
 `approver_id` int(11) unsigned NOT NULL,
 `from_date` date NOT NULL, `to_date` date NOT NULL, `total_days` tinyint(1) unsigned NOT NULL,
 `status` enum('Pending','Approved','Rejected','Cancelled') NOT NULL DEFAULT 'Pending',
 `reason` varchar(512) DEFAULT NULL, `approval_comment` varchar(512) DEFAULT NULL,
 `is_read` enum('Yes','No') NOT NULL DEFAULT 'No', `cancel_reason` varchar(512) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`leave_id`) 
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

CREATE TABLE `holiday` 
( `holiday_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `holiday_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `holiday_date` date NOT NULL, `office_location_id` int(10) NOT NULL,
 `holiday_status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL, PRIMARY KEY (`holiday_id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;