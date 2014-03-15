<?
//Template Input Functions

function textarea($var, $var2) {
	$edit_url = $_REQUEST['edit'];
	$param_value = $_REQUEST[$var];
	$string = file_get_contents($edit_url);
	$json_o = json_decode($string);
	$jsonvar = $json_o->$var;
	echo "<textarea name='".$var."' placeholder='".$var2."'>";
	if (isset($param_value)){
		echo $param_value;
	} else if (isset($jsonvar)){
		echo $jsonvar;
	} else {	
		//do nothing;
	}
	echo "</textarea>";
}


?>

<html>
<head>
</head>
<body>


<ul>
	<li><a href="write.php">write</a></li>
	<li><a href="edit.php">edit</a></li>
	<li><a href="delete.php">delete</a></li>
</ul>
<hr />

<form name="default_form" method="post" action="generate.php">


<h2>Post a Page</h2>

Permalink<br />
<? textarea('permalink');?>
<br /><br />

Title<br />
<? textarea('title');?>
<br /><br />

Text</br />
<? textarea('text');?>
<? //eventually need to add a textarea_encoded();?>

<br /><br />						
<input class="" type="submit" name="submit" value="Post">

</form>



</body>
</html>
