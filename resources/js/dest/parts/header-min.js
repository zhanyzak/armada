$(document).ready(function(){{let t=$(".main-content"),i=$(".header");function e(){let e=i.outerHeight();t.css({"margin-top":e+"px"})}$(window).resize(function(){e()}),e(),$(window).scroll(function(){let t=i.offset();0===t.top?$(".header__top, .header__categories, .header__bottom-pages").slideDown(200):t.top>30&&$(".header__top, .header__categories, .header__bottom-pages").slideUp(200),setTimeout(function(){e()},200)})}{$(".header");let e=$(".header__bars"),t=$(".overlay, .header__overlay"),i=$(".header__responsive");t.on("click",function(){t.fadeOut(200),i.removeClass("active")}),$.each(e,function(){$(this).on("click",function(){t.fadeIn(200),i.toggleClass("active")})})}{let e=$(".autosearch"),t=$(".autosearch__wrap"),i=$(".overlay");i.on("click",function(){i.fadeOut(200),e.slideUp(200)});let a=$(".header__search .search"),s=a.find("input"),o=(a.width(),a.offset().left);s.keyup(function(){0===$(this).val().length?(e.slideUp(200),a.find("button").removeClass("active"),i.fadeOut(200)):(i.fadeIn(200),a.find("button").addClass("active"),t.css({"max-width":"calc(100% - "+o-40+"px)",left:o+"px"}),e.slideDown(200))})}{let e=$(".categories__show"),t=$(".all-categories");e.on("click",function(){t.is(":visible")?t.slideUp(200):t.slideDown(200)}),t.mouseleave(function(){t.slideUp(200)}),$(document).mouseup(function(e){let i=t;i.is(e.target)||0!==i.has(e.target).length||i.slideUp(200)})}{let e=$(".all-categories__main-item--has-children");$(".all-categories");$.each(e,function(){let e=$(this).find(".all-categories__subcategories");$(this).on("mouseenter",function(){e.css({display:"block"}),e.find(".all-categories__subcategories-main-ul").css({height:e.find(".all-categories__subcategories-items-wrap").height()}),e.find(".all-categories__subcategories-items-wrap").mCustomScrollbar({axis:"x"})}),$(this).on("mouseleave",function(){e.css({display:"none"})})})}});