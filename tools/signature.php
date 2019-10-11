<?php  include '../includes/header.php'; ?>


<script src="../js/jSignature.min.js"></script>
<script src="../js/modernizr.js"></script>


<style type="text/css">    

	input {
		padding: .5em;
		margin: .5em;
	}

	select {
		padding: .5em;
		margin: .5em;
	}

	#signatureparent {
		color:darkblue;
		background-color:darkgrey;
		padding:20px;
	}
	/*This is the div within which the signature canvas is fitted*/

	#signature {
		border: 2px dotted black;
		background-color:lightgrey;
	}

	/* Drawing the 'gripper' for touch-enabled devices */ 
	html.touch #content {
		float:left;
		width:92%;
	}

	html.touch #scrollgrabber {
		float:right;
		width:4%;
		margin-right:2%;
		background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAFCAAAAACh79lDAAAAAXNSR0IArs4c6QAAABJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwAAAABJRU5ErkJggg==)
	}
	html.borderradius #scrollgrabber {
		border-radius: 1em;
	}
</style>

<?php
    if (isset($_POST['hdnSig'])) {
        $hdnSig = $_POST['hdnSig'];
        $path = '../images/signature.png';
        $hdnSig = base64_decode($hdnSig);
        file_put_contents($path, $hdnSig);
        
        echo "<script>window.close();</script>";
    }
?>

<form method="post" action="signature.php">
    <div class="col col-sm-12">
        <div id="signatureparent">
            <div id="signature"></div>
            <input type="hidden" name="hdnSig" id="hdnSig"/>
            <br>
            <input type="button" class="btn btn-primary" id="click" value="שמור חתימה"/>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        var $sigdiv = $("#signature");
        $sigdiv.jSignature({'UndoButton':true});
        $('#click').click(function(){
            var data = $sigdiv.jSignature("getData", "image");
            $('#hdnSig').val(data[1]);
            document.forms[0].submit();
        });
    });
</script>

<?php  include '../includes/footer.php'; ?>