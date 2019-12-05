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

function clearSelect(select){
    select
        .find('option')
        .remove()
        .end()
    ;
}

$(function() {
    $(".chosen").chosen();

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

    $("#country").change(function() {
        console.log("hoi");
        $.ajax({
            type: "GET",
            url: 'functions/products.php', //the script to call to get data
            data: "CountryID=" + $("#country").val() + "&getProvinces=true", //you can insert url argumnets here to    pass to api.php
            dataType: "json",
            success: function (data) {
                clearSelect($("#province"));
                clearSelect($("#city"));
                if (data.length !== 0) {
                    console.log(data);
                    for(var i = 0; i < data.length; i++){
                        $("#province").append('<option value="' + data[i].StateProvinceId + '">' + data[i].StateProvinceName + '</option>');
                    }
                    $(".chosen").trigger("chosen:updated");
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });

    $("#province").change(function() {
        $.ajax({
            type: "GET",
            url: 'functions/products.php', //the script to call to get data
            data: "ProvinceID=" + $("#province").val() + "&getCities=true", //you can insert url argumnets here to    pass to api.php
            dataType: "json",
            success: function (data) {
                clearSelect($("#city"));
                if (data.length !== 0) {
                    console.log(data);
                    for(var i = 0; i < data.length; i++){
                        $("#city").append('<option value="' + data[i].CityID + '">' + data[i].CityName + '</option>');
                    }
                    $(".chosen").trigger("chosen:updated");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });

});