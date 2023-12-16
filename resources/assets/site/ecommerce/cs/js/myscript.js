function errorpageHeight() {
    if (1025 < $(window).width()) {
        var e = $(window).height(), i = $("footer").height() + 34, o = Math.abs(e - i);
        $(".page404").css("min-height", o);
        var t = $(".wrapper404").height() - 100, a = Math.abs((o - t) / 2);
        $(".wrapper404").css("padding-top", a)
    }
}
function ViewFullClick(e) {
    return $("a.view_box").removeClass("active"), $(e).addClass("active"), $(".shop_block").addClass("variable-sizes"), TovarPhotoHeight(), !1
}

function ViewBoxClick(e) {
    return $("a.view_full").removeClass("active"), $(e).addClass("active"), $(".shop_block").removeClass("variable-sizes"), TovarPhotoHeight(), !1
}

function TovarPhotoHeight() {
    $(".tovar_img_wrapper img").height();
    var e = -1;
    $(".tovar_img_wrapper img").each(function (i) {
        $(this).height() > e && (e = $(this).height())
    }), $(".tovar_img_wrapper").css("height", e)
}

function OpenURL(e) {
    window.open(e, "_self")
}

function ViewFullClick(e) {
    return $("a.view_box").removeClass("active"), $(e).addClass("active"), $(".shop_block").addClass("variable-sizes"), TovarPhotoHeight(), !1
}

function ViewBoxClick(e) {
    return $("a.view_full").removeClass("active"), $(e).addClass("active"), $(".shop_block").removeClass("variable-sizes"), TovarPhotoHeight(), !1
}

function OpenURL(e) {
    window.open(e, "_self")
}
