 <?php
 function apply_management_func_test($atts){
    extract(shortcode_atts(array(
        'item_type' => '',
    ), $atts));
    $paged = get_query_var('paged')? get_query_var('paged') : 1;  //pagedに渡す変数
    $args = array(
      //'numberposts'     => 20,
      'post_status' => array('publish','private'),
      'post_type' => array($item_type),
      'posts_per_page' => 10,                                     //posts_per_pageの指定
      'paged' => $paged,                                          //pagedの指定
    );
    if($item_type=="event"){
      $args += array(
        'orderby' => 'meta_value',
        'meta_key' => '開催日',
        'order'   => 'DESC',
      );
    }
    $html = "";
    $the_query = new WP_Query($args);
    $posts_per_page = 10;
    $html .= paginate( $the_query->max_num_pages, get_query_var( 'paged' ),$the_query->found_posts, $posts_per_page);
    if($item_type == "internship"){
      $html .= '<p style="text-align: right;"><a href="https://builds-story.com/?page_id=4899">応募者一覧はこちら</a></p>';
    }
    if ($the_query->have_posts()) :
      while ($the_query->have_posts()) :
        $the_query->the_post();
        $now_id = get_the_ID();
        $html .= view_apply_card_func_test($now_id);
        //各投稿のループ
      endwhile;
    endif;
    $html .= paginate( $the_query->max_num_pages, get_query_var( 'paged' ),$the_query->found_posts, $posts_per_page);
    wp_reset_postdata();
    return $html;
}
add_shortcode('apply_management_test', 'apply_management_func_test');

function view_applylist_func_test ( $atts ) {
  extract(shortcode_atts(array(
    'type' => '',
  ),$atts));

  if($_GET){
    $post_id = $_GET['pid'];
    $mode = $_GET['mode'];
  }

  if(get_post_type($post_id)=='internship'){
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $formname = 'インターン応募';
  }else if(get_post_type($post_id)=='event'){
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $formname = 'イベント応募';
  }else if(get_post_type($post_id)=='summer_internship'){
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $formname = 'サマーインターン';
  }else if(get_post_type($post_id)=='autumn_internship'){
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $entry_url = CFS()->get('リダイレクト先URL',$post_id);
    if($entry_url == ""){
      $formname = 'サマーインターン';
    }else{
      $formname = '秋インターン';
    }
  }else{
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $formname = '新卒応募';
  }
  $participant_num = do_shortcode(' [cfdb-count form="/'.$formname.'.*/" filter="job-id='.$post_id.'"]');






  /**
   * CSSは以下の<style>タグの中に記述
   */
  $style_html = '
  <style type="text/css">
  </style>';







  /**
   * HTMLは以下の$phtmlの中を変更
   */
    if(get_post_type($post_id)=='event'){
        $phtml.='<p>'."全".$participant_num."件".'<p>';
        $phtml.=
        do_shortcode('[cfdb-html form="/'.$formname.'.*/" orderby="Submitted desc" filter="job-id='.$post_id.'"]
        <font size="2">
            <table class="tbl02" style="font-size: small;">
            <thead>
                <tr>
                <th width="15%"></th>
                <th>大学</th>
                <th>性別</th>
                <th>学年</th>
                <th>卒業年度</th>
                <th>応募日時</th>
                <th>連絡先</th>
                <th>資格・その他スキル</th>
                <th>プログラミング・留学経験</th>
                <th>所属団体</th>
                <th>興味のある業界</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th>
                    <a href="/user?um_user=${your-id}" style="color:white"><p><font size="1">[get_user_ruby field=login value="${your-id}"]</font><br>${your-name}</p><div>[get_avatar_sc user_login="${your-id}"]</div></a>
                </th>
                <td label="大学">
                    <p>[my_get_userdata_by field=login value="${your-id}" data=univ]<br>[my_get_userdata_by field=login value="${your-id}" data=faculty]</p>
                </td>
                [get_user_meta_info field=login value="${your-id}"]
                <td label="応募日時">
                    <p>[submitted2str sbm="${Submitted}"]</p>
                </td>
                <td label="連絡先">
                    <p>[get_user_mobile_number field=login value="${your-id}"]<br>[get_user_email field=login value="${your-id}"]</p>
                </td>
                <td label="資格・その他スキル">
                    <p>[get_user_skill field=login value="${your-id}"]</p>
                </td>
                <td label="プログラミング・留学経験">
                    <p>プログラミング：[get_user_experience_programming field=login value="${your-id}"]<br>留学：[get_user_studied_abroad field=login value="${your-id}"]</p>
                </td>
                <td label="所属団体">
                    <p>[get_user_univ_community field=login value="${your-id}"]<br>[get_user_community_univ field=login value="${your-id}"]</p>
                </td>
                <td label="興味のある業界">
                    <p>[get_user_bussiness_type field=login value="${your-id}"]</p>
                </td>
                </tr>
            </tbody>
            </table>
        </font>
        [/cfdb-html]');
        $phtml.='<p>'."全".$participant_num."件".'<p>';
    }
  return $style_html.$phtml;
}
add_shortcode('view_applylist_test','view_applylist_func_test');



function view_apply_card_func_test($post_id){
  if(!in_the_loop()){
    global $post;
    $post_id=$post->ID;
  }
  switch(get_post_type($post_id)){
    case 'job':
      return view_apply_fullwidth_job_card_func($post_id);
    case 'internship':
      return view_apply_fullwidth_intern_card_func($post_id);
    case 'event':
      return view_apply_fullwidth_event_card_func_test($post_id);
    case 'company':
      return view_apply_company_card_func($post_id);
    case 'summer_internship':
      return view_apply_fullwidth_summer_intern_card_func($post_id);
    case 'autumn_internship':
      return view_apply_fullwidth_autumn_intern_card_func($post_id);
    break;
  }
  return;
}
add_shortcode('view-card_test','view_card_func_test');

function view_apply_fullwidth_event_card_func_test($post_id){
  $post_title = get_the_title($post_id);
  $image = get_field("イメージ画像",$post_id);
  $image_url = $image["url"];
  $event_date = get_field('開催日時1',$post_id)['日付'].' '.get_field('開催日時1',$post_id)['開始時刻'].'〜'.get_field('開催日時1',$post_id)['終了時刻'];
  $event_day=get_field('開催日',$post_id);
  $today=date("Y/m/d");
  $area = get_the_terms($post_id,"area")[0]->name;
  $event_target = get_field('募集対象_短文',$post_id);
  $event_capacity = get_field('定員',$post_id);
  $sankas=get_field('参加企業',$post_id);
  $sanka_html='<div>';
  foreach((array)$sankas as $sanka){
    $sanka_html.=  '<div><a href="'.get_the_permalink($sanka->ID).'">'.$sanka->post_title.'</a></div>';
  }
  $sanka_html.='</div>';
  $detai_url = 'https://builds-story.com/manage_application_test?pid='.$post_id;
  $favorite_url = 'https://builds-story.com/manage-favorite_test?pid='.$post_id;
  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt>
      </div>
      <div class="full-card-text">';
  if($event_day<$today){
  $card_html.='
        <div class="full-card-text-title">
          <font color = "gray">'.$post_title.'【終了】</font>
        </div>';
  }else{
  $card_html.='
        <div class="full-card-text-title">'.$post_title.'</div>';
  }
  $card_html .='
        <table class="full-card-table">
          <tbody>';
  if(!empty($sankas)){
  $card_html.='
            <tr>
              <th>参加企業</th>
              <td>'.$sankas.'</td>
            </tr>';
  }
  $card_html .='
            <tr>
              <th>開催エリア</th>
              <td>'.$area.'</td>
            </tr>
            <tr>
              <th>開催日時</th>
              <td>'.$event_date.'</td>
            </tr>
            <tr>
              <th>募集対象</th>
              <td>'.$event_target.'</td>
            </tr>
            <tr>
              <th>定員</th>
              <td>'.$event_capacity.'</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="full-card-buttons">
      <a href = "'.esc_url($favorite_url).'"><button class="button favorite innactive">☆お気に入り</button></a>
      <a href = "'.esc_url($detai_url).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';
  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-event-card_test','view_fullwidth_event_card_func_test');


 ?>