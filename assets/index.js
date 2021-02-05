
$(document).ready(function(){
    
  //Load Sales data on document ready..
  load_data(null);


  //Initiate Search submit on filter value entrace on customer, product and price
  $("#searchSubmit").on("keyup", function() {

    setTimeout(function(){
      var filterVals = $("#searchSubmit").serialize(); 
      load_data(filterVals);
    }, 1000);
    
  });

  //Load Sales data via Ajax..
  function load_data(data){

    //Modify filter params according to requirements..
    if(data){
        data += '&filter=true';
    }else{
      data = 'filter=false';
    }

    data += '&searchsubmit=true';

    $.ajax({
      url: "classes/app.php",
      cache: false,
      data: data,
      success: function(html){
        console.log('HTML');
        //console.log(html);
        $("#salesTables").html(html);
      }
    });
  }

});
