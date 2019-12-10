<?php

function my_scripts_method() {
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', array(), '1.8.3');
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

function change_user_pdata(){
    $user_id = um_profile_id();
    $user_roles = get_user_meta($user_id,'wp_146219050_capabilities',false)[0];
    $timestamp = time();
    if(in_array("student", $user_roles)){
        $results = '
        <form method="post" action="">
            <input type="hidden" name="user_id" id="user_id" value="'.$user_id.'">
            <input type="hidden" name="form_id" id="form_id_6120" value="6120">
            <input type="hidden" name="timestamp" class="um_timestamp" value="'.$timestamp.'">
            <div class="photo-btns">
                <input type="submit" value="更新" class="um-modal-btn um-finish-upload image" data-key="profile_photo" data-change="写真を変更">
                <a href="" class="um-modal-btn alt" data-action="um_remove_modal">キャンセル</a>
            </div>
        </form>';
    }
    echo $results;
    die();
}
add_action( 'wp_ajax_change_user_pdata', 'change_user_pdata' );
add_action( 'wp_ajax_nopriv_change_user_pdata', 'change_user_pdata' );

function change_user_cdata(){
    $user_id = um_profile_id();
    $user_roles = get_user_meta($user_id,'wp_146219050_capabilities',false)[0];
    $timestamp = time();
    if(in_array("student", $user_roles)){
    $results = '
    <form method="post" action="">
        <input type="hidden" name="user_id" id="user_id" value="'.$user_id.'">
        <input type="hidden" name="form_id" id="form_id_6120" value="6120">
        <input type="hidden" name="timestamp" class="um_timestamp" value="'.$timestamp.'">
        <div class="photo-btns">
            <input type="submit" value="更新" class="um-modal-btn um-finish-upload image" data-key="cover_photo" data-change="写真を変更">
            <a href="" class="um-modal-btn alt" data-action="um_remove_modal">キャンセル</a>
        </div>
    </form>';
    }
    echo $results;
    die();
}
add_action( 'wp_ajax_change_user_cdata', 'change_user_cdata' );
add_action( 'wp_ajax_nopriv_change_user_cdata', 'change_user_cdata' );


function view_user_pdata(){
    $login_user = wp_get_current_user();
    $user_roles = $login_user->roles;
    $profile_id = um_profile_id();
    $result = '';
    if(in_array("student", $user_roles)){
        $result = '
        <div class="um-dropdown" data-element="div.um-profile-photo" data-position="bc" data-trigger="click" style="top: 74px; width: 200px; left: 4px; right: auto; text-align: center; display: none;">
            <div class="um-dropdown-b">
                <div class="um-dropdown-arr" style="top: -17px; left: 87px; right: auto;">
                    <i class="um-icon-arrow-up-b"></i>
                </div>
                <ul>
                    <li><a href="javascript:void(0);" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">写真を変更</a></li>
                    <li><a href="javascript:void(0);" class="um-reset-profile-photo" data-user_id="'.$profile_id.'" data-default_src="https://builds-story.com/wp-content/uploads/2019/01/72c10119609beb94909b6a4f65a3d12b.jpeg">写真を削除</a></li>
                    <li><a href="javascript:void(0);" class="um-dropdown-hide">キャンセル</a></li>
                </ul>
            </div>
        </div>';
    }
    echo $result;
    die();
}
add_action( 'wp_ajax_view_user_pdata', 'view_user_pdata' );
add_action( 'wp_ajax_nopriv_view_user_pdata', 'view_user_pdata' );

function view_user_cdata(){
    $login_user = wp_get_current_user();
    $user_roles = $login_user->roles;
    $profile_id = um_profile_id();
    $result = '';
    if(in_array("student", $user_roles)){
        $result = '
        <div class="um-dropdown" data-element="div.um-cover" data-position="bc" data-trigger="click" style="top: 203.5px; width: 200px; left: 300px; right: auto; text-align: center; display: none;"><div class="um-dropdown-b">
            <div class="um-dropdown-arr" style="top: -17px; left: 87px; right: auto;">
                <i class="um-icon-arrow-up-b"></i>
            </div>
            <ul>
                <li><a href="javascript:void(0);" class="um-manual-trigger" data-parent=".um-cover" data-child=".um-btn-auto-width">カバー写真を変更</a></li>
                <li><a href="javascript:void(0);" class="um-reset-cover-photo" data-user_id="'.$profile_id.'">削除</a></li>
                <li><a href="javascript:void(0);" class="um-dropdown-hide">キャンセル</a></li>
            </ul>
        </div>';
    }
    echo $result;
    die();
}
add_action( 'wp_ajax_view_user_cdata', 'view_user_cdata' );
add_action( 'wp_ajax_nopriv_view_user_cdata', 'view_user_cdata' );

function Ajax_Base(){
    $user_id = um_profile_id();
    $results = '
    <div class="um-field-label um-info-label-base">
        <label class="um-field-label-text"><i class="um-field-label-base"></i>基本情報</label>
        <span class="um-edit-btn um-edit-btn-base active" onclick="edit_base()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-base inactive">
        <div class="um-field-value">';
    $user_array = array(
        "都道府県"  =>  "region",
        "性別"  =>  "gender",
        "出身高校"  =>  "highschool",
    );
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'gender'){
            if(isset($_POST[$user_value])) {
                $user_meta_value = $_POST[$user_value];
                // Update/Create User Meta
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
                // Update/Create User Meta
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-6120">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results = '</div></div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_base', 'Ajax_Base' );
add_action( 'wp_ajax_nopriv_ajax_base', 'Ajax_Base' );

function Ajax_Univ(){
    $user_id = um_profile_id();
    if(isset($_POST['faculty_lineage'])) {
        $faculty_lineage = $_POST['faculty_lineage'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'faculty_lineage', $faculty_lineage);
    }
    $faculty_lineage = get_user_meta($user_id,'faculty_lineage',false)[0];

    if(isset($_POST['faculty_department-6120'])) {
        $faculty_department = $_POST['faculty_department-6120'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'faculty_department', $faculty_department);
    }
    $faculty_department = get_user_meta($user_id,'faculty_department',false)[0];

    if(isset($_POST['graduate_year'])) {
        $graduate_year = $_POST['graduate_year'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'graduate_year', $graduate_year);
    }
    $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];

    if(isset($_POST['seminar-6120'])) {
        $seminar = $_POST['seminar-6120'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'seminar', $seminar);
    }
    $seminar = get_user_meta($user_id,'seminar',false)[0];

    $result .= "学歴を更新しました。";
    $results = '<div class="um-field-label um-info-label-univ">
                    <label class="um-field-label-text"><i class="um-field-label-univ"></i>学歴</label>
                    <span class="um-edit-btn um-edit-btn-univ active" onclick="edit_univ()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-univ inactive">
                    <div class="um-field-value">
                        <div class="um-field um-field-faculty_lineage um-field-select um-field-type_select" data-key="faculty_lineage">
                            <div class="um-field-label">
                                <label for="faculty_lineage-1597">学部系統</label>
                                <div class="um-clear"></div>
                            </div>
                            <div class="um-field-area">
                                <div class="um-field-value">'.$faculty_lineage.'</div>
                            </div>
                        </div>
                        <div class="um-field um-field-faculty_department um-field-text um-field-type_text" data-key="faculty_department">
                            <div class="um-field-label">
                                <label for="faculty_department-1597">学部・学科</label>
                                <div class="um-clear"></div>
                            </div>
                            <div class="um-field-area">
                                <div class="um-field-value">'.$faculty_department.'</div>
                            </div>
                        </div>
                        <div class="um-field um-field-graduate_year um-field-select um-field-type_select" data-key="graduate_year">
                            <div class="um-field-label">
                                <label for="graduate_year-1597">卒業年</label>
                                <div class="um-clear"></div>
                            </div>
                            <div class="um-field-area">
                                <div class="um-field-value">'.$graduate_year.'</div>
                            </div>
                        </div>
                        <div class="um-field um-field-seminar um-field-text um-field-type_text" data-key="seminar">
                            <div class="um-field-label">
                                <label for="seminar-1597">ゼミ</label>
                                <div class="um-clear"></div>
                            </div>
                            <div class="um-field-area">
                                <div class="um-field-value">'.$seminar.'</div>
                            </div>
                        </div>
                    </div>
                </div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_univ', 'Ajax_Univ' );
add_action( 'wp_ajax_nopriv_ajax_univ', 'Ajax_Univ' );

function Ajax_Abroad(){
    $user_id = um_profile_id();

    if(isset($_POST['studied_abroad'])) {
        $studied_abroad = $_POST['studied_abroad'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'studied_abroad', $studied_abroad);
    }
    $studied_abroad = get_user_meta($user_id,'studied_abroad',false)[0][0];

    if(isset($_POST['studied_ab_place-6120'])) {
        $studied_ab_place = $_POST['studied_ab_place-6120'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'studied_ab_place', $studied_ab_place);
    }
    $studied_ab_place = get_user_meta($user_id,'studied_ab_place',false)[0];

    if(isset($_POST['lang_pr'])) {
        $lang_pr = $_POST['lang_pr'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'lang_pr', $lang_pr);
    }
    $lang_pr = get_user_meta($user_id,'lang_pr',false)[0];

    $result .= "留学を更新しました。";
    $results = '<div class="um-field-label um-info-label-abroad">
                    <label class="um-field-label-text"><i class="um-field-label-abroad"></i>留学</label>
                    <span class="um-edit-btn um-edit-btn-abroad active" onclick="edit_abroad()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-abroad inactive">
                    <div class="um-field-value">
                        <div class="um-field um-field-studied_abroad um-field-radio um-field-type_radio" data-key="studied_abroad">
                            <div class="um-field-label">
                                <label for="studied_abroad-1597">留学経験</label>
                                <div class="um-clear"></div>
                            </div>
                            <div class="um-field-area">
                                <div class="um-field-value">'.$studied_abroad.'</div>
                            </div>
                        </div>
                        <div class="um-field um-field-studied_ab_place um-field-text um-field-type_text" data-key="studied_ab_place">
                            <div class="um-field-label">
                                <label for="studied_ab_place-1597">留学先</label>
                                <div class="um-clear"></div>
                            </div>
                            <div class="um-field-area">
                                <div class="um-field-value">'.$studied_ab_place.'</div>
                            </div>
                        </div>
                        <div class="um-field um-field-lang_pr um-field-textarea um-field-type_textarea" data-key="lang_pr">
                            <div class="um-field-label">
                                <label for="lang_pr-1597">その他</label>
                                <div class="um-clear"></div>
                            </div>
                            <div class="um-field-area">
                                <div class="um-field-value">'.$lang_pr.'</div>
                            </div>
                        </div>
                    </div>
                </div>';

    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_abroad', 'Ajax_Abroad' );
add_action( 'wp_ajax_nopriv_ajax_abroad', 'Ajax_Abroad' );

function Ajax_Programming(){
    $user_id = um_profile_id();

    if(isset($_POST['experience_programming'])) {
        $experience_programming = $_POST['experience_programming'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'experience_programming', $experience_programming);
    }
    $experience_programming = get_user_meta($user_id,'experience_programming',false)[0][0];

    if(isset($_POST['programming_languages'])) {
        $programming_languages = $_POST['programming_languages'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'programming_languages', $programming_languages);
    }
    $programming_languages = get_user_meta($user_id,'programming_languages',false)[0];

    if(isset($_POST['framework'])) {
        $framework = $_POST['framework'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'framework', $framework);
    }
    $framework = get_user_meta($user_id,'framework',false)[0];

    if(isset($_POST['GitHub-6120'])) {
        $Github = $_POST['GitHub-6120'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'Github', $Github);
    }
    $Github = get_user_meta($user_id,'GitHub',false)[0];

    if(isset($_POST['skill_dev'])) {
        $skill_dev = $_POST['skill_dev'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'skill_dev', $skill_dev);
    }
    $skill_dev = get_user_meta($user_id,'skill_dev',false)[0];
    if(isset($skill_dev)) {
        foreach($skill_dev as $dev) {
            //echo $language;
            $devs .= $dev.'</br>' ;
        }
    }

    if(isset($_POST['skill_design'])) {
        $skill_design = $_POST['skill_design'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'skill_design', $skill_design);
    }
    $skill_design = get_user_meta($user_id,'skill_design',false)[0];
    if(isset($skill_design)) {
        foreach($skill_design as $design) {
            //echo $language;
            $designs .= $design.'</br>' ;
        }
    }

    if(isset($_POST['work'])) {
        $work = $_POST['work'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'work', $work);
    }
    $work = get_user_meta($user_id,'work',false)[0];

    $programming_lang_lv_array = array(
        "C言語"  => "programming_lang_lv_c",
        "C++"    => "programming_lang_lv_cpp",
        "C#"  =>  "programming_lang_lv_cs",
        "Objective-C"  =>  "programming_lang_lv_m",
        "Java"  =>  "programming_lang_lv_java",
        "JavaScript"  =>  "programming_lang_lv_js",
        "Python"  =>  "programming_lang_lv_py",
        "PHP"  =>  "programming_lang_lv_php",
        "Perl"  =>  "programming_lang_lv_pl",
        "Ruby"  =>  "programming_lang_lv_rb",
        "Go"  =>  "programming_lang_lv_go",
        "Swift"  =>  "programming_lang_lv_swift",
        "Visual Basic"  =>  "programming_lang_lv_vb",
    );
    $languages = "";
    foreach( $programming_lang_lv_array as $programming_lang_name => $programming_lang_lv){
        if(isset($_POST[$programming_lang_lv])){
            $programming_lang_lv_skill = $_POST[$programming_lang_lv];
            update_user_meta( $user_id, $programming_lang_lv, $programming_lang_lv_skill);
        }
        $programming_lang_lv_skill = get_user_meta($user_id,$programming_lang_lv,false)[0];
        if($programming_lang_lv_skill > 0 and in_array($programming_lang_name, $programming_languages)) {
            $languages .='
                <div class=" um-field-'.$programming_lang_lv.' um-field-rating um-field-type_rating" data-key="'.$programming_lang_lv.'">
                    <div class="um-field-label">
                        <label for="'.$programming_lang_lv.'-6120">'.$programming_lang_name.'のレベル</label>
                        <div class="um-clear"></div>
                    </div>
                    <div class="um-field-area">
                        <div class="um-field-value">
                            <div class="um-rating-readonly um-raty" id="'.$programming_lang_lv.'" data-key="'.$programming_lang_lv.'" data-number="5" data-score="'.$programming_lang_lv_skill.'" title="'.$programming_lang_lv_skill.'">';
                    for($i = 1; $i < ($programming_lang_lv_skill+1); $i++){
                        $languages .= '<i data-alt="'.$i.'" class="star-on-png" title="'.$programming_lang_lv_skill.'"></i>';
                    }
                    for($i = $programming_lang_lv_c+1; $i < 6; $i++){
                        $languages .= '<i data-alt="'.$i.'" class="star-off-png" title="'.$programming_lang_lv_skill.'"></i>';
                    }
            $languages .= '</div>
                        </div>
                    </div>
                </div>';
        }
    }

    $result .= "プログラミングを更新しました。";
    $results = '
            <div class="um-field-label um-info-label-programming">
                <label class="um-field-label-text"><i class="um-field-label-programming"></i>プログラミング</label>
                <span class="um-edit-btn um-edit-btn-programming active" onclick="edit_programming()">編集</span>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area um-field-area-programming inactive">
                <div class="um-field-value">
                    <div class="um-field um-field-experience_programming um-field-radio um-field-type_radio" data-key="experience_programming"><div class="um-field-label"><label for="experience_programming-1597">プログラミング経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$experience_programming.'</div></div></div>'.$languages.'
                    <div class="um-field um-field-framework um-field-textarea um-field-type_textarea" data-key="framework"><div class="um-field-label"><label for="framework-1597">使用したことのあるフレームワーク・ライブラリ</label><p></p><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$framework.'</div></div></div>
                    <div class="um-field um-field-GitHub um-field-url um-field-type_url" data-key="GitHub"><div class="um-field-label"><label for="GitHub-1597">GitHubアカウント</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$Github.'</div></div></div>
                    <div class="um-field um-field-skill_dev um-field-multiselect um-field-type_multiselect" data-key="skill_dev"><div class="um-field-label"><label for="skill_dev-1597">開発ソフトのスキル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$devs.'</div></div></div>
                    <div class="um-field um-field-skill_design um-field-multiselect um-field-type_multiselect" data-key="skill_design"><div class="um-field-label"><label for="skill_design-1597">使えるデザイン系アプリケーション</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$designs.'</div></div></div>
                    <div class="um-field um-field-work um-field-textarea um-field-type_textarea" data-key="work"><div class="um-field-label"><label for="">プログラミング実務経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$work.'</div></div></div>
                </div>
            </div>
        ';

    // echoで、クライアント側に返すデータを送信する
    echo $results;

    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_programming', 'Ajax_Programming' );
add_action( 'wp_ajax_nopriv_ajax_programming', 'Ajax_Programming' );

function Ajax_Skill(){
  $user_query = get_user_by('login',$_GET['um_user']);
  $user_id = um_profile_id();
  

  if(isset($_POST['skill'])) {
      $skill = $_POST['skill'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'skill', $skill);
  }
  $skill = get_user_meta($user_id,'skill',false)[0];

  $result = "資格・その他スキルを更新しました。";
  $results = '<div class="um-field-label um-info-label-skill">
              <label class="um-field-label-text"><i class="um-field-label-skill"></i>資格・その他スキル</label>
              <span class="um-edit-btn um-edit-btn-skill active" onclick="edit_skill()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-skill inactive">
          <div class="um-field-value">
                  <div class="um-field um-field-skill um-field-textarea um-field-type_textarea" data-key="skill"><div class="um-field-label"><label for="skill-1597">資格・その他スキル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$skill.'</div></div></div>
          </div>
          </div>
      ';

// echoで、クライアント側に返すデータを送信する
  echo $results;

  // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
  die();
}
add_action( 'wp_ajax_ajax_skill', 'Ajax_Skill' );
add_action( 'wp_ajax_nopriv_ajax_skill', 'Ajax_Skill' );

function Ajax_Community(){
  $user_query = get_user_by('login',$_GET['um_user']);
  $user_id = um_profile_id();
  if(isset($_POST['univ_community'])) {
      $univ_community = $_POST['univ_community'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'univ_community', $univ_community);
  }
  $univ_community = get_user_meta($user_id,'univ_community',false)[0][0];
  
  if(isset($_POST['community_univ'])) {
      $community_univ = $_POST['community_univ'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'community_univ', $community_univ);
  }
  $community_univ = get_user_meta($user_id,'community_univ',false)[0];
  
  if(isset($_POST['own_pr'])) {
      $own_pr = $_POST['own_pr'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'own_pr', $own_pr);
  }
  $own_pr = get_user_meta($user_id,'own_pr',false)[0];

  $result .= "コミュニティを更新しました。";
  $results = '
          <div class="um-field-label um-info-label-community">
              <label class="um-field-label-text"><i class="um-field-label-community"></i>コミュニティ</label>
              <span class="um-edit-btn um-edit-btn-community active" onclick="edit_community()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-community inactive">
          <div class="um-field-value">
                  <div class="um-field um-field-univ_community um-field-radio um-field-type_radio" data-key="univ_community"><div class="um-field-label"><label for="univ_community-1597">大学時代のコミュニティ</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$univ_community.'</div></div></div>
                  <div class="um-field um-field-community_univ um-field-textarea um-field-type_textarea" data-key="community_univ"><div class="um-field-label"><label for="community_univ-1597">サークル・部活・団体名</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value"><p>'.$community_univ.'</p></div></div></div>
                  <div class="um-field um-field-own_pr um-field-textarea um-field-type_textarea" data-key="own_pr"><div class="um-field-label"><label for="own_pr-1597">当コミュニティでどんなことをしたか？</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value"><p>'.$own_pr.'</p></div></div></div>
          </div>
          </div>
      ';


// echoで、クライアント側に返すデータを送信する
  echo $results;

  // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
  die();
}
add_action( 'wp_ajax_ajax_community', 'Ajax_Community' );
add_action( 'wp_ajax_nopriv_ajax_community', 'Ajax_Community' );

function Ajax_Intern(){
  $user_query = get_user_by('login',$_GET['um_user']);
  $user_id = um_profile_id();
  if(isset($_POST['internship_experiences'])) {
      $internship_experiences = $_POST['internship_experiences'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'internship_experiences', $internship_experiences);
  }
$internship_experiences = get_user_meta($user_id,'internship_experiences',false)[0][0];
  
  if(isset($_POST['internship_company'])) {
      $internship_company = $_POST['internship_company'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'internship_company', $internship_company);
  }
  $internship_company = get_user_meta($user_id,'internship_company',false)[0];
  
  if(isset($_POST['experience_internship'])) {
      $experience_internship = $_POST['experience_internship'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'experience_internship', $experience_internship);
  }
  $experience_internship = get_user_meta($user_id,'experience_internship',false)[0];
  
  if(isset($_POST['self_internship_PR'])) {
      $self_internship_PR = $_POST['self_internship_PR'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'self_internship_PR', $self_internship_PR);
  }
  $self_internship_PR = get_user_meta($user_id,'self_internship_PR',false)[0];
  
  if(isset($_POST['degree_of_internship_interest'])) {
      $degree_of_internship_interest = $_POST['degree_of_internship_interest'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'degree_of_internship_interest', $degree_of_internship_interest);
  }
  $degree_of_internship_interest = get_user_meta($user_id,'degree_of_internship_interest',false)[0];

  $result .= "長期インターンを更新しました。";
  $results = '
          <div class="um-field-label um-info-label-internship">
              <label class="um-field-label-text"><i class="um-field-label-internship"></i>長期インターン</label>
              <span class="um-edit-btn um-edit-btn-internship active" onclick="edit_internship()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-internship inactive">
          <div class="um-field-value">
                  <div class="um-field um-field-internship_experiences um-field-radio um-field-type_radio" data-key="internship_experiences"><div class="um-field-label"><label for="internship_experiences-1597">長期インターン経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$internship_experiences.'</div></div></div>
                  <div class="um-field um-field-internship_company um-field-textarea um-field-type_textarea" data-key="internship_company"><div class="um-field-label"><label for="internship_company-1597">長期インターン経験先企業名</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$internship_company.'</div></div></div>
                  <div class="um-field um-field-experience_internship um-field-textarea um-field-type_textarea" data-key="experience_internship"><div class="um-field-label"><label for="experience_internship-1597">長期インターン先でどんな経験をしたか？</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$experience_internship.'</div></div></div>
                  <div class="um-field um-field-self_internship_PR um-field-textarea um-field-type_textarea" data-key="self_internship_PR"><div class="um-field-label"><label for="self_internship_PR-1597">その他自己PR</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$self_internship_PR.'</div></div></div>
                  <div class="um-field um-field-degree_of_internship_interest um-field-select um-field-type_select" data-key="degree_of_internship_interest"><div class="um-field-label"><label for="degree_of_internship_interest-1597">長期有給インターンへの興味の度合い</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$degree_of_internship_interest.'</div></div></div>
          </div>
          </div>
      ';


// echoで、クライアント側に返すデータを送信する
  echo $results;

  // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
  die();
}
add_action( 'wp_ajax_ajax_intern', 'Ajax_Intern' );
add_action( 'wp_ajax_nopriv_ajax_intern', 'Ajax_Intern' );

function Ajax_Interest(){
  $user_query = get_user_by('login',$_GET['um_user']);
  $user_id = um_profile_id();
  if(isset($_POST['bussiness_type'])) {
      $bussiness_type = $_POST['bussiness_type'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'bussiness_type', $bussiness_type);
  }
  $bussiness_type = get_user_meta($user_id,'bussiness_type',false)[0];
  
  if(isset($_POST['future_occupations'])) {
      $future_occupations = $_POST['future_occupations'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'future_occupations', $future_occupations);
  }
  $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
  
  if(isset($_POST['will_venture'])) {
      $will_venture = $_POST['will_venture'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'will_venture', $will_venture);
  }
  $will_venture = get_user_meta($user_id,'will_venture',false)[0];

  if(isset($bussiness_type)) {
      foreach($bussiness_type as $type) {
        //echo $language;
        $types .= $type.'</br>';
      }
  }
  if(isset($future_occupations)) {
    foreach($future_occupations as $occupation) {
      $occupations .= $occupation.'</br>';
    }
  }

  $result .= "興味・関心を更新しました。";
  $results = '
          <div class="um-field-label um-info-label-interest">
              <label class="um-field-label-text"><i class="um-field-label-interest"></i>興味・関心</label>
              <span class="um-edit-btn um-edit-btn-interest active" onclick="edit_interest()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-interest inactive">
          <div class="um-field-value">
                  <div class="um-field um-field-bussiness_type um-field-checkbox um-field-type_checkbox" data-key="bussiness_type"><div class="um-field-label"><label for="bussiness_type-1597">興味のある業界</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$types.'</div></div></div>
                  <div class="um-field um-field-future_occupations um-field-checkbox um-field-type_checkbox" data-key="future_occupations"><div class="um-field-label"><label for="future_occupations-1597">職種</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$occupations.'</div></div></div>
                  <div class="um-field um-field-will_venture um-field-select um-field-type_select" data-key="will_venture"><div class="um-field-label"><label for="will_venture-1597">ベンチャーへの就職意欲</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$will_venture.'</div></div></div>
          </div>
          </div>
      ';



// echoで、クライアント側に返すデータを送信する
  echo $results;

  // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
  die();
}
add_action( 'wp_ajax_ajax_interest', 'Ajax_Interest' );
add_action( 'wp_ajax_nopriv_ajax_interest', 'Ajax_Interest' );

function Ajax_Experience(){
  $user_query = get_user_by('login',$_GET['um_user']);
  $user_id = um_profile_id();
  if(isset($_POST['student_experience'])) {
      $student_experience = $_POST['student_experience'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'student_experience', $student_experience);
  }
  $student_experience = get_user_meta( $user_id, 'student_experience',false)[0];
  if(isset($student_experience)) {
    foreach($student_experience as $exp) {
      $exps .= $exp.'</br>';
    }
  }

  $result .= "学生時代の経験を更新しました。";
  $results = '
          <div class="um-field-label um-info-label-experience">
              <label class="um-field-label-text"><i class="um-field-label-experience"></i>学生時代の経験</label>
              <span class="um-edit-btn um-edit-btn-experience active" onclick="edit_experience()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-experience inactive">
          <div class="um-field-value">
                  <div class="um-field um-field-student_experience um-field-checkbox um-field-type_checkbox" data-key="student_experience"><div class="um-field-label"><label for="student_experience-1597">学生時代の経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$exps.'</div></div></div>
          </div>
          </div>
      ';


// echoで、クライアント側に返すデータを送信する
  echo $results;

  // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
  die();
}
add_action( 'wp_ajax_ajax_experience', 'Ajax_Experience' );
add_action( 'wp_ajax_nopriv_ajax_experience', 'Ajax_Experience' );



function new_mypage_func(){
  //$user_name = $_GET["um_user"];
  //echo $user_name;
  //$user_query = get_user_by('login',$_GET['um_user']);
  //$user_id = $user_query->data->ID;
  $user_id = um_profile_id();
  //echo $profile_id;
  //echo $user_id;
  $user_role_ar = get_user_meta($user_id,'wp_146219050_capabilities',false)[0];
  $user_role = (array_keys($user_role_ar))[0];
  $timestamp = time();
  if(isset($_POST['region-6120'])) {
      $prefecture = $_POST['region-6120'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'region', $prefecture);
  }
  $prefecture  = get_user_meta($user_id,'region',false)[0];

  if(isset($_POST['highschool-6120'])) {
       $highschool = $_POST['highschool-6120'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'highschool', $highschool);
  }
  $highschool = get_user_meta($user_id,'highschool')[0];
  
  if(isset($_POST['gender'])) {
       $gender = $_POST['gender'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'gender', $gender);
  }
  $gender = get_user_meta($user_id,'gender',false)[0][0];
  
  if(isset($_POST['faculty_lineage'])) {
      $faculty_lineage = $_POST['faculty_lineage'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'faculty_lineage', $faculty_lineage);
  }
  $faculty_lineage = get_user_meta($user_id,'faculty_lineage',false)[0];
  
  if(isset($_POST['faculty_department-6120'])) {
      $faculty_department = $_POST['faculty_department-6120'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'faculty_department', $faculty_department);
  }
  $faculty_department = get_user_meta($user_id,'faculty_department',false)[0];
  
  if(isset($_POST['graduate_year'])) {
      $graduate_year = $_POST['graduate_year'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'graduate_year', $graduate_year);
  }
  $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
  
  if(isset($_POST['seminar-6120'])) {
      $seminar = $_POST['seminar-6120'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'seminar', $seminar);
  }
  $seminar = get_user_meta($user_id,'seminar',false)[0];
  
  if(isset($_POST['studied_abroad'])) {
      $studied_abroad = $_POST['studied_abroad'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'studied_abroad', $studied_abroad);
  }
  $studied_abroad = get_user_meta($user_id,'studied_abroad',false)[0][0];

  if(isset($_POST['studied_ab_place-6120'])) {
      $studied_ab_place = $_POST['studied_ab_place-6120'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'studied_ab_place', $studied_ab_place);
  }
  $studied_ab_place = get_user_meta($user_id,'studied_ab_place',false)[0];
  
  if(isset($_POST['lang_pr'])) {
      $lang_pr = $_POST['lang_pr'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'lang_pr', $lang_pr);
  }
  $lang_pr = get_user_meta($user_id,'lang_pr',false)[0];
  
  if(isset($_POST['experience_programming'])) {
      $experience_programming = $_POST['experience_programming'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'experience_programming', $experience_programming);
  }
  $experience_programming = get_user_meta($user_id,'experience_programming',false)[0][0];
  
  if(isset($_POST['programming_languages'])) {
      $programming_languages = $_POST['programming_languages'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'programming_languages', $programming_languages);
  }
  $programming_languages = get_user_meta($user_id,'programming_languages',false)[0];

  if(isset($_POST['framework'])) {
      $framework = $_POST['framework'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'framework', $framework);
  }
  $framework = get_user_meta($user_id,'framework',false)[0];

  if(isset($_POST['GitHub-6120'])) {
      $Github = $_POST['GitHub-6120'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'Github', $Github);
  }
  $Github = get_user_meta($user_id,'GitHub',false)[0];


  if(isset($_POST['experience_programming'])) {
      $experience_programming = $_POST['experience_programming'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'experience_programming', $experience_programming);
  }
  $experience_programming = get_user_meta($user_id,'experience_programming',false)[0][0];
  
  if(isset($_POST['skill_dev'])) {
      $skill_dev = $_POST['skill_dev'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'skill_dev', $skill_dev);
  }
  $skill_dev = get_user_meta($user_id,'skill_dev',false)[0];
  if(isset($skill_dev)) {
      foreach($skill_dev as $dev) {
        //echo $language;
        $devs .= $dev.'</br>' ;
      }
  }
  
   if(isset($_POST['skill_design'])) {
      $skill_design = $_POST['skill_design'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'skill_design', $skill_design);
  }
  $skill_design = get_user_meta($user_id,'skill_design',false)[0];
  if(isset($skill_design)) {
      foreach($skill_design as $design) {
        //echo $language;
        $designs .= $design.'</br>' ;
      }
  }

  if(isset($_POST['work'])) {
      $work = $_POST['work'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'work', $work);
  }
  $work = get_user_meta($user_id,'work',false)[0];

  if(isset($_POST['skill'])) {
      $skill = $_POST['skill'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'skill', $skill);
  }
$skill = get_user_meta($user_id,'skill',false)[0];

  if(isset($_POST['univ_community'])) {
      $univ_community = $_POST['univ_community'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'univ_community', $univ_community);
  }
  $univ_community = get_user_meta($user_id,'univ_community',false)[0][0];
  
  if(isset($_POST['community_univ'])) {
      $community_univ = $_POST['community_univ'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'community_univ', $community_univ);
  }
  $community_univ = get_user_meta($user_id,'community_univ',false)[0];
  
  if(isset($_POST['own_pr'])) {
      $own_pr = $_POST['own_pr'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'own_pr', $own_pr);
  }
  $own_pr = get_user_meta($user_id,'own_pr',false)[0];

  if(isset($_POST['internship_experiences'])) {
      $internship_experiences = $_POST['internship_experiences'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'internship_experiences', $internship_experiences);
  }
$internship_experiences = get_user_meta($user_id,'internship_experiences',false)[0][0];
  
  if(isset($_POST['internship_company'])) {
      $internship_company = $_POST['internship_company'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'internship_company', $internship_company);
  }
  $internship_company = get_user_meta($user_id,'internship_company',false)[0];
  
  if(isset($_POST['experience_internship'])) {
      $experience_internship = $_POST['experience_internship'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'experience_internship', $experience_internship);
  }
  $experience_internship = get_user_meta($user_id,'experience_internship',false)[0];
  
  if(isset($_POST['self_internship_PR'])) {
      $self_internship_PR = $_POST['self_internship_PR'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'self_internship_PR', $self_internship_PR);
  }
  $self_internship_PR = get_user_meta($user_id,'self_internship_PR',false)[0];
  
  if(isset($_POST['degree_of_internship_interest'])) {
      $degree_of_internship_interest = $_POST['degree_of_internship_interest'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'degree_of_internship_interest', $degree_of_internship_interest);
  }
  $degree_of_internship_interest = get_user_meta($user_id,'degree_of_internship_interest',false)[0];
  
  if(isset($_POST['bussiness_type'])) {
      $bussiness_type = $_POST['bussiness_type'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'bussiness_type', $bussiness_type);
  }
  $bussiness_type = get_user_meta($user_id,'bussiness_type',false)[0];
  
  if(isset($_POST['future_occupations'])) {
      $future_occupations = $_POST['future_occupations'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'future_occupations', $future_occupations);
  }
  $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
  
  if(isset($_POST['will_venture'])) {
      $will_venture = $_POST['will_venture'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'will_venture', $will_venture);
  }
  $will_venture = get_user_meta($user_id,'will_venture',false)[0];

  if(isset($bussiness_type)) {
      foreach($bussiness_type as $type) {
        //echo $language;
        $types .= $type.'</br>';
      }
  }
  if(isset($future_occupations)) {
    foreach($future_occupations as $occupation) {
      $occupations .= $occupation.'</br>';
    }
  }
  
 if(isset($_POST['student_experience'])) {
      $student_experience = $_POST['student_experience'];
      // Update/Create User Meta
      update_user_meta( $user_id, 'student_experience', $student_experience);
  }
  $student_experience = get_user_meta( $user_id, 'student_experience',false)[0];
  if(isset($student_experience)) {
    foreach($student_experience as $exp) {
      $exps .= $exp.'</br>';
    }
  }
  
  $languages = "";
   if(isset($_POST['programming_lang_lv_c'])) {
    $programming_lang_lv_c = $_POST['programming_lang_lv_c'];
    update_user_meta( $user_id, 'programming_lang_lv_c', $programming_lang_lv_c);
  }
  $programming_lang_lv_c = get_user_meta($user_id,'programming_lang_lv_c',false)[0];
  if($programming_lang_lv_c > 0 and in_array("C言語", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_c um-field-rating um-field-type_rating" data-key="programming_lang_lv_c" style="display:none;"><div class="um-field-label"><label for="programming_lang_lv_c-6120">C言語のレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_c" data-key="programming_lang_lv_c" data-number="5" data-score="'.$programming_lang_lv_c.'" title="'.$programming_lang_lv_c.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_cpp'])) {
    $programming_lang_lv_cpp = $_POST['programming_lang_lv_cpp'];
    update_user_meta( $user_id, 'programming_lang_lv_cpp', $programming_lang_lv_cpp);
  }
  $programming_lang_lv_cpp = get_user_meta($user_id,'programming_lang_lv_cpp',false)[0];
  if($programming_lang_lv_cpp > 0 and in_array("C++", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_cpp um-field-rating um-field-type_rating" data-key="programming_lang_lv_cpp"><div class="um-field-label"><label for="programming_lang_lv_cpp-6120">C++のレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_cpp" data-key="programming_lang_lv_cpp" data-number="5" data-score="'.$programming_lang_lv_cpp.'" title="'.$programming_lang_lv_cpp.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_cs'])) {
    $programming_lang_lv_cs = $_POST['programming_lang_lv_cs'];
    update_user_meta( $user_id, 'programming_lang_lv_cs', $programming_lang_lv_cs);
  }
  $programming_lang_lv_cs = get_user_meta($user_id,'programming_lang_lv_cs',false)[0];
  if($programming_lang_lv_cs > 0 and in_array("C#", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_cs um-field-rating um-field-type_rating" data-key="programming_lang_lv_cs"><div class="um-field-label"><label for="programming_lang_lv_cs-6120">C#のレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_cs" data-key="programming_lang_lv_cs" data-number="5" data-score="'.$programming_lang_lv_cs.'" title="'.$programming_lang_lv_cs.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_m'])) {
    $programming_lang_lv_m = $_POST['programming_lang_lv_m'];
    update_user_meta( $user_id, 'programming_lang_lv_m', $programming_lang_lv_m);
  }
  $programming_lang_lv_m = get_user_meta($user_id,'programming_lang_lv_m',false)[0];
  if($programming_lang_lv_m > 0 and in_array("Objective-C", $programming_languages)) {
    $languages .='<div class="um-field um-field-programming_lang_lv_m um-field-rating um-field-type_rating" data-key="programming_lang_lv_m"><div class="um-field-label"><label for="programming_lang_lv_m-6120">Object-Cのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_m" data-key="programming_lang_lv_m" data-number="5" data-score="'.$programming_lang_lv_m.'" title="'.$programming_lang_lv_m.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_java'])) {
    $programming_lang_lv_java = $_POST['programming_lang_lv_java'];
    update_user_meta( $user_id, 'programming_lang_lv_java', $programming_lang_lv_java);
  }
  $programming_lang_lv_java = get_user_meta($user_id,'programming_lang_lv_java',false)[0];
  if($programming_lang_lv_java > 0 and in_array("Java", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_java um-field-rating um-field-type_rating" data-key="programming_lang_lv_java"><div class="um-field-label"><label for="programming_lang_lv_java-6120">Javaのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_java" data-key="programming_lang_lv_java" data-number="5" data-score="'.$programming_lang_lv_java.'" title="'.$programming_lang_lv_java.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_js'])) {
    $programming_lang_lv_js = $_POST['programming_lang_lv_js'];
    update_user_meta( $user_id, 'programming_lang_lv_js', $programming_lang_lv_js);
  }
  $programming_lang_lv_js = get_user_meta($user_id,'programming_lang_lv_js',false)[0];
  if($programming_lang_lv_js > 0 and in_array("JavaScript", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_js um-field-rating um-field-type_rating" data-key="programming_lang_lv_js"><div class="um-field-label"><label for="programming_lang_lv_js-6120">JavaScriptのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_js" data-key="programming_lang_lv_js" data-number="5" data-score="'.$programming_lang_lv_js.'" title="'.$programming_lang_lv_js.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_py'])) {
    $programming_lang_lv_py = $_POST['programming_lang_lv_py'];
    update_user_meta( $user_id, 'programming_lang_lv_py', $programming_lang_lv_py);
  }
  $programming_lang_lv_py = get_user_meta($user_id,'programming_lang_lv_py',false)[0];
  if($programming_lang_lv_py > 0 and in_array("Python", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_py um-field-rating um-field-type_rating" data-key="programming_lang_lv_py"><div class="um-field-label"><label for="programming_lang_lv_py-6120">Pythonのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_py" data-key="programming_lang_lv_py" data-number="5" data-score="'.$programming_lang_lv_py.'" title="'.$programming_lang_lv_py.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_php'])) {
    $programming_lang_lv_php = $_POST['programming_lang_lv_php'];
    update_user_meta( $user_id, 'programming_lang_lv_php', $programming_lang_lv_php);
  }
  $programming_lang_lv_php = get_user_meta($user_id,'programming_lang_lv_php',false)[0];
  if($programming_lang_lv_php > 0 and in_array("PHP", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_php um-field-rating um-field-type_rating" data-key="programming_lang_lv_php"><div class="um-field-label"><label for="programming_lang_lv_php-6120">PHPのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_php" data-key="programming_lang_lv_php" data-number="5" data-score="'.$programming_lang_lv_php.'" title="'.$programming_lang_lv_php.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_pl'])) {
    $programming_lang_lv_pl = $_POST['programming_lang_lv_pl'];
    update_user_meta( $user_id, 'programming_lang_lv_pl', $programming_lang_lv_pl);
  }
  $programming_lang_lv_pl = get_user_meta($user_id,'programming_lang_lv_pl',false)[0];
  if($programming_lang_lv_pl > 0 and in_array("Perl", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_pl um-field-rating um-field-type_rating" data-key="programming_lang_lv_pl"><div class="um-field-label"><label for="programming_lang_lv_pl-6120">Perlのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_pl" data-key="programming_lang_lv_pl" data-number="5" data-score="'.$programming_lang_lv_pl.'" title="'.$programming_lang_lv_pl.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_rb'])) {
    $programming_lang_lv_rb = $_POST['programming_lang_lv_rb'];
    update_user_meta( $user_id, 'programming_lang_lv_rb', $programming_lang_lv_rb);
  }
  $programming_lang_lv_rb = get_user_meta($user_id,'programming_lang_lv_rb',false)[0];
  if($programming_lang_lv_rb > 0 and in_array("Ruby", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_rb um-field-rating um-field-type_rating" data-key="programming_lang_lv_rb"><div class="um-field-label"><label for="programming_lang_lv_rb-6120">Rubyのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_rb" data-key="programming_lang_lv_rb" data-number="5" data-score="'.$programming_lang_lv_rb.'" title="'.$programming_lang_lv_rb.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_go'])) {
    $programming_lang_lv_go = $_POST['programming_lang_lv_go'];
    update_user_meta( $user_id, 'programming_lang_lv_go', $programming_lang_lv_go);
  }
  $programming_lang_lv_go = get_user_meta($user_id,'programming_lang_lv_go',false)[0];
  if($programming_lang_lv_go > 0 and in_array("Go", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_go um-field-rating um-field-type_rating" data-key="programming_lang_lv_go"><div class="um-field-label"><label for="programming_lang_lv_go-6120">Goのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_go" data-key="programming_lang_lv_cpp" data-number="5" data-score="'.$programming_lang_lv_go.'" title="'.$programming_lang_lv_go.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_swift'])) {
    $programming_lang_lv_swift = $_POST['programming_lang_lv_swift'];
    update_user_meta( $user_id, 'programming_lang_lv_swift', $programming_lang_lv_swift);
  }
  $programming_lang_lv_swift = get_user_meta($user_id,'programming_lang_lv_swift',false)[0];
  if($programming_lang_lv_swift > 0 and in_array("Swift", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_swift um-field-rating um-field-type_rating" data-key="programming_lang_lv_swift"><div class="um-field-label"><label for="programming_lang_lv_swift-6120">Swiftのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_swift" data-key="programming_lang_lv_swift" data-number="5" data-score="'.$programming_lang_lv_swift.'" title="'.$programming_lang_lv_swift.'"></div>
                                  </div></div></div>';
  }
  if(isset($_POST['programming_lang_lv_vb'])) {
    $programming_lang_lv_vb = $_POST['programming_lang_lv_vb'];
    update_user_meta( $user_id, 'programming_lang_lv_vb', $programming_lang_lv_vb);
  }
  $programming_lang_lv_vb = get_user_meta($user_id,'programming_lang_lv_vb',false)[0];
  if($programming_lang_lv_vb > 0 and in_array("Visual Basic", $programming_languages)) {
    $languages .='<div class=" um-field-programming_lang_lv_vb um-field-rating um-field-type_rating" data-key="programming_lang_lv_vb"><div class="um-field-label"><label for="programming_lang_lv_vb-6120">Visual Basicのレベル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">
                                      <div class="um-rating-readonly um-raty" id="programming_lang_lv_vb" data-key="programming_lang_lv_vb" data-number="5" data-score="'.$programming_lang_lv_vb.'" title="'.$programming_lang_lv_vb.'"></div>
                                  </div></div></div>';
  }
  



  $html='
<!-- これより上はclassとdivが被っているので不要 -->
<div class="um-profile-infomation">
  <div class="um-info">
      <div class="um-field um-field-profile" id="base">
          <div class="um-field-label um-info-label-base">
              <label class="um-field-label-text"><i class="um-field-label-base"></i>基本情報</label>
              <span class="um-edit-btn um-edit-btn-base" onclick="edit_base()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-base">
          <div class="um-field-value">
                  <div class="um-field um-field-region um-field-text um-field-type_text" data-key="region"><div class="um-field-label"><label for="region-6120">都道府県</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$prefecture.'</div></div></div>
                  <div class="um-field um-field-gender um-field-radio um-field-type_radio" data-key="gender"><div class="um-field-label"><label for="gender-6120">性別</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$gender.'</div></div></div>
                  <div class="um-field um-field-highschool um-field-text um-field-type_text" data-key="highschool"><div class="um-field-label"><label for="highschool-6120">出身高校</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$highschool.'</div></div></div>
          </div>
          </div>
          
          </div>
      <div class="um-editor um-editor-base">
          <form method="post" id="testform">
          <div class="um-field um-field-region um-field-text um-field-type_text" data-key="region">
              <div class="um-field-label"><label for="region-6120">都道府県</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><input autocomplete="off" class="um-form-field valid not-required " type="text" name="region-6120" id="region-6120" value="'.$prefecture.'" placeholder="" data-validate="" data-key="region"><p></p></div>
              </div>
          <div class="um-field um-field-gender um-field-radio um-field-type_radio" data-key="gender">
              <div class="um-field-label"><label for="gender-6120">性別</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><label class="um-field-radio um-field-half "><input type="radio" name="gender[]" value="男性"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">男性</span></label><label class="um-field-radio  um-field-half right"><input type="radio" name="gender[]" value="女性"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">女性</span></label><p></p>
              <div class="um-clear"></div>
              <div class="um-clear"></div>
              </div>
              </div>
          <div class="um-field um-field-highschool um-field-text um-field-type_text" data-key="highschool">
              <div class="um-field-label"><label for="highschool-6120">出身高校</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><input autocomplete="off" class="um-form-field valid not-required " type="text" name="highschool-6120" id="highschool-6120" value="'.$highschool.'" placeholder="" data-validate="" data-key="highschool"><p></p></div>
              </div>
          <div class="um-editor-btn">
              <input type="submit" value="更新" class="um-editor-update2">
              <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
          </div>
          </form>
      </div>
      <div class="result_area" id="resultarea"></div>
  </div>


  <div class="um-info">
      <div class="um-field um-field-profile"  id="univ">
          <div class="um-field-label um-info-label-univ">
              <label class="um-field-label-text"><i class="um-field-label-univ"></i>学歴</label>
              <span class="um-edit-btn um-edit-btn-univ" onclick="edit_univ()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-univ">
          <div class="um-field-value">
                  <div class="um-field um-field-faculty_lineage um-field-select um-field-type_select" data-key="faculty_lineage"><div class="um-field-label"><label for="faculty_lineage-1597">学部系統</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$faculty_lineage.'</div></div></div>
                  <div class="um-field um-field-faculty_department um-field-text um-field-type_text" data-key="faculty_department"><div class="um-field-label"><label for="faculty_department-1597">学部・学科</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$faculty_department.'</div></div></div>
                  <div class="um-field um-field-graduate_year um-field-select um-field-type_select" data-key="graduate_year"><div class="um-field-label"><label for="graduate_year-1597">卒業年</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$graduate_year.'</div></div></div>
                  <div class="um-field um-field-seminar um-field-text um-field-type_text" data-key="seminar"><div class="um-field-label"><label for="seminar-1597">ゼミ</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$seminar.'</div></div></div>
          </div>
          </div>
          </div>
      <div class="um-editor um-editor-univ">
      <form method="post" id="testform2">
          <div class="um-field um-field-faculty_lineage um-field-select um-field-type_select" data-key="faculty_lineage">
              <div class="um-field-label"><label for="faculty_lineage-6120">学部系統<span class="um-req" title="必須">*</span></label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><select data-default="" name="faculty_lineage" id="faculty_lineage" data-validate="" data-key="faculty_lineage" class="um-form-field valid um-s1  select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="文・人文">文・人文</option><option value="社会・国際">社会・国際</option><option value="法・政治">法・政治</option><option value="経済・経営・商">経済・経営・商</option><option value="教育">教育</option><option value="理">理</option><option value="工">工</option><option value="農">農</option><option value="医・歯・薬・保健">医・歯・薬・保健</option><option value="生活科学">生活科学</option><option value="芸術">芸術</option><option value="スポーツ科学">スポーツ科学</option><option value="総合・環境・情報・人間">総合・環境・情報・人間</option></select>
              </div>
              </div>
          <div class="um-field um-field-faculty_department um-field-text um-field-type_text" data-key="faculty_department">
              <div class="um-field-label"><label for="faculty_department-1597">学部・学科<span class="um-req" title="必須">*</span></label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="faculty_department-6120" id="faculty_department-6120" value="'.$faculty_department.'" placeholder="" data-validate="" data-key="faculty_department"><p></p></div>
              </div>
          <div class="um-field um-field-graduate_year um-field-select um-field-type_select" data-key="graduate_year">
              <div class="um-field-label"><label for="graduate_year-6120">卒業年</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><select data-default="" name="graduate_year" id="graduate_year" data-validate="" data-key="graduate_year" class="um-form-field valid not-required um-s1  select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="その他">その他</option></select>
              </div>
              </div>
          <div class="um-field um-field-seminar um-field-text um-field-type_text" data-key="seminar">
              <div class="um-field-label"><label for="seminar-6120">ゼミ<span class="um-req" title="必須">*</span></label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="seminar-6120" id="seminar-6120" value="'.$seminar.'" placeholder="" data-validate="" data-key="seminar"><p></p></div>
              </div>
          <div class="um-editor-btn">
              <input type="submit" value="更新" class="um-editor-update2">
              <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
          </div>
      </form>
      </div>
      <div class="result_area" id="resultarea2"></div>
  </div>
  
  <div class="um-info">
      <div class="um-field um-field-profile" id="abroad">
          <div class="um-field-label um-info-label-abroad">
              <label class="um-field-label-text"><i class="um-field-label-abroad"></i>留学</label>
              <span class="um-edit-btn um-edit-btn-abroad" onclick="edit_abroad()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-abroad">
          <div class="um-field-value">
                  <div class="um-field um-field-studied_abroad um-field-radio um-field-type_radio" data-key="studied_abroad"><div class="um-field-label"><label for="studied_abroad-1597">留学経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$studied_abroad.'</div></div></div>
                  <div class="um-field um-field-studied_ab_place um-field-text um-field-type_text" data-key="studied_ab_place"><div class="um-field-label"><label for="studied_ab_place-1597">留学先</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$studied_ab_place.'</div></div></div>
                  <div class="um-field um-field-lang_pr um-field-textarea um-field-type_textarea" data-key="lang_pr">  <div class="um-field-label"><label for="lang_pr-1597">その他</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$lang_pr.'</div></div></div>
          </div>
          </div>
          </div>
      <div class="um-editor um-editor-abroad">
      <form method="post" id="testform3">
          <div class="um-field um-field-studied_abroad um-field-radio um-field-type_radio" data-key="studied_abroad">
              <div class="um-field-label"><label for="studied_abroad-1597">留学経験</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><label class="um-field-radio um-field-half "><input type="radio" name="studied_abroad[]" value="経験なし"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">経験なし</span></label><label class="um-field-radio um-field-half right"><input type="radio" name="studied_abroad[]" value="3ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">3ヶ月未満</span></label><p></p>
              <div class="um-clear"></div><p><label class="um-field-radio um-field-half "><input type="radio" name="studied_abroad[]" value="３ヶ月以上６ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">３ヶ月以上６ヶ月未満</span></label><label class="um-field-radio um-field-half right"><input type="radio" name="studied_abroad[]" value="６ヶ月以上1年未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">６ヶ月以上1年未満</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-radio um-field-half "><input type="radio" name="studied_abroad[]" value="１年以上"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">１年以上</span></label></p>
              <div class="um-clear"></div>
              </div>
              </div>
          <div class="um-field um-field-studied_ab_place um-field-text um-field-type_text" data-key="studied_ab_place">
              <div class="um-field-label"><label for="studied_ab_place-1597">留学先</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><input autocomplete="off" class="um-form-field valid not-required " type="text" name="studied_ab_place-6120" id="studied_ab_place-1597" value="'.$studied_ab_place.'" placeholder="" data-validate="" data-key="studied_ab_place"><p></p></div>
              </div>
          <div class="um-field um-field-lang_pr um-field-textarea um-field-type_textarea" data-key="lang_pr">
              <div class="um-field-label"><label for="lang_pr-1597">その他</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div id="wp-lang_pr-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                      <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 50px; overflow: auto;" autocomplete="off" cols="40" name="lang_pr" id="lang_pr" aria-hidden="true">'.$lang_pr.'</textarea>
                  </div><p><span class="description">TOEIC点数などPR事項あれば記入してください</span></p></div>
              </div>
          <div class="um-editor-btn">
              <input type="submit" value="更新" class="um-editor-update2">
              <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
          </div>
          </form>
      </div>
      <div class="result_area" id="resultarea3"></div>
  </div>
  <div class="um-info">
      <div class="um-field um-field-profile" id="programming">
          <div class="um-field-label um-info-label-programming">
              <label class="um-field-label-text"><i class="um-field-label-programming"></i>プログラミング</label>
              <span class="um-edit-btn um-edit-btn-programming" onclick="edit_programming()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-programming">
          <div class="um-field-value">
          
                  <div class="um-field um-field-experience_programming um-field-radio um-field-type_radio" data-key="experience_programming"><div class="um-field-label"><label for="experience_programming-1597">プログラミング経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$experience_programming.'</div></div></div>'.$languages.'
                  <div class="um-field um-field-framework um-field-textarea um-field-type_textarea" data-key="framework"><div class="um-field-label"><label for="framework-1597">使用したことのあるフレームワーク・ライブラリ</label><p></p><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$framework.'</div></div></div>
                  <div class="um-field um-field-GitHub um-field-url um-field-type_url" data-key="GitHub"><div class="um-field-label"><label for="GitHub-1597">GitHubアカウント</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$Github.'</div></div></div>
                  <div class="um-field um-field-skill_dev um-field-multiselect um-field-type_multiselect" data-key="skill_dev"><div class="um-field-label"><label for="skill_dev-1597">開発ソフトのスキル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$devs.'</div></div></div>
                  <div class="um-field um-field-skill_design um-field-multiselect um-field-type_multiselect" data-key="skill_design"><div class="um-field-label"><label for="skill_design-1597">使えるデザイン系アプリケーション</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$designs.'</div></div></div>
                  <div class="um-field um-field-work um-field-textarea um-field-type_textarea" data-key="work"><div class="um-field-label"><label for="">プログラミング実務経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$work.'</div></div></div>
          </div>
          </div>
          </div>
      <div class="um-editor um-editor-programming">
      <form method="post" id="testform4">
          <div class="um-field um-field-experience_programming um-field-radio um-field-type_radio" data-key="experience_programming">
              <div class="um-field-label"><label for="experience_programming-6120">プログラミング経験<span class="um-req" title="必須">*</span></label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><label class="um-field-radio  um-field-half "><input type="radio" name="experience_programming[]" value="経験なし"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">経験なし</span></label><label class="um-field-radio um-field-half right"><input type="radio" name="experience_programming[]" value="経験あり"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">経験あり</span></label><p></p>
              <div class="um-clear"></div>
              <div class="um-clear"></div>
              </div>
              </div>
              <div class="um-field um-field-programming_languages um-field-multiselect um-field-type_multiselect" data-key="programming_languages"><div class="um-field-label"><label for="programming_languages-6120">使えるプログラミング言語</label><div class="um-clear"></div></div><div class="um-field-area  "><select multiple="multiple" name="programming_languages[]" id="programming_languages" data-maxsize="0" data-validate="" data-key="programming_languages" class="um-form-field valid not-required um-s1 um-user-keyword_0 select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="C言語">C言語</option><option value="C++">C++</option><option value="C#">C#</option><option value="Go">Go</option><option value="Java">Java</option><option value="JavaScript">JavaScript</option><option value="Objective-C">Objective-C</option><option value="Perl">Perl</option><option value="PHP">PHP</option><option value="Python">Python</option><option value="Ruby">Ruby</option><option value="Swift">Swift</option><option value="Visual Basic">Visual Basic</option></select></div></div>
          
          <div class="um-field um-field-programming_lang_lv_c um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="C言語" id="C言語" data-key="programming_lang_lv_c" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_c-6120">C言語のレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_c" data-key="programming_lang_lv_c" data-number="5" data-score="'.$programming_lang_lv_c.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_cpp um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="C++" id="C++" data-key="programming_lang_lv_cpp" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_cpp-1597">C++のレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_cpp" data-key="programming_lang_lv_cpp" data-number="5" data-score="'.$programming_lang_lv_cpp.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_cs um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="C#"  id="C#" data-key="programming_lang_lv_cs" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_cs-1597">C#のレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_cs" data-key="programming_lang_lv_cs" data-number="5" data-score="'.$programming_lang_lv_cs.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_m um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="Objective-C" id="Objective-C" data-key="programming_lang_lv_m" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_m-1597">Objective-Cのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_m" data-key="programming_lang_lv_m" data-number="5" data-score="'.$programming_lang_lv_m.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_java um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="Java" id="Java" data-key="programming_lang_lv_java" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_java-1597">Javaのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_java" data-key="programming_lang_lv_java" data-number="5" data-score="'.$programming_lang_lv_java.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_js um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="JavaScript"  id="JavaScript" data-key="programming_lang_lv_js" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_js-1597">JavaScriptのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_js" data-key="programming_lang_lv_js" data-number="5" data-score="'.$programming_lang_lv_js.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_py um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="Python" id="Python" data-key="programming_lang_lv_py" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_py-1597">Pythonのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_py" data-key="programming_lang_lv_py" data-number="5" data-score="'.$programming_lang_lv_py.'" style="cursor: pointer;"><input name="programming_lang_lv_py" type="hidden" value="'.$programming_lang_lv_py.'"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_php um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="PHP" id="PHP" data-key="programming_lang_lv_php" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_php-1597">PHPのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_php" data-key="programming_lang_lv_php" data-number="5" data-score="'.$programming_lang_lv_php.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_pl um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="Perl"  id="Perl" data-key="programming_lang_lv_pl" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_pl-1597">Perlのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_pl" data-key="programming_lang_lv_pl" data-number="5" data-score="'.$programming_lang_lv_pl.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_rb um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="Ruby"  id="Ruby" data-key="programming_lang_lv_rb" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_rb-1597">Rubyのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_rb" data-key="programming_lang_lv_rb" data-number="5" data-score="'.$programming_lang_lv_rb.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_go um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="Go"  id="Go" data-key="programming_lang_lv_go" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_go-1597">Goのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_go" data-key="programming_lang_lv_go" data-number="5" data-score="'.$programming_lang_lv_go.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_swift um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="Swift"  id="Swift" data-key="programming_lang_lv_swift" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_swift-1597">Swiftのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_swift" data-key="programming_lang_lv_swift" data-number="5" data-score="'.$programming_lang_lv_swift.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-is-conditional um-field-programming_lang_lv_vb um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="Visual Basic"  id="Basic" data-key="programming_lang_lv_vb" style="display:none;">
              <div class="um-field-label"><label for="programming_lang_lv_vb-1597">Visual Basicのレベル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div class="um-rating um-raty" id="programming_lang_lv_vb" data-key="programming_lang_lv_vb" data-number="5" data-score="'.$programming_lang_lv_vb.'" style="cursor: pointer;"></div>
              </div>
              </div>
          <div class="um-field um-field-framework um-field-textarea um-field-type_textarea" data-key="framework">
              <div class="um-field-label"><label for="framework-1597">使用したことのあるフレームワーク・ライブラリ</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div id="wp-framework-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                  <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="framework" id="framework" aria-hidden="true">'.$framework.'</textarea>
              </div><p><span class="description"></span></p></div>
          </div>
          <div class="um-field um-field-GitHub um-field-url um-field-type_url" data-key="GitHub">
              <div class="um-field-label"><label for="GitHub-6120">GitHubアカウント</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><input class="um-form-field valid not-required " type="text" name="GitHub-6120" id="GitHub-1597" value="'.$Github.'" placeholder="" data-validate="" data-key="GitHub"><p></p></div>
              </div>
          <div class="um-field um-field-skill_dev um-field-multiselect um-field-type_multiselect" data-key="skill_dev">
              <div class="um-field-label"><label for="skill_dev-1597">開発ソフトのスキル</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><select multiple="" name="skill_dev[]" id="skill_dev" data-maxsize="0" data-validate="" data-key="skill_dev" class="um-form-field valid not-required um-s1  um-user-keyword_0 select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="Unity">Unity</option><option value="Blender">Blender</option><option value="3Dプリンター">3Dプリンター</option><option value="建築CAD">建築CAD</option><option value="土木CAD">土木CAD</option><option value="機械CAD">機械CAD</option><option value="電気CAD">電気CAD</option><option value="Microsoft Office Word">Microsoft Office Word</option><option value="Microsoft Office Excel">Microsoft Office Excel</option><option value="Microsoft Office PowerPoint">Microsoft Office PowerPoint</option></select>
              </div>
              </div>
          <div class="um-field um-field-skill_design um-field-multiselect um-field-type_multiselect" data-key="skill_design">
              <div class="um-field-label"><label for="skill_design-1597">使えるデザイン系アプリケーション</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><select multiple="" name="skill_design[]" id="skill_design" data-maxsize="0" data-validate="" data-key="skill_design" class="um-form-field valid not-required um-s1  um-user-keyword_0 select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="Adobe Illustrator">Adobe Illustrator</option><option value="Adobe Photoshop">Adobe Photoshop</option><option value="After Effects">After Effects</option><option value="Premire">Premire</option><option value="CINEMA 4D">CINEMA 4D</option><option value="Maya">Maya</option></select>
              </div>
              </div>
          <div class="um-field um-field-work um-field-textarea um-field-type_textarea" data-key="work">
              <div class="um-field-label"><label for="">プログラミング実務経験</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div id="wp-work-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                  <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="work" id="work" aria-hidden="true">'.$work.'</textarea>
              </div><p><span class="description"></span></p></div>
          </div>
          <div class="um-editor-btn">
              <input type="submit" value="更新" class="um-editor-update2">
              <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
          </div>
      </form>
      </div>
      <div class="result_area" id="resultarea4"></div>
  </div>
  <div class="um-info">
      <div class="um-field um-field-profile"  id="skills">
          <div class="um-field-label um-info-label-skill">
              <label class="um-field-label-text"><i class="um-field-label-skill"></i>資格・その他スキル</label>
              <span class="um-edit-btn um-edit-btn-skill" onclick="edit_skill()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-skill">
          <div class="um-field-value">
                  <div class="um-field um-field-skill um-field-textarea um-field-type_textarea" data-key="skill"><div class="um-field-label"><label for="skill-1597">資格・その他スキル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$skill.'</div></div></div>
          </div>
          </div>
          </div>
      <div class="um-editor um-editor-skill">
      <form method="post" id="testform5">
          <div class="um-field um-field-skill um-field-textarea um-field-type_textarea" data-key="skill">
<div class="um-field-label"><label for="skill">資格・その他スキル</label><span class="um-tip um-tip-w" original-title="その他のスキルや、特にアピールしたいポイントを記入してください。"><i class="um-icon-help-circled"></i></span><p></p>
<div class="um-clear"></div>
</div>
<div class="um-field-area">
<div id="wp-skill-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
<textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="skill" id="skill" aria-hidden="true">'.$skill.'</textarea>
</div><p><span class="description"></span></p></div>
</div>
          <div class="um-editor-btn">
              <input type="submit" value="更新" class="um-editor-update2">
              <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
          </div>
      </form>
      </div>
      <div class="result_area" id="resultarea5"></div>
  </div>
  
  <div class="um-info">
      <div class="um-field um-field-profile"  id="community">
          <div class="um-field-label um-info-label-community">
              <label class="um-field-label-text"><i class="um-field-label-community"></i>コミュニティ</label>
              <span class="um-edit-btn um-edit-btn-community" onclick="edit_community()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-community">
          <div class="um-field-value">
                  <div class="um-field um-field-univ_community um-field-radio um-field-type_radio" data-key="univ_community"><div class="um-field-label"><label for="univ_community-1597">大学時代のコミュニティ</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$univ_community.'</div></div></div>
                  <div class="um-field um-field-community_univ um-field-textarea um-field-type_textarea" data-key="community_univ"><div class="um-field-label"><label for="community_univ-1597">サークル・部活・団体名</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value"><p>'.$community_univ.'</p></div></div></div>
                  <div class="um-field um-field-own_pr um-field-textarea um-field-type_textarea" data-key="own_pr"><div class="um-field-label"><label for="own_pr-1597">当コミュニティでどんなことをしたか？</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value"><p>'.$own_pr.'</p></div></div></div>
          </div>
          </div>
          </div>
      <div class="um-editor um-editor-community">
      <form method="post" id="testform6">
          <div class="um-field um-field-univ_community um-field-radio um-field-type_radio" data-key="univ_community">
              <div class="um-field-label"><label for="univ_community">大学時代のコミュニティ<span class="um-req" title="必須">*</span></label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><label class="um-field-radio  um-field-half"><input type="radio" name="univ_community[]" value="文化系サークル"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">文化系サークル</span></label><label class="um-field-radio  um-field-half right"><input type="radio" name="univ_community[]" value="スポーツ系サークル"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">スポーツ系サークル</span></label><p></p>
              <div class="um-clear"></div><p><label class="um-field-radio  um-field-half"><input type="radio" name="univ_community[]" value="体育会系部活"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">体育会系部活</span></label><label class="um-field-radio  um-field-half right"><input type="radio" name="univ_community[]" value="文化系部活"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">文化系部活</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-radio  um-field-half"><input type="radio" name="univ_community[]" value="学生団体"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">学生団体</span></label><label class="um-field-radio  um-field-half right"><input type="radio" name="univ_community[]" value="当てはまらない"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">当てはまらない</span></label></p>
              <div class="um-clear"></div>
              <div class="um-clear"></div>
              </div>
              </div>
          <div class="um-field um-field-community_univ um-field-textarea um-field-type_textarea" data-key="community_univ">
              <div class="um-field-label"><label for="community_univ">サークル・部活・団体名</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div id="wp-community_univ-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                  <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 50px; overflow: auto;" autocomplete="off" cols="40" name="community_univ" id="community_univ" aria-hidden="true">'.$community_univ.'</textarea>
              </div><p><span class="description"></span></p></div>
              </div>
          <div class="um-field um-field-own_pr um-field-textarea um-field-type_textarea" data-key="own_pr">
              <div class="um-field-label"><label for="own_pr">当コミュニティでどんなことをしたか？</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div id="wp-own_pr-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                  <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="own_pr" id="own_pr" aria-hidden="true">'.$own_pr.'</textarea>
              </div><p><span class="description"></span></p></div>
              </div>
          <div class="um-editor-btn">
              <input type="submit" value="更新" class="um-editor-update2">
              <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
          </div>
      </form>
      </div>
      <div class="result_area" id="resultarea6"></div>
  </div>
  
  <div class="um-info">
      <div class="um-field um-field-profile" id="intern">
          <div class="um-field-label um-info-label-internship">
              <label class="um-field-label-text"><i class="um-field-label-internship"></i>長期インターン</label>
              <span class="um-edit-btn um-edit-btn-internship" onclick="edit_internship()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-internship">
          <div class="um-field-value">
                  <div class="um-field um-field-internship_experiences um-field-radio um-field-type_radio" data-key="internship_experiences"><div class="um-field-label"><label for="internship_experiences-1597">長期インターン経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$internship_experiences.'</div></div></div>
                  <div class="um-field um-field-internship_company um-field-textarea um-field-type_textarea" data-key="internship_company"><div class="um-field-label"><label for="internship_company-1597">長期インターン経験先企業名</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$internship_company.'</div></div></div>
                  <div class="um-field um-field-experience_internship um-field-textarea um-field-type_textarea" data-key="experience_internship"><div class="um-field-label"><label for="experience_internship-1597">長期インターン先でどんな経験をしたか？</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$experience_internship.'</div></div></div>
                  <div class="um-field um-field-self_internship_PR um-field-textarea um-field-type_textarea" data-key="self_internship_PR"><div class="um-field-label"><label for="self_internship_PR-1597">その他自己PR</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$self_internship_PR.'</div></div></div>
                  <div class="um-field um-field-degree_of_internship_interest um-field-select um-field-type_select" data-key="degree_of_internship_interest"><div class="um-field-label"><label for="degree_of_internship_interest-1597">長期有給インターンへの興味の度合い</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$degree_of_internship_interest.'</div></div></div>
          </div>
          </div>
          </div>
      <div class="um-editor um-editor-internship">
      <form method="post" id="testform7">
          <div class="um-field um-field-internship_experiences um-field-radio um-field-type_radio" data-key="internship_experiences">
              <div class="um-field-label"><label for="internship_experiences">長期インターン経験<span class="um-req" title="必須">*</span></label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><label class="um-field-radio  um-field-half"><input type="radio" name="internship_experiences[]" value="なし"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">なし</span></label><label class="um-field-radio  um-field-half right"><input type="radio" name="internship_experiences[]" value="1ヶ月以上3ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">1ヶ月以上3ヶ月未満</span></label><p></p>
              <div class="um-clear"></div><p><label class="um-field-radio  um-field-half"><input type="radio" name="internship_experiences[]" value="3ヶ月以上6ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">3ヶ月以上6ヶ月未満</span></label><label class="um-field-radio  um-field-half right"><input type="radio" name="internship_experiences[]" value="6ヶ月以上1年未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">6ヶ月以上1年未満</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-radio  um-field-half"><input type="radio" name="internship_experiences[]" value="1年以上"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">1年以上</span></label></p>
              <div class="um-clear"></div>
              </div>
              </div>
          <div class="um-field um-field-internship_company um-field-textarea um-field-type_textarea" data-key="internship_company">
              <div class="um-field-label"><label for="internship_company">長期インターン経験先企業名</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div id="wp-internship_company-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                  <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 50px; overflow: auto;" autocomplete="off" cols="40" name="internship_company" id="internship_company" aria-hidden="true">'.$internship_company.'</textarea>
              </div><p><span class="description"></span></p></div>
              </div>
          <div class="um-field um-field-experience_internship um-field-textarea um-field-type_textarea" data-key="experience_internship">
              <div class="um-field-label"><label for="experience_internship">長期インターン先でどんな経験をしたか？</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div id="wp-experience_internship-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                  <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="experience_internship" id="experience_internship" aria-hidden="true">'.$experience_internship.'</textarea>
              </div><p><span class="description"></span></p></div>
              </div>
          <div class="um-field um-field-self_internship_PR um-field-textarea um-field-type_textarea" data-key="self_internship_PR">
              <div class="um-field-label"><label for="self_internship_PR">その他自己PR</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area">
              <div id="wp-self_internship_PR-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                  <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="self_internship_PR" id="self_internship_PR" aria-hidden="true">'.$self_internship_PR.'</textarea>
              </div><p><span class="description"></span></p></div>
              </div>
          <div class="um-field um-field-degree_of_internship_interest um-field-select um-field-type_select" data-key="degree_of_internship_interest">
              <div class="um-field-label"><label for="degree_of_internship_interest">長期有給インターンへの興味の度合い<span class="um-req" title="必須">*</span></label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><select data-default="" name="degree_of_internship_interest" id="degree_of_internship_interest" data-validate="" data-key="degree_of_internship_interest" class="um-form-field valid um-s1  select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="今すぐにでも長期インターンをやってみたい">今すぐにでも長期インターンをやってみたい</option><option value="話を聞いてみて、もし自分に合いそうなのであれば長期インターンをやってみたい">話を聞いてみて、もし自分に合いそうなのであれば長期インターンをやってみたい</option><option value="全く興味がない">全く興味がない</option></select>
              </div>
              </div>
          <div class="um-editor-btn">
              <input type="submit" value="更新" class="um-editor-update2">
              <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
          </div>
      </form>
      </div>
      <div class="result_area" id="resultarea7"></div>
  </div>
  
  <div class="um-info">
      <div class="um-field um-field-profile"  id="interest">
          <div class="um-field-label um-info-label-interest">
              <label class="um-field-label-text"><i class="um-field-label-interest"></i>興味・関心</label>
              <span class="um-edit-btn um-edit-btn-interest" onclick="edit_interest()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-interest">
          <div class="um-field-value">
                  <div class="um-field um-field-bussiness_type um-field-checkbox um-field-type_checkbox" data-key="bussiness_type"><div class="um-field-label"><label for="bussiness_type-1597">興味のある業界</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$types.'</div></div></div>
                  <div class="um-field um-field-future_occupations um-field-checkbox um-field-type_checkbox" data-key="future_occupations"><div class="um-field-label"><label for="future_occupations-1597">職種</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$occupations.'</div></div></div>
                  <div class="um-field um-field-will_venture um-field-select um-field-type_select" data-key="will_venture"><div class="um-field-label"><label for="will_venture-1597">ベンチャーへの就職意欲</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$will_venture.'</div></div></div>
          </div>
          </div>
          </div>
      <div class="um-editor um-editor-interest">
      <form method="post" id="testform8">
          <div class="um-field um-field-bussiness_type um-field-checkbox um-field-type_checkbox" data-key="bussiness_type">
              <div class="um-field-label"><label for="bussiness_type">興味のある業界<span class="um-req" title="必須">*</span></label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="メーカー"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">メーカー</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="メディア"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">メディア</span></label><p></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="金融"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">金融</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="広告"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">広告</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="商社"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">商社</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="人材"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">人材</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="教育"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">教育</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="不動産"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">不動産</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="官公庁"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">官公庁</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="IT"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">IT</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="VC/起業支援"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">VC/起業支援</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="ゲーム"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ゲーム</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="コンサルティング"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">コンサルティング</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="ファッション/アパレル"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ファッション/アパレル</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="ブライダル"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ブライダル</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="旅行・観光"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">旅行・観光</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="医療・福祉"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">医療・福祉</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="小売・流通"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">小売・流通</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="未定"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">未定</span></label></p>
              <div class="um-clear"></div>
              </div>
              </div>
          <div class="um-field um-field-future_occupations um-field-checkbox um-field-type_checkbox" data-key="future_occupations">
              <div class="um-field-label"><label for="future_occupations">職種<span class="um-req" title="必須">*</span></label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="エンジニア"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">エンジニア</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="デザイナー"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">デザイナー</span></label><p></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="ディレクター"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ディレクター</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="マーケティング"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">マーケティング</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="ライター"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ライター</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="営業"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">営業</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="事務/コーポレート・スタッフ"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">事務/コーポレート・スタッフ</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="総務・人事・経理"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">総務・人事・経理</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="企画"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">企画</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="その他"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">その他</span></label></p>
              <div class="um-clear"></div>
              <div class="um-clear"></div>
              </div>
              </div>
          <div class="um-field um-field-will_venture um-field-select um-field-type_select" data-key="will_venture">
              <div class="um-field-label"><label for="will_venture">ベンチャーへの就職意欲</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><select data-default="" name="will_venture" id="will_venture" data-validate="" data-key="will_venture" class="um-form-field valid not-required um-s1  select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="ファーストキャリアはベンチャー企業が良いと思っている">ファーストキャリアはベンチャー企業が良いと思っている</option><option value="自分に合ったベンチャー企業ならば就職してみたい">自分に合ったベンチャー企業ならば就職してみたい</option><option value="ベンチャー企業に少しは興味がある">ベンチャー企業に少しは興味がある</option><option value="ベンチャー企業には全く興味がない">ベンチャー企業には全く興味がない</option></select>
          </div>
          <div class="um-editor-btn">
              <input type="submit" value="更新" class="um-editor-update2">
              <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
          </div>
      </div>
      </form>
      </div>
      <div class="result_area" id="resultarea8"></div>
  </div>
  
  <div class="um-info">
      <div class="um-field um-field-profile" id="experience">
          <div class="um-field-label um-info-label-experience">
              <label class="um-field-label-text"><i class="um-field-label-experience"></i>学生時代の経験</label>
              <span class="um-edit-btn um-edit-btn-experience" onclick="edit_experience()">編集</span>
              <p></p>
          <div class="um-clear"></div>
          </div>
          <div class="um-field-area um-field-area-experience">
          <div class="um-field-value">
                  <div class="um-field um-field-student_experience um-field-checkbox um-field-type_checkbox" data-key="student_experience"><div class="um-field-label"><label for="student_experience-1597">学生時代の経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$exps.'</div></div></div>
          </div>
          </div>
          </div>
      <div class="um-editor um-editor-experience">
      <form method="post" id="testform9">
          <div class="um-field um-field-student_experience um-field-checkbox um-field-type_checkbox" data-key="student_experience">
              <div class="um-field-label"><label for="student_experience">学生時代の経験</label><p></p>
              <div class="um-clear"></div>
              </div>
              <div class="um-field-area"><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="起業経験"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">起業経験</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="体育会キャプテン"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">体育会キャプテン</span></label><p></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="サークル代表経験"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">サークル代表経験</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="学生団体代表経験"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">学生団体代表経験</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="サークル/学生団体創設経験"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">サークル/学生団体創設経験</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="ボランティア"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ボランティア</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="海外ボランティア"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">海外ボランティア</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="ビジコン出場"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ビジコン出場</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="ハッカソン出場"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ハッカソン出場</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="ミスコン出場"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ミスコン出場</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="東大TLPに選ばれた"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">東大TLPに選ばれた</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="東大推薦入試合格"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">東大推薦入試合格</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="首席をとった"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">首席をとった</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="未踏クリエーターに選抜された"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">未踏クリエーターに選抜された</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="0から1をつくりあげた"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">0から1をつくりあげた</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="何かで１番になった"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">何かで１番になった</span></label></p>
              <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="高校時代に生徒会経験あり"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">高校時代に生徒会経験あり</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="中高大の部活経験で全国大会出場経験あり"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">中高大の部活経験で全国大会出場経験あり</span></label></p>
              <div class="um-clear"></div>
              <div class="um-clear"></div>
              </div>
              </div>
          <div class="um-editor-btn">
              <input type="submit" value="更新" class="um-editor-update2">
              <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
          </div>
      </form>
      </div>
      <div class="result_area" id="resultarea9"></div>
  </div>
</div>




<style>
  .result_area {
       background-color:#d7f1ee;
       margin-top: 5px;
       border-radius: 3px;
       height: 25px;
       line-height: 25px;
       padding: 10px;
       color: #555;
       display: none;
  }
  
  .photo-btns {
     overflow: hidden !important;
     //margin-top: 50px !important;
  }
  .um-modal-btn {
  float:left !important;
  width: 40% !important;
  margin:  0 5%;
}

  .um-field-type_rating {
     //display: block !important;
  }
     
     .appeal-text p, .appeal-text section {
      display: inline-block;
  }
  
  .myModal_popUp,
  input[name="myModal_switch"],
  #myModal_open + label ~ label {
    display: none;
  }
  #myModal_open + label,
  #myModal_close-button + label {
    cursor: pointer;
  }
  
  .myModal_popUp {
    animation: fadeIn 1s ease 0s 1 normal;
    -webkit-animation: fadeIn 1s ease 0s 1 normal;
  }
  #myModal_open:checked ~ #myModal_close-button + label{
    animation: fadeIn 2s ease 0s 1 normal;
    -webkit-animation: fadeIn 2s ease 0s 1 normal;
  }
  @keyframes fadeIn {
    0% {opacity: 0;}
    100% {opacity: 1;}
  }
  @-webkit-keyframes fadeIn {
    0% {opacity: 0;}
    100% {opacity: 1;}
  }
  
  #myModal_open:checked + label ~ .myModal_popUp {
    background: #fff;
    display: block;
    width: 90%;
    height: 80%;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    -webkit-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    z-index: 998;
  }
  
  #myModal_open:checked + label ~ .myModal_popUp > .myModal_popUp-content {
    /* width: calc(100% - 40px); */
    /* height: calc(100% - 20px - 44px ); */
      height: 100%;
    overflow-y: auto;
    -webkit-overflow-scrolling:touch;
  }
  
  #myModal_open:checked + label + #myModal_close-overlay + label {
    background: rgba(0, 0, 0, 0.70);
    display: block;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    overflow: hidden;
    white-space: nowrap;
    text-indent: 100%;
    z-index: 997;
  }
  
  #myModal_open:checked ~ #myModal_close-button + label {
    display: block;
    background: #fff;
    text-align: center;
    font-size: 25px;
    line-height: 44px;
    width: 90%;
    height: 44px;
    position: fixed;
    bottom: 10%;
    left: 5%;
    z-index: 999;
  }
  #myModal_open:checked ~ #myModal_close-button + label::before {
    content: "×";
  }
  #myModal_open:checked ~ #myModal_close-button + label::after {
    content: "CLOSE";
    margin-left: 5px;
    font-size: 80%;
  }
  
  @media (min-width: 768px) {
    #myModal_open:checked + label ~ .myModal_popUp {
      width: 600px;
      height: 600px;
    }
    #myModal_open:checked + label ~ .myModal_popUp > .myModal_popUp-content {
      /* height: calc(100% - 20px); */
          height: 100%;
    }
    /* #myModal_open:checked ~ #myModal_close-button + label {
      width: 44px;
      height: 44px;
      left: 50%;
      top: 50%;
      margin-left: 240px;
      margin-top: -285px;
      overflow: hidden;
    }
    #myModal_open:checked ~ #myModal_close-button + label::after {
      display: none;
    } */
  }
  
  .myModal {
      float: right;
  }
  
  .appeal-text {
          border-bottom: solid 2px #eee;
  }
  
  .appeal-text p{
      font-size: 15px;
      font-weight: 550;
      color:#555;
  }
  
  label[for="myModal_open"] {
      padding: 0 10px;
      color: #fff;
      border-radius: 4px;
      background-color: #04c4b0;
      font-weight: normal;
      font-size: 12px;
  }
  
  label[for="myModal_open"]:hover {
      opacity: 0.5;
  }
  
  
  .um-name p a {
      font-size: 30px;
  }
  
  .myModal_popUp {
      border-radius: 4px;
  }
  
  .myModal_popUp-content {
      padding: 0;
      margin: 0;
      border-radius: 4px;
  }
  
  .myModal-header {
      width: 100%;
      background-color: #04c4b0;
      height: 44px;
      line-height: 44px;
      position: relative;
  }
  
  .myModal-header p {
      font-size: 17px;
      color: #fff;
      display: inline-block;
      position: absolute;
      top: 25%;;
      left: 5%;
  }
  
  .myModal-header label {
      display: inline-block;
      height: 100%;
      width: 15%;
      float: right;
      color: #fff;
      position: relative;
  }
  
  .myModal-header label:before {
      font-family: "Material Icons";
      font-style: normal;
      content: "\e5cd";
      font-size: 30px;
      position: absolute;
      top: 0;
      right: 15px;
  }
  
  .myModal-body {
      position: relative;
      height: 78%;
  }
  
  .myModal-body .main-body {
      width: 90%;
      position: absolute;
      top: 0;
      left: 5%;
  }
  
  .um-meta-text {
      padding: 0 !important;
  }
  
  .myModal_popUp {
      position: relative;
  }
  
  .myModal-footer {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 68px;
      margin-top: auto;
      position: relative;
  }
  
  
  .myModal-footer-container {
      display: inline-block;
      position: absolute;
      top: 17px;
      right: 35px;
  }
  
  .myModal-footer-container div{
      display: inline-block;
      float: left;
  }
  
  .myModal-footer-container div:hover {
      opacity: 0.5;
  }
  
  .myModal_upDate-button {
      margin: 0 10px 0 0;
      color: #fff !important;
      background-color: #04c4b0;
  }
  
  .myModal_upDate-button:hover {
      background-color: #04c4b0;
  }
  
  
  .myModal-footer-container label[for="myModal_close-button"] {
      border-color: #eee;
      background-color: #eee;
      color: #666;
  }
  
  #tab-profile:checked ~ #tab-profile_content, #tab-favo:checked ~ #tab-favo_content, #tab-offer:checked ~ #tab-offer_content, #tab-finish:checked ~ #tab-finish_content {
  display: block;
  /*選択されているタブのスタイルを変える*/
  }
  
  .um-cover-overlay-s a{
    color: #fff;
  }
  
  #profile-tabs {
      margin-top: 0;
  }
  
  .um-cover {
      position: relative;
  }
  
  .um-univ-meta-meta {
      padding: 0;
      position: absolute;
      bottom: 7px;
      left: 200px;
  }
  
  .um-univ-field {
      padding: 0;
  }
  
  .um-univ-label {
      padding: 0 !important;
      margin: 0 !important;
      border: 0 !important;
  }
  
  .um-univ-field p {
      width: 70px;
      font-size: 17px;
      font-weight: 549;
      font-family: Hiragino Maru Gothic ProN;
      color: #555;
  }
  
  .um-year-meta {
      padding: 0;
      position: absolute;
      bottom: 10px;
      left: 280px;
  }
  
  .um-univ-field {
      padding: 0;
  }
  
  .um-year-label {
      padding: 0 !important;
      margin: 0 !important;
      border: 0 !important;
  }
  
  .um-year-value {
      width: 70px;
      font-size: 17px;
      font-weight: 549;
      font-family: Hiragino Maru Gothic ProN;
      color: #555;
  }
  
  .um-profile-edit div {
      /* display: inline-block; */
  }
  
  .um-profile-edit {
      /* width: 110px; */
      padding: 0;
  }
  
  .um-edit-icon-profile:before {
    font-family: "Material Icons";
      font-style: normal;
    content: "\e3c9";
  }
  
  .um-edit-icon-account:before {
    font-family: "Material Icons";
      font-style: normal;
    content: "\e853";
  }
  
  .um-edit-icon-logout:before {
    font-family: "Material Icons";
      font-style: normal;
    content: "\e879";
  }
  
  .um-profile-edit-icon a i:before {
      color: #555;
      z-index: 5000;
  }
  
  .um-profile-edit-icon a i:hover:before {
      color: #999;
  }
  
  .um-field-label {
      position: relative;
  }
  
  .um-edit-btn {
      display: block;
      position: absolute;
      top: 21%;
      left: 90%;
      padding: 0 10px;
    color: #fff;
    border-radius: 4px;
    background-color: #04c4b0;
    font-weight: normal;
    font-size: 12px;
      width: 24px;
  }
  
  .um-edit-btn:hover {
      opacity: 0.5;
  }
  
  .um-field-profile {
      margin-bottom: 10px;
  }
  
  .um-editor {
      background-color: #d7f1ee;
      border: solid 1px #d7f1ee;
      border-radius: 4px;
      padding: 0 10px;
  }
  
  
  .um-editor.um-editor-base{
      display: none;
  }
  .um-editor.um-editor-base.active{
      display: block;
  }
  .um-editor.um-editor-univ{
      display: none;
  }
  .um-editor.um-editor-univ.active{
      display: block;
  }
  .um-editor.um-editor-community{
      display: none;
  }
  .um-editor.um-editor-community.active{
      display: block;
  }
  .um-editor.um-editor-programming{
      display: none;
  }
  .um-editor.um-editor-programming.active{
      display: block;
  }
  .um-editor.um-editor-abroad{
      display: none;
  }
  .um-editor.um-editor-abroad.active{
      display: block;
  }
  .um-editor.um-editor-skill{
      display: none;
  }
  .um-editor.um-editor-skill.active{
      display: block;
  }
  .um-editor.um-editor-internship{
      display: none;
  }
  .um-editor.um-editor-internship.active{
      display: block;
  }
  .um-editor.um-editor-interest{
      display: none;
  }
  .um-editor.um-editor-interest.active{
      display: block;
  }
  .um-editor.um-editor-experience{
      display: none;
  }
  .um-editor.um-editor-experience.active{
      display: block;
  }

  .um-field-area-base {
      display: block;
  }
  .um-field-area-base.inactive {
      display: none;
  }

  .um-field-area-univ {
      display: block;
  }
   .um-field-area-univ.inactive {
      display: none;
  }
 

  .um-field-area-community {
      display: block;
  }
  .um-field-area-community.inactive {
      display: none;
  }

  .um-field-area-programming {
      display: block;
  }
  .um-field-area-programming.inactive {
      display: none;
  }

  .um-field-area-abroad {
      display: block;
  }
  .um-field-area-abroad.inactive {
      display: none;
  }

  .um-field-area-skill {
      display: block;
  }
  .um-field-area-skill.inactive {
      display: none;
  }

  .um-field-area-internship {
      display: block;
  }
  .um-field-area-internship.inactive {
      display: none;
  }

  .um-field-area-interest {
      display: block;
  }
  .um-field-area-interest.inactive {
      display: none;
  }

  .um-field-area-experience {
      display: block;
  }
  .um-field-area-experience.inactive {
      display: none;
  }

  
  .um-editor-btn {
      width: 150px;
      margin: 30px 0 10px auto;
  }
  
  
  .um-editor-update {
      cursor: pointer;
      line-height: 24px;
      height: 24px;
      display: inline-block;
      border-radius: 3px;
      padding: 0 10px;
      text-align: center;
      vertical-align: middle;
      font-size: 12px;
      transition: 0.2s;
      text-decoration: none;
      border-color: #03c4b0;
      background-color: #03c4b0;
      color: #fff;
      margin-right: 10px;
  }
  
  .um-editor-update:hover {
      opacity: 0.5;
  }
  .um-editor-update2 {
      cursor: pointer !important;
      line-height: 24px !important;
      height: 24px !important;
      display: inline-block !important;
      border-radius: 3px !important;
      padding: 0 10px !important;
      text-align: center !important;
      vertical-align: middle !important;
      font-size: 12px !important;
      transition: 0.2s !important;
      text-decoration: none !important;
      border-color: #03c4b0 !important;
      background-color: #03c4b0 !important;
      color: #fff !important;
      margin-right: 10px !important;
  }
  
  .um-editor-update2:hover {
      opacity: 0.5 !important;
  }
  
  .um-editor-cancel {
      cursor: pointer;
    line-height: 24px;
    height: 24px;
    display: inline-block;
    border-radius: 3px;
    padding: 0 10px;
    text-align: center;
    vertical-align: middle;
    font-size: 12px;
    transition: 0.2s;
    text-decoration: none;
      border-color: #eee;
    background-color: #eee;
    color: #666;
  }
  
  .um-editor-cancel:hover {
      opacity: 0.5;
  }
  
  .um-field-label-text {
      padding: 0 0 0 25px;
  }
  
  .um-field-label-text i {
      position: relative;
  }
  
  .um-field-label-text i:before {
      font-style: normal;
      margin: 1px !important;
      position: absolute;
    left: -25px;
    top: -1px;
  }
  
  .um-field-label label.um-field-label-text {
      font-size: 20px !important;
  }
  
  .um-field-label-base:before {
      font-family: "Material Icons";
      content: "\e87c";
  }
  
  .um-field-label-univ:before {
      font-family: "Material Icons";
      content: "\e80c";
  }
  
  .um-field-label-abroad:before {
      font-family: "Material Icons";
      content: "\e905";
  }
  
  .um-field-label-programming:before {
      font-family: "Material Icons";
      content: "\e30a";
  }
  
  .um-field-label-skill:before {
      font-family: "Material Icons";
      content: "\e3b8";
  }
  
  .um-field-label-community:before {
      font-family: "Material Icons";
      content: "\e7fb";
  }
  
  .um-field-label-internship:before {
      font-family: "Material Icons";
      content: "\e7f1";
  }
  
  .um-field-label-interest:before {
      font-family: "Material Icons";
      content: "\e815";
  }
  
  .um-field-label-experience:before {
      font-family: "Material Icons";
      content: "\e54b";
  }
  
  
  .tab_item .tab_item_text {
      display: block;
      width: 100%;
      height: 50px;
      font-weight: bold;
      line-height: 50px;
      text-align: center;
  }
  
  .edit-slide, .img-edit-slide{
      display: none;
  }
  .edit-overlay, .img-edit-overlay{
          display: none;
  }


  /* 変更点 */

  .um-field-value .um-field {
      padding: 10px 0 0 0;
  }

  .um-field-value .um-field .um-field-label {
      border-bottom: solid 1px #eee;
  }

  .um-field-value .um-field .um-field-label label{
      font-size: 13px !important;
  }

  .um-field-value .um-field .um-field-area div{
      font-size: 13px !important;
  }

  
  
  
  @media (max-width: 560px) {
    
      
      .um-cover, .um-cover-e{
          height: 300px !important;
      }
  
      div.uimob500 .um-profile-photo {
          top: -190px;
      }
  
      div.uimob340 .um-profile-photo{
          top: -190px;
      }
  
      .um-main-meta {
          position: absolute;
          top: -80px;
          left: initial;
          width: 100%;
          text-align: center;
          padding: 0;
      }
  
      .um-univ-meta-meta{
          bottom: 12px;
          left: initial;
          width: 50%;
          text-align: center;
      }
  
      .um-univ-field p {
          width: initial;
      }
  
      .um-year-meta {
          bottom: 12px;
          left: initial;
          right: 0;
          width: 50%;
          text-align: center;
          margin: 0 auto;
      }
  
      .um-year-value {
          width: initial;
          padding: 3px 0;
      }
  
      .um-cover-e img {
          width: initial !important;
          max-width: initial;
          height: 100%;
      }
  
      .um-meta-text, .appeal-text {
          text-align: left;
      }
  
      .um-modal.uimob500 {
          height: 80%;
          bottom: 20% !important;
      }
  
      .um-modal.uimob500 .um-modal-footer a.um-modal-btn {
          width: initial;
          line-height: 34px !important;
          height: 34px;
      }
  
      .um-modal.uimob500 .um-modal-right {
          width: 266px;
          height: 34px;
          float: right;
      }
  
      .tab_item {
          position: relative;
      }
  
      .tab_item .tab_item_text {
          display: block;
          width: 100%;
      height: 15px;
      font-weight: bold;
      line-height: 15px;
      text-align: center;
          position: absolute;
          bottom: 0px;
          font-size: 0.3em;
      }
  
      .tab_item .tab_item_icon:before{
          font-style: normal;
          font-size: 2.2em;;
      }
  
  
      .tab_item .tab_item_icon_profile:before{
          font-family: "Material Icons";
        content: "\e7fd";
      }
  
      .tab_item .tab_item_icon_favo:before{
          font-family: "Material Icons";
          content: "\e838";
      }
  
      .tab_item .tab_item_icon_offer:before{
          font-family: "Material Icons";
          content: "\e85d";
      }
  
      .tab_item .tab_item_icon_finish:before{
          font-family: "Material Icons";
          content: "\e614";
      }
  
      .um-profile-headericon {
          /* display: none; */
      }
  
      div.uimob340 .um-header .um-profile-meta {
          padding-top: 20px !important;
      }
  
      div.uimob500 .um-header .um-profile-meta {
          padding-top: 30px !important;
      }
  
  
      .um-form {
          position: relative;
      }
  
      .um-edit-wrapper {
          position: absolute;
          top: 1px;
          right: 6px;
          z-index: 100;
      }
  
      .menu-edit-icon:before {
          font-family: "Material Icons";
          content: "\e8b8";
          font-size: 30px;
          font-style: normal;
          color: #fff;
      }
  
      .edit-slide, .img-edit-slide{
          display: none;
      position: fixed;
      z-index: 10000;
      width: 100%;
      bottom: 0;
          left: 0;
      background: #f2f2f2;
      border-top: 1px solid #ccc;
  }
      .edit-overlay, .img-edit-overlay{
          display: none;
          position: fixed;
          top: 0;
          left: 0;
              z-index: 5000;
          width: 100%;
          height: 100%;
          background: rgba(0, 0, 0, 0.7);
      }
  
      .edit-slide-content {
          height: 50px;
          width: 100%;
          text-align: center;
          font-size: 20px;
      }
  
      /* .edit-slide-cover {
          color: #04c4b0 !important;
      } */
  
      .edit-slide-content p, .edit-slide-content a{
          height: 50px;
          width: 100%;
          line-height: 50px;
          text-align: center;
          font-size: 20px;
      }
  
       .edit-slide-logout, .edit-slide-photo{
          border-bottom: solid 1px #ccc;
      }
  
      .um-img-edit-wrapper {
          position: absolute;
          top: 260px;
          right: 6px;
          z-index: 99;
      }
  
      .img-edit-icon:before {
          font-family: "Material Icons";
          content: "\e412";
          font-size: 30px;
          font-style: normal;
          color: #fff;
      }
  
      .um-cover-overlay, .um-profile-photo-overlay {
          background-color: initial !important;
      }
  
      .um-cover-overlay-t {
          display: none;
      }
  
      .um-cover-overlay-s .um-manual-trigger {
          position: absolute;
          top: 8px;
          right: 45px;
          z-index: 20;
      }
  
      .um-profile-photo-overlay-s .um-manual-trigger {
          position: absolute;
          bottom: -15px;
          right: -20px;
          z-index: 20;
      }
  
      .um-profile-photo-overlay-s .um-manual-trigger .um-faicon-camera {
          font-size: 25px;
      }
  
      .um-cover-overlay, .um-profile-photo-overlay {
          display: inline !important;
      }
  
      .um-profile-photo, .um-faicon-camera, .um-faicon-camera:before {
          height: 50px;
          width: 50px;
          line-height: 50px;
      }
      .um-field-label label {
  font-size: 13px !important;
  }
  
  
  
  }
  </style>
';

if ($gender == '男性') {
  $html = str_replace('<label class="um-field-radio um-field-half "><input type="radio" name="gender[]" value="男性"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half "><input type="radio" name="gender[]" value="男性" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
}
if ($gender == '女性') {
  $html = str_replace('><label class="um-field-radio  um-field-half right"><input type="radio" name="gender[]" value="女性"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','><label class="um-field-radio active um-field-half right"><input type="radio" name="gender[]" value="女性" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
}
if(isset($faculty_lineage)) {
  $html = str_replace('value="'.$faculty_lineage.'"','value="'.$faculty_lineage.'" selected=""',$html);
}
if(isset($graduate_year)) {
  $html = str_replace('value="'.$graduate_year.'"','value="'.$graduate_year.'" selected=""',$html);
}
if(isset($studied_abroad)) {
  $html = str_replace('<label class="um-field-radio um-field-half "><input type="radio" name="studied_abroad[]" value="'.$studied_abroad.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half"><input type="radio" name="studied_abroad[]" value="'.$studied_abroad.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
  $html = str_replace('<label class="um-field-radio um-field-half right"><input type="radio" name="studied_abroad[]" value="'.$studied_abroad.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half right"><input type="radio" name="studied_abroad[]" value="'.$studied_abroad.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
  
'<label class="um-field-radio  um-field-half right"><input type="radio" name="studied_abroad[]" value="3ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">';
}
if(isset($experience_programming)) {
  $html = str_replace('<label class="um-field-radio  um-field-half "><input type="radio" name="experience_programming[]" value="'.$experience_programming.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half "><input type="radio" name="experience_programming[]" value="'.$experience_programming.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
  $html = str_replace('<label class="um-field-radio um-field-half right"><input type="radio" name="experience_programming[]" value="'.$experience_programming.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half right"><input type="radio" name="experience_programming[]" value="'.$experience_programming.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
}
if(isset($programming_languages)) {
  foreach($programming_languages as $language) {
   $html = str_replace('<option value="'.$language.'">','<option value="'.$language.'" selected="">',$html); 
  }
}
if(isset($skill_dev)) {
  foreach($skill_dev as $dev){
    $html = str_replace('<option value="'.$dev.'">','<option value="'.$dev.'" selected="">',$html);
  }
}
if(isset($skill_design)) {
  foreach($skill_design as $design){
    $html = str_replace('<option value="'.$design.'">','<option value="'.$design.'" selected="">',$html);
  }
}
if(isset($univ_community)) {
  $html = str_replace('<label class="um-field-radio  um-field-half"><input type="radio" name="univ_community[]" value="'.$univ_community.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half"><input type="radio" name="univ_community[]" value="'.$univ_community.' checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
  $html = str_replace('<label class="um-field-radio  um-field-half right"><input type="radio" name="univ_community[]" value="'.$univ_community.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half right"><input type="radio" name="univ_community[]" value="'.$univ_community.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
}
if(isset($internship_experiences)) {
  $html =str_replace('<label class="um-field-radio  um-field-half"><input type="radio" name="internship_experiences[]" value="'.$internship_experiences.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half"><input type="radio" name="internship_experiences[]" value="'.$internship_experiences.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
  $html = str_replace('<label class="um-field-radio  um-field-half right"><input type="radio" name="internship_experiences[]" value="'.$internship_experiences.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half right"><input type="radio" name="internship_experiences[]" value="'.$internship_experiences.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
}
if(isset($degree_of_internship_interest)) {
  $html = str_replace('<option value="'.$degree_of_internship_interest.'">','<option value="'.$degree_of_internship_interest.'" selected="">',$html);
}
if(isset($bussiness_type)) {
      foreach($bussiness_type as $type) {
  $html = str_replace('<label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="'.$type.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half "><input type="checkbox" name="bussiness_type[]" value="'.$type.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
  $html = str_replace('<label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="'.$type.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half right"><input type="checkbox" name="bussiness_type[]" value="'.$type.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
  }
}
if(isset($future_occupations)) {
    foreach($future_occupations as $occupation) {
  $html = str_replace('<label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="'.$occupation.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half "><input type="checkbox" name="future_occupations[]" value="'.$occupation.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
   $html = str_replace('<label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="'.$occupation.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half right"><input type="checkbox" name="future_occupations[]" value="'.$occupation.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
  }
}
if(isset($will_venture)) {
  $html = str_replace('<option value="'.$will_venture.'">','<option value="'.$will_venture.'" selected="">',$html);
}
if(isset($student_experience)) {
  foreach($student_experience as $exp) {
    $html = str_replace('<label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="'.$exp.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half "><input type="checkbox" name="student_experience[]" value="'.$exp.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
   $html = str_replace('<label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="'.$exp.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half right"><input type="checkbox" name="student_experience[]" value="'.$exp.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
  }
}
if(isset($programming_lang_lv_c)) {
  if(($programming_lang_lv_c)>0 and in_array("C言語", $programming_languages)) {
    $html = str_replace('<option value="C言語">','<option value="C言語" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_c" style="display:none;"', 'data-key="programming_lang_lv_c" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_cpp)) {
  if(($programming_lang_lv_cpp)>0 and in_array("C++", $programming_languages)) {
    $html = str_replace('<option value="C++">','<option value="C++" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_cpp" style="display:none;"', 'data-key="programming_lang_lv_cpp" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_cs)) {
  if(($programming_lang_lv_cs)>0 and in_array("C#", $programming_languages)) {
    $html = str_replace('<option value="C#">','<option value="C#" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_cs" style="display:none;"', 'data-key="programming_lang_lv_cs" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_m)) {
  if(($programming_lang_lv_m)>0 and in_array("Objective-C", $programming_languages)) {
    $html = str_replace('<option value="Objective-C">','<option value="Objective-C" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_m" style="display:none;"', 'data-key="programming_lang_lv_m" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_java)) {
  if(($programming_lang_lv_java)>0 and in_array("Java", $programming_languages)) {
    $html = str_replace('<option value="Java">','<option value="Java" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_java" style="display:none;"', 'data-key="programming_lang_lv_java" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_js)) {
  if(($programming_lang_lv_js)>0 and in_array("JavaScript", $programming_languages)) {
    $html = str_replace('<option value="JavaScript">','<option value="JavaScript" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_js" style="display:none;"', 'data-key="programming_lang_lv_js" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_pl)) {
  if(($programming_lang_lv_pl)>0 and in_array("Perl", $programming_languages)) {
    $html = str_replace('<option value="Perl">','<option value="Perl" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_pl" style="display:none;"', 'data-key="programming_lang_lv_pl" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_php)) {
  if(($programming_lang_lv_php)>0 and in_array("PHP", $programming_languages)) {
    $html = str_replace('<option value="PHP">','<option value="PHP" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_php" style="display:none;"', 'data-key="programming_lang_lv_php" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_py)) {
  if(($programming_lang_lv_py)>0 and in_array("Python", $programming_languages)) {
    $html = str_replace('<option value="Python">','<option value="Python" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_py" style="display:none;"', 'data-key="programming_lang_lv_py" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_rb)) {
  if(($programming_lang_lv_rb)>0 and in_array("Ruby", $programming_languages)) {
    $html = str_replace('<option value="Ruby">','<option value="Ruby" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_rb" style="display:none;"', 'data-key="programming_lang_lv_rb" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_go)) {
  if(($programming_lang_lv_go)>0 and in_array("Go", $programming_languages)) {
    $html = str_replace('<option value="Go">','<option value="Go" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_go" style="display:none;"', 'data-key="programming_lang_lv_go" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_swift)) {
  if(($programming_lang_lv_swift)>0 and in_array("Swift", $programming_languages)) {
    $html = str_replace('<option value="Swift">','<option value="Swift" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_swift" style="display:none;"', 'data-key="programming_lang_lv_swift" style="display:block;"',$html);
  }
}
if(isset($programming_lang_lv_vb)) {
  if(($programming_lang_lv_vb)>0 and in_array("Visual Basic", $programming_languages)) {
    $html = str_replace('<option value="vb">','<option value="vb" selected="">',$html);
    $html = str_replace('data-key="programming_lang_lv_vb" style="display:none;"', 'data-key="programming_lang_lv_vb" style="display:block;"',$html);
  }
}
$html = str_replace('<li class="select2-selection__choice" title=""><span class="select2-selection__choice__remove" role="presentation">×</span></li>','',$html);
$login_user = wp_get_current_user();
$login_user_id = $login_user->data->ID;
$edits = ['base','univ','abroad','programming','skill','community','internship','interest','experience'];
if($login_user_id != $user_id){
  foreach($edits as $edit){
  $html = str_replace('<span class="um-edit-btn um-edit-btn-'.$edit.'" onclick="edit_'.$edit.'()">編集</span>','',$html);
  }
}
return do_shortcode($html);
}
add_shortcode('new_mypage','new_mypage_func');

?>