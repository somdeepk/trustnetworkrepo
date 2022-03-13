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

        if (!empty($_FILES['file']['name']))
        {
            $postfile = json_encode($_FILES);
        } else {
            $postfile = "";
        }

        /*echo "<pre>";
        print_r($videofile);
        exit;
		*/

        $member_id=(isset($arySinglePostData['member_id']) && !empty($arySinglePostData['member_id']))? addslashes(trim($arySinglePostData['member_id'])):'0';
        $post=(isset($arySinglePostData['post']) && !empty($arySinglePostData['post']))? addslashes(trim($arySinglePostData['post'])):'';

		$current_date=date('Y-m-d H:i:s');

		if($member_id>0 && (!empty($post) || !empty($postfile)))
		{
			$menu_arr = array(
	            'member_id' => $member_id,
	            'post'  =>$post,
	            'create_date'  =>$current_date,
	        );
			$lastPostId = $this->Post_Model->addupdatepost(0,$menu_arr);

			//Start Self Log in time line
			$menu_arr_member_timeline = array(
	            'post_id'  =>$lastPostId,
	            'from_member_id' => $member_id,
	            'to_member_id' => $member_id,
	            'post_type'  =>'newsfeed',
	            'create_date'  =>$current_date,
	            'status'  =>'S',
	        );
			$this->Post_Model->addupdatemembertimeline(0,$menu_arr_member_timeline);
			//End Self Log in time line


			//Start Log Data In Timeline
			$friendListData = $this->User_Model->ajaxGetAllFriendList($member_id,'',array());
			if(count($friendListData)>0)
			{
				foreach ($friendListData as $kFrnd => $vFrnd)
				{
					$strPostType='newsfeed';
					if(count($aryPostTagFriend)>0 && in_array($vFrnd['id'], $aryPostTagFriend))
					{
						$strPostType='tagged';
					}

					//Start Log in time line
					$menu_arr_member_timeline = array(
			            'post_id'  =>$lastPostId,
			            'from_member_id' => $member_id,
			            'to_member_id' => $vFrnd['id'],
			            'post_type'  =>$strPostType,
			            'create_date'  =>$current_date,
			            'status'  =>'S',
			        );
					$this->Post_Model->addupdatemembertimeline(0,$menu_arr_member_timeline);
					//End Log in time line
				}
			}
			//End Log Data In Timeline

			//Start Later We ommit This table
			// if(count($aryPostTagFriend)>0)
			// {
			// 	foreach ($aryPostTagFriend as $ktag => $vtag)
			// 	{
			// 		$menu_arr_tag = array(
			//             'post_id'  =>$lastPostId,
			//             'member_id' => $member_id,
			//             'tagged_member_id'  =>$vtag,
			//             'create_date'  =>$current_date,
			//         );
			// 		$lastTagId = $this->Post_Model->addupdatetagfriend(0,$menu_arr_tag);				
			// 	}
			// }
			//End Later We ommit This table

			if(!empty($postfile))
	        {
	            $this->load->library('upload');
	            $postfile=json_decode($postfile);
	            foreach($postfile->file->name as $kFile=>$vFile)
	            {
	            	$imarr=explode(".",$vFile);
		            $ext=end($imarr);
		            if($ext=="jpg" or $ext=="jpeg" or $ext=="png")
		            {
		                $_FILES['file']['name']=$file_original_name=$postfile->file->name[$kFile];
		                $_FILES['file']['type']=$file_type=$postfile->file->type[$kFile];
		                $_FILES['file']['tmp_name']=$postfile->file->tmp_name[$kFile];
		                $_FILES['file']['error']=$postfile->file->error[$kFile];
		                $_FILES['file']['size']=$file_size=$postfile->file->size[$kFile];

		                $config = array(
		                    'file_name' => str_replace(".","",microtime(true)).".".$ext,
		                    'allowed_types' => '*',
		                    'upload_path' => IMAGE_PATH.'images/postfiles/',
		                    //'max_size' => 2000
		                );

		                $this->upload->initialize($config);
		                
		                if (!$this->upload->do_upload('file'))
		                {
		                    $errormsg=$this->upload->display_errors();
		                    $arr=array('error'=>1,'success'=>'','errormsg'=>strip_tags($errormsg));
		                }
		                else
		                {
		                    $image_data = $this->upload->data();
		                    $file_name=$image_data['file_name'];
		                    $menu_arr_post_file = array(
					            'module_id'=>$lastPostId,
					            'module_type'=>'postfiles',
					            'member_id'   =>$member_id,
					            'file_original_name'   =>$file_original_name,
					            'file_name'   =>$file_name,
					            'file_size'   =>$file_size,        
					            'file_type'   =>$file_type,       
					            'create_date'   =>$current_date       
					        );

			                $last_post_file_id = $this->Post_Model->addUpdatPostFile(0,$menu_arr_post_file);
		                }                
		            }
	            }
	        }

			if($lastPostId>0)
			{
		        $returnData['status']='1';
		        $returnData['msg']='success';
		        $returnData['msgstring']='Posted Successfully';
		        $returnData['data']=array('lastPostId'=>$lastPostId);
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

    public function ajaxGetPostList() 
    {
    	$finalPost=array();

    	$postScrollData = $this->input->post('postScrollData');
        $aryPostScrollData=json_decode($postScrollData, true);

        $user_auto_id=$this->session->userdata('user_auto_id');
        $row=(isset($aryPostScrollData['row']) && !empty($aryPostScrollData['row']))? $aryPostScrollData['row']:'0';
        $rowperpage=(isset($aryPostScrollData['rowperpage']) && !empty($aryPostScrollData['rowperpage']))? $aryPostScrollData['rowperpage']:'0';
        $clickProfileTab=(isset($aryPostScrollData['clickProfileTab']) && !empty($aryPostScrollData['clickProfileTab']))? $aryPostScrollData['clickProfileTab']:'newsfeedTab';

        $strOrWhereParam='';
        if($clickProfileTab=='timelineTab')
        {
        	$strOrWhereParam=" AND post_type='tagged'";
	    }
        
        $sqlFindMemberPost="SELECT DISTINCT (id) as timelineid from tn_member_timeline WHERE ((from_member_id='".$user_auto_id."' AND to_member_id= '".$user_auto_id."') OR (to_member_id='".$user_auto_id."' AND from_member_id!= '".$user_auto_id."' ".$strOrWhereParam.")) AND status='S'  AND deleted='0' ORDER BY id DESC limit ".$row.",".$rowperpage;
        $queryFindMemberPost=$this->db->query($sqlFindMemberPost);
		$resultFindMemberPost=$queryFindMemberPost->result_array();

		$strAllTimeLineIds="";
		if(count($resultFindMemberPost)>0)
		{
			foreach ($resultFindMemberPost as $key => $value)
			{
				$strAllTimeLineIds.=$value['timelineid'].",";
			}
			$strAllTimeLineIds=trim($strAllTimeLineIds,",");
		}

		if($strAllTimeLineIds!="")
		{
	    	$sql="SELECT tmt.*
	    				FROM tn_member_timeline as tmt 
	    				LEFT JOIN tn_post as tp ON tp.id=tmt.post_id
	    				LEFT JOIN tn_members as tm on tm.id=tp.member_id
	    				WHERE tmt.id in (".$strAllTimeLineIds.")  AND tp.deleted='0' AND tm.status='1' and tm.deleted='0' group by tmt.post_id order by tmt.create_date DESC"; //limit ".$row.",".$rowperpage;
			$query=$this->db->query($sql);
			$result=$query->result_array();

			if(count($result)>0)
			{
				foreach ($result as $key => $value)
				{
					$finalPost[$key]['id']=$value['id'];
					$finalPost[$key]['post_id']=$value['post_id'];
					$finalPost[$key]['from_member_id']=$value['from_member_id'];
					$finalPost[$key]['to_member_id']=$value['to_member_id'];
					$finalPost[$key]['member_comment']='';


					//Start Get Post File Images/Video Data
					$sqlPostFile="SELECT file_name FROM tn_post_file WHERE module_id='".$value['post_id']."' AND module_type='postfiles' AND deleted='0'";
					$queryPostFile=$this->db->query($sqlPostFile);
					$resultPostFile=$queryPostFile->result_array();

					$finalPost[$key]['post_file_data']=array();
					if(count($resultPostFile)>0)
					{
						$finalPost[$key]['post_file_data']=$resultPostFile;
					}
					//End Get Post File Images/Video Data

					//Start Get tag to Friend Data
					/*$sqlPostTagFriend="SELECT 
					tptf.tagged_member_id,
					tm.first_name,
					tm.last_name
					FROM tn_post_tag_friend as tptf 
					LEFT JOIN tn_members as tm on tm.id=tptf.tagged_member_id
					WHERE tptf.post_id='".$value['post_id']."' AND tm.status='1' and tm.deleted='0'";
					$queryPostTagFriend=$this->db->query($sqlPostTagFriend);
					$resultPostTagFriend=$queryPostTagFriend->result_array();

					$finalPost[$key]['post_tag_friend_data']=array();
					if(count($resultPostTagFriend)>0)
					{
						$finalPost[$key]['post_tag_friend_data']=$resultPostTagFriend;
					}*/

					$sqlPostTagFriend="SELECT 
					tmt.to_member_id,
					tm.first_name,
					tm.last_name
					FROM tn_member_timeline as tmt 
					LEFT JOIN tn_members as tm on tm.id=tmt.to_member_id
					WHERE tmt.post_id='".$value['post_id']."' AND tm.status='1' AND tm.deleted='0' AND tmt.post_type='tagged'";
					$queryPostTagFriend=$this->db->query($sqlPostTagFriend);
					$resultPostTagFriend=$queryPostTagFriend->result_array();

					$finalPost[$key]['post_tag_friend_data']=array();
					if(count($resultPostTagFriend)>0)
					{
						$finalPost[$key]['post_tag_friend_data']=$resultPostTagFriend;
					}
					//End Get tag to Friend Data

					//Start Get Post Data
					$sqlPost="SELECT 
					tp.id,
					tp.member_id,
					tp.post,
					tp.create_date,

					tm.id postMemberId,
					tm.first_name,
					tm.last_name,
					tm.profile_image

					FROM tn_post as tp
					LEFT JOIN tn_members as tm on tm.id=tp.member_id
					WHERE tp.id='".$value['post_id']."' AND tp.status='1' AND tp.deleted='0' AND tm.status='1' and tm.deleted='0'";
					$queryPost=$this->db->query($sqlPost);
					$resultPost=$queryPost->result_array();

					$finalPost[$key]['post_data']=array();
					if(count($resultPost)>0)
					{
						$finalPost[$key]['post_data']=$resultPost[0];
						$finalPost[$key]['post_data']['display_create_date']=date('d M Y h:i A',strtotime($resultPost[0]['create_date']));
						if(count($finalPost[$key]['post_tag_friend_data'])>0)
						{
							$strFirstTagFriend=$finalPost[$key]['post_tag_friend_data'][0]['first_name']." ".$finalPost[$key]['post_tag_friend_data'][0]['last_name'];
							$tag_string_dispaly=" is with ".$strFirstTagFriend;
							if(count($finalPost[$key]['post_tag_friend_data'])>1)
							{
								$tag_string_dispaly.=" & ".(count($finalPost[$key]['post_tag_friend_data'])-1)." others";
							}

							$finalPost[$key]['post_data']['tag_string_dispaly']=$tag_string_dispaly;
						}
					}
					//End Get Post Data

					//Start Get Individual Post Like/Unlike Status
					$sqlIndvPostLike="SELECT deleted FROM tn_post_like WHERE post_id='".$value['post_id']."' AND member_id='".$user_auto_id."'";
					$queryIndvPostLike=$this->db->query($sqlIndvPostLike);
					$rowIndvPostLike=$queryIndvPostLike->row();

					$finalPost[$key]['indv_post_like_unlike']=1;
					if(count($rowIndvPostLike)>0)
					{
						$finalPost[$key]['indv_post_like_unlike']=$rowIndvPostLike->deleted;
					}
					//End Get Individual Post Like/Unlike Status

					//Start Get Post Like data
					$resultPostLikes = $this->Post_Model->getPostLikeData($value['post_id']);
					$finalPost[$key]['post_like_data']=array();
					if(count($resultPostLikes)>0)
					{
						$finalPost[$key]['post_like_data']=$resultPostLikes;
					}
					//End Get Post Like data

					//Start Get Post only 3 Comment data
					$aryArgu=array();
					$aryArgu['post_id']=$value['post_id'];
					$aryArgu['start']=0;
					$aryArgu['limit']=3;
					$resultPostComments = $this->Post_Model->getPostCommentData($aryArgu);
					$finalPost[$key]['post_comment_data']=array();
					if(count($resultPostComments)>0)
					{
						$finalPost[$key]['post_comment_data']=$resultPostComments;
					}
					//End Get Post only 3 Comment data

					//Start Get Post All Comment data
					$aryArgu=array();
					$aryArgu['post_id']=$value['post_id'];
					$aryArgu['start']='';
					$aryArgu['limit']='';
					$resultPostComments = $this->Post_Model->getPostCommentData($aryArgu);
					$finalPost[$key]['all_post_comment_data']=array();
					if(count($resultPostComments)>0)
					{
						$finalPost[$key]['all_post_comment_data']=$resultPostComments;
					}
					//End Get Post All Comment data
				}
			}
		}

		/*echo "<pre>";
        print_r($finalPost);
        exit;*/

		$returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='';
        $returnData['data']=array('postScrollData'=>$finalPost,'postExist'=>count($finalPost));
        echo json_encode($returnData);
        exit;

    }

    public function hideTimelinePost() 
    {

    	$returnData=array();
    	$postStatusData=$this->input->get_post('postStatusData');
    	$aryPostStatusData=json_decode($postStatusData, true);
  
  		$id=(isset($aryPostStatusData['timelineId']) && !empty($aryPostStatusData['timelineId']))? addslashes(trim($aryPostStatusData['timelineId'])):0;
		$status=(isset($aryPostStatusData['status']) && !empty($aryPostStatusData['status']))? addslashes(trim($aryPostStatusData['status'])):'S';
		
		$menu_arr = array(
            'status'  =>$status
        );


		$lastId=0;
 		if($id>0)
		{
			$lastId = $this->Post_Model->addupdatemembertimeline($id,$menu_arr);
		}

		if($id>0 && $lastId>0)
		{
			$returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Status Changed Successfully';
	        $returnData['data']=array('lastId'=>$lastId);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Status Changed Failed';
	        $returnData['data']=array();
		}       
        echo json_encode($returnData);
        exit;
    }

    public function likeTimelinePost() 
    {

    	$returnData=array();
    	$postStatusData=$this->input->get_post('postStatusData');
    	$aryPostStatusData=json_decode($postStatusData, true);
  
  		$post_id=(isset($aryPostStatusData['post_id']) && !empty($aryPostStatusData['post_id']))? addslashes(trim($aryPostStatusData['post_id'])):0;
  		$user_auto_id=$this->session->userdata('user_auto_id');
		$current_date=date('Y-m-d H:i:s');
		
		$menu_arr = array(
            'post_id'  =>$post_id,
            'member_id'  =>$user_auto_id,
            'create_date'  =>$current_date,
        );


		$array_return = $this->Post_Model->addUpdatPostLikeUnlike($menu_arr);

		$post_like_id=$array_return['post_like_id'];
		$strDeleted=$array_return['strDeleted'];


		//Start Get Post Like data
		$postLikeData = $this->Post_Model->getPostLikeData($post_id);
		//End Get Post Like data	

		if($post_like_id>0)
		{
			$returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Like Unlike Successfully Done';
	        $returnData['data']=array('post_like_id'=>$post_like_id,'strDeleted'=>$strDeleted,'postLikeData'=>$postLikeData);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Like Unlike Failed';
	        $returnData['data']=array();
		}       
        echo json_encode($returnData);
        exit;
    }

    public function commentTimelinePost() 
    {
    	$returnData=array();
    	$postCommentData=$this->input->get_post('postCommentData');
    	$aryPostCommentData=json_decode($postCommentData, true);
  
  		$post_comments_id=(isset($aryPostCommentData['post_comments_id']) && !empty($aryPostCommentData['post_comments_id']))? addslashes(trim($aryPostCommentData['post_comments_id'])):0;
  		$post_id=(isset($aryPostCommentData['post_id']) && !empty($aryPostCommentData['post_id']))? addslashes(trim($aryPostCommentData['post_id'])):0;
  		$member_comment=(isset($aryPostCommentData['member_comment']) && !empty($aryPostCommentData['member_comment']))? addslashes(trim($aryPostCommentData['member_comment'])):'';

  		$user_auto_id=$this->session->userdata('user_auto_id');
		$current_date=date('Y-m-d H:i:s');
		
		$menu_arr = array(
            'post_id'  =>$post_id,
            'member_id'  =>$user_auto_id,
            'member_comment'  =>$member_comment,
            'create_date'  =>$current_date,
        );


		$last_post_comments_id = $this->Post_Model->addUpdatePostComment($menu_arr,$post_comments_id);
		
		
		//Start Get Post only 3 Comment data
		$aryArgu=array();
		$aryArgu['post_id']=$post_id;
		$aryArgu['start']=0;
		$aryArgu['limit']=3;
		$postCommentData = $this->Post_Model->getPostCommentData($aryArgu);
		//End Get Post only 3 Comment data

		//Start Get Post All Comment data
		$aryArgu=array();
		$aryArgu['post_id']=$post_id;
		$aryArgu['start']='';
		$aryArgu['limit']='';
		$postAllCommentData = $this->Post_Model->getPostCommentData($aryArgu);
		//End Get Post All Comment data	
		
		if($last_post_comments_id>0)
		{
			$returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Comment Successfully Done';
	        $returnData['data']=array('last_post_comments_id'=>$last_post_comments_id,'postCommentData'=>$postCommentData,'postAllCommentData'=>$postAllCommentData);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Commenting Failed';
	        $returnData['data']=array();
		}       
        echo json_encode($returnData);
        exit;
    }


    public function ajaxGetPhotoList() 
    {
    	$finalPost=array();

    	$photoScrollData = $this->input->post('photoScrollData');
        $aryPhotoScrollDataa=json_decode($photoScrollData, true);

        $user_auto_id=$this->session->userdata('user_auto_id');
        $row=(isset($aryPhotoScrollDataa['row']) && !empty($aryPhotoScrollDataa['row']))? $aryPhotoScrollDataa['row']:'0';
        $rowperpage=(isset($aryPhotoScrollDataa['rowperpage']) && !empty($aryPhotoScrollDataa['rowperpage']))? $aryPhotoScrollDataa['rowperpage']:'0';

        $sql="SELECT tpf.id, tpf.module_type,tpf.file_name,tpf.create_date FROM tn_post_file as tpf WHERE tpf.member_id='".$user_auto_id."' AND tpf.deleted='0' order by tpf.id DESC limit ".$row.",".$rowperpage;
		$query=$this->db->query($sql);
		$result=$query->result_array();

		// echo "<pre>";
		// print_r($result);
		// exit;

		$finalPhotoAry=array();
		$incree=0;
		if(count($result)>0)
		{
			foreach ($result as $k => $v)
			{
				$strPhotoPath='';
				if($v['module_type']=='members')
				{
					$strPhotoPath="/images/members/";
				}
				elseif($v['module_type']=='coverimages')
				{
					$strPhotoPath="/images/members/coverimages/";
				}
				elseif($v['module_type']=='postfiles')
				{
					$strPhotoPath="/images/postfiles/";
				}
				if (file_exists(IMAGE_PATH.$strPhotoPath.$v['file_name']) && $v['file_name']!='')
				{
					$finalPhotoAry[$incree]['id']=$v['id'];
					$finalPhotoAry[$incree]['module_type']=$v['module_type'];
					$finalPhotoAry[$incree]['display_upload_date']=date('d M y h:i A',strtotime($v['create_date']));
					$finalPhotoAry[$incree]['all_file_n_photo_path']=IMAGE_URL.$strPhotoPath.$v['file_name'];
					$incree++;
				}
			}
		}

		// echo "<pre>";
  //       print_r($finalPhotoAry);
  //       exit;

		$returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='';
        $returnData['data']=array('photoScrollData'=>$finalPhotoAry,'photoExist'=>count($finalPhotoAry));
        echo json_encode($returnData);
        exit;

    }


    public function ajaxShowPhotoSlider() 
    {
    	$finalPost=array();

    	$photoSlideData = $this->input->post('photoSlideData');
        $aryPhotoSlideData=json_decode($photoSlideData, true);

        $user_auto_id=$this->session->userdata('user_auto_id');
        $id=(isset($aryPhotoSlideData['id']) && !empty($aryPhotoSlideData['id']))? $aryPhotoSlideData['id']:'0';

        $sqlPrev="SELECT tpf.id, tpf.module_type,tpf.file_name,tpf.create_date FROM tn_post_file as tpf WHERE tpf.member_id='".$user_auto_id."' AND  tpf.id < '".$id."' AND tpf.deleted='0' order by tpf.id DESC limit 1";
		$queryPrev=$this->db->query($sqlPrev);
		$resultPrev=$queryPrev->result_array();
		$totPrev=count($resultPrev);

		$sqlNext="SELECT tpf.id, tpf.module_type,tpf.file_name,tpf.create_date FROM tn_post_file as tpf WHERE tpf.member_id='".$user_auto_id."' AND  tpf.id > '".$id."' AND tpf.deleted='0' order by tpf.id limit 1";
		$queryNext=$this->db->query($sqlNext);
		$resultNext=$queryNext->result_array();
		$totNext=count($resultNext);


        $sql="SELECT tpf.id, tpf.module_type,tpf.file_name,tpf.create_date FROM tn_post_file as tpf WHERE tpf.id='".$id."' AND tpf.deleted='0' ";
		$query=$this->db->query($sql);
		$result=$query->result_array();

		// echo "<pre>";
		// print_r($result);
		// exit;

		$finalPhotoAry=array();
		$incree=0;
		if(count($result)>0)
		{
			foreach ($result as $k => $v)
			{
				$strPhotoPath='';
				if($v['module_type']=='members')
				{
					$strPhotoPath="/images/members/";
				}
				elseif($v['module_type']=='coverimages')
				{
					$strPhotoPath="/images/members/coverimages/";
				}
				elseif($v['module_type']=='postfiles')
				{
					$strPhotoPath="/images/postfiles/";
				}
				if (file_exists(IMAGE_PATH.$strPhotoPath.$v['file_name']) && $v['file_name']!='')
				{
					$finalPhotoAry[$incree]['id']=$v['id'];
					$finalPhotoAry[$incree]['module_type']=$v['module_type'];
					$finalPhotoAry[$incree]['display_upload_date']=date('d M y h:i A',strtotime($v['create_date']));
					$finalPhotoAry[$incree]['all_file_n_photo_path']=IMAGE_URL.$strPhotoPath.$v['file_name'];
					$incree++;
				}
			}
		}

		/*echo "<pre>";
      	print_r($finalPhotoAry);
      	exit;*/

		$returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='';
        $returnData['data']=array('photoSlideData'=>$finalPhotoAry,'resultPrev'=>$resultPrev,'totPrev'=>$totPrev,'resultNext'=>$resultNext,'totNext'=>$totNext);
        echo json_encode($returnData);
        exit;

    }
}