<?php
// Pear Mail Library
require_once "Mail.php";
class MailNotification {

	public static $smtpConfig = array();

	public static $from = '';

	public static function sendNotification(Player $player, Notification $notif) {
		if ($player->hasNotifications($notif->getNotification_type())) {
			$urlPrefix = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/soluche/userCustomisation.php';
			$message = "Soluche t'informe:\r\n\r\n";
			$message .= strip_tags($notif->getMessage()) . "\r\n\r\n";
			$message .= "\tSoluche" . "\r\n\r\n";
			$message .= "PS:\r\n";
			$message .= "Virer les notifications? s'autentifier et suivre le lien " . $urlPrefix;
			$t = explode("\r\n", strip_tags($notif->getShort_message()));
			$subject = '[SOLUCHE] ' . $t[0];
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
