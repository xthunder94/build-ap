var items_collection;
var champions_collection;

function populateItem(arr_collection) {
    $('#overallitemusage').html("");
    for (var i = 0; i < arrayLength; i++) {
        if(arr_collection[i].name != null) {
            var old_usage = arr_collection[i].old_usage > arr_collection[i].new_usage ? 'text-success' : 'text-danger';
            var new_usage = arr_collection[i].new_usage > arr_collection[i].old_usage ? 'text-success' : 'text-danger';
            var old_winrate = arr_collection[i].old_winrate > arr_collection[i].new_winrate ? 'text-success' : 'text-danger';
            var new_winrate = arr_collection[i].new_winrate > arr_collection[i].old_winrate ? 'text-success' : 'text-danger';
            $('#overallitemusage').append('<tr><td><img class="icon" src="' + arr_collection[i].image + '"></img> ' + arr_collection[i].name + '</td><td class='+old_usage+'>' + arr_collection[i].old_usage + '%</td><td class='+new_usage+'>' + arr_collection[i].new_usage + '%</td><td class='+old_winrate+'>' + arr_collection[i].old_winrate + '%</td><td class='+new_winrate+'>' + arr_collection[i].new_winrate + '%</td></tr>');
        }
    }
}

$(document).ready(function() {
    $.getJSON("php/getitems.php", function(data) {
        items_collection = data;
        var arrayLength = data.length;
        data.sort(function(a, b) {return b.new_usage-a.new_usage});
        populateItem(data);
    });
    $.getJSON("php/getchampions.php", function(data) {
        champions_collection = data;
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