Chart.defaults.global.animation.easing = 'easeInOutCirc';
Chart.defaults.global.hover.mode = 'nearest';
Chart.defaults.global.legend.position = 'bottom';
Chart.defaults.global.legend.labels.fontFamily = Chart.defaults.global.tooltips.titleFontFamily = Chart.defaults.global.tooltips.bodyFontFamily = Chart.defaults.global.tooltips.footerFontFamily = "Krub, sans-serif";
Chart.defaults.global.legend.labels.fontSize = 11;
Chart.defaults.global.legend.labels.boxWidth = 10;
Chart.defaults.global.legend.labels.fontColor = '#6A7075';
Chart.defaults.scale.gridLines.color = 'rgba(175,184,201,0.1)';//'#EBECEE'
Chart.defaults.line.scales.xAxes[0] = {
  gridLines: {
    display: false,
	color: 'rgba(0,0,0,0)'
  },
  ticks:{
	 autoSkip: true,
        maxTicksLimit: 20
  }
};
Chart.defaults.bar.scales.xAxes[0] = {
  gridLines: {
    display: false,
	color: 'rgba(0,0,0,0)'
  },
  ticks:{
	 autoSkip: true,
        maxTicksLimit: 20
  }
};
Chart.defaults.line.scales.yAxes[0] = {
 beginAtZero : false,
};
Chart.defaults.bar.scales.yAxes[0] = {
 beginAtZero : false
};
Chart.defaults.line.tooltips = {
	mode: 'index',
	intersect: false,
}
Chart.defaults.scale.ticks.fontFamily = "Krub, sans-serif";
Chart.defaults.scale.ticks.fontSize = 10;
Chart.defaults.scale.ticks.fontColor = '#6A7075';//#8B949B
Chart.defaults.global.elements.line.borderWidth = 2;
Chart.defaults.global.elements.line.tension = 0.2;
Chart.defaults.global.elements.point.radius =0;
Chart.defaults.global.elements.point.hitRadius = 10;
Chart.defaults.radar.elements.point = {
	radius : 3,
}
//Chart.defaults.radar.elements.line.tension = 0.1;
Chart.defaults.radar.spanGaps = true;
Chart.defaults.radar.scale = {
	type: 'radialLinear',
	ticks:{
		backdropColor : '#EFF0F3',
	},
	pointLabels:{
		fontFamily : "Krub, sans-serif",
		fontSize : 11,
		fontColor :  '#8B949B',
		fontStyle : 'bold',
	},
	gridLines: {
		color: 'rgba(175,184,201,0.4)'
	  },
}
