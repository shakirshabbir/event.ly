#DROP VIEW IF EXISTS VU_event_info;
#CREATE VIEW VU_event_info AS
SELECT
	e.eventId
	,eventTitle
	,DATE_FORMAT(eventStartTime, '%m/%d/%Y') as eventDate
	,DATE_FORMAT(eventStartTime, '%h:%i %p') as eventStartTime
	,DATE_FORMAT(eventEndTime,   '%h:%i %p') as eventEndTime
	,eventLocation
	,eventDetails
	,CONCAT(owner.userLname, ', ', owner.userFname) AS ownerName, eOWNs.ownerId
	,owner.userContactNumber AS ownerContactNumber
	,owner.usertypeId AS ownerUserTypeId
	,ownerUsertype.usertype AS ownerUserType
	,IFNULL(CONCAT(organizer.userLname, ', ', organizer.userFname),'Unassigned') AS organizerName, organizer.userId AS organizerId 
	,organizer.userContactNumber AS organizerContactNumber
FROM events e
JOIN event_owners eOWNs 
	ON e.eventId = eOWNs.eventId
LEFT JOIN event_organizers eORGs
	ON e.eventId = eORGs.eventId
JOIN users owner
	ON owner.userId = eOWNs.ownerId
JOIN user_types ownerUsertype
	ON ownerUsertype.usertypeId = owner.usertypeId
LEFT JOIN users organizer 
	ON organizer.userId = eORGs.organizerId