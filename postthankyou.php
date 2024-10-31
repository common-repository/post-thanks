<?php
/**
 * @package Postthankyou
 */
/*
Plugin Name: Post Thanks
Description: This plugin adds custom text in end of each post published.
Version: 1.2
Author: Inderjeet Singh
License: GPLv2 or later
Text Domain: Postthankyou
*/

/*
 *Code hooks “the_content” action that renders post content for your site. When this action fires, 
 * WordPress will call our “my_thank_you_text” function. 
 */
  
add_action('admin_menu', 'p_my_thank_you_menu');

function p_my_thank_you_menu() {
	add_menu_page(__('p_my_thank_you_form', 'thank-you'), __('Post Bulk Add Text', 'thank-you'), 'manage_options', 'p_my_thank_you_form', 'p_my_thank_you_form');
}

function p_my_thank_you_form() {
	
	    echo '
		<br>
	<div class="container" style="border:solid; border-color:blue; padding:15px;">
  <h2 style="font-weight: 900;
    font-style: italic;
    font-size: -webkit-xxx-large;">Post Thank You ---- Menu</h2>
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
	<div style="float:left;width:50%;">
	<p style ="font-weight: 900;
    font-style: italic;
    font-size: large;">Display or Hide text:</p>
    <div class="radio">
      <label style="font-weight: 900;
    font-style: italic;
    font-size: inherit;"><input type="radio" name="displayhide" value="block" checked>Display text</label>
    </div>
    <div class="radio">
      <label style="font-weight: 900;
    font-style: italic;
    font-size: inherit;"><input type="radio" name="displayhide" value="none">Hide text</label>
	</div>
		<br>
	<div>
    <p style="font-weight: 900;
    font-style: italic;
    font-size: large;">Enter your text here:</p>
    <textarea cols="21" rows="3" name="text">' . ( isset( $_POST['text']) ? $text : null ) . '</textarea>
    <br>
    </div>
		<br>
	<div>
    <p style="font-weight: 900;
    font-style: italic;
    font-size: large;">Set text color:</p>
    <input type ="text" name="textcolor">' . ( isset( $_POST['textcolor']) ? $textcolor : null ) . '
    <br>
    </div>
    </div>
    <div style="float:left;width:50%;height: 389px;">
    <p style="font-weight: 900;
    font-style: italic;
    font-size: large;">Show text on top or bottom of posts.</p>
    <div class="radio">
      <label style="font-weight: 900;
    font-style: italic;
    font-size: inherit;"><input type="radio" name="topbottom" value="top">Top</label>
    </div>
    <div class="radio">
      <label style="font-weight: 900;
    font-style: italic;
    font-size: inherit;"><input type="radio" name="topbottom" value="bottom" checked>Bottom</label>
	</div>
		<br>
    </div>
	<br>
	<br>
    <input type="submit" name="submit" value="Submit" style="font-weight: 900;
    font-style: italic;
    font-size: x-large;"/>
    </form>
	</div>
    ';

    if (!isset($_POST['text'])) {
        echo '<div style="border:solid; padding:15px;"><p style="font-weight: 900;
    font-style: italic;
    font-size: large;">Current text active is: </p><div style="color:'.get_option( 'post_thanks_text_color' ).'">'.
        get_option( 'post_thanks_text' ).'</div></div>';
        exit;
    } else {
       $text = esc_textarea($_POST['text']);
		add_option( 'post_thanks_text', $text );
		update_option( 'post_thanks_text', $text );
    }
	
	$textcolor = $_POST["textcolor"]; 
	add_option( 'post_thanks_text_color', $textcolor );
	update_option( 'post_thanks_text_color', $textcolor );

	$showhide = $_POST["displayhide"]; 
	add_option( 'post_thanks_text_displayhide', $showhide );
	update_option( 'post_thanks_text_displayhide', $showhide );
	
	$topbottom = $_POST["topbottom"]; 
	add_option( 'post_thanks_text_topbottom', $topbottom );
	update_option( 'post_thanks_text_topbottom', $topbottom );
	
	echo '<div style="border:solid; padding:15px;"><br><div style="font-weight: 900;
    font-style: italic;
    font-size: large;">Following text added in all posts: </div> <br><div style="color:'.get_option( 'post_thanks_text_color' ).'">'.
        get_option( 'post_thanks_text' ).'</div></div>';
}

add_action( 'the_content', 'p_my_thank_you_text' );

function p_my_thank_you_text ($content) {
	$post_thanks_text = get_option( 'post_thanks_text' );
	$post_thanks_text_color = get_option( 'post_thanks_text_color' );
	$post_thanks_text_showhide = get_option( 'post_thanks_text_displayhide' );
	$post_thanks_text_topbottom = get_option( 'post_thanks_text_topbottom' );
		
	if($post_thanks_text == ''){
		return $content;
	}
	if($post_thanks_text != ''){
		if($post_thanks_text_topbottom == 'bottom'){
			return $content .= '<div style = "color: '.$post_thanks_text_color.'; display: '.$post_thanks_text_showhide.';" class="post_thanks">'.$post_thanks_text.'</div>';
		}
	    if($post_thanks_text_topbottom == 'top'){
			$content2 = '<div style = "color: '.$post_thanks_text_color.'; display: '.$post_thanks_text_showhide.';" class="post_thanks">'.$post_thanks_text.'</div>' . $content;
			return $content2 ;
		}
	}
}
