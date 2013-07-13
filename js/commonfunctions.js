/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function containerResize()
{
    var scaleFactor = 1;
    var scaleFactor1 = 0;
    var scaleFactor2 = 0;
    if (window.innerHeight < $("#container").height()) {
        scaleFactor1 = parseFloat(window.innerHeight / $("#container").height());
    }
    else
        scaleFactor1 = 1;

    if (window.innerWidth < $("#container").width()) {
        scaleFactor2 = parseFloat(window.innerWidth / $("#container").width());
    }
    else
        scaleFactor2 = 1;

    if (scaleFactor1 < scaleFactor2)
        scaleFactor = scaleFactor1;
    else
        scaleFactor = scaleFactor2;
    $("#container").css({"-webkit-transform": "scale(" + scaleFactor + ")"});
    $("#container").css({"-moz-transform": "scale(" + scaleFactor + ")"});
    $("#container").css({"-o-transform": "scale(" + scaleFactor + ")"});
    $("#container").css({"-ms-transform": "scale(" + scaleFactor + ")"});
    $("#container").css({"transform": "scale(" + scaleFactor + ")"});
}
