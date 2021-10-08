<?php
if ($wo['loggedin'] == false) {
    header("Location: " . Wo_SeoLink('index.php?link1=welcome'));
    exit();
}
$wo['data'] = GetArtistCategoryListing();
$wo['category_listing'] = GetAllCategoryListing();
$wo['artist_genre'] = GetAllArtistGenre();
//dd($wo['artist_genre']);
//$wo['influencers_category'] = GetInfluencerCategoryListing();

$wo['description'] = $wo['config']['siteDesc'];
$wo['keywords']    = $wo['config']['siteKeywords'];
$wo['page']        = 'artist_listing';
$wo['title']       = 'Artist Listing' . ' | ' . $wo['config']['siteTitle'];
$wo['content']     = Wo_LoadPage('artist/artist-listing');


