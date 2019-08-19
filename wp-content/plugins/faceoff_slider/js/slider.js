var counter = 1;
if (jQuery('.img_url').last().attr('id')) {
    counter = jQuery('.img_url').last().attr('id').split('_');
}

if (Number(counter[3])) {
    counter = Number(counter[3]) + 1;
}

function add_slide() {
    jQuery('.add_slide').before(
        '<div class="slide_place">' +
        'Изображение слайдера: <input id="default_featured_image_slide_' + counter + '" class="img_url" type="text" size="60" name="slider[img_slide][]" required/> ' +
        '<button type="button" class="button insert-media add_media" data-editor="default_featured_image_slide_' + counter + '">' +
        '<span class="wp-media-buttons-icon"></span>  Загрузить</button> ' +
        '<br>Изображение моб. слайдера: <input id="default_featured_image_mobile_' + counter + '" class="img_url" type="text" size="60" name="slider[img_mobile][]" required/> ' +
        '<button type="button" class="button insert-media add_media" data-editor="default_featured_image_mobile_' + counter + '">' +
        '<span class="wp-media-buttons-icon"></span>  Загрузить</button> ' +
        '<br>Изображение превью: <input id="default_featured_image_preview_' + counter + '" class="img_url" type="text" size="60" name="slider[img_preview][]" required/> ' +
        '<button type="button" class="button insert-media add_media" data-editor="default_featured_image_preview_' + counter + '">' +
        '<span class="wp-media-buttons-icon"></span>  Загрузить</button> ' +
        '<br>Текст 1: <input class="img_caption" type="text" size="60" name="slider[text1][]" value="" required/>' +
        '<br>Текст 2: <input class="img_caption" type="text" size="60" name="slider[text2][]" value="" required/>' +
        '<br>Текст 3: <input class="img_caption" type="text" size="60" name="slider[text3][]" value="" required/>' +
        '<br>Текст 4: <input class="img_caption" type="text" size="60" name="slider[text4][]" value="" required/>' +
        '<br><button class="button remove_slide" >Удалить</button>' +
        '<hr><hr></div>');
    counter++;
    jQuery('.remove_slide').last().attr('onclick', 'remove_slide(this); return false;');
}

function remove_slide(obj) {
    jQuery(obj).parent().remove();
    return false;
}