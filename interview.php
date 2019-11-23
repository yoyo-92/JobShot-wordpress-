<?php

function about_interview(){
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
        .widget {
            font-size: 1.0em;
        }
        footer .widget {
            font-size: 0.8em;
        }
        .gmap {
            height: 0;
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
        }
        .gmap iframe {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
        }
    </style>
    <section>
        <img src="https://builds-story.com/wp-content/uploads/2019/09/c7b52d093ae61f8c6d8350c2f44d6aaf-e1568541207179.png">
        <div class="card-category-container event">
            <div class="card-category">本番同様の面接対策とフィードバックにより合格率200%UP！！！</div><br>
            <div class="card-category">人事と接点のある社員から人事が何をどのように評価しているのか学ぶ！</div><br>
            <div class="card-category">志望業界に入るため、今どのような活動をするべきかを相談！</div><br>
        </div>
    </section>
    <section>
        <table class="demo01">
            <tbody>
                <tr>
                    <th>開催日時</th>
                    <td>
                        <div><a href="https://builds-story.com/interview/apply">こちらからお選びください</a></div>
                    </td>
                </tr>
                <tr>
                    <th>場所</th>
                    <td>
                        <div>カレッジワークススタジオ</div>
                        <div>渋谷区神南1-11-1</div>
                        <div><i class="fas fa-train"></i>渋谷駅徒歩8分</div>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.5970616463133!2d139.6990004153449!3d35.66229558019869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188ca880f4b6e7%3A0x6598c977001c85b3!2z44CSMTUwLTAwNDEg5p2x5Lqs6YO95riL6LC35Yy656We5Y2X77yR5LiB55uu77yR77yR4oiS77yR!5e0!3m2!1sja!2sjp!4v1560310092730!5m2!1sja!2sjp" width="100%" height="auto" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                    </td>
                </tr>
                <tr>
                    <th>参加費</th>
                    <td>無料</td>
                </tr>
                <tr>
                    <th>持ち物</th>
                    <td>メモ帳・筆記用具</td>
                </tr>
            </tbody>
        </table>
    </section>
    <div class="fixed-buttom">
        <a href="https://builds-story.com/interview/apply">
            <button class="button button-apply">申し込みはこちらから</button>
        </a>
    </div>';

    return $html;
}
add_shortcode("about_interview","about_interview");
?>