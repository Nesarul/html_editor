-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table drew.course
CREATE TABLE IF NOT EXISTS `user_type` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL DEFAULT '0',
  `type_comments` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table drew.user_type: ~2 rows (approximately)
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
INSERT INTO `user_type` (`type_id`, `type_name`, `type_comments`) VALUES
	(1, 'Admin', 'System Administrator'),
	(2, 'ID', 'Instructional Designers, Most of the Access But not like Administrator'),
	(3, 'SME', 'Subject Matter Expert , Restricted Users Only view his / her coourse.');

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_first_name` varchar(255) NOT NULL,
  `user_last_name` varchar(255) NOT NULL,
  `user_login_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_phone` varchar(50) DEFAULT NULL,
  `user_type` int(10) unsigned NOT NULL,
  `user_permission` char(50) NOT NULL DEFAULT '0',
  `date_join` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_users_user_type` (`user_type`),
  CONSTRAINT `FK_users_user_type` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table drew.users: ~6 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_first_name`, `user_last_name`, `user_login_name`, `user_email`, `user_pass`, `user_image`, `user_phone`, `user_type`, `user_permission`, `date_join`) VALUES
	(2, 'Drew', 'Bennett', 'db', 'bennett@yahoo.com', '$argon2i$v=19$m=65536,t=4,p=1$Z2IvWVZvZFpURkxFOHh5cA$qYjhV1JdctTBHDTvjA8C1Wf3ul5SmsTRya1IGq8/MdY', 'drew.jpg', '', 1, '1', '2020-11-16 22:36:53'),
	(6, 'Jahangir', 'Alam', 'jahangir', 'jahangir781@gmail.com', '$2y$10$9xsfzCUcH5ZbC/6pdpo53uLLJKaCDKGHxbx8PenUeVz5hHtwBgvWq', '1611061528', '', 3, '1', '2021-01-19 13:05:28'),
	(7, 'Terry', 'White', 'hasan', 'hasan@yahoo.com', '$2y$10$.ACbDcqDGIbmEnYU0mtG5ufGs7b.c1CIdX/SPoKvxH9FzT7trfL.2', '1611223143.jpg', '01612024395', 3, '1', '2021-01-21 09:59:03'),
	(8, 'Nesarul', 'Hoque', 'hoque', 'hoque@yahoo.com', '$2y$10$.ACbDcqDGIbmEnYU0mtG5ufGs7b.c1CIdX/SPoKvxH9FzT7trfL.2', 'nesarul.jpgt', '01612024395', 2, '1', '2021-01-21 19:25:31'),
	(9, 'Jasim', 'Uddin', 'jasim', 'jasim@gmail.com', '$2y$10$tY84Rxe50BjdTygoTgDrHOExZpcwr6lwnE5X58PPWBNnd3GChCp86', '1611304833', '01612024395', 2, '1', '2021-01-22 08:40:33'),
	(11, 'Murshida', 'Hoque', 'murshida', 'murshida@gmail.com', '$2y$10$WkoNcWn22HgpwbJdx1N7kOA2h4AmgfryOxrSPMmInXZzL8pE.eEfG', 'drew.jpg', NULL, 1, '1', '2021-01-30 11:04:30');

CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `sme` int(10) unsigned DEFAULT NULL,
  `c_title` text,
  `c_footer` text,
  `c_css` text,
  `c_js` text,
  PRIMARY KEY (`course_id`),
  KEY `FK_course_users` (`sme`),
  CONSTRAINT `FK_course_users` FOREIGN KEY (`sme`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table drew.course: ~3 rows (approximately)
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` (`course_id`, `course_name`, `date_created`, `author`, `sme`, `c_title`, `c_footer`, `c_css`, `c_js`) VALUES
	(1, 'This is just test.', '2021-01-19 08:05:58', 'Drew Bennett', NULL, '<div class="container-fluid">\r\n    <div class="row">\r\n        <div id="header-box" class="d-flex justify-content-center align-items-center">\r\n            <h1></h1>\r\n        </div>\r\n    </div>\r\n\r\n    <!-- End of Header -->\r\n    <div class="row">\r\n        <div class="col-12 p-0 mb-5">\r\n            <div id="overviewCaption" class="carousel slide">\r\n                <ol class="carousel-indicators">\r\n                    <li data-target="#overviewCaption" data-slide-to="0" class="active"></li>\r\n                    <li data-target="#overviewCaption" data-slide-to="1"></li>\r\n                </ol>\r\n                <div class="carousel-inner">\r\n                    <div class="carousel-item active">\r\n                        <img src="./images/c1/unit_01_intro_01.jpg" class="d-block w-100" alt="../../images/unit01_intro_01.jpg" />\r\n                    </div>\r\n                    <div class="carousel-item">\r\n                        <img src="./images/c1/unit_01_intro_02.jpg" class="d-block w-100" alt="../../images/unit_01_intro_02.jpg" />\r\n                    </div>\r\n                </div>\r\n                <a class="carousel-control-prev" href="#overviewCaption" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#overviewCaption" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>', '</body>', '<link href="./css/bootstrap.min.css" rel="stylesheet">\r\n<link href="./css/custom-c1.css" rel="stylesheet">', '<script src="./js/jquery-3.5.1.min.js"></script>'),
	(4, 'OAEX-253 Executive Office Procedures 1', '2021-01-24 22:00:34', 'Drew Bennett', NULL, '\r\n    <div class="container-fluid">\r\n        <div class="row">\r\n            <div id="header-box" class="d-flex justify-content-center align-items-center">\r\n                <h1></h1>\r\n            </div>\r\n        </div>\r\n\r\n        <!-- End of Header -->\r\n        <div class="row">\r\n            <div class="col-12 p-0 mb-5">\r\n                <div id="overviewCaption" class="carousel slide">\r\n                    <ol class="carousel-indicators">\r\n                        <li data-target="#overviewCaption" data-slide-to="0" class="active"></li>\r\n                        <li data-target="#overviewCaption" data-slide-to="1"></li>\r\n                    </ol>\r\n                    <div class="carousel-inner">\r\n                        <div class="carousel-item active">\r\n                            <img src="./images/c1/unit_01_intro_01.jpg" class="d-block w-100" alt="../../images/unit01_intro_01.jpg" />\r\n                        </div>\r\n                        <div class="carousel-item">\r\n                            <img src="./images/c1/unit_01_intro_02.jpg" class="d-block w-100" alt="../../images/unit_01_intro_02.jpg" />\r\n                        </div>\r\n                    </div>\r\n                    <a class="carousel-control-prev" href="#overviewCaption" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#overviewCaption" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>', NULL, '<link href="./css/bootstrap.min.css" rel="stylesheet"><link href="./css/custom-c1.css" rel="stylesheet">', '<script src="./js/jquery-3.5.1.min.js"></script>'),
	(5, 'OAME-258 Medical Machine Transcription', '2021-01-24 22:01:03', 'Drew Bennett', NULL, '\r\n    <div class="container-fluid">\r\n        <div class="row">\r\n            <div id="header-box" class="d-flex justify-content-center align-items-center">\r\n                <h1></h1>\r\n            </div>\r\n        </div>\r\n\r\n        <!-- End of Header -->\r\n        <div class="row">\r\n            <div class="col-12 p-0 mb-5">\r\n                <div id="overviewCaption" class="carousel slide">\r\n                    <ol class="carousel-indicators">\r\n                        <li data-target="#overviewCaption" data-slide-to="0" class="active"></li>\r\n                        <li data-target="#overviewCaption" data-slide-to="1"></li>\r\n                    </ol>\r\n                    <div class="carousel-inner">\r\n                        <div class="carousel-item active">\r\n                            <img src="./images/c1/unit_01_intro_01.jpg" class="d-block w-100" alt="../../images/unit01_intro_01.jpg" />\r\n                        </div>\r\n                        <div class="carousel-item">\r\n                            <img src="./images/c1/unit_01_intro_02.jpg" class="d-block w-100" alt="../../images/unit_01_intro_02.jpg" />\r\n                        </div>\r\n                    </div>\r\n                    <a class="carousel-control-prev" href="#overviewCaption" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#overviewCaption" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>', NULL, '<link href="./css/bootstrap.min.css" rel="stylesheet"><link href="./css/custom-c1.css" rel="stylesheet">', '<script src="./js/jquery-3.5.1.min.js"></script>');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `unit` (
  `unit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(50) NOT NULL,
  `unit_title` varchar(200) DEFAULT NULL,
  `course_id` int(10) unsigned NOT NULL,
  `unit_author` varchar(255) NOT NULL,
  `unit_created` datetime NOT NULL,
  `unit_contents` longtext,
  `unit_status` tinyint(3) unsigned NOT NULL,
  `unit_approved_by` int(10) unsigned NOT NULL,
  `unit_sme` int(10) unsigned NOT NULL,
  PRIMARY KEY (`unit_id`),
  KEY `FK__course` (`course_id`),
  KEY `FK_unit_users` (`unit_sme`),
  CONSTRAINT `FK__course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  CONSTRAINT `FK_unit_users` FOREIGN KEY (`unit_sme`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table drew.unit: ~5 rows (approximately)
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` (`unit_id`, `unit_name`, `unit_title`, `course_id`, `unit_author`, `unit_created`, `unit_contents`, `unit_status`, `unit_approved_by`, `unit_sme`) VALUES
	(1, 'Unit 01', 'Overview', 1, 'Drew Bennett', '2021-01-19 09:28:40', '<div class="video-container">\r\n<p class="n2d">Drag the Image (H5P)</p>\r\n&nbsp;<iframe src="https://www.youtube.com/embed/m8THoxuhQ6g" width="800" height="450" frameborder="0" allowfullscreen="allowfullscreen" data-mce-fragment="1"></iframe>\r\n<div class="image-caption">\r\n<p class="info-icon"><strong>Caption: </strong>Medical Terminology, Shortcuts for Pronunciation</p>\r\n<p class="small-text"><strong>Source: </strong><a href="https://www.youtube.com/watch?v=m8THoxuhQ6g">YouTube</a></p>\r\n</div>\r\n<div class="text-center my-3"><a class="js-toexpand" href="#a">Video Transcript</a>\r\n<div class="js-expand_more text-left">\r\n<p>Transcript Text Here</p>\r\n</div>\r\n</div>\r\n</div>\r\n<p><iframe src="https://centennialcollege.h5p.com/content/1291212274891465628/embed" width="100%" frameborder="0" allowfullscreen="allowfullscreen"></iframe></p>\r\n<p>&nbsp;</p>', 0, 0, 6),
	(30, 'Unit 01', 'What is Social Media', 1, 'Drew Bennett', '2021-01-23 09:47:55', NULL, 0, 0, 7),
	(31, 'Unit 01', 'Social Media Terminology', 1, 'Drew Bennett', '2021-01-23 09:58:40', '<p>Dear Bangladesh,</p>\r\n<p>How are you doing recently. I am fine.&nbsp;</p>', 0, 0, 7),
	(32, 'Unit 01', 'Whatever the course is', 4, 'Drew Bennett', '2021-01-24 22:03:31', '<p>Dear Bangladesh.&nbsp;</p>\r\n<p>How are you today?</p>', 0, 0, 7),
	(33, 'Unit 01', 'What ever you call it', 1, 'Drew Bennett', '2021-01-26 00:37:06', '<div class="row custom-bubble d-flex align-items-center">\r\n<div class="character">\r\n<div class="av-image"><img src="../../images/colleen_01.jpg" alt="Colleen" /></div>\r\n<button class="btn av-btn-speak" style="--bg-color: #529113; --txt-color: #ffffff;" type="button">Click to Speak</button></div>\r\n<div class="sp-bubble d-none">\r\n<div class="bbl-main" style="--bg-color: #529113; --txt-color: #ffffff;" data-person="1">\r\n<p class="t">Insert Bubble Text Here</p>\r\n</div>\r\n</div>\r\n</div>\r\n<p>&nbsp;</p>\r\n<div class="row custom-bubble d-flex align-items-center justify-content-end">\r\n<div class="sp-bubble d-none">\r\n<div class="bbl-main-r" style="--bg-color: #529113; --txt-color: #ffffff;" data-person="1">\r\n<p class="t">Insert bubble text Here</p>\r\n</div>\r\n</div>\r\n<div class="character">\r\n<div class="av-image"><img src="../../images/colleen_01.jpg" alt="Colleen" /></div>\r\n<button class="btn av-btn-speak" style="--bg-color: #529113; --txt-color: #ffffff;" type="button">Click to Speak</button></div>\r\n</div>\r\n<p>&nbsp;</p>', 0, 0, 6),
	(45, 'Unit 01', 'Health administration', 1, 'Drew Bennett', '2021-01-26 08:16:27', '<div class="text-center my-3"><a class="js-toexpand" href="#">Video Transcript</a>\r\n<div class="js-expand_more text-left" style="display: none;">\r\n<p>Insert Text Here</p>\r\n</div>\r\n</div>\r\n<p>&nbsp;<a href="https://youtu.be/-rCvIECxLDo">https://youtu.be/-rCvIECxLDo</a></p>\r\n<p>&lt;iframe width="560" height="315" src="https://www.youtube.com/embed/-rCvIECxLDo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen&gt;&lt;/iframe&gt;</p>\r\n<p></p>\r\n<p></p>', 1, 10, 7);
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `sort_unit` (
  `s_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_id` int(10) unsigned NOT NULL,
  `u_id` int(10) unsigned NOT NULL,
  `s_u_id` int(10) unsigned NOT NULL,
  `s_ord` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`s_id`),
  KEY `FK_sort_unit_course` (`c_id`),
  KEY `FK_sort_unit_unit` (`u_id`),
  KEY `FK_sort_unit_users` (`s_u_id`),
  CONSTRAINT `FK_sort_unit_course` FOREIGN KEY (`c_id`) REFERENCES `course` (`course_id`),
  CONSTRAINT `FK_sort_unit_unit` FOREIGN KEY (`u_id`) REFERENCES `unit` (`unit_id`),
  CONSTRAINT `FK_sort_unit_users` FOREIGN KEY (`s_u_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table drew.sort_unit: ~6 rows (approximately)
/*!40000 ALTER TABLE `sort_unit` DISABLE KEYS */;
INSERT INTO `sort_unit` (`s_id`, `c_id`, `u_id`, `s_u_id`, `s_ord`) VALUES
	(1, 1, 1, 6, 0),
	(2, 1, 30, 7, 1),
	(3, 1, 31, 7, 2),
	(4, 1, 33, 7, 3),
	(5, 4, 32, 6, 0),
	(10, 1, 45, 7, 0);
/*!40000 ALTER TABLE `sort_unit` ENABLE KEYS */;