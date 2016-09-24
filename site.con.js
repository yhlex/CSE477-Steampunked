/*! DO NOT EDIT project3 2016-05-04 */
function Game(sel) {
    this.update(sel);
    this.data = {};
}


Game.prototype.update = function(sel) {
    var that = this;
    var form = $(sel);
    var newGame = document.getElementsByName('new-game')[0];
    var openValve = document.getElementsByName('open-valve')[0];

    console.log(openValve);

    //this.OpenValve(openValve);
    //console.log(newGame);

    if(newGame){
        this.newGame(newGame);
        console.log(newGame);
    }
    $("form input[type=submit]").click(function() {
        $("form input[type=submit]").attr("clicked","false");
        $(this).attr("clicked", "true");
    });

    form.submit(function(event) {

        event.preventDefault();

        var button = $("input[type=submit][clicked=true]");
        var name = button.attr('name');
        var idx = $("input[name=pipe]:checked").val();

        if(name=="rotate") {

            data = {rotate:"rotate",pipe:idx};
            //
            //var radio = document.getElementsByName('pipe');
            //console.log(radio[pipeIndex]);
            ////radio[pipeIndex].setAttribute("checked","checked");
            //console.log(radio[pipeIndex]);

        }
        else if(name=="insert") {
            var pos = button.attr("value");
            data = {insert:pos,pipe:idx};
        }
        else if(name=="discard") {
            data = {discard:"discard",pipe:idx};
        }
        else{

            var data ={};data[name]=name;
            console.log(data);


        }
        that.ajax(data);

    });

}

Game.prototype.ajax = function(data){
    var that = this;
    $.ajax({
        url: "game-post.php",
        data: data,
        method: "POST",
        success: function(data) {

            var jsn = JSON.parse(data);

            $('#grid').html(jsn.grid);
            $('#pipeOptions').html(jsn.pipeOptions);
            $('#error').html(jsn.error);
            $('#turnMessage').html(jsn.turnMessage);
            $('#win').html(jsn.winnerOptions);

            that.update();
        },
        error: function(xhr, status, error) {
            console.log("Error");
        }
    });
}

//Game.prototype.OpenValve = function(button) {
//    var that = this;
//    var form = $('form');
//    button.onclick = function (event) {
//        event.preventDefault();
//        $.ajax({
//            url: "game-post.php",
//            data: {"open-valve": "open-valve"},
//            method: "POST",
//            success: function (data) {
//                // console.log(data);
//                var jsn = JSON.parse(data);
//
//                $('#grid').html(jsn.grid);
//                $('#pipeOptions').html(jsn.pipeOptions);
//                $('#error').html(jsn.error);
//                $('#turnMessage').html(jsn.turnMessage);
//                $('#win').html(jsn.winnerOptions);
//
//                that.update();
//            },
//            error: function (xhr, status, error) {
//                console.log("!!!!!");
//            }
//        });
//    }
//}
Game.prototype.newGame = function(button){
    var that = this;
    var form = $("form");

    button.onclick = function(event){
        event.preventDefault();
        $.ajax({
            url: "game-post.php",
            data: {"new-game": "new-game"},
            method: "POST",
            success: function(data) {
                // console.log(data);
                var jsn = JSON.parse(data);

                $('#grid').html(jsn.grid);
                $('#pipeOptions').html(jsn.pipeOptions);
                $('#error').html(jsn.error);
                $('#turnMessage').html(jsn.turnMessage);
                $('#win').html(jsn.winnerOptions);

                that.update();
            },
            error: function(xhr, status, error) {
                console.log("!!!!!");
            }
        });
        location.replace("./");
    }
}



function parse_json(json) {
    try {
        var data = $.parseJSON(json);
    } catch(err) {
        throw "JSON parse error: " + json;
    }

    return data;
}
function parse_json(json) {
    try {
        var data = $.parseJSON(json);
    } catch(err) {
        throw "JSON parse error: " + json;
    }

    return data;
}