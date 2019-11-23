<?php
function view_builds_inviter($id){
    $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    array_push (
        $meta_query_args,
        array(
            'key'     => 'inviter_user_login',
            'value'   =>  $id,
            'compare' => 'LIKE'
        )
    );
    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => 'student',
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => $meta_query_args,
        'date_query'   => array(),
        'include'      => array(),
        'exclude'      => array(),
        'offset'       => '',
        'search_columns' => array( 'user_login','faculty_lineage','languages','programming_languages','region','skill_dev','skill',),
        'count_total'  => true,
        'fields'       => 'all',
        'who'          => ''
    );
    $students=new WP_User_Query( $args );//get_users($args);
    _log($students);
}
add_shortcode("view_builds_inviter","view_builds_inviter")
?>