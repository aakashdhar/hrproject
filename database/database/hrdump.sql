create table holiday
(
  holiday_id         int unsigned auto_increment
    primary key,
  holiday_name       varchar(100)                                 not null,
  holiday_start_date date                                         not null,
  holiday_end_date   date                                         not null,
  holiday_status     enum ('Active', 'InActive') default 'Active' null,
  constraint holiday_holiday_name_uindex
  unique (holiday_name)
);

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

create table user_types
(
  user_type_id     int unsigned auto_increment
    primary key,
  user_type        varchar(20)                                  not null,
  user_type_status enum ('Active', 'InActive') default 'Active' null,
  constraint user_types_user_type_uindex
  unique (user_type)
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

