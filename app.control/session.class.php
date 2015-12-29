<?php
	error_reporting(E_WARNING);

    class session
    {
        public function __construct()
        {
			@session_start();
        }
    }
?>