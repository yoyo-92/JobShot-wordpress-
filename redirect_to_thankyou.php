<?php

add_action( 'wp_footer', function () {
?>
<script>
document.addEventListener('wpcf7mailsent', function( event ) {
    if ( '324' == event.detail.contactFormId ) {
        gtag('event', 'apply', {
            'event_category': 'contactform7',
            'event_label': 'internship'
        });
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
        var self_internship_pr = $("[name=your-message]").html();
        var flag = false;
        if ($('.pr_save_check_box').prop('checked')) {
            flag = true;
	        self_internship_pr = $("[name=your-message]").val();
        }
        $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action' : 'update_self_internship_PR', // フックの名前を渡す
                    'your_message' : self_internship_pr,
                    'flag' : flag,
                },
                success: function( response ){
                    // alert('success');
                },
                error: function( response ){
                    console.log(response);
                    // alert('error');
                }
            });
        location = 'https://builds-story.com/thank-you';
    }
}, false );
</script>
<?php } );

function update_self_internship_PR_func(){
    $user = wp_get_current_user();
    $user_id = $user->data->ID;
    $flag = $_POST["flag"];
    $self_internship_PR = $_POST["your_message"];
    if($flag){
        if(isset($_POST["your_message"])) {
            update_user_meta( $user_id, "self_internship_PR", $self_internship_PR);
        }
    }
    die();
}
add_action( 'wp_ajax_update_self_internship_PR', 'update_self_internship_PR_func' );
add_action( 'wp_ajax_nopriv_update_self_internship_PR', 'update_self_internship_PR_func' );

function past_self_internship_PR_func(){
    $user = wp_get_current_user();
    $user_id = $user->data->ID;
    $login_name = $user->user_login;
    $self_internship_pr_num = do_shortcode(' [cfdb-count form="/インターン応募フォーム.*/" filter="your-id='.$login_name.'"]');
    $self_internship_pr_value = do_shortcode('[cfdb-value form="/インターン応募フォーム.*/" filter="your-id='.$login_name.'"]');
    $self_internship_pr_value = preg_split("/[,]/",$self_internship_pr_value);
    $count = 0;
    $self_internship_pr_value = array_chunk($self_internship_pr_value,18);
    $izimodal_content = '<button class="open-options button" style="float: right;">過去の自己PRを使う</button>';
    foreach($self_internship_pr_value as $self_internship_pr_value_each){
        $internship_title = $self_internship_pr_value_each[7];
        $self_internship_pr_content = $self_internship_pr_value_each[8];
        $title_count = $count+1;
        $izimodal_content .= '
        <div class="modal_options" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="過去の自己PR'.$title_count.'" data-izimodal-subtitle="'.$internship_title.'">
            <p id="past-self-pr-'.$title_count.'">'.$self_internship_pr_content.'</p>
            <input type="button" id="button'.$title_count.'" value="これを使う"/>
        </div>';
        $count += 1;
        if($count > 4){
            break;
        }
    }
    return $izimodal_content;
}
add_shortcode("past_self_internship_PR","past_self_internship_PR_func");
?>