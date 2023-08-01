<?php

require_once('../../config.php');
$PAGE->set_context(context_system::instance());  //We must specify the Moodle context to which the current page belongs

$PAGE->set_url(new moodle_url('/local/registration_form/index.php')); //Each page should have a unique URL. That is the address that should be used to return to the page e.g. after editing a block on it
$PAGE->set_pagelayout('standard'); //All supported layouts are defined in the theme/{theme_name}/config.php file of the currently used theme or its parent themes. Commonly used layouts are base (which is the default one), standard, course, frontpage, mydashboard and login
$PAGE->set_title('Registration Form'); //The following code is used to set the page title
$PAGE->set_heading('Registration Form'); //To define the text that should be displayed as the main heading on the page
require_once(__DIR__ . '/registration_form.php');
echo $OUTPUT->header(); //To finish the DOM initialisation and start outputting the HTTP headers and the actual <html> content, call
// Instantiate the registration form and display it.
//$registration_form = new registration_form();
$registration_form = new registration_form();
$registration_form->print_form();
// Finish the page output.
echo $OUTPUT->footer(); //To print the footer on the page, closing </body> and </html> tags and to finalise the output rendering, call