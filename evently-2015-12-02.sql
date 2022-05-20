-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2015 at 10:50 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `evently`
--


-- --------------------------------------------------------

--
-- Table structure for table `checkins`
--

DROP TABLE IF EXISTS `checkins`;
CREATE TABLE IF NOT EXISTS `checkins` (
  `eventId` int(11) NOT NULL,
  `attendeeId` int(11) NOT NULL,
  `checkInTime` timestamp NOT NULL,
  `checkOutTime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`eventId`,`attendeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `eventId` int(11) NOT NULL AUTO_INCREMENT,
  `eventTitle` varchar(255) NOT NULL,
  `eventStartTime` timestamp NOT NULL,
  `eventEndTime` timestamp NOT NULL,
  `eventLocation` varchar(255) NOT NULL,
  `eventDetails` text,
  PRIMARY KEY (`eventId`),
  UNIQUE KEY `eventTitle` (`eventTitle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventId`, `eventTitle`, `eventStartTime`, `eventEndTime`, `eventLocation`, `eventDetails`) VALUES
(35, 'Company 1 Event 2', '2015-11-13 07:00:00', '2015-11-13 10:00:00', 'Kakri Cricket Ground, Karachi, Pakistan', ''),
(47, 'Birthday Celebrations for Mass', '2015-11-14 07:00:00', '2015-11-15 01:00:00', '5500 N. St. Louis Ave, Chicago, IL 60625', ''),
(59, 'Company 2 Event 1', '2015-12-16 07:00:00', '2015-12-16 07:30:00', 'Room#303, LWH Bld, Northeastern', ''),
(60, 'Company 2 Event 2', '2015-12-29 07:00:00', '2015-12-29 07:30:00', 'Room#303, LWH Bld, Northeastern', ''),
(61, 'Buru Buro', '2015-12-04 19:30:00', '2015-12-04 21:00:00', '8898 Kingery Hwy, Willowbrook, IL 60527', ''),
(62, 'Pyara Event2', '2015-12-02 05:00:00', '2015-12-01 06:30:00', '5500 N. St. Louis Ave, Chicago, IL 60625', '');

-- --------------------------------------------------------

--
-- Table structure for table `event_organizers`
--

DROP TABLE IF EXISTS `event_organizers`;
CREATE TABLE IF NOT EXISTS `event_organizers` (
  `eventId` int(11) NOT NULL,
  `organizerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_organizers`
--

INSERT INTO `event_organizers` (`eventId`, `organizerId`) VALUES
(47, 35),
(59, 33),
(61, 39),
(62, 35);

-- --------------------------------------------------------

--
-- Table structure for table `event_owners`
--

DROP TABLE IF EXISTS `event_owners`;
CREATE TABLE IF NOT EXISTS `event_owners` (
  `eventId` int(11) NOT NULL DEFAULT '0',
  `ownerId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eventId`,`ownerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_owners`
--

INSERT INTO `event_owners` (`eventId`, `ownerId`) VALUES
(35, 28),
(47, 28),
(59, 29),
(60, 29),
(61, 39),
(62, 28);

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

DROP TABLE IF EXISTS `invitations`;
CREATE TABLE IF NOT EXISTS `invitations` (
  `eventId` int(11) NOT NULL,
  `hostUserId` int(11) NOT NULL,
  `attendeeId` int(11) NOT NULL AUTO_INCREMENT,
  `attendeeRefCode` varchar(10) NOT NULL,
  `attendeeName` varchar(255) NOT NULL,
  `attendeeEmailAddress` varchar(255) NOT NULL,
  `attendeeResponse` varchar(3) DEFAULT NULL,
  `additionalNote` varchar(255) DEFAULT NULL,
  `invitationSentDate` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `attendeeId` (`attendeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `invitations`
--

INSERT INTO `invitations` (`eventId`, `hostUserId`, `attendeeId`, `attendeeRefCode`, `attendeeName`, `attendeeEmailAddress`, `attendeeResponse`, `additionalNote`, `invitationSentDate`) VALUES
(62, 28, 30, '0G7BCYNNAL', 'Shakir Shabbir', 'shakshabbir@yahoo.com', 'INV', '', '2015-12-02 06:27:41'),
(47, 28, 31, 'PZPY8OINH0', 'Shakir Shabbir', 'shakirshabbir@yahoo.com', 'INV', '', '2015-12-02 06:28:36'),
(60, 5, 32, 'SH2E2ACXXR', 'Shakir Shabbir', 'shakirshabbir@yahoo.com', 'INV', '', '2015-12-02 09:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `response_codes`
--

DROP TABLE IF EXISTS `response_codes`;
CREATE TABLE IF NOT EXISTS `response_codes` (
  `responseCode` varchar(3) NOT NULL,
  `response` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `response_codes`
--

INSERT INTO `response_codes` (`responseCode`, `response`) VALUES
('YES', 'Yes'),
('NO', 'No'),
('MAY', 'Maybe'),
('INV', 'Invited');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `usertypeId` int(11) NOT NULL,
  `userEmailAddress` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userFname` varchar(255) DEFAULT NULL,
  `userLname` varchar(255) DEFAULT NULL,
  `userContactNumber` varchar(255) DEFAULT NULL,
  `userParentId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userEmailAddress` (`userEmailAddress`),
  KEY `usertypeId` (`usertypeId`),
  KEY `usertypeId_2` (`usertypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `usertypeId`, `userEmailAddress`, `userPassword`, `userFname`, `userLname`, `userContactNumber`, `userParentId`) VALUES
(5, 1, 'admin@event.ly', 'shakshab', 'SITE', 'ADMIN', '+1 630 729 4825', 0),
(28, 2, 'company1@yahoo.com', 's', '', 'Company 1', '+1 630-729-4825', 0),
(29, 2, 'company2@yahoo.com', 's', '', 'Company 2', '+ 616 225 1223', 0),
(33, 3, 'company2org1@yahoo.com', 's', 'Company 2', 'Organizer 1', '+1 773 750 3468', 29),
(35, 3, 'company1org3@yahoo.com', 's', 'Company 1', 'Organizer 3', '+1 225 128 9587', 28),
(36, 2, 'company3@yahoo.com', 's', '', 'Company 3', '+ 92 345 266 2272', 0),
(38, 3, 'company1org2@yahoo.com', 'shakshab', 'Abbas', 'Haider', '+ 92 345 266 2272', 28),
(39, 4, 'ind2@yahoo', 'shakshab', 'User 2', 'Indivisual', '92 345 266 2272', 0),
(40, 4, 'ind3@y.com', 'shakshab', 'User 3', 'Indivisual', '92 345 266 2272', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE IF NOT EXISTS `user_types` (
  `usertypeId` int(11) NOT NULL AUTO_INCREMENT,
  `usertype` varchar(255) NOT NULL,
  PRIMARY KEY (`usertypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`usertypeId`, `usertype`) VALUES
(1, 'Admin'),
(2, 'Company'),
(3, 'Organizer'),
(4, 'Indivisual'),
(5, 'Attendee');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vu_attendee_checkins`
--
DROP VIEW IF EXISTS `vu_attendee_checkins`;
CREATE TABLE IF NOT EXISTS `vu_attendee_checkins` (
`eventId` int(11)
,`eventTitle` varchar(255)
,`ownerId` int(11)
,`organizerId` int(11)
,`attendeeId` int(11)
,`attendeeRefCode` varchar(10)
,`attendeeName` varchar(255)
,`attendeeEmailAddress` varchar(255)
,`invitationStatus` varchar(100)
,`checkInTime` timestamp
,`checkInStatus` varchar(19)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vu_client_event_statistics`
--
DROP VIEW IF EXISTS `vu_client_event_statistics`;
CREATE TABLE IF NOT EXISTS `vu_client_event_statistics` (
`ownerLname` varchar(255)
,`ownerFname` varchar(255)
,`ownerName` varchar(512)
,`ownerId` int(11)
,`ownerUserTypeId` int(11)
,`ownerUserType` varchar(255)
,`eventCount` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vu_client_organizers`
--
DROP VIEW IF EXISTS `vu_client_organizers`;
CREATE TABLE IF NOT EXISTS `vu_client_organizers` (
`organizerName` varchar(512)
,`organizerId` int(11)
,`organizerContact` varchar(255)
,`eventId` bigint(11)
,`eventTitle` varchar(255)
,`clientId` int(11)
,`clientName` varchar(512)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vu_event_attendee_count`
--
DROP VIEW IF EXISTS `vu_event_attendee_count`;
CREATE TABLE IF NOT EXISTS `vu_event_attendee_count` (
`eventId` int(11)
,`eventTitle` varchar(255)
,`eventDate` varchar(10)
,`attendeeCount` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vu_event_info`
--
DROP VIEW IF EXISTS `vu_event_info`;
CREATE TABLE IF NOT EXISTS `vu_event_info` (
`eventId` int(11)
,`eventTitle` varchar(255)
,`eventDate` varchar(10)
,`eventStartTime` varchar(8)
,`eventEndTime` varchar(8)
,`eventLocation` varchar(255)
,`eventDetails` text
,`ownerName` varchar(512)
,`ownerId` int(11)
,`ownerContactNumber` varchar(255)
,`ownerUserTypeId` int(11)
,`ownerUserType` varchar(255)
,`organizerName` varchar(512)
,`organizerId` int(11)
,`organizerContactNumber` varchar(255)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vu_organizer_events`
--
DROP VIEW IF EXISTS `vu_organizer_events`;
CREATE TABLE IF NOT EXISTS `vu_organizer_events` (
`organizerName` varchar(512)
,`organizerId` int(11)
,`organizerContact` varchar(255)
,`organizerEventId` int(11)
,`organizerEventTitle` varchar(255)
,`clientName` varchar(512)
,`clientId` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vu_organizer_event_statistics`
--
DROP VIEW IF EXISTS `vu_organizer_event_statistics`;
CREATE TABLE IF NOT EXISTS `vu_organizer_event_statistics` (
`organizerLname` varchar(255)
,`organizerFname` varchar(255)
,`organizerName` varchar(512)
,`organizerId` int(11)
,`organizerUserTypeId` int(11)
,`organizerUserType` varchar(255)
,`eventCount` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vu_organizer_info`
--
DROP VIEW IF EXISTS `vu_organizer_info`;
CREATE TABLE IF NOT EXISTS `vu_organizer_info` (
`organizerName` varchar(512)
,`organizerId` int(11)
,`organizerContact` varchar(255)
,`organizerEmailAddress` varchar(255)
,`ownerName` varchar(255)
,`ownerId` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vu_user_full_info`
--
DROP VIEW IF EXISTS `vu_user_full_info`;
CREATE TABLE IF NOT EXISTS `vu_user_full_info` (
`userId` int(11)
,`usertypeId` int(11)
,`userEmailAddress` varchar(255)
,`userPassword` varchar(255)
,`userFname` varchar(255)
,`userLname` varchar(255)
,`userFullName` varchar(512)
,`userContactNumber` varchar(255)
,`userParentId` int(11)
,`usertype` varchar(255)
,`ownerName` varchar(512)
,`ownerId` int(11)
);
-- --------------------------------------------------------

--
-- Structure for view `vu_attendee_checkins`
--
DROP TABLE IF EXISTS `vu_attendee_checkins`;

CREATE  VIEW `vu_attendee_checkins` AS select `i`.`eventId` AS `eventId`,`e`.`eventTitle` AS `eventTitle`,`eowns`.`ownerId` AS `ownerId`,`eorgs`.`organizerId` AS `organizerId`,`i`.`attendeeId` AS `attendeeId`,`i`.`attendeeRefCode` AS `attendeeRefCode`,`i`.`attendeeName` AS `attendeeName`,`i`.`attendeeEmailAddress` AS `attendeeEmailAddress`,`code`.`response` AS `invitationStatus`,`c`.`checkInTime` AS `checkInTime`,ifnull(`c`.`checkInTime`,'NotCheckedIn') AS `checkInStatus` from (((((((`invitations` `i` left join `checkins` `c` on((`c`.`attendeeId` = `i`.`attendeeId`))) join `response_codes` `code` on((`code`.`responseCode` = `i`.`attendeeResponse`))) join `events` `e` on((`e`.`eventId` = `i`.`eventId`))) join `event_owners` `eowns` on((`eowns`.`eventId` = `e`.`eventId`))) join `users` `owners` on((`owners`.`userId` = `eowns`.`ownerId`))) left join `event_organizers` `eorgs` on((`eorgs`.`eventId` = `e`.`eventId`))) left join `users` `organizer` on((`organizer`.`userId` = `eorgs`.`organizerId`)));

-- --------------------------------------------------------

--
-- Structure for view `vu_client_event_statistics`
--
DROP TABLE IF EXISTS `vu_client_event_statistics`;

CREATE  VIEW `vu_client_event_statistics` AS select `owner`.`userLname` AS `ownerLname`,`owner`.`userFname` AS `ownerFname`,concat(`owner`.`userLname`,', ',`owner`.`userFname`) AS `ownerName`,`eo`.`ownerId` AS `ownerId`,`owner`.`usertypeId` AS `ownerUserTypeId`,`usertypes`.`usertype` AS `ownerUserType`,count(`eo`.`eventId`) AS `eventCount` from ((`event_owners` `eo` join `users` `owner` on((`eo`.`ownerId` = `owner`.`userId`))) join `user_types` `usertypes` on((`usertypes`.`usertypeId` = `owner`.`usertypeId`))) group by `owner`.`userId`;

-- --------------------------------------------------------

--
-- Structure for view `vu_client_organizers`
--
DROP TABLE IF EXISTS `vu_client_organizers`;

CREATE  VIEW `vu_client_organizers` AS select concat(`organizer`.`userLname`,', ',`organizer`.`userFname`) AS `organizerName`,`organizer`.`userId` AS `organizerId`,`organizer`.`userContactNumber` AS `organizerContact`,ifnull(`e`.`eventId`,0) AS `eventId`,ifnull(`e`.`eventTitle`,'No event assigned!') AS `eventTitle`,`client`.`userId` AS `clientId`,concat(`client`.`userLname`,', ',`client`.`userFname`) AS `clientName` from (((`users` `client` left join `users` `organizer` on((`organizer`.`userParentId` = `client`.`userId`))) left join `event_organizers` `eorgs` on((`eorgs`.`organizerId` = `organizer`.`userId`))) left join `events` `e` on((`e`.`eventId` = `eorgs`.`eventId`))) where (`client`.`userParentId` = 0);

-- --------------------------------------------------------

--
-- Structure for view `vu_event_attendee_count`
--
DROP TABLE IF EXISTS `vu_event_attendee_count`;

CREATE  VIEW `vu_event_attendee_count` AS select `event`.`eventId` AS `eventId`,`event`.`eventTitle` AS `eventTitle`,date_format(`event`.`eventStartTime`,'%m/%d/%Y') AS `eventDate`,count(0) AS `attendeeCount` from (`checkins` left join `events` `event` on((`event`.`eventId` = `checkins`.`eventId`))) group by `checkins`.`eventId`;

-- --------------------------------------------------------

--
-- Structure for view `vu_event_info`
--
DROP TABLE IF EXISTS `vu_event_info`;

CREATE  VIEW `vu_event_info` AS select `e`.`eventId` AS `eventId`,`e`.`eventTitle` AS `eventTitle`,date_format(`e`.`eventStartTime`,'%m/%d/%Y') AS `eventDate`,date_format(`e`.`eventStartTime`,'%h:%i %p') AS `eventStartTime`,date_format(`e`.`eventEndTime`,'%h:%i %p') AS `eventEndTime`,`e`.`eventLocation` AS `eventLocation`,`e`.`eventDetails` AS `eventDetails`,concat(`owner`.`userLname`,', ',`owner`.`userFname`) AS `ownerName`,`eowns`.`ownerId` AS `ownerId`,`owner`.`userContactNumber` AS `ownerContactNumber`,`owner`.`usertypeId` AS `ownerUserTypeId`,`ownerusertype`.`usertype` AS `ownerUserType`,ifnull(concat(`organizer`.`userLname`,', ',`organizer`.`userFname`),'Unassigned') AS `organizerName`,`organizer`.`userId` AS `organizerId`,`organizer`.`userContactNumber` AS `organizerContactNumber` from (((((`events` `e` join `event_owners` `eowns` on((`e`.`eventId` = `eowns`.`eventId`))) left join `event_organizers` `eorgs` on((`e`.`eventId` = `eorgs`.`eventId`))) join `users` `owner` on((`owner`.`userId` = `eowns`.`ownerId`))) join `user_types` `ownerusertype` on((`ownerusertype`.`usertypeId` = `owner`.`usertypeId`))) left join `users` `organizer` on((`organizer`.`userId` = `eorgs`.`organizerId`)));

-- --------------------------------------------------------

--
-- Structure for view `vu_organizer_events`
--
DROP TABLE IF EXISTS `vu_organizer_events`;

CREATE  VIEW `vu_organizer_events` AS select concat(`organizer`.`userLname`,', ',`organizer`.`userFname`) AS `organizerName`,`organizer`.`userId` AS `organizerId`,`organizer`.`userContactNumber` AS `organizerContact`,`e`.`eventId` AS `organizerEventId`,`e`.`eventTitle` AS `organizerEventTitle`,concat(`client`.`userLname`,', ',`client`.`userFname`) AS `clientName`,`client`.`userId` AS `clientId` from (((`event_organizers` `eorgs` join `users` `organizer` on((`eorgs`.`organizerId` = `organizer`.`userId`))) join `events` `e` on((`e`.`eventId` = `eorgs`.`eventId`))) left join `users` `client` on((`client`.`userId` = `organizer`.`userParentId`)));

-- --------------------------------------------------------

--
-- Structure for view `vu_organizer_event_statistics`
--
DROP TABLE IF EXISTS `vu_organizer_event_statistics`;

CREATE  VIEW `vu_organizer_event_statistics` AS select `organizer`.`userLname` AS `organizerLname`,`organizer`.`userFname` AS `organizerFname`,concat(`organizer`.`userLname`,', ',`organizer`.`userFname`) AS `organizerName`,`eo`.`organizerId` AS `organizerId`,`organizer`.`usertypeId` AS `organizerUserTypeId`,`usertypes`.`usertype` AS `organizerUserType`,count(`eo`.`eventId`) AS `eventCount` from ((`event_organizers` `eo` join `users` `organizer` on((`eo`.`organizerId` = `organizer`.`userId`))) join `user_types` `usertypes` on((`usertypes`.`usertypeId` = `organizer`.`usertypeId`))) group by `organizer`.`userId`;

-- --------------------------------------------------------

--
-- Structure for view `vu_organizer_info`
--
DROP TABLE IF EXISTS `vu_organizer_info`;

CREATE  VIEW `vu_organizer_info` AS select concat(`organizer`.`userLname`,', ',`organizer`.`userFname`) AS `organizerName`,`organizer`.`userId` AS `organizerId`,`organizer`.`userContactNumber` AS `organizerContact`,`organizer`.`userEmailAddress` AS `organizerEmailAddress`,`owner`.`userLname` AS `ownerName`,`owner`.`userId` AS `ownerId` from (`users` `organizer` join `users` `owner` on((`owner`.`userId` = `organizer`.`userParentId`)));

-- --------------------------------------------------------

--
-- Structure for view `vu_user_full_info`
--
DROP TABLE IF EXISTS `vu_user_full_info`;

CREATE  VIEW `vu_user_full_info` AS select `users`.`userId` AS `userId`,`users`.`usertypeId` AS `usertypeId`,`users`.`userEmailAddress` AS `userEmailAddress`,`users`.`userPassword` AS `userPassword`,`users`.`userFname` AS `userFname`,`users`.`userLname` AS `userLname`,concat(`users`.`userLname`,', ',`users`.`userFname`) AS `userFullName`,`users`.`userContactNumber` AS `userContactNumber`,`users`.`userParentId` AS `userParentId`,`usertypes`.`usertype` AS `usertype`,concat(`owner`.`userLname`,', ',`owner`.`userFname`) AS `ownerName`,`owner`.`userId` AS `ownerId` from ((`users` left join `users` `owner` on((`owner`.`userId` = `users`.`userParentId`))) join `user_types` `usertypes` on((`usertypes`.`usertypeId` = `users`.`usertypeId`))) order by `usertypes`.`usertype`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkins`
--
ALTER TABLE `checkins`
  ADD CONSTRAINT `checkins_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
