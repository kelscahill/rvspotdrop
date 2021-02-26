<?php
/**
 * Template Name: Membership Delete
 */


global $wpdb, $user_id, $current_user; 
$user = wp_get_current_user();
$user_role = $user->roles[0];
if(is_user_logged_in() && !isset($_GET['status'])){
if($user_role == "subscriber"){
   
        
     if(isset($_POST["submit"]) && ($_POST['submit']=="Delete")){
        

        $user_id = $current_user->ID; // correct ID 
        if($_POST['user']== $user_id){

            wp_destroy_current_session();
            wp_clear_auth_cookie();
            wp_set_current_user( 0 );
            wp_delete_user( $_POST['user'] );            
            $url= site_url()."/membership-delete/?status=true'";
            
        }else{
            $url= site_url();
        }
      
        wp_redirect($url);
        exit;
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
      <div class="profile_mem" align="center">
         <h1 style="text-align: center;">Are you sure you want to delete your account?</h1>
           
         <div class="clearfix">
            <form  id="formProfile" class="membership_form" action="" method="post">        
            <div class="clearfix form-member">
                
                
                <input type="hidden" name="user" value="<?php echo $current_user->ID; ?>"> 
             
                <input type="submit" name="submit" class="member-submit" value="Delete">
              
              
                                
            </div>
           </form>
         </div>
      </div>
   </div>
    </div> 
</main>



<?php get_footer(); 


  }else{
   $url= site_url();
  }
    wp_redirect($url);
    exit;
} else if(isset($_GET['status'])){

get_header(); ?>

<main id="maincontent" class="middle-align" role="main">
   <div class="container">
      <div id="content-vw" class="members-pro">
      <div class="profile_mem">
         <h1 style="text-align: center;">Your account has been deleted!</h1>
         
      </div>
   </div>
    </div> 
</main>



<?php get_footer(); 



}else{
    $url= site_url();
    wp_redirect($url);
    exit;
}

 



