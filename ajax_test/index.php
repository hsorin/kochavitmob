<?php  include ('../includes/header.php'); ?>

<div id="main">
    Text to replace.....
</div>
<button id="ajax" type="button">Ajax</button>

<script>
    function replace(){
    $.ajax({
        url: 'text_test.txt',
        type: 'GET',
        dataType: 'text',
       // data: {param1: 'value1'},
       success: function(data) {
        $('#main').html(data);
       }
    });
    };

    $("#ajax").on('click', function(event) {
        replace();
    });
</script>

<script>
 /*   function replace () {
        console.log('start replace');

        var xhr = new XMLHttpRequest();
        console.log('create');
        xhr.open('GET', 'text_test.txt', true);
        console.log('open');
        xhr.onreadystatechange = function(){
            console.log('readyState: ' + xhr.readyState);
            if (xhr.readyState==2) {
                $("#main").html('Loading...');
            }
            if (xhr.readyState==4 && xhr.status == 200) {
                $("#main").html(xhr.responseText);
            }
        }
        xhr.send();
    }

    $("#ajax").on('click', function() {
        replace();
    });
    */
</script>


<!--
<h2>The XMLHttpRequest Object</h2>

<p id="demo">Let AJAX change this text.</p>

<button type="button" onclick="loadDoc()">Change Content</button>
 -->
<script>
// function loadDoc() {
//   var xhttp = new XMLHttpRequest();
//   xhttp.onreadystatechange = function() {
//     if (this.readyState == 4 && this.status == 200) {
//       document.getElementById("demo").innerHTML = this.responseText;
//     }
//   };
// xhttp.open("GET", "ajax_info.txt", true);
//   xhttp.send();
// }
</script>


<?php  include '../includes/footer.php'; ?>