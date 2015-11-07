<?php

// Variables and config
$site_name = 'Simple';
$theme = '';
$file_format = ".md"; 
$core_dir = "core/"; 
$content_dir = "content/";
$siteroot = substr($_SERVER['PHP_SELF'], 0,  - strlen(basename($_SERVER['PHP_SELF']))); // Get site root and remove index.php

define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('CONTENT_DIR', ROOT_DIR .$content_dir); 



// Get post list
function P_list()
{
global $content_dir, $file_format;
$listes = glob($content_dir . "*" . $file_format);
foreach($listes as $liste)
{
$link_address =basename($liste, $file_format);
echo "<a href='$link_address'>$link_address</a>" . "</br>";
}
}


// Load Parsedown library
require_once $core_dir.'Parsedown.php';
$parsedown = new Parsedown();

// Get request url and script url
$url = '';
$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

	
// Get our url path and trim the / of the left and the right
if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');

// Get the file path
if($url) $file = strtolower(CONTENT_DIR . $url);
else $file = $core_dir .'index';

// Load the file
if(is_dir($file)) $file = $content_dir . $url  . $file_format;
else $file .=  $file_format;

// Show 404 if file cannot be found
if(file_exists($file)) $content = file_get_contents($file);
else $content = file_get_contents($core_dir.'404' . $file_format);
?>
<!DOCTYPE html>
<html class="<?php echo $theme; ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<base href="<?php echo $siteroot; ?>">
<link rel="stylesheet" type="text/css" href="style.css">

<title><?php echo (ucwords(strtolower($url))) ? : $site_name; ?></title>
</head>

<header>

	<h2><?php echo $site_name; ?></h2>
<nav>
  <a href="#">Home</a> 
  <a href="Readme">About</a>
  <a href="mailto:mail@server.com">Contact</a>
</nav>
</header>

<article>
<?php 

// Parse post
echo $parsedown->text($content);  


// Show post list only in index

if (empty($url)){ P_list(); }
 ?>
</article>

<footer> © <?php echo date('Y') . " " . $site_name; ?></footer>

</html>
