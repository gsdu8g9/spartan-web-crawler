<?php 

include_once('simple_html_dom.php');

?>

<h1>404 Checker</h1>

<p>Enter a url below and hit submit to look for any 404's on the page. Note that you must include "http://" in front of your url</p>

<p>Running this may take a while depending on the size of the page in question</p>

<form action="/index.php" method="POST">
	<input type="text" name="url">
	<input type="Submit" value="Run a check">
</form>


<?php

if ( isset( $_POST['url'] ) ) {
	echo $_POST['url'];
	$target_url =  $_POST['url'];

	$html = new simple_html_dom();
	$html->load_file($target_url);

	foreach( $html->find('a') as $link ){
		if ( is_404(  $link->href  )) {
			echo '<span style="color:red">' . $link->href . "</span><br />";
		}
		else 
			echo $link->href . "<br />";

	}
}






function is_404($url) {
	$handle = curl_init($url);
	curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

	/* Get the HTML or whatever is linked in $url. */
	$response = curl_exec($handle);

	/* Check for 404 (file not found). */
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	if($httpCode == 404) {
		return true;
	}
	else return false;

	curl_close($handle);
}