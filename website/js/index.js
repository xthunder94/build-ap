$(document).ready(function() {
    $.getJSON("php/getitems.php", function(data) {
        var arrayLength = data.length;
        data.sort(function(a, b) {return b.new_usage-a.new_usage});
        $('#overallitemusage').html("");
        for (var i = 0; i < arrayLength; i++) {
            if(data[i].name != null) {
                var old_usage = data[i].old_usage > data[i].new_usage ? 'text-success' : 'text-danger';
                var new_usage = data[i].new_usage > data[i].old_usage ? 'text-success' : 'text-danger';
                var old_winrate = data[i].old_winrate > data[i].new_winrate ? 'text-success' : 'text-danger';
                var new_winrate = data[i].new_winrate > data[i].old_winrate ? 'text-success' : 'text-danger';
                $('#overallitemusage').append('<tr><td><img class="icon" src="' + data[i].image + '"></img> ' + data[i].name + '</td><td class='+old_usage+'>' + data[i].old_usage + '%</td><td class='+new_usage+'>' + data[i].new_usage + '%</td><td class='+old_winrate+'>' + data[i].old_winrate + '%</td><td class='+new_winrate+'>' + data[i].new_winrate + '%</td></tr>');
            }
        }
    });
    $.getJSON("php/getchampions.php", function(data) {
        var arrayLength = data.length;
        data.sort(function(a, b) {return b.new_pickrate-a.new_pickrate});
        $('#overallchampionusage').html("");
        for (var i = 0; i < arrayLength; i++) {
            if(data[i].name != null) {
                var old_winrate = data[i].old_winrate > data[i].new_winrate ? 'text-success' : 'text-danger';
                var new_winrate = data[i].new_winrate > data[i].old_winrate ? 'text-success' : 'text-danger';
                var old_pickrate = data[i].old_pickrate > data[i].new_pickrate ? 'text-success' : 'text-danger';
                var new_pickrate = data[i].new_pickrate > data[i].old_pickrate ? 'text-success' : 'text-danger';
                var old_damage = data[i].old_damage > data[i].new_damage ? 'text-success' : 'text-danger';
                var new_damage = data[i].new_damage > data[i].old_damage ? 'text-success' : 'text-danger';
                $('#overallchampionusage').append('<tr><td><img class="icon" src="' + data[i].icon + '"></img> ' + data[i].name + '</td><td class='+old_winrate+'>' + data[i].old_winrate + '%</td><td class='+new_winrate+'>' + data[i].new_winrate + '%</td><td class='+old_pickrate+'>' + data[i].old_pickrate + '%</td><td class='+new_pickrate+'>' + data[i].new_pickrate + '%</td><td class='+old_damage+'>' + data[i].old_damage + '</td><td class='+new_damage+'>' + data[i].new_damage + '</td></tr>');
            }
        }
    });
});