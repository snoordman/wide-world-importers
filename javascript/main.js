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

function changeNumber(field, increase){
    var currentVal = field.val();
    console.log(
        currentVal
    );

    if(isNaN(currentVal)){
        field.val(1);
    }else if(increase === true){
        currentVal = Math.round(parseFloat(currentVal));
        field.val(currentVal + 1);
    }else{
        currentVal = Math.round(parseFloat(currentVal));
        field.val(currentVal - 1);
    }

    field.trigger("change");
}


$(function() {
    $(".chosen").chosen({
        width: "100%"
    });

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
                    $("#province").attr("data-placeholder", "Selecteer een optie")
                    $("#city").attr("data-placeholder", "Selecteer een optie")
                }else{
                    $("#province").attr("data-placeholder", "Geen opties beschikbaar")
                    $("#city").attr("data-placeholder", "Geen opties beschikbaar")
                }
                $("#province").trigger("change");
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
                    $("#city").attr("data-placeholder", "Selecteer een optie");
                }else{
                    $("#city").attr("data-placeholder", "Geen opties beschikbaar")
                }
                $(".chosen").trigger("chosen:updated");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });

    $(".quantity").change(function (){
        var value = $(this).val();
        if(isNaN(value)){
            $(this).val(1);
        }else{
            $(this).val(
                Math.round(parseFloat(value))
            );
        }
        console.log(this.form);
        this.form.submit();
    });
});