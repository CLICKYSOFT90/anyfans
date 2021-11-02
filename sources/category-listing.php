<?php
if ($wo['loggedin'] == false) {
    header("Location: " . Wo_SeoLink('index.php?link1=welcome'));
    exit();
}
$platform = Wo_Secure($_GET['platform']);
$genre = Wo_Secure($_GET['category']);
//$genre = str_replace('-', ' ', $genre);
$wo['category_listing'] = GetAllCategoryListing();
$wo['artist_genre'] = GetAllArtistGenre();
if($platform == 'influencer') {
    $wo['data'] = GetInfluencerCategoryListingByCategory($genre, $platform);
    $wo['description'] = $wo['config']['siteDesc'];
    $wo['keywords']    = $wo['config']['siteKeywords'];
    $wo['page']        = 'category_listing';
    $wo['title']       = ucfirst($_GET['category']) . ' | ' . $wo['config']['siteTitle'];
    $wo['content']     = Wo_LoadPage('influncers/category-listing');
}else{
    $wo['data'] = GetArtistCategoryListingByCategory($genre, $platform);
    $wo['description'] = $wo['config']['siteDesc'];
    $wo['keywords']    = $wo['config']['siteKeywords'];
    $wo['page']        = 'category_listing';
    $wo['title']       = ucfirst($_GET['category']) . ' | ' . $wo['config']['siteTitle'];
    $wo['content']     = Wo_LoadPage('artist/category-listing');
}



