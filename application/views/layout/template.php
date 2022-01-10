<?php
$this->load->view('layout/header-script');

if(!isset($ignoreHeadFoot))
{
	$this->load->view('layout/header-bottom');
}

$this->load->view($content);

if(!isset($ignoreHeadFoot))
{
	$this->load->view('layout/footer-top');
}

$this->load->view('layout/footer');
?>