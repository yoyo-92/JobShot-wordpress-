<?php

function view_recruit_search(){

    $item_type = 'company';
    $area_flag = true;
    $occupation_flag = true;
    $business_type_flag = true;

    $args_area = array(
        'show_option_all' => 'エリアで絞り込み',
        'taxonomy'    => 'area',
        'name'        => 'area',
        'value_field' => 'slug',
        'hide_empty'  => 1,
        'selected'    => get_query_var("area",0),
                'hierarchical'       => 1,
                    'depth'              => 1,
        'id' => 'area_'.$item_type,
        'echo' => false
    );
    $args_occupation = array(
        'show_option_all' => '職種で絞り込み',
        'taxonomy'    => 'occupation',
        'name'        => 'occupation',
        'value_field' => 'slug',
        'hide_empty'  => 1,
        'selected'    =>  get_query_var("occupation",0),
        'id' => 'occupation_'.$item_type,
        'echo' => false
    );
    $args_business_type = array(
        'show_option_all' => '業種で絞り込み',
        'taxonomy'    => 'business_type',
        'name'        => 'business_type',
        'value_field' => 'slug',
        'hide_empty'  => 1,
        'selected'    =>  get_query_var("business_type",0),
        'id' => 'business_type_'.$item_type,
		'echo' => false
    );

    $select_area =convert_to_dropdown_checkboxes(wp_dropdown_categories( $args_area ),"chk-ar-","area","エリアを選択");
    $select_occupation=convert_to_dropdown_checkboxes(wp_dropdown_categories($args_occupation),"chk-op-","occupation","職種を選択");
    $select_business_type= convert_to_dropdown_checkboxes(wp_dropdown_categories($args_business_type),"chk-bt-","business_type","業種を選択");
    $home_url =esc_url( home_url( ));
    $search_form_html='<form role="search" method="get" class="search-form" action="'.$home_url.'/customsearch/">';
    $search_form_html.='<div class="search-field-row search-row">
                            <label for="sw" class="search-field-label">キーワードから探す</label>
                            <div class="form-group">
                                <input type="search" class="search-field" placeholder="キーワードを入力" value="" name="sw" id="sw">
                                <input type="submit" class="search-submit button" value="探す">
                                <input type="hidden" name="itype" class="search-field" value="'.$item_type.'">
                            </div>
                        </div>
                        <div class="form-selects-row search-row">
                            <label for="sw" class="search-field-label">カテゴリから探す</label>
                            <div class="form-selects-container form-group">';

    if($area_flag===true){
        $search_form_html.=$select_area;
    }
	if($occupation_flag===true){
	   $search_form_html.=$select_occupation;
	}
	if($business_type_flag===true){
	  $search_form_html.=$select_business_type;
	}

    $search_form_html.='<input type="submit" class="search-submit button" value="探す"></div></div></form>';

    $html ='
    <div class="so-widget-sow-editor so-widget-sow-editor-base">
        <h3 class="widget-title">企業を探す</h3>
        <div class="siteorigin-widget-tinymce textwidget">
            <style type="text/css">
                #feature-form label {
                    display: inline-block;
                    width: calc(100%/2);
                    font-size: calc((50% + 0.25vw));
                }
            </style>'.$search_form_html.'
        </div>
    </div>';
    return $html;
}
add_shortcode('view_recruit_search','view_recruit_search');

function view_recruit_result(){
    $item_type = "company";

    $args = array(
        'post_type' => array($item_type),
        'post_status' => array( 'publish' ),
        'numberposts' => 10,
        'order' => 'ASC',
    );
    $posts = get_posts($args);

    $card_html = '<div class="panel-grid panel-no-style"><div class="panel-grid-cell"><div class="cards-container">';

    foreach($posts as $post){
        $post_id = $post->ID;
        $card_html .= view_fullwidth_company_card_func($post_id);
    }
    $card_html .= '</div></div></div>';

    return $card_html;
}
add_shortcode('view_recruit_result','view_recruit_result');

?>