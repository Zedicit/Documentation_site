<?php
/**
 * GitHub webhook handler template.
 *
 * @see https://developer.github.com/webooks/
 * @author Miloslav Hůla (https://github.com/milo)
 */

# Additional to write a message string to a log file
function LogMessage($message) {
	global $logfile;
	$logfile = 'UpdateDocs.log';
	$time = time();
	$date = date('Y-m-d H:i:s');

	file_put_contents($logfile, $date . "; " . $message . "\n", FILE_APPEND);
}


// In this file: /etc/apache2/sites-available/example.com.conf
// Put this lne: SetEnv GITHUB_WEBHOOK_SECRET MY_SECRET
$hookSecret = getenv('GITHUB_WEBHOOK_SECRET');

set_error_handler(function($severity, $message, $file, $line) {
	throw new \ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function($e) {
	header('HTTP/1.1 500 Internal Server Error');
	echo "Error on line {$e->getLine()}: " . htmlSpecialChars($e->getMessage());
	die();
});

$rawPost = NULL;

if ($hookSecret !== NULL) {
	if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
		throw new \Exception("HTTP header 'X-Hub-Signature' is missing.");
	} elseif (!extension_loaded('hash')) {
		throw new \Exception("Missing 'hash' extension to check the secret code validity.");
	}

	list($algo, $hash) = explode('=', $_SERVER['HTTP_X_HUB_SIGNATURE'], 2) + array('', '');
	if(!in_array($algo, hash_algos(), TRUE)) {
		throw new \Exception("Hash algorithm '$algo' is not supported.");
	}

	$rawPost = file_get_contents('php://input');
	if(!hash_equals($hash, hash_hmac($algo, $rawPost, $hookSecret))) {
		throw new \Exception('Hook secret does not match.');
	}
};

if (!isset($_SERVER['CONTENT_TYPE'])) {
	throw new \Exception("Missing HTTP 'Content-Type' header.");
} elseif (!isset($_SERVER['HTTP_X_GITHUB_EVENT'])) {
	throw new \Exception("Missing HTTP 'X-Github-Event' header.");
}

switch ($_SERVER['CONTENT_TYPE']) {
case 'application/json':
	$json = $rawPost ?: file_get_contents('php://input');
	break;
case 'application/x-www-form-urlencoded':
	$json = $_POST['payload'];
	break;
default:
	throw new \Exception("Unsuported content type: $_SERVER[CONTENT_TYPE]");
}

# Payload structure depends on trigger event
# https://developser.github.com/v3/actieiy/events/types/
$payload = json_decode($json);
switch (strtolower($_SERVER['HTTP_X_GITHUB_EVENT'])) {
	case 'ping':
		echo 'pong';
		break;
	case 'push':
		LogMessage("Push Event recieved from GitHub repository Document_site! Updating Book.");
		# pull the orgin main from GitHub
		# build the book based off of the new GitHub pull
		$result = shell_exec('cd /var/www/com.zedicit/public && git pull origin main 2>&1 && mdbook build 2>&1');

		LogMessage($result);
		LogMessage("Update book command executed.");

		break;
	default:
		header('HTTP/1.0 ror Not Found');
		echo "Event:$_SERVER[HTTP_X_GITHUB_EVENT] Payload:\n";
		LogMessage($payload); # For debug
		die();
}
?>
