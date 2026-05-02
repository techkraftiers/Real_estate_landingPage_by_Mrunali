<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /*Login page*/
        #login_body{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #F3F4F4;
        }
        .form-box{
        width: 90%;
        max-width: 540px;
        box-shadow: 0 10px 15px rgba(0,0,0,0.4);
        padding: 2rem 2.5rem;
        text-align: center;
        background-color: #fff;
        border-radius: 1rem;
        }
        .form-box.active{
        display: block;
        }
        .form-box form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.4rem;
        }
        .form-box h2{
        font-size: 3rem;
        margin: 1.8rem 0;
        color: #34656D;
        }
        form input, form textarea{
        width: 75%;
        padding: 1rem;
        font-size: 1.4rem;
        border: none;
        background-color: #cfd8d8;
        }
        form button{
        padding: .8rem 1.4rem;
        width: 75%;
        border: none;
        background-color: #34656D;
        color: #fff;
        font-size: 1.4rem;
        border-radius: .5rem;
        font-weight: 400;
        cursor: pointer;
        }
        form button:hover{
        background-color: #34656D;
        }
        .form-box p{
        font-size: 1.4rem;
        margin: 1.4rem 0;
        cursor: pointer;
        }

    </style>
</head>
<body>
    <!--Registor form-->
    <div class="form-box" id="register-content">
        <h2>Register</h2>
        <form action="login_register.php" method="post">
            <input type="text" name="name" placeholder="Enter yours name" required>
            <input type="email" name="email" placeholder="Enter yours email" required>
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="register">Resgister</button>
        </form>
        <p>Already have an account? <a href="login.php"> Login</a></p>
    </div>
</body>
</html>
