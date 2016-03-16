<?php

namespace App\Traits;

trait Mail
{
    public function sendMail($messageHtml, $subject, $toEmail, $toName)
    {
        $mailer = new \Mandrill(getenv('MAIL_PASSWORD'));
        $messageArray = [
            'html' => $messageHtml,
            'text' => strip_tags($messageHtml),
            'subject' => $subject,
            'from_email' => getenv('MAIL_FROM'),
            'from_name' => getenv('MAIL_FROM_NAME'),
            'to' => [
                [
                    'email' => $toEmail,
                    'name' => $toName,
                    'type' => 'to'
                ]
            ]
        ];
        try {
            $result = $mailer->messages->send($messageArray);
        } catch (\Exception $e) {//@todo this could be extended for more info on failure
            return false;
        } finally {
            return true;
        }
    }
}