$(function(){var e,i=$(".slider_box").width(),s=$(".slider_box .silder_panel").length,r=0;$(".slider_box").append("<a class='prev'></a><a class='next'></a>");for(var n=0;n<s;n++)$imgUrl=$(".silder_panel").eq(n).find("img").attr("src"),$navItem='<div class="silder_nav_item"><img src="'+$imgUrl+'"></div>',$(".silder_nav").append($navItem);function l(e){var r=-(e+1)*i;0==r?$(".slider_box .silder_con").stop(!0,!1).animate({left:r},300,function(){$(".slider_box .silder_con").stop(!0,!1).css("left",-i*s)}):r==-(s+1)*i?$(".slider_box .silder_con").stop(!0,!1).animate({left:r},300,function(){$(".slider_box .silder_con").stop(!0,!1).css("left",-i)}):$(".slider_box .silder_con").stop(!0,!1).animate({left:r},300),-1==e&&(e=s-1),s<=e&&(e=0),$(".slider_box .silder_nav .silder_nav_item").removeClass("current").eq(e).addClass("current"),$(".slider_box .silder_nav .silder_nav_item").stop(!0,!1).animate({opacity:"0.6"},300).eq(e).stop(!0,!1).animate({opacity:"1"},300)}$(".slider_box .silder_con").css({width:i*(s+2),left:-i}),$(".silder_panel").eq(0).clone().appendTo($(".silder_con")),$(".silder_panel").eq(s-1).clone().prependTo($(".silder_con")),$(".slider_box .silder_nav .silder_nav_item").mouseenter(function(){l(r=$(".slider_box .silder_nav .silder_nav_item").index(this))}).eq(0).trigger("mouseenter"),$(".slider_box .prev").click(function(){l(r-=1),-1==r&&(r=s-1)}),$(".slider_box .next").click(function(){l(r+=1),s<=r&&(r=0)}),$(".slider_box").hover(function(){clearInterval(e)},function(){l(r),e=setInterval(function(){$(".slider_box .next").trigger("click")},4e3)}).trigger("mouseleave")});
