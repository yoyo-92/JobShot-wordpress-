<?php
function manage_column_posts_columns($columns) {
    if(current_user_can( 'administrator' )){
        $columns['first_category'] = '大項目';
        $columns['second_category'] = '中項目';
        unset($columns['date']);
        unset($columns['seotitle']);
        unset($columns['seodesc']);
    }
    return $columns;
}
function add_column_category($column_name, $post_id) {
    if(current_user_can( 'administrator' )){
        if ( $column_name == 'first_category' ) {
            $scholarship = CFS()->get('first_category',$post_id);
            if ( isset($stitle) && $stitle ) {
                echo attribute_escape($stitle);
            } else {
                echo __('None');
            }
        }
        if ( $column_name == 'second_category' ) {
            $scholarship = CFS()->get('second_category',$post_id);
            if ( isset($stitle) && $stitle ) {
                echo attribute_escape($stitle);
            } else {
                echo __('None');
            }
        }
    }
}
add_filter( 'manage_column_posts_columns', 'manage_column_posts_columns' );
add_action( 'manage_column_posts_custom_column', 'add_column_category', 10, 2 );

function add_sidebar_column(){
    $html = '
    <div class="column-navi">
        <h2>カテゴリー</h2>
        <ul class="column-container">
            <li class="column-section">
                <p>長期インターン</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?category=">コラム</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">体験記</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>就活初心者向け</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?category=">就活の基礎知識</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">就活スケジュール</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>業界研究</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?category=">あ</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">い</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>選考ステップ別対策</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?category=">エントリーシート</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">筆記試験・WEBテスト</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">グループディスカッション</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">面接</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">ケース面接・フェルミ推定</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">インターンシップ・ジョブ</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">OB訪問・リクルーター</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">英語・TOEIC対策</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>自分にあったコンテンツ</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?category=">理系学生</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">女子学生</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">体育会系</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">大学院生</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">留学経験者</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>キャリアプラスを考える</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?category=">外資系キャリア</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">日系大手のキャリア</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">ベンチャー企業のキャリア</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?category=">その他のキャリア</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>内定者向けコンテンツ</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?category=">内定後にやること</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>その他のコンテンツ</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?category=">あ</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>';
    return $html;
}
add_shortcode("add_sidebar_column","add_sidebar_column");
?>