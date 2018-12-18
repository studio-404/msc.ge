var Config = {
    website:"https://msc.ge/",
    ajax:"https://msc.ge/ge/ajax/index", 
    pleaseWait:"მოთხოვნა იგზავნება...",
    mainLanguage:"ge"
};

$(".mainsearch").on('keyup', function (e) {
    var v = encodeURI($(this).val());
    var lang = $(".lang").val();
    if (e.keyCode == 13) {
        location.href = Config.website+lang+"/search?w="+v;
    }
});

$(document).on("click", ".changeLanguage", function(){
	var ajaxFile = "/changeLanguage";
    $.ajax({
        method: "POST",
        url: Config.ajax + ajaxFile,
        data: { change:true }
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Success.Code==1){
           location.reload();
        }else{
            alert("Error");
        }
    });
});

$(document).on("click", ".answer", function(){
    var ajaxFile = "/pollupdate";
    var answer = $(this).attr("data-col");
    var poll_id = $(this).attr("data-polid");
     $(".poll-container").html("...");
    $.ajax({
        method: "POST",
        url: Config.ajax + ajaxFile,
        data: { answer:answer, poll_id:poll_id }
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        
        if(obj.Success.Code==1){
            setTimeout(function(){
                $(".poll-container").html(obj.Success.UpdatedPoll);
            }, 1500);
        }
    });
});


$(document).on("click", ".contact-button", function(){
    var ajaxFile = "/sendmessage";
    var lang = $(".lang").val();
    var firstname = $(".firstname").val();
    var email = $(".email").val();
    var message = $(".message").val();

     $(".message-text").html("...");
    $.ajax({
        method: "POST",
        url: Config.ajax + ajaxFile,
        data: { firstname:firstname, email:email, message:message, lang:lang }
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        
        if(obj.Success.Code==1){
            $(".message-text").html(obj.Success.Text);

            $(".firstname").val('');
            $(".email").val('');
            $(".message").val('');
        }else{
            $(".message-text").html(obj.Error.Text);            
        }
    });
});