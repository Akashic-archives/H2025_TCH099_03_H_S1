-- dumping data for table

INSERT INTO `User` (`UserName`, `Email`, `Password`, `Name`, `LastName`) VALUES
('Pablo', 'pablo@local.local', '123', 'Pablo', 'Pablo'),
('Mark', 'mark@local.local', '123', 'Mark', 'Mark'),
('Ekrem', 'ekrem@local.local', '123', 'Ekrem', 'Ekrem'),
('Mhamed', 'mhamed@local.local', '123', 'Mhamed', 'Mhamed')
;

INSERT INTO `Game` () VALUES
(),
(),
()
;

INSERT INTO `Game_User` (`Player_black`, `Player_white`, `GameID`) VALUES
(1, 2, 1),
(2, 1, 2),
(4, 3, 3)
;

INSERT INTO `Turn` (`TurnNumber`, `Move`, `MoveLegality`, `GameID`) VALUES
(1, '1122', 1, 1)
;

INSERT INTO `Pieces` (`PieceID`, `PieceNumber`, `InitialPosition`, `Type`, `State`, `CurrentPosition`, `CurrentGameID`) VALUES
(11, 1, 11, 'rook', 'hidden', 12, 1),
(11, 1, 11, 'rook', 'revealed', 12, 1),
(11, 1, 11, 'rook', 'captured', 12, 1)
;

-- UPDATE `User`
-- SET `FriendUserID` = 3  -- Set Bob's friend to the user with UserID 3
-- WHERE `UserID` = 2;  -- For the user with UserID = 2 (Bob)


