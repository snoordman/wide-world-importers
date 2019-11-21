function changeActive(item){
    item.parent().find(".active").removeClass("active");
    item.addClass("active");
}

function setLimit(item, min = null, max = null){
    itemValue = item.val();
    if(max !== null && item.val() > max && itemValue !== ""){
        console.log("WTF");
        item.val(max);
    }else if(min !== null && item.val() < min && itemValue !== ""){
        console.log("WERK");
        item.val(min)
    }
}

$(function() {

    $("#range").on('propertychange input', function (e) {
        console.log(this.value);
        $("#price").val(this.value);
    });

    $("#price").change(function(){
        var value = this.value;

        $("#range").val(value);

    });

    $("#amountProduct").on("change input", function(){
        setLimit($(this), 1);
    });

    $(".chosen").chosen();
});