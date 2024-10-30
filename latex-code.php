<?php
/*
Plugin Name: iDienstler's Latex Code
Plugin URI: http://wordpress.org/extend/plugins/idienstlers-latex-code
Description: Plugin for adding latex code like [tex]\alpha[/tex] to a post. 
Version: 1.0.1
Author: Jürgen Scholz
Author URI: http://informatikdienstleistungen.de
Min WP Version: 3.4.1
Max WP Version: 3.7.0
*/

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) 
{
    exit('Please don\'t access this file directly.');
}

class ILC_LATEX {

    function ilc_init() 
    {
		add_filter( 'the_content', array(&$this, 'ilc_pre_process_shortcode') , 7);
	}

	/*function ilc_tex_replace($hits)
	{
		$result="";
		// alternative http://latex.informatikdienstleistungen.de/cgi-bin/mathtex.cgi
		$result= "<img src=\"http://www.forkosh.com/mathtex.cgi?".($hits[1])."\" />";
		return $result;
	}*/

	function ilc_content($atts, $syntax, $shortcode)
	{
    
		//$result = preg_replace_callback("/\[tex\](.*?)\[\/tex\]/is", "ilc_tex_replace",$result);    
		//$result = preg_replace("/\[tex\](.*?)\[\/tex\]/is", "'<img src=\"/cgi-bin/mathtex.cgi?'.rawurlencode('$1').'\" align=\"middle\" />'",$result);   
		return "<img src=\"http://www.forkosh.com/mathtex.cgi?".rawurlencode($syntax)."\" align=\"middle\" />";
	}

	// The function pre_process_shortcode is needed to prevent wpautop filter shortcode 
	// Source: http://wpforce.com/prevent-wpautop-filter-shortcode/
	function ilc_pre_process_shortcode($content) 
	{
		global $shortcode_tags;

		// Backup current registered shortcodes and clear them all out
		$orig_shortcode_tags = $shortcode_tags;
		$shortcode_tags = array();

		add_shortcode('tex', array(&$this, 'ilc_content'));

		// Do the shortcode (only the one above is registered)
		$content = do_shortcode($content);

		// Put the original shortcodes back
		$shortcode_tags = $orig_shortcode_tags;
		return $content;
	}

}

/* Main */
if (is_admin()) 
{

}
else
{
	$ilc_latex = new ILC_LATEX;
	add_action( 'init', array(&$ilc_latex,'ilc_init'));
}  
?>