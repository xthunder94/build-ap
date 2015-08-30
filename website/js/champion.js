function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

$(document).ready(function() {
    var champname = getParameterByName('do');
    console.log(champname);
    $.getJSON("champions.json", function(data) {
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
            }
        }
    });
    //$.getJSON("php/getchampion.php?do=" + encodeURI(champname), function(data) {
    $.getJSON("ahri.json", function(data) {
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
});