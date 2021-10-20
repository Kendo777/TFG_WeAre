window.addEventListener("load",start);

function start(){

	getDOMReferences();
	setInitialPositions();
	
	window.addEventListener("keydown",press);
	window.addEventListener("keyup",free);
	window.addEventListener("click",hit);

	requestAnimationFrame(loop);
}

function press(event){
	keyPressed[event.key] = true;
	if(event.key = " " && !spacePressed)
	{
	  canForce = true;
	  spacePressed=true;
	}
}

function free(event){
	keyPressed[event.key] = false;
	if(event.key = " ")
	{
	  spacePressed=false;
	}

}
function hit(event){
	canForce = true
}


//Initialize variables and set hud
function init()
{
	 document.getElementById("results").style.display = "none";
	 document.getElementById("score").innerHTML = "Score: "+score;
}

//Initialize objects and set positions
function setInitialPositions(){
	init();
	game.style.width = window.innerWidth+"px";
	game.style.height = window.innerHeight+"px";

	var margin = 20;

	playArea.style.position = "absolute";
	playArea.style.width = window.innerWidth*3/4-margin+"px";
	playArea.style.height = window.innerHeight-margin*3+"px";

	hud.style.position = "absolute";
	hud.style.width = window.innerWidth/4-margin*3+"px";
	hud.style.height = window.innerHeight-margin*3+"px";

	playArea.style.left = 0+"px";
	playArea.style.top = margin+"px";

	hud.style.right = 0+"px";
	hud.style.top = margin+"px";


	var gonzaloMargin = 100;
	gonzalo.dom.style.position = "absolute";
	gonzalo.width = 60;
	gonzalo.height = 70;
	gonzalo.x = parseInt(playArea.style.width)/2-gonzalo.width/2;
	gonzalo.y = parseInt(playArea.style.height)-gonzaloMargin;

	manux.dom.style.position = "absolute";
	manux.width = 60;
	manux.height = 70;
	manux.x = parseInt(playArea.style.width)/2-manux.width/2;
	manux.y = parseInt(playArea.style.height)-gonzaloMargin;
	updateDOMFromGO(manux);

}
function getDOMReferences(){
	game = document.getElementById("game");
	playArea = document.getElementById("playArea");
	hud = document.getElementById("hud");
	gonzalo.dom = document.getElementById("gonzalo");	
	manux.dom = document.getElementById("manux");
}

function updateDOMFromGO(go){
	go.dom.style.top = go.y + "px";
	go.dom.style.left = go.x + "px";
	go.dom.style.width = go.width + "px";
	go.dom.style.height = go.height + "px";
}


function checkCollisions()
{
	
}

function aabbCollision(rect1, rect2)
{
	return (rect1.x < rect2.x + rect2.width && 
		rect1.x + rect1.width > rect2.x && 
		rect1.y < rect2.y + rect2.height && 
		rect1.height + rect1.y > rect2.y);
}
function aabbCollisionRelative(rect1, rect2, relative)
{
	return (rect1.x < relative.x+rect2.x + rect2.width && 
		rect1.x + rect1.width > relative.x+rect2.x && 
		rect1.y < relative.y+rect2.y + rect2.height && 
		rect1.height + rect1.y > relative.y+rect2.y);
}

function addPoints(points)
{
	score+=points;
	document.getElementById("score").innerHTML = "Score: "+score;
}

function reset()
{
	score-=pointsToRestart;
	if(score<0)
	{
		score=0;
	}
	destroy();
	
	setInitialPositions();
}
//Insert coin
function newGame()
{
	score=0;
	gameOver=false;
	results=false;
	win=false;
	document.getElementById("inGameHud").style.display="block";
	document.getElementById("results").style.display="none";
	document.getElementById("levelOperation").innerHTML = "";
	document.getElementById("lifesOperation").innerHTML = "";
	document.getElementById("scoreOperation").innerHTML = "";
	document.getElementById("finalScore").innerHTML = "";
	document.getElementById("insertCoin").style.display="none";
	reset();

}

function showResult(deltaTime)
{
	timmerResults+=deltaTime;
	if(timmerResults>scoreTime)
	{
		switch(scorePointer)
		{
			case 0:
				document.getElementById("levelOperation").innerHTML = "LEVEL "+level+":"+(pointsOfLevel*level);
				break;
			case 1:
				document.getElementById("lifesOperation").innerHTML = "LIFES:"+(gonzalo.lifes*pointsOfLife);
				break;
			case 2:
				document.getElementById("scoreOperation").innerHTML = "SCORE:"+score;
				break;
			case 3:
				document.getElementById("finalScore").innerHTML = "TOTAL SCORE:"+(pointsOfLevel*level+gonzalo.lifes*pointsOfLife+score);
				document.getElementById("inputScore").value = (pointsOfLevel*level+gonzalo.lifes*pointsOfLife+score);
				pointsSound.pause();
				break;
			case 4:
				document.getElementById("insertCoin").style.display="block";
		}
		timmerResults=0;
		scorePointer++;
	}else
	{//Counter simulation
		switch(scorePointer)
		{
			case 0:
				document.getElementById("levelOperation").innerHTML = "LEVEL "+level+":"+(Math.floor(Math.random() * 10000));
				break;
			case 1:
				document.getElementById("lifesOperation").innerHTML = "LIFES:"+(Math.floor(Math.random() * 10001));
				break;
			case 2:
				document.getElementById("scoreOperation").innerHTML = "SCORE:"+(Math.floor(Math.random() * 10001));
				break;
			case 3:
				document.getElementById("finalScore").innerHTML = "TOTAL SCORE:"+(Math.floor(Math.random() * 10001));
				break;
		}
	}
}
function loop(currentTime) {
	if (lastTime != null ) {
		var deltaTime = (currentTime-lastTime)/1000;
		if(gameOver)
		{
			if(!spSound.paused)
			{
				spSound.pause();
			}
			if(results)
			{
				if(scorePointer<5)
					showResult(deltaTime);
			}
			else
			{
				if(confirm("GAME OVER. INSERT COIN"))
				{
					//Reset
					gonzalo.lifes--;
					reset(deltaTime);
					gameOver=false;
				}
				else
				{
					//Show results
					document.getElementById("inGameHud").style.display="none";
					document.getElementById("results").style.display="block";
					results=true;
					pointsSound.play();
					scorePointer=0;
					timmerResults=0.0;
				}
			}
		}
		else if(win) //Next Level
		{
			level++;
			win=false;
			score+=pointsToRestart;
			reset();
		}
		else if(!pause)
		{
			if(timeout>0.1)
			{
				timeout -= deltaTime;
				document.getElementById("countdown").innerHTML=timeout.toFixed(2);
			}
			else
			{
				timeout = 0;
				document.getElementById("countdown").innerHTML=timeout.toFixed(2);
				gonzalo.hit = true;
			}
			updategonzalo(deltaTime);
			updatemanux(deltaTime);
			checkCollisions();
		}//Pause
		
	}
	lastTime = currentTime;
	requestAnimationFrame(loop);
}
