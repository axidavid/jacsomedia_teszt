<?php
    session_start();
    $con = mysqli_connect("localhost", "root", "", "spkr_prtl");
    if ( mysqli_connect_errno() ) 
    {
        echo '0';
    }
    else
    {
        if ( !isset($_SESSION['userid']) ) 
        {
            echo '0';
        }
        else
        {
            $stmt = $con->prepare('SELECT list1, list2 FROM users WHERE id = ?');
            $stmt->bind_param('i', $_SESSION['userid']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0)
            {
                $stmt->bind_result($list1, $list2);
                $stmt->fetch();
                echo $list1."|".$list2;
            }
            else
            {
                echo '0';
            }
            $stmt->close();
        }
    }
?>