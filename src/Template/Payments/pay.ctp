<?php use Cake\Routing\Router; ?>
<center>
    <div style="font-size: 20px; font-weight: bold;">Please note down your Applicant Id for future reference: <?php echo $applicantId; ?></div>
<table width='100%' cellpadding='0' cellspacing="0" ><tr><th width='90%'>&nbsp;</th></tr></table>
	<!--<center><h3>PHP Integration Kit - Request Page</H3></center>-->

	<form  method="post" action="<?php echo $this->request->webroot; ?>payments/post" name="frmTransaction" id="frmTransaction" >  	 
     <table width="600" cellpadding="2" cellspacing="2" border="0">
        <tr>
            <th colspan="2">Transaction Details</th>
        </tr>
		<tr>
            <!--<td class="fieldName"><span class="error">*</span> Channel</td>-->
            <td align="left"><select name="channel" style="visibility:hidden;">
				<option value="10">Standard</option>
			</select></td>
        </tr>

	   <tr>
            <!--<td class="fieldName" width="50%"><span class="error">*</span> Account Id</td>-->
            <td  align="left" width="50%"> <input name="account_id" type="hidden" value="24828"/>
		<!--<br><span><font color="red"> Please Enter your Account ID provided.</font></span>--> </td> 
        </tr>
        <tr>
            <!--<td class="fieldName" width="50%"><span class="error">*</span> Secret Key</td>-->
            <td  align="left" width="50%"> <input name="secretkey" type="hidden" value="2401afdd1045e96b4804a3fe58b8edab" size="35"/>
			<!--<br><span><font color="red"> Please Enter your Secret Key provided.</font></span>--> </td>
        </tr>
	   <tr>
            <td class="fieldName" width="50%"><span class="error">*</span> Applicant Id</td>

            <td  align="left" width="50%"> <input name="reference_no" type="text" value="<?php echo $applicantId; ?>" readonly="readonly" /></td>
        </tr>
        <tr>
            <td class="fieldName" width="50%"><span class="error">*</span> Application Fee</td>
            <td  align="left" width="50%"> <input name="amount" type="text" value="<?php echo $app_fee; ?>" readonly="readonly" />
                            <select name="currency" >
				<option value="INR">INR</option>
                            </select></td>
        </tr>
		<tr>
		  <!--<td class="fieldName"><span class="error">*</span> Description</td>-->
		  <td align="left"><input name="description" type="hidden" value="Academic Fee 2016-17" /></td>
	   </tr>
		<tr>
		  <!--<td class="fieldName"><span class="error">*</span> Return Url</td>-->
		  <td align="left"><input name="return_url" type="hidden" size="60" value="<?php  //print_r(Router::url( $this->here, true ));
			$elems = parse_url(Router::url( $this->request->here(true), true ));
			echo "http://" . $elems['host'] . $this->request->webroot; ?>payments/returnpg" /></td>
	   </tr>
		<tr>
		  <!--<td class="fieldName"><span class="error">*</span> Mode</td>-->
		  <td align="left"><select name="mode" style="visibility:hidden;">
            <option value="LIVE" selected>LIVE</option>
          </select></td>
	   </tr>
        <tr>
            <th colspan="2">Billing Address</th>
        </tr>

	    <tr>
            <td class="fieldName"><span class="error">*</span> Name</td>
            <td align="left">
                <input name="name" type="text" value="" /></td>
        </tr>
       
        <tr>

            <td class="fieldName"><span class="error">*</span>Address</td>
            <td align="left">
                <textarea name="address"></textarea>            </td>
        </tr>

        <tr>
            <td class="fieldName"><span class="error">*</span>City</td>

            <td align="left">
                <input name="city" type="text" value="" />            </td>
        </tr>

        <tr>
            <td class="fieldName">State/Province</td>
            <td align="left">
               <input name="state" type="text" value="" />            </td>
        </tr>

        <tr>
            <td class="fieldName"><span class="error">*</span>ZIP/Postal Code</td>
            <td align="left">
                <input name="postal_code" type="text" value="" />            </td>
        </tr>
        <tr>
            <td class="fieldName"><span class="error">*</span>Country</td>
            <td align="left">
                <input name="country" type="text" value="IND" readonly="readonly"/>
            </td>
        </tr>
        <tr>
            <td class="fieldName"><span class="error">*</span>Email</td>
            <td align="left">
                <input name="email" type="text" value="" />            </td>
        </tr>
        <tr>
            <td class="fieldName"><span class="error">*</span>Telephone</td>
            <td align="left"><input name="phone" type="text" value="" /></td>
        </tr>
		
        <!--<tr>
            <th colspan="2">Delivery Address</th>
        </tr>-->

		<tr>

            <!--<td class="fieldName"> Name</td>-->
            <td align="left">
                <input name="ship_name" type="hidden" value="Central University of Punjab" /></td>
        </tr>
       
        <tr>
            <!--<td class="fieldName">Address</td>-->
            <td align="left">

                <input name="ship_address" type="hidden" value="City Campus, Mansa Road" />            </td>
        </tr>

        <tr>
            <!--<td class="fieldName">City</td>-->
            <td align="left">
                <input name="ship_city" type="hidden" value="Bathinda" />            </td>
        </tr>

        <tr>
            <!--<td class="fieldName">State/Province</td>-->
            <td align="left">
               <input name="ship_state" type="hidden" value="Punjab" />            </td>
        </tr>

        <tr>
            <!--<td class="fieldName">ZIP/Postal Code</td>-->
            <td align="left">
                <input name="ship_postal_code" type="hidden" value="151001" />            </td>
        </tr>

        <tr>
            <!--<td class="fieldName">Country</td>-->

            <td align="left"><input name="ship_country" type="hidden" value="IND" /></td>
        </tr>

        
        <tr>
            <!--<td class="fieldName">Telephone</td>-->
            <td align="left"><input name="ship_phone" type="hidden" value="0164-2864106" /></td>
        </tr>

        <tr>

            <td valign="top" align="center" colspan="2">
                <input name="submitted" value="Submit" type="submit" /><!--&nbsp; 
                 
                    <input value="Reset" type="reset" />-->                            </td>
        </tr>
	
        <tr>
            <td valign="top" align="center" colspan="2">
                <span class="error">*</span> 
                <span>denotes required field</span>            </td>
        </tr>
    </table>
</form>
<script>
    $(document).ready(function () {
        window.alert("Please note down Applicant Id for furture reference: <?php echo $applicantId; ?>");
        });
</script>
