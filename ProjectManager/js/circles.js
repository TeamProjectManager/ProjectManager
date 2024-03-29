/********************************************************************************************

          CIRCLES
          
********************************************************************************************/




;(function(c,d,j,e){function h(b,a){arguments.length&&this._init(b,a)}h.prototype={defaults:{percent:!0,value:0,maxValue:100,radius:32,thickness:6,backFillColor:"#eeeeee",fillColor:"#e15656",centerFillColor:"#ffffff",decimals:0,retinaReady:!0},_init:function(b,a){this.element=c(b);this.options=c.extend({},this.defaults,a,this.element.data());this.canvas=this._build();this._draw(this._prepareCanvas(this.canvas))},_build:function(){var b=c("<span></span>"),a=j.createElement("canvas");this.element.append(b.clone().addClass("digit-container")).append(b.clone().addClass("canvas-container").append(c(a))).addClass("circular-stat");
if(!a.getContext)if("undefined"!==typeof d.G_vmlCanvasManager)a=d.G_vmlCanvasManager.initElement(a);else return console.log("Your browser does not support HTML5 Canvas, or excanvas.js is missing on IE"),this.element.hide(),!1;return a},_getPixelRatio:function(b){return(d.devicePixelRatio||1)/(b.webkitBackingStorePixelRatio||b.mozBackingStorePixelRatio||b.msBackingStorePixelRatio||b.oBackingStorePixelRatio||b.backingStorePixelRatio||1)},_prepareCanvas:function(b){var a=2*this.options.radius,c=b.getContext("2d"),
c=this._getPixelRatio(c);b.width=b.height=a*c;1<c&&(b.style.width=a+"px",b.style.height=a+"px");return b},_draw:function(b){var a=b.getContext("2d"),i=this._getPixelRatio(a),f=2*(this.options.value/this.options.maxValue)*Math.PI,k=b.width/2,g=b.height/2,d=this.options.radius,e=this._getVal().toFixed(this.options.decimals);a.save();a.clearRect(0,0,b.width,b.height);a.translate(k,g);a.scale(i,i);a.rotate(-Math.PI/2);a.fillStyle=this.options.backFillColor;a.beginPath();a.arc(0,0,d,0,2*Math.PI,!1);a.closePath();
a.fill();a.fillStyle=this.options.fillColor;a.beginPath();a.arc(0,0,d,0,f,!1);a.lineTo(0,0);a.closePath();a.fill();a.fillStyle=this.options.centerFillColor;a.beginPath();a.arc(0,0,d-this.options.thickness,0,2*Math.PI,!1);a.closePath();a.fill();a.restore();c(".digit-container",this.element).css({lineHeight:2*this.options.radius+"px"})[0].innerHTML=this.options.percent?"<span>"+e+"%</span>":"<span>"+e+"</span>/"+this.options.maxValue.toFixed(this.options.decimals)},_getVal:function(){return this.options.percent?
100*(this.options.value/this.options.maxValue):this.options.value},option:function(b,a){if(0===arguments.length)return c.extend({},this.options);if("string"===typeof b){if(a===e)return this.options[b];switch(b){case "value":a=Math.max(0,Math.min(a,this.options.maxValue))}this.options[b]=a;this._draw("radius"===b?this._prepareCanvas(this.canvas):this.canvas)}return this}};c.fn.circularStat=function(b){var a="string"===typeof b,d=Array.prototype.slice.call(arguments,1),f=this;if(a&&"_"===b.charAt(0))return f;
a?this.each(function(){var a=c.data(this,"circular"),g=a&&c.isFunction(a[b])?a[b].apply(a,d):a;if(g!==a&&g!==e)return f=g,!1}):this.each(function(){c.data(this,"circular")||c.data(this,"circular",new h(this,b))});return f};c(function(){c('[data-provide="circular"]').each(function(){var b=c(this);b.circularStat(b.data())})})})(jQuery,window,document);


