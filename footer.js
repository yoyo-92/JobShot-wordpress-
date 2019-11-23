<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" onload="
        $(function() {
            $('form').submit(function() {
                $('form').find(':submit').attr('disabled', 'disabled');
            });
        });
    " defer></script>

$(function() {
    var w = screen.width;
    var x = 1023;
    if (w <= x) {
      var str = document.getElementById("br_tag").innerHTML;
      str = str.replace("エリアを選択","エリア");
      str = str.replace("職種を選択","職種");
      str = str.replace("業種を選択","業種");
      document.getElementById("br_tag").innerHTML = str;
    }
});
/* preview インターンシップ新規投稿、編集 */
    // documentと毎回書くのがだるいので$に置き換え
    var $ = document; 
    var $form = $.querySelector('form');// jQueryの $("form")相当
    
    //jQueryの$(function() { 相当(ただし厳密には違う)
    $.addEventListener('DOMContentLoaded', function() {
        //画像ファイルプレビュー表示
        //  jQueryの $('input[type="file"]')相当
        // addEventListenerは on("change", function(e){}) 相当
        $.querySelector('input[name="picture"]').addEventListener('change', function(e) {
            var file = e.target.files[0],
                   reader = new FileReader(),
                   $preview =  $.querySelector(".preview-img"), // jQueryの $(".preview")相当
                   t = this;
    
            // 画像ファイル以外の場合は何もしない
            if(file.type.indexOf("image") < 0){
              return false;
            }
    
            reader.onload = (function(file) {
              return function(e) {
                 //jQueryの$preview.empty(); 相当
                 while ($preview.firstChild) $preview.removeChild($preview.firstChild);
    
                // imgタグを作成
                var img = document.createElement( 'img' );
                img.setAttribute('src',  e.target.result);
                img.setAttribute('width', '150px');
                img.setAttribute('title',  file.name);
                // imgタグを$previeの中に追加
                $preview.appendChild(img);
              }; 
            })(file);
    
            reader.readAsDataURL(file);
        }); 
    });
    var a = function() {
			$(".um-cover").hover(function() {
      $(".um-cover-overlay").fadeIn();
    }, function() {
      $(".um-cover-overlay").fadeOut();
    });
	};


    var b = function () {
    	$(".um-cover-overlay-t").hover(function() {
      $(".um-cover-overlay-t").css("color","#b5acac");
    }, function() {
      $(".um-cover-overlay-t").css("color","#fff");
    });
	};

    var c = function () {
    	$(".um-manual-trigger .um-faicon-picture-o").hover(function() {
      $(".um-manual-trigger .um-faicon-picture-o").css("color","#b5acac");
    }, function() {
      $(".um-manual-trigger .um-faicon-picture-o").css("color","#fff");
    });
	};
		// トプ画オーバーレイ
		var d = function () {
			$(".um-profile-photo-img").hover(function() {
      $(".um-profile-photo-overlay").fadeIn();
    }, function() {
      $(".um-profile-photo-overlay").fadeOut();
    });
	};

    var e = function () {
    	$(".um-profile-photo-overlay-s .um-faicon-camera").hover(function() {
      $(".um-profile-photo-overlay-s .um-faicon-camera").css("color","#b5acac");
    }, function() {
      $(".um-profile-photo-overlay-s .um-faicon-camera").css("color","#fff");
    });
	};



$(function(){
	var w = $(window).width();
	var x = 560;
	if (w <= x) {
	} else if(w > x) {
		a();
		b();
		c();
		d();
		e();
	}
});


$(window).resize(function(){
	var w = $(window).width();
	var x = 560;
	if (w <= x) {
	} else if(w > x) {
		a();
		b();
		c();
		d();
		e();
	}
});


	function cancel() {
		$(".um-editor").removeClass("active");
		$(".um-edit-btn").removeClass("active");
	}
	function edit_base() {
		if ($(".um-edit-btn-base").hasClass("active")) {
			cancel();
		}else {
			$(".um-editor").removeClass("active");
			$(".um-editor-base").addClass("active");
			$(".um-edit-btn-base").addClass("active");
		}
	}
	function edit_univ() {
		if ($(".um-edit-btn-univ").hasClass("active")) {
			cancel();
		}else {
			$(".um-editor").removeClass("active");
			$(".um-editor-univ").addClass("active");
			$(".um-edit-btn-univ").addClass("active");
		}
	}
	function edit_abroad() {
		if ($(".um-edit-btn-abroad").hasClass("active")) {
			cancel();
		}else {
			$(".um-editor").removeClass("active");
			$(".um-editor-abroad").addClass("active");
			$(".um-edit-btn-abroad").addClass("active");
		}
	}
	function edit_programming() {
		if ($(".um-edit-btn-programming").hasClass("active")) {
			cancel();
		}else {
			$(".um-editor").removeClass("active");
			$(".um-editor-programming").addClass("active");
			$(".um-edit-btn-programming").addClass("active");
		}
	}
	function edit_skill() {
		if ($(".um-edit-btn-skill").hasClass("active")) {
			cancel();
		}else {
			$(".um-editor").removeClass("active");
			$(".um-editor-skill").addClass("active");
			$(".um-edit-btn-skill").addClass("active");
		}
	}
	function edit_community() {
		if ($(".um-edit-btn-community").hasClass("active")) {
			cancel();
		}else {
			$(".um-editor").removeClass("active");
			$(".um-editor-community").addClass("active");
			$(".um-edit-btn-community").addClass("active");
		}
	}
	function edit_internship() {
		if ($(".um-edit-btn-internship").hasClass("active")) {
			cancel();
		}else {
			$(".um-editor").removeClass("active");
			$(".um-editor-internship").addClass("active");
			$(".um-edit-btn-internship").addClass("active");
		}
	}
	function edit_interest() {
		if ($(".um-edit-btn-interest").hasClass("active")) {
			cancel();
		}else {
			$(".um-editor").removeClass("active");
			$(".um-editor-interest").addClass("active");
			$(".um-edit-btn-interest").addClass("active");
		}
	}
	function edit_experience() {
		if ($(".um-edit-btn-experience").hasClass("active")) {
			cancel();
		}else {
			$(".um-editor").removeClass("active");
			$(".um-editor-experience").addClass("active");
			$(".um-edit-btn-experience").addClass("active");
		}
	}

	$(function(){
    var wrp = ".um-edit-wrapper",
        btnOpen = ".menu-edit-icon",
        btnClose = ".edit-slide-close",
        sld = ".edit-slide",
        ovrly = ".edit-overlay",
        current_scrollY;

    $(btnOpen).on("click",function(e){
        if($(sld).css("display") == "none"){
            current_scrollY = $( window ).scrollTop();
            $(wrp).css({
                position: "fixed",
                width: "100%",
                top: -1 * current_scrollY
            });
            $(sld).slideDown();
            $(ovrly).css("display","block");
        }
    });

    $(btnClose).on("click",function(){
        if($(sld).css("display") == "block"){
            $(wrp).attr({style:""});
            $("html, body").prop({scrollTop: current_scrollY});
            $(sld).slideUp();
            $(ovrly).fadeOut();
        }
    });

    $(document).on("click",function(e) {
        if($(sld).css("display") == "block"){
            if ((!$(e.target).closest(sld).length)&&(!$(e.target).closest(btnOpen).length)) {
                $(wrp).attr({style:""});
                $("html, body").prop({scrollTop: current_scrollY});
                $(sld).slideUp();
                $(ovrly).fadeOut();
            }
        }
    });

});

$(function(){
	var wrp = ".um-img-edit-wrapper",
			btnOpen = ".img-edit-icon",
			btnClose = ".edit-slide-close",
			sld = ".img-edit-slide",
			ovrly = ".img-edit-overlay",
			current_scrollY;

	$(btnOpen).on("click",function(e){
			if($(sld).css("display") == "none"){
					current_scrollY = $( window ).scrollTop();
					$(wrp).css({
							position: "fixed",
							width: "100%",
							top: -1 * current_scrollY
					});
					$(sld).slideDown();
					$(ovrly).css("display","block");
			}
	});

	$(btnClose).on("click",function(){
			if($(sld).css("display") == "block"){
					$(wrp).attr({style:""});
					$("html, body").prop({scrollTop: current_scrollY});
					$(sld).slideUp();
					$(ovrly).fadeOut();
			}
	});

	$(document).on("click",function(e) {
			if($(sld).css("display") == "block"){
					if ((!$(e.target).closest(sld).length)&&(!$(e.target).closest(btnOpen).length)) {
							$(wrp).attr({style:""});
							$("html, body").prop({scrollTop: current_scrollY});
							$(sld).slideUp();
							$(ovrly).fadeOut();
					}
			}
	});

});



/* preview1 インターンシップ新規投稿、編集 */
    // documentと毎回書くのがだるいので$に置き換え
    var $ = document; 
    var $form = $.querySelector('form');// jQueryの $("form")相当
    
    //jQueryの$(function() { 相当(ただし厳密には違う)
    $.addEventListener('DOMContentLoaded', function() {
        //画像ファイルプレビュー表示
        //  jQueryの $('input[type="file"]')相当
        // addEventListenerは on("change", function(e){}) 相当
        $.querySelector('input[name="picture1"]').addEventListener('change', function(e) {
            var file = e.target.files[0],
                   reader = new FileReader(),
                   $preview =  $.querySelector(".preview-img"), // jQueryの $(".preview")相当
                   t = this;
    
            // 画像ファイル以外の場合は何もしない
            if(file.type.indexOf("image") < 0){
              return false;
            }
    
            reader.onload = (function(file) {
              return function(e) {
                 //jQueryの$preview.empty(); 相当
                 while ($preview.firstChild) $preview.removeChild($preview.firstChild);
    
                // imgタグを作成
                var img = document.createElement( 'img' );
                img.setAttribute('src',  e.target.result);
                img.setAttribute('width', '150px');
                img.setAttribute('title',  file.name);
                // imgタグを$previeの中に追加
                $preview.appendChild(img);
              }; 
            })(file);
    
            reader.readAsDataURL(file);
        }); 
    });

/* preview2 インターンシップ新規投稿、編集 */
    // documentと毎回書くのがだるいので$に置き換え
    var $ = document; 
    var $form = $.querySelector('form');// jQueryの $("form")相当
    
    //jQueryの$(function() { 相当(ただし厳密には違う)
    $.addEventListener('DOMContentLoaded', function() {
        //画像ファイルプレビュー表示
        //  jQueryの $('input[type="file"]')相当
        // addEventListenerは on("change", function(e){}) 相当
        $.querySelector('input[name="picture2"]').addEventListener('change', function(e) {
            var file = e.target.files[0],
                   reader = new FileReader(),
                   $preview =  $.querySelector(".preview-img2"), // jQueryの $(".preview")相当
                   t = this;
    
            // 画像ファイル以外の場合は何もしない
            if(file.type.indexOf("image") < 0){
              return false;
            }
    
            reader.onload = (function(file) {
              return function(e) {
                 //jQueryの$preview.empty(); 相当
                 while ($preview.firstChild) $preview.removeChild($preview.firstChild);
    
                // imgタグを作成
                var img = document.createElement( 'img' );
                img.setAttribute('src',  e.target.result);
                img.setAttribute('width', '150px');
                img.setAttribute('title',  file.name);
                // imgタグを$previeの中に追加
                $preview.appendChild(img);
              }; 
            })(file);
    
            reader.readAsDataURL(file);
        }); 
    });

/* preview3 インターンシップ新規投稿、編集 */
    // documentと毎回書くのがだるいので$に置き換え
    var $ = document; 
    var $form = $.querySelector('form');// jQueryの $("form")相当
    
    //jQueryの$(function() { 相当(ただし厳密には違う)
    $.addEventListener('DOMContentLoaded', function() {
        //画像ファイルプレビュー表示
        //  jQueryの $('input[type="file"]')相当
        // addEventListenerは on("change", function(e){}) 相当
        $.querySelector('input[name="picture3"]').addEventListener('change', function(e) {
            var file = e.target.files[0],
                   reader = new FileReader(),
                   $preview =  $.querySelector(".preview-img3"), // jQueryの $(".preview")相当
                   t = this;
    
            // 画像ファイル以外の場合は何もしない
            if(file.type.indexOf("image") < 0){
              return false;
            }
    
            reader.onload = (function(file) {
              return function(e) {
                 //jQueryの$preview.empty(); 相当
                 while ($preview.firstChild) $preview.removeChild($preview.firstChild);
    
                // imgタグを作成
                var img = document.createElement( 'img' );
                img.setAttribute('src',  e.target.result);
                img.setAttribute('width', '150px');
                img.setAttribute('title',  file.name);
                // imgタグを$previeの中に追加
                $preview.appendChild(img);
              }; 
            })(file);
    
            reader.readAsDataURL(file);
        }); 
    });

/* preview4 インターンシップ新規投稿、編集 */
    // documentと毎回書くのがだるいので$に置き換え
    var $ = document; 
    var $form = $.querySelector('form');// jQueryの $("form")相当
    
    //jQueryの$(function() { 相当(ただし厳密には違う)
    $.addEventListener('DOMContentLoaded', function() {
        //画像ファイルプレビュー表示
        //  jQueryの $('input[type="file"]')相当
        // addEventListenerは on("change", function(e){}) 相当
        $.querySelector('input[name="picture4"]').addEventListener('change', function(e) {
            var file = e.target.files[0],
                   reader = new FileReader(),
                   $preview =  $.querySelector(".preview-img4"), // jQueryの $(".preview")相当
                   t = this;
    
            // 画像ファイル以外の場合は何もしない
            if(file.type.indexOf("image") < 0){
              return false;
            }
    
            reader.onload = (function(file) {
              return function(e) {
                 //jQueryの$preview.empty(); 相当
                 while ($preview.firstChild) $preview.removeChild($preview.firstChild);
    
                // imgタグを作成
                var img = document.createElement( 'img' );
                img.setAttribute('src',  e.target.result);
                img.setAttribute('width', '150px');
                img.setAttribute('title',  file.name);
                // imgタグを$previeの中に追加
                $preview.appendChild(img);
              }; 
            })(file);
    
            reader.readAsDataURL(file);
        }); 
    });

			jQuery(".wpmem_loginout").html('<a class="login_button" href="/user?um_user=suzutaka&a=logout">Log Out</a>');
			jQuery( "#request" ).val( "" );

var a = function() {
		jQuery(".um-cover").hover(function() {
	jQuery(".um-cover-overlay").fadeIn();
}, function() {
	jQuery(".um-cover-overlay").fadeOut();
});
};


var b = function () {
	jQuery(".um-cover-overlay-t").hover(function() {
	jQuery(".um-cover-overlay-t").css("color","#b5acac");
}, function() {
	jQuery(".um-cover-overlay-t").css("color","#fff");
});
};

var c = function () {
	jQuery(".um-manual-trigger .um-faicon-picture-o").hover(function() {
	jQuery(".um-manual-trigger .um-faicon-picture-o").css("color","#b5acac");
}, function() {
	jQuery(".um-manual-trigger .um-faicon-picture-o").css("color","#fff");
});
};
	// トプ画オーバーレイ
	var d = function () {
		jQuery(".um-profile-photo-img").hover(function() {
	jQuery(".um-profile-photo-overlay").fadeIn();
}, function() {
	jQuery(".um-profile-photo-overlay").fadeOut();
});
};

var e = function () {
	jQuery(".um-profile-photo-overlay-s .um-faicon-camera").hover(function() {
	jQuery(".um-profile-photo-overlay-s .um-faicon-camera").css("color","#b5acac");
}, function() {
	jQuery(".um-profile-photo-overlay-s .um-faicon-camera").css("color","#fff");
});
};



jQuery(function(){
var w = jQuery(window).width();
var x = 560;
if (w <= x) {
} else if(w > x) {
	a();
	b();
	c();
	d();
	e();
}
});


jQuery(window).resize(function(){
var w = jQuery(window).width();
var x = 560;
if (w <= x) {
} else if(w > x) {
	a();
	b();
	c();
	d();
	e();
}
});


function cancel() {
	jQuery(".um-editor").removeClass("active");
	jQuery(".um-edit-btn").removeClass("active");
}
function edit_base() {
	if (jQuery(".um-edit-btn-base").hasClass("active")) {
		cancel();
	}else {
		jQuery(".um-editor").removeClass("active");
		jQuery(".um-editor-base").addClass("active");
		jQuery(".um-edit-btn-base").addClass("active");
	}
}
function edit_univ() {
	if (jQuery(".um-edit-btn-univ").hasClass("active")) {
		cancel();
	}else {
		jQuery(".um-editor").removeClass("active");
		jQuery(".um-editor-univ").addClass("active");
		jQuery(".um-edit-btn-univ").addClass("active");
	}
}
function edit_abroad() {
	if (jQuery(".um-edit-btn-abroad").hasClass("active")) {
		cancel();
	}else {
		jQuery(".um-editor").removeClass("active");
		jQuery(".um-editor-abroad").addClass("active");
		jQuery(".um-edit-btn-abroad").addClass("active");
	}
}
function edit_programming() {
	if (jQuery(".um-edit-btn-programming").hasClass("active")) {
		cancel();
	}else {
		jQuery(".um-editor").removeClass("active");
		jQuery(".um-editor-programming").addClass("active");
		jQuery(".um-edit-btn-programming").addClass("active");
	}
}
function edit_skill() {
	if (jQuery(".um-edit-btn-skill").hasClass("active")) {
		cancel();
	}else {
		jQuery(".um-editor").removeClass("active");
		jQuery(".um-editor-skill").addClass("active");
		jQuery(".um-edit-btn-skill").addClass("active");
	}
}
function edit_community() {
	if (jQuery(".um-edit-btn-community").hasClass("active")) {
		cancel();
	}else {
		jQuery(".um-editor").removeClass("active");
		jQuery(".um-editor-community").addClass("active");
		jQuery(".um-edit-btn-community").addClass("active");
	}
}
function edit_internship() {
	if (jQuery(".um-edit-btn-internship").hasClass("active")) {
		cancel();
	}else {
		jQuery(".um-editor").removeClass("active");
		jQuery(".um-editor-internship").addClass("active");
		jQuery(".um-edit-btn-internship").addClass("active");
	}
}
function edit_interest() {
	if (jQuery(".um-edit-btn-interest").hasClass("active")) {
		cancel();
	}else {
		jQuery(".um-editor").removeClass("active");
		jQuery(".um-editor-interest").addClass("active");
		jQuery(".um-edit-btn-interest").addClass("active");
	}
}
function edit_experience() {
	if (jQuery(".um-edit-btn-experience").hasClass("active")) {
		cancel();
	}else {
		jQuery(".um-editor").removeClass("active");
		jQuery(".um-editor-experience").addClass("active");
		jQuery(".um-edit-btn-experience").addClass("active");
	}
}

jQuery(function(){
var wrp = ".um-edit-wrapper",
	btnOpen = ".menu-edit-icon",
	btnClose = ".edit-slide-close",
	sld = ".edit-slide",
	ovrly = ".edit-overlay",
	current_scrollY;

jQuery(btnOpen).on("click",function(e){
	if(jQuery(sld).css("display") == "none"){
		current_scrollY = jQuery( window ).scrollTop();
		jQuery(wrp).css({
			position: "fixed",
			width: "100%",
			top: -1 * current_scrollY
		});
		jQuery(sld).slideDown();
		jQuery(ovrly).css("display","block");
	}
});

jQuery(btnClose).on("click",function(){
	if(jQuery(sld).css("display") == "block"){
		jQuery(wrp).attr({style:""});
		jQuery("html, body").prop({scrollTop: current_scrollY});
		jQuery(sld).slideUp();
		jQuery(ovrly).fadeOut();
	}
});

jQuery(document).on("click",function(e) {
	if(jQuery(sld).css("display") == "block"){
		if ((!jQuery(e.target).closest(sld).length)&&(!jQuery(e.target).closest(btnOpen).length)) {
			jQuery(wrp).attr({style:""});
			jQuery("html, body").prop({scrollTop: current_scrollY});
			jQuery(sld).slideUp();
			jQuery(ovrly).fadeOut();
		}
	}
});

});

jQuery(function(){
var wrp = ".um-img-edit-wrapper",
		btnOpen = ".img-edit-icon",
		btnClose = ".edit-slide-close",
		sld = ".img-edit-slide",
		ovrly = ".img-edit-overlay",
		current_scrollY;

jQuery(btnOpen).on("click",function(e){
		if(jQuery(sld).css("display") == "none"){
				current_scrollY = jQuery( window ).scrollTop();
				jQuery(wrp).css({
						position: "fixed",
						width: "100%",
						top: -1 * current_scrollY
				});
				jQuery(sld).slideDown();
				jQuery(ovrly).css("display","block");
		}
});

jQuery(btnClose).on("click",function(){
		if(jQuery(sld).css("display") == "block"){
				jQuery(wrp).attr({style:""});
				jQuery("html, body").prop({scrollTop: current_scrollY});
				jQuery(sld).slideUp();
				jQuery(ovrly).fadeOut();
		}
});

jQuery(document).on("click",function(e) {
		if(jQuery(sld).css("display") == "block"){
				if ((!jQuery(e.target).closest(sld).length)&&(!jQuery(e.target).closest(btnOpen).length)) {
						jQuery(wrp).attr({style:""});
						jQuery("html, body").prop({scrollTop: current_scrollY});
						jQuery(sld).slideUp();
						jQuery(ovrly).fadeOut();
				}
		}
});

});
// クリックしたボタンのValueを取得する
// <input type="hidden".... を追加する
// クリックしたボタンのValue→<input type="hidden"....のvalueに追加する
function sort_by_new(){
	var insert = '<input type="hidden" name="sort" class="search-field" value="new">';
	jQuery(".sort-field").html(insert);
}
function sort_by_recommend(){
	var insert = '<input type="hidden" name="sort" class="search-field" value="recommend">';
	jQuery(".sort-field").html(insert);
}
function sort_by_popular(){
	var insert = '<input type="hidden" name="sort" class="search-field" value="popular">';
	jQuery(".sort-field").html(insert);
}