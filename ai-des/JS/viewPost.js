
// Logic Slider
$('#prev').click(function(){
    var curr = $('.active');
    var prevImg = curr.prev();

    if(prevImg.length != 0){
        curr.removeClass('active');
        prevImg.addClass('active');
    }else{
        curr.removeClass('active');
        $('#last').addClass('active');
    }
})

$('#next').click(function(){
    var curr = $('.active');
    var nextImg = curr.next();

    if(nextImg.length != 0){
        curr.removeClass('active');
        nextImg.addClass('active');
    }else{
        curr.removeClass('active');
        $('#first').addClass('active');
    }
})