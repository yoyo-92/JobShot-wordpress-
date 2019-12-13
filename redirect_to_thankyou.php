<?php

add_action( 'wp_footer', function () { 
?>
<script>
document.addEventListener('wpcf7mailsent', function( event ) {
    if ( '324' == event.detail.contactFormId ) {
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
        var fd = new FormData( this );
        fd.append('action'  , 'update_self_internship_PR' );
        $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: fd,
                processData: false,
                contentType: false,
                success: function( response ){
                    alert('success');
                },
                error: function( response ){
                    alert('error');
                }
            });
        location = 'https://builds-story.com/thank-you';
        gtag('event', 'apply', {
        'event_category': 'contactform7',
        'event_label': 'internship'
        });
    }
}, false );
</script>
<?php } );

function update_self_internship_PR(){
    $user = wp_get_current_user();
    $user_id = $user->data->ID;
    if(isset($_POST["your_message"])) {
        $self_internship_PR = $_POST["your_message"];
        update_user_meta( $user_id, "self_internship_PR", $self_internship_PR);
    }
    die();
}
add_action( 'wp_ajax_update_self_internship_PR', 'update_self_internship_PR' );
add_action( 'wp_ajax_nopriv_update_self_internship_PR', 'update_self_internship_PR' );

?>