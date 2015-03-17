// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: Home page, display tickets                                    //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

var params = [];
params['tickets_quantity'] = 0;
params['lol'] = 'mdr';

get_cities(params);


$(document).ready(function(){
	$('#myslides').cycle({
		fit: 1
		    });
    });
