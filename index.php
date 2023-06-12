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
        $conn = mysqli_connect('localhost', 'root', '', 'smarthome');
        $query = "SELECT * FROM tem_record ORDER BY id DESC LIMIT 1;";
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
        <h1><img class="title_img" src="https://cdn-icons-png.flaticon.com/512/8849/8849722.png" /> smarthome</h1>
        <div class="full_div">
            <div>
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
                        <img class="light_img" src="https://cdn-icons-png.flaticon.com/512/7073/7073756.png" />
                        <?php
                        $conn1 = mysqli_connect('localhost', 'root', '', 'smarthome');
                        $query1 = "SELECT led_status FROM led_control;";
                        $result1 = mysqli_query($conn1, $query1);
                        
                        $ledStatus = ""; // 초기값 할당
                        
                        if ($result1) {
                            $row = mysqli_fetch_assoc($result1);
                            $ledStatus = $row['led_status'];
                            if ($ledStatus){
                                echo "켜짐";
                            }
                            else{
                                echo "꺼짐";
                            }
                        } else {
                            echo "쿼리 실행 실패";
                        };
                        ?>
                        
                    </div>
                    <div class="door_div">
                        <p>Delete</p>
                        <a href="delete.php"><img class="light_img" src="https://cdn-icons-png.flaticon.com/512/7945/7945112.png" /></a>
                    </div>
                </div>
            </div>

            <?php
            $query = "SELECT * FROM tem_record ORDER BY id DESC LIMIT 30;";
            $result = mysqli_query($conn, $query);

            $i = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                if ($i == 0) {
                    $graph = $row['tem_status'];
                    $graph2 = $row['hum_status'];
                }

                $mytemp[$i] = $row['tem_status'];
                $myhumi[$i] = $row['hum_status'];
                $mydate[$i] = $i+1;
                $i++;
            }
            ?>
            <div class="graph_div" style="margin-left: 100px; margin-top: 65px;">
                <?php
                include 'graph.php';
                ?>
            </div>
        </div>
    </form>
</body>

</html>