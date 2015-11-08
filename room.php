<?php
	require_once('files/models.php');
	$id = mysql_real_escape_string($_GET['id']);
	$people_of_room = mysql_fetch_assoc(mysql_query("SELECT `first_p`, `second_p` FROM `rooms` WHERE `id` = ".$id.""));
	$first_people = $people_of_room['first_p'];
	$second_people = $people_of_room['second_p'];
?>
<?php
	if(($first_people == $_COOKIE['id']) OR ($second_people == $_COOKIE['id'])) {
	echo '<script src="http://static.opentok.com/v2/js/opentok.min.js"></script>
    <script type="text/javascript">

		var apiKey = "45401662";
      var sessionId = "1_MX40NTQwMTY2Mn5-MTQ0Njk1MTAwODc3OX52NU0xdlljRXY4UUVoYXAwcG9QaWhublR-fg";
      var token = "T1==cGFydG5lcl9pZD00NTQwMTY2MiZzaWc9NjZjY2UzZTczNTQ3OWJlYzYzZGIwNjFjODYxOTAzMGQ5MGM2NzNlYzpyb2xlPXB1Ymxpc2hlciZzZXNzaW9uX2lkPTFfTVg0ME5UUXdNVFkyTW41LU1UUTBOamsxTVRBd09EYzNPWDUyTlUweGRsbGpSWFk0VVVWb1lYQXdjRzlRYVdodWJsUi1mZyZjcmVhdGVfdGltZT0xNDQ2OTUxMDE5Jm5vbmNlPTAuODMzOTQ3MjgxMzU1NTEyMSZleHBpcmVfdGltZT0xNDQ3MDM3MzIxJmNvbm5lY3Rpb25fZGF0YT0=";

      var session = OT.initSession(apiKey, sessionId);
 
      session.on("streamCreated", function(event) {
        session.subscribe(event.stream);
      });
     
      session.connect(token, function(error) {
        var publisher = OT.initPublisher();
        session.publish(publisher);
      });
		
    </script>';
	}
?>
<html>
  <head>
    <title>Holywars</title>
  </head>
  <body>
    <div id="myPublisherDiv"></div>
  </body>
</html>