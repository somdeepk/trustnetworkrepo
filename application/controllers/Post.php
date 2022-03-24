<?php 
class Post extends CI_Controller
{
	public function verbose ($ok=1, $info="")
	{
	  if ($ok==0) { http_response_code(400); }
	  exit(json_encode(["ok"=>$ok, "info"=>$info]));
	}

	public function ajaxsubmitpostfiles() 
    {
    	$lastPostId=$this->session->userdata('lastPostId');

		if (!empty($_FILES) && !$_FILES["file"]["error"] && $lastPostId>0)
		{
			$file_original_name=isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
			$file_size=$_FILES["file"]["size"];
			$file_type=$_FILES["file"]["type"];
			$current_date=date('Y-m-d H:i:s');  			

		  	$fileBasePath = IMAGE_PATH.'images/postfiles';
		  	$filePath = $fileBasePath . DIRECTORY_SEPARATOR . $file_original_name;

			// (D) DEAL WITH CHUNKS
			$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
			$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
			$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
			if ($out) {
			  $in = @fopen($_FILES["file"]["tmp_name"], "rb");
			  if ($in) { while ($buff = fread($in, 4096)) { fwrite($out, $buff); } }
			  else { $this->verbose(0, "Failed to open input stream"); }
			  @fclose($in);
			  @fclose($out);
			  @unlink($_FILES["file"]["tmp_name"]);
			} else { $this->verbose(0, "Failed to open output stream"); }

			// (E) CHECK IF FILE HAS BEEN UPLOADED
			if (!$chunks || $chunk == $chunks - 1){
				$imarr=explode(".",$file_original_name);
		    	$ext=end($imarr);				

				$aryPostData=$this->Post_Model->getPostData($lastPostId);
				$member_id=$aryPostData[0]['member_id'];
				$menu_arr_post_file = array(
		            'module_id'=>$lastPostId,
		            'module_type'=>'post',
		            'member_id'   => $member_id,
		            'file_original_name'   =>$file_original_name,
		            'file_size'   =>$file_size,        
		            'file_type'   =>$ext, 
		            'create_date'   =>$current_date       
		        );

                $last_post_file_id = $this->Post_Model->addUpdatPostFile(0,$menu_arr_post_file);

                if($last_post_file_id>0)
                {
                	$file_name = $last_post_file_id."-".time().'.'.$ext;
	                $filePathSysem = $fileBasePath . DIRECTORY_SEPARATOR . $file_name;
	                rename("{$filePath}.part", $filePathSysem);

	                $menu_arr_post_file = array(
			            'file_name'   =>$file_name     
			        );
	                $last_post_file_id = $this->Post_Model->addUpdatPostFile($last_post_file_id,$menu_arr_post_file);
	            }

				

			}
			$this->verbose(1, "Upload OK");
		}		
    }

    public function ajaxsubmitsinglepost() 
    {
    	$returnData=array();
        $singlePostData = trim($this->input->post('singlePostData'));
        $arySinglePostData=json_decode($singlePostData, true);

        $aryPostTagFriend = trim($this->input->post('aryPostTagFriend'));
        $aryPostTagFriend=json_decode($aryPostTagFriend, true);

        $member_id=(isset($arySinglePostData['loggedUserId']) && !empty($arySinglePostData['loggedUserId']))? addslashes(trim($arySinglePostData['loggedUserId'])):'0';
        $post=(isset($arySinglePostData['post']) && !empty($arySinglePostData['post']))? addslashes(trim($arySinglePostData['post'])):'';
        $uploaddata=(isset($arySinglePostData['uploaddata']) && !empty($arySinglePostData['uploaddata']))? $arySinglePostData['uploaddata']:array();

		$current_date=date('Y-m-d H:i:s');

		if($member_id>0 && (!empty($post) || count($uploaddata)))
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

			if($lastPostId>0)
			{
				$this->session->set_userdata('lastPostId',$lastPostId);

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
					$finalPost[$key]['disabled_comments']=$value['disabled_comments'];
					$finalPost[$key]['add_favorites']=$value['add_favorites'];
					$finalPost[$key]['post_id']=$value['post_id'];
					$finalPost[$key]['from_member_id']=$value['from_member_id'];
					$finalPost[$key]['to_member_id']=$value['to_member_id'];
					$finalPost[$key]['member_comment']='';

					//Start Get Post File Images/Video Data
					$sqlPostFile="SELECT id, file_name,file_type FROM tn_post_file WHERE module_id='".$value['post_id']."' AND module_type='post' AND deleted='0'";
					$queryPostFile=$this->db->query($sqlPostFile);
					$resultPostFile=$queryPostFile->result_array();

					$finalPost[$key]['post_file_data']=array();
					if(count($resultPostFile)>0)
					{
						$tempResultPostFile=array();
						foreach($resultPostFile as $kPF=>$vPF)
						{
							$tempResultPostFile[$kPF]=$vPF;
							$tempResultPostFile[$kPF]['file_type_url']=IMAGE_URL.'images/postfiles/'.$vPF['file_name'];
						}
						$finalPost[$key]['post_file_data']=$tempResultPostFile;			
					}
					//End Get Post File Images/Video Data

					//Start Get tag to Friend Data
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
					$sqlIndvPostLike="SELECT deleted FROM tn_post_like WHERE module_id='".$value['post_id']."' AND module_type='post' AND member_id='".$user_auto_id."'";
					$queryIndvPostLike=$this->db->query($sqlIndvPostLike);
					$rowIndvPostLike=$queryIndvPostLike->row();

					$finalPost[$key]['indv_post_like_unlike']=1;
					if(count($rowIndvPostLike)>0)
					{
						$finalPost[$key]['indv_post_like_unlike']=$rowIndvPostLike->deleted;
					}
					//End Get Individual Post Like/Unlike Status

					//Start Get Post Like data
					$menu_argu_arr = array(
			            'module_id'  =>$value['post_id'],
			            'module_type'  =>'post',
			        );
					$resultPostLikes = $this->Post_Model->getPostLikeData($menu_argu_arr);
					$finalPost[$key]['post_like_data']=array();
					if(count($resultPostLikes)>0)
					{
						$finalPost[$key]['post_like_data']=$resultPostLikes;
					}
					//End Get Post Like data

					//Start Get Post All Comment data
					$aryArgu=array();
					$aryArgu['module_id']=$value['post_id'];
					$aryArgu['module_type']='post';
					$aryArgu['start']='';
					$aryArgu['limit']='';
					$postAllCommentData = $this->Post_Model->getPostCommentData($aryArgu);
					//End Get Post All Comment data	

					//Start Get Post Limit Comment data
					$aryArgu=array();
					$aryArgu['module_id']=$value['post_id'];
					$aryArgu['module_type']='post';
					$aryArgu['start']=0;
					$aryArgu['limit']=3;
					$postCommentData = $this->Post_Model->getPostCommentData($aryArgu);
					//Start Get All Comment Like/Unlike Status
					if(count($postCommentData)>0)
					{
						foreach($postCommentData as $keyPC => $valuePC)
						{
							$menu_comment_argu_arr = array(
					            'module_id'  =>$valuePC['id'],
					            'module_type'  =>'comment',
					        );
							$postCommentData[$keyPC]['comment_like_data']= $this->Post_Model->getPostLikeData($menu_comment_argu_arr);


							//Start Get Individual Comment Like/Unlike Status
							$sqlIndvCommentLike="SELECT deleted FROM tn_post_like WHERE module_id='".$valuePC['id']."' AND module_type='comment' AND member_id='".$user_auto_id."'";
							$queryIndvCommentLike=$this->db->query($sqlIndvCommentLike);
							$rowIndvCommentLike=$queryIndvCommentLike->row();

							$postCommentData[$keyPC]['indv_comment_like_unlike']=1;
							if(count($rowIndvCommentLike)>0)
							{
								$postCommentData[$keyPC]['indv_comment_like_unlike']=$rowIndvCommentLike->deleted;
							}
							//End Get Individual Comment Like/Unlike Status
						}
					}
					//End Get All Comment Like/Unlike Status

					//End Get Post Limit Comment data	

					$finalPost[$key]['limit_post_comment_data']=$postCommentData;
					$finalPost[$key]['totComments']=count($postAllCommentData);
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

    public function likeTimelinePost() 
    {

    	$returnData=array();
    	$postStatusData=$this->input->get_post('postStatusData');
    	$aryPostStatusData=json_decode($postStatusData, true);
  
  		$module_id=(isset($aryPostStatusData['module_id']) && !empty($aryPostStatusData['module_id']))? addslashes(trim($aryPostStatusData['module_id'])):0;
  		$module_type=(isset($aryPostStatusData['module_type']) && !empty($aryPostStatusData['module_type']))? addslashes(trim($aryPostStatusData['module_type'])):'';

  		$user_auto_id=$this->session->userdata('user_auto_id');
		$current_date=date('Y-m-d H:i:s');
		
		$menu_arr = array(
            'module_id'  =>$module_id,
            'module_type'  =>$module_type,
            'member_id'  =>$user_auto_id,
            'create_date'  =>$current_date,
        );

		$array_return = $this->Post_Model->addUpdatPostLikeUnlike($menu_arr);

		$post_like_id=$array_return['post_like_id'];
		$strDeleted=$array_return['strDeleted'];

		

		//Start Get Post Like data
		$postLikeData = $this->Post_Model->getPostLikeData($menu_arr);
		//End Get Post Like data	

		// echo "PP<pre>";
		// print_r($array_return);
		// print_r($postLikeData);
		// exit;

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

    public function changeCommonPostStatus() 
    {

    	$returnData=array();
    	$postStatusData=$this->input->get_post('postStatusData');
    	$aryPostStatusData=json_decode($postStatusData, true);
  
  		$id=(isset($aryPostStatusData['timelineId']) && !empty($aryPostStatusData['timelineId']))? addslashes(trim($aryPostStatusData['timelineId'])):0;
  		$post_id=(isset($aryPostStatusData['post_id']) && !empty($aryPostStatusData['post_id']))? addslashes(trim($aryPostStatusData['post_id'])):0;
		$idfire=(isset($aryPostStatusData['idfire']) && !empty($aryPostStatusData['idfire']))? addslashes(trim($aryPostStatusData['idfire'])):'';
		$tempDisableComment=(isset($aryPostStatusData['tempDisableComment']) && !empty($aryPostStatusData['tempDisableComment']))? addslashes(trim($aryPostStatusData['tempDisableComment'])):0;
		$tempAddFavoritest=(isset($aryPostStatusData['tempAddFavoritest']) && !empty($aryPostStatusData['tempAddFavoritest']))? addslashes(trim($aryPostStatusData['tempAddFavoritest'])):0;

		if($idfire=='hide_post'){
			$menu_arr['status']='H';
		}elseif($idfire=='disabled_comments'){
			$menu_arr['disabled_comments']=$tempDisableComment;
		}elseif($idfire=='add_favorites'){
			$menu_arr['add_favorites']=$tempAddFavoritest;
		}elseif($idfire=='deleted'){
			$menu_arr['deleted']='1';
		}else{
			$menu_arr['status']='S';
		}

		$lastId=0;
		if($post_id>0 && $idfire=='deleted')
		{
			$lastId = $this->Post_Model->addupdatepost($post_id,$menu_arr);
		}elseif($id>0 && $idfire!='deleted'){
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

    public function commentTimelinePost() 
    {
    	$returnData=array();
    	$postCommentData=$this->input->get_post('postCommentData');
    	$aryPostCommentData=json_decode($postCommentData, true);
  
  		$post_comments_id=(isset($aryPostCommentData['post_comments_id']) && !empty($aryPostCommentData['post_comments_id']))? addslashes(trim($aryPostCommentData['post_comments_id'])):0;
  		$module_id=(isset($aryPostCommentData['module_id']) && !empty($aryPostCommentData['module_id']))? addslashes(trim($aryPostCommentData['module_id'])):0;
  		$module_type=(isset($aryPostCommentData['module_type']) && !empty($aryPostCommentData['module_type']))? addslashes(trim($aryPostCommentData['module_type'])):'';

  		$member_comment=(isset($aryPostCommentData['member_comment']) && !empty($aryPostCommentData['member_comment']))? addslashes(trim($aryPostCommentData['member_comment'])):'';

  		$user_auto_id=$this->session->userdata('user_auto_id');
		$current_date=date('Y-m-d H:i:s');
		
		$menu_arr = array(
            'module_id'  =>$module_id,
            'module_type'  =>$module_type,
            'member_id'  =>$user_auto_id,
            'member_comment'  =>$member_comment,
            'create_date'  =>$current_date,
        );

		$last_post_comments_id = $this->Post_Model->addUpdatePostComment($menu_arr,$post_comments_id);
				

		//Start Get Post All Comment data
		$aryArgu=array();
		$aryArgu['module_id']=$module_id;
		$aryArgu['module_type']=$module_type;
		$aryArgu['start']='';
		$aryArgu['limit']='';
		$postAllCommentData = $this->Post_Model->getPostCommentData($aryArgu);
		//End Get Post All Comment data	

		//Start Get Post Limit Comment data
		$aryArgu=array();
		$aryArgu['module_id']=$module_id;
		$aryArgu['module_type']=$module_type;
		$aryArgu['start']=0;
		$aryArgu['limit']=3;
		$postCommentData = $this->Post_Model->getPostCommentData($aryArgu);		
		//End Get Post Limit Comment data	

		
		if($last_post_comments_id>0)
		{
			$returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Comment Successfully Done';
	        $returnData['data']=array('last_post_comments_id'=>$last_post_comments_id,'limit_post_comment_data'=>$postCommentData,'totComments'=>count($postAllCommentData));
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

    public function showMoreCommentTimelinePost() 
    {
    	$returnData=array();
    	$postCommentData=$this->input->get_post('postCommentData');
    	$aryPostCommentData=json_decode($postCommentData, true);
  
  		$module_id=(isset($aryPostCommentData['module_id']) && !empty($aryPostCommentData['module_id']))? $aryPostCommentData['module_id']:0;
  		$module_type=(isset($aryPostCommentData['module_type']) && !empty($aryPostCommentData['module_type']))? addslashes(trim($aryPostCommentData['module_type'])):'';
  		$totStartRowComment=(isset($aryPostCommentData['totStartRowComment']) && !empty($aryPostCommentData['totStartRowComment']))? $aryPostCommentData['totStartRowComment']:3;
		$user_auto_id=$this->session->userdata('user_auto_id');
		//Start Get Post All Comment data
		$aryArgu=array();
		$aryArgu['module_id']=$module_id;
		$aryArgu['module_type']=$module_type;
		$aryArgu['start']='';
		$aryArgu['limit']='';
		$postAllCommentData = $this->Post_Model->getPostCommentData($aryArgu);
		//End Get Post All Comment data	

		//Start Get Post All Comment data
		$aryArgu=array();
		$aryArgu['module_id']=$module_id;
		$aryArgu['module_type']=$module_type;
		$aryArgu['start']=$totStartRowComment;
		$aryArgu['limit']=3;
		$postCommentData = $this->Post_Model->getPostCommentData($aryArgu);
		//Start Get All Comment Like/Unlike Status
		if(count($postCommentData)>0)
		{
			foreach($postCommentData as $keyPC => $valuePC)
			{
				$menu_comment_argu_arr = array(
		            'module_id'  =>$valuePC['id'],
		            'module_type'  =>'comment',
		        );
				$postCommentData[$keyPC]['comment_like_data']= $this->Post_Model->getPostLikeData($menu_comment_argu_arr);

				//Start Get Individual Comment Like/Unlike Status
				$sqlIndvCommentLike="SELECT deleted FROM tn_post_like WHERE module_id='".$valuePC['id']."' AND module_type='comment' AND member_id='".$user_auto_id."'";
				$queryIndvCommentLike=$this->db->query($sqlIndvCommentLike);
				$rowIndvCommentLike=$queryIndvCommentLike->row();

				$postCommentData[$keyPC]['indv_comment_like_unlike']=1;
				if(count($rowIndvCommentLike)>0)
				{
					$postCommentData[$keyPC]['indv_comment_like_unlike']=$rowIndvCommentLike->deleted;
				}
				//End Get Individual Comment Like/Unlike Status
			}
		}
		//End Get All Comment Like/Unlike Status
		//End Get Post All Comment data	

		$returnData['status']='1';
		$returnData['msg']='success';
		$returnData['msgstring']='Comment Successfully Done';
		$returnData['data']=array('last_post_comments_id'=>$last_post_comments_id,'limit_post_comment_data'=>$postCommentData,'totComments'=>count($postAllCommentData));
		    
        echo json_encode($returnData);
        exit;
    }


    public function ajaxGetPostFileList() 
    {
    	$finalPost=array();

    	$postFileData = $this->input->post('postFileData');
        $aryPostFileData=json_decode($postFileData, true);

        $post_id=(isset($aryPostFileData['post_id']) && !empty($aryPostFileData['post_id']))? $aryPostFileData['post_id']:'0';
        $post_file_id=(isset($aryPostFileData['post_file_id']) && !empty($aryPostFileData['post_file_id']))? $aryPostFileData['post_file_id']:6;


        if($post_id>0 && $post_file_id>0)
        {
			//Start Get Post File Images/Video Data
			$sqlPrev="SELECT id FROM tn_post_file WHERE module_id='".$post_id."' AND module_type='post' AND id < '".$post_file_id."' AND deleted='0' order by id DESC limit 1";
			$queryPrev=$this->db->query($sqlPrev);
			$resultPrev=$queryPrev->result_array();
			$totPrev=count($resultPrev);

			$finalPost['resultPrev']=$resultPrev;
			$finalPost['totPrev']=$totPrev;

			$sqlNext="SELECT id FROM tn_post_file WHERE module_id='".$post_id."' AND module_type='post' AND id > '".$post_file_id."' AND deleted='0' order by id ASC limit 1";
			$queryNext=$this->db->query($sqlNext);
			$resultNext=$queryNext->result_array();
			$totNext=count($resultNext);

			$finalPost['resultNext']=$resultNext;
			$finalPost['totNext']=$totNext;


			$sqlPostFile="SELECT file_name,file_type FROM tn_post_file WHERE module_id='".$post_id."' AND module_type='post' AND id='".$post_file_id."' AND deleted='0'";
			$queryPostFile=$this->db->query($sqlPostFile);
			$resultPostFile=$queryPostFile->result_array();

			$finalPost['post_file_data']=array();
			if(count($resultPostFile)>0)
			{
				$tempResultPostFile=$resultPostFile[0];
				$tempResultPostFile['file_type_url']=IMAGE_URL.'images/postfiles/'.$resultPostFile[0]['file_name'];				
				$finalPost['post_file_data']=$tempResultPostFile;			
			}
			//End Get Post File Images/Video Data

			//Start Get tag to Friend Data
			$sqlPostTagFriend="SELECT 
			tmt.to_member_id,
			tm.first_name,
			tm.last_name
			FROM tn_member_timeline as tmt 
			LEFT JOIN tn_members as tm on tm.id=tmt.to_member_id
			WHERE tmt.post_id='".$post_id."' AND tm.status='1' AND tm.deleted='0' AND tmt.post_type='tagged'";
			$queryPostTagFriend=$this->db->query($sqlPostTagFriend);
			$resultPostTagFriend=$queryPostTagFriend->result_array();

			$finalPost['post_tag_friend_data']=array();
			if(count($resultPostTagFriend)>0)
			{
				$finalPost['post_tag_friend_data']=$resultPostTagFriend;
			}
			//End Get tag to Friend Data

			//Start Get Post Data
			$sqlPost="SELECT 
			tp.id,
			tp.member_id,
			tp.post,
			tp.create_date,

			tm.first_name,
			tm.last_name,
			tm.profile_image

			FROM tn_post as tp
			LEFT JOIN tn_members as tm on tm.id=tp.member_id
			WHERE tp.id='".$post_id."' AND tp.status='1' AND tp.deleted='0' AND tm.status='1' and tm.deleted='0'";
			$queryPost=$this->db->query($sqlPost);
			$resultPost=$queryPost->result_array();

			$finalPost['post_data']=array();
			if(count($resultPost)>0)
			{
				$finalPost['post_data']=$resultPost[0];
				$finalPost['post_data']['display_create_date']=date('d M Y h:i A',strtotime($resultPost[0]['create_date']));
				if(count($finalPost['post_tag_friend_data'])>0)
				{
					$strFirstTagFriend=$finalPost['post_tag_friend_data'][0]['first_name']." ".$finalPost['post_tag_friend_data'][0]['last_name'];
					$tag_string_dispaly=" is with ".$strFirstTagFriend;
					if(count($finalPost['post_tag_friend_data'])>1)
					{
						$tag_string_dispaly.=" & ".(count($finalPost['post_tag_friend_data'])-1)." others";
					}

					$finalPost['post_data']['tag_string_dispaly']=$tag_string_dispaly;
				}
			}
			//End Get Post Data
		}

		// echo "<pre>";
		// print_r($finalPost);
		// exit;

		$returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='';
        $returnData['data']=array('postFileData'=>$finalPost);
        echo json_encode($returnData);
        exit;

    }


  //   public function ajaxGetPhotoList() 
  //   {
  //   	$finalPost=array();

  //   	$photoScrollData = $this->input->post('photoScrollData');
  //       $aryPhotoScrollDataa=json_decode($photoScrollData, true);

  //       $user_auto_id=$this->session->userdata('user_auto_id');
  //       $row=(isset($aryPhotoScrollDataa['row']) && !empty($aryPhotoScrollDataa['row']))? $aryPhotoScrollDataa['row']:'0';
  //       $rowperpage=(isset($aryPhotoScrollDataa['rowperpage']) && !empty($aryPhotoScrollDataa['rowperpage']))? $aryPhotoScrollDataa['rowperpage']:'0';

  //       $sql="SELECT tpf.id, tpf.module_type,tpf.file_name,tpf.create_date FROM tn_post_file as tpf WHERE tpf.member_id='".$user_auto_id."' AND tpf.deleted='0' order by tpf.id DESC limit ".$row.",".$rowperpage;
		// $query=$this->db->query($sql);
		// $result=$query->result_array();

		// $finalPhotoAry=array();
		// $incree=0;
		// if(count($result)>0)
		// {
		// 	foreach ($result as $k => $v)
		// 	{
		// 		$strPhotoPath='';
		// 		if($v['module_type']=='members')
		// 		{
		// 			$strPhotoPath="/images/members/";
		// 		}
		// 		elseif($v['module_type']=='coverimages')
		// 		{
		// 			$strPhotoPath="/images/members/coverimages/";
		// 		}
		// 		elseif($v['module_type']=='post')
		// 		{
		// 			$strPhotoPath="/images/postfiles/";
		// 		}
		// 		if (file_exists(IMAGE_PATH.$strPhotoPath.$v['file_name']) && $v['file_name']!='')
		// 		{
		// 			$finalPhotoAry[$incree]['id']=$v['id'];
		// 			$finalPhotoAry[$incree]['module_type']=$v['module_type'];
		// 			$finalPhotoAry[$incree]['display_upload_date']=date('d M y h:i A',strtotime($v['create_date']));
		// 			$finalPhotoAry[$incree]['all_file_n_photo_path']=IMAGE_URL.$strPhotoPath.$v['file_name'];
		// 			$incree++;
		// 		}
		// 	}
		// }

		// // echo "<pre>";
		// //       print_r($finalPhotoAry);
		// //       exit;

		// $returnData['status']='1';
  //       $returnData['msg']='success';
  //       $returnData['msgstring']='';
  //       $returnData['data']=array('photoScrollData'=>$finalPhotoAry,'photoExist'=>count($finalPhotoAry));
  //       echo json_encode($returnData);
  //       exit;

  //   }
}