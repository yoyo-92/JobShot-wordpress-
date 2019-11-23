<?php
function paginate( $pages, $paged, $num_items, $posts_per_page, $range = 2,  $show_only = true ) {

    /** ページネーション出力関数
    * $paged : 現在のページ
    * $pages : 全ページ数
    * $num_items : 全アイテム数（投稿数）
    * $posts_per_page : １ページに表示する件数
    * $range : 左右に何ページ表示するか
    * $show_only : 1ページしかない時に表示するかどうか
    */

    $pages = ( int ) $pages;    //float型で渡ってくるので明示的に int型 へ
    $paged = $paged ?: 1;       //get_query_var('paged')をそのまま投げても大丈夫なように
    $posts_per_page = int($posts_per_page);
    $html = ''; //記述するテキスト
    $num_items = (int)$num_items;

    //表示テキスト
    $text_first   = "« 最初へ";
    $text_before  = "‹ 前へ";
    $text_next    = "次へ ›";
    $text_last    = "最後へ »";

    if ( $show_only && $pages === 1 ) {
        // １ページのみで表示設定が true の時
        $html .=  '<div class="paginate"><span class="current pager">1</span></div>';
        if($paged < $pages) {
            $html .= '<div class = "paginate-text"><p>('.((($paged-1)*$posts_per_page)+1).'～'.$paged*$posts_per_page.'件/'.$num_items.'件中)</p></div>';
        } else {
        $html .= '<div class = "paginate-text"><p>('.((($paged-1)*$posts_per_page)+1).'～'.$num_items.'件/'.$num_items.'件中)</p></div>';
        }
        return $html;
    }

    if ( $pages === 1 ) return;    // １ページのみで表示設定もない場合

    if ( 1 !== $pages ) {
        //２ページ以上の時
        $html .= '<div class="paginate"><span class="page_num">Page '.$paged.' of '.$pages.'</span>';
        if ( $paged > $range + 1 ) {
            // 「最初へ」 の表示
            $html .= '<a href="'.get_pagenum_link(1).'" class="first">'.$text_first.'</a>';
        }
        if ( $paged > 1 ) {
            // 「前へ」 の表示
            $html .= '<a href="'.get_pagenum_link( $paged - 1 ).'" class="prev">'.$text_before.'</a>';
        }
        for ( $i = 1; $i <= $pages; $i++ ) {

            if ( $i <= $paged + $range && $i >= $paged - $range ) {
                // $paged +- $range 以内であればページ番号を出力
                if ( $paged === $i ) {
                    $html .= '<span class="current pager">'.$i.'</span>';
                } else {
                    $html .= '<a href="'.get_pagenum_link( $i ).'" class="pager">'.$i.'</a>';
                }
            }

        }
        if ( $paged < $pages ) {
            // 「次へ」 の表示
            $html .= '<a href="'.get_pagenum_link( $paged + 1 ).'" class="next">'.$text_next.'</a>';
        }
        if ( $paged + $range < $pages ) {
            // 「最後へ」 の表示
            $html .= '<a href="'.get_pagenum_link( $pages ).'" class="last">'.$text_last.'</a>';
        }
        $html .= '</div>';
            if($paged < $pages) {
                $html .= '<div class = "paginate-text"><p>('.((($paged-1)*$posts_per_page)+1).'～'.$paged*$posts_per_page.'件/'.$num_items.'件中)</p></div>';
        } else {
            $html .= '<div class = "paginate-text"><p>('.((($paged-1)*$posts_per_page)+1).'～'.$num_items.'件/'.$num_items.'件中)</p></div>';
        }
        return $html;
    }
}
add_shortcode('paginate', 'paginate');
?>