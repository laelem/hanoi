$(document).ready(function() { 
    reset();
});

$('#controls .next').click(function(){
    var ind = parseInt($('#controls').attr('data-move-index'));
    var nbBlock = $('#nbBlock').val();

    $.ajax({
        method: "GET",
        url: "move.php",
        data: {ind: ind, nbBlock: nbBlock}
    }).done(function(move) {
        move = move.split('|');
        hanoiMove(move[0], move[1]);
        $('#controls').attr('data-move-index', ind+1);
    }).fail(function(e) {
        alert(e);
    });

});

$('#controls .reset').click(function(){
    reset();
});

$('#nbBlock').on('change', function(){
    reset();
});

var reset = function() {
    var nb = $('#nbBlock').val();

    $('.block').remove();

    for (var i = 0, j = nb; i < nb; i++, j--) {
        $('<div/>', {
            'class': 'block',
            'id': 'block'+(i+1),
            'data-position': i,
            'data-index': j,
            'text': j
        }).appendTo('#tower1 .contain');
    };

    $('#controls .next').prop('disabled', false);

    $('#controls').attr('data-move-index', 0);
}

var hanoiMove = function(index, end) {

    var nbChild = $('#tower'+end+' .contain').find('.block').length;
    
    $('.block[data-index="'+index+'"]').appendTo($('#tower'+end+' .contain'));
    
    $('.block[data-index="'+index+'"]').attr('data-position', nbChild);

    if ($('#nbBlock').val() == $('#tower3 .block').length) {
        $('#controls .next').prop('disabled', true);
    }
}