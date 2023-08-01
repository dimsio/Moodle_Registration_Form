<?php
// thank_you_page.php

require_once(__DIR__ . '../../config.php'); // Include Moodle's configuration file.

// Ensure that only logged-in users can access this page (optional).
require_login();

// Display a "Thank You" message or any other custom content.
echo "Thank you for registering! Your account has been created successfully.";