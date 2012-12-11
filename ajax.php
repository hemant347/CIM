
<?php
	include_once 'common.php';

	$get = new Common();

	$msg = '';
	if(isset($_POST['add']) && $_POST['add'] != '')
	{
		$data = array();
		$data['name'] = trim(mysql_real_escape_string($_POST['name']));
		$data['address1'] = trim(mysql_real_escape_string($_POST['address1']));
		$data['address2'] = trim(mysql_real_escape_string($_POST['address2']));
		$data['suburb'] = trim(mysql_real_escape_string($_POST['suburb']));
		$data['state'] = trim(mysql_real_escape_string($_POST['state']));
		$data['postcode'] = trim(mysql_real_escape_string($_POST['postcode']));

		$add_row = new Common();
		$add_row->Add($data);
		unset($add_row);
		header("Location:cust_info.php");
	}

	if(isset($_POST['action']) && $_POST['action'] != '')
	{
		$action = new Common();

		if($_POST['action'] == 'Update')
		{
			$data = array();
			$data['id'] = trim(mysql_real_escape_string($_POST['id']));
			$data['name'] = trim(mysql_real_escape_string($_POST['name']));
			$data['address1'] = trim(mysql_real_escape_string($_POST['address1']));
			$data['address2'] = trim(mysql_real_escape_string($_POST['address2']));
			$data['suburb'] = trim(mysql_real_escape_string($_POST['suburb']));
			$data['state'] = trim(mysql_real_escape_string($_POST['state']));
			$data['postcode'] = trim(mysql_real_escape_string($_POST['postcode']));
			$msg_id = $action->Update($data);
			$msg = "Record has been Updated";
		}
		else if($_POST['action'] == 'Delete')
		{
			$id = trim(mysql_real_escape_string($_POST['id']));
			$msg_id = $action->Delete($id);
			$msg = "Record has been Deleted";

		}
		unset($action);
	}

	if(isset($_POST['page']) && $_POST['page'] != '')
	{
		$get_data = $get->Get_data($_POST['page']);
	}
	else
		$get_data = $get->Get_data(1);

	$rows = $get->Get_count_num_rows();
	$total_pages = ceil($rows/5);

	if(isset($_POST['action']) && $_POST['action'] == 'Search')
	{
		$action = new Common();
		$search_text = trim(mysql_real_escape_string($_POST['search_text']));
		$get_data = $action->Search($search_text);
		$total_pages = 0;
	}


		echo "<ul>";
			for($i=1;$i<=$total_pages;$i++){
				echo "<li><a href='#' onclick=getPage(".$i.")>".$i."</a></li>";
			}
		echo "</ul>";

		if(mysql_num_rows($get_data) > 0)
		{
			if($msg != '')
				echo "<p>".$msg."</p>";

			echo "<table>
					<thead>
						<th>Name</th>
						<th>Address1</th>
						<th>Address2</th>
						<th>Suburb</th>
						<th>State</th>
						<th>Postcode</th>
						<th colspan='3'>Action</th>
					</thead>
					<tbody> ";

					$i = 0;
					while ($row = mysql_fetch_array($get_data)) {
						$i++;

					echo "<tr id='".$i."'>";
						echo "<td><input name='cust_name' type='text' id='cust_name_".$row['id']."' value='".$row['name']."' maxlength='256'></td>";
						echo "<td><textarea name='cust_address1' id='cust_address1_".$row['id']."' cols='15' rows='3' maxlength='256'>".$row['address1']."</textarea></td>";
						echo "<td><textarea name='cust_address2' id='cust_address2_".$row['id']."' cols='15' rows='3' maxlength='256'>".$row['address2']."</textarea></td>";
						echo "<td><input name='cust_suburb' type='text' id='cust_suburb_".$row['id']."' value='".$row['suburb']."' maxlength='256'></td>";
						echo "<td><input name='cust_state' type='text' id='cust_state_".$row['id']."' value='".$row['state']."' maxlength='3'></td>";
						echo "<td><input name='cust_postcode' type='text' id='cust_postcode_".$row['id']."' value='".$row['postcode']."' maxlength='4'></td>";
						echo "<td><input type='button' name='btn_update' id='btn_update_".$row['id']."' value='Update' onclick='return Validate(".$row['id'].");'></td>";
						echo "<td><input type='button' name='btn_delete' id='btn_delete_".$row['id']."' value='Delete' onclick='Delete(".$row['id'].");'></td>";
					echo "</tr>";
					}
				echo "</tbody>";
			echo "</table>";
		}
