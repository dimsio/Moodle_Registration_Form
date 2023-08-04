<?php

// registration_form.php
//namespace registration_form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class registration_form extends moodleform {
    public function definition() {
        // Create the form.
        $form = $this->_form;

        // Add form elements here.
        $form->addElement('text', 'email', 'Email:');
        $form->setType('email', PARAM_TEXT);
        $form->addRule('email', 'This field is required', 'required');
        $form->addRule('email', 'Invalid email address', 'email');

        $form->addElement('text', 'name', 'Name:');
        $form->setType('name', PARAM_TEXT);
        $form->addRule('name', 'This field is required', 'required');

        $form->addElement('text', 'surname', 'Surname:');
        $form->setType('surname', PARAM_TEXT);
        $form->addRule('surname', 'This field is required', 'required');

        $form->addElement('text', 'country', 'Country:');
        $form->setType('country', PARAM_TEXT);

        $form->addElement('text', 'mobile', 'Mobile:');
        $form->setType('mobile', PARAM_TEXT);

        // Add a submit button.
        $form->addElement('submit', 'submitbtn', 'Register');
    }

    public function send_temporary_password_to_user_email($temporary_password, $user_email) {
        // Set the email subject and content.
        $subject = "Your Temporary Password for Moodle";

        $message = "Dear User,\n\n";
        $message .= "You have successfully registered on our Moodle site. ";
        $message .= "Your temporary password is: " . $temporary_password . "\n\n";
        $message .= "Please log in with this temporary password and change it immediately for security reasons. ";
        $message .= "You can change your password from your profile settings in Moodle.\n\n";
        $message .= "Thank you for joining our Moodle community.\n";
        $message .= "Best regards,\n";
        $message .= "Your Moodle Site Team";

        // Additional headers (optional).
        $headers = "From: Your Moodle Site <noreply@example.com>\r\n";
        $headers .= "Reply-To: Your Moodle Site Admin <admin@example.com>\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

        // Send the email.
        if (mail($user_email, $subject, $message, $headers)) {
            // Email sent successfully.
            return true;
        } else {
            // Email sending failed.
            return false;
        }
    }

    // Process form submission.
    public function process_data($data) {
        global $DB;  //is a global variable that represents the database connection object.
        var_dump($data);
        // Create a new user and store the data in the database.
        $newuser = new stdClass();  // is a generic class in PHP used to create objects with arbitrary properties. The properties are dynamic, which means you can add any property to the object without any restrictions.
        $newuser->username = $data->email;
        // Generate a temporary password with 8 characters.
        $temporary_password = 'Acce$$1234';//random_string(8);
        $newuser->password = hash_internal_user_password($temporary_password); // Hash the temporary password for security.
        $newuser->firstname= $data->name;
        $newuser->lastname= $data->surname;
        $newuser->email= $data->email;
        //$newuser->country= $data->country;
        $newuser->mobile= $data->mobile;
        $newuser->auth= 'email';

        // Insert the new user into the database.
        $newuserid = $DB->insert_record('user', $newuser);
        // Send the temporary password to the user's email for them to log in and change it.
        send_temporary_password_to_user_email($temporary_password, $data->email);

        if ($newuserid) {
            // User registration successful.

            // Display a success message using Moodle's messaging system.
            \core\notification::add_success('User registered successfully.');

            // Redirect the user to the custom "Thank You" page you created.
            redirect($CFG->wwwroot . '/local/registration_form/thank_you_page.php');
        } else {
            // Display the SQL statement and the error message for debugging.
			echo "SQL Error: " . $DB->sql_error();
			echo "Generated SQL: " . $DB->last_sql();
			
            $this->display_error_message('User registration failed. Please try again later.');
            return false; // Return false to indicate that the process_data failed.
        }

        return true; // Return true to indicate that the process_data was successful.
    }

    // Display the form on a Moodle page.
    public function print_form(){
        // Continue displaying the rest of the form elements.
        echo $this->display();

       
    }
}