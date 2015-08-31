var items_collection;

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function populateItem(arr_collection) {
    $('#overallitemusage').html("");
    var arrayLength = arr_collection.length;
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

function i_name() {
    items_collection.sort(function(a, b) {return a.name.localeCompare(b.name)});
    populateItem(items_collection);
}

function i_old_usage() {
    items_collection.sort(function(a, b) {return b.old_usage-a.old_usage});
    populateItem(items_collection);
}

function i_new_usage() {
    items_collection.sort(function(a, b) {return b.new_usage-a.new_usage});
    populateItem(items_collection);
}

function i_old_winrate() {
    items_collection.sort(function(a, b) {return b.old_winrate-a.old_winrate});
    populateItem(items_collection);
}

function i_new_winrate() {
    items_collection.sort(function(a, b) {return b.new_winrate-a.new_winrate});
    populateItem(items_collection);
}

$(document).ready(function() {
    var champname = getParameterByName('do');
    console.log(champname);
    $.getJSON("php/getchampions.php", function(data) {
        var arrayLength = data.length;
        for (var i = 0; i < arrayLength; i++) {
            if(data[i].name.toUpperCase() == champname.toUpperCase()) {
                var old_winrate = data[i].old_winrate > data[i].new_winrate ? 'text-success' : 'text-danger';
                var new_winrate = data[i].new_winrate > data[i].old_winrate ? 'text-success' : 'text-danger';
                var old_pickrate = data[i].old_pickrate > data[i].new_pickrate ? 'text-success' : 'text-danger';
                var new_pickrate = data[i].new_pickrate > data[i].old_pickrate ? 'text-success' : 'text-danger';
                var old_damage = data[i].old_damage > data[i].new_damage ? 'text-success' : 'text-danger';
                var new_damage = data[i].new_damage > data[i].old_damage ? 'text-success' : 'text-danger';
                $('#name').html(data[i].name);
                $('#splash').attr('src', data[i].image);
                $('#winrate').html('<span class=' + old_winrate + '>' + data[i].old_winrate + '%</span> / <span class=' + new_winrate + '>' + data[i].new_winrate + '%</span>');
                $('#pickrate').html('<span class=' + old_pickrate + '>' + data[i].old_pickrate + '%</span> / <span class=' + new_pickrate + '>' + data[i].new_pickrate + '%</span>');
                $('#damage').html('<span class=' + old_damage + '>' + data[i].old_damage + '</span> / <span class=' + new_damage + '>' + data[i].new_damage + '</span>');

                $('#suggestedbuild').html('');
                var itemcount = data[i].old_build.length;
                for (var j = 0; j < itemcount; j++) {
                    $('#suggestedbuild').append('<img src="' + data[i].old_build[j] + '"></img>');
                }
                $('#suggestedbuild').append('<img class="arrow" src="img/arrow.png"></img>');
                var itemcount = data[i].new_build.length;
                for (var j = 0; j < itemcount; j++) {
                    $('#suggestedbuild').append('<img src="' + data[i].new_build[j] + '"></img>');
                }
            }
        }
    });
    $.getJSON("php/getchampion.php?do=" + encodeURI(champname), function(data) {
        items_collection = data;
        data.sort(function(a, b) {return b.new_usage-a.new_usage});
        populateItem(data);
    });
});