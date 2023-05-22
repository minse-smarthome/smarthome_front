<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="index_style.css" rel="stylesheet">
    <title>smarthome</title>
</head>
<body>
    <form action="index.php">
    <?php
$conn = mysqli_connect('localhost', 'root', '', 'tem_record');
$query = "SELECT * FROM tem_record ORDER BY tem_id DESC LIMIT 1;";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $tem_status = $row['tem_status'];
    $hum_status = $row['hum_status'];
} else {
    // Handle case when no records are found
    $tem_status = 'N/A';
    $hum_status = 'N/A';
}
?>
        <h1><img class="title_img" src="https://cdn-icons-png.flaticon.com/512/8849/8849722.png"/> smarthome</h1>
        <div class="top_div">
            <div class="tem_div">
                <p>Temp</p>
                <?php echo $tem_status . "°C"; ?>
            </div>
            <div class="hum_div">
                <p>Humidity</p>
                <?php echo $hum_status . "(%)"; ?>
            </div>
        </div>
        <div class="bottom_div">
            <div class="light_div">
                <p>Light</p>
                <img class="light_img" src="https://cdn-icons-png.flaticon.com/512/7073/7073756.png"/>
            </div>
            <div class="door_div">
                <p>Door</p>
                <img class="light_img" src="https://cdn-icons-png.flaticon.com/512/252/252385.png"/>
            </div>
        </div>

<?php
    $query = "SELECT * FROM tem_record;";
    $result = mysqli_query($conn, $query);
?>
    </form>
</body>
</html>