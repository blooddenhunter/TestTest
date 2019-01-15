import jQuery from "jquery";
import 'jquery-validation';
import 'bootstrap';
import 'bootstrap4-notify';
import 'jquery-ui/ui/widgets/datepicker';


window.$ = window.jQuery = jQuery;
window.jQuery = jQuery;

$( document ).ready(function() {
    $('form.form').on('submit', function (e) {
        e.preventDefault();

        var $this = $(this);
        var action = $this.attr('action');
        var method = $this.attr('method');

        $.ajax({
            type: method,
            url: action,
            data: new FormData($this.get(0)),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false
        }).done(function(data, textStatus, jqXHR) {
            notifyServerSucces();
            setTimeout(function() {
                window.location.href = '/';
            }, 1000);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            if(jqXHR.status === 422) {
                var validator = $this.validate();
                validator.showErrors(jQuery.parseJSON(jqXHR.responseText).errors);
            } else {
                notifyServerError();
            }
        });
    });


    $('.transaction-button').on('click', function (e) {
        e.preventDefault();

        var clientId = $(this).data('id');
        var id = $(this).attr('href');
        var collapse = $(id);
        var table = collapse.has('.client-transactions');

        if(table.length < 1){
            getTransaction(clientId, collapse);
        }

        collapse.parent().toggle(500);
        $(id).collapse('toggle');
    });

    function getTransaction(clientId, collapse) {
        $.ajax({
            type: 'GET',
            url: '/transaction/' + clientId,
        }).done(function(data, textStatus, jqXHR) {
            collapse.append(transactionTable(data));
        }).fail(function(jqXHR, textStatus, errorThrown) {
            notifyServerError();
        });
    }

    function notifyServerError() {
        $.notify({
            message: 'Sorry a server error occurred. Please try again'
        }, {
            type: 'danger',
            delay: 1000,
        });
    }

    function notifyServerSucces() {
        $.notify({
            message: 'Success'
        }, {
            type: 'success',
            delay: 1000,
        });
    }
    
    function transactionTable(data) {
        var body = '';
        var table = '';

        if(data.length < 1){
            return '<p class="client-transactions">No transaction</p>';
        }

        $.each(data, function(index, value) {
            body += (
                '<tr>\n' +
                '<th scope="row">' + value.id + '</th>\n' +
                '<td>' + value.type + '</td>\n' +
                '<td>' + value.sum + '</td>\n' +
                '<td class="' + value.status + '">' + value.status + '</td>\n' +
                '<td>' + value.created_at + '</td>\n' +
                '</td>\n' +
                '</tr>\n'
            );
        });

        table =
            '<table class="table client-transactions">\n' +
            '<thead>\n' +
            '<tr>\n' +
            '<th scope="col">#</th>\n' +
            '<th scope="col">Type</th>\n' +
            '<th scope="col">Sum ($)</th>\n' +
            '<th scope="col">Status</th>\n' +
            '<th scope="col">Created At</th>\n' +
            '</tr>\n' +
            '</thead>\n' +
            '<tbody>\n' +
            body +
            '</tbody>\n' +
            '</table>';


        return table;
    }

    $('.ban').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var clientId = $this.data('id');

        $.ajax({
            type: 'GET',
            url: '/client/locked/' + clientId,
        }).done(function(data, textStatus, jqXHR) {
            var status = $this.parents('tr').find('.status');

            notifyServerSucces();
            $this.parent().remove();
            status.find('span').remove();
            status.append(
                '<span class="' + data.status + '">' + data.status + '</span>'
            )
        }).fail(function(jqXHR, textStatus, errorThrown) {
            notifyServerError();
        });
    });


    $(function() {
        var dateFormat = "dd-mm-yy";

        var from = $( "#from" )
                .datepicker({
                    defaultDate: "+1w",
                    dateFormat: dateFormat,
                    changeMonth: true,
                    numberOfMonths: 3
                })
                .on( "change", function() {
                    to.datepicker( "option", "minDate", getDate( this ) );
                }),
            to = $( "#to" ).datepicker({
                defaultDate: "+1w",
                dateFormat: dateFormat,
                changeMonth: true,
                numberOfMonths: 3
            })
                .on( "change", function() {
                    from.datepicker( "option", "maxDate", getDate( this ) );
                });

        function getDate( element ) {
            var date;
            try {
                date = $.datepicker.parseDate( dateFormat, element.value );
            } catch( error ) {
                date = null;
            }

            return date;
        }
    });
});

