$(function() {

    $("#range").on('propertychange input', function (e) {
        console.log(this.value);
        $("#price").val(this.value);
    });

    $("#price").change(function(){
        var value = this.value;

        $("#range").val(this.value);

    });
});