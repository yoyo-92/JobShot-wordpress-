<?php
function manage_column_posts_columns($columns) {
    if(current_user_can( 'administrator' )){
        $columns['first_category'] = '大項目';
        $columns['second_category'] = '中項目';
        $columns['third_category'] = '小項目';
        unset($columns['date']);
        unset($columns['seotitle']);
        unset($columns['seodesc']);
    }
    return $columns;
}
function add_column_category($column_name, $post_id) {
    if(current_user_can( 'administrator' )){
        if ( $column_name == 'first_category' ) {
            $scholarship = CFS()->get('first_category',$post_id);
            if ( isset($stitle) && $stitle ) {
                echo attribute_escape($stitle);
            } else {
                echo __('None');
            }
        }
        if ( $column_name == 'second_category' ) {
            $scholarship = CFS()->get('second_category',$post_id);
            if ( isset($stitle) && $stitle ) {
                echo attribute_escape($stitle);
            } else {
                echo __('None');
            }
        }
        if ( $column_name == 'third_category' ) {
            $scholarship = CFS()->get('third_category',$post_id);
            if ( isset($stitle) && $stitle ) {
                echo attribute_escape($stitle);
            } else {
                echo __('None');
            }
        }
    }
}
add_filter( 'manage_column_posts_columns', 'manage_column_posts_columns' );
add_action( 'manage_column_posts_custom_column', 'add_column_category', 10, 2 );

?>