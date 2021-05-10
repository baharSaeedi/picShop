$("[data-target='#MyModal']").click(function () {
    $(".modal img").attr("src",$(this).children("img").attr("src"));
    $(".modal .picName").text($(this).parent().children(".picName").text());
    $(".modal .pricePic").text($(this).parent().children(".pricePic").text());
    $(".modal .typePic").text($(this).parent().children(".typePic").text());
    $(".modal .addPic").attr("href", $(this).children().children(".picAdd").attr("data-pic"));
})



// $(".addPic").click(function (){
//     var shoppingCount = parseInt($(".shopCart").text())+1;
//     $(".shopCart").text(shoppingCount);
// })


function closeMenu()
{
    $(".navbar-collapse").removeClass("show");
}
$(".closeCollapse").click(function () {
    closeMenu();
})


$(window).scroll(function () {
    if ($(".mainmenu").offset().top >50)
    {
        $(".mainmenu").css("background","#f0f0f0");
    }
    else
    {
        $(".mainmenu").css("background","transparent");
    }
})