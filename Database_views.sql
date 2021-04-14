create view active_alerts_view as
select `alert_system`.`alert_id`            AS `alert_id`,
       `alert_system`.`alert_date_time`     AS `alert_date_time`,
       `alert_system`.`alert_level_id`      AS `alert_level_id`,
       `alert_category`.`alert_description` AS `alert_desc`,
       `alert_system`.`is_active`           AS `is_active`,
       `alert_system`.`region_id`           AS `region_id`,
       `alert_system`.`notify_people`       AS `notify_people`
from (`alert_system`
    join `alert_category`)
where ((`alert_system`.`alert_level_id` = `alert_category`.`alert_level_id`) and
       (`alert_system`.`is_active` = 'Y'));

create view alerts_view as
select `r`.`region_id`                                                                         AS `region_id`,
       `a`.`alert_id`                                                               AS `alert_id`,
       `r`.`region_name`                                                                       AS `region_name`,
       `a`.`alert_desc`                                                             AS `alert_desc`,
       `a`.`alert_date_time`                                                        AS `alert_date_time`,
       (select count(0)
        from (`person` `p`
                 join `address` `ad`)
        where ((`p`.`person_id` = `ad`.`person_id`) and (`ad`.`region_id` = `r`.`region_id`))) AS `population`,
       concat('region_name=', `r`.`region_name`)                                               AS `pkey`,
       'alert'                                                                                 AS `screenname`
from (`region` `r`
         left join `active_alerts_view` `a` on ((`r`.`region_id` = `a`.`region_id`)));

create view cities_det_view as
select `c`.`city_id`                                               AS `city_id`,
       `c`.`region_id`                                             AS `region_id`,
       (select `region`.`region_name`
        from `region`
        where (`region`.`region_id` = `c`.`region_id`)) AS `region_name`,
       `c`.`city_name`                                             AS `city_name`,
       `c`.`province`                                              AS `province`,
       concat('city_id=', `c`.`city_id`)                           AS `pkey`,
       'cities'                                                    AS `screenname`
from `city` `c`;

create view diagnostic_det_view as
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
       (select `city`.`city_name`
        from `city`
        where (`city`.`city_id` = `a`.`city_id`))       AS `city_name`,
       `a`.`region_id`                                             AS `region_id`,
       (select `region`.`region_name`
        from `region`
        where (`region`.`region_id` = `a`.`region_id`)) AS `region_name`,
       `ph`.`facility_id`                                          AS `facility_id`,
       `ph`.`facility_name`                                        AS `facility_name`,
       `ph`.`address`                                              AS `address`,
       `ph`.`web_address`                                          AS `web_address`,
       `ph`.`phone_number`                                         AS `ph_phone_number`,
       `ph`.`type`                                                 AS `type`,
       `ph`.`operating_zone`                                       AS `operating_zone`,
       `ph`.`method_of_acceptance`                                 AS `method_of_acceptance`,
       `ph`.`has_drive_through`                                    AS `has_drive_through`,
       concat('test_id=', `d`.`test_id`)                           AS `pkey`,
       'covidtest'                                                 AS `screenname`
from (((`person` `p` join `diagnostic` `d`) join `publichealthcenter` `ph`)
         join `address` `a`)
where ((`p`.`person_id` = `d`.`person_id`) and (`d`.`performed_at` = `ph`.`facility_id`) and
       (`p`.`person_id` = `a`.`person_id`));

create view diagnostic_view as
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
from (`diagnostic` `d`
         join `person` `p`)
where (`p`.`person_id` = `d`.`person_id`);

create view healthworker_basicinfo_view as
select `p`.`person_id`       AS `person_id`,
       `p`.`first_name`      AS `first_name`,
       `p`.`last_name`       AS `last_name`,
       `phc`.`facility_id`   AS `facility_id`,
       `phc`.`facility_name` AS `facility_name`
from (`person` `p`
         join `publichealthcenter` `phc` on ((`p`.`health_facility_id` = `phc`.`facility_id`)))
where (`p`.`is_health_worker` = 'yes');

create view healthworker_det_schedule_view as
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
from (`work_schedule` `wsh`
         join `publichealthcenter` `phc` on ((`wsh`.`facility_id` = `phc`.`facility_id`)));

create view healthworker_rec_view as
select `p`.`person_id`                       AS `person_id`,
       `p`.`first_name`                      AS `first_name`,
       `p`.`last_name`                       AS `last_name`,
       `p`.`is_health_worker`                AS `is_health_worker`,
       concat('person_id=', `p`.`person_id`) AS `pkey1`,
       'healthworker'                        AS `screenName`,
       `phc`.`facility_name`                 AS `facility_name`
from (`person` `p`
         join `publichealthcenter` `phc` on ((`p`.`health_facility_id` = `phc`.`facility_id`)))
where (`p`.`is_health_worker` = 'Yes');

create view healthworker_schedule_view as
select `wsh`.`person_id`                           AS `person_id`,
       `wsh`.`schedule_date`                       AS `schedule_date`,
       `wsh`.`schedule_start`                      AS `schedule_start`,
       `wsh`.`schedule_end`                        AS `schedule_end`,
       `phc`.`facility_id`                         AS `facility_id`,
       'healthworker_schedule_view'                AS `screenName`,
       concat('person_id=', `wsh`.`person_id`)     AS `pkey1`,
       concat('facility_id=', `wsh`.`facility_id`) AS `pkey2`
from (`work_schedule` `wsh`
         join `publichealthcenter` `phc` on ((`wsh`.`facility_id` = `phc`.`facility_id`)));

create view next_available_alert as
select `region`.`region_name`               AS `region_name`,
       `alert_category`.`alert_level_id`    AS `alert_level_id`,
       `alert_category`.`alert_description` AS `alert_description`
from ((`active_alerts_view` join `region`)
         join `alert_category`)
where (((`alert_category`.`alert_level_id` = (`active_alerts_view`.`alert_level_id` + 1)) or
        (`alert_category`.`alert_level_id` = (`active_alerts_view`.`alert_level_id` - 1))) and
       (`region`.`region_id` = `active_alerts_view`.`region_id`))
union
select `region`.`region_name`               AS `region_name`,
       `alert_category`.`alert_level_id`    AS `alert_level_id`,
       `alert_category`.`alert_description` AS `alert_description`
from (`region`
    join `alert_category`)
where `region`.`region_id` in
      (select `active_alerts_view`.`region_id` from `active_alerts_view`) is false;

create view person_det_view as
select `p`.`person_id`                                             AS `person_id`,
       `p`.`first_name`                                            AS `first_name`,
       `p`.`last_name`                                             AS `last_name`,
       `p`.`dob`                                                   AS `date_of_birth`,
       `p`.`medicare_number`                                       AS `medicare_number`,
       `p`.`is_health_worker`                                      AS `is_health_worker`,
       `p`.`health_facility_id`                                    AS `health_facility_id`,
       `p`.`related_person_no`                                     AS `related_person_no`,
       `p`.`gender`                                                AS `gender`,
       `p`.`citizenship`                                           AS `citizenship`,
       `p`.`fathers_name`                                          AS `fathers_name`,
       `p`.`mothers_name`                                          AS `mothers_name`,
       `a`.`email_address`                                         AS `email_address`,
       `a`.`phone_number`                                          AS `phone_number`,
       `a`.`street_address`                                        AS `street_address`,
       `a`.`region_id`                                             AS `region_id`,
       (select `region`.`region_name`
        from `region`
        where (`region`.`region_id` = `a`.`region_id`)) AS `region_name`,
       `a`.`city_id`                                               AS `city_id`,
       (select concat(`city`.`city_name`, '-', `city`.`province`)
        from `city`
        where (`city`.`city_id` = `a`.`city_id`))       AS `city_name`,
       `a`.`postal_code`                                           AS `postal_code`,
       concat('person_id=', `p`.`person_id`)                       AS `pkey`,
       'person'                                                    AS `screenname`
from (`person` `p`
         join `address` `a`)
where (`a`.`person_id` = `p`.`person_id`);

create view persons_view as
select `p`.`person_id`                       AS `person_id`,
       `p`.`first_name`                      AS `first_name`,
       `p`.`last_name`                       AS `last_name`,
       `p`.`dob`                             AS `dob`,
       `p`.`medicare_number`                 AS `medicare_number`,
       `p`.`is_health_worker`                AS `is_health_worke`,
       `p`.`related_person_no`               AS `related_person_no`,
       concat('person_id=', `p`.`person_id`) AS `pkey`,
       'person'                              AS `screenname`
from `person` `p`;

create view publichealthcentres_det_view as
select `phc`.`facility_id`          AS `facility_id`,
       `phc`.`facility_name`        AS `facility_name`,
       `phc`.`address`              AS `address`,
       `phc`.`web_address`          AS `web_address`,
       `phc`.`phone_number`         AS `phone_number`,
       `phc`.`type`                 AS `type`,
       `phc`.`operating_zone`       AS `operating_zone`,
       `phc`.`method_of_acceptance` AS `method_of_acceptance`,
       `phc`.`has_drive_through`    AS `has_drive_through`
from `publichealthcenter` `phc`;

create view publichealthcentres_view as
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
from `publichealthcenter` `phc`;

create view recommendations_det_view as
select `r`.`rec_id`                    AS `rec_id`,
       `r`.`rec_name`                  AS `rec_name`,
       `r`.`rec_date`                  AS `rec_date`,
       concat('rec_id=', `r`.`rec_id`) AS `pkey`,
       'recommendations'               AS `screenname`
from `recommendations` `r`
where (`r`.`rec_name` <> '');

create view region_det_view as
select `r`.`region_id`                       AS `region_id`,
       `r`.`region_name`                     AS `region_name`,
       'regions'                             AS `screenname`,
       concat('region_id=', `r`.`region_id`) AS `pkey`
from `region` `r`;

create view region_view as
select `r`.`region_id`                       AS `region id`,
       `r`.`region_name`                     AS `region name`,
       concat('region_id=', `r`.`region_id`) AS `pkey`,
       'regions'                             AS `screenname`
from `region` `r`;

