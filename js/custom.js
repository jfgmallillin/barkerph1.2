/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function ajaxComments(url,from,to,start,end){
        var loggedin = false;
        $.ajax({
            type: "POST",
            url: url,
            data: {from: from, to: to,start: start,end: end},
            success: function(result) {
                try {
//                    json format
//                    $data[] = array('ID','USERNAME','DATE_CREATED','TITLE','RATING','CONTENT','COMMENTS')     
                    var jsonData = JSON.parse(result);
                    var paging = "";
                    var output = "<div id='accordion-resizer' class='ui-widget-content'>" +
                            "<div id='accordion'>";

                    var stat = jsonData['status'];
                    loggedin = stat['LOGGED_IN'];
                    var firstcommset = false;
                    for (var i in jsonData) {
                        if (i != 'status' && !(i.substring(0, 'PAGING'.length) === 'PAGING')) {
                            var row = jsonData[i];

                            output += "<h3><a href='" + row['ID'] + "' class='suggestion'>" + row['TITLE'] + "</a></h3>" +
                                    "<div>" +
//                                    "<input id='" + row['ID'] + "' type='text' value='" + row['CONTENT'] + "' style='display:none;'/>" +
                                    "<p>Created by: " + row['USERNAME'] + "</p>" +
                                    "<p>Ratings: " + row['RATING'] + "</p>" +
                                    "<p>Date Created: " + row['DATE_CREATED'] + "</p>";
 
                            var commentdiv = "";
                            if(!firstcommset){
                                getComments(row['ID']);
                                getRoute(row['ID']);
                                commentdiv = "<div id='" + row['ID'] + "' class='commentlist" + row['ID'] + " activecomment'>";
                                firstcommset = true;
                            }else{
                                commentdiv = "<div id='" + row['ID'] + "' class='commentlist" + row['ID'] + "' style='display:none;'>";
                            }
                            commentdiv += "</div>";
                            output += commentdiv;
                            //star ratings

                            output += "</div>";
                        }else if(i.substring(0, 'PAGING'.length) === 'PAGING'){
                            var row = jsonData[i];
                            paging += "<span>" + row['VALUE'] + "</span>";
                        }
                    }
                    output += "</div></div>";
                    $('#SearchOutput').html(output);
                    $('#pagingOutput').html(paging); 
                } catch (err) {
                    $('#SearchOutput').html(result);
                }
            }
        }).done(function() {
            $("a.suggestion").on('click',function(event){
                event.preventDefault();
                $('.activecomment').slideUp();
                $('.activecomment').html('');
                $('.activecomment').removeClass('activecomment');
                var id = $(this).attr('href');
                $('#' + id).addClass('activecomment');
                $('#' + id).hide();
                getComments(id);
                getRoute(id)
            });
        });
    }
     
function getRoute(sug_id){
    $.ajax({
        type: "POST",
        url: "findaway/route/",
        data: {sug_id:sug_id},
        success: function(result){
            var routestring = "";
            var owner = false;
            try{
                var routes = JSON.parse(result);
                owner = routes['SUG_OWNER'];
                for(var i in routes){
                    var route = routes[i];
                    if(i != 'SUG_OWNER'){
                        routestring += "<div class='routedetail'>";
                        routestring += "<div class='transpomode' style='color:" + route['TRANSPOMODE_COLOR'] + "'>" + 
                                route['TRANSPOMODE_NAME'] + "</div>";
                        routestring += "<div class='transpomode_desc'>" + 
                                route['TRANSPOMODE_DESC'] + "</div>";
                        routestring += "<div class='travel_desc'>" + 
                                route['TRAVEL_DESC'] + "</div>";
                        routestring += "<div class='fare'>" + 
                                route['FARE'] + "</div>";
                        routestring += "<div class='ETA'>" + 
                                route['ETA'] + "</div>";
                        routestring += "</div>";
                    }
                }
            }catch(err){
                
            }
            var from = $('#from').val();
            var to = $('#to').val();
            routestring = "<div class='fromto'> From: " + from + "</div>" + routestring;
            routestring = "<div class='routedetails'>" + routestring + "</div><div clas='fromto'> To: " + to + "</div>"; 
            var editroute = "";
            if(owner){
                editroute = "<div id='editrouteauth'><a class='editroute' href='#'>Edit</a></div>";
            }else{
                editroute = "<div id='editrouteauth'>You can not edit this!</div>";
            }
            $('#routeOutput').html(routestring + editroute);
        }
    }).done(function() {
            $("a.editroute").on('click',function(event){
                event.preventDefault();
//                $('.activecomment').slideUp();
//                $('.activecomment').html('');
//                $('.activecomment').removeClass('activecomment');
//                var id = $(this).attr('href');
//                $('#' + id).addClass('activecomment');
//                $('#' + id).hide();
//                getComments(id);
//                getRoute(id)
            });
        });
}

function getComments(sug_id){
    $.ajax({
        type: "POST",
        url: "findaway/comments/",
        data: {SUG_ID: sug_id},
        success: function (result) {
            var commentstring = "<p>Comments:</p><div id='existingcomments'>";
            try{
                var comments = JSON.parse(result);
                for (var j in comments) {
                    if(j!='status'){
//                        $commentlist[] = array('USERNAME','DATE_CREATED','CONTENT');
                        var comment = comments[j];
                        commentstring += "<p class='comment_cont'>" + comment['CONTENT']; + "</p><br/>";
                        commentstring += "<span class='comment_uname'> - " + comment['USERNAME'] + "</span>";
                        commentstring += "<span class='comment_dateposted'> [" + comment['DATE_CREATED'] + "]</span>";
                    }                    
                }
                commentstring +="</div>";
                if(comments['status']['LOGGED_IN']){
                    commentstring += "<textarea class='text-holder newcomment' placeholder='Write a comment..' ></textarea><div id='charleft'></div>";
                }else{
                    commentstring += "<p>No you can't post a comment. <a href='user/'>Login</a> first</p>";
                }
//                commentstring += comments['status']['LOGGED_IN'];
            }catch(err){
                commentstring +="</div>";
                if(comments['status']['LOGGED_IN']){
                    commentstring += "<textarea class='text-holder newcomment' placeholder='Write a comment..' ></textarea><div id='charleft'></div>";
                }else{
                    commentstring += "<p>No you can't post a comment. <a href='user/'>Login</a> first</p>";
                }
//                commentstring += comments['status']['LOGGED_IN'];
            }
            $('#' + sug_id).html(commentstring);
            $('#' + sug_id).slideDown();
            $(".newcomment").limiter(100, $('#charleft'));
        }
    });
    
}

$(function() {
    function split(val) {
        return val.split(/,\s*/);
//        return val;
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $(".search")
            .bind("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).data("ui-autocomplete").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
        source: function(request, response) {
            $.getJSON("search/", {
                term: extractLast(request.term)
            }, response);
        },
        search: function() {
            if (this.value.length < 2) {
                return false;
            }
        },
        focus: function() {
            return false;
        }
    });

    $("#FindRoute").click(function() {
        var from = $("#from").val();
        var to = $("#to").val();

        ajaxComments("findaway/suggestions/",from,to,0,4);
//        ajaxPaging(from,to);
    });
     $(function() {
        $( "#dialog-message" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
    $(document).on('keypress','.newcomment',function(e) {
		if(e.which == 13) {
			var msg = $(this).val();
                        var sug_id = $('.activecomment').attr('id');
			$.ajax({
				url: 'post/comment/',
				type: 'POST',
				data: {sug_id: sug_id, msg: msg},
				success: function(data) {
					$('.newcomment').val('');
					$('.newcomment').css('height','14px');
                                        var commentstring = "";
                                        try{
                                            var comments = JSON.parse(data);
                                            for (var j in comments) {
                                                alert(j);
                //                                $commentlist[] = array(
                //                                        'USERNAME'    
                //                                        'DATE_CREATED'
                //                                        'CONTENT'     
                //                                    );
                                                var comment = comments[j];
                                                commentstring += "<p class='comment_cont'>" + comment['CONTENT']; + "</p><br/>";
                                                commentstring += "<span class='comment_uname'> - " + comment['USERNAME'] + "</span>";
                                                commentstring += "<span class='comment_dateposted'> [" + comment['DATE_CREATED'] + "]</span>";
                                            }
                                        }catch(err){
                                            
                                        }
                                        alert(commentstring);
					$('#existingcomments').append(commentstring);
//					$('.time').timeago();
				}
			});
		}
	});
});

(function($) {
    $.fn.extend( {
        limiter: function(limit, elem) {
            $(this).on("keyup focus", function() {
                setCount(this, elem);
            });
            function setCount(src, elem) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html( limit - chars );
            }
            setCount($(this)[0], elem);
        }
    });
})(jQuery);