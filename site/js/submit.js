
$("#toCity").click(function() {
	event.preventDefault();
	$("#theCity").hide("slide", { direction: "left" }, 500,
			   function() {
			       $("#theTicket").show("slide", { direction: "right" }, 500);
			   });
    });

$("#toTicket").click(function() {
	event.preventDefault();
	$("#theTicket").hide("slide", { direction: "right" }, 500,
			   function() {
			       $("#theCity").show("slide", { direction: "left" }, 500);
			   });
    });

$("#more_link").click(function() {
	event.preventDefault();
	console.log("hello");
	$("#more").show("slide", { direction: "up" }, 500);
    });


if (!(navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15)) {
    $(".navigate").hide();
    $("#theTicket").show();
    $("#more_link").hide();
    $("#more").show();
}

