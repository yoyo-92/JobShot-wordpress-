<?php

function template_column2_func($content){
    $column_sidebar = do_shortcode("[add_sidebar_column]");
    $html = $content;
    return $html;
}

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
                        <a href="https://builds-story.com/column?first_category=internship">長期インターン一覧</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=columm">コラム</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=experience">体験記</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>就活初心者向け</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?first_category=beginner">就活初心者向け一覧</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=basic_knowledge">就活の基礎知識</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=schedule">就活スケジュール</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>業界研究</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?first_category=industry">業界研究一覧</a>
                    </li>
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
                        <a href="https://builds-story.com/column?first_category=selection">選考ステップ別対策一覧</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=entry_sheet">エントリーシート</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=test">筆記試験・WEBテスト</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=discussion">グループディスカッション</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=interview">面接</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=case_interview">ケース面接・フェルミ推定</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=internship">インターンシップ・ジョブ</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=recruiter">OB訪問・リクルーター</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=english">英語・TOEIC対策</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>自分にあったコンテンツ</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?first_category=your_contents">自分にあったコンテンツ一覧</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=science">理系学生</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=female_student">女子学生</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=athlete">体育会系</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=graduate">大学院生</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=aboroad">留学経験者</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>キャリアプランを考える</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?first_category=career_plan">キャリアプランを考える一覧</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=foreign_capital">外資系キャリア</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=japanese_company">日系大手のキャリア</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=venture">ベンチャー企業のキャリア</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=others">その他のキャリア</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>内定者向けコンテンツ</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?first_category=after_contents">内定者向けコンテンツ一覧</a>
                    </li>
                    <li>
                        <a href="https://builds-story.com/column?second_category=after">内定後にやること</a>
                    </li>
                </ul>
            </li>
            <li class="column-section">
                <p>その他のコンテンツ</p>
                <ul>
                    <li>
                        <a href="https://builds-story.com/column?first_category=other_contents">その他のコンテンツ一覧</a>
                    </li>
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