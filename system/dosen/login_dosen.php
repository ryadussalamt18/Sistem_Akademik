<?php
session_start();
$registered_nid = isset($_SESSION['registered_nid']) ? $_SESSION['registered_nid'] : '';
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['registered_nid']);
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dosen</title>
    <link rel="stylesheet" href="global_css/login_register.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 10px);
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #ffa500;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #ff7f00;
        }

        p {
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <?php if ($login_error) : ?>
            <div class="error-message"><?php echo $login_error; ?></div>
        <?php endif; ?>
        <?php if ($registered_nid) : ?>
            <div class="info-message">Silakan gunakan NID yang telah didaftarkan: <?php echo $registered_nid; ?></div>
            <a href="#" id="showNIDButton">Tampilkan NID</a>
            <div id="nidDisplay" style="display: none;">
                <p>NID Anda: <strong><?php echo $registered_nid; ?></strong></p>
            </div>
        <?php endif; ?>
        <form action="process_login_dosen.php" method="POST">
            <div class="form-group">
                <label for="nid">NID</label>
                <input type="text" id="nid" name="nid" value="<?php echo $registered_nid; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register_dosen.php">Daftar disini</a></p>
    </div>
    <script>
        document.getElementById('showNIDButton').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('nidDisplay').style.display = 'block';
        });
    </script>
</body>

</html>