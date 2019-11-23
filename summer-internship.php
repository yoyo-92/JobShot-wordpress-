<?php


function view_summer_intern_card_func(){
    $item_type = "summer_internship";
    $args = array(
        'post_type' => array($item_type),
        'post_status' => array( 'publish' ),
    );
    $posts = get_posts($args);

    $card_html = '<div class="cards-container">';

    foreach($posts as $post){
        $post_id = $post->ID;
        $card_html .= view_fullwidth_card_func($post_id);
    }
    $card_html .= '</div>';
    return do_shortcode($card_html);
  }
add_shortcode('view-summer-intern-card','view_summer_intern_card_func');

function template_summer_internship2_func($content){
    global $post;
    $post_id=$post->ID;

    // タクソノミー
    $area = get_the_terms($post_id,"area")[0]->name;
    $occupation = get_the_terms($post_id,"occupation")[0]->name;

    // 企業情報
    $company = get_userdata($post->post_author);
    $company_name = $company->data->display_name;
    $company_bussiness = nl2br(get_field("事業内容",$post_id));
    if(empty($company_bussiness)){
      $company_id = get_company_id($company);
      $company_bussiness = nl2br(get_field("事業内容",$company_id));
    }
    $company_url='https://builds-story.com/?company='.$company_name;

    $post_title = get_the_title($post_id);
    $image = get_field("トップイメージ画像",$post_id);
    if(is_array($image)){
      $image_url = $image["url"];
    }else{
      $image_url = wp_get_attachment_url($image);
    }


    $intern_contents = nl2br(get_field("インターン内容",$post_id));
    $event_date = nl2br(get_field("開催日",$post_id));
    $deadline = nl2br(get_field("締め切り日",$post_id));
    $recommend = nl2br(get_field("こんな方におすすめ",$post_id));
    $capacity = nl2br(get_field('定員',$post_id));
    $allowance = nl2br(get_field('報酬',$post_id));
    $address = nl2br(get_field("開催場所",$post_id));
    $requirements = nl2br(get_field('参加資格',$post_id));
    $belongings = nl2br(get_field('持ち物・服装',$post_id));
    $selection_flow = nl2br(get_field('プレエントリー後の流れ',$post_id));
    // $skill_requirements = get_field('応募資格',$post_id);
    // $prospective_employer = get_field('インターン卒業生の内定先',$post_id);
    // $intern_student_voice = get_field('働いているインターン生の声',$post_id);
    // $builds_voice = get_field('Builds担当者の声',$post_id);

    $features = get_field('特徴',$post_id);
    if($features){
        $features_html = '';
        foreach($features as $feature){
        $features_html .=  '<div class="card-category" style="background-color:#f9b539;">'.$feature.'</div>';
        }
    }

    $entry_html = '
        <a href="[get_form_address formtype=apply form_id=4767 post_id='.$post->ID.' title='.$post_title.']">
            <button class="button button-apply">プレエントリーする</button>
        </a>';


    $builds_voice_html = '';
    if($builds_voice){
        $builds_voice_html = `
        <section>
            <h2 class="maintitle">Builds担当者からの声</h2>
            <p>'.$builds_voice.'</p>
        </section>
        `;
    }

    $html = '<div class="container">
    <!-- card -->
    <div class="card full-card">
        <div class="full-card-main">
        <div class="full-card-img">
            <img src="'.$image_url.'" alt="">
        </div>
        <div class="full-card-text">
            <div class="full-card-text-title"><a href="'.esc_url(get_permalink($post_id)).'">'.$post_title.'</a></div>
            <div class="full-card-text-caption">
            <div class="full-card-text-company"><a href="'.esc_url($company_url).'"><b>'.$company_name.'</b></a></div>
            <div class="card-category-container">
                <div class="card-category">'.$area.'</div>
                <div class="card-category">'.$occupation.'</div>
            </div>
            </div>
            <table class="full-card-table">
            <tbody>
                <tr>
                <th>開催日</th>
                <td>'.$event_date.'</td>
                </tr>
                <tr>
                <th>締め切り日</th>
                <td>'.$deadline.'</td>
                </tr>
            </tbody>
            </table>'.$features_html
        .'</div>
        </div>
        <div class="full-card-buttons">
            <button class="button favorite innactive">'.get_favorites_button($post_id).'</button>
            <a href="[get_form_address formtype=apply form_id=4767 post_id='.$post->ID.' title='.$post_title.']"><button class="button detail">プレエントリー</button></a>
        </div>
    </div>


    <!-- main -->

    <section>
      <h2 class="maintitle">募集要項</h2>
      <table class="table__base">
        <tbody>
          <tr>
            <th>インターン概要</th>
            <td><p>'.$intern_contents.'</p></td>
          </tr>
          <tr>
            <th>開催日程</th>
            <td><p>'.$event_date.'</p></td>
          </tr>
          <tr>
            <th>プレエントリー締め切り日</th>
            <td><p>'.$deadline.'</p></td>
          </tr>
          ';

        if(!empty($recommend)){
          $html.='<tr>
          <th>こんな方におすすめ</th>
          <td><p>'.$recommend.'</p></td>
        </tr>';
        }

        if(!empty($capacity)){
          $html.='<tr>
          <th>定員</th>
          <td><p>'.$capacity.'</p></td>
        </tr>';
        }

        if(!empty($allowance)){
            $html.='<tr>
            <th>報酬</th>
            <td><p>'.$allowance.'</p></td>
          </tr>';
        }

        if(!empty($address)){
          $html.='<tr>
          <th>開催場所</th>
          <td><p>'.$address.'</p></td>
        </tr>';
        }

        if(!empty($requirements)){
          $html.='<tr>
          <th>参加条件</th>
          <td>'.$requirements.'</td>
        </tr>';
        }

        if(!empty($belongings)){
          $html.='<tr>
          <th>持ち物・服装</th>
          <td>'.$belongings.'</td>
        </tr>';
        }

        $html.='</tbody>
      </table>
    </section>';

    if(!empty($selection_flow)){
        $html.='
        <section>
            <h2 class="maintitle">プレエントリー後の流れ</h2>
            <p>'.$selection_flow.'</p>
        </section>';
    }

    $html .= '
    <!-- entry -->
    <div class="fixed-buttom">'.$entry_html.'</div>
    </div>';
    return do_shortcode($html);
}




?>