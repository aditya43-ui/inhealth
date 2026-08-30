<?php
/**
 * authentication for mobile
 */
class MyMobileAuthController extends Controller
{
	protected function beforeAction($action)
    {
		if(isset($_GET['tracing'])){ //untuk tracing data MA-377
			echo "<pre>";
			print_r($_GET);
			exit;
		}
		return true;
	}
}