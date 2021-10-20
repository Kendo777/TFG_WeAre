//Classes
class Player
{
	constructor(playerSpeed,timeBetweenShoots)
	{
		this.lifes=3;
		this.playerSpeed = playerSpeed;
		this.canShoot = true;
		this.timeBetweenShoots=timeBetweenShoots;
		this.timer=0;
	}
}
class Troup
{
	constructor(speed)
	{
		this.speed=speed;
		this.direction = 1;
		this.moveDown=false;
	}
}
class Invader
{
	constructor(x,y)
	{
		this.x = x;
		this.y = y;
		this.alive=true;
		//this.invaderSpeed = invaderSpeed;
		this.canShoot = true;
		//this.timeBetweenShoots=timeBetweenShoots;
		this.timer=0;
	}
}
class SpecialInvader
{
	constructor(x,y,speed,direction)
	{
		this.x=x;
		this.y=y;
		this.speed=speed;
		this.direction = direction;
	}
}
class Bullet
{
	constructor(x,y,direction, speed)
	{
		this.height= 30;
  		this.width= 30;
  		this.x= x - this.width/2;
		this.y= y + this.height;
		this.direction = direction;
		this.speed = speed;

	}
}
class Block
{
	constructor(x,y)
	{
		this.x=x;
		this.y=y;
		this.bricks=[];
	}
}
class Brick
{
	constructor(x,y)
	{
		this.x=x;
		this.y=y;
		this.pixels=[];
		this.count=0;
	}

	deltePixels()
	{
		var num;
		if(this.count<9)
		{
			num=this.count;
		}
		else
		{
			num=5;
		}
		for(i=0;i<num;i++)
		{
			var del=false;
			do
			{
				var rand=Math.floor(Math.random()*10);
				if(this.pixels[rand]!=null)
				{
					this.pixels[rand].dom.remove();
					this.pixels[rand]=null;
					del=true;
					this.count--;
				}

			}while(!del);
		}
	}
}
class Pixel
{
	constructor(x,y)
	{
		this.x=x;
		this.y=y;
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

//Player variables
var playerTimeBetweenShoots = 0.7;
var playerSpeed = 300;
var player = new Player(playerSpeed,playerTimeBetweenShoots);

var bullets = [];

//Invaders and troup variables
var invadersShootSpeed = 200;
var troup = new Troup(1000);
var startRows = 4;
var startColumns = 9;
var rows = 4;
var columns = 9;
var invaders = [];
var timmerInvaderShoot=0;

//Invader shooting variables
var randomShooringTime;
var maxShootingTime = 3;
var minShootingTime = 0.1;

//Special Invader timming
var minSpecialInvader = 8;
var maxSpecialInvader = 15;
var randomSpecialInvaderTime;
var spInvader;

//Margin invaders
var leftInvader;
var rightInvader;
var bottomInvader;

//Counter of alive invaders
var currentInvaders;

//Blocks
var pixelSize = 5;
var blocks = [];


//Control variables
var gameOver = false;
var results = false;
var win = false;
var pause = false;

//Game Information
var level = 0;
var handicapPerLevel=0.01;

//Score
var score = 0;
var newLife = 5000;
var pointsToRestart = 2000;
var pointsOfLevel = 1000;
var pointsOfLife = 2500;
var invaderPoints = 50;
var spPoints = 800;

//Audio
var shootSound = new Audio('style/sounds/shoot.wav');
shootSound.volume = 0.1;
var backgroundSound = new Audio('style/sounds/fastinvader1.wav');
var spSound = new Audio('style/sounds/ufo_highpitch.wav');
spSound.volume=0.2;
spSound.loop=true;
var invaderDeath = new Audio('style/sounds/invaderkilled.wav');
invaderDeath.volume=0.2;
var playerDeath = new Audio('style/sounds/explosion.wav');
playerDeath.volume=0.2;
var coinSound = new Audio('style/sounds/ES_Coin Drop Single 1 - SFX Producer.wav');
var pointsSound = new Audio('style/sounds/ES_Coin Movement 3 - SFX Producer.wav');
pointsSound.loop=true;
//Sizes and distances variables

var colisionMargin = 5;

var invadersSize = 60;
var spaceBetweenInvaders = 15;


var lifes = [];



var mediumWindowW = 1278;
var mediumWindowH = 870;

//Result Area variables
var scoreTime=1.5;
var scorePointer=0;

//Timmers
var timeBetweenMov;

var timmer = 0.0;
var timmerResults = 0.0;
var specialInvaderTimmer = 0.0;
