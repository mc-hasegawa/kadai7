<?php
header('Content-Type: text/html; charset=UTF-8');
$file = fopen("lesson.bbs", "r+");
$unix_time = time()+(7 * 60 * 60);
$show_time = date('Y/m/d H:i:s',$unix_time);
if (isset($_POST["posting_content"]))
{
	$user_name = $_POST["posting_user_name"];
	$content = $_POST["posting_content"];
	if ($user_name == "")
	{
		$user_name = "匿名希望";
	}
	fseek($file,0,SEEK_END);
	fwrite($file,"\n***>>");
	fwrite($file,htmlspecialchars($user_name."\n"));
	fwrite($file,"date>>");
	fwrite($file,htmlspecialchars($show_time."\n"));
	fwrite($file,"cont>>\n");
	fwrite($file,htmlspecialchars($content));
	fwrite($file,"\ncontend>>");
	rewind($file);
}



$file_line_data = fopen("lesson.bbs", "r");
$response_count = 0;
for($file_line_num = 0; fgets($file_line_data); $file_line_num++);
$file_line_count = 1;
?>
<html>
<head>
<title>PHP課題7_2</title>
</head>
<script>
function posting_check()
{
	console.log(document.posting_form.posting_button.disabled);
	if(document.posting_form.posting_content.value == "")
	{
		document.posting_form.posting_button.disabled = "true";
	}
	else
	{
		document.posting_form.posting_button.disabled = "";
	}
}
</script>
<body>
	<p>PHP課題7_2</p>
	<p>
		======================================<br>
		<?php
		if ($file)
		{
			while (($buffer = fgets($file, 4096)) !== false)
			{
				if (preg_match("/\*\*\*>>/",$buffer))
				{
					$response_count++;
					echo $response_count.", ";
					echo str_replace("***>>","&nbsp",$buffer);
				}
				elseif (preg_match("/date>>/",$buffer))
				{
					echo "&nbsp(投稿日時:&nbsp";
					echo str_replace("date>>","",$buffer);
					echo ")<br>";
				}
				elseif (preg_match("/cont>>/",$buffer))
				{
					echo str_replace("cont>>","",$buffer);
				}
				elseif (preg_match("/contend>>/",$buffer))
				{
					if ($file_line_count < $file_line_num)
					{
						echo "<br>--------------------------------------<br>";
					}
					else
					{
						echo "<br>";
					}
				}
				else
				{
					echo $buffer;
					echo "<br>";
				}
				$file_line_count++;
			}
			if (!feof($file))
			{
				echo "Error: unexpected fgets() fail\n";
			}
		}
		?>
		======================================<br>
		<form action="" method="post" name="posting_form">
			名前
			<p><input type="text" name="posting_user_name" value=""></p>
			書き込む内容
			<p><textarea name="posting_content" rows="6" cols="40" wrap="hard" onChange="posting_check()"></textarea></p>
			<input name="posting_button" type="submit" value="書き込む" disabled>
		</form>
	</p>
</body>
</html>
<?php
fclose($file);
fclose($file_line_data);
?>