$(document).ready(function() {
    $.getJSON("items.json", function(data) {
        var arrayLength = data.length;
        data.sort(function(a, b) {return b.new_usage-a.old_usage});
        $('#overallitemusage').html("");
        for (var i = 0; i < arrayLength; i++) {
            if(data[i].name != null) {
                $('#overallitemusage').append('<tr><td><img class="icon" src="' + data[i].image + '"></img> ' + data[i].name + '</td><td>' + data[i].old_usage + '%</td><td>' + data[i].new_usage + '%</td><td>' + data[i].old_winrate + '%</td><td>' + data[i].new_winrate + '%</td></tr>');
            }
        }
    });
    $.getJSON("champions.json", function(data) {
        var arrayLength = data.length;
        data.sort(function(a, b) {return b.new_usage-a.old_usage});
        $('#overallchampionusage').html("");
        for (var i = 0; i < arrayLength; i++) {
            if(data[i].name != null) {
                $('#overallchampionusage').append('<tr><td><img class="icon" src="' + data[i].image + '"></img> ' + data[i].name + '</td><td>' + data[i].old_winrate + '%</td><td>' + data[i].new_winrate + '%</td><td>' + data[i].old_pickrate + '%</td><td>' + data[i].new_pickrate + '%</td><td>' + data[i].old_damage + '</td><td>' + data[i].new_damage + '</td></tr>');
            }
        }
    });
});