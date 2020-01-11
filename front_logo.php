<?php
    function company_logo_func(){
    $home_url =esc_url( home_url());
    $logo_html ='
    <div class="company-logo only-pc">
    <div class="company-logo-image-box">
    <div class="company-logo-image">
        <!-- ベイン -->
        <a class="company-logo-link" href="'.$home_url.'/?company=baincompany"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/06/72a30328c81d42c4e526fdec72e493b4-e1559865442253.png" /></a>
        <!-- 電通 -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E9%9B%BB%E9%80%9A%E3%82%A4%E3%83%BC%E3%82%B8%E3%82%B9%E3%83%BB%E3%82%B8%E3%83%A3%E3%83%91%E3%83%B3%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/10/1fab54edd9273f883f2d9fe538ce5935.png"/></a>
        <!-- 経済産業省 -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E7%B5%8C%E6%B8%88%E7%94%A3%E6%A5%AD%E7%9C%81"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/06/5c510c3eedb4fb4b32a9a2e972ebc010-e1559347271620.png" /></a>
        <!-- 外務省 -->
        <a class="company-logo-link" href=""><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/05/c1fb65cf42fdfac9c408825dea5240de-e1558112367753.png"/></a>
        <!-- シンプレックス -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%e3%82%b7%e3%83%b3%e3%83%97%e3%83%ac%e3%82%af%e3%82%b9%e6%a0%aa%e5%bc%8f%e4%bc%9a%e7%a4%be"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/10/0641a71daacb1b96bc87b21e1823b978.png"/></a>
        <!-- ランサーズ -->
        <a class="company-logo-link" href="'.$home_url.'/%3Fcompany%3D%E3%83%A9%E3%83%B3%E3%82%B5%E3%83%BC%E3%82%BA%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/10/0c138320274fc8bd22c7713f7e247c1c.png"/></a>
        <!-- Wiz -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%e6%a0%aa%e5%bc%8f%e4%bc%9a%e7%a4%bewiz"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/10/ce0af69dab6bfcc015fc6ba86d6638b5.png"/></a>
        <!-- PR-TABLE -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BEpr-table"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/05/25d99e2d1acdc7b5df43ec56f1f134d1-e1558113262949.png" /></a>
        <!-- リーナー -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BEleaner-technologies"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/05/79042cc350e2f85571d66e34171def33-e1558113537436.png" /></a>
        <!--  パーツワン　-->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE%E3%83%91%E3%83%BC%E3%83%84%E3%83%AF%E3%83%B3"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/05/c8db458a7705e12c45ee174f308a64e3-e1558113683983.png" /></a>
    </div>
    </div>
    </div>
    <!-- エン婚活-->
    <a class="company-logo-link" href="'.$home_url.'/?company=%E3%82%A8%E3%83%B3%E5%A9%9A%E6%B4%BB%E3%82%A8%E3%83%BC%E3%82%B8%E3%82%A7%E3%83%B3%E3%83%88%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/08/499495b968c940a22f2ea0a15cfaca71.png" /></a>
    <!--  フロムスクラッチ　-->
    <a class="company-logo-link" href="'.$home_url.'/?company=%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE%E3%83%95%E3%83%AD%E3%83%A0%E3%82%B9%E3%82%AF%E3%83%A9%E3%83%83%E3%83%81"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/05/fd2b5fb36b9738e9a3d03f127cfb00a6.png" /></a>
    <!-- kinlab -->
    <a class="company-logo-link" href="'.$home_url.'/?company=%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BEkinlab"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/04/62ACDEC3-3DEF-485B-A17C-37E8ED31C45E-e1558113331409.jpeg" /></a>
    <!-- ANA -->
    <a class="company-logo-link" href=""><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/06/89c1ec0274d554dd49596fb260dcbc73.png"/></a>
    <!-- DeNA -->
    <a class="company-logo-link" href="'.$home_url.'/?company=%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BEdena"><img class="company-logo-logo" src="'.$home_url.'/wp-content/uploads/2019/05/04eac9b1e335897af6e4be107903ab8c.png" /></a>
    ';
    return $logo_html;
    }
    add_shortcode("company_logo","company_logo_func");
?>