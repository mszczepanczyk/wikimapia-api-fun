function draw($id) {
    if ($id) {
        var canvas = document.getElementById('canv');
        var context = canvas.getContext('2d');
        $.getJSON('object.php?id=' + $id, function(data) {
            var LEN_X = 300, LEN_Y = 300;

            // find min/max
            var min_x, max_x, min_y, max_y;
            min_x = data.polygon[0].x;
            max_x = data.polygon[0].x;
            min_y = data.polygon[0].y;
            max_y = data.polygon[0].y;
            for (var i = 0; i < data.polygon.length; i++) {
                min_x = Math.min(min_x, data.polygon[i].x);
                max_x = Math.max(max_x, data.polygon[i].x);
                min_y = Math.min(min_y, data.polygon[i].y);
                max_y = Math.max(max_y, data.polygon[i].y);
            }

            // variables for scaling
            var k, cx, cy;
            cx = min_x;
            cy = min_y;
            if (LEN_X/(max_x - min_x) < LEN_Y/(max_y - min_y)) {
                k = LEN_X/(max_x - min_x);
            }
            else {
                k = LEN_Y/(max_y - min_y);
            }

            // drawing
            context.fillStyle = "rgb(55,155,155)";
            context.beginPath();
            for (var i = 0; i < data.polygon.length; i++) {
                var x, y;
                x = k * (data.polygon[i].x - cx);
                y = k * (data.polygon[i].y - cy);
                if (i == 0) {
                    context.moveTo(x, y);
                }
                else {
                    context.lineTo(x, y);
                }
            }
            context.closePath();
            context.fill();
        });
    }
}
