<?php

function login_redirect_func(){
    $url=do_shortcode('[geturlnow]');
  return do_shortcode('[wpmem_form login redirect_to="'.$url.'"]');
  }
  add_shortcode('loginform_redirect','login_redirect_func');
  
  function register_redirect_func(){
    $url=do_shortcode('[geturlnow]');
  return do_shortcode('[wpmem_form register redirect_to="'.$url.'"]');
  }
  add_shortcode('registerform_redirect','register_redirect_func');
  
  
  function un_logged_in_user_redirect() {
    /*
      if( ! is_user_logged_in() && is_single() || is_archive() || is_singular( 'カスタム投稿' ) ) {
          wp_redirect( '/login' );// ログインページのURL
          exit();
      }
        if( ! is_user_logged_in() && is_page(1599)) {
          wp_redirect( '/login' );// ログインページのURL
          exit();
      }
      */
    
  }
  add_action( 'template_redirect',  'un_logged_in_user_redirect' );
  
  
  function under_construction_redirect() {
    $cu=wp_get_current_user();
  /*    if( ! is_user_logged_in() || !($cu->has_cap('administrator'))) {
          wp_redirect( '/' );
          exit();
  }*/
          }
  //add_action( 'template_redirect',  'under_construction_redirect' );
  
  add_filter('wpmem_login_redirect', 'my_login_redirect', 10, 2 );
  function my_login_redirect( $redirect_to, $user_id ) {
      return '/';
  }
  
  /*
  add_action( 'auth_redirect', 'subscriber_go_to_home' );
  function subscriber_go_to_home( $user_id ) {
      $user = get_userdata( $user_id );
      if ( !$user->has_cap( 'edit_posts' ) ) {
          wp_redirect( get_home_url() );
          exit();
      }
  }*/

/**
 * この後の手順
 * login redirectの関数を作成し、《新規登録》、《ログイン》の画面を作る（TOWNみたいに）
 * ログインの後のリダイレクト処理と、新規登録の際は新規登録フォームに飛ばす仕組みにする
 * 新規登録の際にリダイレクト処理は最悪行わなくても良いものとする
 */
function apply_redirect(){
    $html = '
        <div class="um um-login um-1596 uimob500" style="opacity: 1;">
            <div class="um-form">
                <form method="post" action="" autocomplete="off">
                    <div class="um-row _um_row_1 " style="margin: 0 0 30px 0;">
                        <div class="um-col-1">
                            <div class="um-field um-field-username um-field-text um-field-type_text" data-key="username">
                                <div class="um-field-label"><label for="username-1596">ユーザー名またはメールアドレス<span class="um-req" title="必須">*</span></label>
                                    <div class="um-clear"></div>
                                </div>
                                <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="username-1596" id="username-1596" value="" placeholder="" data-validate="unique_username_or_email" data-key="username"></div>
                            </div>
                            <div class="um-field um-field-user_password um-field-password um-field-type_password" data-key="user_password">
                                <div class="um-field-label"><label for="user_password-1596">パスワード<span class="um-req" title="必須">*</span></label>
                                    <div class="um-clear"></div>
                                </div>
                                <div class="um-field-area"><input class="um-form-field valid " type="password" name="user_password-1596" id="user_password-1596" value="" placeholder="" data-validate="" data-key="user_password"></div>
                            </div>
                        </div>
                    </div>
                    <p><input type="hidden" name="form_id" id="form_id_1596" value="1596"></p>
                    <p><input type="hidden" name="timestamp" class="um_timestamp" value="1548337902"></p>
                    <p class="request_name">
                        <label for="request_1596">Only fill in if you are not human</label><br>
                        <input type="text" name="request" id="request_1596" class="input" value="" size="25" autocomplete="off">
                    </p>
                    <div class="um-col-alt">
                        <div class="um-field um-field-c">
                            <div class="um-field-area">
                                <label class="um-field-checkbox "><input type="checkbox" name="rememberme" value="1"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option"> ログイン状態を保存する</span></label>
                            </div>
                        </div>
                        <div class="um-clear"></div>
                        <div class="um-left um-half">
                            <input type="submit" value="ログイン" class="um-button" id="um-submit-btn">
                        </div>
                        <div class="um-right um-half">
                            <a href="https://builds-story.com/regist" class="um-button um-alt"><br>新規登録</a>
                        </div>
                        <div class="um-clear"></div>
                    </div>
                    <div class="um-col-alt-b">
                        <a href="https://builds-story.com/?page_id=1605" class="um-link-alt"><br>パスワードをお忘れですか ?</a>
                    </div>
                </form>
            </div>
        </div>
        <style type="text/css">
        .um-1596.um {
        max-width: 450px;
        }
        </style>
        ';
    $html = do_shortcode('[ultimatemember form_id="1596"]');
    return $html;
}
add_shortcode('view_apply_redirect','apply_redirect');

function redirect_to_mypage(){
    $user = wp_get_current_user();
    $user_roles = $user->roles;
    if(in_array("company", $user_roles)){
        $company_user_id = $user->ID;
        $company_id = get_company_post_id_func($company_user_id);
        $company_url = get_permalink($company_id);
        $location = $company_url;
        wp_redirect( $location );
        exit;
    }
    wp_redirect( 'https://builds-story.com/user');
    exit;
}
add_shortcode('redirect_to_mypage','redirect_to_mypage');

function redirect_to_login(){
    wp_redirect( 'https://builds-story.com/login');
    exit;
}
add_shortcode('redirect_to_login','redirect_to_login');

?>