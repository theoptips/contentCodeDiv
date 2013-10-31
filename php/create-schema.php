<?php

/*
Preamble: This shows you how to run some basic SQL from within a PHP script
Yes, it's overkill. But, let's assume you'll be doing this on the fly in the future
(think of when someone registers with your killer website and wants to create an account)
you'll need this sort of approach vs. sending you an email and then you manually going
into PHPMyAdmin to do it.

So, that said...it ASSUMES you've already installed XAMPP and set it up and gotten
MySQL running and configured with a DB named "sample" and a user named "jimi" with the
below password ('scuse me while i kiss the sky if you're curious about the pwd). Or if
you're all Cloud and stuff, you've got some fancy Amazon S3 thingy running who knows where
and you've spun that up and can pay the billz.

I recommend seeing if you can get this working, break and fix some things to test what
you think you know about the system, and then seeing if you can create some of
your own tables. You can use PHPMyAdmin and look at the SQL it generates to know what
to plug into your statements below.

Finally...if at anytime you find a better way to do any of this...YES!!! Teach someone
else and encourage them to move the Human Race forward. Now...GOOD LUCK and HAVE FUN!!! :D
*/

// force errors to show
ini_set('display_errors', 'On');

// turn off errors by uncommenting the line below
#error_reporting(0);

//setup the link to your DB...IP of your DB, username, password
if ($lnk = mysql_connect('127.0.0.1', 'jimi', 'smw1kts')) {
	mysql_select_db('sample', $lnk);
} else {
	echo "FAILED TO CONNECT TO DB";
	exit;
}

//we'll use this later as an error checker
$e = 0;

//note the naming convention...technically, everything in a DB is a table
//but in your code it helps to know the difference between the DB names and the tablenames
$sql2 = "CREATE TABLE IF NOT EXISTS `tblsample` (
	  `ID` int(11) NOT NULL auto_increment,
	  `FirstName` varchar(255) NOT NULL default '',
	  `LastName` varchar(255) NOT NULL default '',
	  `email` varchar(255) NOT NULL default '',
	  PRIMARY KEY  (`ID`),
	  KEY `fname` (`FirstName`),
	  KEY `lname` (`LastName`),
	  KEY `em` (`email`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1";
$result2 = mysql_query($sql2);

#$sql = "SHOW TABLES FROM sample WHERE tables_in_sample != 'tblfoo'";
$sql = "SHOW TABLES FROM sample";
$result = mysql_query($sql);

//here, we only have one table, but usually you have more than that...the loop interates
//thru them all
while ($row = mysql_fetch_row($result)) {
	$sql1 = "SHOW COLUMNS FROM $row[0] LIKE 'password'";
	$result1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($result1);
//	extract($row1);
	if (empty($row1)) {
		echo "Error! Error, missing required fields 'password' in table $row[0]\n";
		$e++;
	} else {
		//comment this out once you get things cleaner
		echo "OK\n";
	}
}

if ($e == 0) {
	echo "All clean! Miller Time!\n";
}
?>