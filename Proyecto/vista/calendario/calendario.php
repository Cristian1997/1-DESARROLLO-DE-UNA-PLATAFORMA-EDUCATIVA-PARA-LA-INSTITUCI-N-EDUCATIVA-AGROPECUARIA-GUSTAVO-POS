<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
    <link rel="stylesheet" href="/calendario/styles.css">
</head>
<body>
    <div class="container_calendar">
        <div class="header_calendar">
            <h1 id="text_day">00</h1>
            <h5 id="text_month">Null</h5>
        </div>
        <div class="body_calendar">
            <div class="container_details">
                <div class="detail_1">
                    <div class="detail">
                        <div class="circle">
                            <div class="column"></div>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="circle">
                            <div class="column"></div>
                        </div>
                    </div>
                </div>
                <div class="detail_2">
                    <div class="detail">
                        <div class="circle">
                            <div class="column"></div>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="circle">
                            <div class="column"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container_change_month">
                <button id="last_month">&lt;</button>
                <div>
                    <span id="text_month_02">Null</span>
                    <span id="text_year">0000</span>
                </div>
                <button id="next_month">&gt;</button>
            </div>
            <div class="container_weedays">
                <span class="week_days_item">DOM</span>
                <span class="week_days_item">LUN</span>
                <span class="week_days_item">MAR</span>
                <span class="week_days_item">MÍE</span>
                <span class="week_days_item">JUE</span>
                <span class="week_days_item">VIE</span>
                <span class="week_days_item">SÁB</span>
            </div>
            <div class="container_days">
                <span class="week_days_item item_day"></span>
                
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/calendario/calendario.js"></script>
</body>
</html>