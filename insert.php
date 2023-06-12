<?php
$conn = mysqli_connect('localhost', 'root', '', 'smarthome'); // DB 연결 
sleep(1);
// tem_status와 hum_status를 정수로 변환하여 쿼리에 사용합니다.
$tem_status = intval($_GET['tem_status']);
$hum_status = intval($_GET['hum_status']);
$led_status = intval($_GET['led_status']);

// tem_status와 hum_status를 사용하여 tem_record 테이블에 데이터를 삽입하는 쿼리
$sql = "INSERT INTO tem_record (tem_status, hum_status) VALUES ($tem_status, $hum_status)";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "tem_record 테이블에 데이터가 성공적으로 삽입되었습니다.";
} else {
    echo "tem_record 테이블에 데이터 삽입에 실패했습니다.";
}

// led_status를 led_control 테이블의 led_status로 업데이트하는 쿼리
$sql2 = "UPDATE led_control SET led_status = $led_status";
$result2 = mysqli_query($conn, $sql2);

if ($result2) {
    echo "led_control 테이블의 데이터가 성공적으로 업데이트되었습니다.";
} else {
    echo "led_control 테이블의 데이터 업데이트에 실패했습니다.";
}

// 연결을 닫습니다.
mysqli_close($conn);
?>
