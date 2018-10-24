-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-10-24 07:09:24
-- 服务器版本： 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesis`
--

-- --------------------------------------------------------

--
-- 表的结构 `think_admin`
--

DROP TABLE IF EXISTS `think_admin`;
CREATE TABLE IF NOT EXISTS `think_admin` (
  `Tnum` char(4) NOT NULL COMMENT '工号',
  `Tname` varchar(8) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `role` varchar(4) NOT NULL COMMENT '权限 值为1时为超级管理员 值为2时为二级管理员',
  PRIMARY KEY (`Tnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_admin`
--

INSERT INTO `think_admin` (`Tnum`, `Tname`, `pwd`, `role`) VALUES
('0000', 'hh', '14e1b600b1fd579f47433b88e8d85291', '3'),
('1090', '覃忠台', 'b03ba0c98d0f0bc9a864e0288b72fd92', '2');

-- --------------------------------------------------------

--
-- 表的结构 `think_apply`
--

DROP TABLE IF EXISTS `think_apply`;
CREATE TABLE IF NOT EXISTS `think_apply` (
  `apply_num` int(11) NOT NULL AUTO_INCREMENT,
  `topic_Cnum` int(11) NOT NULL,
  `student_Snum` int(11) NOT NULL,
  `student_name` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL COMMENT '选课状态 0为不通过 1为通过',
  `reason` varchar(500) NOT NULL COMMENT '申请理由',
  `Tnum` varchar(4) NOT NULL COMMENT '教师工号',
  PRIMARY KEY (`apply_num`),
  KEY `fk_think_topic_has_think_student_think_student1_idx` (`student_Snum`),
  KEY `fk_think_topic_has_think_student_think_topic1_idx` (`topic_Cnum`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_apply`
--

INSERT INTO `think_apply` (`apply_num`, `topic_Cnum`, `student_Snum`, `student_name`, `status`, `reason`, `Tnum`) VALUES
(16, 1931, 1440217101, '林树嘉', '1', '1111', '1156'),
(19, 1873, 1440226149, '郑俊海', '1', '', '1708');

-- --------------------------------------------------------

--
-- 表的结构 `think_config`
--

DROP TABLE IF EXISTS `think_config`;
CREATE TABLE IF NOT EXISTS `think_config` (
  `year` int(11) NOT NULL COMMENT '年份',
  `status` int(11) DEFAULT '0' COMMENT '系统所处状态(值是0为关闭，值为1为开启）',
  PRIMARY KEY (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_config`
--

INSERT INTO `think_config` (`year`, `status`) VALUES
(2018, 1);

-- --------------------------------------------------------

--
-- 表的结构 `think_defense`
--

DROP TABLE IF EXISTS `think_defense`;
CREATE TABLE IF NOT EXISTS `think_defense` (
  `defense_group` int(11) NOT NULL AUTO_INCREMENT COMMENT '答辩分组',
  `admin` varchar(45) DEFAULT NULL COMMENT '组长',
  `time` datetime DEFAULT NULL COMMENT '答辩时间',
  `class` varchar(45) DEFAULT NULL COMMENT '答辩教室',
  `year` varchar(45) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `ERG_group` int(11) NOT NULL,
  PRIMARY KEY (`defense_group`),
  KEY `fk_think_defense_think_ERG1_idx` (`ERG_group`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_defense`
--

INSERT INTO `think_defense` (`defense_group`, `admin`, `time`, `class`, `year`, `status`, `ERG_group`) VALUES
(9, '1090', '2018-06-13 00:00:00', 's201', '2018', 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `think_defensestudent`
--

DROP TABLE IF EXISTS `think_defensestudent`;
CREATE TABLE IF NOT EXISTS `think_defensestudent` (
  `Snum` int(11) NOT NULL,
  `Sname` varchar(45) DEFAULT NULL,
  `reviewTeacher` varchar(45) DEFAULT NULL COMMENT '论文评阅老师',
  `review_status` int(11) DEFAULT '0',
  `defense_group` int(11) NOT NULL,
  PRIMARY KEY (`Snum`),
  KEY `fk_think_defenseStudent_think_defense1_idx` (`defense_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_defensestudent`
--

INSERT INTO `think_defensestudent` (`Snum`, `Sname`, `reviewTeacher`, `review_status`, `defense_group`) VALUES
(1440226149, '郑俊海', NULL, 0, 9);

-- --------------------------------------------------------

--
-- 表的结构 `think_defenseteacher`
--

DROP TABLE IF EXISTS `think_defenseteacher`;
CREATE TABLE IF NOT EXISTS `think_defenseteacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tnum` varchar(4) NOT NULL,
  `Tname` varchar(45) DEFAULT NULL,
  `defense_group` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_defenseTeacher_think_defense1_idx` (`defense_group`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_defenseteacher`
--

INSERT INTO `think_defenseteacher` (`id`, `Tnum`, `Tname`, `defense_group`) VALUES
(36, '0296', '', 9),
(37, '1708', '', 9),
(49, '1090', NULL, 9);

-- --------------------------------------------------------

--
-- 表的结构 `think_dscore`
--

DROP TABLE IF EXISTS `think_dscore`;
CREATE TABLE IF NOT EXISTS `think_dscore` (
  `Did` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `RgradeC1` float DEFAULT NULL COMMENT '答辩评分',
  `RgradeC2` float DEFAULT NULL,
  `RgradeC3` float DEFAULT NULL,
  `RgradeC4` float DEFAULT NULL,
  `RtextC` varchar(500) DEFAULT NULL COMMENT '''公告内容''',
  `Tnum` char(4) NOT NULL COMMENT '答辩老师',
  `scorenum` int(11) NOT NULL COMMENT '成绩单编号',
  PRIMARY KEY (`Did`),
  KEY `fk_think_dscore_think_teacher1_idx` (`Tnum`),
  KEY `fk_think_dscore_think_score1_idx` (`scorenum`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_dscore`
--

INSERT INTO `think_dscore` (`Did`, `RgradeC1`, `RgradeC2`, `RgradeC3`, `RgradeC4`, `RtextC`, `Tnum`, `scorenum`) VALUES
(65, NULL, NULL, NULL, NULL, NULL, '0296', 12),
(66, NULL, NULL, NULL, NULL, NULL, '1708', 12),
(67, NULL, NULL, NULL, NULL, NULL, '1090', 12);

-- --------------------------------------------------------

--
-- 表的结构 `think_erg`
--

DROP TABLE IF EXISTS `think_erg`;
CREATE TABLE IF NOT EXISTS `think_erg` (
  `ERG_group` int(11) NOT NULL COMMENT '教研室组别',
  `ERG_name` varchar(45) NOT NULL COMMENT '教研室名称',
  PRIMARY KEY (`ERG_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_erg`
--

INSERT INTO `think_erg` (`ERG_group`, `ERG_name`) VALUES
(1, '网设与安全教研室'),
(2, '多媒体与网传教研室'),
(3, '信息工程教研室');

-- --------------------------------------------------------

--
-- 表的结构 `think_information`
--

DROP TABLE IF EXISTS `think_information`;
CREATE TABLE IF NOT EXISTS `think_information` (
  `infonum` int(10) UNSIGNED NOT NULL COMMENT '公告编号',
  `infotitle` varchar(45) NOT NULL COMMENT '''公告标题''',
  `infocontent` text NOT NULL COMMENT '''公告内容''',
  `infotime` datetime NOT NULL COMMENT '''发送时间''',
  `Tnum` char(4) NOT NULL,
  PRIMARY KEY (`infonum`),
  KEY `fk_think_information_think_admin1_idx` (`Tnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_information`
--

INSERT INTO `think_information` (`infonum`, `infotitle`, `infocontent`, `infotime`, `Tnum`) VALUES
(2018061315, '11', '222', '2018-06-13 21:46:07', '0000'),
(2018061477, '阿百川的都', '<p>\r\n					1234 果断发噶伽师瓜啊傻瓜</p>', '2018-06-14 12:36:10', '0000');

-- --------------------------------------------------------

--
-- 表的结构 `think_score`
--

DROP TABLE IF EXISTS `think_score`;
CREATE TABLE IF NOT EXISTS `think_score` (
  `scorenum` int(11) NOT NULL AUTO_INCREMENT COMMENT '''学生学号''',
  `Ggrade1` float DEFAULT NULL COMMENT '指导评分1',
  `Ggrade2` float DEFAULT NULL,
  `Ggrade3` float DEFAULT NULL,
  `Ggrade4` float DEFAULT NULL,
  `Ggrade5` float DEFAULT NULL,
  `Gtext` varchar(400) DEFAULT NULL COMMENT '''指导评分''',
  `Pgrade1` float DEFAULT NULL COMMENT '论文评分1',
  `Pgrade2` float DEFAULT NULL,
  `Ptext` varchar(400) DEFAULT NULL,
  `Pteacher` varchar(10) DEFAULT NULL COMMENT '论文评分老师',
  `Rgrade1` float DEFAULT NULL COMMENT '答辩评分',
  `Rgrade2` float DEFAULT NULL,
  `Rgrade3` float DEFAULT NULL,
  `Rgrade4` float DEFAULT NULL COMMENT '答辩评分4',
  `Rtext` varchar(400) DEFAULT NULL COMMENT '''答辩评语''',
  `Cnum` varchar(15) DEFAULT NULL COMMENT '''课题编号''',
  `Studentnum` int(11) NOT NULL,
  PRIMARY KEY (`scorenum`),
  KEY `fk_think_score_think_student1_idx` (`Studentnum`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_score`
--

INSERT INTO `think_score` (`scorenum`, `Ggrade1`, `Ggrade2`, `Ggrade3`, `Ggrade4`, `Ggrade5`, `Gtext`, `Pgrade1`, `Pgrade2`, `Ptext`, `Pteacher`, `Rgrade1`, `Rgrade2`, `Rgrade3`, `Rgrade4`, `Rtext`, `Cnum`, `Studentnum`) VALUES
(11, 9, 9, 15, 12, 4, '不错很棒，页面新颖，有自己的创作', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1440217101),
(12, 9, 9, 16, 14, 4, '可以，很不错的作品', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1440226149);

-- --------------------------------------------------------

--
-- 表的结构 `think_student`
--

DROP TABLE IF EXISTS `think_student`;
CREATE TABLE IF NOT EXISTS `think_student` (
  `Snum` int(11) NOT NULL COMMENT '学号',
  `Sname` varchar(10) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `sex` varchar(2) DEFAULT NULL COMMENT '''男、女（M/F）''',
  `class` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `qq` int(11) DEFAULT NULL,
  `denfense_status` varchar(2) DEFAULT NULL COMMENT '答辩状态',
  `denfense_allocation` varchar(2) DEFAULT NULL COMMENT '答辩分配状态',
  `taskbook` varchar(100) DEFAULT NULL COMMENT '任务书',
  `denfense_draft` varchar(100) DEFAULT NULL COMMENT '答辩稿',
  `year` int(4) NOT NULL,
  PRIMARY KEY (`Snum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_student`
--

INSERT INTO `think_student` (`Snum`, `Sname`, `pwd`, `sex`, `class`, `phone`, `email`, `qq`, `denfense_status`, `denfense_allocation`, `taskbook`, `denfense_draft`, `year`) VALUES
(1140225111, '蔡子佳', '02a7687e1927fa032f4e9293f2bccf1b', '女', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1140225122, '吴迪', 'f4b39c27b16dc6f9089517716dd29187', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1140225133, '林树嘉', 'dde27cafc9ffd1b384d47d93e9e09f55', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1240217159, '李浩平', 'dfd353e654bb8fb3f61c9df4581eea60', '男', '网络工程(网络设计与管理)', '12312', 'fhsdjakfha@qq.com', 489641865, NULL, '0', './Public/2018/taskbook/1240217159李浩平.docx', './Public/2018/denfense_draft/1240217159李浩平.docx', 2018),
(1440217101, '林树嘉', '2e665be2754515ad18e15e7de7db011e', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, '1', '0', './Public/2018/taskbook/1440217101林树嘉.docx', NULL, 2018),
(1440217102, '程曲杭', '69b9fe6c6f3befd04b34c231fe53c7f0', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217103, '林振杰', '588afe0ae52499a01504fc676dbac1a7', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217104, '胡康伟', '5f58bf43ddcf866806d5864087b8d76e', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217105, '林增誉', '98924b14bbbd23cf534d95d7b2a764d5', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217106, '黄向通', '9fb36245ad27243671a15e5e1e6c28bc', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217107, '张邓欢', 'd378a4b4313bda85a53d8fc803eeffa3', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217108, '张友', '4191fcfe7def70a8c06c6d423f434512', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217109, '刘治成', 'eba4fed3b9dc5812fb15938f17cf4c20', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217110, '岑维文', '858cfdb3f208a3a7bad8cf576b19716e', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217111, '骆灼文', '16d135554abf48eabe895189ab082f2c', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217112, '陈翰童', '5f71b11b7c46177fc18047bec8e505a6', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217113, '黄裕昌', '971ea155441e8f617f3f8a3bbe18f690', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217114, '黄璨', '25d0680cb703b3ac2a14311567482e8d', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217115, '邱杭锐', '0d5d1fecf5990f6a93b5a106eee6fa1b', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217116, '莫敬伟', 'a238f4674d27474f712a21724a5bca7f', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217117, '许清遥', '083de502fdc6bd77623e246508411992', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217118, '何维庭', 'a195311b6d945b687e30433271ba47f2', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217119, '邹谨慎', '5f49ea1a4969aff4760cf5424c2c8054', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217120, '吴曾榆', '202fffc91f7b796280a9a6f4cf1ca1a8', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217121, '周健铭', '1dea6a4722ab623782e8b23cd82ae720', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217122, '许炎智', '5232290e9cbe1a92fbabf9ff8baa358e', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217123, '郭俊贤', 'eda4591cf8fdae13f9bc28eab5cf3af2', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217124, '黄浩延', 'b0c3dbe1b1d58a7651e91c42e188c477', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217125, '梁宝承', 'd2b0badd1c2854a4fb0997a3891e8239', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217126, '劳常贤', 'ffbca3201cfe2249df7444b89ce2d539', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217127, '梁家铭', '2a57138509a51a733cb8cabf2861b8d9', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217128, '谭家辉', 'e8bea6f1df0cf8e92cefde8f54b14f16', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217129, '阮建坤', '43e000a26751183d744d2a8505ad4310', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217130, '赖国浩', '95a4802abc7b24915eac42eb94f9d313', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217131, '何晓强', 'd11d5c4993ce1063b30641d72299751c', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217132, '陆嘉豪', 'e8e79a614a15bf13237769a03d11e60e', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217133, '陈星达', '002b825d264e032bcbed29fd02f0b90a', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217134, '戴泳麟', 'c2fa8e24d60ab956eb56b76470b8fe94', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217135, '林梓朗', 'cc01a0032c2d0a7c0e8878a32da3b91e', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217136, '杨宗耀', 'f8b6a280cfce03d395577f90ddd9dfc7', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217137, '何诚', '1133086a43bc7ff335da471abacdee50', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217138, '钟俊钦', '713f3b03fabbf9e32d7f429af62597de', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217139, '张汭', '0eee844e5cc584b100a67e1bfa088328', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217140, '霍俊杰', '5266cc18c9ca58434e77c7fbfb9c094b', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217141, '薛泽鸿', '4aa1adddcbfd413a093a4dfed96e94a4', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217142, '陈柯良', '90278c6e53f342d4b5d3ad470e0b63c2', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217143, '伍育基', 'a562882417d5e7468ee496fee364f9f1', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217144, '赖绍良', 'e8c325bc32ce721b705547cf6fddccfc', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217145, '张运满', 'e61594d5538be66d90b118e231049066', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217146, '郑殷豪', '22ed174e07a57480e6ef3e3d1fef2920', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217147, '杨炀', 'd9d4c3ec6676d844c9cfe171d9811ee9', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217148, '吴祈桐', '840c0a454abaa7c291bd0fe6212b845d', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217149, '李伟健', '34502ce8a6e6b3d7f1480f27ed05d602', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217150, '李炳至', 'cc18b7ea44a4953c9880b7eb59153033', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217151, '陈景峰', 'c0789324f0d4dffedc35ae13c9a85cc7', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217152, '方炫凯', '6085adb1dc486ffa42def2b379887138', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217153, '张家沂', 'eafba67fa0ffcce3315df0f90cc70abe', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217154, '许森', '3d8d079c958cb57fca10ded8c9378433', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217155, '赖东其', '76f6ae80efd09b3fedd026ae185baf22', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217156, '石有健', 'c27e9f8e2b5a14313122dae2cdb5f09b', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217157, '黄康龙', '25a22c84b6045b298d667b6fa62c2dd5', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440217158, '陈静旖', '51e5674e55a0751bfe20f85ebdc48493', '男', '网络工程(网络设计与管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224101, '邹林开山', '945a9d963fe09477857ba733d6570216', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224103, '麦庭森', '7af785c1617bdffd23140c1c12dbbbe6', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224104, '林子铸', '185688485b1ecd6b2d1a34fd355876ae', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224105, '潘凯鹏', '7ef23bc290da6f807a4413f3a95cf435', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224106, '陈雄伟', '2d75a4c0b8e6e9fdcae749a0df681096', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224107, '梁家秋', 'e058f11dd67afa8c415ca73f35ee5f26', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224108, '刘海健', 'bb690686f3340324728c782eecc7df1e', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224109, '钟尚亮', '6afe8faa9bc9f2ed0586d061e0d75746', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224110, '罗钲', 'b894dce301f762591c45f17b76946664', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224111, '陈紫嘉', 'dab05a01ab1710998ef5098bd417ee5c', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224112, '杨培东', '74f702ba663bcde99d9fc2aab1bd2624', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224113, '刘仰辉', '7708f272cff20ad5c9f24a3986507e9d', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224114, '刘海滨', '483c9a52dd8af93f5149e34ed110391d', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224115, '周志雄', '2e6788cd1e551442c0b7551925bd578a', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224116, '何林燃', '31343684e833a947245fc8d99155f226', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224117, '梁少杰', 'de13502c62e8404f8405cc3aefb63f11', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224118, '朱其剑', 'a885c36d2f52378d3ff442a246fa2d7d', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224119, '张加发', '586809ecd625dd1b19d00f238d6ad581', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224120, '邓启朔', '7e2dd9047ba9fbd59568037942aa02dc', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224121, '王汶炫', '65341694bf2190cd85e0452c4da1dc67', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224122, '江琼', 'c0319e057bb1d29a3303a8f94630dce2', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224123, '严心仪', '21bf5bf3e9b6140d9e64eb320ca9cca8', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224124, '黄家淇', '1e013765abe6283b40ab7ddcdd1767f8', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224125, '罗文迪', '53bbd7da297f26a447dab99563823629', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224126, '张逢彦', 'f8e17bc5669589eb534be5dcfa454c1c', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224127, '周文康', '952e84ff35cc08b4938b26385eec9880', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224128, '蔡鹏程', '50a8caf59d0db2af091bf7743b541434', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224129, '李佳壕', 'eed98e8159c3228af522f63984788f13', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224130, '梁晓曼', '5b2c04a851e4cab8ff18f472f59da1ee', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224131, '胡伟良', 'd1c37e372d72292e547aa4cfa28cfc84', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224132, '陈宗炜', 'c8fb923aae57ebd9f95f73f225bc5dd9', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224133, '黎活平', '9c1450c07047f1c7e71d5db1f720dd35', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224134, '潘晓柯', '8f5a932ca6cffc162548ef2266ddb103', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224135, '王浩生', 'e6848926f8be443499eecfc3203f5878', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224136, '叶嘉福', '65391b9cf248580c5a33355de2bcd5fc', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224137, '赖伟健', '126d3ade63157cbe048f8fbf4540a7b2', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224138, '郑熙然', '91d462125db80e0ee212740847ba81bf', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224139, '曾昭富', 'af20d7638eefafb352d46286b1cc53d6', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224140, '旷鹏飞', '961a67b7383e5339be19843a394f07b0', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224141, '邓轩', 'bfe6c337713b8d049124b2afb2e476c6', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224142, '张海洋', '109aed9774f2144d67b4f1634216b759', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224143, '高若桓', 'e61f95031619aa378cd322f2b67f2716', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224144, '钟豪', '75d9dba45ce8a754e360f58a4fbcb714', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224145, '邓百均', 'eec7506b76c8f5e7be1ce50f5b211288', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224146, '易城满', '1a805d208b2464d16550448c39f72720', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224147, '吕梓炫', '65de1eea6520b875d0b40c773a837885', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224148, '吴世贤', '913b55e892bb957a62d52f6fe7d93354', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224149, '张钊', '80e6133f762f02ce7f895f4cb569793b', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224150, '钟汉文', 'a3bebfa0d2305725077b2c5ac4181aa8', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224151, '黎富新', 'f0ee9c89bc7568ad2223af2410503098', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224152, '莫真谦', '9b0511ddfe1711855776ab18d5666fb1', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224153, '程健', '5efd50670ac5619fac7cbbae325b542a', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224154, '刘文鑫', '374e785fab08f4223d7131b0b3e6359e', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224155, '陈文根', '604a81f67dbc7267cd83ed3e0bfc871e', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224156, '曾立', '1781048c7f64d0e5aa61b4a184af1b1d', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224158, '李志铖', 'd90caaacb045efc4aa6291a814fac677', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224159, '陈乐腾', '1a8116ade31ca0045161e6f9557137de', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224160, '欧阳炳俊', '557c593d60054b6dd6d8d13c73e524d5', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224162, '梁号乾', '868ca1e358205f0f5713df0fdf8c2afc', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224163, '何伟民', 'e55389d31af0aafcc7ae543df5b6911a', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224164, '孙名遥', 'dc4824368a82b405faf37d3c05ba41ba', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224165, '林铭聪', '70e9312762124f0e00d5acada1a1d781', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224166, '李嘉豪', 'b5570869795f058c990ec09ff513fc17', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224167, '林秉毅', 'be415186bd4b9a6e240bd2e9c75c5725', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224168, '梁铭贤', 'f5fd3874503fcec2ac7948d973266cad', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224169, '童晨熙', 'de1df8e5382cd57d2293251d1f47abe0', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224170, '徐嘉豪', '01eddb1168c45aabbfb708454f7f5631', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224171, '伍志成', '4bbe737e43dd0b1ef753ce299c22b1a9', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224172, '陈广辉', '85790cf6822c553eeab9dfecb1ee93ca', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224173, '黄俊杰', 'c36f4f772f9e5e9a4c48086b91479c46', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224174, '张伟强', '3c11d11eeaa3f537e8da5612fc9ac7e6', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224175, '廖志强', 'f9e6826e1517febe54039f76d7295ff8', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224176, '廖士航', '82877b34b2d2f14b63b9acc80de9510f', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224177, '黎卫家', '8b3ed479cbf2cc2b4ed17e20a6fc5743', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224178, '谭智杰', '49c2d28fecab83b8108f0c06e3ebf4d8', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224179, '阮诚宇', 'f3c5848fe76606471fe0f8d723c16767', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224180, '林镇城', 'e14a6831baafecfccbb92475a8fc59a5', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224201, '廖展雄', 'e135787e545678bbfe1c1dce30399de2', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224202, '叶楚炯', '8b036e0acae02863c84ba0c569efec7b', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224203, '梁泽华', 'da59e0a46f97323618eab244c0646ddd', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224204, '余德雄', '20612364e04344eda342d5e874d593fe', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224205, '梁展鹏', '02526c5442907df0a7f401fb3b2a3a79', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224206, '黄达聪', '5c51400e13a3148c1d6b3625b4722bba', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224207, '任焕恒', '03ffb01ac0278c1e2bd60e5f1aba30a1', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224208, '刘翔', 'bf75081de057f747076147f048df2d6d', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224209, '欧阳家豪', '58cf9f27e6e7aaaa5b79d51559e03d79', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224210, '莫润龙', '9e069b6ecde7d0b6b9a5159d5731ee7b', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224211, '林励志', '29839d84c4dcef96f002e1037ccd058a', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440224212, '付嗣凯', '9b8e7a2c1211e4ca8f72269886d1bedf', '男', '网络工程(网络安全技术)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225101, '李冬敏', '610cb25a3920ad34a2608a03d4a78bf5', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225102, '陈祖明', '3df19d3c2dc595a3d49184e3b606ef03', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225103, '卢新益', '14924f7bb2ad6700be13c043661714af', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225104, '陈晓琼', '7215b0395a8505c5e488a5268bf40752', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225105, '李泽飞', '1b8d8053d6821913cbf334486c180a37', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225106, '石嘉蓝', '7192fc70e9c6d1c4b187884304722b0f', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225107, '郑晓娜', '67f1e9661363bdab09195663b01c8491', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225108, '丁泽雄', '084ae8f19865c85f331d8eaaec9d76d8', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225109, '黎文富', 'b354f67ca797b3de84cca3ceaf8f8bdd', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225110, '冯超民', 'a923a2144af4373431c8baf4aa27d87e', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225111, '梁雅倩', '50eee0b2e9b00d14d97bcec062f30b27', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225112, '张玉玲', '8a11685121693285e33a3d6d27b65a18', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225113, '万振邦', '7bfd9491a600a7a1f8435b0eb9b9a750', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225114, '刘嘉聪', '9671a7caba35bcca1f3b76222cf3a75f', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225115, '叶韵婷', '3f0137cbf19888fea4fafda37b07b182', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225116, '邱礼耿', 'f0fb1d916467096387504041e51103d3', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225117, '梁圣旸', '2cc5de253a7008f882eced1f65c56866', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225118, '袁肇辉', '6e4522d668bc73578e7693b5b5aa364f', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225119, '李粲', '14641455decd129d08ba9175e0de2d4a', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225120, '叶惠欣', '8d1ab23352d1d11030ce3040d9a7317e', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225121, '何祥龙', '93bea3c0e95c297e861b4e425e40add4', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225122, '余梓佳', '0483f6b9f355ab469681ff6178f8c627', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225123, '阙瑞英', '195c1121683e4726a3be27462c175bdb', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225124, '徐辰利', '6dc6186147986dc7620d77e89fb0811d', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225125, '沈诗楷', '3dcb614702d905c303e539d7e54560f6', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225126, '蓝晓强', '6887fde118edc0a9f9e7a765349f345f', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225127, '唐浩源', 'ce6d6f624afd6c6d1e78a1aa61efa67d', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225128, '陈佳诚', '704367bd60ffbdf12860ba6e0069563e', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225129, '苏思维', '53a3871632ec07f7e1bcb3dc890fa198', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225130, '叶应新', '8c9bbb501bb1a29b53016fbf8e3c22e2', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225132, '李廷俊', 'abcce1e8da273a4a324899c0770e8999', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225133, '陈咏妍', 'be3adc4e013c891cc9fe555ac4a367fe', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225134, '谢智亮', '79ac639d583cbda3133545cad7e8305f', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225135, '何芷彤', '93b4831b56926a5a0482b9c2838bb2d4', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225136, '全冠儒', '7fe8ba767df544c9dee0777013ebb975', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225137, '黄晓彬', 'a2e101678d65bc38f3db4cb8dfc77dda', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225138, '陈俊豪', '2366826226f5dbd5e0055c2e49667375', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225139, '刘吉吉', '6f4eeab1ff3a5524a0581934ec3129f6', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225140, '吴俊达', '93b60d43da0435b32f9067b569f990be', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225141, '叶文锋', '79e56817d8ae68b9f78026387d2eb8f4', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225142, '廖茜瑶', '013e0408c9ff7d81c57b2889777557d7', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225143, '杨振腾', 'a04cce2a9c556242d5f69265e17c1e25', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225144, '何嘉意', 'f4a18560c940511b1fb0f284bad7eade', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225145, '张永发', 'cc651cd26d44d06e0e2de5a1d9a1906b', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225146, '李剑威', '90a99f13c40113df6e9f82e222d108d7', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225147, '罗锐', 'd674b4c82a11a0617bc131bf424eb8f4', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225148, '张俊权', '5feb28ae6e9831a284833e762a3d93ff', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225149, '蚁涛', '7cb1711d5aebdeb31d7f354c9a89e297', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225150, '郑如庆', '2f85f8a47264452b73c1e20ce039ecff', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225151, '翁俊杰', '1691625a0390b7c4482e63871b9e3364', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225152, '陈晓纯', '125e7ef7eee582d59aae7e7bad59b0ad', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225153, '陈成峰', '24568b5a1694447d340564bae54073d5', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225154, '王心怡', '017be6cc1473cf17daaa073a1ab33c31', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225155, '邓英庄', '5fd1fb9b090eebf2e805412bfbbdfe7a', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225156, '唐耀临', '05e5d7bac4ce8119ce32ea7c4502be1c', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225157, '陈铭易', '9763efbd97744d93a341a87bee10a586', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225158, '李健安', '32c2f1fb591209275f0e394b4cfa34a4', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225159, '曾博', '6de6343d0ebeedb6847668e1f1d4d394', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225160, '黄子佳', '8e5a929dcf60d07f6e41bdf9aa669dde', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225161, '蔡良楷', 'c5695e0dfd15b4d5a0ca1b2b55d8ef0b', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225162, '黄鸿', '890e77b53e7c892b5cefc6919844fcde', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225163, '罗智锋', '43ffda3c20542f31dbc4d54b2c25d168', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225164, '黄裕麟', '1a939a0f4878bf266f740793fd857dcc', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225165, '黄晓仪', '812cd1a35289fa98130b678ed78a6714', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225166, '陈思思', '63c9a7c5acdec6ca0579a2889df78445', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225167, '李颖鸿', 'f013c167d2d0cca810f031ec4703dafe', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225168, '麦嘉倩', '06aa4e754da0c00a757537b5b1649ba1', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225169, '刘智聪', '328630619cd0ac937cd9cdbb7e6bc63a', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225170, '张健聪', '0a64f834e7efb712e1cecf380b5a00ba', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225171, '杨华成', '10ede458db48eb4cac43a28efd6554b9', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225172, '陈日明', '9ecf56c1e71d180b728d264dba19aeec', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225173, '陈浩宇', '768a465f317f1d3482088748248a0b67', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225174, '符峰菁', 'd27a2837e4d24888b22914c2f092bd6a', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225175, '方秋都', 'adaf42742ec1add80021b395a3f40421', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225176, '蔡大烁', 'c20a51d3a34030d394b55bb17b2db93a', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225177, '沈利康', '475e64541e282e1d261a29b7ccc7ecdf', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440225178, '黄光智', '35edc415c3b5e3430073defb67c4f0b8', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226101, '苏明君', '0a201ea91865a1b0446687166dd7560e', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226102, '卜焱圣', 'fcf1dea65f78f19473a86c0e202cc0e1', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226103, '彭飞健', '898b93d73f157f259191fba42449c9e1', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226104, '陈佩莹', 'c99b115b4d172a8a174132db26d3d2cf', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226105, '林鸿嘉', '850f476d3d7f37bc474c90ff6a4a28ac', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226106, '王健华', 'cd23962669cff43749b395500e1d3c18', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226107, '黄明辉', 'b91dc642a92c1d8a3f3b406944885977', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226109, '范远展', 'bca2f3a9c0a37adc89d9f1cb213f5ca5', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226110, '陈景富', '0487bc8f6852f45e1ee0d8270f94027f', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226111, '谢永杰', '21a2cba4fa835cbacc2dc04c1bd6cadd', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226112, '郑思远', '59aad073678e91a69e4ba69bf861b762', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226113, '吴婕', '1cb002e459124d5e3df666597a68952a', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226114, '陈柏新', '9a9d0b5adcf50a907180218a9b3f7b53', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226115, '林灿华', 'e38d2a7e32e47e66c1aa7be0293ec928', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226116, '何学敏', 'c11f043c52a578292664eb17df974405', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226117, '梁峻荣', 'd3ed72eef58ec4a7d4dccb1fb05e79c7', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226118, '林润铿', 'eb38e3c2b7a05a748200f4ca2d54250d', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226119, '陈业平', 'b04450604104719451d6bcd81ee39035', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226120, '赖俊元', '3fb2413e45d9f42a04a5588f3bdffa94', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226121, '王嘉乐', '4c902cb9962c7da8564792d74c6e751c', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226122, '邹呈聪', 'b5c04c578fc1398bc1f782087af2c161', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226123, '陈家亮', '89fec86e2a2124caeb4bda10b79009b3', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226124, '黄雅怡', '71ab5fabd5c090a8480e12abb4166b9d', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226125, '刘健澄', '1594b5bb8a50959520a81ff87c5d066b', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226126, '吴文恒', '899c23faa3d1e09af23296b3efff6888', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226127, '黄俊宇', '8d9af08080c2e4196126da7a0fc36b57', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226128, '郑宏浩', '5765b5731bc2b2cc710741374025c3ac', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226129, '冯嘉俊', 'a34ad571cd6b401471f2519400b76a3b', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226130, '林琪智', '1d23a4aa23a73fa33cedaa37853321e3', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226131, '何振豪', 'a1d3acf306eeb268a9193ea78469478d', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226132, '卢伟恒', '975eb0e4f3386c84a7fb58c72daca2ef', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226133, '吴海燕', '941f894452ea978e7925e666456b124c', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226134, '卓炜炜', '558997780727d238d1f3072740a8bf91', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226135, '邝婷', '5b4a6aa48a338e9c1c200f114238916b', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226136, '朱正', '329d0a80762565a0c5997983ab03f1be', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226137, '余美娇', 'fe76e44b82b0b65700975b536fe91719', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226138, '范国良', '77c490adc01cf7fd3bc747949bbe323a', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226139, '陈俊豪', '307db3bad45082690ba2aacb9298b33b', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226140, '黎国坡', '8817db27bef98d82161a55daf27194d2', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226141, '刘德沐', 'cc88e958612f4c74b7b41b0149894df7', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226142, '吴捷威', '3e293dd87310fffe7e0a1eb0e2a8de42', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226143, '邓杰', '6605d8b3d93c42dd71c6b915e4379984', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226144, '严建勇', '235c55140bd1ec3292ae745a3e6e5cd4', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226145, '赵锦涛', '9247b108457197685ffbbd772afd910f', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226146, '梁建锟', 'db5a54bdeec146698e2a0c2412615a88', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226147, '黄志颖', '50f9c48615be0b598d922fb0e04e70d8', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226148, '邓凌霄', 'f5534b9d0fb74fc74d147e2587172fde', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226149, '郑俊海', 'dbeeef22b0333f6053222f8e651f0c6c', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, '1', '1', NULL, NULL, 2018),
(1440226150, '罗浩琳', 'ee12fe69b60e1e47e4123a09c2e07fb0', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226151, '简升朗', '8577a5173244a1f2fc0302c0260b430d', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226152, '刘嘉豪', 'af2e88232925b017055d8398d0edf178', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226153, '廖荣森', '9044182d4ac3640e0dd0dca21c79564b', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226154, '钟鸣', 'e7a5f0342eaa5f1761ab149b23acc592', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226155, '冯景平', '30b3a83c85af59a94bc045c3a995a72b', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226156, '陈丰平', 'b11391ebebe627ed6ff11cea2fd0d974', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226157, '曾景威', '7b59dfc5e64ab9977f832d331577ee97', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226158, '陈智聪', '1e4754e16a6cb7c08ad11060e852c674', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226159, '徐伟伦', 'a472a6ae29d2759b2380ea7124a467ae', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226160, '连达', '301a57160bb81555ce34423e64a5b163', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226161, '陈琳', '9c47caa467c99a7c8d685a54909da363', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226162, '曾维南', '0fac75c412a3fcec055733bea231d5a1', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226163, '卢毅', '09f6035fc7afad6f4cfd2a5b2ed7bafd', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226164, '何健明', 'c164fadedb0b8335ef02f5cd25ac0e8d', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226165, '郭家俊', '472d1a76f6cb0741be4d8f3a8b1a288b', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226166, '张程', 'abbf9724b8e42743a3b6dc2b89f57e9e', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226167, '何乐为', '56359e96b15e110a433813509c8ca194', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226168, '王祥羽', 'd366fe54fbb2196297d7a9550f4d8939', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226169, '陈育涛', '3b74d34aadcfbb30ed8aba6f217e3f5c', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226170, '郑伟健', '286f6c818360f2f6785d643d211ed447', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226171, '杨宗晓', '04d75ca2fc047cf4300a3be5c2e6709c', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440226172, '张骏', 'a9e6ad28018c1771897bcec1a3703cac', '男', '信息管理与信息系统(信息系统开发) ', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227101, '江子昂', '9cd5a36424f248cdfe5d9d7625d93ffe', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227102, '张映静', 'b74889fb81250ea42dc608d656ac00c7', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227103, '杨晓纯', '3921b85716c3ceca843ea51fa7262ccc', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227104, '文欣然', '4fded12fdfaafd26ac459a45b5c1e419', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227105, '吴俊颖', 'f541fc51d65682df6882a2f7f71c0446', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227106, '谢钰琳', 'b70f013fe1dd3b376e5ac7d219303072', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227107, '林洁', '752811f611f2f4e8154e3e6cf3bee0bd', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227108, '袁文乐', 'aad1e6780fa127dbf601ef84535c7baf', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227110, '李卓伦', '5df27943a41d169ff68a2232be890d3b', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227111, '李雪玲', '64c3003d0a5542566a0199e418dcb63e', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227112, '吕卓运', 'a00aecec11076e773f99ea3793fb72b3', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227114, '李颖', '48bc9702f568d8b6be8e2a371e78c088', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227115, '谭智浩', 'b13e338329259eeeceb56b11682b6afa', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227116, '林玲', 'fae14006ab7e85dfe7f321475071a07c', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227117, '李晓红', 'c1f624ff59715da42eea548cab598dc3', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227118, '徐湄怡', '4cf2bb9b71e4922a9288c5314b95edaa', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227119, '邓碧玲', 'e3845c87bc1acb197df7aa913c34d64d', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227120, '侯玥', '3bb428f99b6d273742e80762d9f3e4f0', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227121, '甘海琼', '4781701e7ce3128bc716a34876fc2e45', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227122, '钟家振', '080a7888cca41ccc4284deebd945d737', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227123, '梁嘉雯', '4dda315fb8273e18573848359b535894', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227124, '罗华安', 'f3d39ed76c0f277ccd2729e61bb15920', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227125, '梁纪贤', 'fceaec651a6fdf454bae6e446055041e', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227126, '姚涛', '91e1b56b58b66ee21844f3c2a2170026', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227127, '邓广泉', 'aff895a618fe6bd8c86d8994fa64216d', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227128, '钟雯意', 'fcd173c97d76992a49036cd78ad8079f', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227129, '林展程', 'c1d7a2d898f898b21c949d45f088072f', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227130, '吴琛琛', '8d77e454ffa85f0d73f752ee31fd084f', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227131, '林慧珊', '3e35f1f6258c6f9a4f2e3bf273045258', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227132, '钟紫盈', '10cbd5b3360c780f7e4948659df7bfad', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227133, '丁玉敏', '8157d1fd0498111af2d2f910ff5db37a', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227134, '邓雯怡', '66a9566f5a335d1bfb7166ff02ad1769', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018);
INSERT INTO `think_student` (`Snum`, `Sname`, `pwd`, `sex`, `class`, `phone`, `email`, `qq`, `denfense_status`, `denfense_allocation`, `taskbook`, `denfense_draft`, `year`) VALUES
(1440227135, '郑丽雅', 'a9c78f21c453dee1d1cb39dea0822a79', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227136, '刘炯轩', '5624eb523f95e4dfb1dc169b16c9dddc', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227137, '张玉海', 'c3cf7d93def56f8979f2ce58b4fc5b61', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227138, '蔡芷茹', 'a25b3c327a83f0dfed4064855b3c8a0c', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227139, '吴耀明', 'b1fa6e0e75687354b76aad00a8b1d5c3', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227140, '曹芷榕', 'a843783d496bc7f66c5a3c5b98e2350a', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227141, '冯家瑶', '90a456a94c7d0eb80f7d82209692f0e1', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227142, '黎嘉威', 'd354b8131a34381898761f2e107b2cd7', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227143, '麦文辉', 'c4e26f7e6b332853b5a731c850cb1101', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227144, '封东彪', 'eaf1cae353b3cf836e15795235604d8f', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227145, '黄惠平', '7637aac2c2e2e04993b95d8b2a870d34', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227146, '杨文凌', '0ca5ccd171a1450bfaad7ea29f9e0c93', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227147, '黄耀宏', '3ad283565ce6577028f2c3dd0888f828', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227148, '何雪莉', '7c319187b21224663d8d18c3dc340e57', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227149, '谢志鹏', '454462ad16e1e4db788dbd956f1e456e', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227150, '薛惠雪', '320f205e6de4fda397fd0473baced4b2', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227151, '梁建城', '35d8043647d2d01b1ed66e0cb2a527ce', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227153, '莫秀茹', '123831f62eaa1aeb1a7334c4f0b6620a', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227154, '叶晓婷', '345f37b8450238d658d388a3c12a373b', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227155, '谢忠浩', 'a77308456f829285b948e84bc9e3c1dd', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227157, '林晓婵', 'ee1bb14bab5a405091e26e1ff550a3a0', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227158, '吴庭嘉', 'c0f82a316d5aafbf0690779090c2c977', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227159, '杨仪', 'b7ae07a6e796d3fa686732fd29112101', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227160, '姚家伟', '83b9430d8f2b387c44c8b257a873616f', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227161, '岑杜威', '898769366c59c8d9be25454b94b4d6be', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440227162, '王健华', '1f88f9af38df3c680eb52f9b97726326', '男', '信息管理与信息系统(信息资源管理)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229101, '罗凯', '2a2c40f9e3d0b438af68c809433209af', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229102, '范永康', '9593aada26f35606a9e058e421a89f53', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229103, '许国祥', '23a653d2a502319157ae66b206884030', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229104, '郭连伟', '7c2b10c81298d5af3bde0b958172b035', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229105, '马焰忠', '1c237985f142915f42be4d5efddc7e88', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229106, '郑爱国', '12feb58e1cd4a6f548e9f2c1a89f19c4', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229107, '王嘉维', 'd11e4a9f6862638c172710ad77d9f2ae', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229108, '刘世豪', 'a9d68ddd8ed424fff397c0f115bfb5d9', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229109, '卢伯俊', 'ec7f6b29d1688acb46487cab9b034f9a', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229110, '朱智豪', '812382d5ad1cbf53ab4aa16df8cf3c6e', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229111, '赵健翔', '601d53a28096483115ab67219d91ee19', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229113, '冯嘉钊', '06988cacffe820da19b5a369e8886b9f', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229114, '骆健行', '2157c60e76d2970d586875954e3f4dee', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229115, '容淑俞', '58b914905477f6c0e8da9d24b3a0a16d', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229116, '张德成', '4bad2005602a34d2e7d37c11b6b4f9d6', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229118, '黎桂荣', 'ee10093ab6a6c558937c0202ac75496c', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229119, '范平妮', 'af077a3063313dc91463c8a3552ce742', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229120, '曾业成', '9308e24d3ed8a5f84ef5b304205a94f8', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229121, '张玉莹', '3c4cbc17b459de86661918087fcfe9aa', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229122, '袁鸿宝', '669efd01700fff19bdeef1f632138b6c', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229123, '曹原志', '7c0897714ae506fd0e007bc9cf42b632', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229124, '梁天硕', '09de1a4236091edb94c062e42facb5e9', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229125, '李健斌', '8c32cb0e7cfe820e21515231d5e310c2', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229128, '杨文涵', '4ed591b5784adce7c0358fcf580b1bd0', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229129, '庄健龙', 'ea26181a67d306472fc58d87a37d13b3', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229130, '陈获胜', 'ea6d3b2488e18b98c7f9c028315d9095', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440229131, '彭子俊', '30c6d0eed8e4cff240800d61b48d762e', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440516123, '陈映君', 'f8fe08a406c2abef506227a14674d3af', '男', '网络工程(网络多媒体)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018),
(1440518130, '叶嘉琪', '1cbcf560fb8854a16d0b80b9a59ac65f', '男', '网络工程(网络传播与商务网站设计)', '123123', 'fhsdjakfha@qq.com', 489641865, NULL, '0', NULL, NULL, 2018);

-- --------------------------------------------------------

--
-- 表的结构 `think_teacher`
--

DROP TABLE IF EXISTS `think_teacher`;
CREATE TABLE IF NOT EXISTS `think_teacher` (
  `Tnum` char(4) NOT NULL,
  `Tname` varchar(10) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `depart` varchar(10) DEFAULT NULL COMMENT '系别',
  `direction` varchar(20) DEFAULT NULL COMMENT '研究方向',
  `phone` varchar(15) DEFAULT NULL,
  `startdate` varchar(10) DEFAULT NULL COMMENT '入职时间',
  `email` varchar(30) DEFAULT NULL,
  `qq` varchar(15) DEFAULT NULL,
  `Ttext` varchar(500) DEFAULT NULL COMMENT '''教师简介''',
  `title` varchar(10) DEFAULT NULL COMMENT '''职称''',
  `ERG_group` int(11) NOT NULL COMMENT '教研室组别',
  PRIMARY KEY (`Tnum`),
  KEY `fk_think_teacher_think_ERG1_idx` (`ERG_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_teacher`
--

INSERT INTO `think_teacher` (`Tnum`, `Tname`, `pwd`, `depart`, `direction`, `phone`, `startdate`, `email`, `qq`, `Ttext`, `title`, `ERG_group`) VALUES
('0230', '黄君强', 'a0cbc80a3d38f3a96e7db2bb7c6ac0f0', '网络技术系', NULL, NULL, '37816', NULL, NULL, '讲师', '讲师', 1),
('0296', '李毓丽', '5dd8bb90859a24ac3d378de46f6a5748', '网络技术系', NULL, NULL, '37820', NULL, NULL, '讲师', '讲师', 2),
('0342', '张明军', '7e1c3595ce5ff1486f6bb5ed9db2041c', '网络技术系', NULL, NULL, '37837', NULL, NULL, '讲师', '讲师', 3),
('0403', '邹延平', '7a22db527994be0348090a0f096a38ea', '网络技术系', NULL, NULL, '37841', NULL, NULL, '讲师', '讲师', 1),
('0633', '周伟', 'deb1ed765841ce30190683e166259c55', '网络技术系', NULL, NULL, '37840', NULL, NULL, '讲师', '讲师', 1),
('0773', '叶小艳', 'bc1b2b7a65cbde9e56dfe6c57759d579', '网络技术系', NULL, NULL, '37834', NULL, NULL, '讲师', '讲师', 3),
('0812', '彭勇', '9050e3573b7a8bc64d6c3cd727b3efbb', '网络技术系', NULL, NULL, '37826', NULL, NULL, '讲师', '讲师', 2),
('0820', '李舟明', '1051d584fa0c586606f5b985893681cd', '网络技术系', NULL, NULL, '37821', NULL, NULL, '讲师', '讲师', 1),
('1031', '王影', '5585d37cc32c56c471704fe6bbccd8f3', '网络技术系', NULL, NULL, '37832', NULL, NULL, '讲师', '讲师', 1),
('1035', '田宏政', 'bfaaaca9ea7441c072a87c5b66391233', '网络技术系', NULL, NULL, '37830', NULL, NULL, '讲师', '讲师', 1),
('1075', '安明忠', '912f7718f913de5c2acd04d9eaf3a09a', '网络技术系', NULL, NULL, '37810', NULL, NULL, '讲师', '讲师', 2),
('1090', '覃忠台', 'b03ba0c98d0f0bc9a864e0288b72fd92', '网络技术系', NULL, NULL, '37809.12', NULL, NULL, '讲师', '讲师', 2),
('1104', '滕浩群', 'fb37c370f22fe282ab9c46e2531d198d', '网络技术系', NULL, NULL, '37829', NULL, NULL, '讲师', '讲师', 1),
('1156', '俞文静', '8464fcf660043580ae4b3ed0af246865', '网络技术系', NULL, NULL, '37835', NULL, NULL, '讲师', '讲师', 3),
('1189', '向雄', '0e671db9a9dfcaca40813c6134c37d0b', '网络技术系', NULL, NULL, '37833', NULL, NULL, '讲师', '讲师', 2),
('1190', '孙勇毅', '7356aeb053b488438026178d3ec1fd0c', '网络技术系', NULL, NULL, '37828', NULL, NULL, '讲师', '讲师', 1),
('1213', '耿晓利', '3e5239b4e4edc1ff5be01ad7206713a1', '网络技术系', NULL, NULL, '37814', NULL, NULL, '讲师', '讲师', 3),
('1269', '周化', '6fe39412d1b521f161d22cfebbbceeb1', '网络技术系', NULL, NULL, '37839', NULL, NULL, '讲师', '讲师', 3),
('1432', '张芒', 'f7a14c62cfe0cd779c6526c40055ce73', '网络技术系', NULL, NULL, '37836', NULL, NULL, '讲师', '讲师', 3),
('1470', '苏进胜', '0124387ee8d3365fea58947400bcb129', '网络技术系', NULL, NULL, '37827', NULL, NULL, '讲师', '讲师', 2),
('1581', '甘卫民', '0129366568d60233081528ea8270bca6', '网络技术系', NULL, NULL, '37813', NULL, NULL, '讲师', '讲师', 2),
('1583', '廖景荣', '5e44593036cda122f3ed77837201eab5', '网络技术系', NULL, NULL, '37822', NULL, NULL, '讲师', '讲师', 1),
('1584', '李岸芩', '3a66aed33987b5a10d78822ddbff7c0d', '网络技术系', NULL, NULL, '37818', NULL, NULL, '讲师', '讲师', 2),
('1585', '赵莲芬', 'ac1d6390f491e900c4c287a46ad3ed4b', '网络技术系', NULL, NULL, '37838', NULL, NULL, '讲师', '讲师', 2),
('1655', '刘翔', '0fc6181fe81853a87119582e492eb063', '网络技术系', NULL, NULL, '37825', NULL, NULL, '讲师', '讲师', 1),
('1656', '王健', '053c4570af102649fc2f8d455e5470e6', '网络技术系', NULL, NULL, '37831', NULL, NULL, '讲师', '讲师', 1),
('1707', '李检辉', '4123dd47366ba5471cc53fd0ed3cf5a9', '网络技术系', NULL, NULL, '37819', NULL, NULL, '讲师', '讲师', 1),
('1708', '黄小平', '8847685ab8ba5120de74c793acf99711', '网络技术系', NULL, NULL, '37817', NULL, NULL, '讲师', '讲师', 2),
('1746', '崔继', '1bd3178d1c706a42c8eda57ff9a27c42', '网络技术系', NULL, NULL, '37812', NULL, NULL, '讲师', '讲师', 1),
('1812', '胡军成', '655d940a681815791b2483dd72f063c5', '网络技术系', NULL, NULL, '37815', NULL, NULL, '讲师', '讲师', 1),
('1813', '刘鸣', '1d0354eadf247c4cdc35a58209eca8cd', '网络技术系', NULL, NULL, '37824', NULL, NULL, '讲师', '讲师', 2),
('1837', '陈淋', '78c89075c7bd8d1c3a1495c702bd2059', '网络技术系', NULL, NULL, '37811', NULL, NULL, '讲师', '讲师', 3),
('1879', '凌友良', '1f195e940835a8309d695696d44d50ca', '网络技术系', NULL, NULL, '37823', NULL, NULL, '讲师', '讲师', 1);

-- --------------------------------------------------------

--
-- 表的结构 `think_topic`
--

DROP TABLE IF EXISTS `think_topic`;
CREATE TABLE IF NOT EXISTS `think_topic` (
  `Cnum` int(11) NOT NULL AUTO_INCREMENT,
  `Cname` varchar(20) NOT NULL,
  `Ctype` varchar(4) NOT NULL,
  `Csource` varchar(10) NOT NULL COMMENT '''课题类别''',
  `Ctext` varchar(500) NOT NULL COMMENT '''课题简介''',
  `status` varchar(45) NOT NULL COMMENT '课题状态 值为0未选 值为1已选',
  `year` int(11) NOT NULL,
  `Tnum` char(4) NOT NULL,
  `ERG_group` int(11) NOT NULL,
  PRIMARY KEY (`Cnum`),
  KEY `fk_think_topic_think_config1_idx` (`year`),
  KEY `fk_think_topic_think_teacher1_idx` (`Tnum`),
  KEY `fk_think_topic_think_ERG1_idx` (`ERG_group`)
) ENGINE=InnoDB AUTO_INCREMENT=1953 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_topic`
--

INSERT INTO `think_topic` (`Cnum`, `Cname`, `Ctype`, `Csource`, `Ctext`, `status`, `year`, `Tnum`, `ERG_group`) VALUES
(1849, 'CLOUDSTACK企业信息平台扩展设计', '设计', '自拟', '1', '0', 2018, '1075', 2),
(1850, '高可用HAproxy+KeepAlive', '设计', '自拟', '1', '0', 2018, '1075', 2),
(1851, '广州小码哥科技有限公司云平台设计方案', '设计', '自拟', '1', '0', 2018, '1075', 2),
(1852, 'BJ银行数据容灾备份系统研究与设计', '设计', '自拟', '1', '0', 2018, '1075', 2),
(1853, '企业NGINX+Keepalived系统', '设计', '自拟', '1', '0', 2018, '1075', 2),
(1854, '华软学院开源CDN技术学习系统设计与实现', '设计', '科研', '1', '0', 2018, '1075', 2),
(1855, '基于情感词典的酒店评论情感分析研究', '设计', '自拟', '1', '0', 2018, '1837', 3),
(1856, '基于PHP音乐教学网站的设计与开发', '设计', '自拟', '1', '0', 2018, '1837', 3),
(1857, '企业旅游定制微信小程序设计与开发', '设计', '自拟', '1', '0', 2018, '1837', 3),
(1858, '虚拟化技术及应用（3）', '设计', '自拟', '1', '0', 2018, '1746', 1),
(1859, '某一种网络安全技术的理论研究', '设计', '科研', '1', '0', 2018, '1746', 1),
(1860, '虚拟化技术及应用（2）', '设计', '自拟', '1', '0', 2018, '1746', 1),
(1861, '基于BS模式下校友信息管理系统的设计与实', '设计', '自拟', '1', '0', 2018, '1581', 2),
(1862, '基于JQuery框架的房产信息网的设计与', '设计', '生产', '1', '0', 2018, '1581', 2),
(1863, '基于ASP.NET的学术会议一站式服务平', '设计', '生产', '1', '0', 2018, '1581', 2),
(1864, '乐学慕课网的设计与实现', '设计', '自拟', '2', '0', 2018, '1213', 3),
(1865, '粤运动网站的设计与实现', '设计', '自拟', '1', '0', 2018, '1213', 3),
(1866, '搞得掂房屋服务app的设计与实现', '设计', '自拟', '1', '0', 2018, '1213', 3),
(1867, '五子棋人机对弈平台的设计与实现', '设计', '自拟', '1', '0', 2018, '1812', 1),
(1868, '市场历史行情系统的设计与实现', '设计', '自拟', '1', '0', 2018, '1812', 1),
(1869, '新闻爬虫系统的设计与实现', '设计', '自拟', '1', '0', 2018, '1812', 1),
(1870, '基于ASP.NET的网上电子商城的设计与', '设计', '自拟', '1', '0', 2018, '0230', 1),
(1871, '基于ASP.NET的网上订座餐厅管理系统', '设计', '自拟', '1', '0', 2018, '0230', 1),
(1872, '简瓷良品瓷砖销售管理系统的设计与实现', '设计', '科研', '1', '0', 2018, '0230', 1),
(1873, '惠州平安山度假区旅游网站的设计与实现', '设计', '自拟', '1', '1', 2018, '1708', 2),
(1874, '竞技类游戏论坛的设计与实现', '设计', '自拟', '1', '0', 2018, '1708', 2),
(1875, '平安山餐饮食堂管理信息系统设计与实现', '设计', '自拟', '1', '0', 2018, '1708', 2),
(1876, '多特箱包移动购物商城的设计与实现', '设计', '生产', '1', '0', 2018, '1584', 2),
(1877, '基于微信的医疗器械咨询小程序的设计与开发', '设计', '自拟', '1', '0', 2018, '1584', 2),
(1878, '英莱芬洗护产品商城网站的设计与实现', '设计', '生产', '1', '0', 2018, '1584', 2),
(1879, '基于java的i资源共享平台的设计与实现', '设计', '自拟', '1', '0', 2018, '1707', 1),
(1880, '基于windows的防java应用程序反', '设计', '自拟', '1', '0', 2018, '1707', 1),
(1881, '基于iOS 平台的“特别省钱”导购APP', '设计', '自拟', '1', '0', 2018, '1707', 1),
(1882, '移动端个人词典日志共享平台建设', '设计', '自拟', '1', '0', 2018, '0296', 2),
(1883, '外卖系统商家APP设计与实现', '设计', '自拟', '1', '0', 2018, '0296', 2),
(1884, '威客百单网在线交易平台建设', '设计', '自拟', '1', '0', 2018, '0296', 2),
(1885, '大学生观影的媒介依赖与习惯的分析与研究', '设计', '自拟', '1', '0', 2018, '0820', 1),
(1886, '针对数据分析岗位招聘需求的分析与研究', '设计', '自拟', '1', '0', 2018, '0820', 1),
(1887, '关于星巴克在中国选址与分布的分析与研究', '设计', '自拟', '1', '0', 2018, '0820', 1),
(1888, 'B/S应用架构的MVC分析', '设计', '科研', '1', '0', 2018, '1583', 1),
(1889, '基于Laravel架构电脑外设电商网站设', '设计', '自拟', '1', '0', 2018, '1583', 1),
(1890, 'XXX商城网站的设计与实现', '设计', '自拟', '1', '0', 2018, '1583', 1),
(1891, '茶语电子商务购物网站设计', '设计', '自拟', '1', '0', 2018, '1879', 1),
(1892, '网上商店系统的设计与实现', '设计', '自拟', '1', '0', 2018, '1879', 1),
(1893, '论计算机网络的安全性设计', '设计', '自拟', '1', '0', 2018, '1879', 1),
(1894, '“视享”视频交流网站的设计与实现', '设计', '自拟', '1', '0', 2018, '1813', 2),
(1895, '“索科”足球装备网上商城的设计与实现', '设计', '自拟', '1', '0', 2018, '1813', 2),
(1896, '“Record”摄影交流网站的设计与实现', '设计', '自拟', '1', '0', 2018, '1813', 2),
(1897, 'Sqlmap实践研究', '设计', '科研', '1', '0', 2018, '1655', 1),
(1898, '大数据安全研究', '设计', '科研', '1', '0', 2018, '1655', 1),
(1899, '安卓APP漏洞挖掘', '设计', '科研', '1', '0', 2018, '1655', 1),
(1900, '酒店综合布线系统设计', '设计', '生产', '1', '0', 2018, '0812', 2),
(1901, '大型园区综合布线方案设计', '设计', '生产', '1', '0', 2018, '0812', 2),
(1902, '大型企业无线办公WLAN解决方案', '设计', '生产', '1', '0', 2018, '0812', 2),
(1903, '岭南风情网的设计与实现', '设计', '自拟', '1', '0', 2018, '1470', 2),
(1904, '温馨港湾（家族网）的设计与实现', '设计', '自拟', '1', '0', 2018, '1470', 2),
(1905, '51简谱网站的设计与实现', '设计', '自拟', '1', '0', 2018, '1470', 2),
(1906, '基于linux平台的WEB安全设计与实现', '设计', '自拟', '1', '0', 2018, '1190', 1),
(1907, '基于linux平台的FTP服务器安全设计', '设计', '自拟', '1', '0', 2018, '1190', 1),
(1908, '基于linux平台的电子邮件服务器安全技', '设计', '自拟', '1', '0', 2018, '1190', 1),
(1909, '红酒电商网站移动端的设计与实现', '设计', '自拟', '1', '0', 2018, '1090', 2),
(1910, '特步鞋在线商城的设计与实现', '设计', '自拟', '1', '0', 2018, '1090', 2),
(1911, '零食之家在线商城的设计与实现', '设计', '自拟', '1', '0', 2018, '1090', 2),
(1912, '《绝地求生》常用枪支讲解视频', '设计', '自拟', '1', '0', 2018, '1104', 1),
(1913, '《抵制道德绑架》宣传片的设计与制作', '设计', '自拟', '1', '0', 2018, '1104', 1),
(1914, '《抵制道德绑架》宣传片的设计与制作', '设计', '自拟', '1', '0', 2018, '1104', 1),
(1915, '《猫咪饲养小课堂》微课的设计与实现', '设计', '自拟', '1', '0', 2018, '1104', 1),
(1916, '针对系统漏洞的渗透攻击及其防范技术', '设计', '自拟', '1', '0', 2018, '1035', 1),
(1917, '网络病毒分析及其防范技术', '设计', '自拟', '1', '0', 2018, '1035', 1),
(1918, '权限提升技术在网络攻击中的研究与应用', '设计', '自拟', '1', '0', 2018, '1035', 1),
(1919, '高校教学辅助系统的设计与实现', '设计', '生产', '1', '0', 2018, '1656', 1),
(1920, '旅游公司OA系统的设计与实现', '设计', '生产', '1', '0', 2018, '1656', 1),
(1921, '基于ERP平台供应链管理系统的设计与实现', '设计', '生产', '1', '0', 2018, '1656', 1),
(1922, '基于flash的交互型幼儿启蒙软件设计—', '设计', '生产', '1', '0', 2018, '1031', 1),
(1923, '基于flash的中学物理实验设计', '设计', '生产', '1', '0', 2018, '1031', 1),
(1924, '基于flash的交互型幼儿启蒙软件设计—', '设计', '生产', '1', '0', 2018, '1031', 1),
(1925, '基于GRE over IPSec的PAT', '设计', '自拟', '1', '0', 2018, '1189', 2),
(1926, '基于Java的纺织品销售管理客户端的设计', '设计', '自拟', '1', '0', 2018, '1189', 2),
(1927, '基于MPLS VPN的多局域网互联方案设', '设计', '自拟', '1', '0', 2018, '1189', 2),
(1928, '基于MVC模式的网上招聘系统的设计与实现', '设计', '自拟', '1', '0', 2018, '0773', 3),
(1929, '基于ASP.NET的企业办公自动化系统的', '设计', '自拟', '1', '0', 2018, '0773', 3),
(1930, '基于柔性流程及表单的OA系统设计与实现', '设计', '自拟', '1', '0', 2018, '0773', 3),
(1931, '东莞钜标自动化设备有限公司网站设计与实现', '设计', '自拟', '1', '1', 2018, '1156', 3),
(1932, '深圳距城自动化设备有限公司网站设计与实现', '设计', '自拟', '1', '0', 2018, '1156', 3),
(1933, '“赫莲娜”旗舰店电子商务网站设计与实现', '设计', '自拟', '1', '0', 2018, '1156', 3),
(1934, '基于BS架构的学车报名系统的设计与实现', '设计', '生产', '1', '0', 2018, '1432', 3),
(1935, '学生宿舍信息管理系统规划与设计', '设计', '生产', '1', '0', 2018, '1432', 3),
(1936, '中小型超市进销存管理系统的规划与设计', '设计', '自拟', '1', '0', 2018, '1432', 3),
(1937, '图像分享及标注系统的设计与实现', '设计', '自拟', '1', '0', 2018, '0342', 3),
(1939, '农技推广网站的设计与实现', '设计', '科研', '1', '0', 2018, '0342', 3),
(1940, '基于PHP的在线视频教学网站的设计与实现', '设计', '生产', '1', '0', 2018, '0342', 3),
(1941, '基于Vue框架的音乐播放器WebAPP的', '设计', '自拟', '1', '0', 2018, '1585', 2),
(1942, '阿四蛋糕店管理系统的设计与实现', '设计', '自拟', '1', '0', 2018, '1585', 2),
(1943, '基于J2EE的OA办公自动化系统的设计与', '设计', '自拟', '1', '0', 2018, '1585', 2),
(1944, '基于正则表达式匹配的通用论坛文本提取算法', '设计', '科研', '1', '0', 2018, '1269', 3),
(1945, '基于文本内容关联和结构树理论的数据抽取算', '设计', '科研', '1', '0', 2018, '1269', 3),
(1946, '基于协同过滤算法的个性化图书推荐', '设计', '科研', '1', '0', 2018, '1269', 3),
(1947, '基于GNS3软件和虚拟化技术的cisco', '设计', '科研', '1', '0', 2018, '0633', 1),
(1948, '基于ENSP软件和虚拟化技术的华为网络设', '设计', '科研', '1', '0', 2018, '0633', 1),
(1949, '华软校园网方案设计与模拟实现', '设计', '自拟', '1', '0', 2018, '0633', 1),
(1950, '企业网络数据备份和灾难防护方案的设计', '设计', '自拟', '1', '0', 2018, '0403', 1),
(1951, '基于VMware技术的企业桌面虚拟化的设', '设计', '自拟', '1', '0', 2018, '0403', 1),
(1952, '基于VMware技术的企业服务器虚拟化的', '设计', '自拟', '1', '0', 2018, '0403', 1);

--
-- 限制导出的表
--

--
-- 限制表 `think_apply`
--
ALTER TABLE `think_apply`
  ADD CONSTRAINT `fk_think_topic_has_think_student_think_student1` FOREIGN KEY (`student_Snum`) REFERENCES `think_student` (`Snum`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_think_topic_has_think_student_think_topic1` FOREIGN KEY (`topic_Cnum`) REFERENCES `think_topic` (`Cnum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `think_defense`
--
ALTER TABLE `think_defense`
  ADD CONSTRAINT `fk_think_defense_think_ERG1` FOREIGN KEY (`ERG_group`) REFERENCES `think_erg` (`ERG_group`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `think_defensestudent`
--
ALTER TABLE `think_defensestudent`
  ADD CONSTRAINT `fk_think_defenseStudent_think_defense1` FOREIGN KEY (`defense_group`) REFERENCES `think_defense` (`defense_group`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `think_defenseteacher`
--
ALTER TABLE `think_defenseteacher`
  ADD CONSTRAINT `fk_think_defenseTeacher_think_defense1` FOREIGN KEY (`defense_group`) REFERENCES `think_defense` (`defense_group`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `think_dscore`
--
ALTER TABLE `think_dscore`
  ADD CONSTRAINT `fk_think_dscore_think_score1` FOREIGN KEY (`scorenum`) REFERENCES `think_score` (`scorenum`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_think_dscore_think_teacher1` FOREIGN KEY (`Tnum`) REFERENCES `think_teacher` (`Tnum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `think_information`
--
ALTER TABLE `think_information`
  ADD CONSTRAINT `fk_think_information_think_admin1` FOREIGN KEY (`Tnum`) REFERENCES `think_admin` (`Tnum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `think_score`
--
ALTER TABLE `think_score`
  ADD CONSTRAINT `fk_think_score_think_student1` FOREIGN KEY (`Studentnum`) REFERENCES `think_student` (`Snum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `think_teacher`
--
ALTER TABLE `think_teacher`
  ADD CONSTRAINT `fk_think_teacher_think_ERG1` FOREIGN KEY (`ERG_group`) REFERENCES `think_erg` (`ERG_group`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `think_topic`
--
ALTER TABLE `think_topic`
  ADD CONSTRAINT `fk_think_topic_think_ERG1` FOREIGN KEY (`ERG_group`) REFERENCES `think_erg` (`ERG_group`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_think_topic_think_config1` FOREIGN KEY (`year`) REFERENCES `think_config` (`year`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_think_topic_think_teacher1` FOREIGN KEY (`Tnum`) REFERENCES `think_teacher` (`Tnum`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
