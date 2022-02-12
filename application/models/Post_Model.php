<?php
class Post_Model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function addupdatepost($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_post',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_post',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function addupdatetagfriend($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_post_tag_friend',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_post_tag_friend',$menu_arr);
			return $this->db->insert_id();
		}
	}
	public function addupdatemembertimeline($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_member_timeline',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_member_timeline',$menu_arr);
			return $this->db->insert_id();
		}
	}
	public function addUpdatPostFile($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_post_file',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_post_file',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function getPostLikeData($post_id=0)
	{
		$sqlPostLikes="SELECT 
		tpl.id,
		tpl.member_id,
		tm.first_name,
		tm.last_name,
		tm.profile_image

		FROM tn_post_like as tpl
		LEFT JOIN tn_members as tm on tm.id=tpl.member_id
		WHERE tpl.post_id='".$post_id."' AND tpl.deleted='0' AND tm.status='1' and tm.deleted='0'";
		$queryPostLikes=$this->db->query($sqlPostLikes);
		$resultPostLikes=$queryPostLikes->result_array();
		return $resultPostLikes;
	}

	public function addUpdatPostLikeUnlike($menu_arr=NULL)
	{
		$array_return=array();
		$post_id=$menu_arr['post_id'];
		$member_id=$menu_arr['member_id'];

		$sql='SELECT id,deleted from tn_post_like WHERE post_id="'.$post_id.'" AND member_id="'.$member_id.'"';
		$query=$this->db->query($sql);
		$rowData=$query->row();
		$post_like_id=0;
		if(!empty($rowData) && $rowData->id>0)
		{
			$post_like_id=$rowData->id;
		}
		if(!empty($post_like_id) && $post_like_id>0)
		{
			$strDeleted='0';
			if($rowData->deleted=='0')
			{
				$strDeleted='1';
			}

			$menu_arr['deleted'] =$strDeleted;
			$this->db->where('id',$post_like_id)->update('tn_post_like',$menu_arr);

			$array_return['post_like_id']=$post_like_id;
			$array_return['strDeleted']=$strDeleted;
			return $array_return;
		}
		else
		{
			$strDeleted='0';
			$menu_arr['deleted'] =$strDeleted;
			$this->db->insert('tn_post_like',$menu_arr);

			$array_return['post_like_id']=$this->db->insert_id();
			$array_return['strDeleted']=$strDeleted;
			return $array_return;
		}
	}

	public function addUpdatePostComment($menu_arr=NULL,$id=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_post_comments',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_post_comments',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function getPostCommentData($aryArgu=array())
	{
		$post_id=$aryArgu['post_id'];
		$start=$aryArgu['start'];
		$limit=$aryArgu['limit'];

		$strLimit="";
		if($limit!="")
		{
			$strLimit=" limit ".$start.",".$limit;
		}

		$sqlPostComments="SELECT 
		tpl.id,
		tpl.member_comment,
		DATE_FORMAT(tpl.create_date, '%d %b %Y %h:%i %p') as comment_date,
		tm.first_name,
		tm.last_name,
		tm.profile_image

		FROM tn_post_comments as tpl
		LEFT JOIN tn_members as tm on tm.id=tpl.member_id
		WHERE tpl.post_id='".$post_id."' AND tpl.deleted='0' AND tm.status='1' and tm.deleted='0' ".$strLimit;
		$queryPostComments=$this->db->query($sqlPostComments);
		$resultPostComments=$queryPostComments->result_array();
		return $resultPostComments;
	}

}
?>