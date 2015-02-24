<?php

if ($_SERVER["REQUEST_METHOD"] != "POST" || strpos($_SERVER["HTTP_USER_AGENT"], "GitHub-Hookshot/") === FALSE)
{
    http_response_code(400);
    die("Bad request");
}

require_once("includes/config.php");

// verify X-Hub-Signature
$headers = getallheaders();

if (empty($headers['X-Hub-Signature']))
{
    http_response_code(401);
    die("No signature");
}

$signature = $headers['X-Hub-Signature'];

// split signature into algorithm and hash
list($algorithm, $hash) = explode('=', $signature, 2);

// calculate hash based on payload and the secret
$payload = file_get_contents('php://input');
$payloadHash = hash_hmac($algorithm, $payload, COMMIT_HOOK_SECRET);

// compare hashes
if ($hash !== $payloadHash)
{
    http_response_code(401);
    die("Bad signature");
}

$local_path = getcwd();

exec("cd {$local_path} && git pull")
    or die("git pull failed!");

echo "Update completed successfully!";

?>
