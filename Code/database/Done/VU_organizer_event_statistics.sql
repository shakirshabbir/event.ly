#DROP VIEW IF EXISTS VU_organizer_event_statistics;
#CREATE VIEW VU_organizer_event_statistics AS
SELECT 
     organizer.userLname AS organizerLname
    ,organizer.userFname AS organizerFname
	,CONCAT(organizer.userLname, ', ', organizer.userFname) AS organizerName
	,EO.organizerId
    ,organizer.usertypeId AS organizerUserTypeId
    ,userTypes.userType AS organizerUserType
    ,COUNT(EO.eventId) eventCount
FROM event_organizers EO
JOIN users organizer
ON EO.organizerId = organizer.userId
JOIN user_types userTypes
	ON userTypes.usertypeId = organizer.usertypeId
GROUP BY organizer.userId