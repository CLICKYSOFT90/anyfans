<?php
if ($wo['loggedin'] == false) {
    header("Location: " . Wo_SeoLink('index.php?link1=welcome'));
    exit();
}
$platform = Wo_Secure($_GET['platform']);
$genre = Wo_Secure($_GET['category']);
//$genre = str_replace('-', ' ', $genre);
if($platform == 'influencer') {
    $wo['data'] = GetInfluencerCategoryListingByCategory($genre, $platform);
}else{
    $wo['data'] = GetArtistCategoryListingByCategory($genre, $platform);
}
$wo['category_listing'] = GetAllCategoryListing();


$wo['description'] = $wo['config']['siteDesc'];
$wo['keywords']    = $wo['config']['siteKeywords'];
$wo['page']        = 'category_listing';
$wo['title']       = ucfirst($_GET['category']) . ' | ' . $wo['config']['siteTitle'];
$wo['content']     = Wo_LoadPage('influncers/category-listing');

