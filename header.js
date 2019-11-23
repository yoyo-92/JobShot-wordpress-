// 新規登録ボタンエラー修正
window.addEventListener('load', function () {
    var str = document.getElementsByClassName("um-right um-half");
    for (i = 0; i < str.length; i++) {
        str[i].innerHTML = '<a href="http://builds-story.com/regist" class="um-button um-alt">新規登録</a>';
      }
});
/* top_accordion_script */
const accs = document.getElementsByClassName('select-dropdown-check')
const shadows = document.getElementsByClassName('select-dropdown-shadow')

function closeOthers(i) {
  for (let j = 0; j < accs.length; j++) {
    if (i !== j) {
      accs[j].checked = false
    }
  }
}

function closeAll() {
  for (let j = 0; j < accs.length; j++) {
    accs[j].checked = false
  }
}

for (let i = 0; i < accs.length; i++) {
  accs[i].addEventListener('click', () => {
    closeOthers(i)
  })
}

for (let i = 0; i < accs.length; i++) {
  shadows[i].addEventListener('click', () => {
    closeAll()
  })
}

/* card_aline_fix */
const containers = document.getElementsByClassName('cards-container')

for (let j = 0; j < containers.length; j ++) {
    const container = containers[j]
    const num = container.childNodes.length

    for (let i = 0; i < num; i++) {
        const emptyElm = document.createElement('div')
        emptyElm.classList.add('card', 'empty')
        container.appendChild(emptyElm)
    }
}

/* bxSlider */
$(function(){
	 $('.slider').bxSlider({
		auto: true,
		pause: 3000,
		adaptiveHeight: true,
		adaptiveHeightSpeed: 100,
		autoHover: true,
		autoControls: true,
		autoControlsCombine: true,
	});
});


/* top-page */
function slide() {
    if($('.searched-icon').hasClass('searched-icon-change')) {
        $('.searched-icon').removeClass('searched-icon-change');
        $('searched').css('color','#03c4b0','background-color','#fff');
    }else {
        $('.searched-icon').addClass('searched-icon-change');
        $('searched').css('color','#fff','background-color','#03c4b0');
    }

    $('.search-container').slideToggle('fast');
}
$(function() {
    $('.searched').attr('onclick', 'slide()');
});

$(function() {
    $('#footer #text-9 .textwidget p a br').remove();
    $('#post-1600 .um-misc-ul li a br').remove();
});


/* search-form-test, code:searach-form.php */
function clickBtn1() {
    var w = screen.width;
    var x = 1023;
    if (w <= x) {
        const color3 = document.form3.selective;
        if (color3[0].checked == true) {
            for (let i = 1; i < color3.length; i++){
                color3[i].checked = false;
            }
        }
    }
}

function clickBtn2() {
    var w = screen.width;
    var x = 1023;
    if (w <= x) {
        const color3 = document.form3.selective;
        if (color3[1].checked == true) {
            for (let i = 0; i < color3.length; i++){
                if (i != 1){
                    color3[i].checked = false;
                }
            }
        }
        }
}

function clickBtn3() {
    var w = screen.width;
    var x = 1023;
    if (w <= x) {
        const color3 = document.form3.selective;
        if (color3[2].checked == true) {
            for (let i = 0; i < color3.length-1; i++){
                color3[i].checked = false;
            }
        }
    }
}