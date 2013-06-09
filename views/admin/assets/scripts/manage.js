Admin.Manage = {
	init: function(){
		var deleteLinks = document.getElementsByClassName('delete');
		var postForm = document.getElementsByTagName('form')[0];
		var pageForm = document.getElementsByTagName('form')[1];
		[].forEach.call(deleteLinks, function(link){
			if(link){
				link.onclick = function(e){
					var href = link.parentNode.parentNode.getElementsByTagName('a')[3].href;
					if(href.indexOf('posts') !== -1){
						postForm.id.value = link.getAttribute('data-post');
						postForm.submit();
					}else if(href.indexOf('pages') !== -1){
						pageForm.id.value = link.getAttribute('data-post');
						pageForm.submit();
					}
					if(e.preventDefault){
						e.preventDefault();
					}
					return false;
				};
			}
		});
	}
};
document.addEventListener('DOMContentLoaded', function(){
	Admin.Manage.init();
});