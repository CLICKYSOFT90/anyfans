<?php
if ($wo['loggedin'] == false) {
    header("Location: " . Wo_SeoLink('index.php?link1=artist'));
    exit();
}
$id = Wo_Secure($_GET['id']);
$wo['artist_info'] = Wo_GetArtist($id);
$wo['artist_comments'] = Wo_GetTemplateComments($id, 'artist');
$wo['top_artist'] = Wo_GetTopArtist($wo['artist_info']['platform'], 3);
$wo['ranking_info'] = Wo_GetArtistRankings($wo['artist_info']['genre_id'], 0);
//$wo['user_voted'] = Wo_UserVotedArtist($wo['user']['user_id'], $wo['artist_info']['page_id'],0);
//$wo['user_voted_category'] = Wo_UserVotedArtistCategory($wo['user']['user_id'], $wo['artist_info']['artist_category'],0);
$wo['user_voted_any_artist'] = Wo_UserHasVotedArtist($wo['user']['user_id'], 0,0);
//dd($wo['user_voted_category']);
//dd($wo['top_artist']);
if (empty($wo['user_voted_any_artist'])) {
    // User has not voted for this artist
    $wo['vote'] = 0;
} else if ($wo['user_voted_any_artist'][0]['vote_type'] == 0 || $wo['user_voted_any_artist'][0]['vote_type'] == 1) {
    // User has voted for this artist
    $user_package = GetUserPackageLogs($wo['user']['user_id']);
    if ($user_package && $user_package[0]['expired_at'] > date('Y-m-d')) {
        $wo['vote'] = 1;
    } else {
        $wo['vote'] = 0;
    }
}
$wo['description'] = $wo['config']['siteDesc'];
$wo['keywords'] = $wo['config']['siteKeywords'];
$wo['page'] = 'rank_influncer';
$wo['title'] = 'Rank Artist' . ' | ' . $wo['config']['siteTitle'];
$wo['content'] = Wo_LoadPage('artist/artist-rank');

