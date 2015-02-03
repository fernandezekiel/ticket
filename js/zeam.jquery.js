(function ($) {

    $.fn.ticket = function (options) {
        var opts = $.extend({}, $.fn.ticket.defaults, options);

        return this.each(function () {
            var $this = $(this);
            $this.submit(function (e) {
                e.preventDefault();
                var $ccdata = $('.ticketed');
                var postdata = {};

                $.each($ccdata, function (index, value) {
                    postdata[$(value).attr('data-ticket')] = $(value).val();
                });

                var zeam = new Zeam({
                	location_api_key : opts.location_api_key,
                	timestamp : opts.timestamp,
               		signature : opts.signature,
               		order_id : opts.order_id
                });

                zeam.requestTicket({
                	data : postdata,
                	responseHanlder : function (status, data) {
                        console.log(data);
                		if (status === 200 || status === 201) {
                			$.fn.ticket.addTicket($this, data.ticket);
                        $this.unbind('submit');
                        $ccdata.remove();
                        $this.submit();
                        } else if (status === 409) {
                            $.fn.ticket.addValidationErrors($this, data);
                        } else {
                            alert("An error has occured, please contact the system administrator");
                        }
                	}
                });
            });
        });
    };

    $.fn.ticket.setHeaders = function (xhr, opts) {
        xhr.setRequestHeader('Location-Api-Key', opts.location_api_id);
        xhr.setRequestHeader('Timestamp', opts.timestamp);
        xhr.setRequestHeader('Authorization', 'ZEAM ' + opts.signature);
        xhr.setRequestHeader('Order-Id', opts.order_id);
    }

    $.fn.ticket.handleError = function ($form, data) {
        switch (data.status) {
        case 409: // a user input validation error
            $.fn.ticket.addValidationErrors($form, data);
            break;
        default: // an error either for the remote server or the configuration
            alert("An error has occured, please contact the system administrator");
        }
    }

    $.fn.ticket.addValidationErrors = function ($form, errors) {
        $errorSummary = $form.find('.errorSummary');
        $errorSummary.html('');
        $form.children().removeClass('error');
        $.each(errors, function (index, value) {
            $.each(value, function (i, v) {
                $('*[data-ticket=' + index + ']').addClass('error');
                $error = $('<p>');
                $error.html(v);
                $error.appendTo($errorSummary);
            });
        });
    }
    //adds a ticket to the form
    $.fn.ticket.addTicket = function (form, ticket) {
        var $ticketField = $('<input>');
        $ticketField.attr({
            type: 'hidden',
            value: ticket,
            name: "ticket"
        });
        $ticketField.appendTo(form);
    }

    $.fn.ticket.defaults = {
        url: "https://zeamster.com/api/v1/cardTickets",

    };

}(jQuery));