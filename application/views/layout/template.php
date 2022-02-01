<?php
if(isset($hideLayout) && $hideLayout==true)
{

}
else
{
	$this->load->view('layout/header-script');
}

if((isset($ignoreHeadFoot) && $ignoreHeadFoot==true) || (isset($hideLayout) && $hideLayout==true) )
{
	
}
else
{
	$this->load->view('layout/header-bottom');
}

$this->load->view($content);

if((isset($ignoreHeadFoot) && $ignoreHeadFoot==true) || (isset($hideLayout) && $hideLayout==true) )
{
	
}
else
{
	$this->load->view('layout/footer-top');
}

if(isset($hideLayout) && $hideLayout==true)
{

}
else
{
	$this->load->view('layout/footer');
}
?>