function updategonzalo(deltaTime){

	if(gonzalo.hit)
	{
		if(!manux.hit && manux.x > gonzalo.x)
		{
			gonzalo.x+= gonzaloSpeed*deltaTime;
		}
		else if(!manux.hit)
		{
			hitAudio.play();
			manux.hit = true;
			manux.force = gonzalo.clicks;
		}
	}
	else
	{
		if(canForce)
		{
			gonzalo.getForce();
			canForce = false;
		}	
	}


	updateDOMFromGO(gonzalo);
}

function updatemanux(deltaTime){
	console.log("HOLA");
	if(manux.hit)
	{
		manux.y += manuxSpeed*deltaTime;
		console.log("HOLA");
	}

	updateDOMFromGO(manux);
}