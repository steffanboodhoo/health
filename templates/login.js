$( document ).ready(function() {
    
    // _get('/test',null,null); works
    function setup(){
    	$('btn_login').click(function{

    	});
    	$('btn_guest').click(function(){

    	});
    }
    function login(){
    	var dataObj = {};
    	dataObj['username'] = $('#input_username').val();
    	dataObj['password'] = $('#input_password').val();
    	console.log(dataObj);
    	_get('/login',dataObj,function(data){
    		console.log(data);
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
                console.log('----');
                console.log(response);
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
                console.log('----');
                console.log(response);
            },
            headers: {
                "Content-Type":"application/x-www-form-urlencoded",
            }
        })
    }
});