create table ALERT_SYSTEM
(
    ALERT_ID        int auto_increment,
    ALERT_DATE_TIME datetime default CURRENT_TIMESTAMP null,
    ALERT_TYPE      varchar(55)                        null,
    IS_ACTIVE       varchar(1)                         null,
    REGION_ID       int                                null,
    NOTIFY_PEOPLE   varchar(1)                         null,
    constraint ALERT_SYSTEM_pk
        unique (ALERT_ID, REGION_ID)
);

create table CITY
(
    city_id   int auto_increment
        primary key,
    city_name varchar(100) null,
    region_id int          null
);

create table DAILY_FOLLOW_UP
(
    PERSON_ID     int       null,
    DATE_REPORTED date      null,
    TIME_REPORTED timestamp null,
    BODY_TEMP     int       null,
    constraint DAILY_FOLLOW_UP_pk
        unique (PERSON_ID, DATE_REPORTED, TIME_REPORTED)
);

create table Diagnostic
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

create table FOLLOWUP_DETAILS
(
    PERSON_ID     int          null,
    DATE_REPORTED date         null,
    TIME_REPORTED timestamp    null,
    SYMPTOMS      varchar(100) null,
    constraint DAILY_FOLLOW_UP_pk
        unique (PERSON_ID, DATE_REPORTED, TIME_REPORTED)
);

create table MESSAGES
(
    MSG_ID           int auto_increment,
    PERSON_ID        int                                null,
    DATETIME         datetime default CURRENT_TIMESTAMP null,
    EMAIL            varchar(255)                       null,
    OLD_ALERT_STATE  varchar(55)                        null,
    NEW_ALERT_STATE  varchar(55)                        null,
    MESSAGE_BODY     varchar(4000)                      null,
    MESSAGE_CATEGORY varchar(55)                        null,
    constraint MESSAGES_pk
        unique (MSG_ID, PERSON_ID)
);

create table PUBLICHEALTHCENTER
(
    facility_id          varchar(40)  not null
        primary key,
    facility_name        varchar(100) null,
    address              varchar(100) null,
    web_address          varchar(100) null,
    phone_number         int          null,
    type                 varchar(100) null,
    operating_zone       varchar(100) null,
    method_of_acceptance varchar(100) null,
    has_drive_through    varchar(1)   null
);

create table Person
(
    person_id         int auto_increment
        primary key,
    first_name        varchar(100)           null,
    last_name         varchar(100)           null,
    DOB               date                   null,
    medicare_number   varchar(100)           null,
    is_health_worker  varchar(1) default 'N' null,
    related_person_no int                    null
);

create table UI_QUERIES
(
    TABLE_NAME varchar(100)  null,
    QUERY      varchar(4000) null
);

create table region
(
    region_id            int auto_increment
        primary key,
    region_name          varchar(100)                null,
    current_active_alert varchar(55) default 'green' null
);

create table address
(
    address_id     int auto_increment
        primary key,
    person_id      int          null,
    street_address varchar(100) null,
    email_address  varchar(100) null,
    province       varchar(50)  null,
    postal_code    varchar(10)  null,
    phone_number   varchar(255) null,
    city_id        int          null,
    region_id      int          null,
    constraint address_city_city_id_fk
        foreign key (city_id) references CITY (city_id),
    constraint address_person_person_id_fk
        foreign key (person_id) references Person (person_id),
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

create definer = root@localhost view alerts_view as
select `a`.`REGION_ID`                           AS `region_id`,
       `a`.`ALERT_ID`                            AS `ALERT_ID`,
       `r`.`region_name`                         AS `region_name`,
       `a`.`ALERT_TYPE`                          AS `alert_type`,
       `a`.`ALERT_DATE_TIME`                     AS `ALERT_DATE_TIME`,
       concat('region_name=', `r`.`region_name`) AS `pkey`,
       'alert'                                   AS `screenName`
from `main_projectv1`.`region` `r`
         join `main_projectv1`.`alert_system` `a`
where ((`a`.`REGION_ID` = `r`.`region_id`) and (`a`.`IS_ACTIVE` = 'Y'));

create definer = root@localhost view diagnostic_view as
select `d`.`test_id`                     AS `Test Id`,
       `d`.`tested_by`                   AS `Tested By`,
       `d`.`performed_at`                AS `Tested At`,
       `d`.`test_date`                   AS `Test Date`,
       `d`.`result_date`                 AS `Result Date`,
       `d`.`result`                      AS `Result`,
       concat('test_id=', `d`.`test_id`) AS `pkey`,
       'diagnosis'                       AS `screenName`
from `main_projectv1`.`diagnostic` `d`;

create definer = root@localhost view person_det_view as
select `p`.`person_id`         AS `person_id`,
       `p`.`first_name`        AS `first_name`,
       `p`.`last_name`         AS `last_name`,
       `p`.`DOB`               AS `dob`,
       `p`.`medicare_number`   AS `medicare_number`,
       `p`.`is_health_worker`  AS `is_health_worker`,
       `p`.`related_person_no` AS `related_person_no`,
       `a`.`email_address`     AS `email_address`,
       `a`.`phone_number`      AS `phone_number`,
       `a`.`street_address`    AS `street_address`,
       `a`.`province`          AS `province`
from `main_projectv1`.`person` `p`
         join `main_projectv1`.`address` `a`
where (`a`.`person_id` = `p`.`person_id`);

create definer = root@localhost view persons_view as
select `p`.`person_id`                       AS `person_id`,
       `p`.`first_name`                      AS `First Name`,
       `p`.`last_name`                       AS `Last Name`,
       `p`.`DOB`                             AS `dob`,
       `p`.`medicare_number`                 AS `Mecidare No`,
       `p`.`is_health_worker`                AS `Health Worker`,
       `p`.`related_person_no`               AS `related_person_no`,
       concat('person_id=', `p`.`person_id`) AS `pkey`,
       'person'                              AS `screenName`
from `main_projectv1`.`person` `p`;

create definer = root@localhost view publichealthcentres_det_view as
select `phc`.`facility_id`          AS `facility_id`,
       `phc`.`facility_name`        AS `facility_name`,
       `phc`.`address`              AS `address`,
       `phc`.`web_address`          AS `web_address`,
       `phc`.`phone_number`         AS `phone_number`,
       `phc`.`type`                 AS `type`,
       `phc`.`operating_zone`       AS `operating_zone`,
       `phc`.`method_of_acceptance` AS `method_of_acceptance`,
       `phc`.`has_drive_through`    AS `has_drive_through`
from `main_projectv1`.`publichealthcenter` `phc`;

create definer = root@localhost view publichealthcentres_view as
select `phc`.`facility_id`                         AS `Facility Id`,
       `phc`.`facility_name`                       AS `Facility Name`,
       `phc`.`address`                             AS `Address`,
       `phc`.`web_address`                         AS `Web Site`,
       `phc`.`phone_number`                        AS `Contact`,
       `phc`.`type`                                AS `Type`,
       `phc`.`operating_zone`                      AS `Operating Zone`,
       `phc`.`method_of_acceptance`                AS `Acceptance Method`,
       `phc`.`has_drive_through`                   AS `Drive Through?`,
       concat('facility_id=', `phc`.`facility_id`) AS `pkey`,
       'healthcenter'                              AS `screenName`
from `main_projectv1`.`publichealthcenter` `phc`;

create definer = root@localhost view region_det_view as
select `r`.`region_id`            AS `region_id`,
       `r`.`region_name`          AS `region_name`,
       `r`.`current_active_alert` AS `current_active_alert`,
       'Region'                   AS `screenname`
from `main_projectv1`.`region` `r`;

create definer = root@localhost view region_view as
select `r`.`region_id`                       AS `Region Id`,
       `r`.`region_name`                     AS `Region Name`,
       `r`.`current_active_alert`            AS `Current Active Alert`,
       concat('region_id=', `r`.`region_id`) AS `pkey`,
       'regions'                             AS `screenName`
from `main_projectv1`.`region` `r`;

