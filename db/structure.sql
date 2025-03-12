-- table structure for table `User`
CREATE TABLE `User` (
  `UserID` int(15) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(20),
  `FriendUserID` int(15) NOT NULL,
  PRIMARY KEY (`UserID`),
  FOREIGN KEY (`FriendUserID`) REFERENCES `User` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Game_User` (
  `PlayerColor` int(1),
  `GameID` int(20) NOT NULL,
  `UserID` int(15) NOT NULL,
  FOREIGN KEY (`GameID`) REFERENCES `Game` (`GameID`),
  FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Game` (
  `GameID` int(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`GameID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Turn` (
  `TurnNumber` int(3) NOT NULL AUTO_INCREMENT,
  `Move` varchar(7),
  `MoveLegality` int(1),
  `GameID` int(20) NOT NULL,
  PRIMARY KEY (`TurnNumber`),
  FOREIGN KEY (`GameID`) REFERENCES `Game` (`GameID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Pieces` (
  `PieceNumber` int(2) NOT NULL AUTO_INCREMENT,
  `InitialPosition` int(2),
  `Type` varchar(10),
  `State` varchar(10),
  `CurrentPosition` varchar(2),
  `CurrentGameID` int(20) NOT NULL,
  PRIMARY KEY (`PieceNumber`),
  FOREIGN KEY (`CurrentGameID`) REFERENCES `Game` (`GameID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `User`
ADD CONSTRAINT `unique_username` UNIQUE (`UserName`);



-- CHATGPT generated and recommanded ALTER TABLE
ALTER TABLE `Pieces`
ADD INDEX `idx_gameid` (`CurrentGameID`);
-- supposedly helps with performance


--
-- AUTO_INCREMENT for table `coaches`
--
--ALTER TABLE `coaches`
--  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `activities`
--
--ALTER TABLE `activities`
--  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`coach`) REFERENCES `coaches` (`name`),
--  ADD CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`location`) REFERENCES `locations` (`name`);
--  ADD CONSTRAINT `activities_ibfk_3` FOREIGN KEY (`level`) REFERENCES `levels` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET_CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
