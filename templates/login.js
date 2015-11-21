$( document ).ready(function() {
    var baseurl = 'http://localhost/health';
    // _get('/test',null,null); works
    setup();
    function setup(){
    	$('#btn_login').click(function(){
    		login();
    	});
    	$('#btn_guest').click(function(){
    		_get('/home',null,null);
    	});
    }
    function login(){
    	var dataObj = {};
    	dataObj['username'] = $('#input_username').val();
    	dataObj['password'] = $('#input_password').val();
    	console.log(dataObj);
    	_post('/login',dataObj,function(data){
    		if(data['status']==1)
                window.location = "/index.php/home";
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