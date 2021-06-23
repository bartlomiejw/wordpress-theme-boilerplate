<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

add_action('acf/init', function () {
    acf_add_options_sub_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme',
        'parent_slug' => 'options-general.php',
    ));

    acf_add_local_field_group(
        (new FieldsBuilder('options'))
            // chain field methods here
            ->setLocation('options_page', '==', 'acf-options-theme')
            ->getRootContext()
            ->build()
    );
});
