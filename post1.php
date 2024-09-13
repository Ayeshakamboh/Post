<?php
$data_file = 'data.json';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $fathers_name = $_POST['fathers_name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $university = $_POST['university'];
    $department = $_POST['department'];

    // Validate mobile number
    if (substr($mobile, 0, 2) !== '92' || strlen($mobile) !== 12) {
        echo "<p class='error'>Invalid mobile number. It should start with 92 and be 12 digits long.</p>";
        echo '<br><a href="?">Back to Form</a>';
        exit();
    }

    // Load existing data
    if (file_exists($data_file)) {
        $data = json_decode(file_get_contents($data_file), true);
    } else {
        $data = [];
    }

    // Check for duplicate mobile number
    foreach ($data as $entry) {
        if ($entry['mobile'] === $mobile) {
            echo "<p class='error'>Mobile number already exists.</p>";
            echo '<br><a href="?">Back to Form</a>';
            exit();
        }
    }

    // Add new entry
    $data[] = [
        'name' => $name,
        'fathers_name' => $fathers_name,
        'email' => $email,
        'dob' => $dob,
        'mobile' => $mobile,
        'university' => $university,
        'department' => $department
    ];

    // Save to JSON file
    file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));

    // Confirmation message
    echo "<p class='success'>Form submitted successfully!</p>";
    echo '<br><a href="?">Back to Form</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 600px;
        }
        h1 {
            margin-top: 0;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: #d9534f;
            font-weight: bold;
        }
        .success {
            color: #5bc0de;
            font-weight: bold;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Submit Your Information</h1>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="fathers_name">Father's Name:</label>
            <input type="text" id="fathers_name" name="fathers_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" required pattern="92\d{10}">

            <label for="university">University:</label>
            <input type="text" id="university" name="university" required>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
