
//$(document).ready(function(){
    var tedirut = <?php echo $tedirut ?>;
    //console.log("Tedirut: ");
    $(".date").datepicker(
        $.datepicker.regional["he"]);
    var changeMonth = $(".date").datepicker("option", "changeMonth");
    var changeYear = $(".date").datepicker("option", "changeYear");
    $(".date").datepicker("option", "changeMonth", true);
    $(".date").datepicker("option", "changeYear", true);
    $(".date").datepicker("option", "showOn", "button");
    $(".date").datepicker("option", "buttonImage", "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif");
    $(".date").datepicker("option", "buttonImageOnly", "true");
    $(".date").datepicker("option", "buttonText", "סמן תאריך");
    $("#tpl_datedone").datepicker('setDate', 'today');
    //$("#tpl_datetodo").datepicker('setDate', '+<?php echo $tedirut ?>m');
    $("#tpl_datetodo").datepicker('setDate', +tedirut+'m');

    
    $("#tpl_datedone").change(function() {
        var dateNew = $("#tpl_datedone").datepicker('getDate');
        //dateNew.setMonth(dateNew.getMonth() +<?php echo $tedirut ?>);
        dateNew.setMonth(dateNew.getMonth() +tedirut);
        $("#tpl_datetodo").datepicker('setDate', dateNew);
    });
//});