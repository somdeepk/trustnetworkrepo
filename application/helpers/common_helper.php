<?php

function authenticate_user()
{	
    $ci=& get_instance();
    if ($ci->session -> userdata('email') == "" && $ci->session -> userdata('login') != true)
	{
	  redirect('user/login');
	}

	$user_auto_id=$ci->session->userdata('user_auto_id');
    $sql='SELECT * from tn_members WHERE id="'.$user_auto_id.'"'; 
    $query = $ci->db->query($sql);
    $resultData=$query->result_array();

    $userLoginData=$resultData[0];
    $userLoginData['login']=true;
	$userLoginData['user_auto_id']=$userLoginData['id'];
 	$userLoginData['user_email']=$userLoginData['user_email'];
 	$userLoginData['user_full_name']=$userLoginData['first_name']." ".$userLoginData['last_name'];
 	$userLoginData['email']=$userLoginData['user_email'];
 	$ci->session->set_userdata($userLoginData);
}


function sendChristtubeEmail($email_to,$email_from,$email_subject="",$email_body="",$email_cc="")
{
   
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    $headers .= "From: Christtube <".$email_from."> \r\n";
    $headers .= "Reply-To: ".$email_from."\r\n";
    $headers .= "Return-Path: ".$email_from."\r\n";

    
    if($email_cc!="")
    {
        $headers .= "CC: ".$email_cc. "\r\n";
    }
    
    $headers .= "Reply-To: ".$email_from . "\r\n" .
    "X-Mailer: PHP/" . phpversion();

    
    if(mail($email_to,$email_subject,$email_body,$headers, "-fme@mydomain.com"))
    {
        return true;
    }
    else
    {
        return;
    }
}


function sendGridFollowMeNowEmail($paramArray=array())
{
    //followmenow@followmenow.org
    //chanachurgaram123@india123

    $email_from=(isset($paramArray['email_from']) && !empty($paramArray['email_from']))? $paramArray['email_from']:'';
    $email_from_name=(isset($paramArray['email_from_name']) && !empty($paramArray['email_from_name']))? $paramArray['email_from_name']:'';
    $email_to=(isset($paramArray['email_to']) && !empty($paramArray['email_to']))? $paramArray['email_to']:array();
    $email_cc=(isset($paramArray['email_cc']) && !empty($paramArray['email_cc']))? $paramArray['email_cc']:array();
    $email_bcc=(isset($paramArray['email_bcc']) && !empty($paramArray['email_bcc']))? $paramArray['email_bcc']:array();

    $email_subject=(isset($paramArray['email_subject']) && !empty($paramArray['email_subject']))? $paramArray['email_subject']:'';
    $email_body=(isset($paramArray['email_body']) && !empty($paramArray['email_body']))? $paramArray['email_body']:'';
    $ary_email_attachment=(isset($paramArray['ary_email_attachment']) && !empty($paramArray['ary_email_attachment']))? $paramArray['ary_email_attachment']:array();

    $sendGridApiKey='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';
    $arySendGrid=array(
        'from'=>$email_from,
        'fromname'=>$email_from_name,
        'subject'=>$email_subject,
        'text'=>preg_replace("/\n\s+/","\n", rtrim(html_entity_decode(strip_tags($email_body)))),
        'html'=>$email_body,
    );

    if(count($email_to)>0)
    {
        foreach ($email_to as $key => $value)
        {
            $arySendGrid['to['.$key.']']=$value;
        }
    }

    if(count($email_cc)>0)
    {
        foreach ($email_cc as $key => $value)
        {
            $arySendGrid['cc['.$key.']']=$value;
        }
    }

    if(count($email_bcc)>0)
    {
        foreach ($email_bcc as $key => $value)
        {
            $arySendGrid['bcc['.$key.']']=$value;
        }
    }

    if(count($ary_email_attachment)>0)
    {
        foreach ($ary_email_attachment as $key => $value)
        {
            $arySendGrid['files['.$value['filename'].']']=$value['filecontent'];
        }
    }

    $session=curl_init('https://api.sendgrid.com/api/mail.send.json');
    curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($session, CURLOPT_HTTPHEADER,array('Authorization:Bearer '.$sendGridApiKey));
    curl_setopt($session, CURLOPT_POST,true);
    curl_setopt($session, CURLOPT_POSTFIELDS,$arySendGrid);
    curl_setopt($session, CURLOPT_HEADER,false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);

    $returnAry=array();
    $returnAry['responce']=curl_exec($session);
    curl_close($session);
    return $returnAry;    
}


?>