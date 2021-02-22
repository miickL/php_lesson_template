<?php
	function handleErrorConnection($conn) {
		
		if ($conn->connect_error) {
			$error = $conn->connect_error;
			$n_error = $conn->connect_errno;
			header("Location: error.php?error=".$error."&n_error=".$n_error);
			exit;
		}
	}

	function handleErrorQuery($conn) {
		if($conn->error) {
			echo($conn->error);
			$error = $conn->error;
			header("Location: error.php?error=$error&n_error=Correo Duplicado");
		}
	}

		
	
	function createConnection($host = "localhost",$user = "root",$pass = "-.,asd",$myDB = "pueblos") {
		
		$conn = new mysqli($host,$user,$pass,$myDB);
		handleErrorConnection($conn);
		return $conn;
	}

	function createQuery($sql_query, $conn){
        $qResult = $conn->query($sql_query);
        handleErrorQuery($conn);
        return $qResult;
    }

?>