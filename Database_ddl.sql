create table city
(
	city_id int auto_increment
		primary key,
	city_name varchar(100) null,
	region_id int null,
	province varchar(100) null
);

create table daily_follow_up
(
	person_id int null,
	date_reported date null,
	time_reported timestamp null,
	body_temp int null,
	constraint daily_follow_up_pk
		unique (person_id, date_reported, time_reported)
);

create table diagnostic
(
	test_id int auto_increment,
	person_id int null,
	tested_by int not null,
	performed_at varchar(40) not null,
	test_date date null,
	result_date date null,
	result varchar(10) null,
	primary key (test_id, performed_at, tested_by)
);

create table followup_details
(
	person_id int null,
	date_reported date null,
	time_reported timestamp null,
	symptoms varchar(100) null,
	constraint daily_follow_up_pk
		unique (person_id, date_reported, time_reported)
);

create table messages
(
	msg_id int auto_increment,
	person_id int null,
	datetime datetime default current_timestamp null,
	email varchar(255) null,
	old_alert_state varchar(55) null,
	new_alert_state varchar(55) null,
	message_body varchar(4000) null,
	message_category varchar(55) null,
	constraint messages_pk
		unique (msg_id, person_id)
);

create table publichealthcenter
(
	facility_id varchar(40) not null
		primary key,
	facility_name varchar(100) null,
	address varchar(100) null,
	web_address varchar(100) null,
	phone_number int null,
	type varchar(100) null,
	operating_zone varchar(100) null,
	method_of_acceptance varchar(100) null,
	has_drive_through varchar(1) null
);

create table person
(
	person_id int auto_increment
		primary key,
	first_name varchar(100) null,
	last_name varchar(100) null,
	dob date null,
	medicare_number varchar(100) null,
	is_health_worker varchar(1) default 'n' null,
	related_person_no int null
);



create table alert_category
(
	alert_level_id int null,
	alert_description varchar(100) null,
	measure varchar(50) null,
	message_text text null,
	constraint alert_category_pk
		unique (alert_level_id)
);

create table alert_system
(
	alert_id int auto_increment,
	alert_date_time datetime default current_timestamp null,
	alert_type varchar(55) null,
	is_active varchar(1) null,
	region_id int null,
	notify_people varchar(1) null,
	alert_level_id int null,
	constraint alert_system_pk
		unique (alert_id, region_id),
	constraint alert_system_alert_category_alert_level_id_fk
		foreign key (alert_level_id) references alert_category (alert_level_id)
);

create trigger trg_notify_people
	after insert
	on alert_system
	for each row
	begin
declare pid integer default 0;
declare emailaddress varchar(100) default '';
declare messagebody varchar(100) default 'hi, you have a new email';
declare finished integer default 0;
    declare cursor_allpeople cursor for (select a.person_id,a.email_address from person p, address a where p.person_id=a.person_id
and a.region_id=new.region_id);

declare continue handler
        for not found set finished = 1;

open cursor_allpeople;
getemail: loop
		fetch cursor_allpeople into pid,emailaddress;
		if finished = 1 then
			leave getemail;
		end if;
		-- build email list
		insert into messages(person_id,email, old_alert_state, new_alert_state, message_body, message_category)
		values(pid,emailaddress,null,new.alert_type,messagebody,'general');
	end loop getemail;
close cursor_allpeople;
end;

create table region
(
	region_id int auto_increment
		primary key,
	region_name varchar(100) null,
	current_active_alert varchar(55) default 'green' null
);

create table address
(
	address_id int auto_increment
		primary key,
	person_id int null,
	street_address varchar(100) null,
	email_address varchar(100) null,
	postal_code varchar(10) null,
	phone_number varchar(255) null,
	city_id int null,
	region_id int null,
	constraint address_city_city_id_fk
		foreign key (city_id) references city (city_id),
	constraint address_person_person_id_fk
		foreign key (person_id) references person (person_id),
	constraint address_region_region_id_fk
		foreign key (region_id) references region (region_id)
);

create table users
(
	username varchar(40) null,
	email varchar(100) null,
	user_type varchar(10) null,
	password varchar(100) null
);

create or replace view active_alerts_view as
	select `alert_system`.`alert_id`            as `alert_id`,
       `alert_system`.`alert_date_time`     as `alert_date_time`,
       `alert_system`.`alert_level_id`      as `alert_level_id`,
       `alert_category`.`alert_description` as `alert_desc`,
       `alert_system`.`is_active`           as `is_active`,
       `alert_system`.`region_id`           as `region_id`,
       `alert_system`.`notify_people`       as `notify_people`
from `alert_system`
         join `alert_category`
where ((`alert_system`.`alert_level_id` = `alert_category`.`alert_level_id`) and
       (`alert_system`.`is_active` = 'y'));

create or replace view alerts_view as
	select `r`.`region_id`                                                                         as `region_id`,
       `a`.`alert_id`                                                                          as `alert_id`,
       `r`.`region_name`                                                                       as `region_name`,
       `a`.`alert_desc`                                                                        as `alert_desc`,
       `a`.`alert_date_time`                                                                   as `alert_date_time`,
       (select count(0)
        from (`person` `p`
                 join `address` `ad`)
        where ((`p`.`person_id` = `ad`.`person_id`) and (`ad`.`region_id` = `r`.`region_id`))) as `population`,
       concat('region_name=', `r`.`region_name`)                                               as `pkey`,
       'alert'                                                                                 as `screenname`
from (`region` `r`
         left join `active_alerts_view` `a` on ((`r`.`region_id` = `a`.`region_id`)));

create or replace view cities_view as
	select `c`.`city_id`                                                     as `city_id`,
       `c`.`region_id`                                                   as `region_id`,
       (select `region`.`region_name`
        from `region`
        where (`region`.`region_id` = `c`.`region_id`)) as `region_name`,
       `c`.`city_name`                                                   as `city_name`,
       `c`.`province`                                                    as `province`,
       concat('city_id=', `c`.`city_id`)                                 as `pkey`,
       'cities'                                                          as `screenname`
from `city` `c`;

create or replace view diagnostic_det_view as
	select `p`.`person_id`                                                   as `person_id`,
       `p`.`first_name`                                                  as `first_name`,
       `p`.`last_name`                                                   as `last_name`,
       `p`.`dob`                                                         as `dob`,
       `p`.`medicare_number`                                             as `medicare_number`,
       `p`.`is_health_worker`                                            as `is_health_worker`,
       `p`.`related_person_no`                                           as `related_person_no`,
       `d`.`test_id`                                                     as `test_id`,
       `d`.`tested_by`                                                   as `tested_by`,
       `d`.`performed_at`                                                as `performed_at`,
       `d`.`test_date`                                                   as `test_date`,
       `d`.`result_date`                                                 as `result_date`,
       `d`.`result`                                                      as `result`,
       `a`.`address_id`                                                  as `address_id`,
       `a`.`street_address`                                              as `street_address`,
       `a`.`email_address`                                               as `email_address`,
       `a`.`postal_code`                                                 as `postal_code`,
       `a`.`phone_number`                                                as `person_phone_number`,
       `a`.`city_id`                                                     as `city_id`,
       (select `city`.`city_name`
        from `city`
        where (`city`.`city_id` = `a`.`city_id`))       as `city_name`,
       `a`.`region_id`                                                   as `region_id`,
       (select `region`.`region_name`
        from `region`
        where (`region`.`region_id` = `a`.`region_id`)) as `region_name`,
       `ph`.`facility_id`                                                as `facility_id`,
       `ph`.`facility_name`                                              as `facility_name`,
       `ph`.`address`                                                    as `address`,
       `ph`.`web_address`                                                as `web_address`,
       `ph`.`phone_number`                                               as `ph_phone_number`,
       `ph`.`type`                                                       as `type`,
       `ph`.`operating_zone`                                             as `operating_zone`,
       `ph`.`method_of_acceptance`                                       as `method_of_acceptance`,
       `ph`.`has_drive_through`                                          as `has_drive_through`
from `person` `p`
         join `diagnostic` `d`
         join `publichealthcenter` `ph`
         join `address` `a`
where ((`p`.`person_id` = `d`.`person_id`) and (`d`.`performed_at` = `ph`.`facility_id`) and
       (`p`.`person_id` = `a`.`person_id`));

create or replace view diagnostic_view as
	select `d`.`test_id`                     as `test_id`,
       `d`.`person_id`                   as `person_id`,
       `p`.`first_name`                  as `person_name`,
       `p`.`last_name`                   as `last_name`,
       `d`.`tested_by`                   as `tested_by`,
       `d`.`performed_at`                as `tested at`,
       `d`.`test_date`                   as `test date`,
       `d`.`result_date`                 as `result date`,
       `d`.`result`                      as `result`,
       concat('test_id=', `d`.`test_id`) as `pkey`,
       'covidtest'                       as `screenname`
from `diagnostic` `d`
         join `person` `p`
where (`p`.`person_id` = `d`.`person_id`);

create or replace view next_available_alert as
	select `region`.`region_name`               as `region_name`,
       `alert_category`.`alert_level_id`    as `alert_level_id`,
       `alert_category`.`alert_description` as `alert_description`
from `active_alerts_view`
         join `region`
         join `alert_category`
where (((`alert_category`.`alert_level_id` = (`active_alerts_view`.`alert_level_id` + 1)) or
        (`alert_category`.`alert_level_id` = (`active_alerts_view`.`alert_level_id` - 1))) and
       (`region`.`region_id` = `active_alerts_view`.`region_id`))
union
select `region`.`region_name`               as `region_name`,
       `alert_category`.`alert_level_id`    as `alert_level_id`,
       `alert_category`.`alert_description` as `alert_description`
from `region`
         join `alert_category`
where (not (`region`.`region_id` in
            (select `active_alerts_view`.`region_id` from `active_alerts_view`)));

create or replace view person_det_view as
	select `p`.`person_id`                                                   as `person_id`,
       `p`.`first_name`                                                  as `first_name`,
       `p`.`last_name`                                                   as `last_name`,
       `p`.`dob`                                                         as `dob`,
       `p`.`medicare_number`                                             as `medicare_number`,
       `p`.`is_health_worker`                                            as `is_health_worker`,
       `p`.`related_person_no`                                           as `related_person_no`,
       `a`.`email_address`                                               as `email_address`,
       `a`.`phone_number`                                                as `phone_number`,
       `a`.`street_address`                                              as `street_address`,
       `a`.`region_id`                                                   as `region_id`,
       (select `region`.`region_name`
        from `region`
        where (`region`.`region_id` = `a`.`region_id`)) as `region_name`,
       `a`.`city_id`                                                     as `city_id`,
       (select `city`.`city_name`
        from `city`
        where (`city`.`city_id` = `a`.`city_id`))       as `city_name`,
       `a`.`postal_code`                                                 as `postal_code`
from (`person` `p`
         join `address` `a`)
where (`a`.`person_id` = `p`.`person_id`);

create or replace view persons_view as
	select `p`.`person_id`                       as `person_id`,
       `p`.`first_name`                      as `first name`,
       `p`.`last_name`                       as `last name`,
       `p`.`dob`                             as `dob`,
       `p`.`medicare_number`                 as `mecidare no`,
       `p`.`is_health_worker`                as `health worker`,
       `p`.`related_person_no`               as `related_person_no`,
       concat('person_id=', `p`.`person_id`) as `pkey`,
       'person'                              as `screenname`
from `person` `p`;

create or replace view publichealthcentres_det_view as
	select `phc`.`facility_id`          as `facility_id`,
       `phc`.`facility_name`        as `facility_name`,
       `phc`.`address`              as `address`,
       `phc`.`web_address`          as `web_address`,
       `phc`.`phone_number`         as `phone_number`,
       `phc`.`type`                 as `type`,
       `phc`.`operating_zone`       as `operating_zone`,
       `phc`.`method_of_acceptance` as `method_of_acceptance`,
       `phc`.`has_drive_through`    as `has_drive_through`
from `publichealthcenter` `phc`;

create or replace view publichealthcentres_view as
	select `phc`.`facility_id`                         as `facility id`,
       `phc`.`facility_name`                       as `facility name`,
       `phc`.`address`                             as `address`,
       `phc`.`web_address`                         as `web site`,
       `phc`.`phone_number`                        as `contact`,
       `phc`.`type`                                as `type`,
       `phc`.`operating_zone`                      as `operating zone`,
       `phc`.`method_of_acceptance`                as `acceptance method`,
       `phc`.`has_drive_through`                   as `drive through?`,
       concat('facility_id=', `phc`.`facility_id`) as `pkey`,
       'healthcenter'                              as `screenname`
from `publichealthcenter` `phc`;

create or replace view region_det_view as
	select `r`.`region_id`            as `region_id`,
       `r`.`region_name`          as `region_name`,
       `r`.`current_active_alert` as `current_active_alert`,
       'region'                   as `screenname`
from `region` `r`;

create or replace view region_view as
	select `r`.`region_id`                       as `region id`,
       `r`.`region_name`                     as `region name`,
       `r`.`current_active_alert`            as `current active alert`,
       concat('region_id=', `r`.`region_id`) as `pkey`,
       'regions'                             as `screenname`
from `region` `r`;

