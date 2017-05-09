$(".tron").mouseover(function(){
	// 修改这个TR里每个TD的背景色
	$(this).find("td").css('backgroundColor', '#DEE7F5');
});

// 当鼠标移开的时候，颜色变回来原色
$(".tron").mouseout(function(){
	// 修改这个TR里每个TD的背景色
	$(this).find("td").css('backgroundColor', '#FFF');
});