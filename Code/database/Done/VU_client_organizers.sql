#DROP VIEW IF EXISTS VU_client_organizers;
#CREATE VIEW VU_client_organizers AS
SELECT 
	 CONCAT(organizer.userLname,', ',organizer.userFname) AS organizerName
	,organizer.userId AS organizerId
	,organizer.userContactNumber AS organizerContact
	,IFNULL(e.eventId,0) AS eventId
	,IFNULL(e.eventTitle,'No event assigned!') AS eventTitle
	,client.userId AS clientId
	,CONCAT(client.userLname,', ',client.userFname) AS clientName
FROM 
	users client 
LEFT JOIN users organizer
	ON organizer.userParentId = client.userId
LEFT JOIN event_organizers eORGs
	ON eORGs.organizerId = organizer.userId
LEFT JOIN events e
	ON e.eventId = eORGs.eventId
WHERE 
	client.userParentId = 0