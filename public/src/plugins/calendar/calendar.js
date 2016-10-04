(function ( $ ) {

    $.fn.calendar = function( options ) {
        var settings = $.extend({
                abbr: true,
                containerPadding: '1px',
                weekdaysSize: '0.85em',
            }, options );

        var calendar;
        var current_month;
        var current_year;
        var $calendar_container = $(this);
        $calendar_container.css('padding', settings.containerPadding);

        generateCalendar($calendar_container);

        function updateCalendar($calendar_container, year, month) {
            $calendar_container.find('.calendar').fadeOut(400, function(){
                $calendar_container.find('.calendar').remove();
                generateCalendar($calendar_container, year, month);
            });
        }

        function generateCalendar($calendar_container, year = null, month = null) {
            var api_url = 'api/calendar' + ((!year || !month) ? '' : '/' + year + '/' + month);
            $.getJSON(api_url, function(response) {

                calendar = response.calendar;
                current_month = (calendar.next.month == 1) ? 12 : calendar.next.month - 1;
                current_year = calendar.year;
                today = calendar.today;

                $calendar_el = createBaseCalendar();

                $calendar_el.find('.title').append('<span class="month-title" data-value="'+ current_month +'">' + calendar.month + '</span>' + '<br>' 
                    + '<span class="year-title">' + calendar.year + '</span>');

                for (var i = calendar.offset; i > 0; i--) {
                    $calendar_el.find('.days').append("<li></li>");
                }

                var month_days = calendar.days.length;

                for (var i = 0; i < month_days; i++) {
                    var day = calendar.days[i];
                    day_class = '';
                    if (day.is_holiday) {
                        day_class += 'red ';
                    }
                    if (day.day == today.day && current_month == today.month && current_year == today.year) {
                        day_class += 'today ';
                    }
                    var day_html = '<li class="' + day_class + '">' + day.day + '</li>';
                    $calendar_el.find('.days').append(day_html);
                }

                $calendar_el.find('.prev').click(function() {
                    var year = current_month == 1 ? current_year - 1 : current_year;
                    var month = current_month == 1 ? 12 : current_month - 1;
                    updateCalendar($calendar_container, year, month);
                });

                $calendar_el.find('.next').click(function() {
                    var year = current_month == 12 ? current_year + 1 : current_year;
                    var month = current_month == 12 ? 1 : current_month + 1;
                    updateCalendar($calendar_container, year, month);
                });

                $calendar_el.persiaNumber();
                $calendar_el.appendTo($calendar_container).fadeIn();

            });
        }

        function createBaseCalendar() {
            var weekdays = '';
            var weekdays_size = 'style="font-size:'  + settings.weekdaysSize + '"';
            if (settings.abbr) {
                weekdays = '<ul class="weekdays abbr"' + weekdays_size + '>' +
                                        '<li><abbr title ="شنبه">ش</abbr></li>' +
                                        '<li><abbr title ="یک‌شنبه">ی</abbr></li>' +
                                        '<li><abbr title ="دوشنبه">د</abbr></li>' +
                                        '<li><abbr title ="سه‌شنبه">س</abbr></li>' +
                                        '<li><abbr title ="چهارشنبه">چ</abbr></li>' +
                                        '<li><abbr title ="پنج‌شنبه">پ</abbr></li>' +
                                        '<li><abbr title ="جمعه">ج</abbr></li>' +
                                    '</ul>';
            }
            else {
                weekdays = '<ul class="weekdays full"' + weekdays_size + '>' +
                                        '<li>شنبه</li>' +
                                        '<li>یکشنبه</li>' +
                                        '<li>دوشنبه</li>' +
                                        '<li>سه شنبه</li>' +
                                        '<li>چهارشنبه</li>' +
                                        '<li>پنجشنبه</li>' +
                                        '<li>جمعه</li>'+
                                    '</ul>';
            }

            var calendar_html = '<div class="calendar">' +
                                                  '<div class="month">'  +
                                                      '<div class="next">&#10095;</div>' +
                                                      '<div class="prev">&#10094;</div>' +
                                                      '<div class="title"></div>' +
                                                  '</div>' +
                                                    weekdays +
                                                  '<ul class="days"></ul>' +
                                            '</div>';
            return $(calendar_html);
        }
    };

}( jQuery ));