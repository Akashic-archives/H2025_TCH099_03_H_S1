-- table structure for table `coaches`
CREATE TABLE `coaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- indexes for table `coaches`
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `coaches`
--
ALTER TABLE `coaches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`coach`) REFERENCES `coaches` (`name`),
  ADD CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`location`) REFERENCES `locations` (`name`);
  ADD CONSTRAINT `activities_ibfk_3` FOREIGN KEY (`level`) REFERENCES `levels` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET_CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
