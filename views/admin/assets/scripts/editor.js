document.addEventListener('DOMContentLoaded', function(){
	var el = document.getElementsByName('content');
	if(el && el[0]){
		var content = '';
		if(el[0].textContent !== undefined){
			content = el[0].textContent;
		}else if(el[0].innerText !== undefined){
			content = el[0].innerText;
		}
		var editor = new EpicEditor({
			container: 'editor',
			clientSideStorage: false /* Doesn't handle different posts, fix this later */,
			basePath: '/app/views/admin/epiceditor/',
			theme: {
				base: 'themes/base/epiceditor.css',
				preview: '../../../../themes/default/css/style.css',
				editor: 'themes/editor/hawalius.css?a'
			},
			file: {
				defaultContent: content
			}
		}).load();
		editor.on('save', function(){
			if(el[0].textContent !== undefined){
				el[0].textContent = editor.exportFile();
			}else if(el[0].innerText !== undefined){
				el[0].innerText = editor.exportFile();
			}
		});
	}
});