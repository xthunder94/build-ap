var items_collection;
var champions_collection;

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

function populateChampion(arr_collection) {
    $('#overallchampionusage').html("");
    var arrayLength = arr_collection.length;
    for (var i = 0; i < arrayLength; i++) {
        if(arr_collection[i].name != null) {
            var old_winrate = arr_collection[i].old_winrate > arr_collection[i].new_winrate ? 'text-success' : 'text-danger';
            var new_winrate = arr_collection[i].new_winrate > arr_collection[i].old_winrate ? 'text-success' : 'text-danger';
            var old_pickrate = arr_collection[i].old_pickrate > arr_collection[i].new_pickrate ? 'text-success' : 'text-danger';
            var new_pickrate = arr_collection[i].new_pickrate > arr_collection[i].old_pickrate ? 'text-success' : 'text-danger';
            var old_damage = arr_collection[i].old_damage > arr_collection[i].new_damage ? 'text-success' : 'text-danger';
            var new_damage = arr_collection[i].new_damage > arr_collection[i].old_damage ? 'text-success' : 'text-danger';
            $('#overallchampionusage').append('<tr><td><img class="icon" src="' + arr_collection[i].icon + '"></img> ' + arr_collection[i].name + '</td><td class='+old_winrate+'>' + arr_collection[i].old_winrate + '%</td><td class='+new_winrate+'>' + arr_collection[i].new_winrate + '%</td><td class='+old_pickrate+'>' + arr_collection[i].old_pickrate + '%</td><td class='+new_pickrate+'>' + arr_collection[i].new_pickrate + '%</td><td class='+old_damage+'>' + arr_collection[i].old_damage + '</td><td class='+new_damage+'>' + arr_collection[i].new_damage + '</td></tr>');
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

function c_name() {
    champions_collection.sort(function(a, b) {return a.name.localeCompare(b.name)});
    populateChampion(champions_collection);
}

function c_old_winrate() {
    champions_collection.sort(function(a, b) {return b.old_winrate-a.old_winrate});
    populateChampion(champions_collection);
}

function c_new_winrate() {
    champions_collection.sort(function(a, b) {return b.new_winrate-a.new_winrate});
    populateChampion(champions_collection);
}

function c_old_pickrate() {
    champions_collection.sort(function(a, b) {return b.old_pickrate-a.old_pickrate});
    populateChampion(champions_collection);
}

function c_new_pickrate() {
    champions_collection.sort(function(a, b) {return b.new_pickrate-a.new_pickrate});
    populateChampion(champions_collection);
}

function c_old_damage() {
    champions_collection.sort(function(a, b) {return b.old_damage-a.old_damage});
    populateChampion(champions_collection);
}

function c_new_damage() {
    champions_collection.sort(function(a, b) {return b.new_damage-a.new_damage});
    populateChampion(champions_collection);
}

$(document).ready(function() {
    $.getJSON("php/getitems.php", function(data) {
        items_collection = data;
        data.sort(function(a, b) {return b.new_usage-a.new_usage});
        populateItem(data);
    });
    $.getJSON("php/getchampions.php", function(data) {
        champions_collection = data;
        data.sort(function(a, b) {return b.new_pickrate-a.new_pickrate});
        populateChampion(data);
    });
});