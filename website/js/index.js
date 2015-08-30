$(document).ready(function() {
    $.getJSON("test.json", function(data) {
        var arrayLength = data.length;
        data.sort(function(a, b) {return b.new_usage-a.old_usage});
        $('#overallitemusage').html("");
        for (var i = 0; i < arrayLength; i++) {
            if(data[i].name != null) {
                $('#overallitemusage').append('<tr><td><img class="icon" src="' + data[i].image + '"></img> ' + data[i].name + '</td><td>' + data[i].old_usage + '%</td><td>' + data[i].new_usage + '%</td><td>' + data[i].old_winrate + '%</td><td>' + data[i].new_winrate + '%</td></tr>');
            }
        }
    });
});