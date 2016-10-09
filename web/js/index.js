// JavaScript Document
$(function(){
 
			// banner图自动滚动
		    //  var sWidth = $(".banner-content-list").width(); //获取焦点图的宽度（显示面积）
		    //  var len = $(".banner-content-list").length; //获取焦点图个数  
		    //  var index = 0;
		    //  var picTimer;
		    // //本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
		    // $(".banner-content-wrap").css("width", sWidth*(len));

		    // //鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
		    // $(".banner-content-wrap").hover(function(){
		    //     clearInterval(picTimer);
		    // },function(){
		    //     picTimer = setInterval(function(){
		    //         showPic(index);
		    //         index ++;
		    //         if(index == len) {index = 0;}
		    //     },4000);      //此4000代表自动播放间隔，单位:毫秒
		    // }).trigger("mouseleave");

		    // //显示图片函数，根据接收的index的值显示相应的内容
		    // function showPic(index){
		    //     var nowLeft = -index * sWidth;  //根据index的值计算ul元素的left值
		    //     //通过animate()调整ul元素滚动到计算出的position
		    //     $(".banner-content-wrap").stop(true, false)
		    //                          .animate({"left" : nowLeft},300);

		    // }
            // 首页轮播图
            var iNow = 0;
            var iImgLength = $(".banner-content-list").length-1;
            var iImgWidth = $(".banner-content-list").width();

            // alert(iImgWidth);

            function auto(){
                iNow==iImgLength ? iNow = 0 : iNow++;
                $(".banner-content-list").eq(iNow).fadeIn(2500).siblings().fadeOut(2500);
            }
            var bannerTimer = setInterval(auto, 4000);

            function changeColor()
            {
                $(".news-lists").hover(
                    function(){
                        $(this).children("span").addClass("current");
                    },
                    function(){
                        $(this).children("span").removeClass("current");
                    }
                );
            }
            changeColor();


		    // 首页其他两个按钮滚轮播图
		    function scrollnew(a,b,c,d,e,f,g){
            var a=0;
            var length = $(b).length;
            var width = $(b).width()
            $(c).width(length*width);
            function Move2(){
                var width=$(b).width();
                var movewidth=-a*width+"px";
                $(c).stop();
                $(c).animate({left:movewidth});
                }
            function Upindex2(){
                    a==(length-1)?a=0:a=a+1;
                    }
            function Downindex2(){
                    a==0?a=(length-1):a=a-1;
                    }
            $(d).click(function(){
                    Upindex2();
                    Move2();
                })
            $(e).click(function(){
                    Downindex2();
                    Move2();
                })
            function f(){
                    g=setInterval(function(){
                        Upindex2();
                        Move2();
                        },3000);        
                }
            $(b).mouseover(function(){
                clearInterval(g);
                })  
            $(b).mouseout(function(){
                f(); 
                })  
            
                f();   
        }   
        scrollnew('i',".cars-scroll-box-list",
            ".cars-scroll-imgs",".scrollbtn-r-bg",
            ".scrollbtn-l-bg",'scrollnewsiteTime1','time1');
        scrollnew('i',".wooden-scroll-box-list",
            ".wooden-scroll-imgs",".scrollbtn-r-bg2",
            ".scrollbtn-l-bg2",'scrollnewsiteTime2','time2');
        scrollnew('i',".cases-scroll-box-list",
            ".cases-scroll-imgs",".scrollbtn-r-bg3",
            ".scrollbtn-l-bg3",'scrollnewsiteTime3','time3');



//    经营范围hover事件
    $('.small-list').hover(function(){
        var index = $(this).index();
        $(this).find('.list-name').removeClass('font-191919').addClass('font-white');
        $(this).addClass('bg-305c98');
    },function(){
        $(this).find('.list-name').removeClass('font-white').addClass('font-191919');
        $(this).removeClass('bg-305c98');
    });

    //导航hover事件
    $('.nav-show-list').hover(function(){
        $(this).find('.nav-child').show();
    },function(){
        $(this).find('.nav-child').hide();
    });







})