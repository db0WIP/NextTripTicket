// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: Usage of the web service API for database handling            //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

// ************************************************************************** //
// Error Handling
// ************************************************************************** //

function        error_shower(type, message, content) {
    $("#content").html('<h1>Error ' + type + '</h1>'
		              + '<h3>' + message + '</h3>'
		       + '<p>' + content + '</p>');
    $("content").show();
}

function        default_callback_error(event, request) {
    error_shower('404', 'Not Found', 'The page you requested cannot be load. Check if:<ul><li>You\'re logged in the Epitech Intranet ('
		  + '<a href="' + intra_url + '">' + intra_url
		 +'</a>)</li><li>The URL is correct</li><li>The information you asked for are valid</li></ul>');
}

// ************************************************************************** //
// Generic function to call the web service API
// ************************************************************************** //

function        wsquery(url, type, params, callback, callback_error) {
    // default values
    url = typeof url !== 'undefined' ? url : '';
    type = typeof type !== 'undefined' ? type : 'GET';
    params = typeof params !== 'undefined' ? params : [];
    callback = typeof callback !== 'undefined' ? callback : function() {};
    callback_error = typeof callback_error !== 'undefined' ? callback_error : default_callback_error;

    var str_params = '';
    for (var idx in params)
	str_params += '&' + idx + '=' + params[idx];

    $.jsonp({
            type: type,
		url: api_url + url + '?callback=?' + str_params,
		data: { format: 'jsonp'},
		dataType: 'jsonp',
		error: callback_error,
		success: callback,
		done: (function() { $("content").show(); }),
		});
}

// ************************************************************************** //
// Cities
// ************************************************************************** //

function	get_cities(params, callback, callback_error) {
    wsquery('cities', 'GET', params, callback, callback_error);
}

