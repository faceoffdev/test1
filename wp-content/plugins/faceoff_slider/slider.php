<?php
/*
Plugin Name: Тестовое задание
Version: 1.0
Author: Вадим Сушинский
*/

/**
 * Enqueue scripts and styles.
 */
function slider_scripts() {
        wp_enqueue_style('slider-bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array( 'twentynineteen-style' ), '3.3.7');

        wp_enqueue_style('slider-animate', plugin_dir_url(__FILE__) . 'css/animate.css', array( 'twentynineteen-style' ) );

        wp_enqueue_style('slider-style', plugin_dir_url(__FILE__) . 'css/style.css', array( 'twentynineteen-style' ) );

        wp_enqueue_script('slider-jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), '3.3.1', true);

        wp_enqueue_script('slider-bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), '3.3.7', true);
}
add_action( 'wp_enqueue_scripts', 'slider_scripts' );

add_filter( 'style_loader_tag', 'new_style_loader_tag', 10, 2 );
/**
 * Add integrity/crossorigin for CDN styles.
 */
function new_style_loader_tag( $html, $handle ) {
    $scripts_to_load = array(
        array(
            ( 'name' )      => 'bootstrap-style',
            ( 'integrity' ) => 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u',
        )
    );

    $key = array_search( $handle, array_column( $scripts_to_load, 'name' ) );

    if ( $key !== false ) {
        $html = str_replace( '/>', ' integrity=\'' . $scripts_to_load[$key]['integrity'] . '\' crossorigin=\'anonymous\' />', $html );
    }

    return $html;
}


/**
 * Регистрация слайдера
 */
function register_slider_post_type() {
    $labels = array(
        'name'               => 'Слайдер',
        'singular_name'      => 'Слайдер',
        'add_new'            => 'Добавить слайдер',
        'add_new_item'       => 'Добавить слайдер',
        'edit_item'          => 'Редактировать слайдер',
        'new_item'           => 'Новый слайдер',
        'all_items'          => 'Все слайдеры',
        'view_item'          => 'Просмотреть слайдер',
        'search_items'       => 'Поиск слайдера',
        'not_found'          => 'Не найдено слайдеров',
        'not_found_in_trash' => 'Не найдено в корзине',
        'menu_name'          => 'Слайдеры',
    );
    $args   = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-images-alt',
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'thumbnail' )
    );

    register_post_type( 'slider', $args );
}
add_action( 'init', 'register_slider_post_type' );

/**
 * Добавление мета боксов
 */
function slider_boxes() {
    add_meta_box( 'slider_extra_fields', 'Слайды: ', 'slider_fields_box_func', 'slider', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'slider_boxes', 1 );

/**
* @param $post
*/
function slider_fields_box_func( $post ) {
    $slider = json_decode( $post->post_content, true );
    echo '<div id="slides_container">';
    echo 'Шорткод слайдера: [slider id="' . $post->ID . '"]<br><br>';
    $counter = 1;
    for ( $i = 0; $i < count( $slider['img_slide'] ); $i ++ ) {
        if ( strlen( $slider['img_slide'][ $i ] ) > 0 ) {

            echo '<div class="slide_place">
                    Изображение слайдера: <input id="default_featured_image_slide_' . $counter . '" class="img_url" type="text"
                                        size="60" name="slider[img_slide][]"
                                        value="' . esc_attr( $slider['img_slide'][ $i ] ) . '" required/>
                    <button type="button" class="button insert-media add_media"
                            data-editor="default_featured_image_slide_' . $counter . '"><span
                            class="wp-media-buttons-icon"></span> Загрузить
                    </button>
                    <br>Изображение моб. слайдера: <input id="default_featured_image_mobile_' . $counter . '" class="img_url" type="text"
                                        size="60" name="slider[img_mobile][]"
                                        value="' . esc_attr( $slider['img_mobile'][ $i ] ) . '" required/>
                    <button type="button" class="button insert-media add_media"
                            data-editor="default_featured_image_mobile_' . $counter . '"><span
                            class="wp-media-buttons-icon"></span> Загрузить
                    </button>
                    <br>Изображение превью: <input id="default_featured_image_preview_' . $counter . '" class="img_url" type="text"
                                        size="60" name="slider[img_preview][]"
                                        value="' . esc_attr( $slider['img_preview'][ $i ] ) . '" required/>
                    <button type="button" class="button insert-media add_media"
                            data-editor="default_featured_image_preview_' . $counter . '"><span
                            class="wp-media-buttons-icon"></span> Загрузить
                    </button>
                    <br>Текст 1: <input class="img_caption" type="text" size="60" name="slider[text1][]"
                                        value="' . esc_attr( $slider['text1'][ $i ] ) . '" required/>
                    <br>Текст 2: <input class="img_caption" type="text" size="60" name="slider[text2][]"
                                        value="' . esc_attr( $slider['text2'][ $i ] ) . '" required/>
                    <br>Текст 3: <input class="img_caption" type="text" size="60" name="slider[text3][]"
                                        value="' . esc_attr( $slider['text3'][ $i ] ) . '" required/>
                    <br>Текст 4: <input class="img_caption" type="text" size="60" name="slider[text4][]"
                                        value="' . esc_attr( $slider['text4'][ $i ] ) . '" required/>
                    <br> <button class="button remove_slide" onclick="remove_slide(this); return false;">Удалить</button>
                    <hr><hr>
                </div>';

            $counter ++;
        }
    }
    echo '<script src="' . plugin_dir_url( __FILE__ ) . 'js/slider.js"></script>';
    echo '<a class = "add_slide" onclick = "add_slide();return false;" href = "#" >Добавить слайд</a >
    <input type = "hidden" name = "extra_fields_nonce" value = "' . wp_create_nonce( __FILE__ ) . '" /></div >';
}

/**
 * Функция сохранения слайдов
 *
 * @param $post_id
 *
 * @return bool
 */
function save_slides( $post_id ) {
    global $wpdb;

    if ( ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ ) ) {
        return false;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        // выходим, если это автосохранение
        return false;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        // выходим, если юзер не имеет право редактировать запись
        return false;
    }

    if ( ! wp_is_post_revision( $post_id ) ) {
        // удаляем, чтобы он не создавал бесконечный цикл
        remove_action( 'save_post', 'save_slides' );
    }

    $my_post       = array();
    $my_post['ID'] = $post_id;
    $slides_count  = count( $_POST['slider']['text1'] );
    for ( $i = 0; $i < $slides_count; $i ++ ) {
        $doc = new DOMDocument();

        @$doc->loadHTML( $_POST['slider']['img_slide'][ $i ] );
        $tags = $doc->getElementsByTagName( 'img' );
        foreach ( $tags as $tag ) {
            $_POST['slider']['img_slide'][ $i ] = $tag->getAttribute( 'src' );
        }

        @$doc->loadHTML( $_POST['slider']['img_mobile'][ $i ] );
        $tags = $doc->getElementsByTagName( 'img' );
        foreach ( $tags as $tag ) {
            $_POST['slider']['img_mobile'][ $i ] = $tag->getAttribute( 'src' );
        }

        @$doc->loadHTML( $_POST['slider']['img_preview'][ $i ] );
        $tags = $doc->getElementsByTagName( 'img' );
        foreach ( $tags as $tag ) {
            $_POST['slider']['img_preview'][ $i ] = $tag->getAttribute( 'src' );
        }

    }

    $my_post['post_content'] = wp_json_encode( $_POST['slider'], JSON_UNESCAPED_UNICODE );
    wp_update_post( $my_post );
    add_action( 'save_post', 'save_slides' );
}
add_action( 'save_post', 'save_slides' );

/**
 * Добавление шорткодов
 */
require 'inc/shortcodes.php';