<?php
require get_template_directory() . '/vendor/autoload.php';

use Unsplash\HttpClient;
use Unsplash\Search;

class UnsplashWriter {
    private Search $photos;
    public function __construct()
    {
        Unsplash\HttpClient::init([
            'applicationId' => 'rL2pkCScoonc0-AWvT4Kw5zoIyr2hwC2ku8fx2dup2U',
            'utmSource' => 'NewApp'
        ]);
    }

    public function searchPhoto(string $search, string $per_page, string $orientation) {
        $photos = get_transient( 'unsplash_photos' );

        if ( $photos !== false ) {
            return $photos;
        }

        $photos = Unsplash\Search::photos($search,1, $per_page, $orientation);
        set_transient( 'unsplash_photos', $photos, DAY_IN_SECONDS );

        return $photos;
    }

}