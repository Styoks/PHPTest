<?php

/*----------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 * Licensed under the MIT License. See LICENSE in the project root for license information.
 *---------------------------------------------------------------------------------------*/

function sayHello($name) {
	echo "Hello $name!";
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>

<html>
	<head>
		<title>Visual Studio Code Remote :: PHP</title>
	</head>
	<body>
		<div>
			<h1>Calculator</h1>
			<div>
				<form action="">
					<input type="text" name="userName" id="userName" placeholder="name">
					<input type="text" required name="subject1" id="subject1">
					<input type="text" required name="subject2" id="subject2">
					<input type="text" name="subject3" id="subject3">
					<button type="submit">Send</button>
				</form>
			</div>
		</div>
		<?php 
		$array = array(
			($_GET['subject1']),
			($_GET['subject2']),
			($_GET['subject3'])
		);

		$array2 = array(
			$_GET['userName'] => ($array)
		);

		if (!is_numeric($_GET['subject1']) || !is_numeric($_GET['subject2']) || (!is_numeric($_GET['subject3']) && $_GET['subject3'] != "")) {
			debug_to_console(implode("", $array));
		} else {
			debug_to_console(array_sum($array));
		};
		foreach ($array as $element) {
		}
		
		debug_to_console($array2[$_GET['userName']]);
			
		?>
	</body>
</html>