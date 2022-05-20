DROP VIEW IF EXISTS VU_attendee_event;
CREATE VIEW VU_attendee_event AS
SELECT
	 e.eventId
    ,i.attendeeId
FROM
	invitations i
JOIN events e
	ON e.eventId = i.eventId