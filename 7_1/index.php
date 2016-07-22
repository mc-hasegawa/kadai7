<?php
header('Content-Type: text/html; charset=UTF-8');
$file = fopen("lesson.bbs", "r");
$file_line_data = fopen("lesson.bbs", "r");
$response_count = 0;
for($file_line_num = 0; fgets($file_line_data); $file_line_num++);
$file_line_count = 1;
?>
<html>
<head>
<title>PHP課題7_1</title>
</head>
<script>
</script>
<body>
	<p>PHP課題7_1</p>
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
				}
				elseif (preg_match("/date>>/",$buffer))
				{
					echo "&nbsp(投稿日時:&nbsp";
					echo str_replace("date>>","",$buffer);
					echo ")<br>";
				}
				elseif (preg_match("/cont>>/",$buffer))
				{
					echo str_replace("cont>>","&nbsp",$buffer);
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
			fclose($file);
		}
		?>
		======================================<br>
	</p>
</body>
</html>