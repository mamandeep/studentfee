
<h3>Please wait, redirecting to process payment..</h3>
<form action="<?php echo $ACTION_URL;?>" name="payment" method="POST">
<?php
	foreach($_POST as $key => $value) {
?>
<input type="hidden" value="<?php echo $value;?>" name="<?php echo $key;?>"/>
<?php
	}
?>
<input type="hidden" value="<?php echo $secureHash; ?>" name="secure_hash"/>
</form>
<script>
	$( document ).ready( function(){
		document.payment.submit();
	} );
</script>
