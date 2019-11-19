function changeActive(item){
    item.parent().find(".active").removeClass("active");
    item.addClass("active");
}

$(function() {

    $("#range").on('propertychange input', function (e) {
        console.log(this.value);
        $("#price").val(this.value);
    });

    $("#price").change(function(){
        var value = this.value;

        $("#range").val(this.value);

    });

    $('#carouselExampleControls').on('slide.bs.carousel', function (e) {
        // do something…
    })
});