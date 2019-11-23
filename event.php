<?php

function template_event2_func($content){
    global $post;
    date_default_timezone_set('Asia/Tokyo');

    $post_id = $post->ID;
    $event_type= get_field('イベントタイプ',$post_id);

    $accesses=textarea2array(get_field('交通案内',$post_id));
    $access_html='<div>';
    foreach($accesses as $access){
        $access_html.=  '<div><i class="fas fa-train"></i>'.$access.'</div>';
    }
    $access_html.='</div>';

    $sankas=textarea2array(get_field('参加企業',$post_id));
    $sanka_company_link_array=textarea2array(get_field('参加企業注釈',$post_id));
    $sanka_html='<div>';
    foreach($sankas as $key => $sanka){
        $sanka_company_link = $sanka_company_link_array[$key];
        $sanka_html.=  '<div><a href="'.$sanka_company_link.'"><i class="fas fa-building" style="color:#03c4b0;"></i> '.$sanka.'</a></div>';
    }
    $sanka_html.='</div>';

    $contents=textarea2array(get_field('コンテンツ',$post_id));
    if($contents[0]=='' && count($contents)==1){
        $contents_html=NULL;
    }else{
        $contents_html='<ul>';
        foreach($contents as $acontent){
            $contents_html.=  '<li>'.$acontent.'</li>';
        }
        $contents_html.='</ul>';
    }

    $schedule=textarea2array(get_field('スケジュール',$post_id));
    $schedule_html='<ul>';
    foreach($schedule as $sch){
        $schedule_html.=  '<li>'.$sch.'</li>';
    }
    $schedule_html.='</ul>';

    $event_image = get_field("イメージ画像",$post_id);
    $event_image_url = $event_image["url"];
    $event_name = get_field('イベント名',$post_id);
    $event_date = get_field('開催日時1',$post_id)['日付'].' '.get_field('開催日時1',$post_id)['開始時刻'].'-'.get_field('開催日時1',$post_id)['終了時刻'];
    $event_due_date = get_field('開催日時1',$post_id)['日付'].' '.get_field('開催日時1',$post_id)['終了時刻'];
    $event_due_date = str_replace('年', '-', $event_due_date);
    $event_due_date = str_replace('月', '-', $event_due_date);
    $event_due_date = str_replace('日', '', $event_due_date);
    $event_due_date .= ':00';
    $points=textarea2array(get_field('イベントのポイント',$post_id));
    $points_html = '';
    foreach($points as $point){
	    $points_html.= '<div class="card-category">'.$point.'</div><br>';
    }
    //if(strtotime(get_field('申込締切日時',$post_id))>strtotime('now')){
    if(strtotime($event_due_date)>strtotime('now')){
        if($event_type == "job"){
            $entry_html = '
                <a href="[get_form_address formtype=apply form_id=2489 post_id='.$post->ID.' title='.$post->post_title.']">
                    <button class="button button-apply">イベントに応募する</button>
                </a>';
        }elseif($event_type == "internship"){
            $entry_html = '
                <a href="[get_form_address formtype=apply form_id=897 post_id='.$post->ID.' title='.$post->post_title.']">
                    <button class="button button-apply">イベントに応募する</button>
                </a>';
        }else{
            $entry_html = '
                <a href="[get_form_address formtype=apply form_id=897 post_id='.$post->ID.' title='.$post->post_title.']">
                    <button class="button button-apply">イベントに応募する</button>
                </a>';
        }
    }else{
        $entry_html = '<a>申し込み受付終了</a>';
    }

    $table_body_html = add_to_table('開催日時', '<div>'.$event_date.'</div>');
    $table_body_html.=add_to_table('場所', '<div>'.get_field('開催場所名',$post_id).'</div><div>'.get_field('開催場所住所',$post_id).'</div>'.$access_html.'<div class="respiframe">[acf type=area name=開催場所の地図]</div>');
    $table_body_html.=add_to_table('募集対象', get_field('募集対象',$post_id));
    $table_body_html.=add_to_table('定員', get_field('定員',$post_id));
    $table_body_html.=add_to_table('参加費', get_field('参加費',$post_id));
    if(!empty($sankas)){
        $table_body_html.=add_to_table('参加企業', $sanka_html);
    }
    // $table_body_html.=add_to_table('コンテンツ', $contents_html);
    $table_body_html.=add_to_table('コンテンツ', get_field('コンテンツ',$post_id));
    // $table_body_html.=add_to_table('スケジュール', $schedule_html);
    $table_body_html.=add_to_table('スケジュール', get_field('スケジュール',$post_id));
    $table_body_html.=add_to_table('持ち物', get_field('持ち物'));
    $table_body_html.=add_to_table('申込締切',date("Y年m月d日 H:i", strtotime(get_field('申込締切日時'))));
    $table_body_html.=add_to_table('備考', get_field('備考'));

    $html='
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <style>
        .datalist dt:before {
            font-family: "Font Awesome 5 Free";
            content: "\f00c";
            padding-right: 15px;
            color: #03c4b0;
            }
            .table th {
            width: 25%;
            text-align: left
        }
        .table td, .table th {
            border-bottom: 2px solid #f0f0f0
        }
        .table td {
            padding: 12px 0 13px
        }
        @media screen and (min-width:768px) {
            .table {
                width: 100%
            }
        }
    </style>
    <section>
        <h2 class="event-title">'.$event_name.'</h2>
        <img src="'.$event_image_url.'" width="100%">
        <div class="card-category-container event">'.$points_html.'</div>
        <div>'.$content.'</div>
    </section>
    <section>
        <table class="demo01">
            <tbody>'.$table_body_html.'</tbody>
        </table>
    </section>
    <div class="fixed-buttom">'.$entry_html.'</div>';

  return do_shortcode($html);
}
?>