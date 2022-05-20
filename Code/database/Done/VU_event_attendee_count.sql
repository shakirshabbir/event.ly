#DROP VIEW IF EXISTS VU_event_attendee_count;
#CREATE VIEW VU_event_attendee_count AS
SELECT
	 event.eventId
	,event.eventTitle
	,DATE_FORMAT(eventStartTime, '%m/%d/%Y') AS eventDate	
#	,CONCAT(owner.userLname, ', ', owner.userFname) AS ownerName
#	,eOwn.ownerId AS ownerId
	,COUNT(*) AS attendeeCount
FROM
	checkins
JOIN events event
	ON event.eventId = checkins.eventId
#JOIN 

#JOIN event_owners eOwn
#	ON eOwn.eventId = event.eventId
#JOIN users owner
#	ON owner.userId = eOwn.ownerId

GROUP BY checkins.eventId