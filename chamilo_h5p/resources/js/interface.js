
function interfacewordsmatch(){

    $(".dataTables_wrapper").css("display","none");
    $("#dictionary_typenode").parent().parent().css("display","none");
    $("#nodeselection").parent().parent().css("display","none");
    
	$("#dictionary_title").parent().parent().css("display","");
    $("#dictionary_title").parent().append("<i>" +  $("#h5p_title_help").html() + "</i>");
    
    $("#dictionary_submit").parent().parent().css("display","");

    $("#dictionary_descript").parent().parent().css("display","");
    $("#dictionary_descript").parent().append("<i>" +  $("#h5p_descr_help").html() + "</i>");
    $("#dictionary_descript").val($("#h5p_wordsmatch_tutor").html());

    $("#dictionary").css("display","");
    $("#addElement").css("display","none");
    $("#nodeselection").css("display","none");

    $("#dictionary_terms_a").parent().parent().css("display","");
    $("#dictionary_terms_a").val($("#h5p_wordsmatch_load").html());
    $("#dictionary_terms_a").parent().append("<i>" +  $("#h5p_wordsmatch_help").html() + "</i>");
    
    interfaceNameLabel('terms_a',$("#h5p_wordsmatch_term_a").html());

}

function interfacedragthewords(){

    $(".dataTables_wrapper").css("display","none");
    $("#dictionary_typenode").parent().parent().css("display","none");
    $("#nodeselection").parent().parent().css("display","none");
    
	$("#dictionary_title").parent().parent().css("display",'');
    $("#dictionary_title").parent().append("<i>" +  $("#h5p_title_help").html() + "</i>");
    
    $("#dictionary_submit").parent().parent().css("display",'');

    $("#dictionary_descript").parent().parent().css("display",'');
    $("#dictionary_descript").parent().append("<i>" +  $("#h5p_descr_help").html() + "</i>");
    $("#dictionary_descript").val($("#h5p_dragthewords_tutor").html());
    
    $("#dictionary").css("display",'');
    $("#addElement").css("display","none");
    $("#nodeselection").css("display","none");

    $("#dictionary_terms_a").parent().parent().css("display",'');
    $("#dictionary_terms_a").val($("#h5p_dragthewords_load").html());
    $("#dictionary_terms_a").parent().append("<i>" +  $("#h5p_dragthewords_help").html() + "</i>");
    
    interfaceNameLabel('terms_a',$("#h5p_wordsmatch_term_a").html());

}

function interfaceNameLabel(idjq,name){
    
    $("label").each(function( index ) {

        var forSrcAttr = $( this ).attr("for");
        if(typeof forSrcAttr === "undefined"){
            forSrcAttr = '';
        }
        if(forSrcAttr.indexOf('_' + idjq)!=-1){
            $(this).html(name);
		}
	
	});

}