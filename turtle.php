<!DOCTYPE html>
<html>
<head>
<title>Saagar TurtleBot</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.3.0/fabric.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style>
#canvas{
  position:relative;
}
</style>


    
</head>

<body>
<header>
    <h1>TurtleBot</h1>
</header>
<p>
  <label for="amount">Speed:</label>
    <script>
  $(function() {
    $( "#slider" ).slider({
      value:10,
      min: 2,
      max: 50,
      step: 1,
      slide: function( event, ui ) {
        $( "#amount" ).val(ui.value );
      }
    });
    $("#amount" ).val($( "#slider" ).slider( "value" )); 
  });
</script>    
  <input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;">
</p>
 
<div id="slider"></div>    
<section>
    <p><b>How to move:</b> use awd or left/right/up to move. Press spacebar to refresh the screen</p> 
    <canvas id="canvas" width="1500" height="700"></canvas>   
</section>
    
   
</body>
<script>
var turnSpeed = 5;
var moveSpeed = 10;
var forward = false;
var rightTurn = false;
var leftTurn = false;
var canvas;
var midX;
var midY;
var triangle;
var upkey = 38;
var rightkey = 39;
var leftkey = 37;
var wkey = 87;
var akey = 65;
var dkey = 68;
var turtle;

    
    

refreshCanvas();
somecanvas();
    
function refreshCanvas(){
  canvas = new fabric.Canvas('canvas');
  midX = canvas.getWidth()/2;
  midY = canvas.getHeight()/2;
  triangle = new fabric.Triangle({
    top: midY,
    left: midX,
    width: 50,
    height: 50,
    fill: 'white',
    angle:0
  })                          
  canvas.backgroundColor="white";
  canvas.add(triangle);
 new fabric.Image.fromURL('https://lh4.googleusercontent.com/anRoEIhdlzRtpFnGpyo3OVh72YNO97jY6c6rFiYCne_Rp3vq25DNuse-TBtasp7QgQ=w1477-h652', function(img) {
    turtle = img.set({ left: midY , top: midX, angle: 90}).scale(0.25);
    canvas.add(turtle);
});
};

function somecanvas(){    
canvas = new fabric.Canvas('canvas');
}    

    
$(document).ready(function(){
      $(document).keydown(function() {
          if(event.which == upkey || event.which==wkey){
            forward=true;
          }
          if(event.which == rightkey || event.which==dkey){
            rightTurn=true;
          }
          if(event.which == leftkey || event.which==akey){
            leftTurn=true;
          }
          if(event.which == 32){
            refreshCanvas();
          }
        });
      $(document).keyup(function() {
          if(event.which == upkey || event.which==wkey){
            forward=false;
          }
          if(event.which == rightkey || event.which==dkey){
            rightTurn=false;
          }
          if(event.which == leftkey || event.which==akey){
            leftTurn=false;
          }
        });
});    


function trailDot(x,y,r){
  var circle = new fabric.Circle({
    left: x,
    top: y,
    radius: r,
    fill: 'green'
  });
  canvas.add(circle);
  canvas.bringToFront(turtle);
};

setInterval(eachInterval, 30);

function toRad(x) {
    return x * (Math.PI / 180);   
}
   
function eachInterval() {
    moveSpeed = $('#amount').val(); 
    turnSpeed = moveSpeed /2
    if (turnSpeed<2) {turnSpeed =2;}
    R = moveSpeed/5;
    if (R<1) {R =1;}
  if(forward==true){
    var Y = triangle.getTop();
    var X = triangle.getLeft();
    var Degreesangle = triangle.getAngle();
    var Radangle = toRad(Degreesangle);  
    Y = Y -  moveSpeed * Math.cos(Radangle);
    X = X + moveSpeed * Math.sin(Radangle);   
         
    var w=canvas.getWidth();
    var h=canvas.getHeight();
    if(X<0){X=0;}
    if(X>w){X=w;}
    if(Y<0){Y=0;}
    if(Y>h){Y=h;}
    triangle.set({top: Y, left:X});
    trailDot(X,Y,R);
  }
  if(rightTurn==true){
    var curAngle = triangle.getAngle();
    if  (curAngle > 360) {curAngle = 360-curAngle;} 
    newAngle = curAngle+turnSpeed;
    if(newAngle<0){
      newAngle=newAngle+360;
    }
    triangle.set({angle: newAngle});
  }
  if(leftTurn==true){
    var curAngle = triangle.getAngle()%359;
    newAngle = curAngle-turnSpeed;
    if(newAngle<0){
      newAngle=newAngle+360;
    }
    triangle.set({angle: newAngle});
  }
    turtle.set({ left: triangle.getLeft() , top: triangle.getTop(), angle: triangle.getAngle()+90});
    canvas.renderAll();
}


</script>

</html>
