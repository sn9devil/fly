		/*日期选择*/
			layui.use('laydate', function() {
				var laydate = layui.laydate;
				var start = {
					elem: '#test1',
					type: 'date',
					min: 0,
					show: true,
					trigger: 'click',
					closeStop: '#test2'
				};
				var end = {
					elem: '#test2',
					type: 'date',
					min: 0,
					show: true,
					trigger: 'click',
					closeStop: '#test1'
				};
				lay('.go-time').on('click', function(e) {
					laydate.render(start);
				});
				lay('.end-time').on('click', function(e) {
					if ($('#test1').val() != null && $('#test1').val() != undefined && $('#test1').val() != '') {
						end.min = $('#test1').val();
					}
					laydate.render(end);
				});
			});
			/*日期选择end*/
	/*弹出面板*/
		layui.use('element', function() {
			var element = layui.element;
		});
	/*弹出面板end*/
	/*城市选择*/
	var cityA = $(".city_a_le1 a"); //城市
	var pla = $("#place"); //出发地
	var dest = $("#destination"); //目的地
	// 默认值
	inCity.width = "345"; //城市选择框  宽
	inCity.height = "auto"; //城市选择框  高
	inCity.id = "#in_city"; //城市选择框  父级ID
	inCity.Children = '.city_a_le1'; //城市名box
	// 初始化 城市HTML模板
	$(inCity.id).prepend(inCity._template.join(''));
	inCity.Hot(cityA);
	
	//城市 导航
	var apay = $(".screen a");
	
	var placeThis; //当前选择标签
	apay.click(function(obj) { //城市导航
		inCity.payment($(this));
	})
	
	inCity.place(pla); //出发地
	inCity.destination(dest); //目的地
	inCity.cityClick(cityA); //显示赋值城市
	/*城市选择end*/
	/*焦点选择*/
	// $(".tab-b1").parent().click(function(e){
	// 		console.log(e.target);
	// });
	$(document).click(function(){
		$('#in_city').hide(300);
	});
	$("#in_city").click(function(event){
		event.stopPropagation();
	});
	//  $('#place').blur(function() {
	//  
	//  });
	//  $('#in_city').focus(function() {
	//  	
	// });
	
	/*焦点选择end*/
	/*人数选择  差一个输入验证*/
	$('.d-selet').click(function() {
		var ul = $(".selet");
		if (ul.css("display") == "none") {
			ul.slideDown("fast");
		} else {
			ul.slideUp("fast");
		}
	});
	/*成人选择*/
	$(".bt1").click(function() {
		var num = parseInt($(".st").val(), 10);
		$(".st").val(num - 1);
		if (num == 2) {
			$(".bt1").attr("disabled", true);
		} else if (num > 2) {
			$(".bt2").attr("disabled", false);
		}
	});
	$(".bt2").click(function() {
		num = parseInt($(".st").val(), 10);
		$(".st").val(num + 1);
		if (num > 0 && num < 8) {
			$(".bt1").attr("disabled", false);
		} else {
			$(".bt2").attr("disabled", true);
		}
	});
	/*儿童选择*/
	$(".bt3").click(function() {
		var num = parseInt($(".st1").val(), 10);
		$(".st1").val(num - 1);
		if (num == 1) {
			$(".bt3").attr("disabled", true);
		} else if (num > 0) {
			$(".bt4").attr("disabled", false);
		}
	});
	$(".bt4").click(function() {
		num = parseInt($(".st1").val(), 10);
		$(".st1").val(num + 1);
		if (num >= 0 && num < 8) {
			$(".bt3").attr("disabled", false);
		} else {
			$(".bt4").attr("disabled", true);
		}
	});
	/*儿童选择end*/
	peoplenum = parseInt($(".st").val(), 10);
	chreanum = parseInt($(".st1").val(), 10);
	if (peoplenum == 1) {
		$(".bt1").attr("disabled", true);
	}
	if (chreanum == 0) {
		$(".bt3").attr("disabled", true);
	}
	$(".bt1,.bt2,.bt3,.bt4").click(function() {
		var peoplenum = parseInt($(".st").val(), 10);
		var chreannum = parseInt($(".st1").val(), 10);
		var allnum = peoplenum + chreannum
		if (allnum == 9) {
			$(".bt2").attr("disabled", true);
			$(".bt4").attr("disabled", true);
		} else {
			$(".bt2").attr("disabled", false);
			$(".bt4").attr("disabled", false);
		}
		$(".pl").val(peoplenum + "成人" + chreannum + "儿童");
	});
	/*成人选择end*/
	/*人数选择end*/
	/*按钮点击*/
	$('.d1').click(function() {
		$('.d1').addClass('on');
		$('.d2').removeClass('on');
		$('.end-time').addClass('nt');
		$('.d-selet').css("left", "24px");
		$('.selet').css("left", "57px");
	});
	$('.d2').click(function() {
		var nt = $(".nt");
		if (nt.css("display") == "none") {
			nt.slideDown("fast");
		}
		$('.d2').addClass('on');
		$('.d1').removeClass('on');
		$('.end-time.nt').removeClass('nt');
		setTimeout(function() {
			$('.d-btn').css("position", "relative")
		}, 60);
		setTimeout(function() {
			$('.tab-b1').css("padding-bottom", "100px")
		}, 60);
	});
	/*按钮点击end*/
	/*地址转换*/
	$('.shift').click(function() {
		var place = $('#place').val();
		var destination = $('#destination').val();
		$('#place').val(destination);
		$('#destination').val(place);
	});
	/*地址转换*/