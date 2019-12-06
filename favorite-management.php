<?php

function view_favorite_list_func ( $atts ) {
    extract(shortcode_atts(array(
      'type' => '',
    ),$atts));

    if($_GET){
      $post_id = $_GET['pid'];
      $mode = $_GET['mode'];
    }

    if(get_post_type($post_id)=='internship'){
        $html = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
        $formname = 'インターン応募';
        $attendformname = 'インターン出席登録';
    }else{
        $html = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
        $formname = 'イベント応募';
        $attendformname = 'イベント出席登録';
    }
    $favorite_users = get_users_who_favorited_post($post_id);

    $f=false;
    $f=is_this_my_content($post_id);

    $html .= '
    <font size="2">
        <table class="tbl02">
            <thead>
                <tr>
                    <th></th>
                    <th>大学</th>
                    <th>性別</th>
                    <th>学年</th>
                    <th>卒業年度</th>
                    <th>スカウト</th>
                </tr>
            </thead>
            <tbody>';
    foreach($favorite_users as $favorite_user){
        $user_id = $favorite_user->data->ID;
        $user_name = $favorite_user->data->display_name;
        $user_email = $favorite_user->data->user_email;
        $user_login_name = $favorite_user->data->user_login;
        $user_info = '
        <a href="/user?um_user='.$user_login_name.'" style="color:white">
            <p>'.$user_name.'<br><font size="1">'.$user_login_name.'</font></p>
            <div>'.get_avatar($user_id).'</div>
        </a>';
        $university = get_univ_name($favorite_user).'<br>'.get_faculty_name($favorite_user);
        $gender = get_user_meta($user_id,'gender',false)[0][0];
        $school_year = get_user_meta($user_id,'school_year',false)[0];
        $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
        $sta=get_remain_mail_num_for_stu_func($favorite_user);
        $scout = '<a href="'.scoutlink($favorite_user).'">'.$sta['status'].'<br>スカウトする（残り'.$sta['remain'].'件）</a>';
        if (current_user_can('administrator')){
            $scout .= '<br><p>'.$user_email.'</p>';
        }

        $html .= '<tr>
                    <th>'.$user_info.'</th>
                    <td label="大学">'.$university.'</td>
                    <td label="性別">'.$gender.'</td>
                    <td label="学年">'.$school_year.'</td>
                    <td label="卒業年度">'.$graduate_year.'</td>
                    <td label="スカウト">'.$scout.'</td>
                </tr>';
    }
    $html .= '
            </tbody>
        </table>
    </font>
    ';
    return $html;
}
add_shortcode('view_favorite_list','view_favorite_list_func');

function view_favorite_list_from_post_func ( $post_id ) {

    if($_GET){
    //   $post_id = $_GET['pid'];
      $mode = $_GET['mode'];
    }

    if(get_post_type($post_id)=='internship'){
        $html = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
        $formname = 'インターン応募';
        $attendformname = 'インターン出席登録';
    }else{
        $html = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
        $formname = 'イベント応募';
        $attendformname = 'イベント出席登録';
    }
    $favorite_users = get_users_who_favorited_post($post_id);

    $f=false;
    $f=is_this_my_content($post_id);

    $html .= '
    <font size="2">
        <table class="tbl02">
            <thead>
                <tr>
                    <th></th>
                    <th>大学</th>
                    <th>性別</th>
                    <th>学年</th>
                    <th>卒業年度</th>
                    <th>スカウト</th>
                </tr>
            </thead>
            <tbody>';
    foreach($favorite_users as $favorite_user){
        $user_id = $favorite_user->data->ID;
        $user_name = $favorite_user->data->display_name;
        $user_login_name = $favorite_user->data->user_login;
        $user_info = '
        <a href="/user?um_user='.$user_login_name.'" style="color:white">
            <p>'.$user_name.'<br><font size="1">'.$user_login_name.'</font></p>
            <div>'.get_avatar($user_id).'</div>
        </a>';
        $university = get_univ_name($favorite_user).'<br>'.get_faculty_name($favorite_user);
        $gender = get_user_meta($user_id,'gender',false)[0][0];
        $school_year = get_user_meta($user_id,'school_year',false)[0];
        $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
        $sta=get_remain_mail_num_for_stu_func($favorite_user);
        $scout = '<a href="'.scoutlink($favorite_user).'">'.$sta['status'].'<br>スカウトする（残り'.$sta['remain'].'件）</a>';

        $html .= '<tr>
                    <th>'.$user_info.'</th>
                    <td label="大学">'.$university.'</td>
                    <td label="性別">'.$gender.'</td>
                    <td label="学年">'.$school_year.'</td>
                    <td label="卒業年度">'.$graduate_year.'</td>
                    <td label="スカウト">'.$scout.'</td>
                </tr>';
    }
    $html .= '
            </tbody>
        </table>
    </font>
    ';
    return $html;
}
add_shortcode('view_favorite_list_from_post','view_favorite_list_from_post_func');

?>