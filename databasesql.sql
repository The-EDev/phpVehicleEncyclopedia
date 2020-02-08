--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data for table `Category`
--

INSERT INTO `Category` VALUES(3, 'Air');
INSERT INTO `Category` VALUES(1, 'Land');
INSERT INTO `Category` VALUES(2, 'Sea');

-- --------------------------------------------------------

--
-- Table structure for table `Operator`
--

CREATE TABLE `Operator` (
  `userID` int(11) NOT NULL,
  `userCode` varchar(45) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Vehicle`
--

CREATE TABLE `Vehicle` (
  `name` varchar(45) NOT NULL,
  `brand` varchar(45) NOT NULL,
  `category` varchar(45) NOT NULL,
  `description` varchar(4096) NOT NULL,
  `id` int(11) NOT NULL,
  `operatorID` int(11) NOT NULL,
  `image` varchar(4096) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `Operator`
--
ALTER TABLE `Operator`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userCode` (`userCode`);

--
-- Indexes for table `Vehicle`
--
ALTER TABLE `Vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `operatorID` (`operatorID`),
  ADD KEY `Vehicle_ibfk_2` (`category`);

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for table `Vehicle`
--
ALTER TABLE `Vehicle`
  ADD CONSTRAINT `Vehicle_ibfk_1` FOREIGN KEY (`operatorID`) REFERENCES `Operator` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Vehicle_ibfk_2` FOREIGN KEY (`category`) REFERENCES `Category` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION;