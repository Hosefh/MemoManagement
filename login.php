<?php
    session_start();
    include "dbcon.php";
    // include_once "loading.php";
    if (isset($_POST['username']) && isset($_POST['user_password']))
    {
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $username =$_POST['username'];
        $password = $_POST['user_password'];

        $sql = "SELECT * FROM users WHERE username='$username' and `password`=password('$password');";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1)
        {
            $row = mysqli_fetch_assoc($result);
            // $password = md5($password);
                // if($row['privilege'] === $privilege)
                // {
            echo "Logged IN";
            $_SESSION['useridname'] = $row['employee_name'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['userid'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            if($row['privilege']==="admin")
            {
                header("Location: admin/index.php");
            }
            else
            {
                header("Location: faculty/index.php");
            }
                // }
                // else
                // {
                //     echo "<script>
                //     alert('Invalid Account Privilege');
                //     window.location.href='index.php';
                //     </script>";
                // }
        } 
        else{
            echo "<script>
            alert('NO Account Registered under said credentials.');
            window.location.href='index.php';
            </script>";
        }
    }
?>