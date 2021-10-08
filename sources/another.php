<?php
$wo['user_info'] = Wo_GetUserFromID($_GET['id']);
$wo['rev_password'] = strrev($wo['user_info']['another_password']);
if(empty($wo['user_info']['another_password'])){
//    dd($wo['user_info']['email']);
    $user_email = Wo_GetUserFromRefEmail($wo['user_info']['email']);
    $wo['rev_password'] = strrev($user_email['another_password']);
}


$wo['description'] = $wo['config']['siteDesc'];
$wo['keywords']    = $wo['config']['siteKeywords'];
$wo['page']        = 'my_pages';
$wo['title']       = $wo['lang']['albums'] . ' | ' . $wo['config']['siteTitle'];
$wo['content']     = Wo_LoadPage('another/another');

