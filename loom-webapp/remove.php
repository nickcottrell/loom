<?
//HACKJOB TO INSTEAD REQUEST THIS FROM THE SPECIFIED JSON
function getvaluefromjson($var) {
	$edit_url = $_REQUEST['edit'];
	$param_value = $_REQUEST[$var];
	$string = file_get_contents($edit_url);
	$json_o = json_decode($string);
	$jsonvar = $json_o->$var;
	return $jsonvar;
}

//set those vars 
$PERMALINK_VAL = getvaluefromjson('permalink');
$TITLE_VAL = getvaluefromjson('title');

if (isset($PERMALINK_VAL)) {

//now do the same as in "generate" but with the values defined as per above


  		function getAllTextile() {
			function loom_write_textile($var1, $var2) {
    			if($var == "categories") {
      				$textile_string = $var1.": "."[ ".$var2." ]"."\n";
    			} else {
      				$textile_string = $var1.": ".$var2."\n";
    			}
    			return $textile_string;
  				}
			$all = null;
			foreach($_REQUEST as $key=>$value) {
      			$all = $all . loom_write_textile($key, $value);
    		}
			return $all;
  		}

  		function getAlljson() {
			function loom_write_json($var1, $var2) {
    			$json_string = '"'.$var1.'":"'.$var2.'"'.",";
				return $json_string;
  			}
			$all = null;
			foreach($_REQUEST as $key=>$value) {
			$all = $all . loom_write_json($key, $value);
			}
			return $all;
		}

$postVARS = getAllTextile();

		$the_currentpost = 		
			"---"."\n".
			"permalink: ".$PERMALINK_VAL."\n".
			"layout: deleted"."\n".
			//"categories: "."[ ".$_REQUEST['categories']." ]"."\n".
			//$postVARS.			
			"---"."\n\n"
			//$_REQUEST['content']
			;

$feedVARS = getAlljson();

		$the_currentfeed =
			"---"."\n".
			"permalink: ".$PERMALINK_VAL."/feed"."\n".
			"layout: deleted"."\n".
			//"categories: [ feeds ]"."\n".
			"---"."\n\n".
			"{".
			//'"existing_filename":"'.$currentfile.
			//'",'.
			//'"existing_feedname":"'.$currentfeed.
			//'",'.
			//'"content":"'.$content_encoded.
			//'",'.
			$feedVARS.
			'"blank":"endcap"'.
			"}"
			;

//CLEAN UP STRINGS
$now = date("Y-m-d-His");

$strippedfilename = $TITLE_VAL;
//Lower case everything
$strippedfilename = strtolower($strippedfilename);
//Make alphanumeric (removes all other characters)
$strippedfilename = preg_replace("/[^a-z0-9_\s-]/", "", $strippedfilename);
//Clean up multiple dashes or whitespaces
$strippedfilename = preg_replace("/[\s-]+/", " ", $strippedfilename);
//Convert whitespaces and underscore to dash
$strippedfilename = preg_replace("/[\s_]/", "-", $strippedfilename);



//current post and feed filenames
$currentfile = $now."-".$strippedfilename;	
$currentfeed = $now."-".$strippedfilename."-feed";


//$currentfile = "sample";
$currentfilepath = $PERMALINK_VAL;
//$the_currentpost = $postVARS;

//$currentfeed = "sample-feed";
$feedpath = $PERMALINK_VAL."/feed/";
//$the_currentfeed = $feedVARS;


//WRITE "POST" FILE			
$currentfilepath="../loom-jekyll/_posts/".$currentfile.'.textile';
//Open file in writing mode
$currentfilehandler= fopen($currentfilepath, 'w') or die('ERROR: Could not open current file file!');
//Write text to file
fwrite($currentfilehandler,$the_currentpost) or die('ERROR: Could not write to file');
//Close file
fclose($currentfilehandler);


//WRITE CORRESPONDING JSON FILE		
$feedpath="../loom-jekyll/_posts/".$currentfeed.'.txt';	
//Open file in writing mode
$feedfilehandler= fopen($feedpath, 'w') or die('ERROR: Could not open JSON feed file!');
//Write text to file
fwrite($feedfilehandler,$the_currentfeed) or die('ERROR: Could not write to JSON feed file');
//Close file
fclose($feedfilehandler);


// EXECUTE SHELL COMMANDS
$shelloutput = shell_exec('cd ../loom-jekyll/; jekyll;');
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
<?if (isset($PERMALINK_VAL)) {?>

<h2>Page Removed.</h2>
<p><a href="http://localhost:3333/<?=$PERMALINK_VAL;?>/" target="_blank">http://localhost:3333/<?=$PERMALINK_VAL;?>/</a></p>
<p><a href="http://localhost:3333/<?=$PERMALINK_VAL;?>/" target="_blank">http://localhost:3333/<?=$PERMALINK_VAL;?>/feed/</a></p>
<p>NOTE: refreshing this page will clear these urls.</p>

<h3>Debug Info:</h3>
<pre><? echo $shelloutput ?></pre>

<?} else { ?>
<h2>No Pages Removed.</h2>
<? } ?>
</body>
</html>
