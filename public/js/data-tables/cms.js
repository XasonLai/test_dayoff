var MT = {
    oTable : null,

    init : function () {

    },

    getDataTable : function (obj) {
    	this.source = '';
        this.order = [[0,'desc']];
    	this.searchable = '';
        this.callback = function(){};
        this.status = function(){};
        
    	for(var key in obj){
    		if(obj[key] != undefined) this[key] = obj[key];	
    	}
    	
        if(CURRENT_LANG=="tr") var oLang = {oLanguage : {"sUrl": BASE + "/assets/data-tables/turkish.json"}};
        else oLang = {};
        
        var options = {
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
            		"sProcessing": "&nbsp;&nbsp;處理中...",
                    "sLengthMenu": "每頁顯示 _MENU_ 條記錄",
                    "sZeroRecords": "對不起，查詢不到相關數據",
                    "sInfo": "當前顯示 _START_ 到 _END_ 條，共 _TOTAL_ 條記錄",
                    "sInfoEmtpy": "無任何資料",},
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": true,
            "sAjaxSource": this.source,
            "aaSorting": this.order,
            'fnDrawCallback': this.callback,
            "fnServerParams": this.status,
            'aoColumnDefs' : this.searchable

        };
        MT.oTable = $('#datatable_ajax2').dataTable($.extend(options, oLang ));


    },
    dataTableReload : function () {
        if(MT.oTable!=null) MT.oTable.fnDraw();
    },

    deleteAjaxWithConfirm : function(url,token){
        bootbox.confirm(LANG.sureDelete, function(result) {
            if(result==true && url!="" && url!="#"){
                $.ajax({
                    type: 'post',
                    url: url,
                    data: { _method:'DELETE',_token :token},
                    success: function(response) {
                        if(response=="ok"){
                        	alert(LANG.successful);
                            MT.dataTableReload();
                        }else{
                         	alert(LANG.an_error_occured);   
                        }
                    }
                });
            }
        });
    }
};





