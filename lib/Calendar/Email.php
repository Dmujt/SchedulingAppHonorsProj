<?php
/**
 * Created by PhpStorm.
 * User: Cornelius
 * Date: 4/4/2017
 * Time: 4:59 PM
 */

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