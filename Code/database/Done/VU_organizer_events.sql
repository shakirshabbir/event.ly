#DROP VIEW IF EXISTS VU_organizer_events;
#CREATE VIEW VU_organizer_events AS 
SELECT 
	 CONCAT(organizer.userLname, ', ', organizer.userFname) AS organizerName
	,organizer.userId AS organizerId
	,organizer.userContactNumber AS organizerContact
	,e.eventId AS organizerEventId
	,e.eventTitle AS organizerEventTitle
	,CONCAT(client.userLname, ', ', client.userFname) AS clientName
	,client.userId AS clientId 
FROM event_organizers eORGs
JOIN users organizer 
	ON eORGs.organizerId = organizer.userId 
JOIN events e 
	ON e.eventId = eORGs.eventId 
LEFT JOIN users client 
	ON client.userId = organizer.userParentId