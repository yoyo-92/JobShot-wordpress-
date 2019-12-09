<?php

function template_internship2_func($content){
  global $post;
  $post_id=$post->ID;
  $company = get_userdata($post->post_author);
  $company_id = get_company_id($company);
  $company_url = get_permalink($company_id);
  $company_name = $company->data->display_name;
  $company_image = get_field("企業ロゴ",$company_id);
  if(is_array($company_image)){
    $company_image_url = $company_image["url"];
  }else{
    $company_image_url = wp_get_attachment_url($company_image);
  }
  if(empty($company_bussiness)){
    $company_bussiness = nl2br(get_field("事業内容",$company_id));
  }
  $company_logo_square = CFS()->get('company_logo_square',$company_id);
  $scholarship = CFS()->get('scholarship',$company_id);
  foreach($scholarship as $scholarship_key => $scholarship_value){
    if($scholarship_key == 'プランD'){
      $scholarship_value = '10,000円';
    }elseif($scholarship_key == 'プランC'){
      $scholarship_value = '7,500円';
    }elseif($scholarship_key == 'プランB'){
      $scholarship_value = '5,000円';
    }else{
      $scholarship_value = '対象外';
    }
  }

  $area = get_the_terms($post_id,"area")[0]->name;
  $occupation = get_the_terms($post_id,"occupation")[0]->name;
  $business_type = get_the_terms($company_id,"business_type")[0]->name;

  $post_title = get_field("募集タイトル",$post_id);
  $salary = nl2br(get_field("給与",$post_id));
  $requirements = nl2br(get_field("勤務条件",$post_id));
  $intern_contents = nl2br(get_field("業務内容",$post_id));
  $skills = nl2br(get_field("身につくスキル",$post_id));
  $address = get_field("勤務地",$post_id);
  $intern_day = nl2br(get_field('1日の流れ',$post_id));
  $worktime = nl2br(get_field('勤務可能時間',$post_id));
  $require_person = nl2br(get_field('求める人物像',$post_id));
  $skill_requirements = nl2br(get_field('応募資格',$post_id));
  $prospective_employer = nl2br(get_field('インターン卒業生の内定先',$post_id));
  $intern_student_voice = nl2br(get_field('働いているインターン生の声',$post_id));
  $builds_voice = nl2br(get_field('Builds担当者の声',$post_id));
  $features = get_field('特徴',$post_id);

  $image = get_field("イメージ画像",$post_id);
  $image2 = get_field("イメージ画像2",$post_id);
  $image3 = get_field("イメージ画像3",$post_id);
  $image4 = get_field("イメージ画像4",$post_id);
  $accesses=get_field('最寄り駅',$post_id);
  $access_html='<div>';
  foreach($accesses as $access){
      $access_html.=  '<div><i class="fas fa-train"></i>';
      foreach($access['line'] as $ln){
        $access_html.=$ln.'/';
      }
      $access_html = rtrim($access_html, '/');
      $access_html.=' '.$access['name'].' 徒歩'.$access['time'].'・'.$access['distance'];
      $access_html.='</div>';
  }
  $access_html.='</div>';
  if(is_array($image)){
    $image_url = $image["url"];
  }else{
    $image_url = wp_get_attachment_url($image);
  }
  if(empty($image_url)){
    $image_url = $company_image_url;
  }
  if(!empty($image2) || !empty($image3) || !empty($image4)){
    if(!empty($image2)){
      if(is_array($image)){
        $image2_url = $image2["url"];
      }else{
        $image2_url = wp_get_attachment_url($image2);
      }
    }
    if(!empty($image3)){
      if(is_array($image)){
        $image3_url = $image3["url"];
      }else{
        $image3_url = wp_get_attachment_url($image3);
      }
    }
    if(!empty($image4)){
      if(is_array($image)){
        $image4_url = $image4["url"];
      }else{
        $image4_url = wp_get_attachment_url($image4);
      }
    }
  }

  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;
  if($company_name == $current_user_name){
    $button_html = '
    <div class="company_edit">
      <button class="button favorite innactive" style="width:40%; margin-top:15px; background-color:#f9b539; border-radius: 5px;">戻る</button>
      <button class="button favorite innactive" style="width:40%; margin-top:15px; background-color:red; border-radius: 5px;">削除する</button>
    </div>';
    $button_html = '
    <div class="company_edit" style="text-align:right;">
      <a href="https://builds-story.com/edit_internship?post_id='.$post_id.'" style="margin-right:5px;">編集する</a><a href="'.get_delete_post_link($post_id).'" style="margin-right:5px;">削除する</a><a href="https://builds-story.com/?company='.$company_name.'">企業ページに戻る</a>
    </div>';
  }else{
    $button_html = '';
  }

  if($features){
      $features_html = '';
      foreach($features as $feature){
      $features_html .=  '<div class="card-category" style="background-color:#f9b539;">'.$feature.'</div>';
      }
  }

  $requirement = '
  <p>【勤務可能時間】</p>
  <p>'.$worktime.'</p>
  <p>【勤務条件】</p>
  <p>'.$requirements.'</p>
  <p>【応募資格】</p>
  <p>'.$skill_requirements.'</p>
  <p>【求める人物像】</p>
  <p>'.$require_person.'</p>
  ';
  $intern_time_table = SCF::get('intern_time_table');
  $intern_time_table_array = array();
  foreach ($intern_time_table as $field_name => $field_value ) {
    $intern_array = array();
    $intern_array["start"] = $field_value['start'];
    $intern_array["end"] = $field_value['end'];
    $intern_array["task"] = $field_value['task'];
    array_push($intern_time_table_array,$intern_array);
  }

  $table_html = '';
  foreach($intern_time_table as $time){
      $start = $time['start'];
      $end = $time['end'];
      $task = $time['task'];
      $start_time = explode(':',$start);
      $end_time = explode(':',$end);
      $span_hour = $end_time[0] - $start_time[0];
      $span_minutes = $end_time[0] - $start_time[0];
      $span_time = $span_hour + $span_minutes / 60;
      $span_time = round($span_time, 0);
      if ($time === end($intern_time_table)) {
          // 最後
          $table_html .= '
          <tr class="timetable__row timetable__time-2">
              <td class="timetable__task">'.$task.
                  '<span class="timetable__start">'.$start.'</span>
                  <span class="timetable__end">'.$end.'</span>
              </td>
          </tr>';
      }else{
          $table_html .= '
          <tr class="timetable__row timetable__time-2">
              <td class="timetable__task">'.$task.
                  '<span class="timetable__start">'.$start.'</span>
              </td>
          </tr>';
      }
  }
  $selection_flows = SCF::get('selection_flow');
  $selection_flow_array = array();
  foreach ($selection_flows as $field_name => $field_value ) {
    $selection_array = array();
    $selection_array[] = $field_value['selection_step'];
    array_push($selection_flow_array,$selection_array);
  }
  $selection_flow_array = array_values($selection_flow_array);

  $selection_html = '<ol class="flowchart">';
  foreach($selection_flow_array as $selection_flow){
    $selection_html .= '<li class="flowchart__item">'.$selection_flow[0].'</li>';
  }
  $selection_html .= '<li class="flowchart__item flowchart__item--last">採用</li></ol>';
  $entry_link = do_shortcode('[get_form_address formtype=apply form_id=324 post_id='.$post->ID.' title='.$post_title.']');

  $entry_html = '
      <a href="'.$entry_link.'">
          <button class="button button-apply">インターンに応募する</button>
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

  $html = $button_html.'
  <div class="card-detail-container">
    <div class="only-sp">
      <div class="full-card-img intern-detail-img">
        <img src="'.$image_url.'" alt>
      </div>
      <div class="detail-text-title">'.$post_title.'</div>
      <!-- card -->
      <div class="card full-card card-company-content">
        <div class="full-card-main">
          <div class="full-card-text">
            <div class="full-card-text-caption">
              <div class="full-card-text-company"><a href="'.esc_url($company_url).'"><b>'.$company_name.'</b></a></div>
              <div class="card-category-container">
                <div class="card-category">'.$area.'</div>
                <div class="card-category">'.$occupation.'</div>
                <div class="card-category">'.$business_type.'</div>
              </div>
              <div class="card_company_square_logo">
                <img src="'.$company_logo_square.'" alt="" scale="0">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- card -->
    <div class="card full-card only-pc">
      <div class="full-card-main">
        <div class="full-card-img">
          <img src="'.$image_url.'" alt>
        </div>
        <div class="full-card-text">
          <div class="full-card-text-title">'.$post_title.'</div>
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
                    <th>勤務条件</th>
                    <td>'.$requirements.'</td>
                </tr>
                <tr>
                    <th>給与</th>
                    <td>'.$salary.'</td>
                </tr>
            </tbody>
          </table>'.
          $features_html
        .'</div>
      </div>
      <div class="full-card-buttons">
        <button class="button favorite innactive">'.get_favorites_button($post_id).'</button>
        <a href="'.$entry_link.'"><button class="button detail">応募する</button></a>
      </div>
    </div>

  <!-- main -->

  <section class="only-sp">';
  if(!empty($company_bussiness)){
    $html .= '
    <div class="intern_list">
      <h3 class="intern_list_title">会社の概要</h3>';
    if(!empty($image2_url)){
        $html .= '
      <div class="intern_list_image_box">
        <img src="'.$image2_url.'">
      </div>';
    }
    $html .= '
      <p class="intern_list_lead">'.$company_bussiness.'</p>
    </div>';
  }
  if(!empty($intern_contents)){
    $html .= '
    <div class="intern_list">
      <h3 class="intern_list_title">仕事の概要</h3>';
    if(!empty($image3_url)){
      $html .= '
      <div class="intern_list_image_box">
        <img src="'.$image3_url.'">
      </div>';
    }
    $html .= '
      <p class="intern_list_lead">'.$intern_contents.'</p>
    </div>';
  }
  if(!empty($intern_time_table[0]['start'])){
    $html .= '
    <div class="intern_list">
      <h3 class="intern_list_title">１日の流れ</h3>';
    if(!empty($image4_url)){
      $html .= '
      <div class="intern_list_image_box">
        <img src="'.$image4_url.'">
      </div>';
    }
    $html .= '
      <table class="timetable">
        <tbody>'.$table_html.'</tbody>
      </table>
    </div>';
  }
  if(!empty($selection_flows[0]['selection_step'])){
    $html .= '
    <div class="intern_list">
      <h3 class="intern_list_title">選考フロー</h3>
      '.$selection_html.'
    </div>';
  }

    $html.='
  </section>
  <section class="only-pc">
    <h2 class="maintitle">仕事の概要</h2>
    <table class="table__base">
      <tbody>';
      if(!empty($company_bussiness)){
        $html .= '
        <tr>
          <th>事業内容</th>
          <td><p>'.$company_bussiness.'</p></td>
        </tr>';
      }
      if(!empty($intern_contents)){
        $html .= '
        <tr>
          <th>業務内容</th>
          <td><p>'.$intern_contents.'</p></td>
        </tr>';
      }
      if(!empty($intern_time_table[0]['start'])){
        $html .= '
        <tr>
          <th>１日の流れ</th>
          <td>
            <table class="timetable">
              <tbody>'.$table_html.'</tbody>
            </table>
          </td>
        </tr>';
      }
      if(!empty($selection_flows[0]['selection_step'])){
        $html .= '
        <tr>
          <th>選考フロー</th>
          <td>'.$selection_html.'</td>
        </div>';
      }
      $html.='</tbody>
    </table>
  </section>
  <section>
    <h2 class="maintitle">募集要項</h2>
    <table class="intern-detail-table">';

    if(!empty($address)){
      $html.='<tr>
      <th>勤務地</th>
      <td><p>'.$address.'</p></td>
    </tr>';
    }
    if(!empty($accesses)){
      $html.='<tr>
      <th>アクセス</th>
      <td><p>'.$access_html.'</p></td>
    </tr>';
    }
    if(!empty($scholarship_value)){
      $html.='<tr>
      <th>給与</th>
      <td>'.$salary.'</td>
    </tr>';
    }
    if(!empty($requirements)){
      $html.='<tr>
      <th>勤務条件</th>
      <td>'.$requirements.'</td>
    </tr>';
    }
    if(!empty($worktime)){
      $html.='<tr>
      <th>勤務可能時間</th>
      <td>'.$worktime.'</td>
    </tr>';
    }
    if(!empty($skill_requirements)){
      $html.='<tr>
      <th>応募資格</th>
      <td>'.$skill_requirements.'</td>
    </tr>';
    }
    if(!empty($require_person)){
      $html.='<tr>
      <th>求める人物像</th>
      <td>'.$require_person.'</td>
    </tr>';
    }
    if(!empty($skills)){
      $html.='<tr>
      <th>学べるスキル</th>
      <td>'.$skills.'</td>
    </tr>';
    }
    if(!empty($scholarship_value)){
      $html.='<tr>
      <th>お祝い金</th>
      <td>'.$scholarship_value.'<a href='.esc_url("https://builds-story.com/gift_money").'>　お祝い金制度とは</a>
      </td>
    </tr>';
    }

    $html.= '</table>
  </section>

  <section>';
  if(!empty($intern_student_voice)){
    $html.='<h2 class="maintitle">働いているインターン生の声</h2>
    <p>'.$intern_student_voice.'</p>';
  }
  $html.='</section>

  <section>';
  if(!empty($prospective_employer)){
    $html.='<h2 class="maintitle">インターン卒業生の内定先</h2>
    <p>'.$prospective_employer.'</p>';
  }
  $html.='</section>'.

  $builds_voice_html

  .'<!-- entry -->
  <div class="fixed-buttom">'.$entry_html.'</div>
  </div>';
  return do_shortcode($html);
}

function edit_internship_info(){
  if($_GET["post_id"]){
    /**
     * * 「募集タイトル、給与、勤務可能時間、勤務条件、求める人物像、業務内容、1日の流れ、身につくスキル、勤務地、応募資格、インターン卒業生の内定先、働いているインターン生の声、イメージ画像、特徴」
     */

    $post_id= $_GET["post_id"];
    $post = get_post($post_id);
    $company = get_userdata($post->post_author);
    $company_name = $company->data->display_name;
    $post_title = $post->post_title;
    $regist_occupation = get_the_terms($post_id,"occupation")[0]->name;
    $occupation_array= array("engineer"=>"エンジニア","designer"=>"デザイナー","director"=>"ディレクター","marketer"=>"マーケティング","writer"=>"ライター","sales"=>"営業","corporate_staff"=>"事務/コーポレート・スタッフ","human_resources"=>"総務・人事・経理","planning"=>"企画","others"=>"その他");
    $occupation_html = '';
    foreach($occupation_array as $occupation_key => $occupation_value){
      if($regist_occupation == $occupation_value){
        $occupation_html .= '<input type="radio" name="occupation" value="'.$occupation_key.'" checked="checked" />'.$occupation_value;
      }else{
        $occupation_html .= '<input type="radio" name="occupation" value="'.$occupation_key.'" />'.$occupation_value;
      }
    }
    $salary = get_field("給与",$post_id);
    $worktime = get_field('勤務可能時間',$post_id);
    $requirements =get_field("勤務条件",$post_id);
    $require_person = get_field('求める人物像',$post_id);
	  $require_person = str_replace(array("\r\n", "\r","\n"), '&#13;', $require_person); //テキストエリア内の改行文字を適切な改行コードに変換
    $intern_contents = get_field("業務内容",$post_id);
	  $intern_contents = str_replace(array("\r\n", "\r","\n"), '&#13;', $intern_contents); //テキストエリア内の改行文字を適切な改行コードに変換
    $intern_day = get_field('1日の流れ',$post_id);
	  $intern_day = str_replace(array("\r\n", "\r","\n"), '&#13;', $intern_day); //テキストエリア内の改行文字を適切な改行コードに変換
    $skills = get_field("身につくスキル",$post_id);
	  $skills = str_replace(array("\r\n", "\r","\n"), '&#13;', $skills); //テキストエリア内の改行文字を適切な改行コードに変換
    $address = get_field("勤務地",$post_id);
    $skill_requirements = get_field('応募資格',$post_id);
	  $skill_requirements = str_replace(array("\r\n", "\r","\n"), '&#13;', $skill_requirements); //テキストエリア内の改行文字を適切な改行コードに変換
    $prospective_employer = get_field('インターン卒業生の内定先',$post_id);
	  $prospective_employer = str_replace(array("\r\n", "\r","\n"), '&#13;', $prospective_employer); //テキストエリア内の改行文字を適切な改行コードに変換
    $intern_student_voice = get_field('働いているインターン生の声',$post_id);
	  $intern_student_voice = str_replace(array("\r\n", "\r","\n"), '&#13;', $intern_student_voice); //テキストエリア内の改行文字を適切な改行コードに変換
    $image = get_field("イメージ画像",$post_id);
    $image2 = get_field("イメージ画像2",$post_id);
	  $image3 = get_field("イメージ画像3",$post_id);
	  $image4 = get_field("イメージ画像4",$post_id);
    if(is_array($image)){
      $image_url = $image["url"];
    }else{
      $image_url = wp_get_attachment_url($image);
    }
    if(is_array($image)){
      $image2_url = $image2["url"];
    }else{
      $image2_url = wp_get_attachment_url($image2);
    }
    if(is_array($image)){
      $image3_url = $image3["url"];
    }else{
      $image3_url = wp_get_attachment_url($image3);
    }
    if(is_array($image)){
      $image4_url = $image4["url"];
    }else{
      $image4_url = wp_get_attachment_url($image4);
    }
    $features_array = array("時給1000円以上","時給1200円以上","時給1500円以上","時給2000円以上","週1日ok","週2日ok","週3日以下でもok","1ヶ月からok","3ヶ月以下歓迎","未経験歓迎","1,2年歓迎","新規事業立ち上げ","理系学生おすすめ","外資系","ベンチャー","エリート社員","社長直下","起業ノウハウが身につく","インセンティブあり","英語力が活かせる","英語力が身につく","留学生歓迎","土日のみでも可能","リモートワーク可能","女性おすすめ","少数精鋭","交通費支給","曜日/時間が選べる","夕方から勤務でも可能","服装自由","髪色自由","ネイル可能","有名企業への内定者多数","プログラミングが未経験から学べる");
    $features = get_field('特徴',$post_id);
    $feature_html = '';
    foreach($features_array as $feature){
      if(in_array($feature, $features, true)){
        $feature_html .= '<label class="feature-label"><input type="checkbox" name="feature[]" id="" value="'.$feature.'" checked>'.$feature.'</label>';
      }else{
        $feature_html .= '<label class="feature-label"><input type="checkbox" name="feature[]" id="" value="'.$feature.'">'.$feature.'</label>';
      }
    }

    $style_html = "
    <style type='text/css'>
      .company_edit{
        text-align:center;
      }
      .feature-label{
        display: inline-block;
        width: 50%;
      }
      .input-width{
        width: 100%;
      }
      .input-file .preview {
        background-image: url(/hoge.jpg);
      }
      .input-file input[type='file'] {
        opacity: 0;
      }
    </style>";

    $edit_html =  $style_html.'
    <h2 class="maintitle">インターン情報</h2>
    <form action="https://builds-story.com/edit_internship?post_id='.$post_id.'" method="POST" enctype="multipart/form-data">
      <div class="tab_content_description">
        <p class="c-txtsp">
            <table class="demo01">
                <tbody>
                    <tr>
                        <th>募集タイトル</th>
                        <td>
                            <div class="company-name"><input class="input-width" type="text" min="0" name="post_title" id="" value="'.$post_title.'"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">職種</th>
                        <td>
                            <div class="company-established">'.$occupation_html.'</div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">給与</th>
                        <td>
                            <div class="company-established"><input class="input-width" type="text" min="0" name="salary" id="" value="'.$salary.'"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">勤務可能時間</th>
                        <td>
                            <div class="company-address"><input class="input-width" type="text" min="0" name="worktime" id="" value="'.$worktime.'"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">求める人物像</th>
                        <td>
                            <div class="company-representative"><textarea name="require_person" id="" cols="30" rows="5">'.$require_person.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">業務内容</th>
                        <td>
                            <div class="company-representative"><textarea name="intern_contents" id="" cols="30" rows="5">'.$intern_contents.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">1日の流れ</th>
                        <td>
                            <div class="company-capital"><textarea name="intern_day" id="" cols="30" rows="5">'.$intern_day.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">身につくスキル</th>
                        <td>
                            <div class="company-capital"><textarea name="skills" id="" cols="30" rows="5">'.$skills.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">勤務地</th>
                        <td>
                            <div class="company-capital"><input type="text" class="input-width" min="0" name="address" id="" value="'.$address.'"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">応募資格</th>
                        <td>
                            <div class="company-capital"><textarea name="skill_requirements" id="" cols="30" rows="5">'.$skill_requirements.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">インターン卒業生の内定先</th>
                        <td>
                            <div class="company-capital"><textarea name="prospective_employer" id="" cols="30" rows="5">'.$prospective_employer.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">働いているインターン生の声</th>
                        <td>
                            <div class="company-capital"><textarea name="intern_student_voice" id="" cols="30" rows="5">'.$intern_student_voice.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">イメージ画像<br>(企業ロゴや社内イメージなど)</th>
                        <td>
                            <div class="input_file">
                              <div class="preview">
                                <div class="preview-img"></div>
                                <img src="'.$image_url.'">
                                <input accept="image/*" id="imgFile" type="file" name="picture">
                              </div>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">イメージ画像2<br>(社内イメージ)</th>
                        <td>
                            <div class="input_file">
                              <div class="preview">
                                <div class="preview-img2"></div>
                                <img src="'.$image2_url.'">
                                <input accept="image/*" id="imgFile2" type="file" name="picture2">
                              </div>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">イメージ画像3<br>(社内イメージ)</th>
                        <td>
                            <div class="input_file">
                              <div class="preview">
                                <div class="preview-img3"></div>
                                <img src="'.$image3_url.'">
                                <input accept="image/*" id="imgFile3" type="file" name="picture3">
                              </div>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">イメージ画像4<br>(社内イメージ)</th>
                        <td>
                            <div class="input_file">
                              <div class="preview">
                                <div class="preview-img4"></div>
                                <img src="'.$image4_url.'">
                                <input accept="image/*" id="imgFile4" type="file" name="picture4">
                              </div>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">特徴</th>
                        <td>
                            <div class="company-capital">'.$feature_html.'</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </p>
        <input type="hidden" name="edit_intern" value="edit_intern">
        <div class="company_edit">
          <input class="button favorite innactive" style="width:40%; margin-top:15px; background-color:#f9b539; border-radius: 5px;" type="submit" value="更新する">
          <a class="button favorite innactive" style="width:40%; margin-top:15px; border-radius: 5px;" href="https://builds-story.com/?company='.$company_name.'">戻る</a>
        </div>
      </div>
    </form>';
    return $edit_html;
  }else{
    header('Location: https://builds-story.com/');
    die();
  }
}
add_shortcode("edit_internship_info","edit_internship_info");

function update_internship_info(){
  if(!empty($_POST["occupation"]) && !empty($_POST["edit_intern"])){
    $post_id = $_GET["post_id"];
    // $post = get_post($post_id);
    $post = get_post($post_id);
    $company = get_userdata($post->post_author);
    $company_name = $company->data->display_name;

    $post_title = $_POST["post_title"];
    $occupation = $_POST["occupation"];
    $salary = $_POST["salary"];
    $worktime = $_POST["worktime"];
    $requirements = $_POST["requirements"];
    $require_person = $_POST["require_person"];
    $intern_contents = $_POST["intern_contents"];
    $intern_day = $_POST["intern_day"];
    $skills = $_POST["skills"];
    $address = $_POST["address"];
    $stations=get_time_to_station($address);
    $skill_requirements = $_POST["skill_requirements"];
    $prospective_employer = $_POST["prospective_employer"];
    $intern_student_voice = $_POST["intern_student_voice"];
    $feature = $_POST["feature"];
    $picture = $_FILES["picture"];
    $picture2 = $_FILES["picture2"];
    $picture3 = $_FILES["picture3"];
    $picture4 = $_FILES["picture4"];

    if($_POST["post_title"]){
      $my_post = array('ID' => $post_id,'post_title' => $post_title,'post_content' => '',);
      wp_update_post( $my_post );
      update_post_meta($post_id, '募集タイトル', $post_title);
    }
    if($_POST["occupation"]){
      wp_set_object_terms( $post_id, $occupation, 'occupation');
    }
    if($_POST["salary"]){
      update_post_meta($post_id, "給与", $salary);
    }
    if($_POST["worktime"]){
      update_post_meta($post_id, "勤務可能時間", $worktime);
    }
    if($_POST["requirements"]){
      update_post_meta($post_id, "勤務条件", $requirements);
    }
    if($_POST["require_person"]){
      update_post_meta($post_id, "求める人物像", $require_person);
    }
    if($_POST["intern_contents"]){
      update_post_meta($post_id, "業務内容", $intern_contents);
    }
    if($_POST["intern_day"]){
      update_post_meta($post_id, "1日の流れ", $intern_day);
    }
    if($_POST["skills"]){
      update_post_meta($post_id, "身につくスキル", $skills);
    }
    if($_POST["address"]){
      update_post_meta($post_id, "勤務地", $address);
      update_post_meta($insert_id, '最寄り駅', $stations);
      preg_match("/(東京都|北海道|(?:京都|大阪)府|.{6,9}県)((?:四日市|廿日市|野々市|臼杵|かすみがうら|つくばみらい|いちき串木野)市|(?:杵島郡大町|余市郡余市|高市郡高取)町|.{3,12}市.{3,12}区|.{3,9}区|.{3,15}市(?=.*市)|.{3,15}市|.{6,27}町(?=.*町)|.{6,27}町|.{9,24}村(?=.*村)|.{9,24}村)(.*)/",$_POST["address"],$result);
      $prefecture = $result[1];
      $area = $result[2];
      if($prefecture == "東京都"){
        wp_set_object_terms( $post_id, $area, 'area');
      }else{
        wp_set_object_terms( $post_id, $prefecture, 'area');
      }
    }
    if($_POST["skill_requirements"]){
      update_post_meta($post_id, "応募資格", $skill_requirements);
    }
    if($_POST["prospective_employer"]){
      update_post_meta($post_id, "インターン卒業生の内定先", $prospective_employer);
    }
    if($_POST["intern_student_voice"]){
      update_post_meta($post_id, "働いているインターン生の声", $intern_student_voice);
    }
    if($_POST["feature"]){
      update_post_meta($post_id, "特徴", $feature);
    }
    if($_FILES["picture"]){
      add_custom_image($post_id, "イメージ画像", $picture);
    }
    if($_FILES["picture2"]){
      add_custom_image($post_id, "イメージ画像2", $picture2);
    }
    if($_FILES["picture3"]){
      add_custom_image($post_id, "イメージ画像3", $picture3);
    }
    if($_FILES["picture4"]){
      add_custom_image($post_id, "イメージ画像4", $picture4);
    }
    header('Location: https://builds-story.com/?company='.$company_name);
    die();
  }
}
add_action('template_redirect', 'update_internship_info');

function new_internship_form(){
  $occupation_array= array("engineer"=>"エンジニア","designer"=>"デザイナー","director"=>"ディレクター","marketer"=>"マーケティング","writer"=>"ライター","sales"=>"営業","corporate_staff"=>"事務/コーポレート・スタッフ","human_resources"=>"総務・人事・経理","planning"=>"企画","others"=>"その他");
  $occupation_html = '<div class="company-established new_intern_occupation">';
  foreach($occupation_array as $occupation_key => $occupation_value){
    $occupation_html .= '<div><input type="radio" name="occupation" value="'.$occupation_key.'" />'.$occupation_value.'</div>';
  }
  $occupation_html .= '</div>';
  $features_array = array("時給1000円以上","時給1200円以上","時給1500円以上","時給2000円以上","週1日ok","週2日ok","週3日以下でもok","1ヶ月からok","3ヶ月以下歓迎","未経験歓迎","1,2年歓迎","新規事業立ち上げ","理系学生おすすめ","外資系","ベンチャー","エリート社員","社長直下","起業ノウハウが身につく","インセンティブあり","英語力が活かせる","英語力が身につく","留学生歓迎","土日のみでも可能","リモートワーク可能","女性おすすめ","少数精鋭","交通費支給","曜日/時間が選べる","夕方から勤務でも可能","服装自由","髪色自由","ネイル可能","有名企業への内定者多数","プログラミングが未経験から学べる");
  $feature_html = '';
  foreach($features_array as $feature){
    $feature_html .= '<div><label class=""><input type="checkbox" name="feature[]" id="" value="'.$feature.'">'.$feature.'</label></div>';
  }

  $style_html = "
  <style type='text/css'>
    .company_edit{
      text-align:center;
    }
    .feature-label{
      display: inline-block;
      width: 50%;
    }
    .input-width{
      width: 100%;
    }
    .input-file .preview {
      background-image: url(/hoge.jpg);
    }
    .input-file input[type='file'] {
      opacity: 0;
    }
    .new_intern_occupation{
      display: flex;
      flex-wrap: wrap;
    }
    .new_intern_occupation div{
      width: 280px;
      line-height: 1.7;
    }
    .new_intern_feature{
      display: flex;
      flex-wrap: wrap;
    }
    .new_intern_feature div{
      width: 280px;
      line-height: 1.7;
    }
    .new_intern_feature div label{
      font-weight: normal;
    }
    .new_intern_address div label{
      font-weight: normal;
    }
    .new_intern_table textarea{
      height: auto;
    }
    @media screen and (max-width: 480px) {
      .new_intern_table td{
        width: 60%;
        margin-left: -20px;
      }
    }
  </style>
  <script src='https://ajaxzip3.github.io/ajaxzip3.js' charset='UTF-8'></script>";
  $ajaxzip3 = "AjaxZip3.zip2addr(this,'','address','address');";

  $edit_html =  $style_html.'
  <h2 class="maintitle">インターン情報</h2>
  <form action="https://builds-story.com/new_post_internship" method="POST" enctype="multipart/form-data">
    <div class="tab_content_description">
      <p class="c-txtsp">
          <table class="demo01 new_intern_table">
              <tbody>
                  <tr>
                      <th>募集タイトル*</th>
                      <td>
                          <div class="company-name"><input class="input-width" type="text" min="0" name="post_title" id="" value="" required></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">職種*</th>
                      <td>
                          '.$occupation_html.'
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">仕事の概要*</th>
                      <td>
                          <div class="company-representative"><textarea name="intern_contents" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;未経験者の方には初歩的なものからやっていただきます。&#13;&#10;研修期間後業務の幅を広げていきます。&#13;&#10;提案資料の作成、企業概要書の作成、売り手・買い手のソーシング、成約に至るまで、M＆Aのプロセスをサポートして頂きます。&#13;&#10;会計士、弁護士やコンサルタントと同じ職場なので、さまざまな経験・スキルを得られます！" required></textarea></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">勤務地*</th>
                      <td>
                          <div class="new_intern_address">
                            <div>
                              <label>郵便番号(ハイフンなし7桁)</label>
                              <input type="text" name="zip11" size="10" maxlength="8" onKeyUp="'.$ajaxzip3.'">
                            </div>
                            <div>
                              <label>住所</label>
                              <input type="text" name="address" size="60">
                            </div>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">給与*</th>
                      <td>
                          <div class="company-established"><input class="input-width" type="text" min="0" name="salary" id="" value="" placeholder="(例) 時給1000円" required></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">勤務可能時間*</th>
                      <td>
                          <div class="company-address"><input class="input-width" type="text" min="0" name="worktime" id="" value="" placeholder="(例) 平日9:00-19:00" required></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">勤務条件*</th>
                      <td>
                          <div class="company-address"><input class="input-width" type="text" min="0" name="day_requirements" placeholder="(例) 1日4時間〜、週3日〜" id="" value="" required></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">応募資格*</th>
                      <td>
                          <div class="company-capital"><textarea name="skill_requirements" id="" cols="30" rows="8" placeholder="(例)&#13;&#10;・最後までやり遂げる力がある&#13;&#10;・MOS全般扱える&#13;&#10;・TOEIC700点以上&#13;&#10;・簿記2級以上&#13;&#10;・1.2年生" required></textarea></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">求める人物像*</th>
                      <td>
                          <div class="company-representative"><textarea name="require_person" id="" cols="30" rows="8" placeholder="(例)&#13;&#10;・素直な人&#13;&#10;・チームワークが取れる人&#13;&#10;・責任感がある人&#13;&#10;・会社運営に関わりたい人&#13;&#10;・仕事を楽しめる人" required></textarea></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">身につくスキル*</th>
                      <td>
                          <div class="company-capital"><textarea name="skills" id="" cols="30" rows="8" placeholder="(例)&#13;&#10;・SEO対策&#13;&#10;・0→1の思考力&#13;&#10;・問題解決力&#13;&#10;・メディア運営ノウハウ&#13;&#10;・デジタルマーケにおける企画・分析・思考力" required></textarea></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">働いているインターン生の声</th>
                      <td>
                          <div class="company-capital"><textarea name="intern_student_voice" id="" cols="30" rows="5"></textarea></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">インターン卒業生の内定先</th>
                      <td>
                          <div class="company-capital"><textarea name="prospective_employer" id="" cols="30" rows="5"></textarea></div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">イメージ画像*<br>(社内イメージ)</th>
                      <td>
                        <div class="input_file">
                          <div class="preview">
                            <div class="preview-img"></div>
                            <input accept="image/*" id="imgFile" type="file" name="picture" required>
                          </div>
                          <p>※600×400サイズ推奨</p>
                        </div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">イメージ画像2<br>(社内イメージ)</th>
                      <td>
                        <div class="input_file">
                          <div class="preview">
                            <div class="preview-img2"></div>
                            <input accept="image/*" id="imgFile2" type="file" name="picture2">
                          </div>
                          <p>※600×400サイズ推奨</p>
                        </div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">イメージ画像3<br>(社内イメージ)</th>
                      <td>
                        <div class="input_file">
                          <div class="preview">
                            <div class="preview-img3"></div>
                            <input accept="image/*" id="imgFile3" type="file" name="picture3">
                          </div>
                          <p>※600×400サイズ推奨</p>
                        </div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">イメージ画像4<br>(社内イメージ)</th>
                      <td>
                        <div class="input_file">
                          <div class="preview">
                            <div class="preview-img4"></div>
                            <input accept="image/*" id="imgFile4" type="file" name="picture4">
                          </div>
                          <p>※600×400サイズ推奨</p>
                        </div>
                      </td>
                  </tr>
                  <tr>
                      <th align="left" nowrap="nowrap">特徴</th>
                      <td>
                          <div class="company-capital new_intern_feature">'.$feature_html.'</div>
                      </td>
                  </tr>
              </tbody>
          </table>
      </p>
      <input type="hidden" name="new_post_intern" value="new_post_intern">
      <div class="company_edit">
        <input class="button favorite innactive" style="width:40%; margin-top:15px; background-color:#f9b539; border-radius: 5px;" type="submit" value="投稿する">
      </div>
    </div>
  </form>';
  return $edit_html;
}
add_shortcode('new_internship_form','new_internship_form');


function new_company_post_internship(){
  if(!empty($_POST["post_title"]) && !empty($_POST["new_post_intern"])){
      $user = get_current_user_id();
      $post_title = $_POST["post_title"];
      $company_bussiness = $_POST["company_bussiness"];
      $intern_contents = $_POST["intern_contents"];
      $skills = $_POST["skills"];
      $address = $_POST["address"];
      $stations=get_time_to_station($address);
      preg_match("/(東京都|北海道|(?:京都|大阪)府|.{6,9}県)((?:四日市|廿日市|野々市|臼杵|かすみがうら|つくばみらい|いちき串木野)市|(?:杵島郡大町|余市郡余市|高市郡高取)町|.{3,12}市.{3,12}区|.{3,9}区|.{3,15}市(?=.*市)|.{3,15}市|.{6,27}町(?=.*町)|.{6,27}町|.{9,24}村(?=.*村)|.{9,24}村)(.*)/",$_POST["address"],$result);
      $prefecture = $result[1];
      $area = $result[2];
      $skill_requirements = $_POST["skill_requirements"];
      $prospective_employer = $_POST["prospective_employer"];
      $intern_student_voice = $_POST["intern_student_voice"];
      $features = $_POST["feature"];
      $occupation = $_POST["occupation"];
      $salary = $_POST["salary"];
      $intern_day = $_POST["intern_day"];
      $worktime = $_POST["worktime"];
      $day_requirements = $_POST["day_requirements"];
      $require_person = $_POST["require_person"];
      $picture = $_FILES["picture"];
      $picture2 = $_FILES["picture2"];
      $picture3 = $_FILES["picture3"];
      $picture4 = $_FILES["picture4"];

      $post_value = array(
          'post_author' => get_current_user_id(),
          'post_title' => $post_title,
          'post_type' => 'internship',
          'post_status' => 'draft'
      );
      $insert_id = wp_insert_post($post_value); //下書き投稿。
      if($insert_id) {
          //配列$post_valueに上書き用の値を追加、変更
          $post_value['ID'] = $insert_id; // 下書きした記事のIDを渡す。
          $post_value['post_status'] = 'publish'; // 公開ステータスをこの時点で公開にする。

          update_post_meta($insert_id, '事業内容', $company_bussiness);
          update_post_meta($insert_id, '募集タイトル', $post_title);
          update_post_meta($insert_id, '給与', $salary);
          update_post_meta($insert_id, '勤務可能時間', $worktime);
          update_post_meta($insert_id, '勤務条件', $day_requirements);
          update_post_meta($insert_id, '求める人物像', $require_person);
          update_post_meta($insert_id, '業務内容', $intern_contents);
          update_post_meta($insert_id, '1日の流れ', $intern_day);
          update_post_meta($insert_id, '身につくスキル', $skills);
          update_post_meta($insert_id, '勤務地', $address);
          update_post_meta($insert_id, '最寄り駅', $stations);
          update_post_meta($insert_id, '応募資格', $skill_requirements);
          update_post_meta($insert_id, 'インターン卒業生の内定先', $prospective_employer);
          update_post_meta($insert_id, '働いているインターン生の声', $intern_student_voice);
          update_post_meta($insert_id, '特徴', $features);
          add_custom_image($insert_id, 'イメージ画像', $picture);
          add_custom_image($insert_id, 'イメージ画像2', $picture2);
          add_custom_image($insert_id, 'イメージ画像3', $picture3);
          add_custom_image($insert_id, 'イメージ画像4', $picture4);
          wp_set_object_terms( $insert_id, $occupation, 'occupation');
          if($prefecture == "東京都"){
              wp_set_object_terms( $insert_id, $area, 'area');
          }else{
              wp_set_object_terms( $insert_id, $prefecture, 'area');
          }
          $insert_id2 = wp_insert_post($post_value); //上書き（投稿ステータスを公開に）

          if($insert_id2) {
              /* 投稿に成功した時の処理等を記述 */
              header('Location: '.get_permalink($insert_id2));
              die();
              $html = '<p>success</p>';
          } else {
              /* 投稿に失敗した時の処理等を記述 */
              $html = '<p>error1</p>';
          }
      } else {
          /* 投稿に失敗した時の処理等を記述 */
          $html = '<p>error2</p>';
          $html .= '<p>'.$insert_id.'</p>';
      }
  }
}
add_action('template_redirect', 'new_company_post_internship');

function get_company_id($company){
  $args = array(
    'posts_per_page'   => 5,
    'offset'           => 0,
    'category'         => '',
    'category_name'    => '',
    'orderby'          => 'date',
    'order'            => 'DESC',
    'include'          => '',
    'exclude'          => '',
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => 'company',
    'post_mime_type'   => '',
    'post_parent'      => '',
    'author'	         => $company->ID,
    'post_status'      => 'publish',
    'suppress_filters' => true,
  );
  $posts_array = get_posts( $args );
  $company_id = $posts_array[0]->ID;
  return $company_id;
}

?>