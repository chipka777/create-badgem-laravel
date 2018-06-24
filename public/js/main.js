
$(document).ready(function ()
{
    $(".next").click(function ()
    {
        var feedType = $(".navigation .active").attr('id');
        if(feedType=="feed")
        {
            nextFeedClick();

        }
        else if(feedType=="insta")
        {
            nextInstaClick();
        }
    });

    $(".prev").click(function ()
    {
        var feedType = $(".navigation .active").attr('id');
        if(feedType=="feed")
        {
            prevFeedClick();
        }
        else if(feedType=="insta")
        {
            prevInstaClick();
        }
    });

});
function nextInstaClick()
{
    var totalimages = $(".panel").length;
    for (i = 1; i < totalimages; i++)
    {
        if(i<=10)
        {
            $(".panels .panel:nth-child("+(i+1)+")").addClass("pos"+(i-1)+" show_image").removeClass("pos"+(i)+" hide_image");
        }
        else
        {
            $(".panels .panel:nth-child("+(i+1)+")").addClass("pos"+(i-1)+" hide_image").removeClass("pos"+(i)+" show_image");
        }
        var temp =  totalimages-1;
        if(i==temp)
        {
            $(".panels .panel:first-child").addClass("pos"+(totalimages-1)+"").removeClass("pos0");
            $('.panels .panel:first').appendTo('.panels');
            $( ".panel" ).last().addClass( "hide_image" ).removeClass("show_image");
        }
    }

}
function prevInstaClick()
{
    var totalimages = $(".panel").length;
    for (i = 1; i < totalimages; i++)
    {
        if(i<=9)
        {
            $(".panels .panel:nth-child("+i+")").addClass("pos"+i+" show_image").removeClass("pos"+(i-1)+" hide_image");
        }
        else
        {
            $(".panels .panel:nth-child("+i+")").addClass("pos"+i+" hide_image").removeClass("pos"+(i-1)+" show_image");
        }
        var temp =  totalimages-1;
        if(i==temp)
        {
            $(".panels .panel:last-child").addClass("pos0 show_image").removeClass("pos"+(totalimages-1)+"");
            $('.panels .panel:last').prependTo('.panels');
            //$( ".panel" ).first().addClass( "show_image").removeClass("hide_image");;
        }
    }
}
/*
function prevFeedClick()
{
    var total = <?php echo $totalImages; ?>;
    var firstImg = <?php echo $firstID; ?>;
    var lastImg = <?php echo $lastID; ?>;
    var currentID = <?php echo $_SESSION['currentID']; ?>;
    $(".next").prop('disabled', true);
    $(".prev").prop('disabled', true);
    var id = $(".panel:first-child").attr('id');
    var idNumber = id.substring(4);
    var feedType = $(".navigation .active").attr('id');
    for (i = 1; i < 10; i++)
    {
        $(".panels .panel:nth-child("+i+")").addClass("pos"+i+"").removeClass("pos"+(i-1)+"");
    }
    var pageValue = $(".next").attr("page-value");
    $.ajax({
        type: 'POST',
        url: 'load-update.php',
        data: { currentID: idNumber, direction: 'up', pageValue:pageValue,feedType:feedType},
        success: function(data, status)
        {
            $(".panels").prepend(data);
            if(pageValue<total-8){	pageValue++;	}
            else{	pageValue = 1;	}
            $(".next").attr( "page-value", pageValue );
            $(".prev").attr( "page-value", pageValue );
            if ($(".panel").length > 10)
            {
                $(".panel:last-child").remove();
            }
            $(".next").prop('disabled', false);
            $(".prev").prop('disabled', false);
        },
        error: function(data, status)
        {
            alert("Error!");
        }
    });
}
function nextFeedClick()
{
    var total = <?php echo $totalImages; ?>;
    var firstImg = <?php echo $firstID; ?>;
    var lastImg = <?php echo $lastID; ?>;
    var currentID = <?php echo $_SESSION['currentID']; ?>;
    $(".next").prop('disabled', true);
    $(".prev").prop('disabled', true);
    var id = $(".panel:last-child").attr('id');
    var idNumber = id.substring(4);
    var feedType = $(".navigation .active").attr('id');
    for (j = 1; j < 10; j++)
    {
        $(".panels .panel:nth-child("+(j+1)+")").addClass("pos"+(j-1)+"").removeClass("pos"+(j)+"");
    }
    var pageValue = $(".next").attr("page-value");
    $.ajax({
        type: 'POST',
        url: 'load-update.php',
        data: { currentID: idNumber, direction: 'down', pageValue:pageValue,feedType:feedType},
        success: function(data, status)
        {
            $(".panels").append(data);
            if(pageValue>1){	pageValue--;	}
            else{	pageValue = total;	}
            $(".next").attr( "page-value", pageValue );
            $(".prev").attr( "page-value", pageValue );
            if ($(".panel").length > 10)
            {
                $(".panels .panel:first-child").remove();
            }
            $(".next").prop('disabled', false);
            $(".prev").prop('disabled', false);
        },
        error: function(data, status)
        {
            alert("Error!");
        }
    });
}*/
function getFeed()
{
    $.ajax({
        type: 'POST',
        url: 'load-update.php',
        data: { currentID: "", direction: "", pageValue:"",feedType:"feed"},
        success: function(data, status)
        {
            $(".panels").html(data);
        },
        error: function(data, status)
        {
            alert("Error!");
        }
    });
}
function getInsta()
{
    $.ajax({
        type: 'POST',
        url: 'load-update.php',
        data: { currentID: "", direction: "", pageValue:"",feedType:"insta"},
        success: function(data, status)
        {
            $(".panels").html(data);
        },
        error: function(data, status)
        {
            alert("Error!");
        }
    });
}

function searchCate(actionValue)
{

    $('.panels').html('<img style="margin: 62px;width: 50px;" src="/img/ajax-loader.gif" />');
    $.ajax({
        url: "cat_search_ajax.php?id="+actionValue,
        type:"POST",
        success: function(html){
            $('.panels').html(html);
        }
    });

}

var flagBot = false;

function botTrigerEnter()
{
    if (flagBot) return false;
    
    $('#bottom-nav').css('bottom', '-40px');
}

function botTrigerLeave()
{
    if (flagBot) return false;
    $('#bottom-nav').css('bottom', '-50px');
}

function botMenuOpen()
{
    if (flagBot) return botMenuClose();

    flagBot = true;

    $('#bottom-nav').css('bottom', '0px');
}

function botMenuClose()
{
    flagBot = false;
    $('#bottom-nav').css('bottom', '-50px');
}

$('html').keypress(function(event) {
     if (event.keyCode == 13) {
         $('.login-btn').click();
     }
})