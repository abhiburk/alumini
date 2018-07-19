-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2017 at 04:55 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumini`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branchID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `branchName` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branchID`, `courseID`, `branchName`) VALUES
(1, 1, 'Civil Engineering'),
(2, 1, 'Computer Sci & Technology'),
(3, 1, 'Electrical Engineering'),
(4, 1, 'E&TC'),
(5, 1, 'Mechanical Engineering'),
(6, 1, 'Mechanical Engineering (Part Time)'),
(7, 1, 'Production Engineering'),
(8, 2, 'Architecture'),
(9, 3, 'Agriculture Engineering '),
(10, 3, 'Civil Engineering'),
(11, 3, 'Civil Engineering(2nd Shift)'),
(12, 3, 'Computer Sci & Technology'),
(13, 3, 'Electrical Engineering'),
(14, 3, 'E&TC'),
(15, 3, 'Mechanical Engineering'),
(16, 3, 'Mechanical Engineering (2nd Shift)'),
(17, 3, 'Plastic & Polymer Engineering'),
(18, 4, 'Agriculture Engineering '),
(19, 4, 'Civil Engineering'),
(20, 4, 'Civil Engineering(2nd Shift)'),
(21, 4, 'Computer Sci & Technology'),
(22, 4, 'Electrical Engineering'),
(23, 4, 'E&TC '),
(24, 4, 'Mechanical Engineering'),
(25, 4, 'Mechanical Engineering (2nd Shift)'),
(26, 4, 'Plastic & Polymer Engineering'),
(27, 5, 'Architecture'),
(28, 6, 'MBA'),
(29, 7, 'MCA'),
(30, 8, 'Automation'),
(31, 8, 'Communication Engineering'),
(32, 8, 'Computer Science'),
(33, 8, 'Electrical Drives & Control'),
(34, 8, 'Embedded System'),
(35, 8, 'Heat Power'),
(36, 8, 'Manufacturing Engineering'),
(37, 8, 'Software Engineering'),
(38, 8, 'Structural Engineering'),
(39, 9, 'Computer Sci & Engineering'),
(40, 9, 'E&TC'),
(41, 9, 'Food Processing Technology'),
(42, 9, 'Mechanical Engineering'),
(43, 10, 'Interior Design'),
(44, 11, 'Diploma in Architecture & Design'),
(45, 12, 'Architecture');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseID` int(11) NOT NULL,
  `courseName` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseID`, `courseName`) VALUES
(1, 'Diploma-Polytechnic'),
(2, 'UG-Bachelor of Architecture (B.Arch)'),
(3, 'UG-Bachelor of Engineering (B.E)'),
(4, 'UG-Bachelor of Technology (B.Tech)'),
(5, 'PG-Master of Architecture (M.Arch)'),
(6, 'PG-Master of Business Admin..(MBA)'),
(7, 'PG-Master of Computer Application (MCA)'),
(8, 'PG-Master of Engineering (M.E)'),
(9, 'PG-Master of Technology (M.Tech)'),
(10, 'UG-Bachelore of Design(Interior Design)'),
(11, 'Diploma-Foundation Diploma in Architecture & Design'),
(12, 'UG-Bachelor of Architecture (B.Arch-YCMOU)');

-- --------------------------------------------------------

--
-- Table structure for table `demo`
--

CREATE TABLE `demo` (
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `demo`
--

INSERT INTO `demo` (`text`) VALUES
('Hi'),
('Hi');

-- --------------------------------------------------------

--
-- Table structure for table `event_status`
--

CREATE TABLE `event_status` (
  `estatusID` int(12) NOT NULL,
  `eventID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `status` varchar(256) NOT NULL,
  `statusTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_status`
--

INSERT INTO `event_status` (`estatusID`, `eventID`, `userID`, `status`, `statusTime`) VALUES
(2, 1, 4, 'Declined', 1496828298),
(22, 1, 4, 'Attending', 1496853269),
(23, 8, 3, 'Attending', 1496907470),
(24, 11, 3, 'Attending', 1497015735);

-- --------------------------------------------------------

--
-- Table structure for table `forum_answers`
--

CREATE TABLE `forum_answers` (
  `answerID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `fqID` int(12) NOT NULL,
  `answerText` text NOT NULL,
  `votes` int(12) NOT NULL DEFAULT '0',
  `createTime` int(12) NOT NULL,
  `updateTime` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_answers`
--

INSERT INTO `forum_answers` (`answerID`, `userID`, `fqID`, `answerText`, `votes`, `createTime`, `updateTime`) VALUES
(1, 1, 3, '<p>yes, you can still use parse_url function</p>\r\n\r\n<pre>\r\n<code>$parsed = parse_url($urlStr);\r\nif (empty($parsed[&#39;scheme&#39;])) {\r\n    $urlStr = &#39;http://&#39; . ltrim($urlStr, &#39;/&#39;);\r\n}</code></pre>\r\n\r\n<p>about writing html with PHP, it&#39;s okay to use echo function, just make sure you escape the double quotes with backslash</p>\r\n', 1, 1497961984, 1498025474),
(2, 4, 3, '<p>Yes it seems to be urlencoded differently in different browsers (Firefox doesn&#39;t encode but Chrome does). Try to map the coordinates into the url directly instead:</p>\r\n\r\n<pre>\r\n<code>myPlaces = [&quot;1.2345,6.7890&quot;, &quot;2.3456,7.8901&quot;];\r\n\r\nvar myPlacesQueryString = &quot;&quot;;\r\n$.each(myPlaces, function(i, value) {\r\n    myPlacesQueryString += &quot;location=&quot; + value;\r\n    if (i &lt; myPlaces.length - 1) {\r\n        myPlacesQueryString += &quot;&amp;&quot;;\r\n    }\r\n});\r\n\r\n$.ajax({\r\n    url : &quot;example.com/route?&quot; + myPlacesQueryString,\r\n    datatype : &quot;json&quot;,\r\n    jsonp : &quot;jsonp&quot;\r\n});</code></pre>\r\n', 0, 1497965511, NULL),
(5, 3, 1, '<p>The best way is to use <code>IN</code> statement :</p>\r\n\r\n<pre>\r\n<code>DELETE from tablename WHERE id IN (1,2,3,...,254);</code></pre>\r\n\r\n<p>You can also use <code>BETWEEN</code> if you have consecutive IDs :</p>\r\n\r\n<pre>\r\n<code>DELETE from tablename WHERE id BETWEEN 1 AND 254;</code></pre>\r\n\r\n<p>You can of course limit for some IDs using other WHERE clause :</p>\r\n\r\n<pre>\r\n<code>DELETE from tablename WHERE id BETWEEN 1 AND 254 AND id&lt;&gt;10;</code></pre>\r\n', 0, 1498025171, NULL),
(7, 1, 3, '<p><code>value&#39;); DROP TABLE table;</code></p>\r\n', 0, 1498063007, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forum_answer_votes`
--

CREATE TABLE `forum_answer_votes` (
  `voteID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `type` varchar(256) NOT NULL,
  `answerID` int(12) NOT NULL,
  `voteTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_answer_votes`
--

INSERT INTO `forum_answer_votes` (`voteID`, `userID`, `type`, `answerID`, `voteTime`) VALUES
(1, 4, 'up', 1, 1498045637),
(2, 1, 'down', 2, 1498045787),
(3, 3, 'up', 2, 1498047039);

-- --------------------------------------------------------

--
-- Table structure for table `forum_questions`
--

CREATE TABLE `forum_questions` (
  `fqID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `tittle` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `answerAccepted` int(2) NOT NULL DEFAULT '0',
  `answerID` int(12) DEFAULT NULL,
  `acceptTime` int(12) DEFAULT NULL,
  `views` int(12) NOT NULL DEFAULT '0',
  `votes` int(12) NOT NULL DEFAULT '0',
  `createTime` int(12) NOT NULL,
  `editedBy` int(12) DEFAULT NULL,
  `updateTime` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_questions`
--

INSERT INTO `forum_questions` (`fqID`, `userID`, `tittle`, `description`, `answerAccepted`, `answerID`, `acceptTime`, `views`, `votes`, `createTime`, `editedBy`, `updateTime`) VALUES
(1, 1, 'Creating dynamic Div Tags for AJAX-PHP-MySQL generated table', '<pre>\r\n<code>&lt;?php\r\ninclude (&quot;/connections/query.php&quot;);\r\n\r\n$nrows = mysqli_num_rows($result);\r\n/* Display results in a table */\r\n    echo &quot;&lt;table&gt;\\n\r\n    &lt;tr&gt;\\n&quot;;\r\n            $i=1;\r\ninclude (&quot;/function/movietable.php&quot;);\r\n\r\n\r\n    echo &quot;&lt;/tr&gt;\\n\r\n    &lt;/table&gt;\\n&quot;;\r\n\r\n\r\n?&gt;  </code></pre>\r\n\r\n<p>I am trying to learn how to create tags in PHP/MySQL. Does anyone know some good sites that help explain how to go about creating tags?</p>\r\n\r\n<p>Tags as in the tags you see when you ask a question in stackoverflow.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 0, NULL, NULL, 50, 0, 1497867675, NULL, 0),
(2, 1, 'Sites to help me create tag in PHP (like the tags on this site)', '<pre>\r\n<code>&lt;?php\r\n  $q=$_GET[&quot;q&quot;];\r\n\r\n  $con = mysql_connect(&#39;localhost&#39;, &#39;root&#39;, &#39;&#39;);\r\n  if (!$con)\r\n      {\r\n        die(&#39;Could not connect: &#39; . mysql_error());\r\n       }\r\n\r\nmysql_select_db(&quot;world&quot;, $con);\r\n\r\n$sql=&quot;SELECT * FROM country WHERE Code = &#39;&quot;.$q.&quot;&#39;&quot;;\r\n\r\n$result = mysql_query($sql);\r\n\r\necho &quot;&lt;table border=&#39;1&#39;&gt;\r\n&lt;tr&gt;\r\n\r\n&lt;th&gt;Code&lt;/th&gt;\r\n&lt;th&gt;Name&lt;/th&gt;\r\n&lt;th&gt;Continent&lt;/th&gt;\r\n&lt;th&gt;GNP&lt;/th&gt;\r\n&lt;th&gt;GNPOld&lt;/th&gt;\r\n&lt;/tr&gt;&quot;;\r\n\r\n\r\n\r\n\r\nwhile($row = mysql_fetch_array($result))\r\n   {\r\n\r\n     echo &quot;&lt;tr&gt;&quot;;  \r\n     echo &quot;&lt;td&gt;&quot; . $row[&#39;Code&#39;] . &quot;&lt;/td&gt;&quot;;\r\n     echo &quot;&lt;td&gt;&quot; . $row[&#39;Name&#39;] . &quot;&lt;/td&gt;&quot;;\r\n     echo &quot;&lt;td&gt;&quot; . $row[&#39;Continent&#39;] . &quot;&lt;/td&gt;&quot;;\r\n     echo &quot;&lt;td&gt;&quot; . $row[&#39;GNP&#39;] . &quot;&lt;/td&gt;&quot;;\r\n     echo &quot;&lt;td&gt;&quot; . $row[&#39;GNPOld&#39;] . &quot;&lt;/td&gt;&quot;;\r\n     echo &quot;&lt;/tr&gt;&quot;;\r\n      }\r\n    echo &quot;&lt;/table&gt;&quot;;\r\n\r\n    mysql_close($con);\r\n    ?&gt;</code></pre>\r\n\r\n<p>Above is PHP and below is HTML for same and I am working on sample world database of mysql now</p>\r\n\r\n<pre>\r\n<code>&lt;?php\r\ninclude (&quot;/connections/query.php&quot;);\r\n\r\n$nrows = mysqli_num_rows($result);\r\n/* Display results in a table */\r\n    echo &quot;&lt;table&gt;\\n\r\n    &lt;tr&gt;\\n&quot;;\r\n            $i=1;\r\ninclude (&quot;/function/movietable.php&quot;);\r\n\r\n\r\n    echo &quot;&lt;/tr&gt;\\n\r\n    &lt;/table&gt;\\n&quot;;\r\n\r\n\r\n?&gt;  </code></pre>\r\n', 0, NULL, NULL, 10, 1, 1497868977, NULL, 0),
(3, 4, 'PHP - How to replace special characters for url?', '<p>I am trying to learn how to create tags in PHP/MySQL. Does anyone know some good sites that help explain how to go about creating tags?</p>\r\n\r\n<p>Tags as in the tags you see when you ask a question in stackoverflow</p>\r\n\r\n<pre>\r\n<code>RewriteCond %{REQUEST_URI} ^/nature-pic-(.*).php\r\nRewriteRule ^nature-pic-(.*)\\.php content.php?tpath=$1 [L]</code></pre>\r\n\r\n<p><code>`table`</code></p>\r\n', 1, 1, 1497974933, 655, 2, 1497870797, 1, 1497952641),
(5, 3, 'Delete many rows from a table using id in Mysql', '<p>I am a Linux admin with only basic knowledge in Mysql Queries</p>\r\n\r\n<p>I want to delete many table entries which are ip address from my table using <strong>id</strong>,</p>\r\n\r\n<p>currently i am using</p>\r\n\r\n<pre>\r\n<code>DELETE from tablename where id=1;\r\nDELETE from tablename where id=2;</code></pre>\r\n\r\n<p>but i have to delete 254 entries,so this method is going to take hours,how can i tell mysql to delete rows that i specify,coz i want to skip deleting some entries out of this 254.</p>\r\n\r\n<p>Deleting whole table and importing needed entries is not an option.</p>\r\n', 0, NULL, NULL, 36, 0, 1498027559, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `forum_question_tag`
--

CREATE TABLE `forum_question_tag` (
  `fqtID` int(12) NOT NULL,
  `fqID` int(12) NOT NULL,
  `ftagID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_question_tag`
--

INSERT INTO `forum_question_tag` (`fqtID`, `fqID`, `ftagID`) VALUES
(1, 1, 3),
(2, 1, 4),
(3, 2, 3),
(74, 3, 1),
(75, 3, 3),
(76, 3, 4),
(79, 5, 3),
(80, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `forum_question_votes`
--

CREATE TABLE `forum_question_votes` (
  `voteID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `type` varchar(12) DEFAULT NULL,
  `fqID` int(12) NOT NULL,
  `voteTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_question_votes`
--

INSERT INTO `forum_question_votes` (`voteID`, `userID`, `type`, `fqID`, `voteTime`) VALUES
(1, 4, 'up', 3, 1498044744),
(2, 4, 'up', 2, 1498063878),
(3, 1, 'up', 3, 1498110804);

-- --------------------------------------------------------

--
-- Table structure for table `forum_tags`
--

CREATE TABLE `forum_tags` (
  `ftagID` int(12) NOT NULL,
  `tagName` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_tags`
--

INSERT INTO `forum_tags` (`ftagID`, `tagName`) VALUES
(1, 'Microsoft'),
(2, 'Data Structure'),
(3, 'PHP'),
(4, 'SQL');

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

CREATE TABLE `friend_request` (
  `friendreqID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `friendWith` int(12) NOT NULL,
  `requestTime` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_request`
--

INSERT INTO `friend_request` (`friendreqID`, `userID`, `friendWith`, `requestTime`) VALUES
(7, 1, 8, '1497090461'),
(20, 29, 4, '1498317035');

-- --------------------------------------------------------

--
-- Table structure for table `group_discussion`
--

CREATE TABLE `group_discussion` (
  `disID` int(12) NOT NULL,
  `groupID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `message` text NOT NULL,
  `sentTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_discussion`
--

INSERT INTO `group_discussion` (`disID`, `groupID`, `userID`, `message`, `sentTime`) VALUES
(1, 2, 4, 'hello', 1496636709),
(2, 2, 4, 'hey', 1496636742),
(3, 2, 1, 'jk', 1498898057),
(4, 2, 1, 'hey', 1498898784),
(5, 2, 1, 'hey', 1498898975),
(6, 2, 1, 'Hey', 1498899036),
(7, 2, 1, 'askhh', 1498899049),
(8, 2, 1, 'hey', 1498899205),
(9, 2, 1, 'hey', 1498899317),
(10, 2, 1, 'za\r\n', 1498899413),
(11, 2, 1, 'as', 1498899486),
(12, 2, 1, 'saks', 1498899530),
(13, 2, 1, 'ask', 1498899664),
(14, 2, 1, 'hey', 1498899764),
(15, 2, 1, 'asj', 1498899854),
(16, 2, 1, 'asaks', 1498899857),
(17, 2, 4, 'sjhdj', 1498900148),
(18, 2, 1, 'hey', 1498900176),
(19, 2, 1, 'hey', 1498908544),
(20, 2, 1, 'hey', 1498908733),
(21, 2, 1, 'Hey how are you', 1498909032),
(22, 2, 1, 'skas', 1498911361),
(23, 2, 4, 'sjhksf', 1498913131),
(24, 2, 4, 'aas', 1498913223),
(25, 2, 4, ',djsdsdlk', 1498913240),
(26, 2, 4, 'dakldlsdjsljsldsskflkdf', 1498913264),
(27, 2, 4, 'sjal', 1498913309),
(28, 2, 4, 'sjld', 1498913441),
(29, 2, 4, 'asjls', 1498915723),
(30, 2, 4, 'jsdksjd', 1498915735);

-- --------------------------------------------------------

--
-- Table structure for table `group_discussion_status`
--

CREATE TABLE `group_discussion_status` (
  `gdstatusID` int(12) NOT NULL,
  `disID` int(12) NOT NULL,
  `readBy` int(12) NOT NULL,
  `readTime` int(12) DEFAULT NULL,
  `deletedBy` int(12) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_discussion_status`
--

INSERT INTO `group_discussion_status` (`gdstatusID`, `disID`, `readBy`, `readTime`, `deletedBy`) VALUES
(1, 1, 1, 1496636721, 1),
(2, 1, 4, 1496636739, 4),
(3, 2, 4, 1496636745, 4),
(4, 2, 1, 1496641723, 1),
(5, 1, 5, 1497426635, 0),
(6, 2, 5, 1497426635, 0),
(7, 3, 1, 1498898060, 1),
(8, 4, 1, 1498898787, 1),
(9, 5, 1, 1498898979, 1),
(10, 6, 1, 1498899038, 1),
(11, 7, 1, 1498899058, 1),
(12, 8, 1, 1498899211, 1),
(13, 9, 1, 1498899323, 1),
(14, 10, 1, 1498899418, 1),
(15, 11, 1, 1498899494, 1),
(16, 12, 1, 1498899534, 1),
(17, 13, 1, 1498899671, 1),
(18, 14, 1, 1498899765, 1),
(19, 15, 1, 1498899854, 1),
(20, 16, 1, 1498899857, 1),
(21, 3, 4, 1498900143, 4),
(22, 4, 4, 1498900143, 4),
(23, 5, 4, 1498900143, 4),
(24, 6, 4, 1498900143, 4),
(25, 7, 4, 1498900143, 4),
(26, 8, 4, 1498900143, 4),
(27, 9, 4, 1498900143, 4),
(28, 10, 4, 1498900143, 4),
(29, 11, 4, 1498900143, 4),
(30, 12, 4, 1498900143, 4),
(31, 13, 4, 1498900143, 4),
(32, 14, 4, 1498900143, 4),
(33, 15, 4, 1498900143, 4),
(34, 16, 4, 1498900143, 4),
(35, 17, 4, 1498900148, 4),
(36, 17, 1, 1498900174, 1),
(37, 18, 1, 1498900176, 1),
(38, 19, 1, 1498908544, 1),
(39, 18, 4, 1498908706, 4),
(40, 19, 4, 1498908706, 4),
(41, 20, 1, 1498908733, 1),
(42, 20, 4, 1498908742, 4),
(43, 21, 1, 1498909032, 1),
(44, 21, 4, 1498909307, 0),
(45, 22, 1, 1498911361, 1),
(46, 22, 4, 1498911367, 0),
(47, 23, 4, 1498913131, 0),
(48, 23, 1, 1498913216, 1),
(49, 24, 4, 1498913223, 0),
(50, 24, 1, 1498913233, 1),
(51, 25, 4, 1498913240, 0),
(52, 26, 4, 1498913264, 0),
(53, 25, 1, 1498913302, 1),
(54, 26, 1, 1498913302, 1),
(55, 27, 4, 1498913309, 0),
(56, 27, 1, 1498913437, 1),
(57, 28, 4, 1498913441, 0),
(58, 28, 1, 1498913506, 1),
(59, 29, 4, 1498915723, 0),
(60, 30, 4, 1498915735, 0),
(61, 29, 1, 1498921823, 1),
(62, 30, 1, 1498921823, 1),
(63, 1, 2, 1499082032, 0),
(64, 2, 2, 1499082032, 0),
(65, 3, 2, 1499082032, 0),
(66, 4, 2, 1499082032, 0),
(67, 5, 2, 1499082032, 0),
(68, 6, 2, 1499082032, 0),
(69, 7, 2, 1499082032, 0),
(70, 8, 2, 1499082032, 0),
(71, 9, 2, 1499082032, 0),
(72, 10, 2, 1499082032, 0),
(73, 11, 2, 1499082032, 0),
(74, 12, 2, 1499082032, 0),
(75, 13, 2, 1499082032, 0),
(76, 14, 2, 1499082032, 0),
(77, 15, 2, 1499082032, 0),
(78, 16, 2, 1499082032, 0),
(79, 17, 2, 1499082032, 0),
(80, 18, 2, 1499082032, 0),
(81, 19, 2, 1499082032, 0),
(82, 20, 2, 1499082032, 0),
(83, 21, 2, 1499082032, 0),
(84, 22, 2, 1499082032, 0),
(85, 23, 2, 1499082032, 0),
(86, 24, 2, 1499082032, 0),
(87, 25, 2, 1499082032, 0),
(88, 26, 2, 1499082032, 0),
(89, 27, 2, 1499082032, 0),
(90, 28, 2, 1499082032, 0),
(91, 29, 2, 1499082032, 0),
(92, 30, 2, 1499082032, 0);

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `gmID` int(12) NOT NULL,
  `groupID` int(12) NOT NULL,
  `memberID` int(12) NOT NULL,
  `addedBy` int(12) NOT NULL,
  `addTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`gmID`, `groupID`, `memberID`, `addedBy`, `addTime`) VALUES
(1, 1, 4, 4, 1496154263),
(3, 2, 5, 5, 1496161965),
(4, 2, 2, 5, 1496161965),
(5, 2, 4, 5, 1496161965),
(6, 2, 1, 5, 1496161965),
(7, 2, 6, 5, 1496161965),
(8, 3, 2, 2, 1496410981),
(9, 3, 3, 2, 1496410981),
(10, 3, 4, 2, 1496410981),
(11, 3, 6, 2, 1496410981),
(12, 1, 1, 4, 1496415892),
(13, 4, 1, 1, 1496642305),
(14, 4, 2, 1, 1496642305),
(15, 4, 4, 1, 1496642305),
(16, 1, 3, 0, 1498065505),
(17, 1, 3, 0, 1498065647),
(18, 4, 3, 0, 1498066332);

-- --------------------------------------------------------

--
-- Table structure for table `group_request`
--

CREATE TABLE `group_request` (
  `greqID` int(12) NOT NULL,
  `groupID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `requestTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `instituteID` int(12) NOT NULL,
  `instituteName` varchar(256) DEFAULT NULL,
  `createTime` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`instituteID`, `instituteName`, `createTime`) VALUES
(1, 'MIT (T)', ''),
(2, 'MIT (B.E)', '');

-- --------------------------------------------------------

--
-- Table structure for table `invitation`
--

CREATE TABLE `invitation` (
  `inviteID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `inviteTo` int(12) NOT NULL,
  `referenceID` int(12) NOT NULL,
  `type` varchar(12) NOT NULL,
  `inviteTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `my_friends`
--

CREATE TABLE `my_friends` (
  `myfriendID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `friendWith` int(12) NOT NULL,
  `friendshipTime` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `my_friends`
--

INSERT INTO `my_friends` (`myfriendID`, `userID`, `friendWith`, `friendshipTime`) VALUES
(7, 5, 3, '1496146797'),
(8, 5, 2, '1496146847'),
(9, 5, 4, '1496146903'),
(10, 5, 6, '1497162869'),
(11, 1, 4, '1497430019'),
(12, 1, 5, '1497517066'),
(14, 1, 3, '1498756999'),
(15, 1, 29, '1498843589');

-- --------------------------------------------------------

--
-- Table structure for table `news_feed`
--

CREATE TABLE `news_feed` (
  `feedID` int(12) NOT NULL,
  `newsBy` int(12) NOT NULL,
  `type` varchar(256) NOT NULL,
  `newsText` text NOT NULL,
  `reference` varchar(256) NOT NULL,
  `referenceID` int(12) NOT NULL,
  `newsTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news_feed`
--

INSERT INTO `news_feed` (`feedID`, `newsBy`, `type`, `newsText`, `reference`, `referenceID`, `newsTime`) VALUES
(1, 4, 'user.photo', 'changed his profile photo', 'post_id', 1, 1497340075),
(2, 1, 'group.photo', 'has updated <a href=\'group/1\'>Cricket India</a> group profile photo', 'post_id', 2, 1497342303),
(3, 1, 'event.photo', 'has updated <a href=\'event/8\'>Meet-Up 2017</a> event profile photo', 'post_id', 3, 1497373234),
(4, 3, 'home.post', 'added new post', 'post_id', 5, 1497373866),
(5, 3, 'group.post', 'added new post to <a href=\'group/3\'>Alumini</a> group', 'post_id', 6, 1497374498),
(6, 5, 'user.photo', 'changed her profile photo', 'post_id', 7, 1497375348),
(7, 27, 'user.photo', 'changed his profile photo', 'post_id', 8, 1498310416),
(8, 29, 'user.photo', 'changed his profile photo', 'post_id', 9, 1498318765),
(9, 31, 'user.photo', 'changed his profile photo', 'post_id', 10, 1498320685),
(10, 1, 'home.post', 'added new post', 'post_id', 11, 1498632373),
(11, 1, 'event.post', 'added new post to <a href=\'event/8\'>Meet-Up 2017</a> group', 'post_id', 12, 1498756281);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationID` int(12) NOT NULL,
  `read` int(12) DEFAULT NULL,
  `notiBy` int(12) NOT NULL,
  `notiTo` int(12) NOT NULL,
  `type` varchar(256) NOT NULL,
  `notiText` varchar(256) NOT NULL,
  `reference` varchar(256) NOT NULL,
  `referenceID` text NOT NULL,
  `notiTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notificationID`, `read`, `notiBy`, `notiTo`, `type`, `notiText`, `reference`, `referenceID`, `notiTime`) VALUES
(2, 1, 5, 3, 'home.post.comment', 'commented on your post', 'comment_id', '6', 1497421248),
(3, 1, 4, 1, 'group.photo.comment', 'commented on your <b>Cricket India</b> group profile photo', 'comment_id', '7', 1497421273),
(7, 1, 4, 5, 'user.photo', 'like your profile photo', 'post_id', '7', 1497424619),
(10, 1, 4, 1, 'group.photo', 'like your <b>Cricket India</b> group profile photo', 'post_id', '2', 1497424913),
(22, 1, 4, 1, 'request.sent', 'sent you a friend request', 'friend_request_id', '8', 1497429723),
(23, 1, 1, 4, 'request.accepted', 'accepted your friend request', 'my_friend_id', '11', 1497430019),
(26, 1, 1, 4, 'user.photo', 'like your profile photo', 'post_id', '1', 1497431779),
(29, 1, 1, 5, 'user.photo', 'like your profile photo', 'post_id', '7', 1497457477),
(30, 1, 1, 5, 'request.email', 'has requested for you Email-ID', 'request_info_id', '1', 1497514612),
(33, 1, 5, 1, 'request.sent', 'sent you a friend request', 'friend_request_id', '9', 1497516681),
(35, 0, 1, 5, 'request.accepted', 'accepted your friend request', 'my_friend_id', '12', 1497517066),
(37, 0, 1, 6, 'group.invite', 'invited you to join <b>Cricket India</b> group ', 'user_groups_id', '1', 1497545019),
(38, 1, 1, 3, 'group.invite', 'invited you to join <b>Cricket India</b> group ', 'user_groups_id', '1', 1497545026),
(39, 1, 5, 3, 'home.post', 'like your post', 'post_id', '5', 1497545811),
(40, 1, 5, 3, 'home.post.comment', 'commented on your post', 'comment_id', '8', 1497545845),
(41, 1, 3, 5, 'home.post.comment', 'like your comment for <b>Rohit Sharma</b> post', 'comment_id', '8', 1497546568),
(47, 0, 3, 5, 'user.photo', 'like your profile photo', 'post_id', '7', 1498018962),
(48, 0, 1, 3, 'question.vote.up', 'has up voted to your question: <b>"Delete many rows from a table using id in Mysql"</b> ', 'forum_question_id', '5', 1498027704),
(49, 1, 4, 4, 'question.vote.down', 'has down voted to your question: <b>"PHP - How to replace special characters for url?"</b> ', 'forum_question_id', '3', 1498044605),
(50, 1, 4, 4, 'question.vote.down', 'has down voted to your question: <b>"PHP - How to replace special characters for url?"</b> ', 'forum_question_id', '3', 1498044744),
(51, 1, 1, 4, 'answer.vote.down', 'has down voted to your answer to the question: <b>"PHP - How to replace special characters for url?"</b> ', 'forum_answer_id', '2', 1498045787),
(52, 1, 3, 4, 'answer.vote.down', 'has down voted to your answer to the question: <b>"PHP - How to replace special characters for url?"</b> ', 'forum_answer_id', '2', 1498047039),
(54, 1, 1, 4, 'answer.to.question', 'has answered to your question: <b>"PHP - How to replace special characters for url?"</b> ', 'forum_answer_id', '7', 1498063007),
(55, 1, 4, 1, 'question.vote.up', 'has up voted to your question: <b>"Sites to help me create tag in PHP (like the tags on this site)"</b> ', 'forum_question_id', '2', 1498063878),
(56, 1, 3, 4, 'group.invite.accepted', 'accepted your invitation and joined to <b>Cricket India</b> group ', 'user_groups_id', '1', 1498065647),
(57, 1, 4, 3, 'group.invite', 'invited you to join <b>EA Cricket 2007</b> group ', 'user_groups_id', '4', 1498066311),
(58, 1, 3, 1, 'group.invite.accepted', 'accepted your invitation and joined to <b>EA Cricket 2007</b> group ', 'user_groups_id', '4', 1498066332),
(59, 1, 1, 4, 'question.vote.up', 'has up voted to your question: <b>"PHP - How to replace special characters for url?"</b> ', 'forum_question_id', '3', 1498110804),
(61, 0, 29, 4, 'request.sent', 'sent you a friend request', 'friend_request_id', '17', 1498316595),
(62, 1, 29, 4, 'request.sent', 'sent you a friend request', 'friend_request_id', '18', 1498316783),
(64, 0, 29, 4, 'request.sent', 'sent you a friend request', 'friend_request_id', '20', 1498317035),
(75, 0, 3, 1, 'request.sent', 'sent you a friend request', 'friend_request_id', '29', 1498578807),
(77, 0, 1, 3, 'request.accepted', 'accepted your friend request', 'my_friend_id', '14', 1498756999),
(78, 0, 29, 1, 'request.sent', 'sent you a friend request', 'friend_request_id', '30', 1498757081),
(79, 0, 1, 29, 'request.accepted', 'accepted your friend request', 'my_friend_id', '15', 1498843589),
(80, 0, 1, 29, 'request.contact', 'has requested for your phone contact', 'request_info_id', '1', 1498993093);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `postType` varchar(256) NOT NULL,
  `postText` text,
  `postImg` varchar(256) DEFAULT NULL,
  `reference` varchar(256) NOT NULL,
  `referenceID` int(12) NOT NULL,
  `like_counts` int(12) NOT NULL DEFAULT '0',
  `comment_counts` int(12) NOT NULL DEFAULT '0',
  `postTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `userID`, `postType`, `postText`, `postImg`, `reference`, `referenceID`, `like_counts`, `comment_counts`, `postTime`) VALUES
(1, 4, 'user.photo', NULL, 'page3_img1.jpg', 'user_id', 4, 2, 0, 1497340075),
(2, 1, 'group.photo', NULL, '2.jpg', 'group_id', 1, 2, 1, 1497342303),
(3, 1, 'event.photo', NULL, '11.jpg', 'event_id', 8, 1, 1, 1497373234),
(5, 3, 'home.post', 'Test', '1.jpg', 'user_id', 3, 1, 2, 1497373866),
(6, 3, 'group.post', 'Test', NULL, 'group_id', 3, 0, 0, 1497374498),
(7, 5, 'user.photo', NULL, 'Fotolia_20568380_Subscription_XXL-94x94.jpg', 'user_id', 5, 4, 0, 1497375348),
(8, 27, 'user.photo', NULL, '1.jpg', 'user_id', 27, 0, 0, 1498310416),
(9, 29, 'user.photo', NULL, '1.jpg', 'user_id', 29, 0, 0, 1498318765),
(10, 31, 'user.photo', NULL, 'page2_img.jpg', 'user_id', 31, 0, 0, 1498320685),
(11, 1, 'home.post', 'Test', NULL, 'user_id', 1, 1, 0, 1498632373),
(12, 1, 'event.post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.', NULL, 'event_id', 8, 1, 0, 1498756281);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `commentID` int(12) NOT NULL,
  `postID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `comment` text NOT NULL,
  `like_counts` int(12) NOT NULL DEFAULT '0',
  `commentTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`commentID`, `postID`, `userID`, `comment`, `like_counts`, `commentTime`) VALUES
(4, 3, 1, 'test event', 0, 1497421130),
(6, 5, 5, 'test', 0, 1497421248),
(7, 2, 4, 'test', 0, 1497421273),
(8, 5, 5, 'hiiiiii', 1, 1497545845);

-- --------------------------------------------------------

--
-- Table structure for table `request_info`
--

CREATE TABLE `request_info` (
  `reqinfoID` int(12) NOT NULL,
  `reqTo` int(12) NOT NULL,
  `reqBy` int(12) NOT NULL,
  `reqAbout` varchar(256) NOT NULL,
  `reqTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_info`
--

INSERT INTO `request_info` (`reqinfoID`, `reqTo`, `reqBy`, `reqAbout`, `reqTime`) VALUES
(1, 29, 1, 'request.contact', 1498993093);

-- --------------------------------------------------------

--
-- Table structure for table `share_request_info`
--

CREATE TABLE `share_request_info` (
  `sharereqID` int(12) NOT NULL,
  `shareBy` int(12) NOT NULL,
  `shareWith` int(12) NOT NULL,
  `type` varchar(256) NOT NULL,
  `shareTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `share_request_info`
--

INSERT INTO `share_request_info` (`sharereqID`, `shareBy`, `shareWith`, `type`, `shareTime`) VALUES
(1, 5, 1, 'share.email', 1497514684);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(12) NOT NULL,
  `firstName` varchar(256) NOT NULL,
  `lastName` varchar(256) NOT NULL,
  `webName` varchar(256) DEFAULT NULL,
  `userImg` varchar(256) DEFAULT NULL,
  `userEmail` varchar(256) NOT NULL,
  `emailPrivacy` varchar(12) NOT NULL DEFAULT 'Only Me',
  `birthday` date NOT NULL,
  `gender` varchar(256) NOT NULL,
  `userPhone` varchar(12) DEFAULT NULL,
  `phonePrivacy` varchar(12) NOT NULL DEFAULT 'Only Me',
  `userPass` varchar(256) NOT NULL,
  `tempPassword` int(12) NOT NULL DEFAULT '1',
  `verificationCode` varchar(256) DEFAULT NULL,
  `createTime` varchar(256) NOT NULL,
  `updateTime` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `webName`, `userImg`, `userEmail`, `emailPrivacy`, `birthday`, `gender`, `userPhone`, `phonePrivacy`, `userPass`, `tempPassword`, `verificationCode`, `createTime`, `updateTime`) VALUES
(1, 'Abhishek', 'Burkule', 'abhiburk', '7.jpg', 'abhiburk@gmail.com', 'Only Me', '1995-05-05', 'Male', '8445562337', 'Public', '25f9e794323b453885f5181f1b624d0b', 1, 'verified', '1490795856', '1498929444'),
(2, 'Lokesh', 'Rahul', NULL, NULL, 'rahul@gmail.com', 'Only Me', '1985-06-10', 'Male', NULL, 'Only Me', '25f9e794323b453885f5181f1b624d0b', 1, 'verified', '1490806169', NULL),
(3, 'Rohit', 'Sharma', 'hitman', 'page2_img2.jpg', 'rohit@gmail.com', 'Only Me', '1989-07-15', 'Male', '9565856656', 'Only Me', '25f9e794323b453885f5181f1b624d0b', 1, 'verified', '1490807510', NULL),
(4, 'Murli', 'Vijay', 'mvijay', 'page3_img1.jpg', 'murli@gmail.com', 'Only Me', '1989-10-15', 'Male', '9565856656', 'Only Me', '25f9e794323b453885f5181f1b624d0b', 1, 'verified', '1490807682', NULL),
(5, 'Vishakha ', 'Burkule', NULL, 'Fotolia_20568380_Subscription_XXL-94x94.jpg', 'vishakha@gmail.com', 'Only Me', '1989-06-15', 'Female', '9565856656', 'Only Me', '25f9e794323b453885f5181f1b624d0b', 1, 'verified', '1493123212', NULL),
(6, 'Virat', 'Kohli', NULL, NULL, 'virat@gmail.com', 'Only Me', '1991-01-11', 'Male', '8855445522', 'Only Me', '25f9e794323b453885f5181f1b624d0b', 1, 'verified', '1496047612', NULL),
(7, 'Suresh', 'Raina', NULL, NULL, 'suresh@gmail.com', 'Only Me', '1983-01-01', 'Male', NULL, 'Only Me', '25f9e794323b453885f5181f1b624d0b', 1, 'verified', '1496982238', NULL),
(8, 'Nilesh', 'Rao', NULL, NULL, 'nilesh@gmail.com', 'Only Me', '1989-06-14', 'Male', NULL, 'Only Me', '25f9e794323b453885f5181f1b624d0b', 1, 'verified', '1496982602', NULL),
(29, 'Sachin', 'Rana', NULL, '1.jpg', 'sachin@gmail.com', 'Only Me', '1990-06-14', 'Male', NULL, 'Only Me', '25f9e794323b453885f5181f1b624d0b', 1, 'verified', '1498310783', NULL),
(32, 'Geeta', 'Naik', NULL, NULL, 'geeta@gmail.com', 'Only Me', '1966-06-15', 'Female', NULL, 'Only Me', '25f9e794323b453885f5181f1b624d0b', 1, '75594e', '1498322656', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_edu`
--

CREATE TABLE `users_edu` (
  `ueID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `instituteName` varchar(256) DEFAULT NULL,
  `courseName` varchar(256) DEFAULT NULL,
  `branchName` varchar(256) DEFAULT NULL,
  `joinDate` date DEFAULT NULL,
  `passoutDate` date DEFAULT NULL,
  `currentlystudying` int(12) DEFAULT '0',
  `updateTime` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_edu`
--

INSERT INTO `users_edu` (`ueID`, `userID`, `instituteName`, `courseName`, `branchName`, `joinDate`, `passoutDate`, `currentlystudying`, `updateTime`) VALUES
(1, 1, 'MIT (T)', 'UG-Bachelor of Technology (B.Tech)', 'Computer Sci & Technology', '2015-07-10', NULL, 1, 1498843630),
(2, 5, 'MIT (T)', 'UG-Bachelor of Technology (B.Tech)', 'Computer Sci & Technology', '2015-07-14', NULL, 1, 1497459195),
(3, 4, 'MIT (T)', 'UG-Bachelor of Technology (B.Tech)', 'Civil Engineering', '2014-07-20', NULL, 1, 1497505731),
(4, 3, 'MIT (B.E)', 'UG-Bachelor of Technology (B.Tech)', 'Civil Engineering', '2015-08-16', NULL, 1, 1497506395),
(6, 29, 'MIT (T)', 'UG-Bachelor of Technology (B.Tech)', 'Electrical Engineering', '2013-06-12', '2017-04-13', NULL, 1498310888);

-- --------------------------------------------------------

--
-- Table structure for table `user_active`
--

CREATE TABLE `user_active` (
  `u_activeID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `activeTime` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_active`
--

INSERT INTO `user_active` (`u_activeID`, `userID`, `activeTime`) VALUES
(1, 1, '1499104191'),
(2, 4, '1499139172'),
(3, 3, '1498734275'),
(4, 2, '1499085091'),
(6, 6, '1498288433'),
(7, 5, '1497547006'),
(8, 7, '1497373258'),
(9, 29, '1498757121');

-- --------------------------------------------------------

--
-- Table structure for table `user_events`
--

CREATE TABLE `user_events` (
  `eventID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `eventName` varchar(512) NOT NULL,
  `eventImg` varchar(256) DEFAULT NULL,
  `eventDetails` text NOT NULL,
  `eventLocation` varchar(256) NOT NULL,
  `eventDate` date NOT NULL,
  `eventTime` time NOT NULL,
  `eventShare` int(12) NOT NULL DEFAULT '0',
  `updateTime` int(12) DEFAULT NULL,
  `createTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_events`
--

INSERT INTO `user_events` (`eventID`, `userID`, `eventName`, `eventImg`, `eventDetails`, `eventLocation`, `eventDate`, `eventTime`, `eventShare`, `updateTime`, `createTime`) VALUES
(2, 3, 'Android Workshop', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.', 'MIT Aurangabad', '2017-06-12', '10:30:00', 0, 0, 1496854088),
(8, 1, 'Meet-Up 2017', '11.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.', 'Aurangabad', '2017-06-22', '12:25:00', 0, 1497373234, 1496902810),
(9, 4, 'Matron Season', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.', 'Pune', '2017-06-20', '12:00:00', 0, 0, 1496913796),
(10, 5, 'Digital India', 'cycle1.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.', 'Aurangabad', '2017-06-15', '01:00:00', 0, 1496915322, 1496914512),
(11, 1, 'Go Trip', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.', 'Mumbai', '2017-06-13', '05:00:00', 0, 0, 1496914755),
(12, 4, 'MIT Setup', '0026.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.', 'Aurangabad', '2017-06-09', '09:00:00', 0, 1496915304, 1496914865),
(15, 1, 'Lake Clue', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.', 'Pune', '2017-05-15', '10:00:00', 0, 0, 1496988443);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `groupID` int(12) NOT NULL,
  `groupName` varchar(256) NOT NULL,
  `userID` varchar(12) NOT NULL,
  `groupImg` varchar(256) DEFAULT NULL,
  `privacy` varchar(256) NOT NULL DEFAULT 'Private',
  `approval` varchar(256) NOT NULL DEFAULT 'admin',
  `updateTime` int(12) DEFAULT NULL,
  `createTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`groupID`, `groupName`, `userID`, `groupImg`, `privacy`, `approval`, `updateTime`, `createTime`) VALUES
(1, 'Cricket India', '4', '2.jpg', 'Private', 'admin', 1497342303, 1496154263),
(2, 'Funtush', '5', '4.jpg', 'Private', 'admin', 1497247905, 1496161965),
(3, 'Alumini', '2', NULL, 'Private', 'admin', 0, 1496410981),
(4, 'EA Cricket 2007', '1', '3.jpg', 'Private', 'admin', 1496642333, 1496642305);

-- --------------------------------------------------------

--
-- Table structure for table `user_likes`
--

CREATE TABLE `user_likes` (
  `likeID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `likeType` varchar(256) NOT NULL,
  `likeTo` int(12) NOT NULL,
  `likeTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_likes`
--

INSERT INTO `user_likes` (`likeID`, `userID`, `likeType`, `likeTo`, `likeTime`) VALUES
(1, 1, 'event.photo', 3, 1497419218),
(4, 4, 'event.photo.comment', 5, 1497424602),
(5, 4, 'user.photo', 7, 1497424619),
(8, 4, 'group.photo', 2, 1497424913),
(21, 1, 'user.photo', 1, 1497431779),
(24, 1, 'user.photo', 7, 1497457477),
(25, 5, 'home.post', 5, 1497545811),
(26, 3, 'home.post.comment', 8, 1497546568),
(27, 5, 'user.photo', 7, 1497546789),
(28, 1, 'group.photo', 2, 1497546938),
(29, 3, 'user.photo', 7, 1498018962),
(31, 1, 'event.post', 16, 1498469016),
(35, 4, 'user.photo', 1, 1498805370),
(36, 1, 'home.post', 11, 1498836527),
(37, 1, 'event.post', 12, 1498897948);

-- --------------------------------------------------------

--
-- Table structure for table `user_message`
--

CREATE TABLE `user_message` (
  `msgID` int(12) NOT NULL,
  `sentBy` int(12) NOT NULL,
  `sentTo` int(12) NOT NULL,
  `message` text NOT NULL,
  `sentTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_message`
--

INSERT INTO `user_message` (`msgID`, `sentBy`, `sentTo`, `message`, `sentTime`) VALUES
(6, 1, 2, '//checking if already deleted by end user', 1498668838),
(359, 1, 2, 'jeyasajsl', 1498670642),
(360, 1, 2, 'dhdj', 1498670676),
(361, 1, 2, 'samsb', 1498670681),
(362, 1, 2, 'aksas,n', 1498670686),
(363, 1, 2, 'asjasjk', 1498670689),
(364, 1, 3, 'hey', 1498708885),
(365, 3, 1, '#load_chats', 1498708929),
(366, 1, 3, '#load_chats', 1498708966),
(367, 1, 3, '#load_chats', 1498709013),
(368, 3, 1, '#load_chats', 1498709022),
(369, 3, 1, 'load_chat', 1498709484),
(370, 3, 1, 'function humanTiming ($time)\r\n{\r\n	$time = time() - $time; // to get the time since that moment\r\n	$time = ($time&lt;1)? 1 : $time;\r\n	$tokens = array (\r\n		31536000 =&gt; \'year\',\r\n		2592000 =&gt; \'month\',\r\n		604800 =&gt; \'week\',\r\n		86400 =&gt; \'day\',\r\n		3600 =&gt; \'hr\',\r\n		60 =&gt; \'min\',\r\n		1 =&gt; \'sec\'\r\n);\r\nforeach ($tokens as $unit =&gt; $text) {\r\n	if ($time &lt; $unit) continue;\r\n	$numberOfUnits = floor($time / $unit);\r\n	return $numberOfUnits.\' \'.$text.(($numberOfUnits&gt;1)?\'s\':\'\');\r\n}\r\n}\r\n\r\n?&gt;', 1498711399),
(371, 3, 1, 'A', 1498711512),
(372, 3, 1, '&lt;script&gt;\r\n                    $(document).ready(function(e) {\r\n							$(&quot;#chats&quot;).html(\'&lt;center&gt;&lt;img src=&quot;images/spinner.gif&quot; style=&quot;width: 50px;&quot;&gt;&lt;/center&gt;\');\r\n							//load all msgs initially\r\n							$(&quot;#chats&quot;).load(\'manipulates/load_chat.php\');\r\n                        setTimeout(function(){ \r\n							//set 3 sec refresh time for msg\r\n                            $(&quot;#chats&quot;).load(\'manipulates/load_chat.php\');\r\n                        }, 5000);\r\n						  // keep scroll bar at bottom\r\n                         $(\'.scroll\').scrollTop($(\'.scroll\')[0].scrollHeight);\r\n                    });\r\n                &lt;/script&gt;', 1498711532),
(450, 1, 3, 'hey', 1498731267),
(451, 3, 1, 'hii', 1498731291),
(452, 3, 1, '$.ajax({\r\n		type: &quot;POST&quot;,\r\n		url: &quot;manipulates/msg_count.php&quot;,\r\n		success: function (response) {\r\n			if(response!=0){\r\n			$(&quot;#msg_count&quot;).addClass(\'label label-danger\');\r\n			document.getElementById(&quot;msg_count&quot;).innerHTML=response; \r\n			}\r\n		}\r\n		});', 1498731381),
(454, 3, 1, 'helo', 1498731563),
(455, 3, 1, 'asabsm', 1498731569),
(456, 1, 3, 'hey', 1498732074),
(457, 1, 3, 'how are u', 1498732151),
(458, 3, 1, 'm fine', 1498732190),
(459, 1, 3, 'okay', 1498732215),
(460, 3, 1, 'askj', 1498732248),
(461, 1, 3, 'asa', 1498732274),
(462, 3, 1, 'asjk', 1498732281),
(463, 1, 3, 'asas', 1498732287),
(464, 3, 1, 'asa,s', 1498732293),
(465, 1, 3, 'asask', 1498732307),
(466, 3, 1, 'asjk', 1498732315),
(467, 1, 3, 'asajs', 1498732537),
(468, 4, 3, 'hii bro', 1498732557),
(469, 1, 3, 'ehaj', 1498732766),
(470, 3, 1, 'asj', 1498732774),
(471, 1, 3, 'ehaj', 1498732819),
(472, 1, 3, 'as', 1498732851),
(473, 1, 3, 'asa', 1498732894),
(477, 1, 3, 'Hey', 1498804818),
(617, 1, 4, 'saslaksa', 1498911385),
(618, 1, 4, 'asjlsa', 1498911460),
(619, 1, 4, 'asnskasn', 1498911502),
(620, 1, 4, 'aslkas', 1498911546),
(621, 4, 1, 'as', 1498911561),
(622, 1, 4, 'skhajsh', 1498912540),
(623, 4, 1, 'skjdh', 1498912576),
(624, 4, 1, 'sajsh', 1498912652),
(625, 4, 1, 'zkjdksj', 1498912693),
(626, 4, 1, 'jshdkshdk', 1498912783),
(627, 4, 1, 'hey', 1498913902),
(628, 4, 1, 'hkj', 1498913981),
(629, 4, 1, 'dhfdfhk', 1498914003),
(630, 4, 1, '', 1498914006),
(631, 4, 1, 'skals', 1498915899),
(632, 4, 1, 'abmd', 1498918181),
(633, 1, 4, 'asbas', 1498918417),
(634, 1, 4, 'zsdjskd', 1498918440),
(635, 1, 4, 'n,sbds,nd', 1498918454),
(636, 1, 4, 'hey', 1498921971),
(637, 4, 1, 'hey', 1498922023),
(638, 4, 1, 'hey', 1499008807),
(639, 1, 2, 'shkshk\r\n', 1499064761),
(640, 1, 2, 'JHL', 1499064794),
(641, 1, 4, 'asa', 1499104144),
(642, 4, 1, 'hey', 1499139181);

-- --------------------------------------------------------

--
-- Table structure for table `user_message_status`
--

CREATE TABLE `user_message_status` (
  `msgstatusID` int(12) NOT NULL,
  `msgID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `read` varchar(2) NOT NULL DEFAULT '00',
  `readTime` int(12) DEFAULT NULL,
  `deleted` varchar(2) NOT NULL DEFAULT '00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_message_status`
--

INSERT INTO `user_message_status` (`msgstatusID`, `msgID`, `userID`, `read`, `readTime`, `deleted`) VALUES
(6, 6, 1, '10', 1498670706, '10'),
(359, 359, 1, '10', 1498670706, '10'),
(360, 360, 1, '10', 1498670706, '10'),
(361, 361, 1, '10', 1498670706, '10'),
(362, 362, 1, '10', 1498670706, '10'),
(363, 363, 1, '10', 1498670706, '10'),
(364, 364, 1, '01', 1498708925, '00'),
(365, 365, 3, '01', 1498708963, '00'),
(366, 366, 1, '01', 1498708982, '10'),
(367, 367, 1, '01', 1498709018, '00'),
(368, 368, 3, '01', 1498709024, '00'),
(369, 369, 3, '01', 1498711392, '00'),
(370, 370, 3, '01', 1498726743, '00'),
(371, 371, 3, '01', 1498726743, '00'),
(372, 372, 3, '01', 1498726743, '00'),
(450, 450, 1, '01', 1498731275, '00'),
(451, 451, 3, '01', 1498731376, '00'),
(452, 452, 3, '01', 1498731694, '00'),
(454, 454, 3, '01', 1498731694, '00'),
(455, 455, 3, '01', 1498731694, '00'),
(456, 456, 1, '01', 1498732165, '00'),
(457, 457, 1, '01', 1498732165, '00'),
(458, 458, 3, '01', 1498732191, '00'),
(459, 459, 1, '01', 1498732215, '00'),
(460, 460, 3, '01', 1498732252, '00'),
(461, 461, 1, '01', 1498732275, '00'),
(462, 462, 3, '01', 1498732282, '00'),
(463, 463, 1, '01', 1498732287, '00'),
(464, 464, 3, '01', 1498732302, '00'),
(465, 465, 1, '01', 1498732307, '00'),
(466, 466, 3, '01', 1498732322, '00'),
(467, 467, 1, '01', 1498732547, '00'),
(468, 468, 4, '00', 0, '00'),
(469, 469, 1, '01', 1498732767, '00'),
(470, 470, 3, '01', 1498732780, '00'),
(471, 471, 1, '01', 1498732827, '00'),
(472, 472, 1, '01', 1498732857, '01'),
(473, 473, 1, '01', 1498732897, '01'),
(477, 477, 1, '00', 0, '00'),
(617, 617, 1, '10', 1498922002, '10'),
(618, 618, 1, '10', 1498922002, '10'),
(619, 619, 1, '10', 1498922002, '10'),
(620, 620, 1, '10', 1498922002, '10'),
(621, 621, 4, '01', 1498922002, '01'),
(622, 622, 1, '10', 1498922002, '10'),
(623, 623, 4, '01', 1498922002, '01'),
(624, 624, 4, '01', 1498922002, '01'),
(625, 625, 4, '01', 1498922002, '01'),
(626, 626, 4, '01', 1498922002, '01'),
(627, 627, 4, '01', 1498922002, '01'),
(628, 628, 4, '01', 1498922002, '01'),
(629, 629, 4, '01', 1498922002, '01'),
(630, 630, 4, '01', 1498922002, '01'),
(631, 631, 4, '01', 1498922002, '01'),
(632, 632, 4, '01', 1498922002, '01'),
(633, 633, 1, '10', 1498922002, '10'),
(634, 634, 1, '10', 1498922002, '10'),
(635, 635, 1, '10', 1498922002, '10'),
(636, 636, 1, '10', 1498922002, '10'),
(637, 637, 4, '01', 1498922124, '00'),
(638, 638, 4, '01', 1499008973, '00'),
(639, 639, 1, '01', 1499082029, '00'),
(640, 640, 1, '01', 1499082029, '00'),
(641, 641, 1, '01', 1499139178, '00'),
(642, 642, 4, '00', 0, '00');

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

CREATE TABLE `user_session` (
  `u_sessionID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `session_name` varchar(256) NOT NULL,
  `session_time` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_social_con`
--

CREATE TABLE `user_social_con` (
  `usocialconID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `fb_name` varchar(256) DEFAULT NULL,
  `fb_privacy` int(2) NOT NULL DEFAULT '0',
  `in_name` varchar(256) DEFAULT NULL,
  `in_privacy` int(2) DEFAULT '0',
  `createTime` int(12) NOT NULL,
  `updateTime` int(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_social_con`
--

INSERT INTO `user_social_con` (`usocialconID`, `userID`, `fb_name`, `fb_privacy`, `in_name`, `in_privacy`, `createTime`, `updateTime`) VALUES
(1, 1, 'abhishburk', 1, 'abhishburk', 0, 1498986796, 1498992653);

-- --------------------------------------------------------

--
-- Table structure for table `user_workplace`
--

CREATE TABLE `user_workplace` (
  `workID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `companyName` varchar(256) DEFAULT NULL,
  `description` text,
  `position` varchar(256) NOT NULL,
  `startDate` date NOT NULL,
  `currentlyworking` int(11) NOT NULL DEFAULT '0',
  `endDate` date DEFAULT NULL,
  `createTime` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_workplace`
--

INSERT INTO `user_workplace` (`workID`, `userID`, `companyName`, `description`, `position`, `startDate`, `currentlyworking`, `endDate`, `createTime`) VALUES
(1, 1, 'MIT', '', 'Teacher', '2015-03-10', 1, '0000-00-00', 1497620794),
(2, 1, 'Clapdust', 'Test', 'Manager & Owner', '2015-03-10', 1, '0000-00-00', 1497625166);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branchID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseID`);

--
-- Indexes for table `event_status`
--
ALTER TABLE `event_status`
  ADD PRIMARY KEY (`estatusID`);

--
-- Indexes for table `forum_answers`
--
ALTER TABLE `forum_answers`
  ADD PRIMARY KEY (`answerID`);

--
-- Indexes for table `forum_answer_votes`
--
ALTER TABLE `forum_answer_votes`
  ADD PRIMARY KEY (`voteID`);

--
-- Indexes for table `forum_questions`
--
ALTER TABLE `forum_questions`
  ADD PRIMARY KEY (`fqID`);

--
-- Indexes for table `forum_question_tag`
--
ALTER TABLE `forum_question_tag`
  ADD PRIMARY KEY (`fqtID`);

--
-- Indexes for table `forum_question_votes`
--
ALTER TABLE `forum_question_votes`
  ADD PRIMARY KEY (`voteID`);

--
-- Indexes for table `forum_tags`
--
ALTER TABLE `forum_tags`
  ADD PRIMARY KEY (`ftagID`);

--
-- Indexes for table `friend_request`
--
ALTER TABLE `friend_request`
  ADD PRIMARY KEY (`friendreqID`);

--
-- Indexes for table `group_discussion`
--
ALTER TABLE `group_discussion`
  ADD PRIMARY KEY (`disID`);

--
-- Indexes for table `group_discussion_status`
--
ALTER TABLE `group_discussion_status`
  ADD PRIMARY KEY (`gdstatusID`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`gmID`);

--
-- Indexes for table `group_request`
--
ALTER TABLE `group_request`
  ADD PRIMARY KEY (`greqID`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`instituteID`);

--
-- Indexes for table `invitation`
--
ALTER TABLE `invitation`
  ADD PRIMARY KEY (`inviteID`);

--
-- Indexes for table `my_friends`
--
ALTER TABLE `my_friends`
  ADD PRIMARY KEY (`myfriendID`);

--
-- Indexes for table `news_feed`
--
ALTER TABLE `news_feed`
  ADD PRIMARY KEY (`feedID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `request_info`
--
ALTER TABLE `request_info`
  ADD PRIMARY KEY (`reqinfoID`);

--
-- Indexes for table `share_request_info`
--
ALTER TABLE `share_request_info`
  ADD PRIMARY KEY (`sharereqID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `users_edu`
--
ALTER TABLE `users_edu`
  ADD PRIMARY KEY (`ueID`);

--
-- Indexes for table `user_active`
--
ALTER TABLE `user_active`
  ADD PRIMARY KEY (`u_activeID`);

--
-- Indexes for table `user_events`
--
ALTER TABLE `user_events`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`groupID`);

--
-- Indexes for table `user_likes`
--
ALTER TABLE `user_likes`
  ADD PRIMARY KEY (`likeID`);

--
-- Indexes for table `user_message`
--
ALTER TABLE `user_message`
  ADD PRIMARY KEY (`msgID`);

--
-- Indexes for table `user_message_status`
--
ALTER TABLE `user_message_status`
  ADD PRIMARY KEY (`msgstatusID`);

--
-- Indexes for table `user_session`
--
ALTER TABLE `user_session`
  ADD PRIMARY KEY (`u_sessionID`);

--
-- Indexes for table `user_social_con`
--
ALTER TABLE `user_social_con`
  ADD PRIMARY KEY (`usocialconID`);

--
-- Indexes for table `user_workplace`
--
ALTER TABLE `user_workplace`
  ADD PRIMARY KEY (`workID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `branchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `event_status`
--
ALTER TABLE `event_status`
  MODIFY `estatusID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `forum_answers`
--
ALTER TABLE `forum_answers`
  MODIFY `answerID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `forum_answer_votes`
--
ALTER TABLE `forum_answer_votes`
  MODIFY `voteID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `forum_questions`
--
ALTER TABLE `forum_questions`
  MODIFY `fqID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `forum_question_tag`
--
ALTER TABLE `forum_question_tag`
  MODIFY `fqtID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `forum_question_votes`
--
ALTER TABLE `forum_question_votes`
  MODIFY `voteID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `forum_tags`
--
ALTER TABLE `forum_tags`
  MODIFY `ftagID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `friend_request`
--
ALTER TABLE `friend_request`
  MODIFY `friendreqID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `group_discussion`
--
ALTER TABLE `group_discussion`
  MODIFY `disID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `group_discussion_status`
--
ALTER TABLE `group_discussion_status`
  MODIFY `gdstatusID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `gmID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `group_request`
--
ALTER TABLE `group_request`
  MODIFY `greqID` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `instituteID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `invitation`
--
ALTER TABLE `invitation`
  MODIFY `inviteID` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `my_friends`
--
ALTER TABLE `my_friends`
  MODIFY `myfriendID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `news_feed`
--
ALTER TABLE `news_feed`
  MODIFY `feedID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notificationID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `commentID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `request_info`
--
ALTER TABLE `request_info`
  MODIFY `reqinfoID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `share_request_info`
--
ALTER TABLE `share_request_info`
  MODIFY `sharereqID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `users_edu`
--
ALTER TABLE `users_edu`
  MODIFY `ueID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_active`
--
ALTER TABLE `user_active`
  MODIFY `u_activeID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user_events`
--
ALTER TABLE `user_events`
  MODIFY `eventID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `groupID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_likes`
--
ALTER TABLE `user_likes`
  MODIFY `likeID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `user_message`
--
ALTER TABLE `user_message`
  MODIFY `msgID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=643;
--
-- AUTO_INCREMENT for table `user_message_status`
--
ALTER TABLE `user_message_status`
  MODIFY `msgstatusID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=643;
--
-- AUTO_INCREMENT for table `user_session`
--
ALTER TABLE `user_session`
  MODIFY `u_sessionID` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_social_con`
--
ALTER TABLE `user_social_con`
  MODIFY `usocialconID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_workplace`
--
ALTER TABLE `user_workplace`
  MODIFY `workID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
