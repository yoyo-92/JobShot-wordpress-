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
    foreach($self_internship_pr_value as $self_internship_pr_value_each){
        $internship_title = $self_internship_pr_value_each[7];
        $self_internship_pr_content = $self_internship_pr_value_each[8];
        $slick_html .= '
        <div class="slick_content">
            <p>'.$internship_title.'</p>
            <p>'.$self_internship_pr_content.'</p>
            <button>利用する</button>
        </div>';
        $count += 1;
        if($count > 5){
            break;
        }
    }
    $html = '
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <style>
    .slick_content{
        text-align: center;
      }
    </style>
    <section class="past_pr_slick">
        '.$slick_html.'
    </section>
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script type="text/javascript">
        $(document).on("ready", function() {
            // ここから
            $(".past_pr_slick").slick({
                dots: true,
                centerMode: true,
            });
            // ここまで
        });
    </script>';
    // Loghtboxを利用するための読み込み
    $izimodal = '
    <link href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/css/iziModal.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js" type="text/javascript"></script>';
    return $html;
}
add_shortcode("past_self_internship_PR","past_self_internship_PR_func");
?>