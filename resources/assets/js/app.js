require('./bootstrap');

$(() => {
    $('*[name=start_time]').appendDtpicker({
        "futureOnly": true,
        "autodateOnStart": false,
        "minuteInterval": 30,
        "minTime": "08:00",
        "maxTime": "19:00"
    });
    $('*[name=finish_time]').appendDtpicker({
        "futureOnly": true,
        "autodateOnStart": false,
        "minuteInterval": 30,
        "minTime": "08:00",
        "maxTime": "19:00"
    });
});
