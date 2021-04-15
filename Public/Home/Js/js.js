var rad = Math.PI / 180;
 var R = 300;
 var N = 16; // num slices: odd number!!
 var A = 360 * rad / N; // angle slice
 var W = 2 * Math.abs(Math.sin(A / 2)) * R; // width buffer canvas
 var H = Math.abs(Math.cos(A / 2)) * R; // height buffer canvas
 // buffer canvas
 var _canvas = document.getElementById("_canvas");
 var _ctx = _canvas.getContext("2d");
 var _cw = _canvas.width = W;
 _cx = _cw / 2;
 var _ch = _canvas.height = H;
 _cy = _ch / 2;
 _ctx.shadowBlur = 5;
 _ctx.shadowOffsetX = 3;
 _ctx.shadowOffsetY = 3;
 _ctx.shadowColor = "#333";
 // main canvas
 var canvas = document.getElementById("canvas");
 var ctx = canvas.getContext("2d");
 var cw = canvas.width = 600;
 cx = cw / 2;
 var ch = canvas.height = 600;
 cy = ch / 2;
 var frames = 0; // for the animation
 var offset = 0; // time offset between particles
 var particles = [];
 var n = 16; // num particles
 var historyLength = 50;
 function Particle(i) {
    this.x = 0;
    this.y = 0;
    this.r = 5;
    this.offset = Math.random() * 1000;
    this.h = 200 + i * 12; // hue
    this.s = 20; // saturation
    this.history = [{
        x: this.x,
        y: this.y,
        r: this.r,
        h: this.h,
        s: this.s,
        l: 65
    }];
    this.draw = function() {
        for (var i = 0; i < this.history.length; i++) {
            var pos = this.history[i];
            var r = map(i, 0, historyLength, .1, this.r);
            _ctx.fillStyle = "hsl(" + pos.h + ", " + pos.s + "%," + pos.l + "%)";
            _ctx.beginPath();
            _ctx.arc(pos.x, pos.y, r, 0, 2 * Math.PI);
            _ctx.fill();
        }
    }
    this.update = function(t, frames) {
        var s = map(this.y, 0, H, 10, 60); // saturation
        this.r = map(this.x, 0, W, 1, 12);
        var l = map(this.x, 0, W, 100, 30); //map(this.y, 0, H, 30, 80);
        this.x = _cx + Math.cos(t / 17 + 
		   Math.cos(t / 11 + frames * rad)) * (_cx - 2 * this.r);
        this.y = _cy + Math.sin(t / 31 + 
		   Math.cos(t / 37 + frames * rad)) * (_cy - 2 * this.r);
        this.history.push({
            x: this.x,
            y: this.y,
            h: this.h,
            s: s,
            l: l
        })
        if (this.history.length > historyLength) {
            this.history.splice(0, 1)
        }
    }
 }
 for (var i = 0; i < n; i++) {
    var p = new Particle(i);
    particles.push(p);
 }
 path(_ctx, W, H)
 _ctx.clip();
 var img = _canvas;
 function Animate() {
    elId = window.requestAnimationFrame(Animate);
    frames += .25;
    _ctx.clearRect(-_cw, -_ch, 2 * _cw, 2 * _ch);
    ctx.clearRect(-cw, -ch, 2 * cw, 2 * ch);
    var t = new Date().getTime() / 70;
    for (var i = 0; i < particles.length; i++) {
        var p = particles[i];
        p.update(t + p.offset, frames);
        p.draw();
    }
    ctx.save();
    ctx.translate(cx, cy);
    //ctx.rotate(frames/25)
    for (var i = 0; i < N; i++) {
        var sc = i % 2 == 0 ? 1 : -1;
        ctx.rotate(2 * Math.PI / N);
        ctx.save();
        //ctx.translate(200,0)
        ctx.scale(sc, 1);
        ctx.drawImage(img, -W / 2, 0);
        ctx.restore();
    }
    ctx.restore();
 }
 requestId = window.requestAnimationFrame(Animate);
 function path(ctx, W, H) {
        ctx.moveTo(W / 2, 0);
        ctx.lineTo(W, H);
        ctx.lineTo(0, H);
        ctx.closePath();
        ctx.restore();
    } // for clip
 
 function map(n, a, b, _a, _b) {
    var d = b - a;
    var _d = _b - _a;
    var u = _d / d;
    return _a + n * u;
}