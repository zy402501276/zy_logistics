//订单完成，当输入框内有值得时候显示价格
// $(document).on('change', '.aa', function() {
// 	var a1 = $(".a1").val();
// 	var a2 = $(".a2").val();
// 	var a3 = $(".a3").val();
// 	var a4 = $(".a4").val();
// 	var a5 = $(".a5").val();
// 	var a6 = $(".a6 option:selected").text();
// 	var a7 = $(".a7").val();
// 	var a8 = $(".a8").val();
// 	var a9 = $(".a9").val();
// 	if(a1 == "" || a2 == "" || a3 == "" || a4 == "" || a5 == "" || a6 == "" || a7 == "" || a8 == "" || a9 == "") {
// 		$(".amount").hide();
// 	} else {
// 		$(".amount").show();
// 	}
// 	console.log(a1, a2, a3, a4, a5, a6, a7)
// })

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