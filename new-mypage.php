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
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
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
    $results .= '</div></div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_base', 'Ajax_Base' );
add_action( 'wp_ajax_nopriv_ajax_base', 'Ajax_Base' );

function Ajax_Univ(){
    $user_id = um_profile_id();
    $results = '<div class="um-field-label um-info-label-univ">
                    <label class="um-field-label-text"><i class="um-field-label-univ"></i>学歴</label>
                    <span class="um-edit-btn um-edit-btn-univ active" onclick="edit_univ()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-univ inactive">
                    <div class="um-field-value">';
    $user_array = array(
        "学部系統"  =>  "faculty_lineage",
        "学部・学科"  =>  "faculty_department",
        "卒業年"  =>  "graduate_year",
        "ゼミ"  =>  "seminar",
    );
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'faculty_lineage' || $user_value == 'graduate_year'){
            if(isset($_POST[$user_value])) {
                $user_meta_value = $_POST[$user_value];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }else{
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }
        $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_univ', 'Ajax_Univ' );
add_action( 'wp_ajax_nopriv_ajax_univ', 'Ajax_Univ' );

function Ajax_Abroad(){
    $user_id = um_profile_id();
    $results = '<div class="um-field-label um-info-label-abroad">
                    <label class="um-field-label-text"><i class="um-field-label-abroad"></i>留学</label>
                    <span class="um-edit-btn um-edit-btn-abroad active" onclick="edit_abroad()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-abroad inactive">
                    <div class="um-field-value">';
    $user_array = array(
        "留学経験"  =>  "studied_abroad",
        "留学先"  =>  "studied_ab_place",
        "その他"  =>  "lang_pr",
    );
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'studied_ab_place'){
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }else{
            if(isset($_POST[$user_value])) {
                $user_meta_value = $_POST[$user_value];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }
        if($user_value == 'studied_abroad'){
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_abroad', 'Ajax_Abroad' );
add_action( 'wp_ajax_nopriv_ajax_abroad', 'Ajax_Abroad' );

function Ajax_Programming(){
    $user_id = um_profile_id();
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
    $results =
            '<div class="um-field-label um-info-label-programming">
                <label class="um-field-label-text"><i class="um-field-label-programming"></i>プログラミング</label>
                <span class="um-edit-btn um-edit-btn-programming active" onclick="edit_programming()">編集</span>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area um-field-area-programming inactive">
                <div class="um-field-value">';
    $user_array = array(
        "プログラミング経験"  =>  "experience_programming",
        "使用したことのあるフレームワーク・ライブラリ"  =>  "framework",
        "GitHubアカウント"  =>  "Github",
        "開発ソフトのスキル"  =>  "skill_dev",
        "使えるデザイン系アプリケーション"  =>  "skill_design",
        "プログラミング実務経験"  =>  "work",
    );
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'Github'){
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }else{
            if(isset($_POST[$user_value])) {
                $user_meta_value = $_POST[$user_value];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }
        if($user_value == 'experience_programming'){
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        if($user_value == 'skill_design' || $user_value == 'skill_dev'){
            $user_meta_value_sub = '';
            foreach($user_meta_value as $user_meta_value_each) {
                $user_meta_value_sub .= $user_meta_value_each.'</br>' ;
            }
            $user_meta_value = $user_meta_value_sub;
        }
        $language_result = '';
        if($user_value == 'experience_programming'){
            $language_result = $languages;
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>'.$language_result;
    }
    $results .= '</div></div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_programming', 'Ajax_Programming' );
add_action( 'wp_ajax_nopriv_ajax_programming', 'Ajax_Programming' );

function Ajax_Skill(){
    $user_id = um_profile_id();
    if(isset($_POST['skill'])) {
        $skill = $_POST['skill'];
        update_user_meta( $user_id, 'skill', $skill);
    }
    $skill = get_user_meta($user_id,'skill',false)[0];

    $results = '
        <div class="um-field-label um-info-label-skill">
            <label class="um-field-label-text"><i class="um-field-label-skill"></i>資格・その他スキル</label>
            <span class="um-edit-btn um-edit-btn-skill active" onclick="edit_skill()">編集</span>
            <div class="um-clear"></div>
        </div>
        <div class="um-field-area um-field-area-skill inactive">
            <div class="um-field-value">
                <div class="um-field um-field-skill um-field-textarea um-field-type_textarea" data-key="skill">
                    <div class="um-field-label">
                        <label for="skill-1597">資格・その他スキル</label>
                        <div class="um-clear"></div>
                    </div>
                    <div class="um-field-area">
                        <div class="um-field-value">'.$skill.'</div>
                    </div>
                </div>
            </div>
        </div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_skill', 'Ajax_Skill' );
add_action( 'wp_ajax_nopriv_ajax_skill', 'Ajax_Skill' );

function Ajax_Community(){
    $user_id = um_profile_id();
    $results = '
            <div class="um-field-label um-info-label-community">
                <label class="um-field-label-text"><i class="um-field-label-community"></i>コミュニティ</label>
                <span class="um-edit-btn um-edit-btn-community active" onclick="edit_community()">編集</span>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area um-field-area-community inactive">
                <div class="um-field-value">';
    $user_array = array(
        "大学時代のコミュニティ"  =>  "univ_community",
        "サークル・部活・団体名"  =>  "community_univ",
        "当コミュニティでどんなことをしたか？"  =>  "own_pr",
    );
    foreach($user_array as $user_key => $user_value){
        if(isset($_POST[$user_value])) {
            $user_meta_value = $_POST[$user_value];
            update_user_meta( $user_id, $user_value, $user_meta_value);
        }
        if($univ_community == 'univ_community'){
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_community', 'Ajax_Community' );
add_action( 'wp_ajax_nopriv_ajax_community', 'Ajax_Community' );

function Ajax_Intern(){
  $user_id = um_profile_id();
  $results = '
    <div class="um-field-label um-info-label-internship">
        <label class="um-field-label-text"><i class="um-field-label-internship"></i>長期インターン</label>
        <span class="um-edit-btn um-edit-btn-internship active" onclick="edit_internship()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-internship inactive">
        <div class="um-field-value">';
    $user_array = array(
        "長期インターン経験"  =>  "internship_experiences",
        "長期インターン経験先企業名"  =>  "internship_company",
        "長期インターン先でどんな経験をしたか？"  =>  "experience_internship",
        "自己PR"  =>  "self_internship_PR",
        "長期有給インターンへの興味の度合い"  =>  "degree_of_internship_interest",
    );
    foreach($user_array as $user_key => $user_value){
        if(isset($_POST[$user_value])) {
            $user_meta_value = $_POST[$user_value];
            update_user_meta( $user_id, $user_value, $user_meta_value);
        }
        if($user_value == 'internship_experiences'){
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_intern', 'Ajax_Intern' );
add_action( 'wp_ajax_nopriv_ajax_intern', 'Ajax_Intern' );

function Ajax_Interest(){
    $user_id = um_profile_id();
    $results = '
            <div class="um-field-label um-info-label-interest">
                <label class="um-field-label-text"><i class="um-field-label-interest"></i>興味・関心</label>
                <span class="um-edit-btn um-edit-btn-interest active" onclick="edit_interest()">編集</span>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area um-field-area-interest inactive">
                <div class="um-field-value">';
    $user_array = array(
        "興味のある業界"  =>  "bussiness_type",
        "職種"  =>  "future_occupations",
        "ベンチャーへの就職意欲"  =>  "will_venture",
    );
    foreach($user_array as $user_key => $user_value){
        if(isset($_POST[$user_value])) {
            $user_meta_value = $_POST[$user_value];
            update_user_meta( $user_id, $user_value, $user_meta_value);
        }
        $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        if($user_value == 'future_occupations' || $user_value == 'bussiness_type'){
            $user_meta_value_sub = '';
            foreach($user_meta_value as $user_meta_value_each) {
                $user_meta_value_sub .= $user_meta_value_each.'</br>' ;
            }
            $user_meta_value = $user_meta_value_sub;
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_interest', 'Ajax_Interest' );
add_action( 'wp_ajax_nopriv_ajax_interest', 'Ajax_Interest' );

function Ajax_Experience(){
    $user_id = um_profile_id();
    if(isset($_POST['student_experience'])) {
        $student_experience = $_POST['student_experience'];
        update_user_meta( $user_id, 'student_experience', $student_experience);
    }
    $student_experience = get_user_meta( $user_id, 'student_experience',false)[0];
    if(isset($student_experience)) {
        foreach($student_experience as $exp) {
        $exps .= $exp.'</br>';
        }
    }
    $results = '
            <div class="um-field-label um-info-label-experience">
                <label class="um-field-label-text"><i class="um-field-label-experience"></i>学生時代の経験</label>
                <span class="um-edit-btn um-edit-btn-experience active" onclick="edit_experience()">編集</span>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area um-field-area-experience inactive">
                <div class="um-field-value">
                    <div class="um-field um-field-student_experience um-field-checkbox um-field-type_checkbox" data-key="student_experience">
                        <div class="um-field-label">
                            <label for="student_experience-1597">学生時代の経験</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div class="um-field-value">'.$exps.'</div>
                        </div>
                    </div>
                </div>
            </div>';
    // echoで、クライアント側に返すデータを送信する
    echo $results;
    // dieしておかないと末尾に余計なデータ「0」が付与されるので注意
    die();
}
add_action( 'wp_ajax_ajax_experience', 'Ajax_Experience' );
add_action( 'wp_ajax_nopriv_ajax_experience', 'Ajax_Experience' );



function new_mypage_func(){
    $user_id = um_profile_id();
    $user_array = array(
        "都道府県"  =>  "region",
        "性別"  =>  "gender",
        "出身高校"  =>  "highschool",
        "学部系統"  =>  "faculty_lineage",
        "学部・学科"  =>  "faculty_department",
        "卒業年"  =>  "graduate_year",
        "ゼミ"  =>  "seminar",
        "留学経験"  =>  "studied_abroad",
        "留学先"  =>  "studied_ab_place",
        "その他"  =>  "lang_pr",
        "プログラミング経験"  =>  "experience_programming",
        "使用したことのあるフレームワーク・ライブラリ"  =>  "framework",
        "GitHubアカウント"  =>  "Github",
        "開発ソフトのスキル"  =>  "skill_dev",
        "使えるデザイン系アプリケーション"  =>  "skill_design",
        "プログラミング実務経験"  =>  "work",
        "資格・その他スキル"    =>  "skill",
        "大学時代のコミュニティ"  =>  "univ_community",
        "サークル・部活・団体名"  =>  "community_univ",
        "当コミュニティでどんなことをしたか？"  =>  "own_pr",
        "長期インターン経験"  =>  "internship_experiences",
        "長期インターン経験先企業名"  =>  "internship_company",
        "長期インターン先でどんな経験をしたか？"  =>  "experience_internship",
        "自己PR"  =>  "self_internship_PR",
        "長期有給インターンへの興味の度合い"  =>  "degree_of_internship_interest",
        "興味のある業界"  =>  "bussiness_type",
        "職種"  =>  "future_occupations",
        "ベンチャーへの就職意欲"  =>  "will_venture",
        "学生時代の経験"    =>  "student_experience",
    );
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'region' || $user_value == 'highschool' || $user_value == 'faculty_department' || $user_value == 'seminar' || $user_value == 'studied_ab_place' || $user_value == 'GitHub'){
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }else{
            if(isset($_POST[$user_value])) {
                $user_meta_value = $_POST[$user_value];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }
    }
    $prefecture  = get_user_meta($user_id,'region',false)[0];
    $highschool = get_user_meta($user_id,'highschool')[0];
    $gender = get_user_meta($user_id,'gender',false)[0][0];
    $faculty_lineage = get_user_meta($user_id,'faculty_lineage',false)[0];
    $faculty_department = get_user_meta($user_id,'faculty_department',false)[0];
    $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
    $seminar = get_user_meta($user_id,'seminar',false)[0];
    $studied_abroad = get_user_meta($user_id,'studied_abroad',false)[0][0];
    $studied_ab_place = get_user_meta($user_id,'studied_ab_place',false)[0];
    $lang_pr = get_user_meta($user_id,'lang_pr',false)[0];
    $experience_programming = get_user_meta($user_id,'experience_programming',false)[0][0];
    $programming_languages = get_user_meta($user_id,'programming_languages',false)[0];
    $framework = get_user_meta($user_id,'framework',false)[0];
    $Github = get_user_meta($user_id,'GitHub',false)[0];
    $experience_programming = get_user_meta($user_id,'experience_programming',false)[0][0];
    $skill_dev = get_user_meta($user_id,'skill_dev',false)[0];
    if(isset($skill_dev)) {
        foreach($skill_dev as $dev) {
            $devs .= $dev.'</br>' ;
        }
    }
    $skill_design = get_user_meta($user_id,'skill_design',false)[0];
    if(isset($skill_design)) {
        foreach($skill_design as $design) {
            $designs .= $design.'</br>' ;
        }
    }
    $work = get_user_meta($user_id,'work',false)[0];
    $skill = get_user_meta($user_id,'skill',false)[0];
    $univ_community = get_user_meta($user_id,'univ_community',false)[0][0];
    $community_univ = get_user_meta($user_id,'community_univ',false)[0];
    $own_pr = get_user_meta($user_id,'own_pr',false)[0];
    $internship_experiences = get_user_meta($user_id,'internship_experiences',false)[0][0];
    $internship_company = get_user_meta($user_id,'internship_company',false)[0];
    $self_internship_PR = get_user_meta($user_id,'self_internship_PR',false)[0];
    $degree_of_internship_interest = get_user_meta($user_id,'degree_of_internship_interest',false)[0];
    $bussiness_type = get_user_meta($user_id,'bussiness_type',false)[0];
    if(isset($bussiness_type)) {
        foreach($bussiness_type as $type) {
            $types .= $type.'</br>';
        }
    }
    $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
    if(isset($future_occupations)) {
        foreach($future_occupations as $occupation) {
            $occupations .= $occupation.'</br>';
        }
    }
    $will_venture = get_user_meta($user_id,'will_venture',false)[0];
    $student_experience = get_user_meta( $user_id, 'student_experience',false)[0];
    if(isset($student_experience)) {
        foreach($student_experience as $exp) {
            $exps .= $exp.'</br>';
        }
    }

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
    $language_result_html = "";
    $option_languages_html = "";
    foreach( $programming_lang_lv_array as $programming_lang_name => $programming_lang_lv){
        if(isset($_POST[$programming_lang_lv])){
            $programming_lang_lv_skill = $_POST[$programming_lang_lv];
            update_user_meta( $user_id, $programming_lang_lv, $programming_lang_lv_skill);
        }
        $programming_lang_lv_skill = get_user_meta($user_id,$programming_lang_lv,false)[0];
        $languages .='
            <div class=" um-field-'.$programming_lang_lv.' um-field-rating um-field-type_rating" data-key="'.$programming_lang_lv.'" style="display:none;">
                <div class="um-field-label">
                    <label for="'.$programming_lang_lv.'-6120">'.$programming_lang_name.'のレベル</label>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area">
                    <div class="um-field-value">
                        <div class="um-rating-readonly um-raty" id="'.$programming_lang_lv.'" data-key="'.$programming_lang_lv.'" data-number="5" data-score="'.$programming_lang_lv_skill.'" title="'.$programming_lang_lv_skill.'">
                        </div>
                    </div>
                </div>
            </div>';
        $language_result_html .= '
        <div class="um-field um-field-'.$programming_lang_lv.' um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="'.$programming_lang_name.'" id="'.$programming_lang_name.'" data-key="'.$programming_lang_lv.'" style="display:none;">
            <div class="um-field-label">
                <label for="'.$programming_lang_lv.'-6120">'.$programming_lang_name.'のレベル</label>
            <div class="um-clear"></div>
        </div>
        <div class="um-field-area">
            <div class="um-rating um-raty" id="programming_lang_lv_c" data-key="programming_lang_lv_c" data-number="5" data-score="'.$programming_lang_lv_c.'" style="cursor: pointer;"></div>
            </div>
        </div>';
        $option_languages_html .= '<option value="'.$programming_lang_name.'">'.$programming_lang_name.'</option>';
    }

  $html='
    <!-- これより上はclassとdivが被っているので不要 -->
    <div class="um-profile-infomation">
        <div class="um-info">
            <div class="um-field um-field-profile" id="base">
                <div class="um-field-label um-info-label-base">
                    <label class="um-field-label-text"><i class="um-field-label-base"></i>基本情報</label>
                    <span class="um-edit-btn um-edit-btn-base" onclick="edit_base()">編集</span>
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
                    <div class="um-field um-field-programming_languages um-field-multiselect um-field-type_multiselect" data-key="programming_languages">
                        <div class="um-field-label">
                            <label for="programming_languages-6120">使えるプログラミング言語</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <select multiple="multiple" name="programming_languages[]" id="programming_languages" data-maxsize="0" data-validate="" data-key="programming_languages" class="um-form-field valid not-required um-s1 um-user-keyword_0 select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true">
                            '.$option_languages_html.'
                            </select>
                        </div>
                    </div>
                    '.$language_result_html.'
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
                        <div class="um-field um-field-self_internship_PR um-field-textarea um-field-type_textarea" data-key="self_internship_PR"><div class="um-field-label"><label for="self_internship_PR-1597">自己PR</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$self_internship_PR.'</div></div></div>
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
                    <div class="um-field-label"><label for="self_internship_PR">自己PR</label><p></p>
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
    </div>';

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

foreach( $programming_lang_lv_array as $programming_lang_name => $programming_lang_lv){
    if(isset($_POST[$programming_lang_lv])){
        $programming_lang_lv_skill = $_POST[$programming_lang_lv];
        update_user_meta( $user_id, $programming_lang_lv, $programming_lang_lv_skill);
    }
    $programming_lang_lv_skill = get_user_meta($user_id,$programming_lang_lv,false)[0];
    if(($programming_lang_lv_skill)>0 and in_array($programming_lang_name, $programming_languages)) {
        $html = str_replace('<option value="'.$programming_lang_name.'">','<option value="'.$programming_lang_name.'" selected="">',$html);
        $html = str_replace('data-key="'.$programming_lang_lv.'" style="display:none;"', 'data-key="'.$programming_lang_lv.'" style="display:block;"',$html);
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