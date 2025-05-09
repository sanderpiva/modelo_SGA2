<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/style.css">
    <title>Mostrar tabela com registros</title>
  </head>
  <body>

	   <table>


			<tr>
				
				<td>nome<td/>
				<td>email<td/>
				<td>q1<td/>
				<td>q2<td/>
				<td>q3<td/>
				<td>q4<td/>
				<td>nota<td/>
			<tr/>

			<?php

				include"../servicos-professor/conexao.inc";

				$sql="select *from tabeladados";
				$res=mysqli_query($conn, $sql);
				$lin=mysqli_affected_rows($conn);

				echo "Registros identificados: $lin";
        echo "<br><br>";

				while($reg=mysqli_fetch_row($res)){

					
					$nome=$reg[0];
					$email=$reg[1];
					$q1=$reg[2];
					$q2=$reg[3];
					$q3=$reg[2];
					$q4=$reg[5];
					$nota=$reg[6];
					
					echo "<tr>";
					echo "<td>$nome<td/><td>$email<td/><td>$q1<td/><td>$q2<td/><td>$q3<td/><td>$q4<td/><td>$nota<td/>";
					echo "<tr/>";


				}

				mysqli_close($conn);

			?>

	   <table/>

      <br><br><br>
	  <a href="../index.php"><em>CLIQUE PARA HomePage</em></a>

  </body>
</html>
