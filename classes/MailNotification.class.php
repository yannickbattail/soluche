<?php
// Pear Mail Library
require_once "Mail.php";
class MailNotification {

	public static $smtpConfig = array();

	public static $from = '';

	public static function sendNotification(Player $player, Notification $notif) {
		if ($player->hasNotifications($notif->getNotification_type())) {
			$urlPrefix = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/soluche/userCutomisation.php';
			$message = "Soluche t'informe:\r\n\r\n";
			$message .= $notif->getShort_message() . "\r\n";
			$message .= "\tSoluche" . "\r\n\r\n";
			$message .= "PS:\r\n";
			$message .= "Virer les notifications? s'autentifier et suivre le lien " . $urlPrefix;
			$subject = '[SOLUCHE] ' . strip_tags($notif->getShort_message());
			self::sendMailPlayer($player, $subject, $message);
		}
	}

	public static function sendMailPlayer(Player $player, $subject, $message) {
		self::sendMail($player->getEmail(), $subject, $message);
	}

	public static function sendMail($dest, $subject, $message) {
		$headers = array('From' => self::$from, 'To' => $dest, 'Subject' => $subject);
		
		$smtp = @Mail::factory('smtp', self::$smtpConfig);
		
		$mail = @$smtp->send($dest, $headers, $message);
		
		if (@PEAR::isError($mail)) {
			$message .= '<p>' . $mail->getMessage() . '</p>';
		}
	}

	public static function init() {
		require_once 'mailConfig.php';
	}
}

MailNotification::init();
