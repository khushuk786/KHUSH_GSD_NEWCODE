-- Use the hospital database
create database hospital;
USE hospital;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table structure for table `tbladmin`
-- --------------------------------------------------------

CREATE TABLE `tbladmin` (
  `AID` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `tbladmin`
INSERT INTO `tbladmin` (`AID`, `Username`, `Password`) VALUES
(1, 'khin', 'khin123'),
(2, 'poe', 'poe123');

-- --------------------------------------------------------
-- Table structure for table `tblappointment`
-- --------------------------------------------------------

CREATE TABLE `tblappointment` (
  `AID` int(11) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `DoctorID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Notes` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tblappointment` (`AID`, `PatientID`, `DoctorID`, `Date`, `Notes`) VALUES
(1, 4, 1, '2024-08-11', 'HI testing');

-- --------------------------------------------------------
-- Table structure for table `tblbed`
-- --------------------------------------------------------

CREATE TABLE `tblbed` (
  `AID` int(11) NOT NULL,
  `Number` varchar(50) NOT NULL,
  `Availability` int(11) NOT NULL,
  `WardID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tblbed` (`AID`, `Number`, `Availability`, `WardID`) VALUES
(1, 'B1', 0, 1),
(2, 'B2', 0, 2),
(3, 'B3', 1, 1);

-- --------------------------------------------------------
-- Table structure for table `tbldoctor`
-- --------------------------------------------------------

CREATE TABLE `tbldoctor` (
  `AID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Grade` varchar(100) NOT NULL,
  `TeamID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbldoctor` (`AID`, `Name`, `Grade`, `TeamID`) VALUES
(1, 'DoctorA1', 'Consultant', 1),
(2, 'Doctor2', 'Grade 1 Junior', 1),
(3, 'dikshaynta', 'Consultant', 2),
(4, 'Khin Yadanar', 'Grade 1 Junior', 2);

-- --------------------------------------------------------
-- Table structure for table `tbllog`
-- --------------------------------------------------------

CREATE TABLE `tbllog` (
  `AID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Description` varchar(300) NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `tbllog`
INSERT INTO `tbllog` (`AID`, `UserID`, `Description`, `Date`) VALUES
(1, 1, 'khin logged in.', '2024-08-10 23:28:58'),
(2, 1, 'khin logged out.', '2024-08-11 00:07:48'),
(3, 1, 'khin logged in.', '2024-08-11 00:08:54'),
(4, 1, 'khin added new patient (Patient1)', '2024-08-11 00:11:22');
-- (Include the rest of the `tbllog` inserts here)

-- --------------------------------------------------------
-- Table structure for table `tblpatient`
-- --------------------------------------------------------

CREATE TABLE `tblpatient` (
  `AID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Age` int(11) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `RegisterDate` date NOT NULL,
  `WardID` int(11) NOT NULL,
  `BedID` int(11) NOT NULL,
  `TeamID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `tblpatient` (`AID`, `Name`, `Age`, `Gender`, `RegisterDate`, `WardID`, `BedID`, `TeamID`) VALUES
(4, 'Will', 24, 'Male', '2024-08-11', 1, 3, 1);

-- --------------------------------------------------------
-- Table structure for table `tblteam`
-- --------------------------------------------------------

CREATE TABLE `tblteam` (
  `AID` int(11) NOT NULL,
  `Code` varchar(20) NOT NULL,
  `Name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tblteam` (`AID`, `Code`, `Name`) VALUES
(1, 'T001', 'Team1'),
(2, 'T002', 'Team2'),
(3, 'T003', 'Team3');

-- --------------------------------------------------------
-- Table structure for table `tblward`
-- --------------------------------------------------------

CREATE TABLE `tblward` (
  `AID` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Type` varchar(250) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `Availability` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tblward` (`AID`, `Name`, `Type`, `Capacity`, `Availability`) VALUES
(1, 'W1', 'Male', 20, 19),
(2, 'F1', 'Female', 20, 20),
(3, 'W2', 'Male', 10, 10);

-- --------------------------------------------------------
-- Add primary keys and auto-increment
-- --------------------------------------------------------

ALTER TABLE `tbladmin` ADD PRIMARY KEY (`AID`);
ALTER TABLE `tblappointment` ADD PRIMARY KEY (`AID`);
ALTER TABLE `tblbed` ADD PRIMARY KEY (`AID`);
ALTER TABLE `tbldoctor` ADD PRIMARY KEY (`AID`);
ALTER TABLE `tbllog` ADD PRIMARY KEY (`AID`);
ALTER TABLE `tblpatient` ADD PRIMARY KEY (`AID`);
ALTER TABLE `tblteam` ADD PRIMARY KEY (`AID`);
ALTER TABLE `tblward` ADD PRIMARY KEY (`AID`);

-- Enable auto-increment
ALTER TABLE `tbladmin` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `tblappointment` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `tblbed` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `tbldoctor` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `tbllog` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
ALTER TABLE `tblpatient` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `tblteam` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `tblward` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- Table structure for table `tblfiles`
CREATE TABLE `tblfiles` (
  `AID` int(11) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `FilePath` varchar(255) NOT NULL,
  `UploadDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tblfiles` ADD PRIMARY KEY (`AID`);
ALTER TABLE `tblfiles` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------
-- Table structure for table `tblprescription`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tblprescription` (
  `AID` int(11) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `Medicine` varchar(255) NOT NULL,
  `Dosage` varchar(100) NOT NULL,
  `PrescriptionDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tblprescription` ADD PRIMARY KEY (`AID`);
ALTER TABLE `tblprescription` MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT;


-- Inserting sample data into tblfiles
INSERT INTO `tblfiles` (`AID`, `PatientID`, `FilePath`, `UploadDate`) VALUES
(1, 4, '/uploads/xray_patient4.jpg', '2024-08-12 11:00:00'),
(2, 4, '/uploads/lab_result_patient4.pdf', '2024-08-12 12:00:00'),
(3, 4, '/uploads/scan_patient4.pdf', '2024-08-12 13:00:00');


-- Inserting sample data into tblprescription
INSERT INTO `tblprescription` (`AID`, `PatientID`, `Medicine`, `Dosage`, `PrescriptionDate`) VALUES
(1, 4, 'Paracetamol', '500 mg', '2024-08-12 10:00:00'),
(2, 4, 'Amoxicillin', '250 mg', '2024-08-12 10:00:00'),
(3, 4, 'Ibuprofen', '400 mg', '2024-08-12 10:00:00');






COMMIT;