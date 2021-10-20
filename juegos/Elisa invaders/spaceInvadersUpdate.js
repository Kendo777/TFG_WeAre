function updatePlayer(deltaTime){

	//GameOver condition
	if(player.lifes<=0)
	{
		gameOver = true;
	}
	//Enough points to get a new life
	if(score>=newLife)
	{
		addPoints(-newLife);
		player.lifes++;
		addLife();
	}
	if(!player.canShoot)
	{
		player.timer+=deltaTime;
	}

	if(keyPressed[controls.RIGHT] && player.x+player.width<(parseInt(playArea.style.width)-colisionMargin)){
		player.x +=  player.playerSpeed * deltaTime;
	}
	if(keyPressed[controls.LEFT] && player.x>colisionMargin){
		player.x -=  player.playerSpeed * deltaTime;	 
	}

	if(!player.canShoot && player.timer>=player.timeBetweenShoots)
	{
		player.canShoot=true;
		player.timer=0;
	}

	if(keyPressed[controls.SHOOT] && player.canShoot)
	{
		var div = document.createElement("div");
		div.className = "go bullet";
		div.setAttribute("id","bullet"+bullets.length);
		document.getElementById('playArea').appendChild(div);

		var newBullet = new Bullet(player.x+parseInt(player.width)/2,player.y-parseInt(player.height),-1,1000);
		newBullet.dom = div;
		updateDOMFromGO(newBullet);
		bullets.push(newBullet);
		var s = new Audio(shootSound.src);
		s.volume = 0.2;
		s.play();
		player.canShoot=false;
		
	}

	updateDOMFromGO(player);
}
function updateBullets(deltaTime)
{
	for(i=0;i<bullets.length;i++)
	{
		bullets[i].y += bullets[i].direction * bullets[i].speed * deltaTime; 
		updateDOMFromGO(bullets[i]);
		if(bullets[i].y<=0 || bullets[i].y+bullets[i].height>parseInt(playArea.style.height))
		{
			bullets[i].dom.remove();
			bullets.splice(i,1);
			i--;
		}
	}

}

function updateSpecialInvader(deltaTime)
{
	if(spInvader!=null)
	{
		spInvader.x+=spInvader.direction*spInvader.speed*deltaTime;
		
		updateDOMFromGO(spInvader);
		if(spInvader.x<0 || spInvader.x+spInvader.width>parseInt(playArea.style.width))
		{
			spInvader.dom.remove();
			spInvader=null;
			spSound.pause();
			randomSpecialInvaderTime = Math.random() * (maxSpecialInvader - minSpecialInvader) + minSpecialInvader;
		}
	}
	else //Create de Special Invader
	{
		specialInvaderTimmer+=deltaTime;
		if(specialInvaderTimmer>=randomSpecialInvaderTime)
		{
			specialInvaderTimmer=0.0;
			spInvader=new SpecialInvader(0,0,250,Math.floor(Math.random() * 2));
			spInvader.width=60;
			spInvader.height=60;
			var div = document.createElement("div");
			div.className = "go specialInvader";
			document.getElementById('playArea').appendChild(div);
			spInvader.dom = div;
			if(spInvader.direction==0)
			{
				spInvader.x=parseInt(playArea.style.width)-spInvader.width;
				spInvader.direction=-1;
			}
			spSound.play();
			spSound.muted=false;
			updateDOMFromGO(spInvader);
		}
	}
}

function updateInvaders(deltaTime)
{
	timmer+=deltaTime;
	if(timmer>timeBetweenMov)
	{
		//Increase the background sound repeats as the timeBetweenMov decreases
		backgroundSound.play();
		backgroundSound.muted=false;
		//See if its time to go down
		if((troup.x+rightInvader.x+rightInvader.width>=parseInt(playArea.style.width) || troup.x+leftInvader.x<=0) && !troup.moveDown)
		{
			troup.direction*=-1;
			troup.y+=troup.speed*deltaTime;
			troup.moveDown=true;
			//Check bottom colision for not go further as it needs
			if(troup.y>=parseInt(playArea.style.height))
			{
				troup.y=parseInt(playArea.style.height);
			}
		}
		else
		{
			troup.x+=troup.direction*troup.speed*deltaTime;
			//Check right and left colision for not go further as it needs
			if(troup.x+rightInvader.x+rightInvader.width+colisionMargin>parseInt(playArea.style.width))
			{
				troup.x = parseInt(playArea.style.width) - (rightInvader.x+rightInvader.width);
			}
			else if(troup.x+leftInvader.x<0)
			{
				troup.x = 0-leftInvader.x;
			}
			if(troup.moveDown)
			{
				troup.moveDown=false;
			}
		}
		updateDOMFromGO(troup);
		timmer=0;
		//Change Sprites
		for(i=0; i<rows; i++)
		{
			for(j=0; j<columns; j++)
			{
				if(invaders[i][j]!=null)
				{
					if(invaders[i][j].dom.className.length == "go invader".length+1)
					{
						invaders[i][j].dom.className =invaders[i][j].dom.className+1;
					}
					else
					{
						invaders[i][j].dom.className = invaders[i][j].dom.className.substring(0,invaders[i][j].dom.className.length-1);
					}
				}
				
				
			}
		}
		//GameOver Condition, if the invaders arrive to earth
		if(troup.y+bottomInvader.y+bottomInvader.height>=parseInt(playArea.style.height))
		{
			gameOver=true;
		}
	}
	invadersShoot(deltaTime);
}

function invadersShoot(deltaTime)
{
	var find=false;
	var invaderY;
	var invaderX;
	timmerInvaderShoot+=deltaTime;
	if(timmerInvaderShoot>=randomShooringTime-(level*handicapPerLevel))
	{
		invaderY = Math.floor(Math.random() * columns);
		invaderX=invaders.length-1;
		//Search for the bottom one of each column
		do
		{
			if(invaders[invaderX][invaderY]!=null)
			{
				var div = document.createElement("div");
				div.className = "go bullet-elisa";
				div.setAttribute("id","bullet"+bullets.length);
				document.getElementById('playArea').appendChild(div);

				var newBullet = new Bullet(troup.x+invaders[invaderX][invaderY].x+invaders[invaderX][invaderY].width/2,troup.y+invaders[invaderX][invaderY].y+invaders[invaderX][invaderY].height,1,invadersShootSpeed);
				newBullet.width = 50;
				newBullet.height = 50;
				newBullet.dom = div;
				updateDOMFromGO(newBullet);
				bullets.push(newBullet);

				randomShooringTime=Math.random() * (maxShootingTime - minShootingTime) + minShootingTime;
				timmerInvaderShoot=0.0;


				find=true;
			}else
			{
				if(invaderX>0)
				{
					invaderX--;
				}
				else
				{
					break;
				}
				
			}

		}while(!find);

	}
}