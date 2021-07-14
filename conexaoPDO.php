<!DOCTYPE html><html><head><title>Usuários</title><head></html>
<?php
	include ('Usuario.php');
	

	if($_REQUEST["nome"]=='' or $_REQUEST["usuario"]== '' or $_REQUEST["email"]== '' or $_REQUEST["senha"]==''){
		echo 'Por favor digite informações válidas ou complete todos os campos!';
	}else{
		$senhaCrip = md5($_REQUEST["senha"]);
		$pessoa = New Usuario( $_REQUEST["nome"],$_REQUEST["usuario"], $_REQUEST["email"], $senhaCrip);

		$username = "root";
		$password = "";

		try {
			$conn = new PDO('mysql:host=localhost;dbname=exercicio', $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$nome = $pessoa->getNome();
			$usu = $pessoa->getUsuario();
			$email = $pessoa->getEmail();
			$senha = $pessoa->getSenha();
			$stmt = $conn->prepare('INSERT INTO USUARIOS VALUES(?,?,?,?)');
			$stmt->bindParam(1,$nome, PDO::PARAM_INT);
			$stmt->bindParam(2,$usu, PDO::PARAM_INT);
			$stmt->bindParam(3,$email, PDO::PARAM_INT);
			$stmt->bindParam(4,$senha, PDO::PARAM_INT);
			$stmt->execute();
			$usus = $conn->prepare('SELECT nome, usuario, email FROM USUARIOS');
			$usus->execute();
			$c=0;
			while($row = $usus->fetch(PDO::FETCH_OBJ)){
			  echo'USUARIO '. $c;
			  echo "<br>";
			  echo ' -----------------------'; echo "<br>";
			  echo 'Nome: '.$row->nome; echo "<br>";
			  echo 'Usuario: '.$row->usuario; echo "<br>";
			  echo 'Email: '.$row->email; echo "<br>";
			  echo ' -----------------------'; echo "<br>";echo "<br>";
			  $c++;
			}
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}
	}
?>
