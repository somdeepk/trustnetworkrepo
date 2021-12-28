<?php 
class Post extends CI_Controller
{
	public function ajaxsubmitsinglepost() 
    {
    	$returnData=array();
        $singlePostData = trim($this->input->post('singlePostData'));
        $arySinglePostData=json_decode($singlePostData, true);

        $aryPostTagFriend = trim($this->input->post('aryPostTagFriend'));
        $aryPostTagFriend=json_decode($aryPostTagFriend, true);

        // echo "<pre>";
        // print_r($aryPostTagFriend);
        // exit;

        $member_id=(isset($arySinglePostData['member_id']) && !empty($arySinglePostData['member_id']))? addslashes(trim($arySinglePostData['member_id'])):'0';
        $post=(isset($arySinglePostData['post']) && !empty($arySinglePostData['post']))? addslashes(trim($arySinglePostData['post'])):'';

		$current_date=date('Y-m-d H:i:s');

		if($member_id>0)
		{
			$menu_arr = array(
	            'member_id' => $member_id,
	            'post'  =>$post,
	            'create_date'  =>$current_date,
	        );

			$lstPostId = $this->Post_Model->addupdatepost(0,$menu_arr);

			if(count($aryPostTagFriend)>0)
			{
				foreach ($aryPostTagFriend as $ktag => $vtag) {
					$menu_arr_tag = array(
			            'post_id'  =>$lstPostId,
			            'member_id' => $member_id,
			            'tagged_member_id'  =>$vtag,
			            'create_date'  =>$current_date,
			        );
					$lastTagId = $this->Post_Model->addupdatetagfriend(0,$menu_arr_tag);
				}
			}
			if($lstPostId>0)
			{
		        $returnData['status']='1';
		        $returnData['msg']='success';
		        $returnData['msgstring']='Posted Successfully';
		        $returnData['data']=array('lstPostId'=>$lstPostId);
			}			
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Posting Failed';
	        $returnData['data']=array();
		}
        echo json_encode($returnData);
        exit;    	
    }
}