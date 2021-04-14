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

create table cityzipcodes
(
    city_id     int         null,
    postal_code varchar(20) null
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
    health_facility_id varchar(100)            null,
    citizenship        varchar(100)            null,
    fathers_name       varchar(100)            null,
    mothers_name       varchar(100)            null,
    gender             varchar(10)             null
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

