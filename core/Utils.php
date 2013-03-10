<?php
function redirect($location = '/', $statusCode = 302){
	header('Location: ' . $location, true, $statusCode);
}