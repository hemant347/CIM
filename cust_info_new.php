<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add New Customer Information</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
		<script type="text/javascript">
			function validate_form(frm)
			{
				var flg = true;
				var reg_ex_name = /^([a-zA-Z ]+)$/;
				var reg_exp_postcode = /^(((2|8|9)\d{2})|((02|08|09)\d{2})|([1-9]\d{3}))$/;

				if(!reg_ex_name.test(frm.name.value))
				{
					document.getElementById('name_error').style.display = '';
					flg = false;
				}
				else
					document.getElementById('name_error').style.display = 'none';

				if(document.getElementById('address1').value == '')
				{
					document.getElementById('address1_error').style.display = '';
					flg = false;
				}
				else
					document.getElementById('address1_error').style.display = 'none';

				if(!reg_ex_name.test(frm.suburb.value))
				{
					document.getElementById('suburb_error').style.display = '';
					flg = false;
				}
				else
					document.getElementById('suburb_error').style.display = 'none';

				if(!reg_ex_name.test(frm.state.value))
				{
					document.getElementById('state_error').style.display = '';
					flg = false;
				}
				else
					document.getElementById('state_error').style.display = 'none';

				if(!reg_exp_postcode.test(frm.postcode.value))
				{
					document.getElementById('postcode_error').style.display = '';
					flg = false;
				}
				else
					document.getElementById('postcode_error').style.display = 'none';


				return flg;

			}

			function Update(id)
			{
				var name = ($('#cust_name_'+id).val());
				var add1 = ($('#cust_address1_'+id).val());
				var add2 = ($('#cust_address2_'+id).val());
				var suburb = ($('#cust_suburb_'+id).val());
				var state = ($('#cust_state_'+id).val());
				var postcode = ($('#cust_postcode_'+id).val());

				var data = "action=Update&id="+id+"&name="+name+"&address1="+add1+"&address2="+add2+"&suburb="+suburb+"&state="+state+"&postcode="+postcode;

				$.ajax({
						async: false,
						url:"ajax.php",
						data:data,
						dataType:"html",
						type: "POST",
						success: function(data){
							$("#main").html(data);
						}
					});
			}
		</script>
    </head>
    <body style="font-family: arial">
		<form name="cust_info_form" method="post" action="ajax.php" onsubmit="return validate_form(this);">
			<table width="450px">
				<tr>
					<td valign="top">
						<label for="name">Name &#42</label>
					</td>
					<td valign="top">
						<input type="text" name="name" id="name" maxlength="256" size="30"><br>
						<label id="name_error" style="font-size:10px;color:red;display:none;">&#42 Invalid 'Name'. Please enter correct 'Name'.<br></label>
						<label style="font-size:10px;">'Name' must contain characters only  e.g.(Brian Smith | john)</label>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="address1">Address1 &#42</label>
					</td>
					<td valign="top">
						<textarea name="address1" id="address1" maxlength="256" cols="15" rows="3" ></textarea><br>
						<label id="address1_error" style="font-size:10px;color:red;display:none;">&#42 Please enter 'Address1'.<br></label>
						<label style="font-size:10px;">e.g.(34 Good st | (303-91/A Gypsy St)</label>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="address2">Address2</label>
					</td>
					<td valign="top">
						<textarea name="address2" id="address2" maxlength="256" cols="15" rows="3" ></textarea>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="suburb">Suburb &#42</label>
					</td>
					<td valign="top">
						<input type="text" name="suburb" id="suburb" maxlength="256" size="30"><br>
						<label id="suburb_error" style="font-size:10px;color:red;display:none;">&#42 Invalid 'Suburb'. Please enter correct 'Suburb'.<br></label>
						<label style="font-size:10px;">'Suburb' must contain characters only  e.g.(Westmead | new castle)</label>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="state">State &#42</label>
					</td>
					<td valign="top">
						<input type="text" name="state" id="state" maxlength="3" size="10"><br>
						<label id="state_error" style="font-size:10px;color:red;display:none;">&#42 Invalid 'State'. Please enter correct 'State'.<br></label>
						<label style="font-size:10px;">'State' must contain characters only  e.g.(NSW | ACT)</label>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<label for="postcode">Postcode &#42</label>
					</td>
					<td valign="top">
						<input type="text" name="postcode" id="postcode" maxlength="4" size="12"><br>
						<label id="postcode_error" style="font-size:10px;color:red;display:none;">&#42 Invalid 'Postcode'. Please enter correct 'Postcode'.<br></label>
						<label style="font-size:10px;">'Postcode' must contain numbers only  e.g.(200 | 0820 | 2753)</label>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<h6>An astrisk (&#42) denotes a required field.</h6>
						<input type="submit" name="add" id="add" value="Add New" />
						<input type="button" name="View" value="View" onclick="location.href='cust_info.php'">
					</td>
				</tr>
			</table>
		</form>
    </body>
</html>
