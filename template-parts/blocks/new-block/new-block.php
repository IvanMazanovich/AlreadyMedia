<?php

require get_template_directory() . '/classes/unsplashWriter.php';

$id = 'block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

$className = 'new-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$title = get_field('title') ?: 'Заголовок блока';
$description = get_field('description') ?: 'Описание для блока';
$search = get_field('search') ?: 'Ключевое слово для поиска изображений';
$count = get_field('count') ?: 'Количество изображений';
$orientation = get_field('orientation') ?: 'Ориентация';

$writer = new UnsplashWriter();
$results = $writer->searchPhoto($search,$count,$orientation);

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <h2 class="new-block__title">
        <?php echo $title; ?>
    </h2>
    <p class="new-block__description">
        <?php echo $description; ?>
    </p>
    <swiper-container class="swiper-slider" slides-per-view="1" speed="500" loop="false" auto-height="true" navigation="true" pagination="true">
        <?php for ($i = 0; $i <= $count-1; $i++) {
            echo '<swiper-slide class="swiper-slide" lazy="true"><img class="swiper-slide__image" loading="lazy" src="' . $results[$i]['urls']['regular'] . '" alt="' . $results[$i]['description'] . '"></swiper-slide>';
        } ?>
    </swiper-container>
</section>

<?php