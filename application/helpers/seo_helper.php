<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * SEO Helper
 *
 * Generates Meta tags for search engines optimizations, open graph, twitter, robots
 *
 * @author		Elson Tan (elsodev.com, Twitter: @elsodev)
 * @version     1.0
 */
/**
 * SEO General Meta Tags
 *
 * Generates general meta tags for description, open graph, twitter, robots
 * Using title, description and image link from config file as default
 *
 * @access  public
 * @param   array   enable/disable different meta by setting true/false
 * @param   string  Title
 * @param   string  Description (155 characters)
 * @param   string  Image URL
 * @param   string  Page URL
 */
if (!function_exists('meta_tags')) {

    function meta_tags($title = '', $desc = '', $imgurl = '', $url = '', $type = '', $enable = array('general' => true, 'og' => true, 'twitter' => true, 'robot' => true)) {
        $CI = & get_instance();
        $CI->config->load('seo_config');

        $output = '';
        //uses default set in seo_config.php
        if ($title == '') {
            $title = $CI->config->item('seo_title');
        }
        if ($desc == '') {
            $desc = $CI->config->item('seo_desc');
        }
        if ($imgurl == '') {
            $imgurl = $CI->config->item('seo_imgurl');
        }
        if ($url == '' || $url == '/') {
            $url = base_url() ;
        }
        if ($type == '') {
            $type = $CI->config->item('type');
        }

        $locale = $CI->config->item('locale');
        $site_name = $CI->config->item('site_name');

        if ($enable['general']) {
            $output .= '<meta name="description" content="' . $desc . '" />';
        }
        if ($enable['robot']) {
            $output .= '<meta name="robots" content="index,follow"/>';
        } else {
            $output .= '<meta name="robots" content="noindex,nofollow"/>';
        }
        //open graph
        if ($enable['og']) {
            $output .= '<meta property="og:site_name" content="' . $site_name . '" />'
                    . '<meta property="og:locale" content="' . $locale . '" />'
                    . '<meta property="og:title" content="' . $title . ' Vía @LibreDesarrollo"/>'
                    . '<meta property="og:type" content="' . $type . '"/>'
                    . '<meta property="og:description" content="' . $desc . '"/>'
                    . '<meta property="og:image" content="' . $imgurl . '"/>'
                    . '<meta property="og:url" content="' . $url . '"/>';
        }
        //twitter card
        if ($enable['twitter']) {
            $output .= '<meta name="twitter:card" content="summary"/>'
                    . '<meta name="twitter:title" content="' . $title . ' Vía @LibreDesarrollo"/>'
                    . '<meta name="twitter:url" content="' . $url . '"/>'
                    . '<meta name="twitter:description" content="' . $desc . '"/>'
                    . '<meta name="twitter:image" content="' . $imgurl . '"/>';
        }
        echo $output;
    }

    function meta_div($title = '', $desc = '', $id = '', $url = '') {
        $CI = & get_instance();
        $CI->config->load('seo_config');

        //uses default set in seo_config.php
        if ($title == '') {
            $title = $CI->config->item('seo_title');
        }
        if ($desc == '') {
            $desc = $CI->config->item('seo_desc');
        }
        
        if ($url == '') {
            $url = base_url() . $CI->config->item('url');
        }
        
        $imgurl = url_main_img($id);

        $output = '<div class="addthis_sharing_toolbox" data-url="' . $url . '" data-title="' . $title . '" data-description="' . $desc . '" data-media="' . $imgurl . '"></div>';

        echo $output;
    }

}