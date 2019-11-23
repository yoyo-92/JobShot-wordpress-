<?php

function company_side_bar_func($content){

    $current_user = wp_get_current_user();
    $current_user_roles = $current_user->roles;
    $company = wp_get_current_user();
    $company_id = get_company_id($company);
    $company_user_login=$company->ID;
    $company_url = get_permalink($company_id);
    $html = '
    <style>
        #sow-editor-2 {
            display: none;
        }
        .col-sidebar {
            position: 　-webkit-sticky;
            position: sticky;
            top: 50px;
        }
    </style>
    <div id="enterprise-navigation-bar" class="fixed" style="top: 60px;">
        <div class="navigation-section">
            <div class="navigation-section-head">ダッシュボード</div>
            <div class="navigation-section-container">
                <a class="link-section" href="'.$company_url.'">ホーム</a>
            </div>
        </div>
        <div class="navigation-section">
            <div class="navigation-section-head">新規募集</div>
            <div class="navigation-section-container">
                <a class="link-section" href="https://builds-story.com/new_post_job"><div class="link-title">新卒情報</div></a>
                <a class="link-section" href="https://builds-story.com/new_post_internship"><div class="link-title">インターン情報</div></a>
            </div>
        </div>
        <div class="navigation-section">
            <div class="navigation-section-head">募集管理</div>
            <div class="navigation-section-container">
                <a class="link-section" href="https://builds-story.com/manage_post?posttype=job"><div class="link-title">新卒情報</div></a>
                <a class="link-section" href="https://builds-story.com/manage_post?posttype=internship"><div class="link-title">インターン情報</div></a>
            </div>
        </div>
        <div class="navigation-section">
            <div class="navigation-section-head">スカウト</div>
            <div class="navigation-section-container">
                <a class="link-section" href="https://builds-story.com/student-search"><div class="link-title">スカウトメールを送る</div></a>
                <a class="link-section" href="https://builds-story.com/manage_scout"><div class="link-title">スカウトメール管理</div></a>
            </div>
        </div>
        <div class="navigation-section">
            <div class="navigation-section-head">アカウント情報</div>
            <div class="navigation-section-container">
                <a class="link-section" href="https://builds-story.com/user_account"><div class="link-title">マイアカウント</div></a>
                <a class="link-section" href="https://builds-story.com/?page_id=1603"><div class="link-title">ログアウト</div></a>
            </div>
        </div>
        <div class="navigation-section">
            <div class="navigation-section-head">オプションメニュー</div>
            <div class="navigation-section-container">
                <a class="link-section" href="https://builds-story.com/option_menu/logo"><div class="link-title">トップページにロゴを掲載</div></a>
                <a class="link-section" href="https://builds-story.com/option_menu/post"><div class="link-title">トップページに募集を掲載</div></a>
                <a class="link-section" href="https://builds-story.com/option_menu/event"><div class="link-title">長期インターン合同説明会に参加する</div></a>
            </div>
        </div>
        <div class="navigation-section">
            <div class="navigation-section-head">ヘルプ</div>
            <div class="navigation-section-container">
                <a class="link-section" href=""><div class="link-title">採用担当者向けヘルプ</div></a>
            </div>
        </div>
        <div class="navigation-section">
            <div class="navigation-section-head">お問い合わせ</div>
            <div class="navigation-section-container">
                <a class="link-section" href="https://builds-story.com/contact"><div class="link-title">メールでのお問い合わせ</div></a>
            </div>
        </div>
    </div>';
    if($company_user_login == 40){
        return  $html;
    }else{
        return;
    }
    if(in_array("company", $current_user_roles)){
        return $html;
    }else{
        return;
    }
}
add_shortcode("company_side_bar","company_side_bar_func");

function side_bar_widget_func(){
    $current_user = wp_get_current_user();
    $current_user_roles = $current_user->roles;
    if(in_array("company", $current_user_roles)){
        return;
    }
    $html = '
    <h3 class="widgettitle">特別コンテンツ</h3>
    <p>
        <a href="https://builds-story.com/interview"><img class=" wp-image-5404 aligncenter" src="https://builds-story.com/wp-content/uploads/2019/09/c7b52d093ae61f8c6d8350c2f44d6aaf-e1568541207179.png"></a>
        <br>
        <a href="https://builds-story.com/gift_money"><img class=" wp-image-5404 aligncenter" src="https://builds-story.com/wp-content/uploads/2019/10/0cc52848b5f9663458606f357ee63b46.png"></a>
        <br>
        <a href="https://builds-story.com/?event=%e5%a4%a7%e6%89%8b%e5%ae%b6%e5%85%b7%e3%83%a1%e3%83%bc%e3%82%ab%e3%83%bc%e5%8f%82%e5%8a%a0%ef%bc%81-%e9%ab%98%e5%ad%a6%e6%ad%b4%e7%94%9f%e5%90%91%e3%81%91-1%e5%88%86%e3%83%94%e3%83%83%e3%83%81"><img class=" wp-image-5404 aligncenter" src="https://builds-story.com/wp-content//uploads/2019/11/93afe8fc32856925c7187c7df002736d.png"></a>
        <br>
        <a href="https://builds-story.com/?event=%e9%95%b7%e6%9c%9f%e3%82%a4%e3%83%b3%e3%82%bf%e3%83%bc%e3%83%b3%e6%8e%a1%e7%94%a8%e3%82%82%e3%81%82%e3%82%8a%ef%bc%81%ef%bc%9f-king-x-jobshot%e5%90%88%e5%90%8c%e5%8b%89%e5%bc%b7%e4%bc%9a"><img class=" wp-image-5404 aligncenter" src="https://builds-story.com/wp-content/uploads/2019/11/157a23972c1752eff669068fd415ad24.png"></a>
        <br>
        <a href="https://builds-story.com/?event=flutter%e3%82%92%e5%ad%a6%e3%81%b3%e3%81%9f%e3%81%84%e4%ba%ba%e9%9b%86%e3%81%be%e3%82%8c%ef%bc%81-finc-x-jobshot%e3%82%a8%e3%83%b3%e3%82%b8%e3%83%8b%e3%82%a2%e5%8b%89%e5%bc%b7%e4%bc%9a"><img class=" wp-image-5404 aligncenter" src="https://builds-story.com/wp-content/uploads/2019/11/3267f35874d4724c1cfa098482b03a3a.png"></a>
        <br>
        <a href="https://builds-story.com/?event=%e3%80%90%e5%ad%a6%e7%94%9f%e3%81%af%e8%b5%b7%e6%a5%ad%e3%81%97%e3%82%8d%e3%80%91skyland-vcxjobshot%e3%82%b3%e3%83%a9%e3%83%9c%e3%82%a4%e3%83%99%e3%83%b3%e3%83%88"><img class=" wp-image-5404 aligncenter" src="https://builds-story.com/wp-content/uploads/2019/11/f3f966d826e3770c27867fabe1aef959.png"></a>
    </p>';
    return $html;
}
add_shortcode("side_bar_widget","side_bar_widget_func");

function option_menu_logo(){
    $current_user = wp_get_current_user();
    $current_user_roles = $current_user->roles;
    // if(in_array("company", $current_user_roles)){
    //     return;
    // }
    $style_html = '
    <style>
    .option-container{
    }
    .main_menu_title{
        text-align: center;
        color: #03c4b0;
        line-height: 1.8;
        font-size: 30px;
        font-weight: 600 !important;
        margin-bottom: 20px;
    }
    .menu_title{
        text-align: center;
        color: #03c4b0;
        line-height: 1.8;
        font-size: 24px;
        font-weight: 600 !important;
        margin-bottom: 20px;
    }
    .menu_text{
        font-size: 15px;
        text-align: center;
        line-height: 2;
        margin-top: 20px;
        padding: 10px 20px;
    }
    .logo-option{
        text-align: center;
        font-size: 30px;
        padding: 10px 0;
    }
    .logo-option .price{
        color: #03c4b0;
        margin-left: 20px;
    }
    .logo-option .tax{
        font-size: 12px;
        color: #9DA0A4;
    }
    .option_faq{
    }
    .option_faq div{
        text-align: center;
        background-color: #03c4b042;
        padding: 1.5em 10px;
        margin: 10px;
      }
    </style>';
    $entry_html = '<a href="https://builds-story.com/published_contact"><button class="button button-apply">お申し込み</button></a>';
    $html = $style_html.'
    <h3 class="widget-title">トップページにロゴを掲載</h3>
    <div class="option-container">
        <p><img class="alignnone size-full wp-image-7216" src="https://builds-story.com/wp-content/uploads/2019/11/439c69c10814e06fa2ed2f54a241b543.png" alt="" width="1702" height="720" /></p>
        <div class="option_menu_logo_details">
            <h4 class="main_menu_title">JobShotユーザーに対して認知度を上げる！<br>効果的に幅広いユーザーへのアプローチが可能！</h4>
            <p class="menu_text">注目度の高いトップページに企業ロゴを掲載することで、<br>JobShotユーザーへの認知度を上げ、企業ブランディングをすることが可能です。</p>
        </div>
        <hr>
        <div class="option_menu_logo_flow">
            <h4 class="menu_title">ご利用の流れ</h4>
            <div class="scholarship-flow-figure">
              <ul class="scholarship-feature">
                <li>
                  <p><i class="fas fa-pencil-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP1】<br>お申し込み</span></p>
                  <p class="menu_text">下記にある「お問い合わせ」ボタンからお問い合わせ下さい。</p>
                </li>
                <li>
                  <p><i class="far fa-calendar-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP2】<br>掲載期間の確認</span></p>
                  <p class="menu_text">トップページに企業ロゴを掲載する期間の内容を確認いたします。</p>
                </li>
                <li>
                  <p><i class="far fa-handshake big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP3】<br>トップページへ掲載</span></p>
                  <p class="menu_text">STEP2で確定した期間、トップページに企業ロゴを掲載いたします。</p>
                </li>
              </ul>
            </div>
        </div>
        <hr>
        <div class="option_menu_logo_plan">
            <h4 class="menu_title">ご利用料金</h4>
            <p class="logo-option">トップページロゴ掲載(1週間)<span class="price">30,000円</span><span class="tax">(税別)</span></p>
        </div>
        <hr>
        <div class="option_menu_logo_quesitons">
            <h4 class="menu_title">よくある質問</h4>
            <div class="option_faq">
                <div><p>Q.利用にあたって必要なものはありますか？</p><p>A.企業ロゴ画像のみ必要になります。</p></div>
                <div><p>Q.申し込みから開始まではどれぐらいですか？</p><p>A.最短で翌日からの掲載が可能です。</p></div>
                <div><p>Q.誰でも申し込みすることはできますか？</p><p>A.掲載契約期間内でしたらどなたでもご利用いただけます。</p></div>
                <div><p>Q.支払い方法はどのようになっていますか？</p><p>A.掲載日が確定次第、請求書を発行させていたきます。</p></div>
            </div>
        </div>
        <hr>
        <div class="option_menu_others">
            <h4 class="menu_title">オプション一覧</h4>
            <div class="scholarship-flow-figure">
              <ul class="scholarship-feature">
                <li>
                  <p><i class="fas fa-pencil-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">トップページにロゴ掲載</span></p>
                </li>
                <li>
                  <p><i class="far fa-calendar-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">トップページに募集を掲載</span></p>
                </li>
                <li>
                  <p><i class="far fa-handshake big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">長期インターン合同説明会に参加する</span></p>
                </li>
              </ul>
            </div>
        </div>
    </div>
    <div class="fixed-buttom">'.$entry_html.'</div>
    ';
    return $html;
}
add_shortcode("option_menu_logo","option_menu_logo");

function option_menu_post(){
    $current_user = wp_get_current_user();
    $current_user_roles = $current_user->roles;
    // if(in_array("company", $current_user_roles)){
    //     return;
    // }
    $style_html = '
    <style>
    .option-container{
    }
    .main_menu_title{
        text-align: center;
        color: #03c4b0;
        line-height: 1.8;
        font-size: 30px;
        font-weight: 600 !important;
        margin-bottom: 20px;
    }
    .menu_title{
        text-align: center;
        color: #03c4b0;
        line-height: 1.8;
        font-size: 24px;
        font-weight: 600 !important;
        margin-bottom: 20px;
    }
    .menu_text{
        font-size: 15px;
        text-align: center;
        line-height: 2;
        margin-top: 20px;
        padding: 10px 20px;
    }
    .logo-option{
        text-align: center;
        font-size: 30px;
        padding: 10px 0;
    }
    .logo-option .price{
        color: #03c4b0;
        margin-left: 20px;
    }
    .logo-option .tax{
        font-size: 12px;
        color: #9DA0A4;
    }
    .option_faq{
    }
    .option_faq div{
        text-align: center;
        background-color: #03c4b042;
        padding: 1.5em 10px;
        margin: 10px;
      }
    </style>';
    $entry_html = '<a href="https://builds-story.com/published_contact"><button class="button button-apply">お申し込み</button></a>';
    $html = $style_html.'
    <h3 class="widget-title">トップページに募集を掲載</h3>
    <div class="option-container">
        <p><img class="" src="https://builds-story.com/wp-content/uploads/2019/11/efebe7f3c5973e9f462c4e30a375b6f4.png" alt="" width="" height="100%" /></p>
        <div class="option_menu_logo_details">
            <h4 class="main_menu_title">JobShotユーザーに対して認知度を上げる！<br>効果的に幅広いユーザーへのアプローチが可能！</h4>
            <p class="menu_text">注目度の高いトップページに案件を掲載することで、<br>JobShotユーザーへの認知度を上げ、応募数を増やすことが可能です。</p>
        </div>
        <hr>
        <div class="option_menu_logo_flow">
            <h4 class="menu_title">ご利用の流れ</h4>
            <div class="scholarship-flow-figure">
              <ul class="scholarship-feature">
                <li>
                  <p><i class="fas fa-pencil-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP1】<br>お申し込み</span></p>
                  <p class="menu_text">下記にある「お問い合わせ」ボタンからお問い合わせ下さい。</p>
                </li>
                <li>
                  <p><i class="far fa-calendar-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP2】<br>掲載期間の確認</span></p>
                  <p class="menu_text">トップページに掲載したい募集の詳細、掲載期間を確認いたします。</p>
                </li>
                <li>
                  <p><i class="far fa-handshake big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP3】<br>トップページへ掲載</span></p>
                  <p class="menu_text">STEP2で確定した期間、トップページに募集を掲載いたします。</p>
                </li>
              </ul>
            </div>
        </div>
        <hr>
        <div class="option_menu_logo_plan">
            <h4 class="menu_title">ご利用料金</h4>
            <p class="logo-option">トップページ募集掲載(1週間)<span class="price">30,000円</span><span class="tax">(税別)</span></p>
        </div>
        <hr>
        <div class="option_menu_logo_quesitons">
            <h4 class="menu_title">よくある質問</h4>
            <div class="option_faq">
                <div><p>Q.利用にあたって必要なものはありますか？</p><p>A.掲載予定の募集要項のみ必要となります。</p></div>
                <div><p>Q.申し込みから開始まではどれぐらいですか？</p><p>A.最短で翌日からの掲載が可能です。</p></div>
                <div><p>Q.誰でも申し込みすることはできますか？</p><p>A.掲載契約期間内でしたらどなたでもご利用いただけます。</p></div>
                <div><p>Q.支払い方法はどのようになっていますか？</p><p>A.掲載日が確定次第、請求書を発行させていたきます。</p></div>
            </div>
        </div>
        <hr>
        <div class="option_menu_others">
            <h4 class="menu_title">オプション一覧</h4>
            <div class="scholarship-flow-figure">
              <ul class="scholarship-feature">
                <li>
                  <p><i class="fas fa-pencil-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">トップページにロゴ掲載</span></p>
                </li>
                <li>
                  <p><i class="far fa-calendar-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">トップページに募集を掲載</span></p>
                </li>
                <li>
                  <p><i class="far fa-handshake big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">長期インターン合同説明会に参加する</span></p>
                </li>
              </ul>
            </div>
        </div>
    </div>
    <div class="fixed-buttom">'.$entry_html.'</div>
    ';
    return $html;
}
add_shortcode("option_menu_post","option_menu_post");

function option_menu_event(){
    $current_user = wp_get_current_user();
    $current_user_roles = $current_user->roles;
    // if(in_array("company", $current_user_roles)){
    //     return;
    // }
    $style_html = '
    <style>
    #post-7244 .sharedaddy{
        display: none;
    }
    .option-container{
    }
    .main_menu_title{
        text-align: center;
        color: #03c4b0;
        line-height: 1.8;
        font-size: 30px;
        font-weight: 600 !important;
        margin-bottom: 20px;
    }
    .menu_title{
        text-align: center;
        color: #03c4b0;
        line-height: 1.8;
        font-size: 24px;
        font-weight: 600 !important;
        margin-bottom: 20px;
    }
    .menu_text{
        font-size: 15px;
        text-align: center;
        line-height: 2;
        margin-top: 20px;
        padding: 10px 20px;
    }
    .logo-option{
        text-align: center;
        font-size: 30px;
        padding: 10px 0;
    }
    .logo-option .price{
        color: #03c4b0;
        margin-left: 20px;
    }
    .logo-option .tax{
        font-size: 12px;
        color: #9DA0A4;
    }
    .option_faq{
    }
    .option_faq div{
        text-align: center;
        background-color: #03c4b042;
        padding: 1.5em 10px;
        margin: 10px;
      }
    </style>';
    $args = array(
        'post_type' => array( 'event'),
        'post_status' => array( 'publish' ),
        'posts_per_page' => 10,
    );
    $args += array(
        'orderby' => 'meta_value',
        'meta_key' => '開催日',
        'order'   => 'DESC',
        'meta_query' => array('value' => date('Y/m/d'),
        'compare' => '>=',
        'type' => 'DATE')
    );
    $cat_query = new WP_Query($args);
    $event_html .= '<div class="cards-container">';
    while ($cat_query->have_posts()): $cat_query->the_post();
        $post_id = $post->ID;
        $event_day = get_field("開催日",$post_id);
        $event_type= get_field('イベントタイプ',$post_id);
        if($event_day>=date("Y/m/d") && $event_type == "internship"){
            $event_html .= view_card_func($post_id);
        }
    endwhile;
  	$event_html .= '</div>';
    $entry_html = '<a href="https://builds-story.com/published_contact"><button class="button button-apply">お申し込み</button></a>';
    $html = $style_html.'
    <h3 class="widget-title">長期インターン合同説明会に参加する</h3>
    <div class="option-container">
        <p><img class="" src="https://builds-story.com/wp-content/uploads/2019/11/efebe7f3c5973e9f462c4e30a375b6f4.png" alt="" width="" height="100%" /></p>
        <div class="option_menu_logo_details">
            <h4 class="main_menu_title">少人数制で学生と接点を持てるイベント！<br>学生と密なコミュニケーションをとることができます！</h4>
            <p class="menu_text">企業説明に加えて座談会やパネルディスカッション、個別面談などのコンテンツを用意しております。<br>気になった学生とは当日に個別面談を組むことができます。</p>
        </div>
        <hr>
        <div class="option_menu_logo_flow">
            <h4 class="menu_title">ご利用の流れ</h4>
            <div class="scholarship-flow-figure">
              <ul class="scholarship-feature">
                <li>
                  <p><i class="fas fa-pencil-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP1】<br>イベントの確認</span></p>
                  <p class="menu_text">下記にある長期インターンイベント一覧から参加したいイベントの詳細、日時をご確認ください。</p>
                </li>
                <li>
                  <p><i class="far fa-calendar-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP2】<br>お申し込み</span></p>
                  <p class="menu_text">下記にある「お問い合わせ」ボタンから参加したい長期インターンイベントをお問い合わせ下さい。</p>
                </li>
                <li>
                  <p><i class="far fa-handshake big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP3】<br>イベントに参加</span></p>
                  <p class="menu_text">STEP2で確定したイベントに当日ご参加ください。</p>
                </li>
              </ul>
            </div>
        </div>
        <hr>
        <div class="option_menu_event">
            <h4 class="menu_title">イベント一覧</h4>
            '.$event_html.'
        </div>
        <hr>
        <div class="option_menu_logo_plan">
            <h4 class="menu_title">ご利用料金</h4>
            <p class="logo-option">長期インターンイベント<span class="price">200,000円/回</span><span class="tax">(税別)</span></p>
        </div>
        <hr>
        <div class="option_menu_logo_quesitons">
            <h4 class="menu_title">よくある質問</h4>
            <div class="option_faq">
                <div><p>Q.参加にあたって必要なものはありますか？</p><p>A.企業説明のスライドを用意して頂きます。</p></div>
                <div><p>Q.誰でも申し込みすることはできますか？</p><p>A.長期インターンを導入している企業様、長期インターンの導入を考えている企業様がお申し込み頂けます。</p></div>
                <div><p>Q.支払い方法はどのようになっていますか？</p><p>A.イベントへの参加が確定次第、請求書を発行させていたきます。</p></div>
            </div>
        </div>
        <hr>
        <div class="option_menu_others">
            <h4 class="menu_title">オプション一覧</h4>
            <div class="scholarship-flow-figure">
              <ul class="scholarship-feature">
                <li>
                  <p><i class="fas fa-pencil-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">トップページにロゴ掲載</span></p>
                </li>
                <li>
                  <p><i class="far fa-calendar-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">トップページに募集を掲載</span></p>
                </li>
                <li>
                  <p><i class="far fa-handshake big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">長期インターン合同説明会に参加する</span></p>
                </li>
              </ul>
            </div>
        </div>
    </div>
    <div class="fixed-buttom">'.$entry_html.'</div>
    ';
    return $html;
}
add_shortcode("option_menu_event","option_menu_event");
?>