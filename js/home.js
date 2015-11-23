$( document ).ready(function() {
    console.log( "ready!" );
    
    var access = false;
	var action = {
		'display':1,
		'create':2,
		'modify':3
	};
	var currentAction = action.display;    

    (function(){
    	(function(){
    		var today = new Date();
    		var str = 	'<label class="col-md-4 control-label" for="date_onset">Onset</label>'+ 
    					'<div class="col-md-4"> <input id="date_onset" type="text" class="form-control date_field" value="01-01-2015"> </div> <div class="col-md-4"></div>';
    		$('#date-container-onset').append(str);

    		str = '<label class="col-md-4 control-label" for="date_seen">Seen</label>'+
				'<div class="col-md-4"> <input id="date_seen" type="text" class="form-control date_field" value="'+(today.getMonth()+1)+'-'+today.getDate()+'-'+today.getFullYear()+'"</div>';
    		$('#date-container-seen').append(str);
    		
    		$('.date_field').datepicker();
    	})();
        _get('/validate',null,function(dataObj){
            toggleBox(false);
            if(dataObj['status']==1)
                access = true;
        })
    	$('#btn_save').click(function(){
    		if(access)
                insert();
            else
                toggleBox(true);
    	});

        $('#btn_access').click(function(){
            logout();
        });

        $('.nav').click(function(){
            toggleBox(false);
        })

    })();


    function createTable(dataObj, clickCallBack){
    	var columnNames = dataObj['columns'], data = dataObj['data'];
    	var table = $('<table/>',{id:'results_table',class:'display',cellspacing:'0',width:'100%'}),
		thead = $('<thead/>'), tr = $('<tr/>');

		//head [creation/init]
		columnNames.forEach(function(el){ //creates the header for each column
			tr.append($('<th/>').append(el));
		});
		//this Column will be used for any buttons
		tr.append($('<th/>').append('Action'));

		thead.append(tr);

		var tbody = $('<tbody/>');
		
		//body [creation/init]
		for(var row_key in data){
			tr = $('<tr/>');
			var row = data[row_key];
			for(var column in columnNames){
				var td = $('<td/>').append(row[columnNames[column]]);
				tr.append(td);
			}
			//create buttons for action field
			var btn = $('<button/>',{"class":"btn btn-default"}).append($('<span/>',{"class":"glyphicon glyphicon-wrench"}));
			tr.append($('<td/>').append(btn));
			tbody.append(tr);
		}
		table.append(thead);table.append(tbody);
		$('#table_container').append(table);

		var table = $('#results_table').DataTable();
		$('#results_table tbody').on( 'click', 'button', function () {  	
        	if(!access){
                toggleBox(true);
                return;
            }
            var data = table.row( $(this).parents('tr') ).data();
        	data.pop(10);
        	var dataObj = {};
        	dataObj['id'] = data[0];
        	dataObj['age'] = data[1];
        	dataObj['sex'] = data[2];
        	dataObj['address'] = data[3];
        	// dataObj['phone'] = data[4];
        	dataObj['onset'] = data[4];
        	dataObj['seen'] = data[5];
        	dataObj['referral'] = data[6];
        	dataObj['diagnosis'] = data[7];
        	dataObj['symptoms'] = data[8];
        	dataObj['notes'] = data[9];
        	navToEdit(dataObj);
    	});

    }

   

    _get('/getAll',null,function(dataObj){createTable(dataObj,null)});

    function insert(){
        var dataObj = {};
        dataObj['name'] = $('#input_name').val();
        dataObj['age'] = $('#input_age').val();
        dataObj['phone'] = $('#input_phone').val();
        dataObj['sex'] = $('input[name="radio_sex"]:checked').val();
        dataObj['address'] = $('#input_address').val();
        dataObj['diagnosis'] = $('#input_diagnosis').val();
        dataObj['referral'] = $('input[name="radio_referral"]:checked').val();
        dataObj['symptoms'] = $('#input_symptoms').val();
        dataObj['notes'] = $('#input_notes').val();
        var dates = [$('#date_onset').datepicker('getDate'),$('#date_seen').datepicker('getDate')];
        dates = [dates[0].getTime()/1000,dates[1].getTime()/1000];
        dataObj['onset'] = dates[0];
        dataObj['seen'] = dates[1];
        dataObj['lon'] = $('#input_lon').val();
        dataObj['lat'] = $('#input_lat').val();
        console.log(dataObj);
        _post('/subject',dataObj,null);  
        document.getElementById("insert_form").reset();  
    }

    function update(constraints){
        var dataObj = {};
        dataObj['age'] = $('#modify_age').val();
        // dataObj['sex'] = $('input[name="radio_sex"]:checked').val();
        dataObj['address'] = $('#modify_address').val();
        dataObj['diagnosis'] = $('#modify_diagnosis').val();
        // dataObj['referral'] = $('input[name="radio_referral"]:checked').val();
        dataObj['symptoms'] = $('#modify_symptoms').val();
        dataObj['notes'] = $('#modify_notes').val();
        var dates = [$('#modify_onset').datepicker('getDate'),$('#modify_seen').datepicker('getDate')];
        dates = [dates[0].getTime()/1000,dates[1].getTime()/1000];
        dataObj['onset'] = dates[0];
        dataObj['seen'] = dates[1];
        
        var postObj = {};
        postObj['update'] = dataObj;
        postObj['constraint'] = constraints;
        console.log(postObj);
        document.getElementById("update_form").reset();
        _post('/subject/update',postObj,null);
    }

    function navToEdit(oldRec){
    	switch_on_click();
    	createEdit(oldRec);
    }
    
    function switch_on_click(){
    	var new_tab = "tab_2";
    	var current_tab = "tab_0";
		document.getElementById(current_tab).className = 
			document.getElementById(current_tab).className.replace(/\bactive\b/,'');
		document.getElementById(new_tab).className = 
			document.getElementById(new_tab).className +" active"
		tabs = document.getElementById('nav_tabs')
		tabs.children[0].className = tabs.children[0].className.replace(/\bactive\b/,'');
		tabs.children[2].className = tabs.children[2].className + " active"; 
	}	

    function createEdit(oldRec){
    	var tab = $('#tab_2');
    	tab.empty();
    	var form = $('<form/>',{"class":"form-horizontal","id":"update_form"}).appendTo(tab);
    	var set = $('<fieldset/>').appendTo(form);
    	$('<legend/>').append('Modifications').appendTo(set);

    	var d1 = cdiv(2).appendTo(set);
    	$('<label/>',{"class":"col-md-4 control-label","for":"modify_age"}).append("Age").appendTo(d1);
    	cdiv(1).append($('<input/>',{'class':'form-control input-md','type':'number','id':'modify_age','value': oldRec['age']})).appendTo(d1);
    	cdiv(3,oldRec['age']).appendTo(d1);

    	var d2 = cdiv(2).appendTo(set);
    	$('<label/>',{"class":"col-md-4 control-label","for":"modify_address"}).append("Address").appendTo(d2);
    	cdiv(1).append($('<input/>',{'class':'form-control input-md','type':'text','id':'modify_address','value': oldRec['address']})).appendTo(d2);
    	cdiv(3,oldRec['address']).appendTo(d2);

    	//------------------TEXT AREAs
    	var d4 = cdiv(2).appendTo(set);
    	$('<label/>',{"class":"col-md-4 control-label","for":"modify_diagnosis"}).append("Diagnosis").appendTo(d4);
    	cdiv(1).append($('<textarea/>',{'class':'form-control input-md','id':'modify_diagnosis'}).append(oldRec['diagnosis'])).appendTo(d4);
    	cdiv(3,oldRec['diagnosis']).appendTo(d4);

    	var d5 = cdiv(2).appendTo(set);
    	$('<label/>',{"class":"col-md-4 control-label","for":"modify_symptoms"}).append("Symptoms").appendTo(d5);
    	cdiv(1).append($('<textarea/>',{'class':'form-control input-md', 'id':'modify_symptoms'}).append(oldRec['symptoms'])).appendTo(d5);
    	cdiv(3,oldRec['symptoms']).appendTo(d5);

    	var d6 = cdiv(2).appendTo(set);
    	$('<label/>',{"class":"col-md-4 control-label","for":"modify_notes"}).append("Notes").appendTo(d6);
    	cdiv(1).append($('<textarea/>',{'class':'form-control input-md', 'id':'modify_notes'}).append(oldRec['notes'])).appendTo(d6);
    	cdiv(3,oldRec['notes']).appendTo(d6);
    	//------------------
    	var d7 = cdiv(2).appendTo(set);
    	$('<label/>',{"class":"col-md-4 control-label","for":"modify_onset"}).append("Onset").appendTo(d7);
    	cdiv(1).append($('<input/>',{'class':'modify_date form-control input-md', 'id':'modify_onset','value': oldRec['onset']})).appendTo(d7);
    	cdiv(3,oldRec['onset']).appendTo(d7);

    	var d8 = cdiv(2).appendTo(set);
    	$('<label/>',{"class":"col-md-4 control-label","for":"modify_seen"}).append("Seen").appendTo(d8);
    	cdiv(1).append($('<input/>',{'class':'modify_date form-control input-md', 'id':'modify_seen','value': oldRec['seen']})).appendTo(d8);
    	cdiv(3,oldRec['seen']).appendTo(d8);
    	$('.modify_date').datepicker();

        var d9 = cdiv(2).appendTo(set);
        cdiv(1).appendTo(d9);
        cdiv(1).append($('<button>',{"type":"button","id":"btn_modify","class":"btn btn-info"}).append("done")).appendTo(d9);
        
        $('#btn_modify').click(function(){
            if(access)
                update({'id':oldRec['id']});
            else
                toggleBox(true);
        })
    	
        function cdiv(opt,old){
    		if(opt==1)
    			return $('<div/>',{"class":"col-md-4"});
    		if(opt==2)
    			return $('<div/>',{"class":"form-group"});
    		if(opt==3)
    			return $('<div/>',{"class":"col-md-4"}).append('<p class="help-block">Old Value : '+old+'</p>');
    	}
    }

    function logout(){
        _get('/validate',null,function(dataObj){
            if(dataObj['status']==1){console.log('logging out');

                //unset and log out
                _get('/logout',null,function(dataObj){
                    if(dataObj['status']==1)
                        console.log('successful log out');
                })
            }else{console.log('redirecting');
                //redirect
                
                var getUrl = window.location.origin;
                getUrl+='/health/'
                console.log(getUrl);
                window.location = getUrl;
            }   
        })
    }

     function _get(url,params,call_back){
        var adj_url = '/health/index.php'+url;
        console.log(adj_url);
        $.ajax({
            url:adj_url,
            type:'GET',
            data:params,
            success:function(response){
                if(typeof call_back==='function')
                    call_back(JSON.parse(response))
                else
                    console.log(JSON.parse(response))
            },
            headers: {
                "Content-Type":"application/x-www-form-urlencoded",
            }
        })
    }
    function _post(url,params,call_back){
        var adj_url = '/health/index.php'+url;
        console.log(adj_url);
        $.ajax({
            url:adj_url,
            type:'POST',
            data:params,
            success:function(response){
                // console.log('----');
                // console.log(response);
            },
            headers: {
                "Content-Type":"application/x-www-form-urlencoded",
            }
        })
    }

    function toggleBox(visbility){
        if(visbility)
            $('#err_box').show(); 
        else
            $('#err_box').hide(); 
    }


});