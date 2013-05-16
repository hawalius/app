Admin.Dashboard = {
	init: function(){
		Admin.Dashboard.Clock.init();
	}
};
Admin.Dashboard.Clock = {
	init: function(){
		Admin.Dashboard.Clock.update();
		setInterval(function(){
			Admin.Dashboard.Clock.update();
		}, 1000);
	},
	getMonthName: function(date){
		var monthNames = [
			'January', 'February', 'March',
			'April', 'May', 'June',
			'July', 'August', 'September',
			'October', 'November', 'December'
		];
		return monthNames[date.getMonth()];
	},
	update: function(){
		var now = new Date(),
			hr = now.getHours(),
			el = document.getElementById('widget_clock');
		if(hr > 12){
			hr -= 12;
		}
		if(hr == 0){
			hr = 12;
		}
		var mn = now.getMinutes(); 
		if(mn < 10){
			mn = '0' + mn;
		}
		var sc = now.getSeconds();
		if(sc < 10){
			sc = '0' + sc;
		}
		var year;
		if(now.getFullYear){
			year = now.getFullYear()
		}else{
			// This is not a good way to do it, it will fail in some (old) browsers
			var yy = now.getYear();
			year = (yy < 1000) ? yy + 1900 : yy;
		}
		var day = now.getDate();
		var month = Dashboard.Clock.getMonthName(now);
		el.innerHTML = '<div class="time">'+hr+ ':'+mn+':'+sc+ ' '+(hr >= 12 ? 'PM' : 'AM')+'</div><div class="date">'+day+' '+month+', '+year+'</div>';
	}
};
document.addEventListener('DOMContentLoaded', function(){
	Admin.Dashboard.init();
});