
  if(!window.jQuery) {
     var jQuery = {
      ajax: function(obj) {
         var s = new sack(obj.url); 
         s.asynchronous = obj.async;
         s.onCompletion = function() {
        	if (s.responseStatus && s.responseStatus[0] == 200) {   
                  obj.success(s.response);
        	}
         };
         s.runAJAX(obj.data);
     
      },
      post: function(url,params,callback,context) {
         var s = new sack(url);
         s.onCompletion = function() {
        	if (s.responseStatus && s.responseStatus[0] == 200) {   
                  callback(s.response);
        	}
         };
         s.runAJAX(params);
      }
     };
  }

