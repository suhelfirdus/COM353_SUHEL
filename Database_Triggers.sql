CREATE OR REPLACE TRIGGER trg_notify_people
AFTER INSERT ON ALERT_SYSTEM
FOR EACH ROW

BEGIN


DECLARE PID INTEGER DEFAULT 0;
DECLARE emailAddress varchar(100) DEFAULT "";
DECLARE messagebody varchar(100) DEFAULT "Hi, you have a new email";
DECLARE finished INTEGER DEFAULT 0;
    DECLARE cursor_allpeople CURSOR FOR (SELECT A.person_id,a.email_address FROM Person P, address A WHERE P.person_id=A.person_id
AND A.REGION_ID=NEW.REGION_ID);

DECLARE CONTINUE HANDLER
        FOR NOT FOUND SET finished = 1;

OPEN cursor_allpeople;
getEmail: LOOP
		FETCH cursor_allpeople INTO PID,emailAddress;
		IF finished = 1 THEN
			LEAVE getEmail;
		END IF;
		-- build email list
		insert into MESSAGES(person_id,email, old_alert_state, new_alert_state, message_body, message_category)
		values(pid,emailAddress,null,NEW.ALERT_TYPE,messagebody,'General');
	END LOOP getEmail;
CLOSE cursor_allpeople;
END;

