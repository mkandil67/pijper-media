
<html>
<head>

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>

        $(document).ready(function() {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();


            /*  className colors

            className: default(transparent), important(red), chill(pink), success(green), info(blue)

            */


            /* initialize the external events
            -----------------------------------------------------------------*/

            $('#external-events div.external-event').each(function() {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });

            });


            /* initialize the calendar
            -----------------------------------------------------------------*/

            var calendar =  $('#calendar').fullCalendar({
                header: {
                    left: 'title',
                    center: 'agendaDay,agendaWeek,month',
                    right: 'prev,next today'
                },
                editable: true,
                firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
                selectable: true,
                defaultView: 'month',

                axisFormat: 'h:mm',
                columnFormat: {
                    month: 'ddd',    // Mon
                    week: 'ddd d', // Mon 7
                    day: 'dddd M/d',  // Monday 9/7
                    agendaDay: 'dddd d'
                },
                titleFormat: {
                    month: 'MMMM yyyy', // September 2009
                    week: "MMMM yyyy", // September 2009
                    day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
                },
                allDaySlot: false,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                    if (title) {
                        calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                            true // make the event "stick"
                        );
                    }
                    calendar.fullCalendar('unselect');
                },
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }

                },

                events: [
                    {
                        title: 'Emma Heesters',
                        start: new Date(y, 0, 8, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Roxeanne Hazes',
                        start: new Date(y, 0, 18, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'André Hazes',
                        start: new Date(y, 0, 21, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Doutzen Kroes',
                        start: new Date(y, 0, 23, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Maan',
                        start: new Date(y, 1, 10, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Chantal Janzen',
                        start: new Date(y, 1, 15, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Bizzey',
                        start: new Date(y, 1, 16, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Katja Schuurman',
                        start: new Date(y, 1, 19, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'NikkieTutorials',
                        start: new Date(y, 2, 2, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Dave Roelvink',
                        start: new Date(y, 2, 13, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Robin Martens',
                        start: new Date(y, 2, 16, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Yolanthe Cabau',
                        start: new Date(y, 2, 19, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Monica Geuze',
                        start: new Date(y, 2, 27, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Anouk',
                        start: new Date(y, 3, 8, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Monique Smit',
                        start: new Date(y, 3, 9, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Rico Verhoeven',
                        start: new Date(y, 3, 10, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Sylvie Meis',
                        start: new Date(y, 3, 13, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Dionne Stax',
                        start: new Date(y, 3, 22, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Rens Kroes',
                        start: new Date(y, 3, 30, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Nikkie Plessen',
                        start: new Date(y, 4, 8, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Gaby Blaaser',
                        start: new Date(y, 5, 7, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Eloise van Oranje',
                        start: new Date(y, 5, 8, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Fajah Lourens',
                        start: new Date(y, 6, 3, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Bibi Breijman',
                        start: new Date(y, 6, 6, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Eva Jinek',
                        start: new Date(y, 6, 13, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Kim Kötter',
                        start: new Date(y, 6, 27, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Jim Bakkum',
                        start: new Date(y, 7, 10, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Kim Feenstra',
                        start: new Date(y, 7, 23, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Martien Meiland',
                        start: new Date(y, 7, 26, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Fred van Leer',
                        start: new Date(y, 8, 18, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Elise Schaap',
                        start: new Date(y, 8, 21, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Linda Hakeboom',
                        start: new Date(y, 8, 24, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Nicolette Kluijver',
                        start: new Date(y, 8, 29, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Snelle',
                        start: new Date(y, 9, 3, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Mascha Feoktistova',
                        start: new Date(y, 9, 11, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Christine Quinn',
                        start: new Date(y, 9, 14, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Kim Kardashian',
                        start: new Date(y, 9, 21, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Tony Junior',
                        start: new Date(y, 9, 21, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Rose Bertram',
                        start: new Date(y, 9, 26, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Emma Wortelboer',
                        start: new Date(y, 9, 26, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Caitlynn Jenner',
                        start: new Date(y, 9, 28, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Bridget Maasland',
                        start: new Date(y, 10, 9, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Halina Reijn',
                        start: new Date(y, 10, 10, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Daphne Deckers',
                        start: new Date(y, 10, 10, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Davina Michelle',
                        start: new Date(y, 10, 12, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Romy Monteiro',
                        start: new Date(y, 10, 13, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Holly Mae Brood',
                        start: new Date(y, 10, 25, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Maxime Meiland',
                        start: new Date(y, 10, 25, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Amalia',
                        start: new Date(y, 11, 7, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Famke Louise',
                        start: new Date(y, 11, 9, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Anna Nooshin',
                        start: new Date(y, 11, 18, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Viktoria Koblenko',
                        start: new Date(y, 11, 19, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Jennifer Hoffman',
                        start: new Date(y, 11, 23, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                    {
                        title: 'Monique Westenberg',
                        start: new Date(y, 11, 26, 0, 0),
                        allDay: true,
                        className: 'important'
                    },
                ],
            });


        });

    </script>
    <style>

        body {
            margin-bottom: 40px;
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
            background:url(http://www.digiphotohub.com/wp-content/uploads/2015/09/bigstock-Abstract-Blurred-Background-Of-92820527.jpg);
        }

        #wrap {
            width: 1100px;
            margin: 0 auto;
        }

        #external-events {
            float: left;
            width: 150px;
            padding: 0 10px;
            text-align: left;
        }

        #external-events h4 {
            font-size: 16px;
            margin-top: 0;
            padding-top: 1em;
        }

        .external-event { /* try to mimick the look of a real event */
            margin: 10px 0;
            padding: 2px 4px;
            background: #3366CC;
            color: #fff;
            font-size: .85em;
            cursor: pointer;
        }

        #external-events p {
            margin: 1.5em 0;
            font-size: 11px;
            color: #666;
        }

        #external-events p input {
            margin: 0;
            vertical-align: middle;
        }

        #calendar {
            /* 		float: right; */
            margin: 0 auto;
            width: 900px;
            background-color: #FFFFFF;
            border-radius: 6px;
            box-shadow: 0 1px 2px #C3C3C3;
            -webkit-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
            -moz-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
            box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
        }

    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/calendar.css')}}">
</head>
    <body>
        <div class="container">
            <style>

                .nav-link {
                    padding: 1em 0.5em;
                    color: #0b057a;
                }
                .nav-link:hover {
                    border-bottom: 2px solid blue;
                }
                .border-b:hover{
                    border-bottom: 2px solid blue;
                }
                .strong {
                    font-weight: bold;
                }
                a .readMore {
                    display: none;
                }

                a .readLess {
                    display: inline;
                }

                a.collapsed .readMore {
                    display: inline;
                }

                a.collapsed .readLess {
                    display: none;
                }

            </style>
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">
            <div id="app">
                <div class="bg-img">
                    <nav id="navigation" class="navbar navbar-inner navbar-expand-sm shadow-sm">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span><img src="https://img.icons8.com/fluent-systems-regular/24/000000/menu--v3.png"/></span>
                            </button>
                            <a class="d-sm-none" href="/" style="margin-right: 8px">
                                <img src="/pics/pijper-logo.png" width="50" height="50">
                            </a>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <!-- Left Side Of Navbar -->
                                <a class="d-none d-md-block" href="/" style="margin-right: 8px">
                                    <img src="/pics/pijper-logo.png" width="50" height="50">
                                </a>
                                <h1 style="font-family: Open Sans" class="d-none d-md-block font-weight-lighter">|</h1>
                                <h6 class="d-none d-md-block" style="padding-top: 5px; margin-left: 5px;">PM Social Wall</h6>
                                <!-- Right Side Of Navbar -->
                                <ul class="navbar-nav ml-auto">
                                    <!-- Authentication Links -->
                                    @guest
                                        @if (Route::has('login'))
                                            <li class="nav-item">
                                                <a class="btn btn-primary" href="{{ route('login') }}" role="button">{{ __('Login') }}</a>
                                            </li>
                                        @endif

                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="btn btn-light ml-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif


                                    @else

                                        <li class="{{ (request()->is('home')) ? 'strong' : ''}}">
                                            <a class="nav-link nav-link-me" href="{{ route('home') }}">Home</a>

                                        @if (Route::is('home'))
                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    Categories
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" style="width:250%; " aria-labelledby="navbarDropdown">
                                                    <form class="d-flex justify-content-center" action="/categories" method="POST">
                                                        @csrf
                                                        <div class="">
                                                            <div class="form-group row"></div>

                                                            <input type="checkbox" name="categories[]" value="News" {{ ($categories['News']) ? 'checked' : '' }} > News<br/>
                                                            <input type="checkbox" name="categories[]" value="Showbizz/Entertainment" {{ ($categories['Showbizz/Entertainment']) ? 'checked' : '' }} > Showbizz/Entertainment<br/>
                                                            <input type="checkbox" name="categories[]"  value="Royals" {{ ($categories['Royals']) ? 'checked' : '' }} > Royals<br/>
                                                            <input type="checkbox" name="categories[]"  value="Food/Recipes" {{ ($categories['Food/Recipes']) ? 'checked' : '' }} > Food/Recipes<br/>
                                                            <input type="checkbox" name="categories[]"  value="Lifehacks" {{ ($categories['Lifehacks']) ? 'checked' : '' }} > Lifehacks<br/>
                                                            <input type="checkbox" name="categories[]"  value="Fashion" {{ ($categories['Fashion']) ? 'checked' : '' }} > Fashion<br/>
                                                            <input type="checkbox" name="categories[]"  value="Beauty" {{ ($categories['Beauty']) ? 'checked' : '' }} > Beauty<br/>
                                                            <input type="checkbox" name="categories[]"  value="Health" {{ ($categories['Health']) ? 'checked' : '' }} > Health<br/>
                                                            <input type="checkbox" name="categories[]"  value="Family" {{ ($categories['Family']) ? 'checked' : '' }} > Family<br/>
                                                            <input type="checkbox" name="categories[]"  value="House and garden" {{ ($categories['House and garden']) ? 'checked' : '' }} > House and Garden<br/>
                                                            <input type="checkbox" name="categories[]"  value="Cleaning" {{ ($categories['Cleaning']) ? 'checked' : '' }} > Cleaning<br/>
                                                            <input type="checkbox" name="categories[]"  value=" Lifestyle" {{ ($categories['Lifestyle']) ? 'checked' : '' }} > Lifestyle<br/>
                                                            <input type="checkbox" name="categories[]" value="Cars" {{ ($categories['Cars']) ? 'checked' : '' }} > Cars<br/>
                                                            <input type="checkbox" name="categories[]"  value="Crime" {{ ($categories['Crime']) ? 'checked' : '' }} > Crime<br/>

                                                            <div class="form-group row mb-0">
                                                                <div class="col-md-6 offset-3 pt-3">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        {{ __('Submit') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </li>
                                        @endif


                                        <li class="{{ (request()->is('#')) ? 'strong' : ''}}">
                                            <a class="nav-link nav-link-me" href="#">Trending</a>
                                        </li>
                                        <li class="{{ (request()->is('activity')) ? 'strong' : ''}}">
                                            <a class="nav-link nav-link-me" href="{{ route('activity') }}">Activity</a>
                                        </li>
                                        <li class="{{ (request()->is('calendar')) ? 'strong' : ''}}">
                                            <a class="nav-link nav-link-me" href="{{ route('calendar') }}">Calendar</a>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                {{ Auth::user()->name }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="#">Notifications</a>
                                                <a class="dropdown-item" href="{{route('my_activity')}}">My Activity</a>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>

                <main class="">
                    @yield('content')
                </main>
            </div>
        </div>
        <div class="container" >
            <p>
            </p>
        </div>
        <div id='calendar'></div>


        <div style='clear:both'></div>

    <script src="{{ asset('js/calendar.js') }}" type="text/javascript"></script>
    </body>

</html>


