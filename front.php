<?php
function frontpage_view_pickups_func(){
    $html='';
    $pickups=get_field('ピックアップ１');
    foreach($pickups as $pickup){
        $html.=view_card_func($pickup->ID);
    }
    return $html;
  }
  add_shortcode('view_pickups','frontpage_view_pickups_func');

  function builds_loginform_func(){

   return do_shortcode(' [wpmem_form login redirect_to="http://mysite.com/my-page/"]');
  }
  add_shortcode('builds_loginform','builds_loginform_func');

  function view_top_intern_card_func(){
    $item_type = "internship";
    $args = array(
        'post_type' => array($item_type),
        'post_status' => array( 'publish' ),
        'meta_key' => 'day_views_count',
        'orderby' => 'meta_value_num',
        'order'=>'DESC',
        'showposts'=>10
    );
    $posts = get_posts($args);

    $card_html = '<div class="cards-container">';
    // $card_html .= view_fullwidth_intern_card_func(7382);
    // $card_html .= view_fullwidth_intern_card_func(6635);

    foreach($posts as $post){
        $post_id = $post->ID;
        // if($post_id != 7382 and $post_id != 6635){
          $card_html .= view_fullwidth_intern_card_func($post_id);
        // }
    }
    $card_html .= '</div>';
    $home_url =esc_url( home_url( ));
    $card_html .= '<p style="text-align: right; text-decoration: underline;"><a href="'.$home_url.'/internship">長期インターン案件をもっと見る</a></p>';
    return do_shortcode($card_html);
  }
add_shortcode('view-top-intern-card','view_top_intern_card_func');
?>