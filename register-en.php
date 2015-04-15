<?php

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$country = $_POST["country"];
$email = $_POST["email"];
$family = $_POST["family"];
$adult2 = $_POST["adult2"];
$child1 = $_POST["child1"];
$child2 = $_POST["child2"];
$wholecourse = $_POST["wholecourse"];
$arrive_day = $_POST["arrive_day"];
$arrive_time = $_POST["arrive_time"];
$leave_day = $_POST["leave_day"];
$leave_time = $_POST["leave_time"];
$vegetarian = $_POST["vegetarian"];
$comment = $_POST["comment"];
$price = $_POST["price"];
$reg_datetime = $_POST["reg_datetime"];


if ( ! isset($firstname, $lastname, $country, $email) or ($price <= 0)) {
print "<html>
<head>
<title>Error!</title>
</head>
<body>
<h2>Error</h2>";
print "Firstname:$firstname:<br>";
print "Lastname:$lastname:<br>";
print "Country:$country:<br>";
print "Email:$email:<br>";
print "Price:$price:<br>";
print "
</body>
</html>";

  exit ("Invalid data.");
}

$DBhost = "cpanel7.int2000.net";
$DBuser = "int14915_mila";
$DBpass = "chagchen";
$DBName = "int14915_milarepa";
$table = "milarepa";
mysql_connect($DBhost,$DBuser,$DBpass) or die("Unable to connect to database $DBName.");
@mysql_select_db("$DBName") or die("Unable to select database $DBName");
$id = 'NULL';
$reg_datetime = date('Y-m-d H:i:s');

$sqlquery = "INSERT INTO $table VALUES(
  '$id',
  '$firstname',
  '$lastname',
  '$country',
  '$email',
  '$family',
  '$adult2',
  '$child1',
  '$child2',
  '$wholecourse',
  '$arrive_day',
  '$arrive_time',
  '$leave_day',
  '$leave_time',
  '$vegetarian',
  '$comment',
  '$price',
  '$reg_datetime')";

$results = mysql_query($sqlquery) or die(mysql_error());
$id = mysql_insert_id();

$sqlquery = "SELECT * FROM $table WHERE id=$id";
$results = mysql_query($sqlquery) or die(mysql_error());
$num = mysql_numrows($results);

if ($num != 1) {
	print "
<html>
<head>
<title>Error!</title>
</head>
<body>
<h2>Error</h2>
Please contact me asap! <a href=\"mailto:milarepa@buddhalaisuus.fi\">Zsolt</a>
</body>
</html>
";
die();
}


$row_array = mysql_fetch_array($results);
$day_arr = array("0" => "17 April (Friday)", "1" => "18 April (Saturday)", "2" => "19 April (Sunday)");
$meal_arr = array("0" => "breakfast", "1" => "lunch", "2" => "dinner");
$a_day = $row_array[arrive_day];
$a_time = $row_array[arrive_time];
$l_day = $row_array[leave_day];
$l_time = $row_array[leave_time];

#######################
# Printing the web page
#######################

print "
<html>
<head>
<title>Online registration for the Milarepa Camp</title>
<link href=\"style/form.css\" rel=\"stylesheet\" type=\"text/css\">
</head>
<body>
<p>
<table border=\"1\" cellspacing=\"5\" cellpadding=\"5\" class=\"text\">
  <tr><td colspan=\"2\" class=\"text\"><span class=\"mainlinkLiteral\">Online registration for the Milarepa Camp 17-19 April 2015</span></td></tr>
  <tr><td colspan=\"2\" class=\"text\">Thank you for registering!<p>Your registration number is <span class=\"mainlinkLiteral\">$row_array[id]</span><p>Course fee: <strong>$row_array[price] euros</strong><p>If you transfer the course fee to our bank account, please mention the registration number in the <i>message</i> field.</td></tr>
  <tr><td colspan=\"2\"></td></tr>
  <tr bgcolor=\"#CCCCCC\"><td colspan=\"2\" class=\"mainlink\">Basic information</td></tr>
  <tr><td class=\"text\"><span class=\"text\">Name</span></td><td>$row_array[lastname] $row_array[firstname]</td>
  <tr><td class=\"text\"><span class=\"text\">Country</span></td><td>$row_array[country]</td></tr>
  <tr><td><span class=\"text\">Email</span></td><td>$row_array[email]</td></tr>";

if ($row_array[family] == 1) print "
  <tr><td colspan=\"2\" bgcolor=\"#CCCCCC\"><span class=\"mainlink\">Family information</span></td></tr>";
if ($row_array[adult2]) print "
  <tr><td class=\"text\"><span class=\"text\">2<sup>nd</sup> adult</span></td><td colspan=\"4\">$row_array[adult2]</td></tr>";
if ($row_array[child1]) print "
  <tr><td class=\"text\"><span class=\"text\">Child 7-17</span></td><td colspan=\"4\">$row_array[child1]</td></tr>";
if ($row_array[child2]) print "
  <tr><td class=\"text\"><span class=\"text\">Child 7-17</span></td><td colspan=\"4\">$row_array[child2]</td></tr>";

print "
  <tr><td colspan=\"2\" bgcolor=\"#CCCCCC\"><span class=\"mainlink\">Attendance</span></td></tr>";

if ($row_array[wholecourse] == 1) {
  print "
  <tr align=\"left\" valign=\"top\"><td colspan=\"2\" nowrap><span class=\"text\">I will attend the whole course.</span></td></tr>";
  } else {
    print "
  <tr align=\"left\" valign=\"top\">
    <td nowrap colspan=\"2\">";
    print "
      <span class=\"text\">I will arrive on $day_arr[$a_day] for $meal_arr[$a_time]</span><br>";
    print "
      <span class=\"text\">I will leave on $day_arr[$l_day] after $meal_arr[$l_time]</span>";
    print "
    </td>
  </tr>";
}

print "
  <tr align=\"left\" valign=\"top\"><td colspan=\"2\" class=\"mainlink\" bgcolor=\"#CCCCCC\">Meals</td></tr>";

if ($row_array[vegetarian] == 1) {
  print "
  <tr align=\"left\" valign=\"top\"><td colspan=\"2\" class=\"text\"><span class=\"text\">I would like to have vegetarian food.</span></td></tr>";
  } else {
  print "
  <tr align=\"left\" valign=\"top\"><td colspan=\"2\" class=\"text\"><span class=\"text\">I am a compassionate meat eater.</span></td></tr>";
  } 

  if ($row_array[comment])  print "
  <tr align=\"left\" valign=\"top\" bgcolor=\"#CCCCCC\"><td colspan=\"2\" class=\"mainlink\">Notes</td></tr>
  <tr align=\"left\" valign=\"top\"><td colspan=\"2\" class=\"text\">$row_array[comment]</td></tr>";

print "
</table>
<hr>
<a href=http://www.buddhalaisuus.fi/milarepa/index.html>Back</a>
<br><font size=\"-2\">";

print date("l dS F Y H:i:s");

print "
</font>
</body>
</html>";

####################
# Sending email
####################

$to = $row_array[email];
$subject = "Milarepa Camp 17-19 April 2015 Finland - Reg. $row_array[id]";
$headers = 'From: Milarepa@buddhalaisuus.fi' . "\r\n" . 'Bcc: Milarepa@buddhalaisuus.fi'. "\r\n";

$body = <<< emailbody
Online registration for the Milarepa Camp 17-19 April 2015

Thank you for registering!

Your registration number is *$row_array[id]*
Course fee: $row_array[price] euros
If you transfer the course fee to our bank account, please mention the registration number in the message field.

Basic information
=================
Name: $row_array[lastname] $row_array[firstname]
Country: $row_array[country]
emailbody;

$body .= "
Email: $row_array[email]";

if ($row_array[family] == 1) $body .= "

Family information
==================";
if ($row_array[adult2]) $body .= "
2nd adult: $row_array[adult2]";
if ($row_array[child1]) $body .= "
Child 7-17: $row_array[child1]";
if ($row_array[child2]) $body .= "
Child 7-17: $row_array[child2]";

$body .= "

Attendance
==========";
if ($row_array[wholecourse] == 1) {
  $body .= "
I will attend the whole course.";
  } else {
    $body .= "
I will arrive on $day_arr[$a_day] for $meal_arr[$a_time]
I will leave on $day_arr[$l_day] after $meal_arr[$l_time]
";
}

if ($row_array[vegetarian] == 1) {
  $body .= "

I would like vegetarian food.";
  } else {
  $body .= "

I am a compassionate meat eater.";
  } 

  if ($row_array[comment]) $body .= "

Notes
=====
$row_array[comment]";

$body .= "

For more information please visit our website: http://milarepa.buddhalaisuus.fi
You can contact us on the Milarepa@buddhalaisuus.fi email address.

Kind reagards,
The organisers

------------------------------------------------------------------------------------
Note: If you don't know why did you receive this email, most likely somebody misused
your email address. If this is the case, please let us know.
Milarepa@buddhalaisuus.fi
";

$success = mail($to, $subject, $body, $headers);
?>
