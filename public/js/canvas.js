var canvas_enable = false;
var main_flag = false;
    /*
    * Scale
    */
//$('#canvas-scale').on('mousedown', function(e) {
function canvasScale(e,elem) {
    var top = Math.round(elem.position().top /elem.parent().height() * 100);

    var p = e.pageY;

    $('html').on('mousemove', function(e) {
            h = elem.parent().height();
            res = e.pageY - p;

         
            
            a = res/(h*0.15);
        
            n = top + (15*a);

            //q = 15 * Math.floor(n/15) + 4;

            start = 4;
            finish = 78;

            range = finish - start;

            if (n <= finish && n >= start && latest) {
                
                if (n > 70) {
                    n = 78;
                    angle = 0;
                }
                if (n > 52 && n < 70) {
                    n = 54;
                    angle = 90;
                }
                if (n > 34 && n < 52) {
                    n = 36;
                    angle = 180;
                }
                if (n > 16 && n < 34) {
                    n = 18;
                    angle = 270;
                }
                if (n < 16) {
                    n = 4;
                    angle = 360;
                } 
                

                
                elem.css('top', n +"%");
                latest.parent().css("transform", 'rotate(' + angle +'deg)');
                latest.parent().attr("data-angle", n);
            }
    })
    elem.on('dragstart', function (event) {
        return false;
    });
    $('html').on('mouseup', function() {
        $('html').off('mousemove');
    });
}


    /*
    * Drag and drop images
    */

    //$(".panel img").on("mousedown", function(e){
function panelImg(e,elem) {
       
        main_flag = true;

        $('#tooltip').remove();
       
        var elem = elem;

        var obj = elem.parent();
        
        var top_per = Math.round(obj.position().top / obj.parent().height() * 100);
        var left_per = Math.round(obj.position().left / obj.parent().width() * 100);
        
        var left = obj.position().left;
        var top = obj.position().top;

        var y = e.pageY ;
        var x = e.pageX;
        
        if (!canvas_enable) {
            var prev = prev_elem;
            showMain('drop');
            showDrop();
        }

        obj.css({'z-index': 10000, 'transition-duration': '0.1s' });
        
        //$('html').append($(this));

        $('html').on('mousemove', function(e) {
                
                res_y = (top + e.pageY - y)/obj.parent().height() * 100;
                res_x = (left + e.pageX - x)/obj.parent().width() * 100;

                obj.css({top: res_y + '%', left: res_x + '%'});
        });
        
        obj.on('dragstart', function() {
            return false;
        });

        $(document).on('mouseup', function() {
            $('html').off('mousemove');
            /*obj.attr('style', '');
            showMain(prev);
            hideDrop();
            $(document).off("mouseup");*/
            
            
             main_flag = false;
             if (!canvas_enable){
                    status = checkPosition(elem, $(".main"));

                    if (status) {
                        canvasShow();
                    }
             }
            //status = checkPosition(elem);
            var canvas = $(".canvas").offset();
            var canvas_h = $(".canvas").height();
            var canvas_w = $(".canvas").width();

            var img = elem.offset();
            var img_h = elem.height();
            var img_w = elem.width();

            var status = 0;
            target = false;
            if ( (img.top + img_h) > canvas.top    &&
            img.top < (canvas.top + canvas_h)      &&
            (img.left + img_w) > canvas.left       &&
            img.left < (canvas.left + canvas_w) ) status =  1;
            if (status) {
                setLast(obj.clone().appendTo(".canvas").addClass('border')
                    .append('<span class="img-control" onmousedown="resizeImg(event, $(this))"></span')
                    .append('<span class="img-control-delete" onmousedown="deleteImg(event, $(this))"><i class="fa fa-close fa-5" aria-hidden="true"></i></span')
                    .children('img').addClass('border-active').removeClass('insta-img').attr('onmousedown', ''));
                canvasImg();

                $('#bottom-nav').show();
            }
             
            obj.attr('style', '');
            showMain(prev);
            hideDrop();
            $(document).off("mouseup");
          
            
        });
    }

var latest = false;
var target = false;
function checkPosition(elem, parent = $(".canvas")) {
    var canvas = parent.offset();
    var canvas_h = parent.height();
    var canvas_w = parent.width();

    var img = elem.offset();
    var img_h = elem.height();
    var img_w = elem.width();

    var status = 0;

    if ( (img.top + img_h) > canvas.top    &&
    img.top < (canvas.top + canvas_h)      &&
    (img.left + img_w) > canvas.left       &&
    img.left < (canvas.left + canvas_w) ) return 1;

    return 0;
}
function canvasImg(obj) {

    $(".canvas>.border img").on("mousedown", function(e){

        var elem = $(this);

        var obj = $(this).parent();

        var left = Number(obj.css('left').slice(0, -2));
        var top = Number(obj.css('top').slice(0, -2));

        var y = e.pageY;
        var x = e.pageX;
      
        setLast(elem);

        target = true;
        
        $('html').on('mousemove', function(e) {
            var canvas = $(".canvas").offset();
            var canvas_h = $(".canvas").height();
            var canvas_w = $(".canvas").width();

            var img = obj.offset();
            var img_h = obj.height();
            var img_w = obj.width();
            res_y = top + e.pageY - y;
            res_x = left + e.pageX - x;
            
            
            if (res_y > 0 && (res_x) > 0 && (res_y + obj.height()) < canvas_h && (res_x + obj.width()) < canvas_w) {
                obj.css({top: res_y + 'px', left: res_x + 'px'});

            }
        });
        obj.on('dragstart', function() {
            return false;
        });
        $(document).on('mouseup', function() {
            $('html').off('mousemove');
            $(document).off("mouseup");
            target = false;
        });
    });
}

function setLast(obj) {
    if (latest) {
        latest.removeClass('border-active').parent().css('z-index', 1);
        hideControls(latest.parent());
    }

    latest = obj;

    latest.addClass('border-active');
    
    latest.parent().css('z-index', 2);

    rotate = getRotationDegrees(latest);

    setRotationDegrees(latest, rotate, 74, true);
    
    showControls(obj.parent());
}

function getRotationDegrees(obj) {
    var matrix = obj.css("-webkit-transform") ||
    obj.css("-moz-transform")    ||
    obj.css("-ms-transform")     ||
    obj.css("-o-transform")      ||
    obj.css("transform");
    if(matrix !== 'none') {
        var values = matrix.split('(')[1].split(')')[0].split(',');
        var a = values[0];
        var b = values[1];
        var angle = Math.atan2(b, a) * (180/Math.PI);

    } else { var angle = 0; }
    
    return (angle < 0) ? angle + 360 : angle;
}

function setRotationDegrees(obj, rotate = 0, range = 74, flag = false) {
    if (!flag){
        angle_per_percent = (360/range);

        rot = rotate - 4;

        angle =  360 - (rot * angle_per_percent);

        if (angle < 5) angle = 0;
        if (angle > 355) angle = 360;

        obj.parent().css("transform", 'rotate(' + angle +'deg)');
        obj.parent().attr("data-angle", rotate);
    }else {
        pos = obj.parent().attr("data-angle") || 77.4568;
        $("#canvas-scale").css("top", pos + "%");
    }
}

function canvasShow() {
    canvas_enable = true;
    $(".main").hide()
    $(".frame-main").hide() 
    $(".main-canvas").css("display", 'flex').fadeIn('slow');
    $('.spiral-nav-canvas').fadeIn('slow');  
    $('#bottom-nav').show();
}
function canvasHide() {
    canvas_enable = false;
    $(".main-canvas").hide();
    $(".main").fadeIn('slow');
    $(".frame-main").fadeIn('slow');   
    $('.spiral-nav-canvas').hide(); 
    $('#bottom-nav').hide();
    

}

function resizeImg(e, elem) {

        var obj = elem.parent();

        var w = Number(obj.css("width").slice(0, -2));
        var h = Number(obj.css("height").slice(0, -2));        
        var x = e.pageX;
        var y = e.pageY;

        target = true;
        $('html').on('mousemove', function(e) {
            res_x = e.pageY - y + w;
            res_y = e.pageY - y + h;

            canvas_h = Number($('.canvas').css('height').slice(0, -2));
            canvas_w = Number($('.canvas').css('width').slice(0, -2));            
            
            top_o = obj.position().top; 
            left_o = obj.position().left;           

            if ( (res_y + top_o) < canvas_h && (res_x + left_o) < canvas_w ) obj.css({width: res_x});
           
        });
        $(document).on('mouseup', function() {
            $('html').off('mousemove');
            $(document).off("mouseup");
            target = false;
        });
}

function deleteImg(e, elem) {
    elem.parent().remove();
}

function showControls(obj) {
    obj.children('.img-control').show();
    obj.children('.img-control-delete').show();
}

function hideControls(obj) {
    obj.children('.img-control').hide();
    obj.children('.img-control-delete').hide();
}

function hideLatest() {
    if (!target) {
        latest.removeClass('border-active').parent().css('z-index', 1);
        hideControls(latest.parent());
        latest = false;
        target = true;
    }
}

function savePDF() {
    html = '';
    images = [];
    $('.canvas>.canva-img').each(function (num,item) {
        image = {
            'height': ((Math.round($(this).height() / $(this).parent().height() * 100) * 768)/100),
            'width': ((Math.round($(this).width() / $(this).parent().width() * 100) * 1152)/100),
            'rotate': getRotationDegrees($(this)),
            'src': $(this).children('img').attr('src'),
            'top': ((Math.round(Number($(this).css('top').slice(0, -2)) / $(this).parent().height() * 100) * 768)/100),
            'left': ((Math.round(Number($(this).css('left').slice(0, -2)) / $(this).parent().width()  * 100) * 1152)/100)
        };
        
        images[num] = image;
    });

    $.ajax({
	    type: 'POST',
	    url: 'download_new.php',
	    data: { images: images},
		success: function(data, status)
	    {
            window.location.replace("http://create.badge-m.com/down.php");
		},
		error: function(data, status)
		{
		    alert("Error!");
		}
	});	
}

$(document).ready(function() {
    setTimeout(function() {
       // $('.button-nav').height($('.button-nav').height());
    }, 300);

})


$(window).resize(function() {
    //$('.button-nav').attr('style','height:auto');    
    //$('.button-nav').height($('.button-nav').height());
})

function showDrop() 
{
    $('.button-nav').hide();
    $('.button-sections').hide();
    $('.main-navigation-body').hide();    
    $('.main-navigation-header').hide();      
    $('.spiral-nav').hide();
    $('.drop-me').css('display','flex').fadeIn('slow');
}

function hideDrop()
{
    $('.button-nav').fadeIn('slow');
    $('.button-sections').css('display','flex').fadeIn('slow');
    $('.main-navigation-body').fadeIn('slow');  
    $('.main-navigation-header').fadeIn('slow');  
    $('.spiral-nav').fadeIn('slow');
    $('.drop-me').hide();
}