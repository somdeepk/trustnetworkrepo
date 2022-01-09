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

	if($ci->session->userdata('is_approved')=='N')
	{
	  redirect('user/profilesetting');
	}
    
}
?>