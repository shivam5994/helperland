<?php
session_start();
require 'phpmailer/mail.php';

class userController
{
    function __construct()
    {

        include 'models/userModel.php';
        $this->model = new userModel();
        $this->Err = '';
    }

    function submit_contactForm()
    {
        if (isset($_POST)) {
            $data = $_POST['data'];
            $array = [
                'firstname' => $data['Firstname'],
                'lastname' => $data['Lastname'],
                'email' => $data['Email'],
                'phone' => $data['Phone'],
                'subject' => $data['Subject'],
                'message' => $data['Message'],
                'createdOn' => date('Y-m-d H:i:s'),
            ];

            $this->validateContactMessage($array['message']);

            if (!preg_match("/^[a-zA-Z ]*$/", $array['firstname']) && !preg_match("/^[a-zA-Z ]*$/", $array['lastname'])) {
                $this->Err = $this->Err  . "Only letters and white space allowed in name field" . "<br>";

            }
            if (!preg_match('/^[0-9]{10}+$/', $array['phone'])) {
                $this->Err = $this->Err  . "phone number size must be 10." . "<br>";
       
            }
            if($this->Err==''){
                $ins = $this->model->insert_Contactus('contactus', $array);
                if($ins){
                    echo json_encode("Success");
                }
            }else{
                echo json_encode($this->Err);
            }
        } else {
            echo 'error occured!! try again';
        }
    }

    function validateFields($fname, $lname, $phone, $email)
    {
        if (!preg_match("/^[a-zA-Z ]*$/", $fname) && !preg_match("/^[a-zA-Z ]*$/", $lname)) {
            $this->Err =  "Only letters and white space allowed in name field" . "<br>";
        }
        if (!preg_match('/^[0-9]{10}+$/', $phone)) {
            $this->Err = $this->Err  . "phone number size must be 10." . "<br>";
        }

        $result = $this->model->checkMail('user', $email);

        if ($result > 0) {
            $this->Err = $this->Err . "Email Id Already Exist! Choose Another Email" . "<br>";
        }
    }

    function validateContactMessage($array)
    {
        if (!preg_match("/^[a-zA-Z ]*$/", $array)) {
            $this->Err = $this->Err . "Only letters and white space allowed in Message field." . "</br>";

        }
    }

    function register_Customer()
    {
        if (isset($_POST)) {
            $array = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['emailId'],
                'phone' => $_POST['phone'],
                'password' => $_POST['password'],
                'userTypeId' => '1',
                'workWithPets' => '0',
                'createdDate' => date('Y-m-d H:i:s'),
                'modifiedDate' => date('Y-m-d H:i:s'),
                'modifiedBy' => '0',
                'isApproved' => '0',
                'isActive' => '1',
                'isDeleted' => '0',
                'status' => '0',
            ];


            $this->validateFields($array['firstname'], $array['lastname'], $array['phone'], $array['email']);
            $pass = $this->checkPasswordStrength($array['password']);


            if ($this->Err == '') {

                $array['password'] = $pass;
                $ins = $this->model->insert_Customer('user', $array);
                $enc_id = password_hash($ins, PASSWORD_DEFAULT);
                $body = "<p>Click on link to activate your account: <a href ='http://localhost/helperland/?controller=user&function=verifyAccount&id=$ins'>http://localhost/helperland/?controller=user&function=verifyAccount&id=$enc_id</a></p>";
                sendmail([$array['email']], 'Account Activation', $body, '');
                echo json_encode("We have send an account activation link for your account kindly check your mail.");
            } else {
                echo json_encode($this->Err);
            }
        } else {
            echo "error occurred! try again..";
        }
    }

    function validatePassword($pass, $c_pass)
    {

        if ($pass == $c_pass) {
            return true;
        } else {
            $this->Err = $this->Err . "Password does not matched." . "<br>";
        }
    }

    function verifyAccount()
    {
        $arr['base_url'] = 'http://localhost/Helperland';
        $id = $_GET['id'];

        $this->model->activateAccount('user', $id);

        header('Location:' . $arr['base_url']);
    }

    function spRegister()
    {
        if (isset($_POST)) {
            $array = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['emailId'],
                'phone' => $_POST['phone'],
                'password' => $_POST['password'],
                'userTypeId' => '2',
                'workWithPets' => '0',
                'createdDate' => date('Y-m-d H:i:s'),
                'modifiedDate' => date('Y-m-d H:i:s'),
                'modifiedBy' => '0',
                'isApproved' => '0',
                'isActive' => '1',
                'isDeleted' => '0',
                'status' => '0',
            ];


            $this->validateFields($array['firstname'], $array['lastname'], $array['phone'], $array['email']);
            $pass = $this->checkPasswordStrength($array['password']);
            $array['password'] = $pass;


            if ($this->Err == '') {
                $ins = $this->model->insert_Sp('user', $array);
                $enc_id = password_hash($ins, PASSWORD_DEFAULT);
                $body = "<p>Click on link to activate your account: <a href ='http://localhost/helperland/?controller=user&function=verifyAccount&id=$ins'>http://localhost/helperland/?controller=user&function=verifyAccount&id=$enc_id</a></p>";
                sendmail([$array['email']], 'Account Activation', $body, '');
                echo json_encode("We have send an account activation link for your account kindly check your mail.");
                return $ins;
            } else {
                echo json_encode($this->Err);
            }
        } else {
            echo "error occured try again!!!";
        }
    }

    function checkPasswordStrength($password)
    {
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if ($password < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
            $this->Err = $this->Err . "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character." . "<br>";
        } else {
            $res = $this->validatePassword($password, $_POST['cpass']);

            if ($res == true) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $password = $hash;
            }
        }
        return $password;
    }

    function userLogin()
    {
        if (isset($_POST)) {
            $records = $this->model->checkIdPass($_POST['email']);

            $password = $_POST['pass'];

            $pass = password_verify($password, $records['Password']);

            if ($pass == 1 && $records['Status'] == 1 ) {

               if(isset($_POST['remember'])){
                   setcookie('email',$_POST['email'],time()+(86400*7));
                   setcookie('pass',$_POST['pass'],time()+(86400*7));
                   setcookie('remember-me','checked',time()+(86400*7));
               }
                $_SESSION['islogin']=true;
                $_SESSION['userId'] = $records['UserId'];  
                $_SESSION['userName'] = $records['FirstName'];
                $_SESSION['userType'] = $records['UserTypeId'];
                $_SESSION['userEmail'] = $records['Email'];
                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
                $res["status"] = true;
                $res["message"] = "Successfully Login.";
                $res["loginToken"] = session_id();
                $res['type'] = $records['UserTypeId'];
                echo json_encode($res); 
            } else if ($pass == 1 && $records['Status'] == 0) {
                $this->Err = $this->Err .  "You have not confirmed your account yet. Please check you inbox and verify your id.";
                echo json_encode($this->Err);
            } else {
                $this->Err = $this->Err . "Email and Password are invalid";
                echo json_encode($this->Err);
            }
   
        } else {
            echo "error occurred!! try again..";
        }
    }

    function forgetPassword()
    {
        if (isset($_POST)) {
            $records = $this->model->checkIdPass($_POST['email']);

            if ($records > 0) {

                $body = "<p>Click on link to change your password: <a href ='http://localhost/helperland/?controller=home&function=changePassword&id=$records[UserId]'>http://localhost/helperland/?controller=home&function=changePassword&id=$records[Password]</a></p>";
                sendmail([$_POST['email']], 'Forget Password', $body, '');
                echo json_encode("An email has been sent to your account. Click on the link in received email to reset the password.");
            } else {
                $this->Err = $this->Err . "Email not exits";
                echo json_encode($this->Err);
            }
        } else {
            echo "error occurred!! try again..";
        }
    }

    function validateNewPassword($id)
    {

        if (isset($_POST)) {
            $pass = $_POST['pass'];

            $hash = $this->checkPasswordStrength($pass);

            if($this->Err == ''){
                $updatePass = $this->model->updatePassword('user', $hash, $id);

                if ($updatePass == true) {
                    echo json_encode("Success");
                }
            }else{
                echo json_encode($this->Err);
            }
        }
    }

    function userLogout(){
        $_SESSION['islogin'] = false;
        unset($_SESSION['islogin']);
        echo 'success';
    }
}
