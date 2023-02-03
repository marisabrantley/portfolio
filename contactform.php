<?php

    if(isset($_POST['submit'])) {
            $name = $_POST['name'];
            $subject = $_POST['subject'];
            $mailFrom = $_POST['email'];
            $message = $_POST['message'];

            $mailTo = "hello@marisabrantley.com";
            $headers = "From: ".$mailFrom;
            $txt = "You have received an email from ".$name.".\n\n".$message;

            mail($mailTo, $subject, $txt, $headers);
            header("Location: index.html?mailsend");
    }

?>