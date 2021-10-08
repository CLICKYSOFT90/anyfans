<?php
if ($wo['loggedin'] == false) {
    header("Location: " . Wo_SeoLink('index.php?link1=welcome'));
    exit();
}
$wo['data'] = GetInfluencerCategoryListing();
$wo['category_listing'] = GetAllCategoryListing();
$wo['artist_genre'] = GetAllArtistGenre();
//dd($wo['data']);
//$wo['influencers_category'] = GetInfluencerCategoryListing();

$wo['description'] = $wo['config']['siteDesc'];
$wo['keywords']    = $wo['config']['siteKeywords'];
$wo['page']        = 'artist_listing';
$wo['title']       = 'Influencer Listing' . ' | ' . $wo['config']['siteTitle'];
$wo['content']     = Wo_LoadPage('influncers/influncer-listing');


