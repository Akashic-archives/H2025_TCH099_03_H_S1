-- dumping data for table

INSERT INTO `User` (`UserName`) VALUES
('Pablo'),
('Mark'),
('Ekrem'),
('Mhamed')
;

INSERT INTO `Game_User` (`PlayerColor`, `GameID`, `UserID`) VALUES
(1, 1, 1)
;

INSERT INTO `Game` (`GameID`) VALUES
(),
(),
()
;

INSERT INTO `Turn` (`TurnNumber`, `Move`, `MoveLegality`, `GameID`) VALUES
(1, ``, 1, 1)
;

INSERT INTO `Pieces` (`PieceNumber`, `InitialPosition`, `Type`, `State`, `CurrentPosition`, `CurrentGameID`) VALUES
(1, 1, ``, ``, ``, 1)
;

--UPDATE `User`
--SET `FriendUserID` = 3  -- Set Bob's friend to the user with UserID 3
--WHERE `UserID` = 2;  -- For the user with UserID = 2 (Bob)


