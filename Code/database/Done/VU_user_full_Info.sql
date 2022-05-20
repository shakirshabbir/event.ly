#DROP VIEW IF EXISTS VU_user_full_info;
#CREATE VIEW VU_user_full_info AS
SELECT 
	 users.userId
	,users.usertypeId
	,users.userEmailAddress
	,users.userPassword
	,users.userFname
	,users.userLname
	,CONCAT(users.userLname,', ', users.userFname) AS userFullName
	,users.userContactNumber
	,users.userParentId
	,usertypes.usertype
	,CONCAT(owner.userLname,', ',owner.userFname) AS ownerName
	,owner.userId AS ownerId
FROM users 
LEFT JOIN users owner 
	ON owner.userId = users.userParentId 
JOIN user_types usertypes 
	ON usertypes.usertypeId = users.usertypeId
ORDER BY usertypes.usertype ASC