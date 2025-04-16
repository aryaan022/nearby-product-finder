
-- SQL query to create a contact_form_submissions table in phpMyAdmin

CREATE TABLE `contact_form_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` enum('new','read','replied','closed') DEFAULT 'new',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SQL query to insert form data (this would typically be done in your PHP code)
-- Example of how to insert form data in PHP:

-- 
-- $name = mysqli_real_escape_string($conn, $_POST['name']);
-- $email = mysqli_real_escape_string($conn, $_POST['email']);
-- $phone = mysqli_real_escape_string($conn, $_POST['phone']);
-- $subject = mysqli_real_escape_string($conn, $_POST['subject']);
-- $message = mysqli_real_escape_string($conn, $_POST['message']);
-- $ip = $_SERVER['REMOTE_ADDR'];
-- 
-- $sql = "INSERT INTO contact_form_submissions (name, email, phone, subject, message, ip_address) 
--         VALUES ('$name', '$email', '$phone', '$subject', '$message', '$ip')";
-- 
-- if (mysqli_query($conn, $sql)) {
--     echo "Form submission successful";
-- } else {
--     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
-- }
--
