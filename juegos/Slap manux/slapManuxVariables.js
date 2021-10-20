//Classes
class Gonzalo
{
	constructor(mov)
	{
		this.clicks=0;
		this.movment = mov;
		this.hit = false;
	}
	getForce()
	{
		if(canForce)
		{
			this.clicks++;
			this.x-=this.movment;
			canForce = false;
		}
	}
}

class Manux
{
	constructor()
	{
		this.force;
		this.hit=false;
	}
}

//Div Areas
var playArea;
var game;
var hud;
var results;

//Gameplay variables
var controls = {
	LEFT : "ArrowLeft",
	RIGHT : "ArrowRight",
	SHOOT : " ",
	RESET : "r",
	RESET2 : "R",
	PAUSE : "p",
	PAUSE2 : "P",
	SKIP : "q",
	SKIP2 : "Q"
}
var keyPressed = [];
var lastTime = null;
var movmentPerClick = 5;
var manuxSpeed = 100;
var gonzaloSpeed = 1500;
var gonzalo = new Gonzalo(movmentPerClick);
var manux = new Manux();

//Score
var score = 0;
var timeout = 10;
var timmer = 0;
var gameOver = false;
var results = false;
var win = false;
var pause = false;
var canForce = true;
var spacePressed= false;

var hitAudio = new Audio('style/sounds/slap-effects.mp3');
hitAudio.volume = 0.1;