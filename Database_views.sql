CREATE OR REPLACE VIEW active_alerts_view  as select * from alert_system where IS_ACTIVE='Y';
CREATE OR REPLACE VIEW alerts_view AS
SELECT r.REGION_ID,A.ALERT_ID,r.region_name,A.ALERT_TYPE,A.ALERT_DATE_TIME,
 concat('region_name=', r.region_name) AS 'pkey','alert' AS 'screenName'
FROM region r
LEFT JOIN active_alerts_view a
ON r.REGION_ID = a.REGION_ID;
