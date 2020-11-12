<?php
    session_start();
    unset($_SESSION['userid']);
    $con = mysqli_connect("localhost", "root", "", "spkr_prtl");
    if ( mysqli_connect_errno() ) 
    {
        header("Location: index.php?error=1");
    }
    if ( !isset($_REQUEST['username']) || !isset($_REQUEST['password']) ) 
    {
        header("Location: index.php?error=1");
    }
    $stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?');
    $stmt->bind_param('s', $_REQUEST['username']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0)
    {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        if (password_verify($_REQUEST['password'], $password))
        {
            $_SESSION['userid'] = $id;
            header("Location: mpaf.php");
        }
        else
        {
            header("Location: index.php?error=1");
        }
    }
    else 
    {
        header("Location: index.php?error=1");
    }
    $stmt->close();
?>