<?php

namespace Calendar;


class Email {
    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param $headers
     * creating and sending email to users to set password
     */
    public function mail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }
}