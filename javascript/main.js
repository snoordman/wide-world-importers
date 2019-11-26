function changeActive(item){
    item.parent().find(".active").removeClass("active");
    item.addClass("active");
}

function setLimit(item, min = null, max = null){
    var itemValue = item.val();
    console.log(itemValue);
    console.log(min);
    console.log(max);
    if(itemValue > max){
        item.val(max);
    }else if(itemValue !== "" && min !== null && itemValue < min){
        item.val(min);
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


    $("#amountProduct").on('change keypress', function(e){
        //console.log($(this).val());
        console.log(e.originalEvent);

        var min = $(this)[0].min;
        var max = $(this)[0].max;

        if(min === undefined){min = null;}
        if(max === undefined){max = null;}

        if(!$.isNumeric(e.key) && e.key !== "Enter"){
            e.preventDefault();
        }
    });

    $(".chosen").chosen();
});