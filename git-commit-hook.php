<?php

if ($_SERVER["REQUEST_METHOD"] != "POST" || strpos($_SERVER["HTTP_USER_AGENT"], "GitHub-Hookshot/") === FALSE)
    die("Bad request");

require_once("git-config.php");

// verify X-Hub-Signature
$headers = getallheaders();

if (empty($headers['X-Hub-Signature']))
    die("No signature");

$signature = $headers['X-Hub-Signature'];
 
// split signature into algorithm and hash
list($algorithm, $hash) = explode('=', $signature, 2);
 
// calculate hash based on payload and the secret
$payload = file_get_contents('php://input');
$payloadHash = hash_hmac($algorithm, $payload, COMMIT_HOOK_SECRET);
 
// compare hashes
if ($hash !== $payloadHash)
    die("Bad signature");

$local_path = getcwd();

//echo "cd {$local_path} && git pull <br>";

exec("cd {$local_path} && git pull")
    or die("git pull failed!");

echo "Update completed successfully!";

?>