<?php
if ($wo['loggedin'] == false && !isset($_GET['id'])) {
    header("Location: " . Wo_SeoLink('index.php?link1=artist'));
    exit();
}
$id = Wo_Secure($_GET['id']);
$wo['influncer_info'] = Wo_GetInfluencer($id);
//dd($wo['influncer_info']);
$wo['influencer_comments'] = Wo_GetTemplateComments($id, 'influencer');
$wo['top_artist'] = Wo_GetTopInfluencer($wo['influncer_info']['influencer_category'], 3);
$wo['ranking_info'] = Wo_GetInfluencerRankings($wo['influncer_info']['influencer_category'], 0);
//$wo['user_voted'] = Wo_UserVotedInfluencer($wo['user']['user_id'], $wo['influncer_info']['page_id'],0);
//$wo['user_voted_category'] = Wo_UserVotedInfluencerCategory($wo['user']['user_id'], $wo['influncer_info']['influencer_category'],0);
$wo['user_voted_category'] = Wo_UserHasVotedInfluencer($wo['user']['user_id'], 0,0);

//dd($wo['ranking_info'] );
if (empty($wo['user_voted_category'])) {
    // User has not voted for this artist
    $wo['vote'] = 0;
} else if ($wo['user_voted_category'][0]['vote_type'] == 0 || $wo['user_voted_category'][0]['vote_type'] == 1) {
    // User has voted for this artist
    $user_package = GetUserPackageLogs($wo['user']['user_id']);
    if ($user_package && $user_package[0]['expired_at'] > date('Y-m-d')) {
        $wo['vote'] = 1;
    } else {
        $wo['vote'] = 0;
    }
}

$wo['description'] = $wo['config']['siteDesc'];
$wo['keywords']    = $wo['config']['siteKeywords'];
$wo['page']        = 'rank_influncer';
$wo['title']       = 'Rank Influencer' . ' | ' . $wo['config']['siteTitle'];
$wo['content']     = Wo_LoadPage('influncers/influncer-rank');

