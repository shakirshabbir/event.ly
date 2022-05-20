#DROP VIEW IF EXISTS VU_attendee_checkins;
#CREATE VIEW VU_attendee_checkins AS
SELECT
	 i.eventId
	,e.eventTitle
	,eOwns.ownerId
	,eOrgs.organizerId	
	,i.attendeeId
	,i.attendeeRefCode
    ,i.attendeeName
	,i.attendeeEmailAddress 
    ,code.response AS invitationStatus
	,c.checkInTime AS checkInTime
    ,IFNULL(c.checkInTime, 'NotCheckedIn') AS checkInStatus
FROM
	invitations i
LEFT JOIN checkins c
	ON c.attendeeId = i.attendeeId
JOIN response_codes code
	ON code.responseCode = i.attendeeResponse
JOIN events e
	ON e.eventId = i.eventId
JOIN event_owners eOwns
	ON eOwns.eventId = e.eventId
JOIN users owners
	ON owners.userId = eOwns.ownerId
LEFT JOIN event_organizers eOrgs
	ON eOrgs.eventId = e.eventId
LEFT JOIN users organizer 
	ON organizer.userId = eORGs.organizerId