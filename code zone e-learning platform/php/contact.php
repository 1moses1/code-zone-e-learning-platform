<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
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

        /* Add this style for the styled button */
        .styled-button {
            display: inline-block;
            text-align: center;
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
    </style>
</head>
<body>
    <section class="form-container">
        <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $contact = $_POST['number'];
            $message = $_POST['msg'];

            if (!empty($name) && !empty($email) && !empty($contact) && !empty($message)) {
                // Database connection
                $link = mysqli_connect("localhost", "root", "1234", "code_zone_db");
                if ($link === false) {
                    die(mysqli_connect_error());
                }

                // Use prepared statements to insert data securely
                $sql = "INSERT INTO contact_form (name, email, contact, message) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $contact, $message);

                // Execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    echo '<p class="message success-message">Your message has been received successfully!</p>';
                    echo '<a class="styled-button success-button" href="contact.html">Go Back</a>';
                } else {
                    echo '<p class="message error-message">Something went wrong. Please try again later!</p>';
                    echo '<a class="styled-button failure-button" href="contact.html">Try Again</a>';
                }

                // Close the statement and the connection
                mysqli_stmt_close($stmt);
                mysqli_close($link);
            } else {
                echo '<p class="message error-message">Please provide all required information!</p>';
                echo '<a class="styled-button failure-button" href="contact.html">Try Again</a>';
            }
        }
        ?>
    </section>
</body>
</html>
