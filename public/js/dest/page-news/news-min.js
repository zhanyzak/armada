$(document).ready(function(){{let e=$(".together__wrap");$.each(e,function(){let e=$(this).find(".together__items"),t=$(this).find(".together__arrow--next"),o=$(this).find(".together__arrow--prev");$(".header__cart").on("click",function(){e.slick("slickGoTo",1)}),e.slick({slidesToShow:1,slidesToScroll:1,arrows:!0,nextArrow:t,prevArrow:o,responsive:[{breakpoint:1024,settings:{dots:!0}}]});let i=$(this).find(".slick-dots");window.matchMedia("(max-width: 1024px)").matches&&(i.append(t),i.prepend(o))})}}),$(document).ready(function(){});