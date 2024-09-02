<?php
/*----------------------------------------------------------------------------------------
* Copyright (c) Microsoft Corporation. All rights reserved.
* Licensed under the MIT License. See LICENSE in the project root for license information.
*---------------------------------------------------------------------------------------*/

session_start();

if (!isset($_SESSION['array_operations'])) {
	$_SESSION['array_operations'] = [];
}

 function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function handle_submit() {
	$array_operations = $_SESSION['array_operations'];

	$array_result = array(
		($_POST['subject1']),
		($_POST['subject2']),
		($_POST['subject3'])
	);

	array_push($array_operations, array(($_POST['subject1']), ($_POST['subject2']), ($_POST['subject3']), ($_POST['userName'])
	));

	$_SESSION['array_operations'] = $array_operations;

    if (!is_numeric($_POST['subject1']) || !is_numeric($_POST['subject2']) || (!is_numeric($_POST['subject3']) && $_POST['subject3'] != "")) {
        $result = $_POST['userName'] . " - " . implode("", $array_result);
    } else {
        $result = $_POST['userName'] . " - " . array_sum($array_result);
    }
    
    return $result;
}

function reset_memory() {
	$_SESSION['array_operations'] = [];
}

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['subject1']) == false){
		$_SESSION['array_operations'] = "";
		$result = handle_submit();
	}
    if (isset($_POST['reset'])) {
        reset_memory();
    } else {
        $result = handle_submit();
    }
}
?>

<html>
	<head>
		<title>Visual Studio Code Remote :: PHP</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link rel="stylesheet" href="./style.css">
	</head>
	<body class="d-flex flex-column justify-content-center align-items-center">
		<div class="container div-container p-4 d-flex align-items-center flex-column calculator-body">
			<h1 class="mb-4">Calculator</h1>
			<div class="w-100">
				<form action="" method="POST">
					<input type="text" class="form-label" name="userName" id="userName" placeholder="Name">
					<div class="d-flex gap-2">
						<input type="text" class="form-label" required name="subject1" id="subject1" placeholder="First value">
						<input type="text" class="form-label" required name="subject2" id="subject2" placeholder="Second value">
						<input type="text" class="form-label" name="subject3" id="subject3" placeholder="Third value">
					</div>
					<button type="submit" class="btn btn-success">Send</button>
				</form>
			</div>
		</div>
		<?php 

		echo "<div class='div-container mt-5 p-4'>";

		if ($result !== null) {
			echo "<div class='d-flex justify-content-between align-items-center'>";
			echo "<h1 class='m-0'>Result: $result</h1>";
			echo "
				<form action='' method='POST' class='m-0'>
					<button class='btn bg-danger'  method='POST' name='reset' id='reset'> Reset memory </button>
				</form>";
			echo "</div>";
		}

		if (!empty($_SESSION['array_operations'])) {
			if(isset($_POST['subject1']) == false){
				echo "<h2>Waiting operations</h2>";
				return;
			};
			$unique_users = [];
			echo "<hr class='divider'>";
			echo "<h2>Previous results with the same operation:</h2>";
			echo "<ul>";
			foreach ($_SESSION['array_operations'] as $values) {
				if(in_array($values[3], $unique_users)){
					continue;
				}; 
				if ($values[0]==$_POST['subject1'] && $values[1]==$_POST['subject2'] && $values[2]==$_POST['subject3']){
					array_push($unique_users, $values[3]);
					echo "<li class='h5'>$values[3]: " . "$values[0], $values[1], $values[2]" . "</li>";
				} else {
					$errors[] = "Bitte benutzen Sie das Formular aus Ihrem Profil";
				}

			}
			echo "</ul>";
		} else {
			echo "<h2>Waiting operations</h2>";
		}

		echo "</div>"

		?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>