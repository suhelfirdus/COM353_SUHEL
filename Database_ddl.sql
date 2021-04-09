create table alert_category
(
    alert_level_id    int          null,
    alert_description varchar(100) null,
    measure           varchar(50)  null,
    message_text      text         null,
    constraint alert_category_pk
        unique (alert_level_id)
);

create table alert_system
(
    alert_id        int auto_increment,
    alert_date_time datetime default CURRENT_TIMESTAMP null,
    alert_type      varchar(55)                        null,
    is_active       varchar(1)                         null,
    region_id       int                                null,
    notify_people   varchar(1)                         null,
    alert_level_id  int                                null,
    constraint alert_system_pk
        unique (alert_id, region_id),
    constraint alert_system_alert_category_alert_level_id_fk
        foreign key (alert_level_id) references alert_category (alert_level_id)
);

create definer = qfc353_4@`172.16.0.0/255.240.0.0` trigger trg_notify_people
    after insert
    on alert_system
    for each row
begin
    declare pid integer default 0;
    declare emailaddress varchar(100) default '';
    declare messagebody varchar(100) default 'hi, you have a new email';
    declare finished integer default 0;
    declare cursor_allpeople cursor for (select a.person_id, a.email_address
                                         from person p,
                                              address a
                                         where p.person_id = a.person_id
                                           and a.region_id = new.region_id);

    declare continue handler
        for not found set finished = 1;

    open cursor_allpeople;
    getemail:
    loop
        fetch cursor_allpeople into pid,emailaddress;
        if finished = 1 then
            leave getemail;
        end if;
        -- build email list
        insert into messages(person_id, email, old_alert_state, new_alert_state, message_body, message_category)
        values (pid, emailaddress, null, new.alert_type, messagebody, 'general');
    end loop getemail;
    close cursor_allpeople;
end;

create table city
(
    city_id   int auto_increment
        primary key,
    city_name varchar(100) null,
    region_id int          null,
    province  varchar(100) null
);

create table daily_follow_up
(
    person_id     int       null,
    date_reported date      null,
    time_reported timestamp null,
    body_temp     int       null,
    constraint daily_follow_up_pk
        unique (person_id, date_reported, time_reported)
);

create table diagnostic
(
    test_id      int auto_increment,
    person_id    int         null,
    tested_by    int         not null,
    performed_at varchar(40) not null,
    test_date    date        null,
    result_date  date        null,
    result       varchar(10) null,
    primary key (test_id, performed_at, tested_by)
);

create table followup_details
(
    person_id     int          null,
    date_reported date         null,
    time_reported timestamp    null,
    symptoms      varchar(100) null,
    constraint daily_follow_up_pk
        unique (person_id, date_reported, time_reported)
);

create table messages
(
    msg_id           int auto_increment,
    person_id        int                                null,
    datetime         datetime default CURRENT_TIMESTAMP null,
    email            varchar(255)                       null,
    old_alert_state  varchar(55)                        null,
    new_alert_state  varchar(55)                        null,
    message_body     varchar(4000)                      null,
    message_category varchar(55)                        null,
    constraint messages_pk
        unique (msg_id, person_id)
);

create table person
(
    person_id          int auto_increment
        primary key,
    first_name         varchar(100)            null,
    last_name          varchar(100)            null,
    dob                date                    null,
    medicare_number    varchar(100)            null,
    is_health_worker   varchar(3) default 'No' null,
    related_person_no  int                     null,
    health_facility_id varchar(100)            null
);

create table publichealthcenter
(
    facility_id          varchar(40)  not null
        primary key,
    facility_name        varchar(100) null,
    address              varchar(100) null,
    web_address          varchar(100) null,
    phone_number         decimal(20)  null,
    type                 varchar(100) null,
    operating_zone       varchar(100) null,
    method_of_acceptance varchar(100) null,
    has_drive_through    varchar(1)   null
);

create table recommendations
(
    rec_id   int auto_increment
        primary key,
    rec_name varchar(100) null,
    rec_date date         null,
    rec_text text         null
);

create table region
(
    region_id   int auto_increment
        primary key,
    region_name varchar(100) null
);

create table address
(
    address_id     int auto_increment
        primary key,
    person_id      int          null,
    street_address varchar(100) null,
    email_address  varchar(100) null,
    postal_code    varchar(10)  null,
    phone_number   varchar(255) null,
    city_id        int          null,
    region_id      int          null,
    constraint address_city_city_id_fk
        foreign key (city_id) references city (city_id),
    constraint address_person_person_id_fk
        foreign key (person_id) references person (person_id),
    constraint address_region_region_id_fk
        foreign key (region_id) references region (region_id)
);

create table users
(
    username  varchar(40)  null,
    email     varchar(100) null,
    user_type varchar(10)  null,
    password  varchar(100) null
);

create table work_schedule
(
    person_id      int          not null,
    facility_id    varchar(100) not null,
    schedule_date  date         not null,
    schedule_start time         null,
    schedule_end   time         null,
    primary key (person_id, facility_id, schedule_date)
);

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view active_alerts_view as
select `qfc353_4`.`alert_system`.`alert_id`            AS `alert_id`,
       `qfc353_4`.`alert_system`.`alert_date_time`     AS `alert_date_time`,
       `qfc353_4`.`alert_system`.`alert_level_id`      AS `alert_level_id`,
       `qfc353_4`.`alert_category`.`alert_description` AS `alert_desc`,
       `qfc353_4`.`alert_system`.`is_active`           AS `is_active`,
       `qfc353_4`.`alert_system`.`region_id`           AS `region_id`,
       `qfc353_4`.`alert_system`.`notify_people`       AS `notify_people`
from (`qfc353_4`.`alert_system`
         join `qfc353_4`.`alert_category`)
where ((`qfc353_4`.`alert_system`.`alert_level_id` = `qfc353_4`.`alert_category`.`alert_level_id`) and
       (`qfc353_4`.`alert_system`.`is_active` = 'Y'));

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view alerts_view as
select `r`.`region_id`                                                                         AS `region_id`,
       `qfc353_4`.`a`.`alert_id`                                                               AS `alert_id`,
       `r`.`region_name`                                                                       AS `region_name`,
       `qfc353_4`.`a`.`alert_desc`                                                             AS `alert_desc`,
       `qfc353_4`.`a`.`alert_date_time`                                                        AS `alert_date_time`,
       (select count(0)
        from (`qfc353_4`.`person` `p`
                 join `qfc353_4`.`address` `ad`)
        where ((`p`.`person_id` = `ad`.`person_id`) and (`ad`.`region_id` = `r`.`region_id`))) AS `population`,
       concat('region_name=', `r`.`region_name`)                                               AS `pkey`,
       'alert'                                                                                 AS `screenname`
from (`qfc353_4`.`region` `r`
         left join `qfc353_4`.`active_alerts_view` `a` on ((`r`.`region_id` = `qfc353_4`.`a`.`region_id`)));

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view cities_view as
select `c`.`city_id`                                               AS `city_id`,
       `c`.`region_id`                                             AS `region_id`,
       (select `qfc353_4`.`region`.`region_name`
        from `qfc353_4`.`region`
        where (`qfc353_4`.`region`.`region_id` = `c`.`region_id`)) AS `region_name`,
       `c`.`city_name`                                             AS `city_name`,
       `c`.`province`                                              AS `province`,
       concat('city_id=', `c`.`city_id`)                           AS `pkey`,
       'cities'                                                    AS `screenname`
from `qfc353_4`.`city` `c`;

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view diagnostic_det_view as
select `p`.`person_id`                                             AS `person_id`,
       `p`.`first_name`                                            AS `first_name`,
       `p`.`last_name`                                             AS `last_name`,
       `p`.`dob`                                                   AS `dob`,
       `p`.`medicare_number`                                       AS `medicare_number`,
       `p`.`is_health_worker`                                      AS `is_health_worker`,
       `p`.`related_person_no`                                     AS `related_person_no`,
       `d`.`test_id`                                               AS `test_id`,
       `d`.`tested_by`                                             AS `tested_by`,
       `d`.`performed_at`                                          AS `performed_at`,
       `d`.`test_date`                                             AS `test_date`,
       `d`.`result_date`                                           AS `result_date`,
       `d`.`result`                                                AS `result`,
       `a`.`address_id`                                            AS `address_id`,
       `a`.`street_address`                                        AS `street_address`,
       `a`.`email_address`                                         AS `email_address`,
       `a`.`postal_code`                                           AS `postal_code`,
       `a`.`phone_number`                                          AS `person_phone_number`,
       `a`.`city_id`                                               AS `city_id`,
       (select `qfc353_4`.`city`.`city_name`
        from `qfc353_4`.`city`
        where (`qfc353_4`.`city`.`city_id` = `a`.`city_id`))       AS `city_name`,
       `a`.`region_id`                                             AS `region_id`,
       (select `qfc353_4`.`region`.`region_name`
        from `qfc353_4`.`region`
        where (`qfc353_4`.`region`.`region_id` = `a`.`region_id`)) AS `region_name`,
       `ph`.`facility_id`                                          AS `facility_id`,
       `ph`.`facility_name`                                        AS `facility_name`,
       `ph`.`address`                                              AS `address`,
       `ph`.`web_address`                                          AS `web_address`,
       `ph`.`phone_number`                                         AS `ph_phone_number`,
       `ph`.`type`                                                 AS `type`,
       `ph`.`operating_zone`                                       AS `operating_zone`,
       `ph`.`method_of_acceptance`                                 AS `method_of_acceptance`,
       `ph`.`has_drive_through`                                    AS `has_drive_through`
from (((`qfc353_4`.`person` `p` join `qfc353_4`.`diagnostic` `d`) join `qfc353_4`.`publichealthcenter` `ph`)
         join `qfc353_4`.`address` `a`)
where ((`p`.`person_id` = `d`.`person_id`) and (`d`.`performed_at` = `ph`.`facility_id`) and
       (`p`.`person_id` = `a`.`person_id`));

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view diagnostic_view as
select `d`.`test_id`                     AS `test_id`,
       `d`.`person_id`                   AS `person_id`,
       `p`.`first_name`                  AS `person_name`,
       `p`.`last_name`                   AS `last_name`,
       `d`.`tested_by`                   AS `tested_by`,
       `d`.`performed_at`                AS `tested at`,
       `d`.`test_date`                   AS `test date`,
       `d`.`result_date`                 AS `result date`,
       `d`.`result`                      AS `result`,
       concat('test_id=', `d`.`test_id`) AS `pkey`,
       'covidtest'                       AS `screenname`
from (`qfc353_4`.`diagnostic` `d`
         join `qfc353_4`.`person` `p`)
where (`p`.`person_id` = `d`.`person_id`);

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view healthworker_basicinfo_view as
select `p`.`person_id`       AS `person_id`,
       `p`.`first_name`      AS `first_name`,
       `p`.`last_name`       AS `last_name`,
       `phc`.`facility_id`   AS `facility_id`,
       `phc`.`facility_name` AS `facility_name`
from (`qfc353_4`.`person` `p`
         join `qfc353_4`.`publichealthcenter` `phc` on ((`p`.`health_facility_id` = `phc`.`facility_id`)))
where (`p`.`is_health_worker` = 'yes');

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view healthworker_det_schedule_view as
select `wsh`.`person_id`                               AS `person_id`,
       `wsh`.`schedule_date`                           AS `schedule_date`,
       `wsh`.`schedule_start`                          AS `schedule_start`,
       `wsh`.`schedule_end`                            AS `schedule_end`,
       `phc`.`facility_id`                             AS `facility_id`,
       `phc`.`facility_name`                           AS `facility_name`,
       'healthworker_det_schedule'                     AS `screenName`,
       concat('person_id=', `wsh`.`person_id`)         AS `pkey1`,
       concat('facility_id=', `wsh`.`facility_id`)     AS `pkey2`,
       concat('schedule_date=', `wsh`.`schedule_date`) AS `pkey3`
from (`qfc353_4`.`work_schedule` `wsh`
         join `qfc353_4`.`publichealthcenter` `phc` on ((`wsh`.`facility_id` = `phc`.`facility_id`)));

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view healthworker_rec_view as
select `p`.`person_id`                       AS `person_id`,
       `p`.`first_name`                      AS `first_name`,
       `p`.`last_name`                       AS `last_name`,
       `p`.`is_health_worker`                AS `is_health_worker`,
       concat('person_id=', `p`.`person_id`) AS `pkey1`,
       'healthworker'                        AS `screenName`,
       `phc`.`facility_name`                 AS `facility_name`
from (`qfc353_4`.`person` `p`
         join `qfc353_4`.`publichealthcenter` `phc` on ((`p`.`health_facility_id` = `phc`.`facility_id`)))
where (`p`.`is_health_worker` = 'yes');

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view healthworker_schedule_view as
select `wsh`.`person_id`                           AS `person_id`,
       `wsh`.`schedule_date`                       AS `schedule_date`,
       `wsh`.`schedule_start`                      AS `schedule_start`,
       `wsh`.`schedule_end`                        AS `schedule_end`,
       `phc`.`facility_id`                         AS `facility_id`,
       'healthworker_schedule_view'                AS `screenName`,
       concat('person_id=', `wsh`.`person_id`)     AS `pkey1`,
       concat('facility_id=', `wsh`.`facility_id`) AS `pkey2`
from (`qfc353_4`.`work_schedule` `wsh`
         join `qfc353_4`.`publichealthcenter` `phc` on ((`wsh`.`facility_id` = `phc`.`facility_id`)));

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view next_available_alert as
select `qfc353_4`.`region`.`region_name`               AS `region_name`,
       `qfc353_4`.`alert_category`.`alert_level_id`    AS `alert_level_id`,
       `qfc353_4`.`alert_category`.`alert_description` AS `alert_description`
from ((`qfc353_4`.`active_alerts_view` join `qfc353_4`.`region`)
         join `qfc353_4`.`alert_category`)
where (((`qfc353_4`.`alert_category`.`alert_level_id` = (`qfc353_4`.`active_alerts_view`.`alert_level_id` + 1)) or
        (`qfc353_4`.`alert_category`.`alert_level_id` = (`qfc353_4`.`active_alerts_view`.`alert_level_id` - 1))) and
       (`qfc353_4`.`region`.`region_id` = `qfc353_4`.`active_alerts_view`.`region_id`))
union
select `qfc353_4`.`region`.`region_name`               AS `region_name`,
       `qfc353_4`.`alert_category`.`alert_level_id`    AS `alert_level_id`,
       `qfc353_4`.`alert_category`.`alert_description` AS `alert_description`
from (`qfc353_4`.`region`
         join `qfc353_4`.`alert_category`)
where `qfc353_4`.`region`.`region_id` in
      (select `qfc353_4`.`active_alerts_view`.`region_id` from `qfc353_4`.`active_alerts_view`) is false;

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view person_det_view as
select `p`.`person_id`                                             AS `person_id`,
       `p`.`first_name`                                            AS `first_name`,
       `p`.`last_name`                                             AS `last_name`,
       `p`.`dob`                                                   AS `dob`,
       `p`.`medicare_number`                                       AS `medicare_number`,
       `p`.`is_health_worker`                                      AS `is_health_worker`,
       `p`.`health_facility_id`                                    AS `health_facility_id`,
       `p`.`related_person_no`                                     AS `related_person_no`,
       `a`.`email_address`                                         AS `email_address`,
       `a`.`phone_number`                                          AS `phone_number`,
       `a`.`street_address`                                        AS `street_address`,
       `a`.`region_id`                                             AS `region_id`,
       (select `qfc353_4`.`region`.`region_name`
        from `qfc353_4`.`region`
        where (`qfc353_4`.`region`.`region_id` = `a`.`region_id`)) AS `region_name`,
       `a`.`city_id`                                               AS `city_id`,
       (select `qfc353_4`.`city`.`city_name`
        from `qfc353_4`.`city`
        where (`qfc353_4`.`city`.`city_id` = `a`.`city_id`))       AS `city_name`,
       `a`.`postal_code`                                           AS `postal_code`
from (`qfc353_4`.`person` `p`
         join `qfc353_4`.`address` `a`)
where (`a`.`person_id` = `p`.`person_id`);

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view persons_view as
select `p`.`person_id`                       AS `person_id`,
       `p`.`first_name`                      AS `first name`,
       `p`.`last_name`                       AS `last name`,
       `p`.`dob`                             AS `dob`,
       `p`.`medicare_number`                 AS `mecidare no`,
       `p`.`is_health_worker`                AS `health worker`,
       `p`.`related_person_no`               AS `related_person_no`,
       concat('person_id=', `p`.`person_id`) AS `pkey`,
       'person'                              AS `screenname`
from `qfc353_4`.`person` `p`;

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view publichealthcentres_det_view as
select `phc`.`facility_id`          AS `facility_id`,
       `phc`.`facility_name`        AS `facility_name`,
       `phc`.`address`              AS `address`,
       `phc`.`web_address`          AS `web_address`,
       `phc`.`phone_number`         AS `phone_number`,
       `phc`.`type`                 AS `type`,
       `phc`.`operating_zone`       AS `operating_zone`,
       `phc`.`method_of_acceptance` AS `method_of_acceptance`,
       `phc`.`has_drive_through`    AS `has_drive_through`
from `qfc353_4`.`publichealthcenter` `phc`;

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view publichealthcentres_view as
select `phc`.`facility_id`                         AS `facility id`,
       `phc`.`facility_name`                       AS `facility name`,
       `phc`.`address`                             AS `address`,
       `phc`.`web_address`                         AS `web site`,
       `phc`.`phone_number`                        AS `contact`,
       `phc`.`type`                                AS `type`,
       `phc`.`operating_zone`                      AS `operating zone`,
       `phc`.`method_of_acceptance`                AS `acceptance method`,
       `phc`.`has_drive_through`                   AS `drive through?`,
       concat('facility_id=', `phc`.`facility_id`) AS `pkey`,
       'healthcenter'                              AS `screenname`
from `qfc353_4`.`publichealthcenter` `phc`;

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view recommendations_view as
select `r`.`rec_id`                    AS `Rec id`,
       `r`.`rec_name`                  AS `Rec Name`,
       `r`.`rec_date`                  AS `Rec Nate`,
       concat('rec_id=', `r`.`rec_id`) AS `pkey`,
       'recommendations'               AS `screenname`
from `qfc353_4`.`recommendations` `r`;

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view region_det_view as
select `r`.`region_id` AS `region_id`, `r`.`region_name` AS `region_name`, 'region' AS `screenname`
from `qfc353_4`.`region` `r`;

create definer = qfc353_4@`172.16.0.0/255.240.0.0` view region_view as
select `r`.`region_id`                       AS `region id`,
       `r`.`region_name`                     AS `region name`,
       concat('region_id=', `r`.`region_id`) AS `pkey`,
       'regions'                             AS `screenname`
from `qfc353_4`.`region` `r`;

