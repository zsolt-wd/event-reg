<?
$DBhost = "localhost";
$DBuser = "int14915_mila";
$DBpass = "chagchen";
$DBName = "int14915_milarepa";
$table = "milarepa";
mysql_connect($DBhost,$DBuser,$DBpass) or die("Unable to connect to database $DBName.");
@mysql_select_db("$DBName") or die("Unable to select database $DBName");

$sqlquery = "SELECT * FROM $table ORDER BY firstname";
$results = mysql_query($sqlquery) or die(mysql_error());

$day_arr = array("0" => "17.4 (Friday)", "1" => "18.4 (Saturday)", "2" => "19.4 (Sunday)");
$meal_arr = array("0" => "breakfast", "1" => "lunch", "2" => "dinner");

print "
<html>
<head>
<title>Online-rekister&ouml;ityminen Milarepa-leirille 17-19.4.2015</title>
<link href=\"style/form.css\" rel=\"stylesheet\" type=\"text/css\">
</head>
<body>
<table border=\"1\" cellspacing=\"1\" cellpadding=\"2\" class=\"text\">
<tr>
  <th>ID</th>
  <th>nimi</th>
  <th>valtio</th>
  <th>email</th>
  <th>perhe</th>
  <th>p&auml;iv&auml;t</th>
  <th>ruoka</th>
  <th>huom.</th>
  <th>EUR</th>
  <th>rek. pvm.</th>
</tr>
";
$adult = 0;
$child = 0;
$total_income = 0;
while ($row_array = mysql_fetch_array($results)) {
  $a_day = $row_array[arrive_day];
  $a_time = $row_array[arrive_time];
  $l_day = $row_array[leave_day];
  $l_time = $row_array[leave_time];

#######################
# Printing the web page
#######################
  $adult++;
print "
  <tr>
    <td class=\"text\">$row_array[id]</td>
    <td class=\"text\">$row_array[firstname]&nbsp;$row_array[lastname]</td>
    <td class=\"text\">$row_array[country]</td>
    <td class=\"text\">$row_array[email]</td>";

if ($row_array[adult2] || $row_array[child1] || $row_array[child2]) {
    $familyprice = 0;
    print "
    <td class=\"text\">";
    if ($row_array[adult2]) {
	$adult++;
	print "
    aikiuinen: $row_array[adult2];<br>";
    }
    if ($row_array[child1]) {
	$child++;
	print "
    lapsi 7-17: $row_array[child1];<br>";
    }
    if ($row_array[child2]) {
	$child++;
	print "
    lapsi 7-17: $row_array[child2];<br>";
    }
    print "
    </td>";
    $coursefee += $familyprice;
} else print "<td class=\"text\">&nbsp</td>";

if ($row_array[wholecourse] == 1) {
    print "
  <td class=\"text\">&nbsp;</td>";
} else {
    print "
  <td class=\"text\">
    saapuu: $day_arr[$a_day] for $meal_arr[$a_time]<br>
    l&auml;htee: $day_arr[$l_day] after $meal_arr[$l_time]
  </td>";
}

if ($row_array[vegetarian] == 1) {
  print "
  <td class=\"text\">Kasvis</td>";
} else {
  print "
  <td class=\"text\">Liha</td>";
  } 

if ($row_array[comment]) {
print "
  <td class=\"text\">$row_array[comment]</td>";
} else print "
  <td class=\"text\">&nbsp;</td>";

print "
  <td class=\"text\" align=\"right\">$row_array[price]</td>";
  $total_income += $row_array[price];

print "
  <td class=\"text\" align=\"left\">$row_array[reg_datetime]</td>
</tr>";
}

print "
</table>
<p>
<table border=\"1\" cellpadding=\"5\">
  <tr>
    <th>aikuista</th><td>$adult</td>
  </tr>
  <tr>
    <th>lasta 7-17</th><td>$child</td>
  </tr>
  <tr>
    <th>EUR</th><td>$total_income</td>
  </tr>
</table>

<hr><font size=\"-2\">";

print date("l dS F Y H:i:s");

print "
</font>
</body>
</html>";
?>
