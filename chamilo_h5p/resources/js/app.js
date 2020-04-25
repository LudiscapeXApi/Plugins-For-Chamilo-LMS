
function getbyelem(n){
	
	if(document.getElementById(n)){
	
		var tagName = document.getElementById(n).tagName;
		
		if(tagName=='SELECT'){
			var get_id = document.getElementById(n);
			var resultselect = get_id.options[get_id.selectedIndex].value;
			//console.log(resultselect);
			return resultselect;
		}
		
		if(tagName=='INPUT'){
			return document.getElementById(n).value;
		}
		
		if(tagName=='TEXTAREA'){
			var ct = document.getElementById(n).value;
			ct = ct.replace('\n','<br />');
			return ct;
		}
	
	}else{
	
		return "-";
		
	}

}

function checkRadio(r){
	$('#rad' + r).prop('checked',true);
	$('#dictionary_typenode').val(r);
}

$(document).ready(function(){

	var u = window.top.location.href;
	
	if(u.indexOf('action=edit')==-1){
		$("#dictionary").css("display","none");
		var btn = '<a id="addElement" href="#" onClick="showEditFormulaire();" class="btn btn-success">';
		btn += 'Create Page</a><br><br>';
		//$("#dictionary").parent().prepend(btn);
	}

	$("#dictionary_title").parent().parent().css("display","none");
	$("#dictionary_typenode").parent().parent().css("display","none");
	$("#dictionary_submit").parent().parent().css("display","none");
	$("#dictionary_descript").parent().parent().css("display","none");

	$("#dictionary_terms_a").parent().parent().css("display","none");
	$("#dictionary_terms_b").parent().parent().css("display","none");
	$("#dictionary_terms_c").parent().parent().css("display","none");

	$("#dictionary_opt_1").parent().parent().css("display","none");
	$("#dictionary_opt_2").parent().parent().css("display","none");
	$("#dictionary_opt_3").parent().parent().css("display","none");
	
	$("#dictionary_submit").parent().prepend('<a style="margin-right:10px;" href="node_list.php" class="btn btn-default" ><b>' + $("#h5p_cancel").html() + '</b></a>');
	
	$("#dictionary_submit").click(function(e){
		
		var pagetype = $("#dictionary_typenode").val();

		var title = $("#dictionary_title").val();
			if(title==''){
				$("#dictionary_title").css("background","pink");
				e.preventDefault();
			}else{
				if(u.indexOf('action=edit')==-1){
					if(pagetype==''){
						e.preventDefault();
					}
				}
			}	
	});

});

$(document).ready(function(){

    var menuBc = '<li class="active">&nbsp;&nbsp;';
	menuBc += '<a><img src="img/edit.png" alt="">H5P</a>&nbsp;&nbsp;</li>';

    var btn = '&nbsp;&nbsp;<a id="addElement" href="#" ';
	btn += ' onClick="showEditFormulaire();" class="btn btn-success">+</a>';

	var u = window.top.location.href;
	
    $(".breadcrumb").html(menuBc + btn);
    $(".view-options").css("display","none");
	if(u.indexOf('action=edit')!=-1){
	    $(".styleOfPages").css("display","none");
	}
	$("#addElement").css("background","#30353d").css("border-color","#30353d");
	$(".breadcrumb").css("background","#474f5a");
	$(".breadcrumb").css("color","white");
	$(".breadcrumb li").css("color","white");
	$(".breadcrumb li a").css("color","white");

});

function showEditFormulaire(){
	$("#dictionary").css("display","");
	$("#addElement").css("display","none");
	$(".alert-info").css("display","none");
	checkRadio(1);
}
function closeEditFormulaire(){
	$("#dictionary").css("display",'none');
	$("#addElement").css("display",'');
}

function showFileManger(){
	var urlContent = "../../main/inc/lib/elfinder/filemanager.php";
	var OpenWind = window.open(urlContent,'FileManager','menubar=no, scrollbars=no, top=50, left=50, width=700, height=600');
	console.log(OpenWind.setUrl);
}

function showFileMangerold(){

	$('<div \>').dialog({modal: true, width: "80%", title: "Select your file", zIndex: 99999,
		create: function(event, ui) {
			$(this).elfinder({
				resizable: false,
				url: "../../main/inc/lib/elfinder/connectorAction.php",
				commandsOptions: {
					getfile: {
					oncomplete: 'destroy' 
					}
				},                            
				getFileCallback: function(file) {
					document.getElementById('fileurl').value = file; 
					jQuery('a.ui-dialog-titlebar-close[role="button"]').click();
				}
			}).elfinder('instance')
		}
	});

}