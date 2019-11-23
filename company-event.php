<?php

function view_fullwidth_event_card_func($pid){
    $image_id = get_post_thumbnail_id($pid);
 $image_url = wp_get_attachment_image_src($image_id, thumbnail);
     $location = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51849.583412130276!2d139.72134401979653!3d35.68687552925201!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188c0c0b13f54d%3A0xb630953beee48188!2z5p2x5Lqs6YO95Y2D5Luj55Sw5Yy6!5e0!3m2!1sja!2sjp!4v1530895318295" width="250" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>';
   $image_url = 'https://www.pakutaso.com/shared/img/thumb/AME20181123B004_TP_V.jpg';
   $company_name = get_posts_meta($pid,"社名",true);
    // $event_date = get_posts_meta($pid,"社名",true);
 
 $card_html = '<div class="card full-card">
   <div class="full-card-main">
       <div class="full-card-img">
           <img src="'.$image_url.'" alt="">
       </div>
       <div class="full-card-text">
           <div class="full-card-text-title">こんなイベントをやります!</div>
           <div class="full-card-text-caption">
               <div class="full-card-text-company">'.$company_name.'</div>
               <div class="card-category-container">
                   <div class="card-category">デザイナー</div>
                   <div class="card-category">エンジニア</div>
                   <div class="card-category">デザイナー</div>
                   <div class="card-category">エンジニア</div>
                   <div class="card-category">デザイナー</div>
                   <div class="card-category">エンジニア</div>
                   <div class="card-category">デザイナー</div>
                   <div class="card-category">エンジニア</div>
               </div>
           </div>
           <table class="full-card-table">
           <tbody> <tr>
                       <td>hoge</td>
                   </tr>
                   <tr>
                        <th>日時</th>
                        <td>12月15日</td>
                    </tr>
                   <tr>
                        <th>場所</th>
                        <td>'.$location.'</td>
                    </tr>
                   <tr>
                        <th>募集対象</th>
                        <td>'.get_field('募集対象_短文',$pid).'</td>
                   </tr>
                   <tr>
                        <th>定員</th>
                        <td>'.get_field('定員',$pid).'</td>
                    </tr>
               </tbody>
           </table>
       </div>
   </div>
   <div class="full-card-buttons">
       <button class="button favorite innactive">☆お気に入り</button>
       <button class="button detail">詳細を見る</button>
   </div>
</div>';
 return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-event-card','view_fullwidth_event_card_func');



function view_event_card_func($pid){
  
    //global $post;
    //$post_id = $post->ID;
    //$pidが取得できていないため、$image_urlがうまく表示できていない
  
   //   setup_postdata(get_post( $pid));
      $image_id = get_post_thumbnail_id($pid);
    //$image_url = wp_get_attachment_image_src($image_id, thumbnail);
    $image_url = array("https://www.pakutaso.com/shared/img/thumb/YAM85_sukitooruokinawanoumi_TP_V.jpg");
    //$location = view_terms_func($pid, array('area'),'<object>','','</object>');
    $location = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51849.583412130276!2d139.72134401979653!3d35.68687552925201!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188c0c0b13f54d%3A0xb630953beee48188!2z5p2x5Lqs6YO95Y2D5Luj55Sw5Yy6!5e0!3m2!1sja!2sjp!4v1530895318295" width="250" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>';
    //$url = the_permalink();
      
      $sankas=get_field('参加企業',$pid);  
      $sanka_html='<div>';
    foreach((array)$sankas as $sanka){
    $sanka_html.=  '<div><a href="'.get_the_permalink($sanka->ID).'"><i class="fas fa-building" style="color:#03c4b0;"></i> '.$sanka->post_title.'</a></div>';
    }
    $sanka_html.='</div>';

    $card_html= '
  <a class="card" href="'. esc_url(get_permalink($pid)).'">
    <div class="card-bigimg-wrap">
      <img class="card-bigimg-inner" src="'.$image_url[0].'" alt="" />
    </div>
  
    <div class="card-text-content">
      <h4 class="card-title event-title">'.get_post_meta($pid , 'キャッチコピー' ,true).'</h4>
      <table class="card-table">
        <tbody>
          <tr>
            <th>日時</th>
            <td>12月15日</td>
          </tr>
          <tr>
            <th>場所</th>
            <td>'.$location.'</td>
          </tr>
          <tr>
            <th>募集対象</th>
            <td>'.get_field('住所',$pid).'</td>
            <td>'.get_field('募集対象_短文',$pid).'</td>
          </tr>
          <tr>
            <th>定員</th>
            <td>'.get_field('定員',$pid).'</td>
          </tr>
          <tr>
             <tr>
        </tbody>
      </table>
    </div>
  </a>';
    
    return $card_html;
  }
  add_shortcode('view-event-card','view_event_card_func');


?>