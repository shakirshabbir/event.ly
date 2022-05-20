SELECT
	 CONCAT(client.userLname, ', ', client.userFname) AS clientName
	,client.userId AS clientId
	,client.userContactNumber as clientContact
	,eventsSelf.eventId AS selfEventId
	,eventsSelf.eventTitle AS selfEventTitle	
    ,CONCAT(organizer.userLname, ', ', organizer.userFname) AS organizerName
	,organizer.userId AS organizerId 
	,organizer.userContactNumber as organizerContact
	,e.eventId AS organizerEventId
	,e.eventTitle AS organizerEventTitle
FROM users client
LEFT JOIN users organizer
	ON organizer.userParentId = client.userId
LEFT JOIN event_organizers eORGs
	ON eORGs.organizerId = organizer.userId
LEFT JOIN events e
	ON e.eventId = eORGs.eventId
LEFT JOIN event_organizers eORGsOwn
	ON eORGsOwn.organizerId = client.userId
LEFT JOIN events eventsSelf
	ON eventsSelf.eventId = eORGsOwn.eventId	
WHERE client.userParentId = 0
#So dont repeat organizers that are associated with the client