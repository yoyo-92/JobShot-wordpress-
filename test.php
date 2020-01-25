<?php

function apply_status_test(){
    $post_id=7928;
    $apply_value = do_shortcode('[cfdb-value form="/インターン応募フォーム.*/" filter="job-id='.$post_id.'"]');
    $apply_value_array = preg_split("/[,]/",$apply_value);
    $apply_value_array = array_chunk($apply_value_array,18);
    $apply_student_ids=array();
    foreach($apply_value_array as $ava){
        array_push($apply_student_ids,$ava[4]);
    }
    print_r($apply_student_ids);
}
add_shortcode('apply_status_test','apply_status_test');

?>