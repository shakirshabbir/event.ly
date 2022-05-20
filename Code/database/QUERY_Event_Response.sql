SELECT
    attendeeResponseTbl.eventId,
    attendeeResponseTbl.attendeeResponse,
    attendeeResponseTbl.responseCount
FROM (
    SELECT eventId, attendeeResponse, COUNT(attendeeResponse) responseCount FROM invitations
    GROUP BY eventId, attendeeResponse
    ) as attendeeResponseTbl
GROUP BY
    attendeeResponseTbl.eventId,
    attendeeResponseTbl.attendeeResponse