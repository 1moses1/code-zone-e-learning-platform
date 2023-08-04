<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        /* Your existing styles for the form container go here */
        .form-container {
            /* Your existing styles for the form container go here */
        }

        /* Add this style to display messages in center, bolded, and with increased font size */
        .message {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        /* Add this style for success message in green color */
        .success-message {
            color: green;
            background-color: #90EE90;
        }

        /* Add this style to display error messages in red color */
        .error-message {
            color: red;
            background-color: #FFC0CB;
        }

        /* Add this style for the styled button */
        .styled-button {
    display: inline-block;
    text-align: center;
    position: center;
    font-weight: bold;
    font-size: 18px;
    padding: 8px 20px;
    border-radius: 10px;
    margin: 10px auto;
    text-decoration: none;
    color: white;
}

/* Style the button based on success or failure */
.styled-button.success-button {
    background-color: #4CAF50;
}

.styled-button.failure-button {
    background-color: #f44336;
}

    </style>
</head>
<body>
    <section class="form-container">
        <?php
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['pass'];

            if (!empty($name) && !empty($email) && !empty($password)) {
                // Database connection
                $link = mysqli_connect("localhost", "root", "1234", "code_zone_db");
                if ($link === false) {
                    die(mysqli_connect_error());
                }

                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Use prepared statements to insert data securely
                $sql = "INSERT INTO registered_users (name, email, password) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($link, $sql);

                // Bind the parameters to the prepared statement
                mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

                // Execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    echo '<p class="message success-message">Record inserted successfully!</p>';
                    echo '<a class="styled-button success-button" href="login.html">Go to Login</a>';
                } else {
                    echo '<p class="message error-message">Something went wrong or please provide all information!</p>';
                    echo '<a class="styled-button failure-button" href="register.html">Try Again</a>';
                }

                // Close the statement and the connection
                mysqli_stmt_close($stmt);
                mysqli_close($link);
            } else {
                echo '<p class="message error-message">Please provide all information!</p>';
                echo '<a class="styled-button failure-button" href="register.html">Try Again</a>';
            }
        }
        ?>
    </section>
</body>
</html>
