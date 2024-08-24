<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';
session_start();

if (isset($_POST['uname']) && isset($_POST['pword'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pword = validate($_POST['pword']);

    if (empty($uname) || empty($pword)) {
        header("Location: index.php?error=User Name and Password are required");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Use MD5 for user passwords
        if (md5($pword) === $row['pword']) {
            $_SESSION['uname']   = $row['uname'];
            $_SESSION['contact'] = $row['contact'];
            $_SESSION['email']   = $row['email'];
            $_SESSION['id']      = $row['id'];
            header("Location: home.php");
            exit();
        } else {
            header("Location: index.php?error=Incorrect username or password");
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE uname = ?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $resultAdmin = $stmt->get_result();

        if ($resultAdmin->num_rows === 1) {
            $rowAdmin = $resultAdmin->fetch_assoc();

            // Use MD5 for admin passwords
            if (md5($pword) === $rowAdmin['pword']) {
                $_SESSION['uname']     = $rowAdmin['uname'];
                $_SESSION['position']  = $rowAdmin['position'];
                $_SESSION['name']      = $rowAdmin['name'];
                $_SESSION['id']        = $rowAdmin['id'];
                header("Location: admin.php");
                exit();
            } else {
                header("Location: index.php?error=Incorrect username or password");
            }
        } else {
            header("Location: index.php?error=Incorrect username or password");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>

