<?php
    session_start();
    $con = mysqli_connect("localhost", "root", "", "spkr_prtl");
    if ( mysqli_connect_errno() ) 
    {
        echo "We encountered an error.";
    }
    if ( !isset($_SESSION['userid']) ) 
    {
        echo "We encountered an error.";
    }
    $l1 = implode(",",$_REQUEST['list1']);
    $l2 = implode(",",$_REQUEST['list2']);
    $stmt = $con->prepare('UPDATE users SET list1 = ?, list2 = ? WHERE id = ?');
    $stmt->bind_param('ssi', $l1, $l2, $_SESSION['userid']);
    $stmt->execute();
    if ($stmt)
    {
        echo "Your list has been saved successfully.";
    }
    else 
    {
        echo "We encountered an error.";
    }
    $stmt->close();
?>