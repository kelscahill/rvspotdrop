<?php
/**
 * Template Name: Membership Profile1
 */


global $wpdb, $user_id, $current_user; 
if(!is_user_logged_in()){
	$url= site_url()."/login/";
    wp_redirect($url);
}   

     $user_id = $current_user->ID; // correct ID 
     $mInfo = get_userdata($user_id);

     
     if($mInfo->member_editMonth != date('M')){update_user_meta($user_id, 'member_editCount', '0');} 
	
	if(isset($_POST["submit"]) && ($_POST['submit']=="Save"))
     {
		$first_name=$_REQUEST['first_name'];
		$last_name=$_REQUEST['last_name'];	
		
		          if(isset($mInfo->member_editCount)){
         			$ecount = $mInfo->member_editCount + 1;
         		}else{$ecount = 0;}			
		


			$p_city=$_POST['p_city'];  
			$city="";  
			foreach($p_city as $pCity)  
			   {  
			      $city .= $pCity.",";  
			   }  

			global $wpdb; 
            $username = $mInfo->user_login;
            $email = $mInfo->user_email;
			$campLocation = $_REQUEST['campLocation'];
			$serviceRequirements = $_REQUEST['serviceRequirements'];
			$rigLength = $_REQUEST['rigLength'];
			$rigType = $_REQUEST['rigType'];
			$yearOfRig = $_REQUEST['yearOfRig'];
			$petFriendly = $_REQUEST['petFriendly'];
			$adultOnly = $_REQUEST['adultOnly'];			
			$now = new DateTime();
			$createDate=$now->format('Y-m-d H:i:s');


		   update_user_meta($user_id, 'member_campLocation', $_REQUEST['campLocation']);
		   update_user_meta($user_id, 'member_preferredLocation', $city);
		   update_user_meta($user_id, 'member_serviceRequirements', $_REQUEST['serviceRequirements']);
		   update_user_meta($user_id, 'member_rigLength', $_REQUEST['rigLength']);
		   update_user_meta($user_id, 'member_rigType', $_REQUEST['rigType']);
		   update_user_meta($user_id, 'member_yearOfRig', $_REQUEST['yearOfRig']);
		   update_user_meta($user_id, 'member_petFriendly', $_REQUEST['petFriendly']);
		   update_user_meta($user_id, 'member_adultOnly', $_REQUEST['adultOnly']);
		   update_user_meta($user_id, 'member_editCount', $ecount);
		   update_user_meta($user_id, 'member_editMonth', date('M'));
		   


             
             $sql = "INSERT INTO `{$wpdb->base_prefix}campground`(`user_id`,`username`,`email`,`campLocation`,`preferredLocation`,`serviceRequirements`,`rigLength`,`rigType`,`yearOfRig`,`petFriendly`,`adultOnly`,`createDate`) values('$user_id','$username','$email','$campLocation','$city','$serviceRequirements','$rigLength','$rigType','$yearOfRig','$petFriendly','$adultOnly','$createDate')"; 
            //$wpdb->query($sql);
             
             if($wpdb->query($sql)){ 

			$subject = "New Enquiry";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			//$headers .= "From: RVSpotDrop" . "\r\n";
			$to_email = $mInfo->user_email; 
			$message='
               <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RVSPOTDROP</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#153643" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <h1 style="padding: 5px 0 5px 0; margin-bottom: 0px; color: #dedede; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">RVSPOTDROP</h1>
                            <h2 style="padding: 5px 0 5px 0; margin-top: 0px; color: #dedede; font-size: 16px; font-weight: bold; font-family: Arial, sans-serif;">We Find The Best RV Campground for You</h2>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; text-align:right;">
                                        '.date('d M, Y').'
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <h3 style="padding: 5px 0 5px 0; margin-bottom: 0px; color: #153643; font-size: 20px; font-weight: bold; font-family: Arial, sans-serif;">Member Detail</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="10" cellspacing="10" width="100%" style="border: 1px solid #cccccc; border-collapse: collapse; color: #153643; font-size: 14px; font-weight: normal; font-family: Arial, sans-serif;">
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Username</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$mInfo->user_login.'
                                                </td>
                                            </tr>
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Email</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$mInfo->user_email.'
                                                </td>
                                            </tr>
                                                                                       
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <h3 style="padding: 5px 0 5px 0; margin-bottom: 0px; margin-top: 30px; color: #153643; font-size: 20px; font-weight: bold; font-family: Arial, sans-serif;">Campground Detail</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="10" cellspacing="10" width="100%" style="border: 1px solid #cccccc; border-collapse: collapse; color: #153643; font-size: 14px; font-weight: normal; font-family: Arial, sans-serif;">
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Where do you want to camp?</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$_REQUEST['campLocation'].'
                                                </td>
                                            </tr>
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Preferred Camping Locations</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$city.'
                                                </td>
                                            </tr>
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Service Requirements</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$_REQUEST['serviceRequirements'].'
                                                </td>
                                            </tr>
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Rig Length</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$_REQUEST['rigLength'].'
                                                </td>
                                            </tr>
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Rig Type</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$_REQUEST['rigType'].'
                                                </td>
                                            </tr>
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Year of Rig</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$_REQUEST['yearOfRig'].'
                                                </td>
                                            </tr>
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Pet Friendly?</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$_REQUEST['petFriendly'].'
                                                </td>
                                            </tr>
                                            <tr style="border: 1px solid #cccccc; border-collapse: collapse; ">
                                                <td width="265" valign="top">
                                                    <strong>Adult Only?</strong>
                                                </td>                                                
                                                <td width="275" valign="top">
                                                    '.$_REQUEST['adultOnly'].'
                                                </td>
                                            </tr>
                                            
                                            
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                        © 2020 <a href="#" style="color: #ffffff;"><font color="#ffffff">RVSpotDrop</font></a>
                                    </td>                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
			';

		    $admin_email = get_option('admin_email');
		    $blogname = get_option('blogname');

		    //exit;
	        wp_mail($admin_email, sprintf(__('Preferred Camping Selections'), $blogname), $message, $headers);	
	        wp_mail($to_email, sprintf(__('Preferred Camping Selections'), $blogname), $message, $headers);		   
		}
	    		
     }



get_header(); ?>
<style type="text/css">
	input.member-submit {
    border-radius: 0px;
    padding: 15px 45px;
    font-size: 20px;
    background: #5b90bf;
}
p.note_p{
	color: #f33f4b !important;
	margin-top: 15px !important;
}

.help-inline-error{
	color: #f33f4b!important;
}

</style>
<main id="maincontent" class="middle-align" role="main">
   <div class="container">
      <div id="content-vw" class="members-pro">
      <div class="profile_mem">
         <h1>My Membership Profile</h1>
         <p>Please personalize your preferred camping selections.<br>This information is used to ensure that RVSpotDrop is only sending you campgrounds that fit your needs!</p>  
         <div class="clearfix">
           	<form  id="formProfile" class="membership_form" action="" method="post">        
            <div class="clearfix form-member">
            	<div class="">
                	<label class="form_title">Where do you want to camp? 
                    	<span class="required-point">*</span>
                     </label>
                     <select class="camp-selector" name="campLocation" required>
                     	<option value="">Select Location</option>
                     	<option <?php if($mInfo->member_campLocation =="Canada"){echo 'selected="selected"';} ?> value="Canada">Canada</option>
                        <option <?php if($mInfo->member_campLocation =="USA"){echo 'selected="selected"';} ?> value="USA">USA</option>                        
                     </select>
                     <p>Please choose which country you like to camp in.</p>
                </div>
                
                <div class="canada-city checks-hide clearfix Canada" id="Canada" style="display:none;">
                	<div class="p_city">
                	<label class="form_title ">Preferred Camping Locations - Canada 
                    	<span class="required-point">*</span>
                     </label>
                     </div> 
                     <ul id="canada-cities" class="wpforms-field-required clearfix">
   <li>
      <input type="checkbox" id="alberta" name="p_city[]" value="Alberta" required="">
      <label class="wpforms-field-label-inline" for="alberta">Alberta</label>
   </li>
   <li>
      <input type="checkbox" id="british-columbia" name="p_city[]" value="British Columbia (general)" required="">
      <label class="wpforms-field-label-inline" for="british-columbia">British Columbia (general)</label>
   </li>
   <li>
      <input type="checkbox" id="okanagan" name="p_city[]" value="Okanagan (BC)" required="">
      <label class="wpforms-field-label-inline" for="okanagan">Okanagan (BC)</label>
   </li>
   <li>
      <input type="checkbox" id="vancouver-island" name="p_city[]" value="Vancouver Island (BC)" required="">
      <label class="wpforms-field-label-inline" for="vancouver-island">Vancouver Island (BC)</label>
   </li>
   <li>
      <input type="checkbox" id="eastern-canada" name="p_city[]" value="Eastern Canada (Maritimes)" required="">
      <label class="wpforms-field-label-inline" for="eastern-canada">Eastern Canada (Maritimes)</label>
   </li>
   <li>
      <input type="checkbox" id="manitoba" name="p_city[]" value="Manitoba" required="">
      <label class="wpforms-field-label-inline" for="manitoba">Manitoba</label>
   </li>
   <li>
      <input type="checkbox" id="ontario" name="p_city[]" value="Ontario" required="">
      <label class="wpforms-field-label-inline" for="ontario">Ontario</label>
   </li>
   <li>
      <input type="checkbox" id="quebec" name="p_city[]" value="Quebec" required="">
      <label class="wpforms-field-label-inline" for="quebec">Quebec</label>
   </li>
   <li>
      <input type="checkbox" id="saskatchewan" name="p_city[]" value="Saskatchewan" required="">
      <label class="wpforms-field-label-inline" for="saskatchewan">Saskatchewan</label>
   </li>
</ul>
                </div>     
                
                <div class="usa-city clearfix checks-hide USA" id="USA" style="display:none;">
                	<div class="p_city">
                	<label class="form_title">Preferred Camping Locations - USA 
                    	<span class="required-point">*</span>
                     </label>
                    </div>
                     <ul id="usa-cities" class="wpforms-field-required clearfix">
                           <li>
                              <input type="checkbox" id="alabama" name="p_city[]" value="Alabama" required="">
                              <label class="wpforms-field-label-inline" for="alabama">Alabama</label>
                           </li>
                           <li>
                              <input type="checkbox" id="arizona" name="p_city[]" value="Arizona" required="">
                              <label class="wpforms-field-label-inline" for="arizona">Arizona</label>
                           </li>
                           <li>
                              <input type="checkbox" id="arkansas" name="p_city[]" value="Arkansas" required="">
                              <label class="wpforms-field-label-inline" for="arkansas">Arkansas</label>
                           </li>
                           <li>
                              <input type="checkbox" id="california" name="p_city[]" value="California" required="">
                              <label class="wpforms-field-label-inline" for="california">California</label>
                           </li>
                           <li>
                              <input type="checkbox" id="colorado" name="p_city[]" value="Colorado" required="">
                              <label class="wpforms-field-label-inline" for="colorado">Colorado</label>
                           </li>
                           <li>
                              <input type="checkbox" id="connecticut" name="p_city[]" value="Connecticut" required="">
                              <label class="wpforms-field-label-inline" for="connecticut">Connecticut</label>
                           </li>
                           <li>
                              <input type="checkbox" id="delaware" name="p_city[]" value="Delaware" required="">
                              <label class="wpforms-field-label-inline" for="delaware">Delaware</label>
                           </li>
                           <li>
                              <input type="checkbox" id="florida" name="p_city[]" value="Florida" required="">
                              <label class="wpforms-field-label-inline" for="florida">florida</label>
                           </li>
                           <li>
                              <input type="checkbox" id="georgia" name="p_city[]" value="Georgia" required="">
                              <label class="wpforms-field-label-inline" for="georgia">Georgia</label>
                           </li>
                           <li>
                              <input type="checkbox" id="idaho" name="p_city[]" value="Idaho" required="">
                              <label class="wpforms-field-label-inline" for="idaho">Idaho</label>
                           </li>
                           <li>
                              <input type="checkbox" id="illinois" name="p_city[]" value="Illinois" required="">
                              <label class="wpforms-field-label-inline" for="illinois">Illinois</label>
                           </li>
                           <li>
                              <input type="checkbox" id="indiana" name="p_city[]" value="Indiana" required="">
                              <label class="wpforms-field-label-inline" for="indiana">Indiana</label>
                           </li>
                           <li>
                              <input type="checkbox" id="iowa" name="p_city[]" value="Iowa" required="">
                              <label class="wpforms-field-label-inline" for="iowa">Iowa</label>
                           </li>
                           <li>
                              <input type="checkbox" id="kansas" name="p_city[]" value="Kansas" required="">
                              <label class="wpforms-field-label-inline" for="kansas">Kansas</label>
                           </li>
                           <li>
                              <input type="checkbox" id="kentucky" name="p_city[]" value="Kentucky" required="">
                              <label class="wpforms-field-label-inline" for="kentucky">Kentucky</label>
                           </li>
                           <li>
                              <input type="checkbox" id="louisiana" name="p_city[]" value="Louisiana" required="">
                              <label class="wpforms-field-label-inline" for="louisiana">Louisiana</label>
                           </li>
                           <li>
                              <input type="checkbox" id="maine" name="p_city[]" value="Maine" required="">
                              <label class="wpforms-field-label-inline" for="maine">Maine</label>
                           </li>
                           <li>
                              <input type="checkbox" id="maryland" name="p_city[]" value="Maryland" required="">
                              <label class="wpforms-field-label-inline" for="maryland">Maryland</label>
                           </li>
                           <li>
                              <input type="checkbox" id="massachusetts" name="p_city[]" value="Massachusetts" required="">
                              <label class="wpforms-field-label-inline" for="massachusetts">Massachusetts</label>
                           </li>
                           <li>
                              <input type="checkbox" id="michigan" name="p_city[]" value="Michigan" required="">
                              <label class="wpforms-field-label-inline" for="michigan">Michigan</label>
                           </li>
                           <li>
                              <input type="checkbox" id="minnesota" name="p_city[]" value="Minnesota" required="">
                              <label class="wpforms-field-label-inline" for="minnesota">Minnesota</label>
                           </li>
                           <li>
                              <input type="checkbox" id="mississippi" name="p_city[]" value="Mississippi" required="">
                              <label class="wpforms-field-label-inline" for="mississippi">Mississippi</label>
                           </li>
                           <li>
                              <input type="checkbox" id="missouri" name="p_city[]" value="Missouri" required="">
                              <label class="wpforms-field-label-inline" for="missouri">Missouri</label>
                           </li>
                           <li>
                              <input type="checkbox" id="montana" name="p_city[]" value="Montana" required="">
                              <label class="wpforms-field-label-inline" for="montana">Montana</label>
                           </li>
                           <li>
                              <input type="checkbox" id="nebraska" name="p_city[]" value="Nebraska" required="">
                              <label class="wpforms-field-label-inline" for="nebraska">Nebraska</label>
                           </li>
                           <li>
                              <input type="checkbox" id="nevada" value="Nevada" required="">
                              <label class="wpforms-field-label-inline" for="nevada">Nevada</label>
                           </li>
                           <li>
                              <input type="checkbox" id="new-hampshire" name="p_city[]" value="New Hampshire" required="">
                              <label class="wpforms-field-label-inline" for="new-hampshire">New Hampshire</label>
                           </li>
                           <li>
                              <input type="checkbox" id="new-jersey" name="p_city[]" value="New Jersey" required="">
                              <label class="wpforms-field-label-inline" for="new-jersey">New Jersey</label>
                           </li>
                           <li>
                              <input type="checkbox" id="new-mexico" name="p_city[]" value="New Mexico" required="">
                              <label class="wpforms-field-label-inline" for="new-mexico">New Mexico</label>
                           </li>
                           <li>
                              <input type="checkbox" id="new-york" name="p_city[]" value="New York" required="">
                              <label class="wpforms-field-label-inline" for="new-york">New York</label>
                           </li>
                           <li>
                              <input type="checkbox" id="north-carolina" name="p_city[]" value="North Carolina" required="">
                              <label class="wpforms-field-label-inline" for="north-carolina">North Carolina</label>
                           </li>
                           <li>
                              <input type="checkbox" id="north-dakota" name="p_city[]" value="North Dakota" required="">
                              <label class="wpforms-field-label-inline" for="north-dakota">North Dakota</label>
                           </li>
                           <li>
                              <input type="checkbox" id="ohio" name="p_city[]" value="Ohio" required="">
                              <label class="wpforms-field-label-inline" for="ohio">Ohio</label>
                           </li>
                           <li>
                              <input type="checkbox" id="oklahoma" name="p_city[]" value="Oklahoma" required="">
                              <label class="wpforms-field-label-inline" for="oklahoma">Oklahoma</label>
                           </li>
                           <li>
                              <input type="checkbox" id="oregon" name="p_city[]" value="Oregon" required="">
                              <label class="wpforms-field-label-inline" for="oregon">Oregon</label>
                           </li>
                           <li>
                              <input type="checkbox" id="pennsylvania" name="p_city[]" value="Pennsylvania" required="">
                              <label class="wpforms-field-label-inline" for="pennsylvania">Pennsylvania</label>
                           </li>
                           <li>
                              <input type="checkbox" id="rhode-island" name="p_city[]" value="Rhode Island" required="">
                              <label class="wpforms-field-label-inline" for="rhode-island">Rhode Island</label>
                           </li>
                           <li>
                              <input type="checkbox" id="south-carolina" name="p_city[]" value="South Carolina" required="">
                              <label class="wpforms-field-label-inline" for="south-carolina">South Carolina</label>
                           </li>
                           <li>
                              <input type="checkbox" id="south-dakota" name="p_city[]" value="South Dakota" required="">
                              <label class="wpforms-field-label-inline" for="south-dakota">South Dakota</label>
                           </li>
                           <li>
                              <input type="checkbox" id="tennessee" name="p_city[]" name="p_city[]" value="Tennessee" required="">
                              <label class="wpforms-field-label-inline" for="tennessee">Tennessee</label>
                           </li>
                           <li>
                              <input type="checkbox" id="texas" name="p_city[]" value="Texas" required="">
                              <label class="wpforms-field-label-inline" for="texas">Texas</label>
                           </li>
                           <li>
                              <input type="checkbox" id="utah" name="p_city[]" value="Utah" required="">
                              <label class="wpforms-field-label-inline" for="utah">Utah</label>
                           </li>
                           <li>
                              <input type="checkbox" id="vermont" name="p_city[]" value="Vermont" required="">
                              <label class="wpforms-field-label-inline" for="vermont">Vermont</label>
                           </li>
                           <li>
                              <input type="checkbox" id="virginia" name="p_city[]" value="Virginia" required="">
                              <label class="wpforms-field-label-inline" for="virginia">Virginia</label>
                           </li>
                           <li>
                              <input type="checkbox" id="washington" name="p_city[]" value="Washington" required="">
                              <label class="wpforms-field-label-inline" for="washington">Washington</label>
                           </li>
                           <li>
                              <input type="checkbox" id="west-virginia" name="p_city[]" value="West Virginia" required="">
                              <label class="wpforms-field-label-inline" for="west-virginia">West Virginia</label>
                           </li>
                           <li>
                              <input type="checkbox" id="wisconsin" name="p_city[]" value="Wisconsin" required="">
                              <label class="wpforms-field-label-inline" for="wisconsin">Wisconsin</label>
                           </li>
                           <li>
                              <input type="checkbox" id="wyoming" name="p_city[]" value="Wyoming" required="">
                              <label class="wpforms-field-label-inline" for="wyoming">Wyoming</label>
                           </li>
                        </ul>
                </div>     
                
                
                <div class="">
                	<label class="form_title">Service Requirements 
                    	<span class="required-point">*</span>
                     </label>
     <select name="serviceRequirements" required>
     	<option <?php if($mInfo->member_serviceRequirements == "30 Amp only"){echo 'selected="selected"';} ?> value="30 Amp only">30 Amp only</option>
        <option <?php if($mInfo->member_serviceRequirements == "50 Amp only"){echo 'selected="selected"';} ?> value="50 Amp only">50 Amp only</option>
        <option <?php if($mInfo->member_serviceRequirements == "3 way (30 Amp power, water, sewer)"){echo 'selected="selected"';} ?> value="3 way (30 Amp power, water, sewer)">3 way (30 Amp power, water, sewer)</option>
        <option <?php if($mInfo->member_serviceRequirements == "3 way (50 Amp power, water, sewer)"){echo 'selected="selected"';} ?> value="3 way (50 Amp power, water, sewer)">3 way (50 Amp power, water, sewer)</option>
        <option <?php if($mInfo->member_serviceRequirements == "Water only"){echo 'selected="selected"';} ?> value="Water only">Water only</option>
        <option <?php if($mInfo->member_serviceRequirements == "Dry camping (no services)"){echo 'selected="selected"';} ?> value="Dry camping (no services)">Dry camping (no services)</option>
     </select>
                     <p>Choose what service requirements you need.</p>
                </div>
                
                <div class="">
                	<label class="form_title">Rig Length 
                    	<span class="required-point">*</span>
                     </label>
                     <select name="rigLength" required>
                     	<option <?php if($mInfo->member_rigLength == "Less than 20'"){echo 'selected="selected"';} ?> value="Less than 20'">Less than 20'</option>
                        <option <?php if($mInfo->member_rigLength == "21 - 30'"){echo 'selected="selected"';} ?> value="21 - 30'">21 - 30'</option>
                        <option <?php if($mInfo->member_rigLength == "31 - 40'"){echo 'selected="selected"';} ?> value="31 - 40'">31 - 40'</option>
                        <option <?php if($mInfo->member_rigLength == "Greater than 41'"){echo 'selected="selected"';} ?> value="Greater than 41'">Greater than 41'</option>
                     </select>
                     <p>Please select the length of your rig. This measurement is the trailer only and includes the hitch.</p>
                </div>
                
                 <div class="">
                	<label class="form_title rigType">Rig Type 
                    	<span class="required-point">*</span>
                     </label>
                    <div>
                    <ul id="" class="rig_type clearfix">
                       <li class="">
                        <input type="radio" name="rigType" id="a-class" value="A Class" <?php if($mInfo->member_rigType == "A Class"){echo 'checked="checked"';} ?> required="">
                        <label for="a-class">A Class</label>
                       </li>
                       <li class="">
                        <input type="radio" name="rigType" id="b-class" value="B Class / Van" <?php if($mInfo->member_rigType == "B Class / Van"){echo 'checked="checked"';} ?> required="">
                        <label for="b-class">B Class / Van</label></li>
                       <li class="choice-6 depth-1">
                        <input type="radio" name="rigType" id="c-class" value="C Class" <?php if($mInfo->member_rigType == "C Class"){echo 'checked="checked"';} ?> required="">
                        <label for="c-class">C Class</label>
                       </li>
                       <li class="">
                        <input type="radio" name="rigType" id="travel-trailer" value="Travel Trailer" <?php if($mInfo->member_rigType == "Travel Trailer"){echo 'checked="checked"';} ?> required="">
                        <label for="travel-trailer">Travel Trailer</label>
                       </li>
                       <li class="">
                        <input type="radio" name="rigType" id="fifth-wheel" value="Fifth Wheel" <?php if($mInfo->member_rigType == "Fifth Wheel"){echo 'checked="checked"';} ?> required="">
                        <label for="fifth-wheel">Fifth Wheel</label>
                       </li>
                       <li class="">
                        <input type="radio" name="rigType" id="tent-trailer" value="Tent Trailer" <?php if($mInfo->member_rigType == "Tent Trailer"){echo 'checked="checked"';} ?> required="">
                        <label for="tent-trailer">Tent Trailer</label>
                       </li>
                    </ul>
                    </div>
                     <p>What kind of rig do you have? Select 1.</p>
                </div>
                
                <div class="">
                	<label class="form_title">Year of Rig</label>
                    <input type="range" class="year-ring" value="<?php if($mInfo->member_yearOfRig){echo $mInfo->member_yearOfRig;} ?>" min="1960" max="2022" step="1" id="myRange">
                    <input type="hidden" value="" name="yearOfRig" id="myRig">
                     <div>Selected Value: <strong id="yearly"><?php if($mInfo->member_yearOfRig){echo $mInfo->member_yearOfRig;} ?></strong></div>
                     <p>What year is your rig? * Some campgrounds may have age restrictions.</p>
                </div>
                
                 <div class="">
                	<label class="form_title petFriendly">Pet Friendly? 
                    	<span class="required-point">*</span>
                     </label>
                    <div>
                    <ul id="" class="pet-field clearfix">
                       <li class="">
                        <input type="radio" name="petFriendly" value="Yes" id="y" <?php if($mInfo->member_petFriendly == "Yes"){echo 'checked="checked"';} ?> required="">
                        <label for="y">Yes</label>
                       </li>
                       <li class="">
                        <input type="radio" name="petFriendly" value="No" id="n" <?php if($mInfo->member_petFriendly == "No"){echo 'checked="checked"';} ?> required="">
                        <label for="n">No</label></li>
                    </ul>
                    </div>
                     <p>Do you travel with pets?</p>
                </div>
                
                <div class="">
                	<label class="form_title adultOnly">Adult Only? 
                    	<span class="required-point">*</span>
                     </label>
                    <div>
                    <ul id="" class="adult-field clearfix">
                       <li class="">
                        <input type="radio" id="ye" name="adultOnly" value="Yes" <?php if($mInfo->member_adultOnly == "Yes"){echo 'checked="checked"';} ?> required="">
                        <label for="ye">Yes</label>
                       </li>
                       <li class="">
                        <input type="radio" id="no" name="adultOnly" value="No" <?php if($mInfo->member_adultOnly == "No"){echo 'checked="checked"';} ?> required="">
                        <label for="no">No</label></li>
                        <li class="">
                        <input type="radio" id="no-preference" name="adultOnly" value="No preference" <?php if($mInfo->member_adultOnly == "No preference"){echo 'checked="checked"';} ?> required="">
                        <label for="no-preference">No preference</label></li>
                    </ul>
                    </div>
                     <p>Are you looking for an adult only campground or resort ?</p>
                </div>
               <?php if($mInfo->member_editCount != 2){ ?>
                <input type="submit" name="submit" class="member-submit" value="Save">
               <?php } ?>
                <p class="note_p">Note: With a Basic Membership, you can edit your preferences up to 2 times per month.</p>
                                
            </div>
           </form>
         </div>
      </div>
   </div>
    </div> 
</main>

<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("yearly");
var myRig = document.getElementById("myRig");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
  myRig.value=output.innerHTML;
}
</script>

<?php get_footer(); ?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript">  

 
jQuery(document).ready(function(){

jQuery(function() {
  jQuery('.camp-selector').change(function(){
    jQuery('.checks-hide').hide();
    jQuery('#' + jQuery(this).val()).show();
    jQuery('#' + jQuery(this).val() + ' input:checkbox').removeAttr('checked');
  });
});

jQuery("#formProfile").validate({ 
        rules: {
			username: {
                required: true,
            },
			password: {
                required: true,
            },
			campLocation: {
			   required: true
			}            
        },		
		errorElement: "span",
		errorClass: "help-inline-error",
		errorPlacement: function (error, element) {
        var name = jQuery(element).attr("name");
        var type = jQuery(element).attr("type");
	      if(name === "petFriendly") {            
	            error.insertAfter('.petFriendly').wrap('<div/>');
	        }else if(name === "adultOnly") {            
	            error.insertAfter('.adultOnly').wrap('<div/>');
	        }else if(name === "rigType") {            
	            error.insertAfter('.rigType').wrap('<div/>');
	        }else if(type === "checkbox") {            
	            error.insertAfter('.p_city').wrap('<div/>');
	        } else {
	            error.insertAfter(element).wrap('<div/>'); 
	        } 
			        
			},		
		        
    });	
});	
</script>