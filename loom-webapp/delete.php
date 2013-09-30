<?
if (isset($_REQUEST['url'])) {
$edit = $_REQUEST['url'];
$editurl = "remove.php?edit=".$edit."/feed";
header('Location: '.$editurl);}
?>

<html>
<head>
</head>
<body>

<form name="default_form" method="post" action="delete.php">


<ul>
	<li><a href="write.php">write</a></li>
	<li><a href="edit.php">edit</a></li>
	<li><a href="delete.php">delete</a></li>
</ul>
<hr />


<h2>Paste a url to DELETE</h2>

<input type"textfield" name="url" />

<br /><br />						
<input class="" type="submit" name="submit" value="DELETE">

</form>



</body>
</html>