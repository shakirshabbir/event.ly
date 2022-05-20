#DROP VIEW IF EXISTS VU_organizer_info;
#CREATE VIEW VU_organizer_info AS
SELECT 
	 CONCAT(organizer.userLname,', ',organizer.userFname) AS organizerName
	,organizer.userId AS organizerId
	,organizer.userContactNumber AS organizerContact
	,organizer.userEmailAddress AS organizerEmailAddress
	,owner.userLname AS ownerName
	#,CONCAT(owner.userLname,', ',owner.userFname) 
	,owner.userId AS ownerId
FROM users organizer
JOIN users owner
	ON owner.userId = organizer.userParentId