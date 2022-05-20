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
	
http://careers.stackoverflow.com/jobs/83736/full-stack-php-developer-debt-pay-inc?utm_source=stackoverflow.com&utm_medium=ad&utm_campaign=small-sidebar-tag-themed-php&_scjid=83736	