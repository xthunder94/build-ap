$(document).ready(function() {
    $.getJSON("php/getchampions.php", function(data) {
        var arrayLength = data.length;
        data.sort(function(a, b) {return a.name.localeCompare(b.name);});
        $('#selectchampion').html("");
        for (var i = 0; i < arrayLength; i++) {
            if(data[i].name != null) {
                $('#selectchampion').append('<a href="champion.html?do='+data[i].name+'"><img src="'+data[i].icon+'"></img></a>');
            }
        }
    });
});