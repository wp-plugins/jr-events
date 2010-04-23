<?php
/*
Plugin Name: JR Events
Plugin URI: http://www.jakeruston.co.uk/2010/02/wordpress-plugin-jr-events/
Description: Displays certain upcoming events as a widget.
Version: 1.1.3
Author: Jake Ruston
Author URI: http://www.jakeruston.co.uk
*/

/*  Copyright 2010 Jake Ruston - the.escapist22@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Hook for adding admin menus
add_action('admin_menu', 'jr_events_add_pages');
if (!defined("ch"))
{
function setupch()
{
$ch = curl_init();
$c = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
return($ch);
}
define("ch", setupch());
}

if (!function_exists("curl_get_contents")) {
function curl_get_contents($url)
{
$c = curl_setopt(ch, CURLOPT_URL, $url);
return(curl_exec(ch));
}
}
register_activation_hook(__FILE__,'events_choice');

function events_choice () {
if (get_option("jr_events_links_choice")=="") {


$content = curl_get_contents("http://www.jakeruston.co.uk/pluginslink4.php");

if ($content!="") {
update_option("jr_events_links_choice", $content);
}
}
}

// action function for above hook
function jr_events_add_pages() {
    add_options_page('JR Events', 'JR Events', 'administrator', 'jr_events', 'jr_events_options_page');
}

// jr_events_options_page() displays the page content for the Test Options submenu
function jr_events_options_page() {

    // variables for the field and option names 
    $opt_name = 'mt_events_account';
    $opt_name_2 = 'mt_events_limit';
	$opt_name_3 = 'mt_events_query';
	$opt_name_4 = 'mt_events_title2';
    $opt_name_5 = 'mt_events_plugin_support';
    $opt_name_6 = 'mt_events_title';
    $opt_name_9 = 'mt_events_cache';
    $hidden_field_name = 'mt_events_submit_hidden';
    $data_field_name = 'mt_events_account';
    $data_field_name_2 = 'mt_events_limit';
	$data_field_name_3 = 'mt_events_query';
	$data_field_name_4 = 'mt_events_title2';
    $data_field_name_5 = 'mt_events_plugin_support';
    $data_field_name_6 = 'mt_events_title';
    $data_field_name_9 = 'mt_events_cache';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
    $opt_val_2 = get_option($opt_name_2);
	$opt_val_3 = get_option($opt_name_3);
	$opt_val_4 = get_option($opt_name_4);
    $opt_val_5 = get_option($opt_name_5);
    $opt_val_6 = get_option($opt_name_6);
    $opt_val_9 = get_option($opt_name_9);

if (!$_POST['feedback']=='') {
$my_email1="the.escapist22@gmail.com";
$plugin_name="JR Events";
$blog_url_feedback=get_bloginfo('url');
$user_email=$_POST['email'];
$user_email=stripslashes($user_email);
$subject=$_POST['subject'];
$subject=stripslashes($subject);
$name=$_POST['name'];
$name=stripslashes($name);
$response=$_POST['response'];
$response=stripslashes($response);
$category=$_POST['category'];
$category=stripslashes($category);
if ($response=="Yes") {
$response="REQUIRED: ";
}
$feedback_feedback=$_POST['feedback'];
$feedback_feedback=stripslashes($feedback_feedback);
if ($user_email=="") {
$headers1 = "From: feedback@jakeruston.co.uk";
} else {
$headers1 = "From: $user_email";
}
$emailsubject1=$response.$plugin_name." - ".$category." - ".$subject;
$emailmessage1="Blog: $blog_url_feedback\n\nUser Name: $name\n\nUser E-Mail: $user_email\n\nMessage: $feedback_feedback";
mail($my_email1,$emailsubject1,$emailmessage1,$headers1);
?>

<div class="updated"><p><strong><?php _e('Feedback Sent!', 'mt_trans_domain' ); ?></strong></p></div>

<?php
}
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];
        $opt_val_2 = $_POST[$data_field_name_2];
		$opt_val_3 = $_POST[$data_field_name_3];
		$opt_val_4 = $_POST[$data_field_name_4];
        $opt_val_5 = $_POST[$data_field_name_5];
        $opt_val_6 = $_POST[$data_field_name_6];
        $opt_val_9 = $_POST[$data_field_name_9];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );
        update_option( $opt_name_2, $opt_val_2 );
		update_option( $opt_name_3, $opt_val_3 );
		update_option( $opt_name_4, $opt_val_4 );
        update_option( $opt_name_5, $opt_val_5 );
        update_option( $opt_name_6, $opt_val_6 ); 
        update_option( $opt_name_9, $opt_val_9 );
		update_option("mt_events_cachey", "");

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'JR Events Plugin Options', 'mt_trans_domain' ) . "</h2>";
$blog_url_feedback=get_bloginfo('url');
	$donated=curl_get_contents("http://www.jakeruston.co.uk/p-donation/index.php?url=".$blog_url_feedback);
	if ($donated=="1") {
	?>
		<div class="updated"><p><strong><?php _e('Thank you for donating!', 'mt_trans_domain' ); ?></strong></p></div>
	<?php
	} else {
	?>
	<div class="updated"><p><strong><?php _e('Please consider donating to help support the development of my plugins!', 'mt_trans_domain' ); ?></strong><br /><br /><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ULRRFEPGZ6PSJ">
<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form></p></div>
<?php
}

    // options form
   
    $change3 = get_option("mt_events_plugin_support");
    $change6 = get_option("mt_events_cache");

if ($change3=="Yes" || $change3=="") {
$change3="checked";
$change31="";
} else {
$change3="";
$change31="checked";
}

if ($change5=="user" || $change5=="") {
$change5="checked";
$change51="";
} else {
$change5="";
$change51="checked";
}

    ?>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Widget Title:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_6; ?>" value="<?php echo $opt_val_6; ?>" size="50">
</p><hr />

<p><?php _e("Query (Keyword to display events for):", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_3; ?>" value="<?php echo $opt_val_3; ?>" size="20">
</p><hr />

<p><?php _e("Location:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
</p><hr />

<p><?php _e("Number of Events to Show:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_2; ?>" value="<?php echo $opt_val_2; ?>" size="3">
</p><hr />

<p><?php _e("Show Plugin Support?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="Yes" <?php echo $change3; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="No" <?php echo $change31; ?> id="Please do not disable plugin support - This is the only thing I get from creating this free plugin!" onClick="alert(id)">No
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>
<script type="text/javascript">
function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {
    alert(alerttxt);return false;
    }
  else
    {
    return true;
    }
  }
}

function validate_form(thisform)
{
with (thisform)
  {
  if (validate_required(subject,"Subject must be filled out!")==false)
  {email.focus();return false;}
  if (validate_required(email,"E-Mail must be filled out!")==false)
  {email.focus();return false;}
  if (validate_required(feedback,"Feedback must be filled out!")==false)
  {email.focus();return false;}
  }
}
</script><h3>Submit Feedback about my Plugin!</h3>
<p><b>Note: Only send feedback in english, I cannot understand other languages!</b></p>
<form name="form2" method="post" action="" onsubmit="return validate_form(this)">
<p><?php _e("Name:", 'mt_trans_domain' ); ?> 
<input type="text" name="name" /></p>
<p><?php _e("E-Mail:", 'mt_trans_domain' ); ?> 
<input type="text" name="email" /></p>
<p><?php _e("Category:", 'mt_trans_domain'); ?>
<select name="category">
<option value="Bug Report">Bug Report</option>
<option value="Feature Request">Feature Request</option>
<option value="Other">Other</option>
</select>
<p><?php _e("Subject (Required):", 'mt_trans_domain' ); ?>
<input type="text" name="subject" /></p>
<input type="checkbox" name="response" value="Yes" /> I want e-mailing back about this feedback</p>
<p><?php _e("Comment (Required):", 'mt_trans_domain' ); ?> 
<textarea name="feedback"></textarea>
</p>
<p class="submit">
<input type="submit" name="Send" value="<?php _e('Send', 'mt_trans_domain' ); ?>" />
</p><hr /></form>
</div>
<?php
 
}

if (get_option("jr_events_links_choice")=="") {
events_choice();
}

function show_events($args) {

extract($args);

  $widget_title = get_option("mt_events_title"); 
  $max_tracks = get_option("mt_events_limit");  
  $location = get_option("mt_events_account");
  $supportplugin = get_option("mt_events_plugin_support"); 
  $optioneventscache = get_option("mt_events_cache");
  $query = get_option("mt_events_query");

$widget_title=str_replace("%user%", $optionevents, $widget_title);

$doc = new DOMDocument();

$docload='http://upcoming.yahooapis.com/services/rest/?api_key=4cfc6a0c7c&method=event.search&search_text='.$query.'.&location='.$location;

if($doc->load($docload)) {

  $i = 1;

$eventsdisp="";

  $eventsdisp .= $before_title; 

  $eventsdisp .= $widget_title.$after_title."<br />".$before_widget."<ul>";

  foreach ($doc->getElementsByTagName('event') as $node) {

    $id = $node->getAttributeNode('id');
	$id = $id->nodeValue;
	$name = $node->getAttributeNode('name');
	$name = $name->nodeValue;
	$venue_name = $node->getAttributeNode('venue_name');
	$venue_name = $venue_name->nodeValue;
	$venue_city = $node->getAttributeNode('venue_city');
	$venue_city = $venue_city->nodeValue;
	$start_date = $node->getAttributeNode('start_date');
	$start_date = $start_date->nodeValue;
	$start_time = $node->getAttributeNode('start_time');
	$start_time = $start_time->nodeValue;
	

$url = "http://upcoming.yahoo.com/event/".$id;
    $eventsdisp .= '<li><font color="#000000" size="2"><a href="'.$url.'">'.$name.'</a><br />'.$venue_name.', '.$venue_city.'<br />'.$start_time.'<br />'.$start_date.'</font></li><br />';
    $check = "Yes";
    if($i++ >= $max_tracks) break;
  }

  if ($check!="Yes") {
  $eventsdisp .= "<li>No events found.</li>";
  }
  $eventsdisp .= "</ul>";
  
if ($supportplugin=="Yes" || $supportplugin=="") {
$pluginschoicelink=get_option("jr_events_links_choice");
preg_match("/sunbrella-cushions.info/", $pluginschoicelink, $xyz);
if ($xyz[0]!="") {
update_option("jr_events_links_choice", 'Sponsored by <a href="http://www.cushion-reviews.info">Sunbrella Cushions</a> and <a href="http://www.gpthq.com">GPT</a>.');
}
$eventsdisp .= "<p style='font-size:x-small'>Events Plugin created by Jake Ruston's <a href='http://www.jakeruston.co.uk'>Wordpress Plugins</a> - ".get_option('jr_events_links_choice')."</p>";
}

$eventsdisp .= $after_widget;

echo $eventsdisp;

}

}

function init_events_widget() {
register_sidebar_widget("JR Events", "show_events");
}

add_action("plugins_loaded", "init_events_widget");

?>
