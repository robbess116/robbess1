<?php
 /**
 * index.php, home page.
 * @package Example-application
 */

require('./setup.php');
require_once('dbVideos.php');
require_once('dbCategory.php');
require_once('dbChannel.php');
require_once('dbType.php');
require_once('common.php');
require_once('dbAdmin.php');


		$action = "";
		
		$mode="0";
		$title_id="0";
		$category_parent_id="";
		$category_name_E="";
		$category_name_A="";
		$upload_date=date("Y-m-d h:i:s");
		$coverimage="images/videoTitleIcon/videoicon.jpg";
		$video_types="";
		$video_type="";
		$video_type_row="";
		$video_type_id="";
		$categories="";
		$category="";
		$category_id="";
		$usertypes="";
		$user_type="";
		$user_type_row="";
		$user_type_id="";
		$view_count="";
		$videoTitles="";
		$title="";
		$videos="";
		$video_url="";
		$channel_name="";
		$video_description="";
		$selectedcategory="";
		$selectedcategory_id="";
       
		$selectedusertype_id="";
		$selectedusertype="";
		
if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $channel_id=$_SESSION['channel_id'];
    $user_id=$_SESSION['user_id'];
    $channel_name=$_SESSION['channel_name'];
$categories=$dbCategories->getCategories();
 
 

$types=$dbTypes->getTypes();
$videos=$dbVideos->getVideosByUserId($user_id);
if($action=='create'){
	$mode=$_REQUEST['mode'];
	$category_id=$_REQUEST['category'];
	$video_type_id=$_REQUEST['video_type'];
   $kind=$_REQUEST['kind'];
	$title=$_REQUEST['title'];
	$video_description=$_REQUEST['description'];
	$id=$_REQUEST['title_id'];
	$category=$dbCategories->getCategoryById($category_id);
	$channel=$dbChannels->getChannelById($channel_id);
	$category_name=$category['category_name'];
	$channel_name=$channel['channel_name'];
	$video_types=$dbTypes->getTypes();
	$video_type=$dbTypes->getTypeById($video_type_id);
	$video_type_name=$video_type['name'];
	$filename=uploadImage('imagefile','videocoverimage',329,185,true);
        $videofilename=uploadVideo('videofile');
        $title_icon=$filename;
        $video_url=$videofilename;
	
	
	$video=$dbVideos->getVideoById($id);
	
    
	if($mode=='0'){
	if($title_icon==""){
        
    }else if($video_url==""){
        
    }else{
        $dbVideos->createVideo_user($title,$video_description,$title_icon,$video_type_id,$category_id,$channel_id,$video_url,$view_count,$user_id,$kind) ;
    }	
	
   
	$videos=$dbVideos->getVideosByUserId($user_id);
	$video_url="";
	$coverimage="images/videoTitleIcon/videoicon.jpg";
	$video_description="";
	$title="";
	}
	else{
        if($title_icon==""){
        
    }else if($video_url==""){
        
    }else{
       $dbVideos->saveVideoById($id,$title,$video_description,$title_icon,$video_type_id,$category_id,$channel_id,$video_url,$video['view_count'],$kind);
    }	
		$mode='0';      
	
	$videos=$dbVideos->getVideosByUserId($user_id);
    $video_url="";
	$coverimage="images/videoTitleIcon/videoicon.jpg";
	$video_description="";
	$title="";
	$selectedcategory="";
	$selectedcategory_id="";
	}
	
//$smarty->display("{$prefix}videoTitle.tpl");
	
		
}
if($action=='delete'){
	$title_id=$_REQUEST['id'];
	
	$dbVideos->dropVideoById($title_id);
   $videos=$dbVideos->getVideosByUserId($user_id);
	// deleteImage($video['coverimage']);
	
		
}
if($action=='modify'){
	$title_id=$_REQUEST['id'];
	$video=$dbVideos->getVideoById($title_id);
    //print_r($video);exit;
	$category=$dbCategories->getCategoryById($video['category_id']);
	
	// $video_type=$dbTypes->getTypeById($video['type_id']);
	// $dbTypes->saveCheckedById($video['type_id']);
    $types=$dbTypes->getTypes();
	$mode='1';
	$selectedcategory=$category['category_name'];
	$selectedcategory_id=$video['category_id'];
	$title=$video['title'];
	
	$video_url=$video['video_url'];
	$video_description=$video['description'];
	
	$coverimage=$video['coverimage'];
		
}
	
	
	$smarty->assign("mode",$mode);
    $smarty->assign("title_id",$title_id);
    $smarty->assign("coverimage",$coverimage);
    $smarty->assign("title",$title);
    $smarty->assign("selectedcategory_id",$selectedcategory_id);
    $smarty->assign("selectedcategory",$selectedcategory);
   
    $smarty->assign("categories",$categories);
    $smarty->assign("channel_name",$channel_name);
    
    $smarty->assign("types",$types);
    $smarty->assign("videourl",$video_url);
    // $smarty->assign("selectedvideotype_id",$selectedvideotype_id);
    // $smarty->assign("selectedvideotype",$selectedvideotype);
    $smarty->assign("video_description",$video_description);
    $smarty->assign("videos",$videos);
    
    
	$smarty->display("{$prefix}videos_user.tpl");
} else {
   $smarty->display("{$prefix}login.tpl");
}

?>