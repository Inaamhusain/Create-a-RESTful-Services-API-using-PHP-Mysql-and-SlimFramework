var API = {
  call:function(url,callback,data){
    var data = (!!data) ? data : {};
    var callback = (!!callback) ? callback : function(){};
    $.ajax({
      dataType: "jsonp",
      crossDomain: true,
      xhrFields: { withCredentials: true }, 
      url: "api/"+url,
      data:data,
      success:callback,
      error:function(data){
        console.log(data);
      }
    });    
  }
}