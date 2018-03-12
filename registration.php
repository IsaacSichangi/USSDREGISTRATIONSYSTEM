<?php

    require_once("connect.php");
//content to be in plain text - most gateways use this

// Reads the variables sent via POST from our gateway
    $sessionId = $_POST["sessionId"];
    $serviceCode = $_POST["serviceCode"];
    $phoneNumber = $_POST["phoneNumber"];
    $text = $_POST["text"];
    $default_error_message = "oops something went wrong";


// Check connection

    if (!$conn) {

        ussd_stop("Connection failed: " . mysqli_connect_error());


    } else {

        $textarray = explode("*", $text);

        $userresponse = trim(end($textarray));

        $level = 0;

        $check_level = mysqli_query($conn, "SELECT level FROM session_levels WHERE session_id = '$sessionId'");

        if ($check_level) {

            while ($row = mysqli_fetch_array($check_level)) {

                $level = $row['level'];


            }


            $check_user = mysqli_query($conn, "SELECT * FROM users WHERE phonenumber ='$phoneNumber'");

            if ($check_user) {


                if (mysqli_num_rows($check_user) > 0) {

                    if ($userresponse == "") {

                        switch ($level) {

                            case 0:

                                $save_level = mysqli_query($conn, "INSERT INTO session_levels VALUES('$sessionId', '$phoneNumber', 1)");

                                if ($save_level) {


                                    $response = "You are already registered do you want to unsubscribe \n";
                                    $response .= "1. Yes \n";
                                    $response .= "2.  No";

                                    ussd_proceed($response);

                                } else {

                                    error_reportingsss();

                                    ussd_stop($default_error_message);

                                }

                                break;

                            default:

                                ussd_stop($default_error_message);


                        }


                    } else if ($userresponse == "1") {

                        $save_level = mysqli_query($conn, "UPDATE session_levels SET level = 2 WHERE session_id = '$sessionId'");

                        if ($save_level) {

                            $delete_user = mysqli_query($conn, "DELETE FROM users WHERE phonenumber = '$phoneNumber'");

                            if ($delete_user) {

                                ussd_stop("you have successfully unsubscribed");

                            } else {


                                error_reportingsss();

                                ussd_stop($default_error_message);

                            }

                        } else {

                            error_reportingsss();

                            ussd_stop($default_error_message);


                        }


                    } else if ($userresponse == "2") {


                        $save_level = mysqli_query($conn, "UPDATE session_levels SET level = 3 WHERE session_id = '$sessionId'");

                        if ($save_level) {

                            ussd_stop("Thankyou have a nice day");

                        }else{

                            error_reportingsss();

                            ussd_stop($default_error_message);
                        }


                        } else {

                            ussd_stop($default_error_message);


                        }



                    } else {


                        if ($userresponse == "") {

                            switch ($level) {

                                case 0:

                                    $save_level = mysqli_query($conn, "INSERT INTO session_levels VALUES('$sessionId', '$phoneNumber', 1)");

                                    if ($save_level) {

                                      //  $save_phonenumber = mysqli_query($conn, "INSERT INTO users (phonenumber) VALUES ('$phoneNumber')");

                                       // if ($save_phonenumber) {

                                            $response = "welcome to Modcom subscription service \n";
                                            $response .= "1. register \n";
                                            $response .= "2. plans";

                                            ussd_proceed($response);

                                        //} else {

                                           // error_reportingsss();

                                            //ussd_stop($default_error_message);


                                        //}


                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);

                                    }
                                    break;


                                default:

                                    ussd_stop($default_error_message);


                            }


                        } else if ($userresponse == "1") {

                            switch ($level) {


                                case 0:


                                    $save_level = mysqli_query($conn, "UPDATE session_levels SET level = 1 WHERE session_id = '$sessionId'");

                                    if ($save_level) {

                                        $response = "welcome to Modcom subscription service \n";
                                        $response .= "1. register \n";
                                        $response .= "2. plans";

                                        ussd_proceed($response);

                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);


                                    }


                                    break;

                                case  1:

                                    $save_level = mysqli_query($conn, "UPDATE session_levels SET level = 2 WHERE session_id = '$sessionId'");

                                    if ($save_level) {

                                        $response = "personal details \n";
                                        $response .= " enter name \n";
                                        $response .= "2. go back to main menu ";

                                        ussd_proceed($response);

                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);


                                    }

                                    break;


                                case 3:

                                    $save_level = mysqli_query($conn, "UPDATE session_levels SET level = 4 WHERE session_id = '$sessionId'");

                                    if ($save_level) {


                                        $response = " daily news \n";
                                        $response .= " 1. confirm \n";
                                        $response .= " 2. cancel \n";

                                        ussd_proceed($response);

                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);


                                    }


                                    break;

                                case 4:

                                    $check_username = mysqli_query($conn, "SELECT username FROM users WHERE phonenumber ='$phoneNumber'");

                                    if ($check_username) {
                                        if (mysqli_num_rows($check_username) > 0) {

                                            ussd_stop(" you have been successfully registered");


                                        } else {

                                            ussd_stop("please register your name first");
                                        }


                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);
                                    }

                                    break;


                                case 5:

                                    $check_username = mysqli_query($conn, "SELECT username FROM users WHERE phonenumber ='$phoneNumber'");

                                    if ($check_username) {
                                        if (mysqli_num_rows($check_username) > 0) {

                                            ussd_stop(" you have been successfully registered");


                                        } else {

                                            ussd_stop("please register your name first");
                                        }


                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);
                                    }


                                    break;


                                case 6:

                                    $check_username = mysqli_query($conn, "SELECT username FROM users WHERE phonenumber ='$phoneNumber'");

                                    if ($check_username) {
                                        if (mysqli_num_rows($check_username) > 0) {

                                            ussd_stop(" you have been successfully registered");


                                        } else {

                                            ussd_stop("please register your name first");
                                        }


                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);
                                    }


                                    break;

                                default:

                                    ussd_stop($default_error_message);


                            }


                        } else if ($userresponse == "2") {


                            switch ($level) {


                                case 1:

                                    $save_level = mysqli_query($conn, "UPDATE session_levels SET level = 3 WHERE session_id = '$sessionId'");

                                    if ($save_level) {


                                        $response = "subscription \n";
                                        $response .= "1.  daily news \n";
                                        $response .= "2.  weekly news \n";
                                        $response .= "3. monthly news ";

                                        ussd_proceed($response);

                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);


                                    }


                                    break;

                                case 2:

                                    $save_level = mysqli_query($conn, "UPDATE session_levels SET level = 1 WHERE session_id = '$sessionId'");

                                    if ($save_level) {


                                        $response = "welcome to Modcom subscription service \n";
                                        $response .= "1. register \n";
                                        $response .= "2. plans";

                                        ussd_proceed($response);

                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);


                                    }


                                    break;

                                case 3:

                                    $save_level = mysqli_query($conn, "UPDATE session_levels SET level = 5 WHERE session_id = '$sessionId'");

                                    if ($save_level) {


                                        $response = " weekly news \n";
                                        $response .= " 1. confirm \n";
                                        $response .= " 2. cancel \n";

                                        ussd_proceed($response);

                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);


                                    }


                                    break;

                                case 4:

                                    ussd_stop("Thankyou goodbye");

                                    break;

                                case 5:

                                    ussd_stop("Thankyou goodbye");

                                    break;

                                case 6:

                                    ussd_stop("Thankyou goodbye");

                                    break;


                                default:

                                    ussd_stop($default_error_message);


                            }


                        } else if ($userresponse == "3") {


                            switch ($level) {


                                case 3:

                                    $save_level = mysqli_query($conn, "UPDATE session_levels SET level = 6 WHERE session_id = '$sessionId'");

                                    if ($save_level) {


                                        $response = " Monthly news \n";
                                        $response .= " 1. confirm \n";
                                        $response .= " 2. cancel \n";

                                        ussd_proceed($response);

                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);


                                    }


                                    break;


                                default:

                                    ussd_stop($default_error_message);


                            }


                        } else {

                            switch ($level) {

                                case 2:

                                    $save_username = mysqli_query($conn, "INSERT INTO users VALUES ('$userresponse','$phoneNumber')");

                                    if ($save_username) {

                                        $response = "you have been successfully registered ";


                                        ussd_stop($response);

                                    } else {

                                        error_reportingsss();

                                        ussd_stop($default_error_message);


                                    }

                                    break;


                                default:

                                    ussd_stop($default_error_message);


                            }


                        }


                    }




                } else {

                   error_reportingsss();

                    ussd_stop($default_error_message);


                }

            } else {

               error_reportingsss();

                ussd_stop($default_error_message);


            }







    }














?>