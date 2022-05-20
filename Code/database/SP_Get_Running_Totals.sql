SP LIKHNA HAI

SET @runtot:=0;
SELECT
   DATE_FORMAT(q1.cTime, '%h:%i') as cTime
   ,q1.c
   ,(@runtot := @runtot + q1.c) AS rt
FROM
   (SELECT
       checkInTime AS cTime,
       COUNT(*) AS c
    FROM  event_monitoring
    WHERE  eventId=1
	GROUP BY checkInTime
    ORDER  BY checkInTime ASC) AS q1