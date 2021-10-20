<?php 

session_start();

if(!isset($_SESSION['user']))
{
	header('location:../../index.php');
}
if(isset($_POST['name']) && isset($_POST['score']))
{
	while (strpos(file_get_contents("score.txt"),"EDIT"));
	$info = json_decode(file_get_contents("score.txt"),true);
	$move;

	$myfile = fopen("score.txt", "w") or die("Unable to open file!");
	fwrite($myfile, "EDIT\n".file_get_contents("score.txt"));
	fclose($myfile);
	for($i=0; $i<count($info); $i++)
    {
		if(!isset($move) && $_POST['score']>$info[$i]['score'])
		{
			$move = $info[$i];
			$info[$i]['name'] = $_POST['name'];
			$info[$i]['score'] = $_POST['score'];
		}
		else if(isset($move))
		{
			$aux = $info[$i];
			$info[$i] = $move;
			$move = $aux;
		}
		else if($_POST['score']==$info[$i]['score'] && $_POST['name']==$info[$i]['name'])
		{
			break;
		}
		else if ($info[$i]['score'] == 0) {
			$info[$i]['name'] = $_POST['name'];
			$info[$i]['score'] = $_POST['score'];
			break;
		}
	}
	$myfile = fopen("score.txt", "w") or die("Unable to open file!");
	fwrite($myfile, json_encode($info));
	fclose($myfile);
	header('location:../../index.php?page=games');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Space Invaders</title>
	<script type="text/javascript" src="spaceInvadersVariables.js"></script>
	<script type="text/javascript" src="spaceInvadersUpdate.js"></script>
	<script type="text/javascript" src="spaceInvaders.js"></script>
	<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
	<div id="game">
		
		<div id="playArea">
			<div class="go gonzalo" id="gonzalo"></div>
			<div class="go manux" id="manux"></div>
		</div>
		<div id="hud"> 
		<div id="inGameHud" style="padding: 10px">
			<h1>Countdown:</h1>
			<h1 id="countdown"></h1>
			<h1 id="score">Score: </h1>
			<div id="lifes"></div>
			<br>
			<h1>Constrols:</h1>
			<h3>Move: Left arrow, Right arrow</h3>
			<h3>Shoot: Spacebar</h3>
			<h3>Reset Level: R</h3>
			<h3>Skip Level: Q</h3>
		</div>
		<div id="results" style="padding: 10px">
			<h1>RESULTS:</h1><br>
			<h1 id="levelOperation"></h1>
			<h1 id="lifesOperation"></h1>
			<h1 id="scoreOperation"></h1>
			<h1 id="finalScore"></h1>
			<div id="insertCoin">
				<form method="post" action="index.php">
					<input type="text" hidden class="form-control" name="name" value=<?php echo '"'.$_SESSION['user'].'"';  ?>>
					<input type="number" hidden class="form-control" name="score" id="inputScore">
					<button type="submit" class="btn btn-default"><img src="style/sprites/coin.png" width="50%" height="25%"></button>
					<p>(Press the insert coin button to save your score or to play again)</p>
    			</form>
			</div>
			

		</div>
	</div>
	</div>


</body>
</html>