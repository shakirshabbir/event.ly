#DROP VIEW IF EXISTS VU_client_event_statistics;
#CREATE VIEW VU_client_event_statistics AS
SELECT 
     owner.userLname AS ownerLname
    ,owner.userFname AS ownerFname
	,CONCAT(owner.userLname, ', ', owner.userFname) AS ownerName
	,EO.ownerId
    ,owner.usertypeId AS ownerUserTypeId
    ,userTypes.userType AS ownerUserType
    ,COUNT(EO.eventId) eventCount
FROM event_owners EO
JOIN users owner
ON EO.ownerId = owner.userId
JOIN user_types userTypes
	ON userTypes.usertypeId = owner.usertypeId
GROUP BY owner.userId