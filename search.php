<?php
function my_esc_sql($str){
    return mb_ereg_replace('(_%#)', '#¥1', $str);
}
//////////////////カスタム検索////////////////////////////////////////

function get_view_get_values($getq, $getname, $view){
    $getv = '';
    if (isset($_GET[$getq])) {
            $getv = $_GET[$getq];
        if ($getv[0] == '0' ){
            array_splice($getv, 0, 1);
        }
    }
    return $getv;
}

function view_recommend_func(){
    $result_html='';
    if (isset($_GET['itype'])) {
        $item_type = my_esc_sql($_GET['itype']);
    } else {
        $item_type = get_post_type();
    }
    $ocs = get_the_terms(get_the_ID(), 'occupation');
    $occupation=array();
    foreach($ocs as $oc){
        array_push($occupation, $oc->term_id);
    }

    $bts = get_the_terms(get_the_ID(), 'business_type');
    $business_type=array();
    foreach($bts as $bt){
        array_push($business_type, $bt->term_id);
    }
  $args=array(
        'orderby' => 'rand',
        'posts_per_page' => 3,
        'paged' => 1,
        'post_type' => array($item_type),
        'post__not_in' => array( get_the_ID()) ,
        'post_status' => array( 'publish' ),
        'tax_query' =>array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'occupation',
                'field' => 'id',
                'terms' => $occupation,
                'include_children' => true,
                'operator' => 'IN',
            ),
            array(
                'taxonomy' => 'business_type',
                'field' => 'id',
                'terms' => $business_type,
                'include_children' => true,
                'operator' => 'IN',
            )
        )
    );
    $query = new WP_Query($args);
    $matching_category_ids = array();


    if ($item_type == 'company' || $item_type == 'internship' || $item_type == 'event') {
        $result_html.= '<div class="cards-container companies-container">';
    while ($query->have_posts()): $query->the_post();
        array_push($matching_category_ids, $post->ID);
        $result_html.= view_card_func($post->ID);
    endwhile;
        $result_html.= '</div>';
    } else {
    //  $result_html.= 'no';
    }
    return $result_html;
}
add_shortcode('view_recommend', 'view_recommend_func');

function view_custom_search_func($atts){
    extract(shortcode_atts(array(
        'item_type' => '',
        'style' => '',
        'num_items' => '100',
        'occupation'=>'',
        'sort' => '',
    ), $atts));

    global $post;

    if ($item_type=='' && isset($_GET['itype'])) {
        $item_type = my_esc_sql($_GET['itype']);
    }

    $posts_per_page = 10;
    $page_no = get_query_var('paged')? get_query_var('paged') : 1;
    $reccomend=false;

    $args = array(
        'posts_per_page' => $posts_per_page,
        'paged' => $page_no,
        'post_type' => array($item_type),
        'post_status' => array( 'publish' ),
    );

    if (!empty($_GET['sw'])) {
        $keyword = my_esc_sql($_GET['sw']);
        $args += array('s' => $keyword);
    }
    if(isset($_GET["feature"])){
        $features = $_GET["feature"];
        foreach($features as $feature){
            $metaquerysp[] = array('key'=>'特徴','value'=> $feature,'compare'=>'LIKE');
        }
        $args += array('meta_query' => $metaquerysp);
    }
    if($item_type=="event"){
        $args += array('orderby' => 'meta_value','meta_key' => '開催日','order'   => 'DESC','meta_query' => array('value' => date('Y/m/d'),'compare' => '>=','type' => 'DATE'));
    }
    //新卒投稿をしている企業のみを取得
    if($item_type=="company"){
        $args1=array('post_type' => array('job'),'posts_per_page' => -1);
        $job_posts=get_posts($args1);
        $author_id = array();
        foreach($job_posts as $job_post){
            if (!in_array($job_post->post_author, $author_id)) {
                $author_id[]= $job_post->post_author;
            }
        }
        $args += array('author__in'=>$author_id,);
    }

    // 業種のタクソノミーは企業情報に基づいているので該当する企業投稿を検索→authorに追加
    if (!empty($_GET['business_type'])) {
        if($item_type!="company"){
            $args2=array('post_type' => array('company'),'posts_per_page' => -1);
            $tax_obj2=get_taxonomy('business_type');
            $terms2= get_view_get_values('business_type',$tax_obj2->labels->name,true);
            $taxq2 = array('relation' => 'AND',);
            array_push($taxq2, array(
                'taxonomy' => 'business_type',
                'field' => 'slug',
                'terms' => $terms2,
                'include_children' => true,
                'operator' => 'IN',
            ));
            $args2 += array('tax_query' => $taxq2);
            $company_posts=get_posts($args2);
            $author_id2 = array();
            foreach($company_posts as $company_post){
                if (!in_array($company_post->post_author, $author_id2)) {
                    $author_id2[]= $company_post->post_author;
                }
            }
            $args+=array('author__in'=>$author_id2,);
        }
    }

    $tax_query = array('relation' => 'AND',);
    $tax_slugs = array('occupation','area','business_type');
    foreach ($tax_slugs as $tax_slug){
        if(!($tax_slug =='business_type' and ($item_type=="internship" or $item_type=="summer_internship" or $item_type=="autumn_internship"))){
            $tax_obj = get_taxonomy($tax_slug);
            $terms = get_view_get_values($tax_slug,$tax_obj->labels->name,true);
            if(!empty($terms)){
                array_push($tax_query, array(
                    'taxonomy' => $tax_slug,
                    'field' => 'slug',
                    'terms' => $terms,
                    'include_children' => true,
                    'operator' => 'IN',
                ));
            }
        }
    }
    $args += array('tax_query' => $tax_query);
  
  
    if (isset($_GET['sort'])) {
        $sort = my_esc_sql($_GET['sort']);
        switch($sort){
            case 'popular':
                $args += array('meta_key' => 'week_views_count','orderby' => 'meta_value_num',);
                break;
            case 'new':
                $args += array('order'   => 'DESC',);
                break;
            case 'recommend':
            	unset($args['posts_per_page']);
            	$args += array(
                	'posts_per_page' => -1,
            	);
                break;
        }
    }


    
    if($sort == 'recommend'){
    	$cat_query = recommend_score($args);
    }else{
        $cat_query = new WP_Query($args);
    }
    $html = paginate($cat_query->max_num_pages, get_query_var( 'paged' ), $cat_query->found_posts, $posts_per_page);
    $html .= '<div class="cards-container">';
    /**
     * ベイカレント用に変更（↓通常時）
     * while ($cat_query->have_posts()): $cat_query->the_post();
     *     $post_id = $post->ID;
     *     $html .= view_card_func($post_id);
     * endwhile;
     */
    // ベイカレント用変更ーーーここからーーー
    if($item_type == "event"){
        $post_id = 7554;
        $post_title = get_the_title($post_id);
        $image = get_field("イメージ画像",$post_id);
        $image_url = $image["url"];
        $event_date = get_field('開催日時1',$post_id)['日付'].' '.get_field('開催日時1',$post_id)['開始時刻'].'〜'.get_field('開催日時1',$post_id)['終了時刻'];
        $event_day=get_field('開催日',$post_id);
        $today=date("Y/m/d");
        $area = get_the_terms($post_id,"area")[0]->name;
        $event_target = get_field('募集対象_短文',$post_id);
        $event_capacity = get_field('定員',$post_id);
        $sankas=get_field('参加企業',$post_id);
        $sanka_html='<div>';
        foreach((array)$sankas as $sanka){
            $sanka_html.=  '<div><a href="'.get_the_permalink($sanka->ID).'">'.$sanka->post_title.'</a></div>';
        }
        $sanka_html.='</div>';

        $button_html = '<button class="button favorite innactive">'.get_favorites_button($post_id).'</button>';

        $event_url=get_permalink($post_id);

        $card_html = '
        <div class="card full-card">
            <div class="full-card-main">
            <div class="full-card-img">
                <img src="'.$image_url.'" alt>
            </div>
            <div class="full-card-text">';
        if($event_day<$today){
        $card_html.='
                <div class="full-card-text-title">
                <font color = "gray">'.$post_title.'【終了】</font>
                </div>';
        }else{
        $card_html.='
                <div class="full-card-text-title"><a href="'.esc_url($event_url).'">'.$post_title.'</a></div>';
        }
        $card_html .='
                <table class="full-card-table">
                <tbody>';
        if(!empty($sankas)){
        $card_html.='
                    <tr>
                    <th>参加企業</th>
                    <td>'.$sankas.'</td>
                    </tr>';
        }
        $card_html .='
                    <tr>
                    <th>開催場所</th>
                    <td>株式会社ベイカレント・コンサルティング本社</td>
                    </tr>
                    <tr>
                    <th>開催日時</th>
                    <td>2019年12月4日〜2019年12月25日</td>
                    </tr>
                    <tr>
                    <th>募集対象</th>
                    <td>'.$event_target.'</td>
                    </tr>
                    <tr>
                    <th>定員</th>
                    <td>'.$event_capacity.'</td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
            <div class="full-card-buttons">'
            .$button_html.'
            <a href = "'.esc_url(get_permalink($post_id)).'"><button class="button detail">詳細を見る</button></a>
            </div>
        </div>';
        $html .= $card_html;
    }
    while ($cat_query->have_posts()): $cat_query->the_post();
        if($item_type == "event"){
            $post_id = $post->ID;
            if($post_id != 7554){
                $html .= view_card_func($post_id);
            }
        }else{
            $post_id = $post->ID;
            $html .= view_card_func($post_id);
        }
    endwhile;
    // ベイカレント用変更ーーーここまでーーー
  	$html .= '</div>';
    $html .= paginate($cat_query->max_num_pages, get_query_var( 'paged' ), $cat_query->found_posts, $posts_per_page);
   	wp_reset_postdata();
    return $html;
}
add_shortcode('view_custom_search', 'view_custom_search_func');

function recommend_score($args){
    $cat_query=new WP_Query($args);
    $posts=get_posts( $args );
    $posts_c=count($posts);
  	$cat_query->found_posts=$posts_c;
    $cat_query->max_num_pages=ceil($posts_c/10);
    $sort=array();
    $score=0;
  	if(is_user_logged_in()){
    	$future_occupations = get_user_meta(wp_get_current_user()->ID,'future_occupations',false)[0];
	}
    foreach($posts as $post){
        $post_id = $post->ID;
        $occupation=get_the_terms( $post_id, 'occupation' )[0]->name;
    	$score = get_post_meta($post_id, 'recommend_score', true);
        if(in_array($occupation,$future_occupations)){
            $score+=50;
        }else{
        }
        $sort[]=$score;
	}
    array_multisort($sort, SORT_DESC, SORT_NUMERIC, $posts);
    $paged = 0 == get_query_var( 'paged', 0 ) ? 1 : get_query_var( 'paged', 1 );
    $cat_query->posts=array_slice($posts, ($paged-1)*10,$paged*10);
    return $cat_query;
}

//おすすめの点数の詳細表示用。使い終わったら非常に処理が重くなるのですぐに元に戻す。
/* function recommend_score($args){
    $cat_query=new WP_Query($args);
    $posts=get_posts( $args );
    $posts_c=count($posts);
  	$cat_query->found_posts=$posts_c;
    $cat_query->max_num_pages=ceil($posts_c/10);
    $sort=array();
    $score=0;
    $score1=array();
    $score2=array();
    $score3=array();
  	if(is_user_logged_in()){
    	$future_occupations = get_user_meta(wp_get_current_user()->ID,'future_occupations',false)[0];
	}
    foreach($posts as $post){
        $post_id = $post->ID;*/
        //$score1[]+=(20-(int)do_shortcode(' [cfdb-count form="/インターン応募.*/" filter="job-id='.$post_id.'"]'))*6;
        /*$score2[]+=(int)get_post_meta($post_id, 'week_views_count', true)*4;
        $occupation=get_the_terms( $post_id, 'occupation' )[0]->name;
    	$score = get_post_meta($post_id, 'recommend_score', true);
        if(in_array($occupation,$future_occupations)){
            $score+=50;
            $score3[]+=50;
        }else{
		  	$score3[]+=0;
        }
        $sort[]=$score;
	}
    array_multisort($sort, SORT_DESC, SORT_NUMERIC, $posts,$score1,$score2,$score3);
    print_r($score1);
    print_r($score2);
    print_r($score3);
    print_r($sort);
    $paged = 0 == get_query_var( 'paged', 0 ) ? 1 : get_query_var( 'paged', 1 );
    $cat_query->posts=array_slice($posts, ($paged-1)*10,$paged*10);
    return $cat_query;
} */


?>
