<?php
if (isset($_POST['toggle'])) {
  $url = "http://10.150.150.110/toggle";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_exec($ch);
  curl_close($ch);
}
?>

<html>
<head>
  <title>LED Control</title>
</head>
<body>
  <form method="POST" action="">
    <button type="submit" name="toggle">Toggle LED</button>
  </form>
</body>
</html>
