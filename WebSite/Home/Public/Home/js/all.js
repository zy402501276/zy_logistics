//新建订单


$('.nva-ul li').click(function () {
    $('.nva-ul li').css({'backgroundColor':'#363636','color':'#696969'});
    $(this).css({'backgroundColor':'#303030','color':'#fff'});
});




//筛选框
$('.newOrder-type-li').unbind('click');
$('.newOrder-type-li').click(function () {
    $(this).find('.type-ul1').toggle();
    $('.overMasking').toggle();
});

$('.type-ul1 li').each(function () {
    $(this).css({'backgroundColor':'#fff','color':'#898989'});
    if($(this).html()==$(this).parent().prev().html()){
        $(this).css({'backgroundColor':'#9FC0E1','color':'#fff'});
    };
});


$('.type-ul1 li').unbind('click');
$('.type-ul1 li').click(function (event) {
   $(this).parent().prev().html($(this).html());
    $(this).parent().hide();
    $('.overMasking').hide();

    $('.type-ul1 li').each(function () {
        $(this).css({'backgroundColor':'#fff','color':'#898989'});
        if($(this).html()==$(this).parent().prev().html()){
            $(this).css({'backgroundColor':'#9FC0E1','color':'#fff'});
        };
    });

    event.stopPropagation();
});


//遮罩
$('.overMasking').click(function () {
    $('.type-ul1').hide();
    $(this).hide();
});



var newDom = '<ul class="goods-information-ul"><li><span>长:</span><input type="text"></li><li><span>宽:</span><input type="text"></li><li><span>高:</span><input type="text"></li><li><span>重量:</span><input type="text"></li><li><span>数量:</span><input type="text"></li><li><span>类别:</span><input type="text"><div class="delete-btn"></div></li></ul>';
var domIndex = 0;
//新增货物信息
$('.add-ul-btn').click(function (event) {
    domIndex++;
    $(this).prev().after(newDom);
    $('.newOder-goods-information').height(domIndex*40+80);
    console.log(domIndex,$('.newOder-goods-information').height());

    //删除
    $('.delete-btn').unbind('click');
    $('.delete-btn').click(function (event) {
        domIndex--;
        $(this).parent().parent().remove();
        $('.newOder-goods-information').height(domIndex*40+80);
        console.log(domIndex,$('.newOder-goods-information').height());
    });
});
$('.contact-driver').click(function(){
	$('.pop').show();
});
$('.pop1-close').click(function(){
	$('.pop').hide();
})
//单选
$('.check-span').click(function() {
		$(this).toggleClass('check-span-icon');
	})








//完成订单

$('.driver-advice').click(function(){
    $('.driver-evaluate-area').toggle();
    $('.add-evaluate').click(function () {

    });
});