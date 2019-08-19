<?php
/**
 * Функция, реализующая шорткод
 *
 * @param $atts string - входные параметры, указанные в виде атрибутов шорткода
 *
 * @return string
 */
function insert_slider( $atts ) {
    $atts         = shortcode_atts( array(
        'id' => 0,
    ), $atts );
    $slider_json  = get_post( $atts['id'], ARRAY_A );
    $slider       = $slider_json['post_content'];
    $slider       = json_decode( $slider, true );
    $count_slides = count( $slider['img_slide'] );
    ob_start();
    ?>
    <!-- slider -->
    <div class="navbar-001 js-show-container">
        <div class="custom-slider">
            <div id="myCarousel" class="carousel slide" data-ride="false">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php for ( $i = 0; $i < $count_slides; $i ++ ) { ?>
                    <li data-target="#myCarousel"
                        data-slide-to="<?php echo $i; ?>" <?php if ( $i == 0 ) {
                        echo 'class="active"';
                    } ?>>
                        <div class="full-indicator hidden-xs">
                            <img src=<?php echo $slider['img_preview'][ $i ]; ?>>
                            <div class="indicator-text hidden-sm">
                                <span><?php echo $slider['text3'][ $i ]; ?></span>
                                <span><?php echo $slider['text1'][ $i ]; ?></span>
                            </div>
                        </div>
                    </li>
                  <?php } ?>
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <?php for ( $i = 0; $i < $count_slides; $i ++ ) { ?>
                        <div class="item <?php if ( $i == 0 ) {
                            echo 'active';
                        } ?>">
                            <div class="carousel-caption">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-7 col-sm-offset-3 col-md-6 col-md-offset-3 slider-inner">
                                            <h1 class="fadeInDown animated"><?php echo $slider['text1'][ $i ]; ?></h1>
                                            <span class="animated zoomIn hidden-xs"><?php echo $slider['text2'][ $i ]; ?></span>
                                            <span class="animated zoomIn hidden-sm hidden-md hidden-lg"><?php echo $slider['text4'][ $i ]; ?></span>
                                            <div class="button-group animated bounceInUp">
                                                <a class="btn btn-color text-uppercase" href="#">подробнее</a>
                                                <a class="btn btn-outline text-uppercase hidden-xs" href="#">все акции</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img class="img-responsive hidden-xs" src=<?php echo $slider['img_slide'][ $i ]; ?>>
                            <img src=<?php echo $slider['img_mobile'][ $i ]; ?> class="img-responsive hidden-sm hidden-md hidden-lg">
                        </div>
                    <?php } ?>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control hidden-xs" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control hidden-xs" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <?php
    $out = ob_get_contents();
    ob_end_clean();

    return $out;
}
add_shortcode( 'slider', 'insert_slider' );