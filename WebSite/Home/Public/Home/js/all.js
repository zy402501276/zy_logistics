var tf = '';
function getShow(){

    setTimeout(function(){
        $('.aa').each(function(){
            if($(this).val()==''){
                console.log($(this).val())
                tf = false;
                return false;
            }else{
                console.log($(this).val())
                tf = true;
            };
        })
        setTimeout(function(){
            var x = 10000;
            var y = 1000;
            var rand = parseInt(Math.random() * (x - y + 1) + y);

            var rateX = 100;
            var rateY = 70;
            var randRate = parseInt(Math.random() * (rateX - rateY + 1) + rateY);

            if(tf){
                $(".loading-rate").text(randRate);
                $(".randRate").val(randRate);
                $(".loading-rate").show();


            	$(".amount").text(rand);
                $(".randPrice").val(rand);
                $(".amount").show();


            }else{
                $(".amount").hide();
                $(".loading-rate").hide();
            };

            console.log(tf)
        },500)

    },500);
};


//订单完成，当输入框内有值得时候显示价格

$(document).on('keydown', '.aa', function() {
    getShow();
})

$(document).click(function(event){
    getShow();
});



$('.nva-ul li').click(function() {
    $('.nva-ul li').css({ 'backgroundColor': '#363636', 'color': '#696969' });
    $(this).css({ 'backgroundColor': '#303030', 'color': '#fff' });
});

//新建订单

$('.nva-ul li').click(function() {
    $('.nva-ul li').css({ 'backgroundColor': '#363636', 'color': '#696969' });
    $(this).css({ 'backgroundColor': '#303030', 'color': '#fff' });
});

//筛选框
$('.newOrder-type-li').unbind('click');
$('.newOrder-type-li').click(function() {
    $(this).find('.type-ul1').toggle();
    $('.overMasking').toggle();
});

$('.type-ul1 li').each(function() {
    $(this).css({ 'backgroundColor': '#fff', 'color': '#898989' });
    if($(this).html() == $(this).parent().prev().html()) {
        $(this).css({ 'backgroundColor': '#9FC0E1', 'color': '#fff' });
    };
});

$('.type-ul1 li').unbind('click');
$('.type-ul1 li').click(function(event) {
    $(this).parent().prev().html($(this).html());
    $(this).parent().hide();
    $('.overMasking').hide();

    $('.type-ul1 li').each(function() {
        $(this).css({ 'backgroundColor': '#fff', 'color': '#898989' });
        if($(this).html() == $(this).parent().prev().html()) {
            $(this).css({ 'backgroundColor': '#9FC0E1', 'color': '#fff' });
        };
    });

    event.stopPropagation();
});

//遮罩
$('.overMasking').click(function() {
    $('.type-ul1').hide();
    $(this).hide();
    $('.order-map').hide();
});

$('.contact-driver').click(function() {
    $('.pop').show();
});
$('.pop1-close').click(function() {
    $('.pop').hide();
})
//单选
$('.check-span').click(function() {
    $(this).toggleClass('check-span-icon');
})

//完成订单

//$('.driver-advice').click(function(){
//  $('.driver-evaluate-area').toggle();
//  $('.add-evaluate').click(function () {
//		$('.pop2').show();
//  });
//});
$('.driver-advice').click(function() {
    $('.pop2').show();
});
//评价   星星
//$('.star-icon').unbind('click');
$('.star-icon').click(function() {
    var s = $(this).index();
    if($(this).hasClass('star-icon1')) {
        $('.star-icon').each(function(i, element) {
            if($(element).index() >= s) {
                $(element).removeClass('star-icon1');
            };
        })
    } else {
        $('.star-icon').each(function(i, ele) {
            if($(ele).index() <= s) {
                $(ele).addClass('star-icon1');
            } else {
                $(ele).removeClass('star-icon1');
            };

        });
    }
});

$('.content-button').click(function() {
    var selStar = 0;
    $('.star-icon').each(function() {
        if($(this).hasClass('star-icon1')) {
            selStar++;
        }
    });
});

$('.advice-box').bind('input propertychange', function() {
    var l = $(this).val().length;
    if(l > 500) {
        $(this).val($(this).val().substring(0, 500));
    };
    $('.words-num').html(500 - l * 1);
});

$('.proposal-evaluate').click(function(event) {
    event.stopPropagation();
})
$('.pop2').click(function(event) {
    $(this).hide();
})
//查看路线  弹出地图
$('.see-rotate').click(function() {
    $('.overMasking').show();
    $('.order-map').show();
})
