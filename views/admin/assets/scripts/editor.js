document.addEventListener('DOMContentLoaded', function(){
	var el = document.getElementsByName('content');
	var transfer = function(file){
		var reader = new FileReader();
		reader.file = file;
		reader.type = file.type;
		reader.callback = complete;
		reader.onload = reader.callback;
		reader.readAsText(file);
	};
	var complete = function(e){
		var content = '', file = {type: undefined};
		if(e && e.currentTarget){
			if(e.currentTarget.result){
				content = e.currentTarget.result;
			}
			if(e.currentTarget.file){
				file = e.currentTarget.file;
			}
		}
		if(images.indexOf(file.type) !== -1){ // is image			
		}else if(file.type == 'text/x-markdown' || file.name.slice(file.name.length - 3) == '.md'){ // hack since chrome doesn't recognize .md files
			if(content){
				editor.importFile(false, content);
			}
		}
	};
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
		
		var editorEl = editor.editor;
			images = ['image/jpeg', 'image/gif', 'image/png'];
		
		editor.on('save', function(){
			if(el[0].textContent !== undefined){
				el[0].textContent = editor.exportFile();
			}else if(el[0].innerText !== undefined){
				el[0].innerText = editor.exportFile();
			}
		});
		
		function noop(e){
			if(e.stopPropagation){
				e.stopPropagation();
			}
			if(e.preventDefault){
				e.preventDefault();
			}
		}
		
		editorEl.addEventListener('dragenter', noop);
		editorEl.addEventListener('dragexit', noop);
		editorEl.addEventListener('dragover', noop);
		editorEl.addEventListener('drop', function(e){
			noop(e);
			if(e.dataTransfer && e.dataTransfer.files){
				var files = e.dataTransfer.files;
				var count = files.length;
				
				if(count == 1){
					var file = files[0];
					transfer(file);
				}else if(count > 0){
					files.forEach();
				}
			}
		});
	}
});