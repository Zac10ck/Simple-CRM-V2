<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "sample");
$column = array("dar.date","dar.client", "dar.person", "dar.phone", "dar.remark");
$query = "
 SELECT * FROM dar";
$query .= " WHERE ";
//if(isset($_POST["is_category"]))
//{
 //$query .= "product.category = '".$_POST["is_category"]."' AND ";
//}
if(isset($_POST["search"]["value"]))
{
 $query .= '(dar.client LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR dar.person LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR dar.phone LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR dar.remark LIKE "%'.$_POST["search"]["value"].'%") ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY dar.date DESC ';
}

$query1 = '';

if($_POST["length"] != 1)
{
 $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["date"];
 $sub_array[] = $row["client"];
 $sub_array[] = $row["person"];
 $sub_array[] = $row["phone"];
 $sub_array[] = $row["remark"];
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM dar";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>
