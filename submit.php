<?php
if(isset($_POST['submit']))
{
    //Create Connection
        $db_host = 'db hostname here';
        $db_username = 'db username here';
        $db_password = 'db password here';
        $db_name = 'name of database';

        $connect = mysql_connect($db_host, $db_username, $db_password, $db_name);

    //Check connection 
        if($connect === false){
            die("Error: Could not connect. " . mysqli_connect_error());
        }

    //Filter Inputs
        //filter names
        function filterNames($field){
            //sanitize
            $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
            //validate
            if(filter_var($field, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
                return $field;
            } else {
                return FALSE;
            }
        }

        //filter email
        function filterEmail($field){
            //sanitize
            $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL));
            //validate
            if(filter_var($field), FILTER_VALIDATE_EMAIL)){
                return $field;
            } else{
                return FALSE;
            } 
        }

        //filter strings
        function filterString($field){
            //sanitize
            $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
            //validate
            if(!empty($field)){
                return $field;
            } else{
                return FALSE;
            }
        }

        //filter int
        function filterInt($field){
            //sanitize
            $field = filter_var($field, FILTER_SANITIZE_NUMBER_INT));
            //validate
            if(filter_var($field, FILTER_VALIDATE_INT)) {
                return $field;
            } else {
                return FALSE;
            }
        }

    //Posts
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $last_name = $_POST['lastname'];
            $first_name = $_POST['firstname'];
            $initials = $_POST['initials'];
            $id = $_POST['id'];
            $cell_phone = $_POST['cellphone'];
            $home_phone = $_POST['homephone'];
            $email = $_POST['email'];
            $qualification = $_POST['qualification'];
            $grad = $_POST['grad'];
            $housenumber = $_POST['housenumber'];
            $streetaddress = $_POST['streetaddress'];
            $suburb = $_POST['suburb'];
            $city = $_POST['city'];
            $province = $_POST['province'];
            $area = $_POST['area'];
            $course_choice = $_POST['course-choice'];
            $artitic_details = $_POST['artitic-details'];
            $medicalconditions = $_POST['medicalconditions'];
            //Feedback (Checkbox and Radio)
            $emergency_name = $_POST['emergencyname'];
            $emergency_name2 = $_POST['emergencyname2'];
            $emergency_no = $_POST['emergencyno'];
            $emergency_no2 = $_POST['emergencyno2'];
            $relationship = $_POST['relationship'];
            $doc_name = $_POST['docname'];
            $doc_no = $_POST['docno'];

            //arrays for loops
            $name_array = array($last_name, $first_name, $emergency_name, $emergency_name2, $doc_name);
            $int_array = array($cell_phone, $home_phone, $housenumber, $grad, $area, $emergency_no, $emergency_no2, $doc_no);
            $string_array = array($initials, $id, $qualification, $streetaddress, $suburb, $city, $province, $course_choice, $artitic_details, $relationship)
            
            //validate names
            foreach($name_array as $name) {
                $name = filterNames($name);
            }
            //validate integers
            foreach($int_array as $integers) {
                $integers = filterInt($integers);
            }
            //validate string
            foreach($string_array as $string) {
                $string = filterString($string);
            }
            //validate email
            $email = filterEmail($email);

        //Submit Posts
            $user_info = “INSERT INTO $db_name () VALUES ($last_name, $first_name, $initials, $id, $cell_phone, $home_phone, $email, $qualification, $grad, $housenumber, $streetaddress, $suburb, $city, $province, $area, $course_choice, $artitic_details, $medicalconditions, $emergency_name, $emergency_name2, $emergency_no, $emergency_name2, $relationship, $doc_name, $doc_no)”;
        //Mailing User
            $to = $email;
            $subject = 'SAGIT Application';
            $from = //sagit email;
            
            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            
            // Create email headers
            $headers .= 'From: '.$from."\r\n".
                'Reply-To: '.$from."\r\n" .
                'X-Mailer: PHP/' . phpversion();
            
            // Compose a simple HTML email message
            $message = '<html><body>';
            $message .= '<p style="color:#080;font-size:18px;">Your Application has been received and is being proccesed.</p>';
            $message .= '</body></html>';
        
            if(mysqli_query($link, $user_info)) {
                header('Location: www.sagit.com');
            } else {
                echo "ERROR: Could not able to execute $user_info. " . mysqli_error($connect);
            }
        }
        //Close Connection
        mysqli_close($connect);
}
?>
