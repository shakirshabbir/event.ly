INSERT INTO event_monitoring(eventId, attendeeId, checkInTime, checkOutTime)
 VALUES 
  (1, 'ATT01', NOW(), NULL)
 ,(1, 'ATT02', NOW() + INTERVAL 2 MINUTE, NULL)
 ,(1, 'ATT03', NOW() + INTERVAL 3 MINUTE, NULL)
 ,(1, 'ATT04', NOW() + INTERVAL 5 MINUTE, NULL)
 ,(1, 'ATT05', NOW() + INTERVAL 6 MINUTE, NULL) 
 ,(1, 'ATT06', NOW() + INTERVAL 9 MINUTE, NULL)
 ,(1, 'ATT07', NOW() + INTERVAL 10 MINUTE, NULL)
 ,(1, 'ATT08', NOW() + INTERVAL 12 MINUTE, NULL)
 ,(1, 'ATT09', NOW() + INTERVAL 17 MINUTE, NULL)
 ,(1, 'ATT10', NOW() + INTERVAL 18 MINUTE, NULL)
 ,(1, 'ATT11', NOW() + INTERVAL 24 MINUTE, NULL)
 ,(1, 'ATT12', NOW() + INTERVAL 30 MINUTE, NULL)
 ,(1, 'ATT13', NOW() + INTERVAL 31 MINUTE, NULL)
 ,(1, 'ATT14', NOW() + INTERVAL 31 MINUTE, NULL)
 ,(1, 'ATT15', NOW() + INTERVAL 31 MINUTE, NULL)
 ,(1, 'ATT16', NOW() + INTERVAL 34 MINUTE, NULL)
 ,(1, 'ATT17', NOW() + INTERVAL 35 MINUTE, NULL)
 ,(1, 'ATT18', NOW() + INTERVAL 35 MINUTE, NULL)
 ,(1, 'ATT19', NOW() + INTERVAL 37 MINUTE, NULL)
 ,(1, 'ATT20', NOW() + INTERVAL 37 MINUTE, NULL)
 ,(1, 'ATT21', NOW() + INTERVAL 37 MINUTE, NULL) 
 ,(1, 'ATT22', NOW() + INTERVAL 40 MINUTE, NULL)
 ,(1, 'ATT23', NOW() + INTERVAL 41 MINUTE, NULL)
 ,(1, 'ATT24', NOW() + INTERVAL 42 MINUTE, NULL)
 ,(1, 'ATT25', NOW() + INTERVAL 43 MINUTE, NULL)
 ,(1, 'ATT26', NOW() + INTERVAL 44 MINUTE, NULL); 
 
--
-- Table structure for table `event_monitoring`
--

DROP TABLE IF EXISTS `event_monitoring`;
CREATE TABLE IF NOT EXISTS `event_monitoring` (
  `eventId` int(11) NOT NULL,
  `attendeeId` varchar(13) NOT NULL,
  `checkInTime` timestamp NOT NULL,
  `checkOutTime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`eventId`,`attendeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_monitoring`
--
ALTER TABLE `event_monitoring`
  ADD CONSTRAINT `event_monitoring_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE NO ACTION ON UPDATE NO ACTION;