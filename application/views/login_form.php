<!DOCTYPE html>
<html lang="en">

<head>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #6e8efb;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #6e8efb;
            color: white;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5a74d3;
        }

        .alert {
            margin-top: 15px;
            padding: 12px;
            background: #f44336;
            color: white;
            border-radius: 5px;
            text-align: center;
            display: none;
        }

        /*  Responsive Styles */
        @media (max-width: 480px) {
            .login-box {
                padding: 25px 20px;
            }

            input[type="text"],
            input[type="password"],
            button {
                font-size: 14px;
                padding: 10px;
            }

            .login-box h2 {
                font-size: 22px;
            }
        }
    </style>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

    <div class="login-box">
        <h2>🔐 Login</h2>
        <form id="loginForm">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="name" required />
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required />
            </div>
            <button type="submit">Login</button>
        </form>

        <div class="alert" id="errorAlert"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    url: "<?php echo base_url(); ?>Login/login",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "<?= base_url('view/home/'); ?>";
                        } else {
                            $('#errorAlert').text(response.message).show();
                        }
                    },
                    error: function() {
                        $('#errorAlert').text("An error occurred. Please try again.").show();
                    }
                });
            });
        });
    </script>

</body>

</html>