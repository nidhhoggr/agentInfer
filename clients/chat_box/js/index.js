$(document).ready(function() {

    // load messages every 1000 milliseconds from server.
    load_data = {'fetch':1};

    printToScreen = function(msg, cb)
    {
        printable = "<hr /><b>" + msg.msg_from + " (" + msg.date_created + ")</b>:  " + msg.msg;

        $('.message_box').append(printable);

            //var scrolltoh = $('.message_box')[0].scrollHeight;

            //$('.message_box').scrollTop(scrolltoh);
 
        if(cb) cb(); 
    
    }

    window.setInterval(function(){
     $.post('shout.php', load_data,  function(data) {

        resp = $.parseJSON(data);

        for(i in resp)
        {
            msg = resp[i];

            printToScreen(msg);
        }
     });
    }, 2000);

    //method to trigger when user hits enter key
    $("#shout_message").keypress(function(evt) {
        if(evt.which == 13) {

                var imessage = $('#shout_message').val();

                post_data = {'message':imessage};
                
                //send data to "shout.php" using jQuery $.post()
                $.post('shout.php', post_data, function(data) {
    
                    msg = $.parseJSON(data);

                    printToScreen(msg, function() {
                        //reset value of message box
                        $('#shout_message').val('');
                    });
                    
                }).fail(function(err) { 
                    //alert HTTP server error
                    alert(err.statusText); 
                });
            }
    });
    
    //toggle hide/show shout box
    $(".close_btn").click(function (e) {
        //get CSS display state of .toggle_chat element
        var toggleState = $('.toggle_chat').css('display');
        
        //toggle show/hide chat box
        $('.toggle_chat').slideToggle();
        
        //use toggleState var to change close/open icon image
        if(toggleState == 'block')
        {
            $(".header div").attr('class', 'open_btn');
        }
        else
        {
            $(".header div").attr('class', 'close_btn');
        }
    });
});

