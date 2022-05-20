SELECT
	 e.eventId
	,eventTitle
	,eOWNs.ownerId
	,eORGs.organizerId
FROM events e
JOIN event_owners eOWNs 
	ON e.eventId = eOWNs.eventId
LEFT JOIN event_organizers eORGs
	ON e.eventId = eORGs.eventId
ORDER BY eventId