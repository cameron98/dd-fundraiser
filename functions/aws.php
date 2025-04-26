<?php

require($_SERVER['DOCUMENT_ROOT'] . "/../aws/aws-autoloader.php");
$config = require($_SERVER['DOCUMENT_ROOT'] . "/../config.php");

$aws_key = $config['aws_key'];
$aws_secret = $config['aws_secret'];
$from_email = $config['from_email'];

use Aws\Ses\SesClient;
use Aws\Ses\Exception\SesException;

function sendEmail($to, $subject, $body, $aws_key, $aws_secret, $from_email) {
    $client = new SesClient([
    'version' => 'latest',
    'region' => 'us-east-1',
    'credentials' => [
    'key' => $aws_key,
    'secret' => $aws_secret,
    ]
    ]);
    try {
    $result = $client->sendEmail([
    'Destination' => [
    'ToAddresses' => [$to],
    ],
    'Message' => [
    'Body' => [
    'Text' => [
    'Charset' => 'UTF-8',
    'Data' => $body,
    ],
    ],
    'Subject' => [
    'Charset' => 'UTF-8',
    'Data' => $subject,
    ],
    ],
    'Source' => $from_email,
    ]);
    $messageId = $result['MessageId'];
    return true;
    } catch (SesException $error) {
    return false;
    }
    }