<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
        <title></title>
		<style>
			table{border:1px solid #000;padding:0px;margin:0px;cellpadding:10px;}
			tr{vertical-align: top;}
			th,td{border: 1px solid grey;border-collapse: collapse;}
			thead{background-color: #e2e2e2;}
			ul{list-style-type: none}
			li{display: inline;padding:5px;}
			input[type="text"],textarea{border:1px solid #333;margin:5px;}
			p{color:red;}
		</style>
		<script>
			var XMLHttpFactories = [
			function () {return new XMLHttpRequest()},
			function () {return new ActiveXObject("Msxml2.XMLHTTP")},
			function () {return new ActiveXObject("Msxml3.XMLHTTP")},
			function () {return new ActiveXObject("Microsoft.XMLHTTP")}
			];

			function createXMLHTTPObject()
			{
				var xmlhttp = false;
				for (var i=0;i<XMLHttpFactories.length;i++) {
					try {
						xmlhttp = XMLHttpFactories[i]();
					}
					catch (e) {
						continue;
					}
					break;
				}
				return xmlhttp;
			}
			function showCustomers()
			{
				var xmlhttp = createXMLHTTPObject();
				if (!xmlhttp) return;

				xmlhttp.onreadystatechange=function()
				{
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						document.getElementById("main").innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open("POST","ajax.php",true);
				xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xmlhttp.send();
			}

			function getPage(page)
			{
				var xmlhttp = createXMLHTTPObject();
				if (!xmlhttp) return;

				xmlhttp.onreadystatechange=function()
				{
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						document.getElementById("main").innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open("POST","ajax.php",true);
				xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xmlhttp.send("page="+page);
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

			function Delete(id)
			{
				if(confirm("Are you sure you want to delete record?"))
				{
					$.ajax({
						async: false,
						url:"ajax.php",
						data:{action:'Delete',id:id},
						dataType:"html",
						type: "POST",
						success: function(data){
							$("#main").html(data);
						}
					});
				}
			}

			function Search()
			{
				var search_text = ($('#txt_search').val());

				$.ajax({
					async: false,
					url:"ajax.php",
					data:{action:'Search',search_text:search_text},
					dataType:"html",
					type: "POST",
					success: function(data){
						$("#main").html(data);
					}
				});

			}
			function Validate(id)
			{
				var flg = true;
				var reg_ex_name = /^([a-zA-Z ]+)$/;
				var reg_exp_postcode = /^(((2|8|9)\d{2})|((02|08|09)\d{2})|([1-9]\d{3}))$/;

				var name = ($('#cust_name_'+id).val());
				var add1 = ($('#cust_address1_'+id).val());
				var add2 = ($('#cust_address2_'+id).val());
				var suburb = ($('#cust_suburb_'+id).val());
				var state = ($('#cust_state_'+id).val());
				var postcode = ($('#cust_postcode_'+id).val());

				if(!reg_ex_name.test(name))
				{
					alert('Invalid Name. Please enter correct Name!');
					$('#cust_name_'+id).focus();
					flg = false;
				}
				else if(add1 == '')
				{
					alert('Invalid Address1. Please enter correct Address1!');
					$('#cust_address1_'+id).focus();
					flg = false;
				}
				else if(!reg_ex_name.test(suburb))
				{
					alert('Invalid Suburb. Please enter correct Suburb!');
					$('#cust_suburb_'+id).focus();
					flg = false;
				}
				else if(!reg_ex_name.test(state))
				{
					alert('Invalid State. Please enter correct State!');
					$('#cust_state_'+id).focus();
					flg = false;
				}
				else if(!reg_exp_postcode.test(postcode))
				{
					alert('Invalid Postcode. Please enter correct Postcode!');
					$('#cust_postcode_'+id).focus();
					flg = false;
				}

				if(flg == true)
					Update(id);
				else
					return false;
			}

		</script>
    </head>
    <body onload="showCustomers();">
		<div style="">
			<input type="text" name="txt_search" id="txt_search" value="" title="type in a name">
			<input type="button" name="btn_search" id="btn_search" value="Search" onclick="Search();">
			<input type="button" name="add" id="add" value="Add New" onclick="location.href='cust_info_new.php'">
			<input type="button" name="View" value="View" onclick="location.href='cust_info.php'">
		</div>
		<div id="main"></div>
    </body>
</html>

<script type="text/javascript">



</script>