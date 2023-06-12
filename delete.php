<?php
    $conn = mysqli_connect('localhost', 'root', '', 'smarthome'); // DB 연결 
    
    $sql = "DELETE FROM tem_record;";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "데이터가 성공적으로 삭제되었습니다.";
        header("Location: index.php");
        exit; 
    } else {
        echo "데이터 삽입에 실패했습니다.";
    }
?>
