<?php

require_once '_guards.php';
Guard::guestOnly();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/main-style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="icon" type="image/x-icon" href="icon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 2em;
            background-color: #E7F0DC;
            font-family: 'Open Sans', sans-serif;
        }

        .page-title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            color: #597445;
            text-shadow: rgba(0, 0, 0, 0.3) 0px 10px 20px;
        }

        .login-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80vh;
        }

        .login-form {
            width: 40%;
            color: #fff;
            background-color: #597445;
            padding: 20px;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 60px 40px -7px;
            font-family: 'Open Sans', sans-serif;
        }

        .form-control input[type="text"],
        .form-control input[type="password"] {
            background-color: #F0F8F2;
            color: #525865;
            border-radius: 4px;
            border: 1px solid #d1d1d1;
            box-shadow: inset 0px 1px 8px rgba(0, 0, 0, 0.2);
            font-family: inherit;
            font-size: 1em;
            line-height: 1.45;
            outline: none;
            padding: 0.6em 1.45em 0.7em;
            -webkit-transition: .18s ease-out;
            -moz-transition: .18s ease-out;
            -o-transition: .18s ease-out;
            transition: .18s ease-out;
        }

        .form-control input[type="text"]:focus,
        .form-control input[type="password"]:focus {
            color: #4b515d;
            border-color: #B8B6B6;
            box-shadow: inset 1px 2px 4px rgba(0, 0, 0, 0.01), 0px 0px 8px rgba(0, 0, 0, 0.2);
        }

        .form-control label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .form-control label i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: #729762;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Open Sans', sans-serif;
        }

        .btn-primary:hover {
            background-color: #A25772;
        }
    </style>
</head>

<body>
    </br></br>
    <div class="page-title">POINT OF SALE & INVENTORY SYSTEM</div>

    <div class="login-container">
        <div class="login-form card">

            <div class="card-header">
                <div class="card-title">LOGIN FIRST</div>
            </div>

            <div class="card-content">
                <form method="POST" action="api/login_controller.php">

                    <?php displayFlashMessage('login') ?>

                    <div class="form-control">
                        <label><i class="fas fa-envelope"></i> EMAIL</label>
                        <input type="text" name="email" placeholder="Enter your email" required="true" />
                    </div>

                    <div class="form-control mt-16">
                        <label><i class="fas fa-lock"></i> PASSWORD</label>
                        <input type="password" name="password" placeholder="Enter your password" required="true" />
                    </div>


                    <div class="mt-16 flex justify-end">
                        <button class="btn btn-primary" type="submit">LOGIN</button>
                    </div>

                </form>
            </div>
        </div>

        <div class="login-image">
            <img src="image.png" alt="Nature Image">
        </div>
    </div>

</body>

</html>