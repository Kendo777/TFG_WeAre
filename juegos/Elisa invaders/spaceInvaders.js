window.addEventListener("load",start);

function start(){

	getDOMReferences();
	setInitialPositions();
	
	window.addEventListener("keydown",press);
	window.addEventListener("keyup",free);

	requestAnimationFrame(loop);
}

function press(event){
	keyPressed[event.key] = true;
}

function free(event){
	keyPressed[event.key] = false;
}

//Initialize variables and set hud
function init()
{
	 columns = Math.floor(startColumns* window.innerWidth/mediumWindowW);
	 rows = Math.floor(startRows*window.innerHeight/mediumWindowH);
	 currentInvaders= rows*columns;
	 //Calculate the time for move all the invaders
	 if(currentInvaders-level<1)
	 {
	 	timeBetweenMov= (1/(columns*rows));
	 }
	 else
	 {
		timeBetweenMov= ((currentInvaders-level)/(columns*rows));
	 }
	 document.getElementById("results").style.display = "none";
	 document.getElementById("score").innerHTML = "Score: "+score;
	 document.getElementById("level").innerHTML = "Level: "+level;
	 for(var i=0;i<player.lifes;i++)
	 {
	 	addLife();
	 }

}
function addLife()
{
		var div = document.createElement("div");
	 	div.setAttribute("id","life"+lifes.length);
	 	div.style.display = "inline-block";
	 	div.style.width = 35+"px";
		div.style.height = 25+"px";
		div.className = "lifes player";
	 	document.getElementById('lifes').appendChild(div);
	 	lifes.push(div);
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


	var playerMargin = 100;
	player.dom.style.position = "absolute";
	player.width = 60;
	player.height = 70;
	player.x = parseInt(playArea.style.width)/2-player.width/2;
	player.y = parseInt(playArea.style.height)-playerMargin;
	updateDOMFromGO(player);

	troup.dom.style.position = "absolute";
	troup.direction = 1;
	troup.width = invadersSize*columns+spaceBetweenInvaders*(columns-1);
	troup.height = invadersSize*rows + spaceBetweenInvaders*(rows-1);
	troup.x = parseInt(playArea.style.width)/2-troup.width/2;
	troup.y = parseInt(playArea.style.height)/6;
	updateDOMFromGO(troup);

	//Setting the invaders
	for(i=0; i<rows; i++)
	{
		var array = [];
		for(j=0; j<columns; j++)
		{
			var div = document.createElement("div");
			if(i>0)
			{
				if(i>2)
				{
					div.className = "go invader"+2;
				}
				else
				{
					div.className = "go invader"+1;
				}
			}
			else
			{
				div.className = "go invader"+i;
			}
			
			div.setAttribute("id","invader"+(i*columns+j));
			document.getElementById('invaders').appendChild(div);

			var newInvader = new Invader((invadersSize+spaceBetweenInvaders)*j,(invadersSize+spaceBetweenInvaders)*i);
			newInvader.dom = div;
			newInvader.width = invadersSize;
			newInvader.height = invadersSize;
			updateDOMFromGO(newInvader);
			array.push(newInvader);

		}
		invaders.push(array);
	}

	randomShooringTime = Math.random() * (maxShootingTime - minShootingTime) + minShootingTime;
	randomSpecialInvaderTime = Math.random() * (maxSpecialInvader - minSpecialInvader) + minSpecialInvader;
	leftInvader = invaders[0][0];
	rightInvader = invaders[0][columns-1];
	bottomInvader = invaders[rows-1][0];
	initBlock();

}
function initBlock()
{
	//array Block
	for(i=0; i<3; i++)
	{
		var blok = document.createElement("div");
		blok.className="go";
		blok.setAttribute("id","block"+i);
		document.getElementById("blocks").appendChild(blok);
		newBlock = new Block((1+i)*parseInt(playArea.style.width)/4-(4*3*pixelSize)/2,parseInt(playArea.style.height)*3/4);
		newBlock.width = 4*3*pixelSize;
		newBlock.height = 3*3*pixelSize;
		newBlock.dom=blok;
		updateDOMFromGO(newBlock);
		//matrix of bricks
		for(j=0; j<3; j++)
		{
			var array = [];
			for(k=0; k<4; k++)
			{
				var div = document.createElement("div");
				div.className = "go";
				div.setAttribute("id","brick"+i+(j*4+k));
				document.getElementById('block'+i).appendChild(div);

				var newBrick = new Brick(k*3*pixelSize,j*3*pixelSize);
				newBrick.width = 3*pixelSize;
				newBrick.height = 3*pixelSize;
				newBrick.count = 9;
				newBrick.dom = div;
				updateDOMFromGO(newBrick);
				//pixels in bricks
				for(l=0; l<3;l++)
				{
					for(m=0; m<3; m++)
					{
						var pix = document.createElement("div");
						pix.className = "go pixel";
						pix.setAttribute("id","pixel"+(l*3+m));
						document.getElementById('brick'+i+(j*4+k)).appendChild(pix);
						var newPix = new Pixel(m*pixelSize,l*pixelSize);
						newPix.width = pixelSize;
						newPix.height = pixelSize;
						newPix.dom = pix;
						updateDOMFromGO(newPix);
						newBrick.pixels.push(newPix);
					}
				}
				array.push(newBrick);
			}
			newBlock.bricks.push(array);
		}
		//Deleting the pixels to make the block form
		newBlock.bricks[0][0].pixels[0].dom.remove();
		newBlock.bricks[0][0].pixels[0]=null;
		newBlock.bricks[0][0].pixels[1].dom.remove();
		newBlock.bricks[0][0].pixels[1]=null;
		newBlock.bricks[0][0].pixels[3].dom.remove();
		newBlock.bricks[0][0].pixels[3]=null;
		newBlock.bricks[0][0].count -=3;

		newBlock.bricks[0][3].pixels[1].dom.remove();
		newBlock.bricks[0][3].pixels[1]=null;
		newBlock.bricks[0][3].pixels[2].dom.remove();
		newBlock.bricks[0][3].pixels[2]=null;
		newBlock.bricks[0][3].pixels[5].dom.remove();
		newBlock.bricks[0][3].pixels[5]=null;
		newBlock.bricks[0][3].count -=3;

		newBlock.bricks[2][1].pixels[6].dom.remove();
		newBlock.bricks[2][1].pixels[6]=null;
		newBlock.bricks[2][1].pixels[7].dom.remove();
		newBlock.bricks[2][1].pixels[7]=null;
		newBlock.bricks[2][1].pixels[8].dom.remove();
		newBlock.bricks[2][1].pixels[8]=null;
		newBlock.bricks[2][1].pixels[5].dom.remove();
		newBlock.bricks[2][1].pixels[5]=null;
		newBlock.bricks[2][1].pixels[4].dom.remove();
		newBlock.bricks[2][1].pixels[4]=null;
		newBlock.bricks[2][1].pixels[2].dom.remove();
		newBlock.bricks[2][1].pixels[2]=null;
		newBlock.bricks[2][1].count -=6;

		newBlock.bricks[2][2].pixels[6].dom.remove();
		newBlock.bricks[2][2].pixels[6]=null;
		newBlock.bricks[2][2].pixels[7].dom.remove();
		newBlock.bricks[2][2].pixels[7]=null;
		newBlock.bricks[2][2].pixels[8].dom.remove();
		newBlock.bricks[2][2].pixels[8]=null;
		newBlock.bricks[2][2].pixels[3].dom.remove();
		newBlock.bricks[2][2].pixels[3]=null;
		newBlock.bricks[2][2].pixels[4].dom.remove();
		newBlock.bricks[2][2].pixels[4]=null;
		newBlock.bricks[2][2].pixels[0].dom.remove();
		newBlock.bricks[2][2].pixels[0]=null;
		newBlock.bricks[2][2].count -=6;

		blocks.push(newBlock);

	}
}
function getDOMReferences(){
	game = document.getElementById("game");
	playArea = document.getElementById("playArea");
	hud = document.getElementById("hud");
	player.dom = document.getElementById("player");
	troup.dom = document.getElementById("invaders");
	
}

function updateDOMFromGO(go){
	go.dom.style.top = go.y + "px";
	go.dom.style.left = go.x + "px";
	go.dom.style.width = go.width + "px";
	go.dom.style.height = go.height + "px";
}


function checkCollisions()
{
	var stop = false;
	for(k=0;k<bullets.length;k++)
	{
		//Check colisions between player bullet (direction=-1)
		if(bullets.length>0 && bullets[k].direction!=1)
		{
			for(i=0;i<rows;i++)
			{
				for(j=0;j<columns;j++)
				{
					if(invaders[i][j]!=null)
					{
						if(k>=0 && aabbCollisionRelative(bullets[k],invaders[i][j],troup))
						{
							bullets[k].dom.remove();
							bullets.splice(k,1);
							k--;

							invaders[i][j].dom.remove();
							//If the invader who is going to die is one of the margin invaders we will search for a new one
							if(invaders[i][j]==leftInvader)
							{
								invaders[i][j]=null;
								calculateLeftInvader();
							}
							if(invaders[i][j]==rightInvader)
							{
								invaders[i][j]=null;
								calculateRightInvader();
							}
							if(invaders[i][j]==bottomInvader)
							{
								invaders[i][j]=null;
								calculateBottomInvader();
							}
							invaders[i][j]=null;
							invaderDeath.play();
							currentInvaders--;
							addPoints(invaderPoints);
							stop = true;
							//Calculate the time for move all the invaders
							if(currentInvaders-level<1)
							{
								timeBetweenMov= (1/(columns*rows));
							}
							else
							{
								timeBetweenMov= ((currentInvaders-level)/(columns*rows));
							}
							break;
						}
					}
							
				}
				if(stop)
				{
					break;
				}
			}
			if(spInvader!=null && k>=0 && aabbCollision(bullets[k],spInvader))
			{
				bullets[k].dom.remove();
				bullets.splice(k,1);
				k--;

				invaderDeath.play();
				invaderDeath.muted=false;
				spInvader.dom.remove();
				spInvader=null;
				spSound.pause();
				randomSpecialInvaderTime = Math.random() * (maxSpecialInvader - minSpecialInvader) + minSpecialInvader;
				addPoints(spPoints);
			}
		} //Check colisions between invaders bullet and player
		else
		{
			if(k>=0 && aabbCollision(bullets[k],player))
			{
				bullets[k].dom.remove();
				bullets.splice(k,1);
				k--;

				playerDeath.play();
				playerDeath.muted=false;
				player.lifes--;
				lifes[player.lifes].remove();

			}
		}
		//Check colisions between the bullets and the blocks
		for(n=0;n<blocks.length;n++)
		{
			for(l=0;l<3;l++)
			{
				for(m=0;m<4;m++)
				{
					if(k>=0 && blocks[n].bricks[l][m]!=null && aabbCollisionRelative(bullets[k],blocks[n].bricks[l][m],blocks[n]))
					{
						bullets[k].dom.remove();
						bullets.splice(k,1);
						k--;

						blocks[n].bricks[l][m].deltePixels();
						if(blocks[n].bricks[l][m].count<=0)
						{
							blocks[n].bricks[l][m].dom.remove();
							blocks[n].bricks[l][m]=null;
						}
					}
				}
			}
		}
	}
	//Check colissions between bullets
	for(i=0;i<bullets.length;i++)
	{
		for(j=0;j<bullets.length;j++)
		{
			if(bullets[i]!=bullets[j])
			{
				if(aabbCollision(bullets[i],bullets[j]))
				{
					bullets[j].dom.remove();
					bullets.splice(j,1);
					j--;

					bullets[i].dom.remove();
					bullets.splice(i,1);
					i--;
				}
			}
		}
	}
}
function calculateLeftInvader()
{
	var stop = false;
	for(var l=0;l<columns;l++)
	{
		for(var m=0;m<rows;m++)
		{
			if(invaders[m][l]!=null)
			{
				leftInvader=invaders[m][l];
				stop = true;
				break;
			}
		}
		if(stop)
		{
			break;
		}
	}
}
function calculateRightInvader()
{
	var stop = false;
	for(var l=columns-1;l>=0;l--)
	{
		for(var m=rows-1;m>=0;m--)
		{
			if(invaders[m][l]!=null)
			{
				rightInvader=invaders[m][l];
				stop = true;
				troup.width = invadersSize*(l+1)+spaceBetweenInvaders*(l);;
				break;
			}
		}
		if(stop)
		{
			break;
		}
	}
}
function calculateBottomInvader()
{
	var stop = false;
	for(var l=rows-1;l>=0;l--)
	{
		for(var m=0;m<columns;m++)
		{
			if(invaders[l][m]!=null)
			{
				bottomInvader=invaders[l][m];
				troup.height = invadersSize*(l+1) + spaceBetweenInvaders*(l);
				stop = true;
				break;
			}
		}
		if(stop)
		{
			break;
		}
	}
	updateDOMFromGO(troup);
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

function destroy()
{
	//Invaders
	for(var i=0; i<rows; i++)
	{
		for(var j=0; j<columns; j++)
		{
			if(invaders[i][j]!=null)
				invaders[i][j].dom.remove();
		}
		invaders[i]=[];
	}
	//Bullets
	for(var i = 0; i<bullets.length; i++)
	{
		bullets[i].dom.remove();
	}
	//Lifes
	for(var i = 0; i<lifes.length; i++)
	{
		lifes[i].remove();
	}
	//Blocks
	for(var i=0; i<blocks.length;i++)
	{
		for(var j=0; j<3;j++)
		{
			for(var k=0; k<4;k++)
			{
				if(blocks[i].bricks[j][k]!=null)
				{
					for(var l=0;l<9;l++)
					{
						if(blocks[i].bricks[j][k].pixels[l]!=null)
							blocks[i].bricks[j][k].pixels[l].dom.remove();
					}
					blocks[i].bricks[j][k].dom.remove();
					blocks[i].bricks[j][k].pixels=[];
				}
			}
			blocks[i].bricks[j] = [];
		}
		blocks[i].dom.remove();
		blocks[i].bricks = [];
	}
	if(spInvader!=null)
	{
		spSound.pause();
		spInvader.dom.remove();
		spInvader=null;
	}
	invaders = [];
	bullets = [];
	lifes = [];
	blocks = [];

}
function reset()
{
	score-=pointsToRestart;
	if(score<0)
	{
		score=0;
	}
	destroy();
	if(player.lifes<=0)
	{
		player.lifes = 3;
	}
	setInitialPositions();
}
//Insert coin
function newGame()
{
	coinSound.play();
	level=0;
	score=0;
	player.lifes=3;
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
				document.getElementById("lifesOperation").innerHTML = "LIFES:"+(player.lifes*pointsOfLife);
				break;
			case 2:
				document.getElementById("scoreOperation").innerHTML = "SCORE:"+score;
				break;
			case 3:
				document.getElementById("finalScore").innerHTML = "TOTAL SCORE:"+(pointsOfLevel*level+player.lifes*pointsOfLife+score);
				document.getElementById("inputScore").value = (pointsOfLevel*level+player.lifes*pointsOfLife+score);
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
		var deltaTime = currentTime-lastTime;
		if(gameOver)
		{
			if(!spSound.paused)
			{
				spSound.pause();
			}
			if(results)
			{
				if(scorePointer<5)
					showResult(deltaTime/1000);
			}
			else
			{
				if(confirm("GAME OVER. INSERT COIN"))
				{
					//Reset
					player.lifes--;
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
			updatePlayer(deltaTime/1000);
			//Win condition
			if(currentInvaders>0)
			{
				updateInvaders(deltaTime/1000);
				updateSpecialInvader(deltaTime/1000);
			}
			else
			{
				win = true;
			}
			updateBullets(deltaTime/1000);
			checkCollisions();
			if(keyPressed[controls.RESET] || keyPressed[controls.RESET2])
			{
				reset();
			}
		}//Pause
		if(keyPressed[controls.PAUSE] || keyPressed[controls.PAUSE2])
		{
			pause = !pause;
			spSound.pause();
		}//Pass level
		if(keyPressed[controls.SKIP] || keyPressed[controls.SKIP2])
		{
			currentInvaders=0;
		}
	}
	lastTime = currentTime;
	requestAnimationFrame(loop);
}
