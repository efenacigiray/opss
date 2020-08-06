var productTour = [
    { element: '#input-name1', 'tooltip' : 'This is a tooltip for some element #id', 'text': 'test' },
    { element: '#input-model', 'tooltip' : 'The last link of some ul list', 'text': 'test2' },
]

$(document).ready(function() {
    $('#help').on('click', function(e) {

        options = {
            data : productTour,
            buttons: {
              next  : { text : 'Next', class : 'btn btn-sm'},
              prev  : { text : 'Previous', class: 'btn btn-sm' },
              start : { text : 'Start', class: 'btn btn-sm' },
              end   : { text : 'End', class: 'btn btn-sm' }
            },
            controlsCss: {
              background: 'rgba(0, 0, 0, 0.70)',
              color: '#fff'
            },
            tooltipCss: {
              background: 'rgba(0, 0, 0, 0.70)',
              color: '#fff'
            }
        }

        $.aSimpleTour(options);
    });

    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';
    //$.fn.editable.defaults.ajaxOptions = {type: "POST"};
    //make username editable
    $('.ocedit').editable({
        error: function(response, newValue) {
            if (response.status === 401) {
                location.reload();
                return 'Not Authorized';
            } else {
                return response.responseText;
            }
        }
    });

    $('.toggle-event-status').change(function() {
        var thisenable = $(this);
        if (thisenable.prop('checked') == true) {
            var switchvalue = 1;
        } else {
            var switchvalue = 0;
        }
        $.post(thisenable.attr('data-url'), {
            name: "status",
            pk: thisenable.attr('data-pk'),
            value: switchvalue
        }, function(data, textStatus, jqXHR) {
            if (jqXHR.status != 200) {
                alert('error update status:' + jqXHR.status + '|' + textStatus);
                thisenable.bootstrapToggle('toggle').bootstrapToggle('disable');
            }
        }).fail(function() {
            alert('Error. Not autorize');
            thisenable.bootstrapToggle('toggle').bootstrapToggle('disable');
        });
    });

    var percent = 100 / $('.menu > li').length;
    $('.menu > li').each(function(index, item) {
      $(item).css("width", percent + "%");
    })

    $(document).find('body').on('resize', () => {
        var percent = 100 / $('.menu > li').length;
        console.log(percent);
        $('.menu > li').each(function(index, item) {
          $(item).css("width", percent + "%");
        })
    });
});