function PointerEventsPolyfill(t) { if(this.options = { selector: "*", mouseEvents: ["click", "dblclick", "mousedown", "mouseup"], usePolyfillIf: function() { if("Microsoft Internet Explorer" == navigator.appName) { var t = navigator.userAgent; if(null != t.match(/MSIE ([0-9]{1,}[\.0-9]{0,})/)) { var e = parseFloat(RegExp.$1); if(11 > e) return !0 } } return !1 } }, t) { var e = this;
		$.each(t, function(t, r) { e.options[t] = r }) } this.options.usePolyfillIf() && this.register_mouse_events() }(function() { "use strict";

	function t(t) { return "function" == typeof t || "object" == typeof t && null !== t }

	function e(t) { return "function" == typeof t }

	function r(t) { return "object" == typeof t && null !== t }

	function n(t) { U = t }

	function i(t) { V = t }

	function o() { return function() { process.nextTick(h) } }

	function s() { return function() { k(h) } }

	function a() { var t = 0,
			e = new q(h),
			r = document.createTextNode(""); return e.observe(r, { characterData: !0 }),
			function() { r.data = t = ++t % 2 } }

	function l() { var t = new MessageChannel; return t.port1.onmessage = h,
			function() { t.port2.postMessage(0) } }

	function u() { return function() { setTimeout(h, 1) } }

	function h() { for(var t = 0; W > t; t += 2) { var e = Z[t],
				r = Z[t + 1];
			e(r), Z[t] = void 0, Z[t + 1] = void 0 } W = 0 }

	function c() { try { var t = require,
				e = t("vertx"); return k = e.runOnLoop || e.runOnContext, s() } catch(r) { return u() } }

	function p() {}

	function d() { return new TypeError("You cannot resolve a promise with itself") }

	function f() { return new TypeError("A promises callback cannot return that same promise.") }

	function v(t) { try { return t.then } catch(e) { return et.error = e, et } }

	function g(t, e, r, n) { try { t.call(e, r, n) } catch(i) { return i } }

	function m(t, e, r) { V(function(t) { var n = !1,
				i = g(r, e, function(r) { n || (n = !0, e !== r ? x(t, r) : S(t, r)) }, function(e) { n || (n = !0, E(t, e)) }, "Settle: " + (t._label || " unknown promise"));!n && i && (n = !0, E(t, i)) }, t) }

	function y(t, e) { e._state === J ? S(t, e._result) : e._state === tt ? E(t, e._result) : A(e, void 0, function(e) { x(t, e) }, function(e) { E(t, e) }) }

	function T(t, r) { if(r.constructor === t.constructor) y(t, r);
		else { var n = v(r);
			n === et ? E(t, et.error) : void 0 === n ? S(t, r) : e(n) ? m(t, r, n) : S(t, r) } }

	function x(e, r) { e === r ? E(e, d()) : t(r) ? T(e, r) : S(e, r) }

	function b(t) { t._onerror && t._onerror(t._result), _(t) }

	function S(t, e) { t._state === $ && (t._result = e, t._state = J, 0 !== t._subscribers.length && V(_, t)) }

	function E(t, e) { t._state === $ && (t._state = tt, t._result = e, V(b, t)) }

	function A(t, e, r, n) { var i = t._subscribers,
			o = i.length;
		t._onerror = null, i[o] = e, i[o + J] = r, i[o + tt] = n, 0 === o && t._state && V(_, t) }

	function _(t) { var e = t._subscribers,
			r = t._state; if(0 !== e.length) { for(var n, i, o = t._result, s = 0; s < e.length; s += 3) n = e[s], i = e[s + r], n ? C(r, n, i, o) : i(o);
			t._subscribers.length = 0 } }

	function M() { this.error = null }

	function w(t, e) { try { return t(e) } catch(r) { return rt.error = r, rt } }

	function C(t, r, n, i) { var o, s, a, l, u = e(n); if(u) { if(o = w(n, i), o === rt ? (l = !0, s = o.error, o = null) : a = !0, r === o) return void E(r, f()) } else o = i, a = !0;
		r._state !== $ || (u && a ? x(r, o) : l ? E(r, s) : t === J ? S(r, o) : t === tt && E(r, o)) }

	function P(t, e) { try { e(function(e) { x(t, e) }, function(e) { E(t, e) }) } catch(r) { E(t, r) } }

	function R(t, e) { var r = this;
		r._instanceConstructor = t, r.promise = new t(p), r._validateInput(e) ? (r._input = e, r.length = e.length, r._remaining = e.length, r._init(), 0 === r.length ? S(r.promise, r._result) : (r.length = r.length || 0, r._enumerate(), 0 === r._remaining && S(r.promise, r._result))) : E(r.promise, r._validationError()) }

	function D(t) { return new nt(this, t).promise }

	function B(t) {
		function e(t) { x(i, t) }

		function r(t) { E(i, t) } var n = this,
			i = new n(p); if(!X(t)) return E(i, new TypeError("You must pass an array to race.")), i; for(var o = t.length, s = 0; i._state === $ && o > s; s++) A(n.resolve(t[s]), void 0, e, r); return i }

	function O(t) { var e = this; if(t && "object" == typeof t && t.constructor === e) return t; var r = new e(p); return x(r, t), r }

	function F(t) { var e = this,
			r = new e(p); return E(r, t), r }

	function L() { throw new TypeError("You must pass a resolver function as the first argument to the promise constructor") }

	function I() { throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.") }

	function G(t) { this._id = lt++, this._state = void 0, this._result = void 0, this._subscribers = [], p !== t && (e(t) || L(), this instanceof G || I(), P(this, t)) }

	function N() { var t; if("undefined" != typeof global) t = global;
		else if("undefined" != typeof self) t = self;
		else try { t = Function("return this")() } catch(e) { throw new Error("polyfill failed because global object is unavailable in this environment") }
		var r = t.Promise;
		(!r || "[object Promise]" !== Object.prototype.toString.call(r.resolve()) || r.cast) && (t.Promise = ut) } var H;
	H = Array.isArray ? Array.isArray : function(t) { return "[object Array]" === Object.prototype.toString.call(t) }; var k, U, j, X = H,
		W = 0,
		V = ({}.toString, function(t, e) { Z[W] = t, Z[W + 1] = e, W += 2, 2 === W && (U ? U(h) : j()) }),
		z = "undefined" != typeof window ? window : void 0,
		Y = z || {},
		q = Y.MutationObserver || Y.WebKitMutationObserver,
		K = "undefined" != typeof process && "[object process]" === {}.toString.call(process),
		Q = "undefined" != typeof Uint8ClampedArray && "undefined" != typeof importScripts && "undefined" != typeof MessageChannel,
		Z = new Array(1e3);
	j = K ? o() : q ? a() : Q ? l() : void 0 === z && "function" == typeof require ? c() : u(); var $ = void 0,
		J = 1,
		tt = 2,
		et = new M,
		rt = new M;
	R.prototype._validateInput = function(t) { return X(t) }, R.prototype._validationError = function() { return new Error("Array Methods must be provided an Array") }, R.prototype._init = function() { this._result = new Array(this.length) }; var nt = R;
	R.prototype._enumerate = function() { for(var t = this, e = t.length, r = t.promise, n = t._input, i = 0; r._state === $ && e > i; i++) t._eachEntry(n[i], i) }, R.prototype._eachEntry = function(t, e) { var n = this,
			i = n._instanceConstructor;
		r(t) ? t.constructor === i && t._state !== $ ? (t._onerror = null, n._settledAt(t._state, e, t._result)) : n._willSettleAt(i.resolve(t), e) : (n._remaining--, n._result[e] = t) }, R.prototype._settledAt = function(t, e, r) { var n = this,
			i = n.promise;
		i._state === $ && (n._remaining--, t === tt ? E(i, r) : n._result[e] = r), 0 === n._remaining && S(i, n._result) }, R.prototype._willSettleAt = function(t, e) { var r = this;
		A(t, void 0, function(t) { r._settledAt(J, e, t) }, function(t) { r._settledAt(tt, e, t) }) }; var it = D,
		ot = B,
		st = O,
		at = F,
		lt = 0,
		ut = G;
	G.all = it, G.race = ot, G.resolve = st, G.reject = at, G._setScheduler = n, G._setAsap = i, G._asap = V, G.prototype = { constructor: G, then: function(t, e) { var r = this,
				n = r._state; if(n === J && !t || n === tt && !e) return this; var i = new this.constructor(p),
				o = r._result; if(n) { var s = arguments[n - 1];
				V(function() { C(n, i, s, o) }) } else A(r, i, t, e); return i }, "catch": function(t) { return this.then(null, t) } }; var ht = N,
		ct = { Promise: ut, polyfill: ht }; "function" == typeof define && define.amd ? define(function() { return ct }) : "undefined" != typeof module && module.exports ? module.exports = ct : "undefined" != typeof this && (this.ES6Promise = ct), ht() }).call(this),
	function(t) {
		function e(t) { return t = +t, 0 === t || isNaN(t) ? t : t > 0 ? 1 : -1 }

		function r(t) { var e = new Promise(function(e, r) { var n = function(i) { setTimeout(function() { t && t.data ? e() : i >= 20 ? r() : n(++i) }, 50) };
				n(0) }); return e }

		function n() { f = d ? (t.screen.orientation.angle || 0) * u : (t.orientation || 0) * u }

		function i(t) { c.orientation.data = t; for(var e in c.orientation.callbacks) c.orientation.callbacks[e].call(this) }

		function o(t) { c.motion.data = t; for(var e in c.motion.callbacks) c.motion.callbacks[e].call(this) } if(void 0 === t.FULLTILT || null === t.FULLTILT) { var s = Math.PI,
				a = s / 2,
				l = 2 * s,
				u = s / 180,
				h = 180 / s,
				c = { orientation: { active: !1, callbacks: [], data: void 0 }, motion: { active: !1, callbacks: [], data: void 0 } },
				p = !1,
				d = t.screen && t.screen.orientation && void 0 !== t.screen.orientation.angle && null !== t.screen.orientation.angle ? !0 : !1,
				f = (d ? t.screen.orientation.angle : t.orientation || 0) * u,
				v = a,
				g = s,
				m = l / 3,
				y = -a,
				T = {};
			T.version = "0.5.3", T.getDeviceOrientation = function(t) { var e = new Promise(function(e, n) { var i = new T.DeviceOrientation(t);
					i.start(); var o = new r(c.orientation);
					o.then(function() { e(i) })["catch"](function() { i.stop(), n("DeviceOrientation is not supported") }) }); return e }, T.getDeviceMotion = function(t) { var e = new Promise(function(e, n) { var i = new T.DeviceMotion(t);
					i.start(); var o = new r(c.motion);
					o.then(function() { e(i) })["catch"](function() { i.stop(), n("DeviceMotion is not supported") }) }); return e }, T.Quaternion = function(t, r, n, i) { var o;
				this.set = function(t, e, r, n) { this.x = t || 0, this.y = e || 0, this.z = r || 0, this.w = n || 1 }, this.copy = function(t) { this.x = t.x, this.y = t.y, this.z = t.z, this.w = t.w }, this.setFromEuler = function() { var t, e, r, n, i, o, s, a, l, h, c, p; return function(d) { return d = d || {}, r = (d.alpha || 0) * u, t = (d.beta || 0) * u, e = (d.gamma || 0) * u, o = r / 2, n = t / 2, i = e / 2, s = Math.cos(n), a = Math.cos(i), l = Math.cos(o), h = Math.sin(n), c = Math.sin(i), p = Math.sin(o), this.set(h * a * l - s * c * p, s * c * l + h * a * p, s * a * p + h * c * l, s * a * l - h * c * p), this.normalize(), this } }(), this.setFromRotationMatrix = function() { var t; return function(r) { return t = r.elements, this.set(.5 * Math.sqrt(1 + t[0] - t[4] - t[8]) * e(t[7] - t[5]), .5 * Math.sqrt(1 - t[0] + t[4] - t[8]) * e(t[2] - t[6]), .5 * Math.sqrt(1 - t[0] - t[4] + t[8]) * e(t[3] - t[1]), .5 * Math.sqrt(1 + t[0] + t[4] + t[8])), this } }(), this.multiply = function(t) { return o = T.Quaternion.prototype.multiplyQuaternions(this, t), this.copy(o), this }, this.rotateX = function(t) { return o = T.Quaternion.prototype.rotateByAxisAngle(this, [1, 0, 0], t), this.copy(o), this }, this.rotateY = function(t) { return o = T.Quaternion.prototype.rotateByAxisAngle(this, [0, 1, 0], t), this.copy(o), this }, this.rotateZ = function(t) { return o = T.Quaternion.prototype.rotateByAxisAngle(this, [0, 0, 1], t), this.copy(o), this }, this.normalize = function() { return T.Quaternion.prototype.normalize(this) }, this.set(t, r, n, i) }, T.Quaternion.prototype = { constructor: T.Quaternion, multiplyQuaternions: function() { var t = new T.Quaternion; return function(e, r) { var n = e.x,
							i = e.y,
							o = e.z,
							s = e.w,
							a = r.x,
							l = r.y,
							u = r.z,
							h = r.w; return t.set(n * h + s * a + i * u - o * l, i * h + s * l + o * a - n * u, o * h + s * u + n * l - i * a, s * h - n * a - i * l - o * u), t } }(), normalize: function(t) { var e = Math.sqrt(t.x * t.x + t.y * t.y + t.z * t.z + t.w * t.w); return 0 === e ? (t.x = 0, t.y = 0, t.z = 0, t.w = 1) : (e = 1 / e, t.x *= e, t.y *= e, t.z *= e, t.w *= e), t }, rotateByAxisAngle: function() { var t, e, r = new T.Quaternion,
						n = new T.Quaternion; return function(i, o, s) { return t = (s || 0) / 2, e = Math.sin(t), n.set((o[0] || 0) * e, (o[1] || 0) * e, (o[2] || 0) * e, Math.cos(t)), r = T.Quaternion.prototype.multiplyQuaternions(i, n), T.Quaternion.prototype.normalize(r) } }() }, T.RotationMatrix = function(t, e, r, n, i, o, s, a, l) { var h;
				this.elements = new Float32Array(9), this.identity = function() { return this.set(1, 0, 0, 0, 1, 0, 0, 0, 1), this }, this.set = function(t, e, r, n, i, o, s, a, l) { this.elements[0] = t || 1, this.elements[1] = e || 0, this.elements[2] = r || 0, this.elements[3] = n || 0, this.elements[4] = i || 1, this.elements[5] = o || 0, this.elements[6] = s || 0, this.elements[7] = a || 0, this.elements[8] = l || 1 }, this.copy = function(t) { this.elements[0] = t.elements[0], this.elements[1] = t.elements[1], this.elements[2] = t.elements[2], this.elements[3] = t.elements[3], this.elements[4] = t.elements[4], this.elements[5] = t.elements[5], this.elements[6] = t.elements[6], this.elements[7] = t.elements[7], this.elements[8] = t.elements[8] }, this.setFromEuler = function() { var t, e, r, n, i, o, s, a, l; return function(h) { return h = h || {}, r = (h.alpha || 0) * u, t = (h.beta || 0) * u, e = (h.gamma || 0) * u, n = Math.cos(t), i = Math.cos(e), o = Math.cos(r), s = Math.sin(t), a = Math.sin(e), l = Math.sin(r), this.set(o * i - l * s * a, -n * l, i * l * s + o * a, i * l + o * s * a, o * n, l * a - o * i * s, -n * a, s, n * i), this.normalize(), this } }(), this.setFromQuaternion = function() { var t, e, r, n; return function(i) { return t = i.w * i.w, e = i.x * i.x, r = i.y * i.y, n = i.z * i.z, this.set(t + e - r - n, 2 * (i.x * i.y - i.w * i.z), 2 * (i.x * i.z + i.w * i.y), 2 * (i.x * i.y + i.w * i.z), t - e + r - n, 2 * (i.y * i.z - i.w * i.x), 2 * (i.x * i.z - i.w * i.y), 2 * (i.y * i.z + i.w * i.x), t - e - r + n), this } }(), this.multiply = function(t) { return h = T.RotationMatrix.prototype.multiplyMatrices(this, t), this.copy(h), this }, this.rotateX = function(t) { return h = T.RotationMatrix.prototype.rotateByAxisAngle(this, [1, 0, 0], t), this.copy(h), this }, this.rotateY = function(t) { return h = T.RotationMatrix.prototype.rotateByAxisAngle(this, [0, 1, 0], t), this.copy(h), this }, this.rotateZ = function(t) { return h = T.RotationMatrix.prototype.rotateByAxisAngle(this, [0, 0, 1], t), this.copy(h), this }, this.normalize = function() { return T.RotationMatrix.prototype.normalize(this) }, this.set(t, e, r, n, i, o, s, a, l) }, T.RotationMatrix.prototype = { constructor: T.RotationMatrix, multiplyMatrices: function() { var t, e, r = new T.RotationMatrix; return function(n, i) { return t = n.elements, e = i.elements, r.set(t[0] * e[0] + t[1] * e[3] + t[2] * e[6], t[0] * e[1] + t[1] * e[4] + t[2] * e[7], t[0] * e[2] + t[1] * e[5] + t[2] * e[8], t[3] * e[0] + t[4] * e[3] + t[5] * e[6], t[3] * e[1] + t[4] * e[4] + t[5] * e[7], t[3] * e[2] + t[4] * e[5] + t[5] * e[8], t[6] * e[0] + t[7] * e[3] + t[8] * e[6], t[6] * e[1] + t[7] * e[4] + t[8] * e[7], t[6] * e[2] + t[7] * e[5] + t[8] * e[8]), r } }(), normalize: function(t) { var e = t.elements,
						r = e[0] * e[4] * e[8] - e[0] * e[5] * e[7] - e[1] * e[3] * e[8] + e[1] * e[5] * e[6] + e[2] * e[3] * e[7] - e[2] * e[4] * e[6]; return e[0] /= r, e[1] /= r, e[2] /= r, e[3] /= r, e[4] /= r, e[5] /= r, e[6] /= r, e[7] /= r, e[8] /= r, t.elements = e, t }, rotateByAxisAngle: function() { var t, e, r = new T.RotationMatrix,
						n = new T.RotationMatrix,
						i = !1; return function(o, s, a) { return n.identity(), i = !1, t = Math.sin(a), e = Math.cos(a), 1 === s[0] && 0 === s[1] && 0 === s[2] ? (i = !0, n.elements[4] = e, n.elements[5] = -t, n.elements[7] = t, n.elements[8] = e) : 1 === s[1] && 0 === s[0] && 0 === s[2] ? (i = !0, n.elements[0] = e, n.elements[2] = t, n.elements[6] = -t, n.elements[8] = e) : 1 === s[2] && 0 === s[0] && 0 === s[1] && (i = !0, n.elements[0] = e, n.elements[1] = -t, n.elements[3] = t, n.elements[4] = e), i ? (r = T.RotationMatrix.prototype.multiplyMatrices(o, n), r = T.RotationMatrix.prototype.normalize(r)) : r = o, r } }() }, T.Euler = function(t, e, r) { this.set = function(t, e, r) { this.alpha = t || 0, this.beta = e || 0, this.gamma = r || 0 }, this.copy = function(t) { this.alpha = t.alpha, this.beta = t.beta, this.gamma = t.gamma }, this.setFromRotationMatrix = function() { var t, e, r, n; return function(i) { t = i.elements, t[8] > 0 ? (e = Math.atan2(-t[1], t[4]), r = Math.asin(t[7]), n = Math.atan2(-t[6], t[8])) : t[8] < 0 ? (e = Math.atan2(t[1], -t[4]), r = -Math.asin(t[7]), r += r >= 0 ? -s : s, n = Math.atan2(t[6], -t[8])) : t[6] > 0 ? (e = Math.atan2(-t[1], t[4]), r = Math.asin(t[7]), n = -a) : t[6] < 0 ? (e = Math.atan2(t[1], -t[4]), r = -Math.asin(t[7]), r += r >= 0 ? -s : s, n = -a) : (e = Math.atan2(t[3], t[0]), r = t[7] > 0 ? a : -a, n = 0), 0 > e && (e += l), e *= h, r *= h, n *= h, this.set(e, r, n) } }(), this.setFromQuaternion = function() { var t, e, r; return function(n) { var i = n.w * n.w,
							o = n.x * n.x,
							u = n.y * n.y,
							c = n.z * n.z,
							p = i + o + u + c,
							d = n.w * n.x + n.y * n.z,
							f = 1e-6; if(d > (.5 - f) * p) t = 2 * Math.atan2(n.y, n.w), e = a, r = 0;
						else if((-.5 + f) * p > d) t = -2 * Math.atan2(n.y, n.w), e = -a, r = 0;
						else { var v = i - o + u - c,
								g = 2 * (n.w * n.z - n.x * n.y),
								m = i - o - u + c,
								y = 2 * (n.w * n.y - n.x * n.z);
							m > 0 ? (t = Math.atan2(g, v), e = Math.asin(2 * d / p), r = Math.atan2(y, m)) : (t = Math.atan2(-g, -v), e = -Math.asin(2 * d / p), e += 0 > e ? s : -s, r = Math.atan2(-y, -m)) } 0 > t && (t += l), t *= h, e *= h, r *= h, this.set(t, e, r) } }(), this.rotateX = function(t) { return T.Euler.prototype.rotateByAxisAngle(this, [1, 0, 0], t), this }, this.rotateY = function(t) { return T.Euler.prototype.rotateByAxisAngle(this, [0, 1, 0], t), this }, this.rotateZ = function(t) { return T.Euler.prototype.rotateByAxisAngle(this, [0, 0, 1], t), this }, this.set(t, e, r) }, T.Euler.prototype = { constructor: T.Euler, rotateByAxisAngle: function() { var t = new T.RotationMatrix; return function(e, r, n) { return t.setFromEuler(e), t = T.RotationMatrix.prototype.rotateByAxisAngle(t, r, n), e.setFromRotationMatrix(t), e } }() }, T.DeviceOrientation = function(e) { this.options = e || {}; var r = 0,
					n = 200,
					i = 0,
					o = 10; if(this.alphaOffsetScreen = 0, this.alphaOffsetDevice = void 0, "game" === this.options.type) { var s = function(e) { return null !== e.alpha && (this.alphaOffsetDevice = new T.Euler(e.alpha, 0, 0), this.alphaOffsetDevice.rotateZ(-f), ++i >= o) ? void t.removeEventListener("deviceorientation", s, !1) : void(++r >= n && t.removeEventListener("deviceorientation", s, !1)) }.bind(this);
					t.addEventListener("deviceorientation", s, !1) } else if("world" === this.options.type) { var a = function(e) { return e.absolute !== !0 && void 0 !== e.webkitCompassAccuracy && null !== e.webkitCompassAccuracy && +e.webkitCompassAccuracy >= 0 && +e.webkitCompassAccuracy < 50 && (this.alphaOffsetDevice = new T.Euler(e.webkitCompassHeading, 0, 0), this.alphaOffsetDevice.rotateZ(f), this.alphaOffsetScreen = f, ++i >= o) ? void t.removeEventListener("deviceorientation", a, !1) : void(++r >= n && t.removeEventListener("deviceorientation", a, !1)) }.bind(this);
					t.addEventListener("deviceorientation", a, !1) } }, T.DeviceOrientation.prototype = { constructor: T.DeviceOrientation, start: function(e) { e && "[object Function]" == Object.prototype.toString.call(e) && c.orientation.callbacks.push(e), p || (d ? t.screen.orientation.addEventListener("change", n, !1) : t.addEventListener("orientationchange", n, !1)), c.orientation.active || (t.addEventListener("deviceorientation", i, !1), c.orientation.active = !0) }, stop: function() { c.orientation.active && (t.removeEventListener("deviceorientation", i, !1), c.orientation.active = !1) }, listen: function(t) { this.start(t) }, getFixedFrameQuaternion: function() { var t = new T.Euler,
						e = new T.RotationMatrix,
						r = new T.Quaternion; return function() { var n = c.orientation.data || { alpha: 0, beta: 0, gamma: 0 },
							i = n.alpha; return this.alphaOffsetDevice && (e.setFromEuler(this.alphaOffsetDevice), e.rotateZ(-this.alphaOffsetScreen), t.setFromRotationMatrix(e), t.alpha < 0 && (t.alpha += 360), t.alpha %= 360, i -= t.alpha), t.set(i, n.beta, n.gamma), r.setFromEuler(t), r } }(), getScreenAdjustedQuaternion: function() { var t; return function() { return t = this.getFixedFrameQuaternion(), t.rotateZ(-f), t } }(), getFixedFrameMatrix: function() { var t = new T.Euler,
						e = new T.RotationMatrix; return function() { var r = c.orientation.data || { alpha: 0, beta: 0, gamma: 0 },
							n = r.alpha; return this.alphaOffsetDevice && (e.setFromEuler(this.alphaOffsetDevice), e.rotateZ(-this.alphaOffsetScreen), t.setFromRotationMatrix(e), t.alpha < 0 && (t.alpha += 360), t.alpha %= 360, n -= t.alpha), t.set(n, r.beta, r.gamma), e.setFromEuler(t), e } }(), getScreenAdjustedMatrix: function() { var t; return function() { return t = this.getFixedFrameMatrix(), t.rotateZ(-f), t } }(), getFixedFrameEuler: function() { var t, e = new T.Euler; return function() { return t = this.getFixedFrameMatrix(), e.setFromRotationMatrix(t), e } }(), getScreenAdjustedEuler: function() { var t, e = new T.Euler; return function() { return t = this.getScreenAdjustedMatrix(), e.setFromRotationMatrix(t), e } }(), isAbsolute: function() { return c.orientation.data && c.orientation.data.absolute === !0 ? !0 : !1 }, getLastRawEventData: function() { return c.orientation.data || {} }, ALPHA: "alpha", BETA: "beta", GAMMA: "gamma" }, T.DeviceMotion = function(t) { this.options = t || {} }, T.DeviceMotion.prototype = { constructor: T.DeviceMotion, start: function(e) { e && "[object Function]" == Object.prototype.toString.call(e) && c.motion.callbacks.push(e), p || (d ? t.screen.orientation.addEventListener("change", n, !1) : t.addEventListener("orientationchange", n, !1)), c.motion.active || (t.addEventListener("devicemotion", o, !1), c.motion.active = !0) }, stop: function() { c.motion.active && (t.removeEventListener("devicemotion", o, !1), c.motion.active = !1) }, listen: function(t) { this.start(t) }, getScreenAdjustedAcceleration: function() { var t = c.motion.data && c.motion.data.acceleration ? c.motion.data.acceleration : { x: 0, y: 0, z: 0 },
						e = {}; switch(f) {
						case v:
							e.x = -t.y, e.y = t.x; break;
						case g:
							e.x = -t.x, e.y = -t.y; break;
						case m:
						case y:
							e.x = t.y, e.y = -t.x; break;
						default:
							e.x = t.x, e.y = t.y } return e.z = t.z, e }, getScreenAdjustedAccelerationIncludingGravity: function() { var t = c.motion.data && c.motion.data.accelerationIncludingGravity ? c.motion.data.accelerationIncludingGravity : { x: 0, y: 0, z: 0 },
						e = {}; switch(f) {
						case v:
							e.x = -t.y, e.y = t.x; break;
						case g:
							e.x = -t.x, e.y = -t.y; break;
						case m:
						case y:
							e.x = t.y, e.y = -t.x; break;
						default:
							e.x = t.x, e.y = t.y } return e.z = t.z, e }, getScreenAdjustedRotationRate: function() { var t = c.motion.data && c.motion.data.rotationRate ? c.motion.data.rotationRate : { alpha: 0, beta: 0, gamma: 0 },
						e = {}; switch(f) {
						case v:
							e.beta = -t.gamma, e.gamma = t.beta; break;
						case g:
							e.beta = -t.beta, e.gamma = -t.gamma; break;
						case m:
						case y:
							e.beta = t.gamma, e.gamma = -t.beta; break;
						default:
							e.beta = t.beta, e.gamma = t.gamma } return e.alpha = t.alpha, e }, getLastRawEventData: function() { return c.motion.data || {} } }, t.FULLTILT = T } }(window), ! function(t, e) { "object" == typeof module && "object" == typeof module.exports ? module.exports = t.document ? e(t, !0) : function(t) { if(!t.document) throw new Error("jQuery requires a window with a document"); return e(t) } : e(t) }("undefined" != typeof window ? window : this, function(t, e) {
		function r(t) { var e = "length" in t && t.length,
				r = J.type(t); return "function" === r || J.isWindow(t) ? !1 : 1 === t.nodeType && e ? !0 : "array" === r || 0 === e || "number" == typeof e && e > 0 && e - 1 in t }

		function n(t, e, r) { if(J.isFunction(e)) return J.grep(t, function(t, n) { return !!e.call(t, n, t) !== r }); if(e.nodeType) return J.grep(t, function(t) { return t === e !== r }); if("string" == typeof e) { if(at.test(e)) return J.filter(e, t, r);
				e = J.filter(e, t) } return J.grep(t, function(t) { return z.call(e, t) >= 0 !== r }) }

		function i(t, e) { for(;
				(t = t[e]) && 1 !== t.nodeType;); return t }

		function o(t) { var e = ft[t] = {}; return J.each(t.match(dt) || [], function(t, r) { e[r] = !0 }), e }

		function s() { Z.removeEventListener("DOMContentLoaded", s, !1), t.removeEventListener("load", s, !1), J.ready() }

		function a() { Object.defineProperty(this.cache = {}, 0, { get: function() { return {} } }), this.expando = J.expando + a.uid++ }

		function l(t, e, r) { var n; if(void 0 === r && 1 === t.nodeType)
				if(n = "data-" + e.replace(xt, "-$1").toLowerCase(), r = t.getAttribute(n), "string" == typeof r) { try { r = "true" === r ? !0 : "false" === r ? !1 : "null" === r ? null : +r + "" === r ? +r : Tt.test(r) ? J.parseJSON(r) : r } catch(i) {} yt.set(t, e, r) } else r = void 0; return r }

		function u() { return !0 }

		function h() { return !1 }

		function c() { try { return Z.activeElement } catch(t) {} }

		function p(t, e) { return J.nodeName(t, "table") && J.nodeName(11 !== e.nodeType ? e : e.firstChild, "tr") ? t.getElementsByTagName("tbody")[0] || t.appendChild(t.ownerDocument.createElement("tbody")) : t }

		function d(t) { return t.type = (null !== t.getAttribute("type")) + "/" + t.type, t }

		function f(t) { var e = It.exec(t.type); return e ? t.type = e[1] : t.removeAttribute("type"), t }

		function v(t, e) { for(var r = 0, n = t.length; n > r; r++) mt.set(t[r], "globalEval", !e || mt.get(e[r], "globalEval")) }

		function g(t, e) { var r, n, i, o, s, a, l, u; if(1 === e.nodeType) { if(mt.hasData(t) && (o = mt.access(t), s = mt.set(e, o), u = o.events)) { delete s.handle, s.events = {}; for(i in u)
						for(r = 0, n = u[i].length; n > r; r++) J.event.add(e, i, u[i][r]) } yt.hasData(t) && (a = yt.access(t), l = J.extend({}, a), yt.set(e, l)) } }

		function m(t, e) { var r = t.getElementsByTagName ? t.getElementsByTagName(e || "*") : t.querySelectorAll ? t.querySelectorAll(e || "*") : []; return void 0 === e || e && J.nodeName(t, e) ? J.merge([t], r) : r }

		function y(t, e) { var r = e.nodeName.toLowerCase(); "input" === r && At.test(t.type) ? e.checked = t.checked : ("input" === r || "textarea" === r) && (e.defaultValue = t.defaultValue) }

		function T(e, r) { var n, i = J(r.createElement(e)).appendTo(r.body),
				o = t.getDefaultComputedStyle && (n = t.getDefaultComputedStyle(i[0])) ? n.display : J.css(i[0], "display"); return i.detach(), o }

		function x(t) { var e = Z,
				r = kt[t]; return r || (r = T(t, e), "none" !== r && r || (Ht = (Ht || J("<iframe frameborder='0' width='0' height='0'/>")).appendTo(e.documentElement), e = Ht[0].contentDocument, e.write(), e.close(), r = T(t, e), Ht.detach()), kt[t] = r), r }

		function b(t, e, r) { var n, i, o, s, a = t.style; return r = r || Xt(t), r && (s = r.getPropertyValue(e) || r[e]), r && ("" !== s || J.contains(t.ownerDocument, t) || (s = J.style(t, e)), jt.test(s) && Ut.test(e) && (n = a.width, i = a.minWidth, o = a.maxWidth, a.minWidth = a.maxWidth = a.width = s, s = r.width, a.width = n, a.minWidth = i, a.maxWidth = o)), void 0 !== s ? s + "" : s }

		function S(t, e) { return { get: function() { return t() ? void delete this.get : (this.get = e).apply(this, arguments) } } }

		function E(t, e) { if(e in t) return e; for(var r = e[0].toUpperCase() + e.slice(1), n = e, i = Kt.length; i--;)
				if(e = Kt[i] + r, e in t) return e; return n }

		function A(t, e, r) { var n = Vt.exec(e); return n ? Math.max(0, n[1] - (r || 0)) + (n[2] || "px") : e }

		function _(t, e, r, n, i) { for(var o = r === (n ? "border" : "content") ? 4 : "width" === e ? 1 : 0, s = 0; 4 > o; o += 2) "margin" === r && (s += J.css(t, r + St[o], !0, i)), n ? ("content" === r && (s -= J.css(t, "padding" + St[o], !0, i)), "margin" !== r && (s -= J.css(t, "border" + St[o] + "Width", !0, i))) : (s += J.css(t, "padding" + St[o], !0, i), "padding" !== r && (s += J.css(t, "border" + St[o] + "Width", !0, i))); return s }

		function M(t, e, r) { var n = !0,
				i = "width" === e ? t.offsetWidth : t.offsetHeight,
				o = Xt(t),
				s = "border-box" === J.css(t, "boxSizing", !1, o); if(0 >= i || null == i) { if(i = b(t, e, o), (0 > i || null == i) && (i = t.style[e]), jt.test(i)) return i;
				n = s && (Q.boxSizingReliable() || i === t.style[e]), i = parseFloat(i) || 0 } return i + _(t, e, r || (s ? "border" : "content"), n, o) + "px" }

		function w(t, e) { for(var r, n, i, o = [], s = 0, a = t.length; a > s; s++) n = t[s], n.style && (o[s] = mt.get(n, "olddisplay"), r = n.style.display, e ? (o[s] || "none" !== r || (n.style.display = ""), "" === n.style.display && Et(n) && (o[s] = mt.access(n, "olddisplay", x(n.nodeName)))) : (i = Et(n), "none" === r && i || mt.set(n, "olddisplay", i ? r : J.css(n, "display")))); for(s = 0; a > s; s++) n = t[s], n.style && (e && "none" !== n.style.display && "" !== n.style.display || (n.style.display = e ? o[s] || "" : "none")); return t }

		function C(t, e, r, n, i) { return new C.prototype.init(t, e, r, n, i) }

		function P() { return setTimeout(function() { Qt = void 0 }), Qt = J.now() }

		function R(t, e) { var r, n = 0,
				i = { height: t }; for(e = e ? 1 : 0; 4 > n; n += 2 - e) r = St[n], i["margin" + r] = i["padding" + r] = t; return e && (i.opacity = i.width = t), i }

		function D(t, e, r) { for(var n, i = (re[e] || []).concat(re["*"]), o = 0, s = i.length; s > o; o++)
				if(n = i[o].call(r, e, t)) return n }

		function B(t, e, r) { var n, i, o, s, a, l, u, h, c = this,
				p = {},
				d = t.style,
				f = t.nodeType && Et(t),
				v = mt.get(t, "fxshow");
			r.queue || (a = J._queueHooks(t, "fx"), null == a.unqueued && (a.unqueued = 0, l = a.empty.fire, a.empty.fire = function() { a.unqueued || l() }), a.unqueued++, c.always(function() { c.always(function() { a.unqueued--, J.queue(t, "fx").length || a.empty.fire() }) })), 1 === t.nodeType && ("height" in e || "width" in e) && (r.overflow = [d.overflow, d.overflowX, d.overflowY], u = J.css(t, "display"), h = "none" === u ? mt.get(t, "olddisplay") || x(t.nodeName) : u, "inline" === h && "none" === J.css(t, "float") && (d.display = "inline-block")), r.overflow && (d.overflow = "hidden", c.always(function() { d.overflow = r.overflow[0], d.overflowX = r.overflow[1], d.overflowY = r.overflow[2] })); for(n in e)
				if(i = e[n], $t.exec(i)) { if(delete e[n], o = o || "toggle" === i, i === (f ? "hide" : "show")) { if("show" !== i || !v || void 0 === v[n]) continue;
						f = !0 } p[n] = v && v[n] || J.style(t, n) } else u = void 0; if(J.isEmptyObject(p)) "inline" === ("none" === u ? x(t.nodeName) : u) && (d.display = u);
			else { v ? "hidden" in v && (f = v.hidden) : v = mt.access(t, "fxshow", {}), o && (v.hidden = !f), f ? J(t).show() : c.done(function() { J(t).hide() }), c.done(function() { var e;
					mt.remove(t, "fxshow"); for(e in p) J.style(t, e, p[e]) }); for(n in p) s = D(f ? v[n] : 0, n, c), n in v || (v[n] = s.start, f && (s.end = s.start, s.start = "width" === n || "height" === n ? 1 : 0)) } }

		function O(t, e) { var r, n, i, o, s; for(r in t)
				if(n = J.camelCase(r), i = e[n], o = t[r], J.isArray(o) && (i = o[1], o = t[r] = o[0]), r !== n && (t[n] = o, delete t[r]), s = J.cssHooks[n], s && "expand" in s) { o = s.expand(o), delete t[n]; for(r in o) r in t || (t[r] = o[r], e[r] = i) } else e[n] = i }

		function F(t, e, r) { var n, i, o = 0,
				s = ee.length,
				a = J.Deferred().always(function() { delete l.elem }),
				l = function() { if(i) return !1; for(var e = Qt || P(), r = Math.max(0, u.startTime + u.duration - e), n = r / u.duration || 0, o = 1 - n, s = 0, l = u.tweens.length; l > s; s++) u.tweens[s].run(o); return a.notifyWith(t, [u, o, r]), 1 > o && l ? r : (a.resolveWith(t, [u]), !1) },
				u = a.promise({ elem: t, props: J.extend({}, e), opts: J.extend(!0, { specialEasing: {} }, r), originalProperties: e, originalOptions: r, startTime: Qt || P(), duration: r.duration, tweens: [], createTween: function(e, r) { var n = J.Tween(t, u.opts, e, r, u.opts.specialEasing[e] || u.opts.easing); return u.tweens.push(n), n }, stop: function(e) { var r = 0,
							n = e ? u.tweens.length : 0; if(i) return this; for(i = !0; n > r; r++) u.tweens[r].run(1); return e ? a.resolveWith(t, [u, e]) : a.rejectWith(t, [u, e]), this } }),
				h = u.props; for(O(h, u.opts.specialEasing); s > o; o++)
				if(n = ee[o].call(u, t, h, u.opts)) return n; return J.map(h, D, u), J.isFunction(u.opts.start) && u.opts.start.call(t, u), J.fx.timer(J.extend(l, { elem: t, anim: u, queue: u.opts.queue })), u.progress(u.opts.progress).done(u.opts.done, u.opts.complete).fail(u.opts.fail).always(u.opts.always) }

		function L(t) { return function(e, r) { "string" != typeof e && (r = e, e = "*"); var n, i = 0,
					o = e.toLowerCase().match(dt) || []; if(J.isFunction(r))
					for(; n = o[i++];) "+" === n[0] ? (n = n.slice(1) || "*", (t[n] = t[n] || []).unshift(r)) : (t[n] = t[n] || []).push(r) } }

		function I(t, e, r, n) {
			function i(a) { var l; return o[a] = !0, J.each(t[a] || [], function(t, a) { var u = a(e, r, n); return "string" != typeof u || s || o[u] ? s ? !(l = u) : void 0 : (e.dataTypes.unshift(u), i(u), !1) }), l } var o = {},
				s = t === Te; return i(e.dataTypes[0]) || !o["*"] && i("*") }

		function G(t, e) { var r, n, i = J.ajaxSettings.flatOptions || {}; for(r in e) void 0 !== e[r] && ((i[r] ? t : n || (n = {}))[r] = e[r]); return n && J.extend(!0, t, n), t }

		function N(t, e, r) { for(var n, i, o, s, a = t.contents, l = t.dataTypes;
				"*" === l[0];) l.shift(), void 0 === n && (n = t.mimeType || e.getResponseHeader("Content-Type")); if(n)
				for(i in a)
					if(a[i] && a[i].test(n)) { l.unshift(i); break }
			if(l[0] in r) o = l[0];
			else { for(i in r) { if(!l[0] || t.converters[i + " " + l[0]]) { o = i; break } s || (s = i) } o = o || s } return o ? (o !== l[0] && l.unshift(o), r[o]) : void 0 }

		function H(t, e, r, n) { var i, o, s, a, l, u = {},
				h = t.dataTypes.slice(); if(h[1])
				for(s in t.converters) u[s.toLowerCase()] = t.converters[s]; for(o = h.shift(); o;)
				if(t.responseFields[o] && (r[t.responseFields[o]] = e), !l && n && t.dataFilter && (e = t.dataFilter(e, t.dataType)), l = o, o = h.shift())
					if("*" === o) o = l;
					else if("*" !== l && l !== o) { if(s = u[l + " " + o] || u["* " + o], !s)
					for(i in u)
						if(a = i.split(" "), a[1] === o && (s = u[l + " " + a[0]] || u["* " + a[0]])) { s === !0 ? s = u[i] : u[i] !== !0 && (o = a[0], h.unshift(a[1])); break }
				if(s !== !0)
					if(s && t["throws"]) e = s(e);
					else try { e = s(e) } catch(c) { return { state: "parsererror", error: s ? c : "No conversion from " + l + " to " + o } } } return { state: "success", data: e } }

		function k(t, e, r, n) { var i; if(J.isArray(e)) J.each(e, function(e, i) { r || Ae.test(t) ? n(t, i) : k(t + "[" + ("object" == typeof i ? e : "") + "]", i, r, n) });
			else if(r || "object" !== J.type(e)) n(t, e);
			else
				for(i in e) k(t + "[" + i + "]", e[i], r, n) }

		function U(t) { return J.isWindow(t) ? t : 9 === t.nodeType && t.defaultView }
		var j = [],
			X = j.slice,
			W = j.concat,
			V = j.push,
			z = j.indexOf,
			Y = {},
			q = Y.toString,
			K = Y.hasOwnProperty,
			Q = {},
			Z = t.document,
			$ = "2.1.4",
			J = function(t, e) { return new J.fn.init(t, e) },
			tt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
			et = /^-ms-/,
			rt = /-([\da-z])/gi,
			nt = function(t, e) { return e.toUpperCase() };
		J.fn = J.prototype = { jquery: $, constructor: J, selector: "", length: 0, toArray: function() { return X.call(this) }, get: function(t) { return null != t ? 0 > t ? this[t + this.length] : this[t] : X.call(this) }, pushStack: function(t) { var e = J.merge(this.constructor(), t); return e.prevObject = this, e.context = this.context, e }, each: function(t, e) { return J.each(this, t, e) }, map: function(t) { return this.pushStack(J.map(this, function(e, r) { return t.call(e, r, e) })) }, slice: function() { return this.pushStack(X.apply(this, arguments)) }, first: function() { return this.eq(0) }, last: function() { return this.eq(-1) }, eq: function(t) { var e = this.length,
					r = +t + (0 > t ? e : 0); return this.pushStack(r >= 0 && e > r ? [this[r]] : []) }, end: function() { return this.prevObject || this.constructor(null) }, push: V, sort: j.sort, splice: j.splice }, J.extend = J.fn.extend = function() { var t, e, r, n, i, o, s = arguments[0] || {},
				a = 1,
				l = arguments.length,
				u = !1; for("boolean" == typeof s && (u = s, s = arguments[a] || {}, a++), "object" == typeof s || J.isFunction(s) || (s = {}), a === l && (s = this, a--); l > a; a++)
				if(null != (t = arguments[a]))
					for(e in t) r = s[e], n = t[e], s !== n && (u && n && (J.isPlainObject(n) || (i = J.isArray(n))) ? (i ? (i = !1, o = r && J.isArray(r) ? r : []) : o = r && J.isPlainObject(r) ? r : {}, s[e] = J.extend(u, o, n)) : void 0 !== n && (s[e] = n)); return s }, J.extend({
			expando: "jQuery" + ($ + Math.random()).replace(/\D/g, ""),
			isReady: !0,
			error: function(t) { throw new Error(t) },
			noop: function() {},
			isFunction: function(t) { return "function" === J.type(t) },
			isArray: Array.isArray,
			isWindow: function(t) { return null != t && t === t.window },
			isNumeric: function(t) { return !J.isArray(t) && t - parseFloat(t) + 1 >= 0 },
			isPlainObject: function(t) { return "object" !== J.type(t) || t.nodeType || J.isWindow(t) ? !1 : t.constructor && !K.call(t.constructor.prototype, "isPrototypeOf") ? !1 : !0 },
			isEmptyObject: function(t) { var e; for(e in t) return !1; return !0 },
			type: function(t) { return null == t ? t + "" : "object" == typeof t || "function" == typeof t ? Y[q.call(t)] || "object" : typeof t },
			globalEval: function(t) { var e, r = eval;
				t = J.trim(t), t && (1 === t.indexOf("use strict") ? (e = Z.createElement("script"), e.text = t, Z.head.appendChild(e).parentNode.removeChild(e)) : r(t)) },
			camelCase: function(t) { return t.replace(et, "ms-").replace(rt, nt) },
			nodeName: function(t, e) { return t.nodeName && t.nodeName.toLowerCase() === e.toLowerCase() },
			each: function(t, e, n) { var i, o = 0,
					s = t.length,
					a = r(t); if(n) { if(a)
						for(; s > o && (i = e.apply(t[o], n), i !== !1); o++);
					else
						for(o in t)
							if(i = e.apply(t[o], n), i === !1) break } else if(a)
					for(; s > o && (i = e.call(t[o], o, t[o]), i !== !1); o++);
				else
					for(o in t)
						if(i = e.call(t[o], o, t[o]), i === !1) break; return t },
			trim: function(t) { return null == t ? "" : (t + "").replace(tt, "") },
			makeArray: function(t, e) { var n = e || []; return null != t && (r(Object(t)) ? J.merge(n, "string" == typeof t ? [t] : t) : V.call(n, t)), n },
			inArray: function(t, e, r) { return null == e ? -1 : z.call(e, t, r) },
			merge: function(t, e) { for(var r = +e.length, n = 0, i = t.length; r > n; n++) t[i++] = e[n]; return t.length = i, t },
			grep: function(t, e, r) { for(var n, i = [], o = 0, s = t.length, a = !r; s > o; o++) n = !e(t[o], o), n !== a && i.push(t[o]); return i },
			map: function(t, e, n) { var i, o = 0,
					s = t.length,
					a = r(t),
					l = []; if(a)
					for(; s > o; o++) i = e(t[o], o, n), null != i && l.push(i);
				else
					for(o in t) i = e(t[o], o, n), null != i && l.push(i); return W.apply([], l) },
			guid: 1,
			proxy: function(t, e) {
				var r, n, i;
				return "string" == typeof e && (r = t[e],
					e = t, t = r), J.isFunction(t) ? (n = X.call(arguments, 2), i = function() { return t.apply(e || this, n.concat(X.call(arguments))) }, i.guid = t.guid = t.guid || J.guid++, i) : void 0
			},
			now: Date.now,
			support: Q
		}), J.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function(t, e) { Y["[object " + e + "]"] = e.toLowerCase() });
		var it = function(t) {
			function e(t, e, r, n) { var i, o, s, a, l, u, c, d, f, v; if((e ? e.ownerDocument || e : k) !== B && D(e), e = e || B, r = r || [], a = e.nodeType, "string" != typeof t || !t || 1 !== a && 9 !== a && 11 !== a) return r; if(!n && F) { if(11 !== a && (i = yt.exec(t)))
						if(s = i[1]) { if(9 === a) { if(o = e.getElementById(s), !o || !o.parentNode) return r; if(o.id === s) return r.push(o), r } else if(e.ownerDocument && (o = e.ownerDocument.getElementById(s)) && N(e, o) && o.id === s) return r.push(o), r } else { if(i[2]) return $.apply(r, e.getElementsByTagName(t)), r; if((s = i[3]) && b.getElementsByClassName) return $.apply(r, e.getElementsByClassName(s)), r }
					if(b.qsa && (!L || !L.test(t))) { if(d = c = H, f = e, v = 1 !== a && t, 1 === a && "object" !== e.nodeName.toLowerCase()) { for(u = _(t), (c = e.getAttribute("id")) ? d = c.replace(xt, "\\$&") : e.setAttribute("id", d), d = "[id='" + d + "'] ", l = u.length; l--;) u[l] = d + p(u[l]);
							f = Tt.test(t) && h(e.parentNode) || e, v = u.join(",") } if(v) try { return $.apply(r, f.querySelectorAll(v)), r } catch(g) {} finally { c || e.removeAttribute("id") } } } return w(t.replace(lt, "$1"), e, r, n) }

			function r() {
				function t(r, n) { return e.push(r + " ") > S.cacheLength && delete t[e.shift()], t[r + " "] = n } var e = []; return t }

			function n(t) { return t[H] = !0, t }

			function i(t) { var e = B.createElement("div"); try { return !!t(e) } catch(r) { return !1 } finally { e.parentNode && e.parentNode.removeChild(e), e = null } }

			function o(t, e) { for(var r = t.split("|"), n = t.length; n--;) S.attrHandle[r[n]] = e }

			function s(t, e) { var r = e && t,
					n = r && 1 === t.nodeType && 1 === e.nodeType && (~e.sourceIndex || Y) - (~t.sourceIndex || Y); if(n) return n; if(r)
					for(; r = r.nextSibling;)
						if(r === e) return -1; return t ? 1 : -1 }

			function a(t) { return function(e) { var r = e.nodeName.toLowerCase(); return "input" === r && e.type === t } }

			function l(t) { return function(e) { var r = e.nodeName.toLowerCase(); return("input" === r || "button" === r) && e.type === t } }

			function u(t) { return n(function(e) { return e = +e, n(function(r, n) { for(var i, o = t([], r.length, e), s = o.length; s--;) r[i = o[s]] && (r[i] = !(n[i] = r[i])) }) }) }

			function h(t) { return t && "undefined" != typeof t.getElementsByTagName && t }

			function c() {}

			function p(t) { for(var e = 0, r = t.length, n = ""; r > e; e++) n += t[e].value; return n }

			function d(t, e, r) { var n = e.dir,
					i = r && "parentNode" === n,
					o = j++; return e.first ? function(e, r, o) { for(; e = e[n];)
						if(1 === e.nodeType || i) return t(e, r, o) } : function(e, r, s) { var a, l, u = [U, o]; if(s) { for(; e = e[n];)
							if((1 === e.nodeType || i) && t(e, r, s)) return !0 } else
						for(; e = e[n];)
							if(1 === e.nodeType || i) { if(l = e[H] || (e[H] = {}), (a = l[n]) && a[0] === U && a[1] === o) return u[2] = a[2]; if(l[n] = u, u[2] = t(e, r, s)) return !0 } } }

			function f(t) { return t.length > 1 ? function(e, r, n) { for(var i = t.length; i--;)
						if(!t[i](e, r, n)) return !1; return !0 } : t[0] }

			function v(t, r, n) { for(var i = 0, o = r.length; o > i; i++) e(t, r[i], n); return n }

			function g(t, e, r, n, i) { for(var o, s = [], a = 0, l = t.length, u = null != e; l > a; a++)(o = t[a]) && (!r || r(o, n, i)) && (s.push(o), u && e.push(a)); return s }

			function m(t, e, r, i, o, s) { return i && !i[H] && (i = m(i)), o && !o[H] && (o = m(o, s)), n(function(n, s, a, l) { var u, h, c, p = [],
						d = [],
						f = s.length,
						m = n || v(e || "*", a.nodeType ? [a] : a, []),
						y = !t || !n && e ? m : g(m, p, t, a, l),
						T = r ? o || (n ? t : f || i) ? [] : s : y; if(r && r(y, T, a, l), i)
						for(u = g(T, d), i(u, [], a, l), h = u.length; h--;)(c = u[h]) && (T[d[h]] = !(y[d[h]] = c)); if(n) { if(o || t) { if(o) { for(u = [], h = T.length; h--;)(c = T[h]) && u.push(y[h] = c);
								o(null, T = [], u, l) } for(h = T.length; h--;)(c = T[h]) && (u = o ? tt(n, c) : p[h]) > -1 && (n[u] = !(s[u] = c)) } } else T = g(T === s ? T.splice(f, T.length) : T), o ? o(null, s, T, l) : $.apply(s, T) }) }

			function y(t) { for(var e, r, n, i = t.length, o = S.relative[t[0].type], s = o || S.relative[" "], a = o ? 1 : 0, l = d(function(t) { return t === e }, s, !0), u = d(function(t) { return tt(e, t) > -1 }, s, !0), h = [function(t, r, n) { var i = !o && (n || r !== C) || ((e = r).nodeType ? l(t, r, n) : u(t, r, n)); return e = null, i }]; i > a; a++)
					if(r = S.relative[t[a].type]) h = [d(f(h), r)];
					else { if(r = S.filter[t[a].type].apply(null, t[a].matches), r[H]) { for(n = ++a; i > n && !S.relative[t[n].type]; n++); return m(a > 1 && f(h), a > 1 && p(t.slice(0, a - 1).concat({ value: " " === t[a - 2].type ? "*" : "" })).replace(lt, "$1"), r, n > a && y(t.slice(a, n)), i > n && y(t = t.slice(n)), i > n && p(t)) } h.push(r) }
				return f(h) }

			function T(t, r) { var i = r.length > 0,
					o = t.length > 0,
					s = function(n, s, a, l, u) { var h, c, p, d = 0,
							f = "0",
							v = n && [],
							m = [],
							y = C,
							T = n || o && S.find.TAG("*", u),
							x = U += null == y ? 1 : Math.random() || .1,
							b = T.length; for(u && (C = s !== B && s); f !== b && null != (h = T[f]); f++) { if(o && h) { for(c = 0; p = t[c++];)
									if(p(h, s, a)) { l.push(h); break }
								u && (U = x) } i && ((h = !p && h) && d--, n && v.push(h)) } if(d += f, i && f !== d) { for(c = 0; p = r[c++];) p(v, m, s, a); if(n) { if(d > 0)
									for(; f--;) v[f] || m[f] || (m[f] = Q.call(l));
								m = g(m) } $.apply(l, m), u && !n && m.length > 0 && d + r.length > 1 && e.uniqueSort(l) } return u && (U = x, C = y), v }; return i ? n(s) : s } var x, b, S, E, A, _, M, w, C, P, R, D, B, O, F, L, I, G, N, H = "sizzle" + 1 * new Date,
				k = t.document,
				U = 0,
				j = 0,
				X = r(),
				W = r(),
				V = r(),
				z = function(t, e) { return t === e && (R = !0), 0 },
				Y = 1 << 31,
				q = {}.hasOwnProperty,
				K = [],
				Q = K.pop,
				Z = K.push,
				$ = K.push,
				J = K.slice,
				tt = function(t, e) { for(var r = 0, n = t.length; n > r; r++)
						if(t[r] === e) return r; return -1 },
				et = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
				rt = "[\\x20\\t\\r\\n\\f]",
				nt = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
				it = nt.replace("w", "w#"),
				ot = "\\[" + rt + "*(" + nt + ")(?:" + rt + "*([*^$|!~]?=)" + rt + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + it + "))|)" + rt + "*\\]",
				st = ":(" + nt + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + ot + ")*)|.*)\\)|)",
				at = new RegExp(rt + "+", "g"),
				lt = new RegExp("^" + rt + "+|((?:^|[^\\\\])(?:\\\\.)*)" + rt + "+$", "g"),
				ut = new RegExp("^" + rt + "*," + rt + "*"),
				ht = new RegExp("^" + rt + "*([>+~]|" + rt + ")" + rt + "*"),
				ct = new RegExp("=" + rt + "*([^\\]'\"]*?)" + rt + "*\\]", "g"),
				pt = new RegExp(st),
				dt = new RegExp("^" + it + "$"),
				ft = { ID: new RegExp("^#(" + nt + ")"), CLASS: new RegExp("^\\.(" + nt + ")"), TAG: new RegExp("^(" + nt.replace("w", "w*") + ")"), ATTR: new RegExp("^" + ot), PSEUDO: new RegExp("^" + st), CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + rt + "*(even|odd|(([+-]|)(\\d*)n|)" + rt + "*(?:([+-]|)" + rt + "*(\\d+)|))" + rt + "*\\)|)", "i"), bool: new RegExp("^(?:" + et + ")$", "i"), needsContext: new RegExp("^" + rt + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + rt + "*((?:-\\d)?\\d*)" + rt + "*\\)|)(?=[^-]|$)", "i") },
				vt = /^(?:input|select|textarea|button)$/i,
				gt = /^h\d$/i,
				mt = /^[^{]+\{\s*\[native \w/,
				yt = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
				Tt = /[+~]/,
				xt = /'|\\/g,
				bt = new RegExp("\\\\([\\da-f]{1,6}" + rt + "?|(" + rt + ")|.)", "ig"),
				St = function(t, e, r) { var n = "0x" + e - 65536; return n !== n || r ? e : 0 > n ? String.fromCharCode(n + 65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320) },
				Et = function() { D() }; try { $.apply(K = J.call(k.childNodes), k.childNodes), K[k.childNodes.length].nodeType } catch(At) { $ = { apply: K.length ? function(t, e) { Z.apply(t, J.call(e)) } : function(t, e) { for(var r = t.length, n = 0; t[r++] = e[n++];);
						t.length = r - 1 } } } b = e.support = {}, A = e.isXML = function(t) { var e = t && (t.ownerDocument || t).documentElement; return e ? "HTML" !== e.nodeName : !1 }, D = e.setDocument = function(t) { var e, r, n = t ? t.ownerDocument || t : k; return n !== B && 9 === n.nodeType && n.documentElement ? (B = n, O = n.documentElement, r = n.defaultView, r && r !== r.top && (r.addEventListener ? r.addEventListener("unload", Et, !1) : r.attachEvent && r.attachEvent("onunload", Et)), F = !A(n), b.attributes = i(function(t) { return t.className = "i", !t.getAttribute("className") }), b.getElementsByTagName = i(function(t) { return t.appendChild(n.createComment("")), !t.getElementsByTagName("*").length }), b.getElementsByClassName = mt.test(n.getElementsByClassName), b.getById = i(function(t) { return O.appendChild(t).id = H, !n.getElementsByName || !n.getElementsByName(H).length }), b.getById ? (S.find.ID = function(t, e) { if("undefined" != typeof e.getElementById && F) { var r = e.getElementById(t); return r && r.parentNode ? [r] : [] } }, S.filter.ID = function(t) { var e = t.replace(bt, St); return function(t) { return t.getAttribute("id") === e } }) : (delete S.find.ID, S.filter.ID = function(t) { var e = t.replace(bt, St); return function(t) { var r = "undefined" != typeof t.getAttributeNode && t.getAttributeNode("id"); return r && r.value === e } }), S.find.TAG = b.getElementsByTagName ? function(t, e) { return "undefined" != typeof e.getElementsByTagName ? e.getElementsByTagName(t) : b.qsa ? e.querySelectorAll(t) : void 0 } : function(t, e) { var r, n = [],
						i = 0,
						o = e.getElementsByTagName(t); if("*" === t) { for(; r = o[i++];) 1 === r.nodeType && n.push(r); return n } return o }, S.find.CLASS = b.getElementsByClassName && function(t, e) { return F ? e.getElementsByClassName(t) : void 0 }, I = [], L = [], (b.qsa = mt.test(n.querySelectorAll)) && (i(function(t) { O.appendChild(t).innerHTML = "<a id='" + H + "'></a><select id='" + H + "-\f]' msallowcapture=''><option selected=''></option></select>", t.querySelectorAll("[msallowcapture^='']").length && L.push("[*^$]=" + rt + "*(?:''|\"\")"), t.querySelectorAll("[selected]").length || L.push("\\[" + rt + "*(?:value|" + et + ")"), t.querySelectorAll("[id~=" + H + "-]").length || L.push("~="), t.querySelectorAll(":checked").length || L.push(":checked"), t.querySelectorAll("a#" + H + "+*").length || L.push(".#.+[+~]") }), i(function(t) { var e = n.createElement("input");
					e.setAttribute("type", "hidden"), t.appendChild(e).setAttribute("name", "D"), t.querySelectorAll("[name=d]").length && L.push("name" + rt + "*[*^$|!~]?="), t.querySelectorAll(":enabled").length || L.push(":enabled", ":disabled"), t.querySelectorAll("*,:x"), L.push(",.*:") })), (b.matchesSelector = mt.test(G = O.matches || O.webkitMatchesSelector || O.mozMatchesSelector || O.oMatchesSelector || O.msMatchesSelector)) && i(function(t) { b.disconnectedMatch = G.call(t, "div"), G.call(t, "[s!='']:x"), I.push("!=", st) }), L = L.length && new RegExp(L.join("|")), I = I.length && new RegExp(I.join("|")), e = mt.test(O.compareDocumentPosition), N = e || mt.test(O.contains) ? function(t, e) { var r = 9 === t.nodeType ? t.documentElement : t,
						n = e && e.parentNode; return t === n || !(!n || 1 !== n.nodeType || !(r.contains ? r.contains(n) : t.compareDocumentPosition && 16 & t.compareDocumentPosition(n))) } : function(t, e) { if(e)
						for(; e = e.parentNode;)
							if(e === t) return !0; return !1 }, z = e ? function(t, e) { if(t === e) return R = !0, 0; var r = !t.compareDocumentPosition - !e.compareDocumentPosition; return r ? r : (r = (t.ownerDocument || t) === (e.ownerDocument || e) ? t.compareDocumentPosition(e) : 1, 1 & r || !b.sortDetached && e.compareDocumentPosition(t) === r ? t === n || t.ownerDocument === k && N(k, t) ? -1 : e === n || e.ownerDocument === k && N(k, e) ? 1 : P ? tt(P, t) - tt(P, e) : 0 : 4 & r ? -1 : 1) } : function(t, e) { if(t === e) return R = !0, 0; var r, i = 0,
						o = t.parentNode,
						a = e.parentNode,
						l = [t],
						u = [e]; if(!o || !a) return t === n ? -1 : e === n ? 1 : o ? -1 : a ? 1 : P ? tt(P, t) - tt(P, e) : 0; if(o === a) return s(t, e); for(r = t; r = r.parentNode;) l.unshift(r); for(r = e; r = r.parentNode;) u.unshift(r); for(; l[i] === u[i];) i++; return i ? s(l[i], u[i]) : l[i] === k ? -1 : u[i] === k ? 1 : 0 }, n) : B }, e.matches = function(t, r) { return e(t, null, null, r) }, e.matchesSelector = function(t, r) { if((t.ownerDocument || t) !== B && D(t), r = r.replace(ct, "='$1']"), !(!b.matchesSelector || !F || I && I.test(r) || L && L.test(r))) try { var n = G.call(t, r); if(n || b.disconnectedMatch || t.document && 11 !== t.document.nodeType) return n } catch(i) {}
				return e(r, B, null, [t]).length > 0 }, e.contains = function(t, e) { return(t.ownerDocument || t) !== B && D(t), N(t, e) }, e.attr = function(t, e) {
				(t.ownerDocument || t) !== B && D(t); var r = S.attrHandle[e.toLowerCase()],
					n = r && q.call(S.attrHandle, e.toLowerCase()) ? r(t, e, !F) : void 0; return void 0 !== n ? n : b.attributes || !F ? t.getAttribute(e) : (n = t.getAttributeNode(e)) && n.specified ? n.value : null }, e.error = function(t) { throw new Error("Syntax error, unrecognized expression: " + t) }, e.uniqueSort = function(t) { var e, r = [],
					n = 0,
					i = 0; if(R = !b.detectDuplicates, P = !b.sortStable && t.slice(0), t.sort(z), R) { for(; e = t[i++];) e === t[i] && (n = r.push(i)); for(; n--;) t.splice(r[n], 1) } return P = null, t }, E = e.getText = function(t) { var e, r = "",
					n = 0,
					i = t.nodeType; if(i) { if(1 === i || 9 === i || 11 === i) { if("string" == typeof t.textContent) return t.textContent; for(t = t.firstChild; t; t = t.nextSibling) r += E(t) } else if(3 === i || 4 === i) return t.nodeValue } else
					for(; e = t[n++];) r += E(e); return r }, S = e.selectors = { cacheLength: 50, createPseudo: n, match: ft, attrHandle: {}, find: {}, relative: { ">": { dir: "parentNode", first: !0 }, " ": { dir: "parentNode" }, "+": { dir: "previousSibling", first: !0 }, "~": { dir: "previousSibling" } }, preFilter: { ATTR: function(t) { return t[1] = t[1].replace(bt, St), t[3] = (t[3] || t[4] || t[5] || "").replace(bt, St), "~=" === t[2] && (t[3] = " " + t[3] + " "), t.slice(0, 4) }, CHILD: function(t) { return t[1] = t[1].toLowerCase(), "nth" === t[1].slice(0, 3) ? (t[3] || e.error(t[0]), t[4] = +(t[4] ? t[5] + (t[6] || 1) : 2 * ("even" === t[3] || "odd" === t[3])), t[5] = +(t[7] + t[8] || "odd" === t[3])) : t[3] && e.error(t[0]), t }, PSEUDO: function(t) { var e, r = !t[6] && t[2]; return ft.CHILD.test(t[0]) ? null : (t[3] ? t[2] = t[4] || t[5] || "" : r && pt.test(r) && (e = _(r, !0)) && (e = r.indexOf(")", r.length - e) - r.length) && (t[0] = t[0].slice(0, e), t[2] = r.slice(0, e)), t.slice(0, 3)) } }, filter: { TAG: function(t) { var e = t.replace(bt, St).toLowerCase(); return "*" === t ? function() { return !0 } : function(t) { return t.nodeName && t.nodeName.toLowerCase() === e } }, CLASS: function(t) { var e = X[t + " "]; return e || (e = new RegExp("(^|" + rt + ")" + t + "(" + rt + "|$)")) && X(t, function(t) { return e.test("string" == typeof t.className && t.className || "undefined" != typeof t.getAttribute && t.getAttribute("class") || "") }) }, ATTR: function(t, r, n) { return function(i) { var o = e.attr(i, t); return null == o ? "!=" === r : r ? (o += "", "=" === r ? o === n : "!=" === r ? o !== n : "^=" === r ? n && 0 === o.indexOf(n) : "*=" === r ? n && o.indexOf(n) > -1 : "$=" === r ? n && o.slice(-n.length) === n : "~=" === r ? (" " + o.replace(at, " ") + " ").indexOf(n) > -1 : "|=" === r ? o === n || o.slice(0, n.length + 1) === n + "-" : !1) : !0 } }, CHILD: function(t, e, r, n, i) { var o = "nth" !== t.slice(0, 3),
							s = "last" !== t.slice(-4),
							a = "of-type" === e; return 1 === n && 0 === i ? function(t) { return !!t.parentNode } : function(e, r, l) { var u, h, c, p, d, f, v = o !== s ? "nextSibling" : "previousSibling",
								g = e.parentNode,
								m = a && e.nodeName.toLowerCase(),
								y = !l && !a; if(g) { if(o) { for(; v;) { for(c = e; c = c[v];)
											if(a ? c.nodeName.toLowerCase() === m : 1 === c.nodeType) return !1;
										f = v = "only" === t && !f && "nextSibling" } return !0 } if(f = [s ? g.firstChild : g.lastChild], s && y) { for(h = g[H] || (g[H] = {}), u = h[t] || [], d = u[0] === U && u[1], p = u[0] === U && u[2], c = d && g.childNodes[d]; c = ++d && c && c[v] || (p = d = 0) || f.pop();)
										if(1 === c.nodeType && ++p && c === e) { h[t] = [U, d, p]; break } } else if(y && (u = (e[H] || (e[H] = {}))[t]) && u[0] === U) p = u[1];
								else
									for(;
										(c = ++d && c && c[v] || (p = d = 0) || f.pop()) && ((a ? c.nodeName.toLowerCase() !== m : 1 !== c.nodeType) || !++p || (y && ((c[H] || (c[H] = {}))[t] = [U, p]), c !== e));); return p -= i, p === n || p % n === 0 && p / n >= 0 } } }, PSEUDO: function(t, r) { var i, o = S.pseudos[t] || S.setFilters[t.toLowerCase()] || e.error("unsupported pseudo: " + t); return o[H] ? o(r) : o.length > 1 ? (i = [t, t, "", r], S.setFilters.hasOwnProperty(t.toLowerCase()) ? n(function(t, e) { for(var n, i = o(t, r), s = i.length; s--;) n = tt(t, i[s]), t[n] = !(e[n] = i[s]) }) : function(t) { return o(t, 0, i) }) : o } }, pseudos: { not: n(function(t) { var e = [],
							r = [],
							i = M(t.replace(lt, "$1")); return i[H] ? n(function(t, e, r, n) { for(var o, s = i(t, null, n, []), a = t.length; a--;)(o = s[a]) && (t[a] = !(e[a] = o)) }) : function(t, n, o) { return e[0] = t, i(e, null, o, r), e[0] = null, !r.pop() } }), has: n(function(t) { return function(r) { return e(t, r).length > 0 } }), contains: n(function(t) { return t = t.replace(bt, St),
							function(e) { return(e.textContent || e.innerText || E(e)).indexOf(t) > -1 } }), lang: n(function(t) { return dt.test(t || "") || e.error("unsupported lang: " + t), t = t.replace(bt, St).toLowerCase(),
							function(e) { var r;
								do
									if(r = F ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return r = r.toLowerCase(), r === t || 0 === r.indexOf(t + "-"); while ((e = e.parentNode) && 1 === e.nodeType); return !1 } }), target: function(e) { var r = t.location && t.location.hash; return r && r.slice(1) === e.id }, root: function(t) { return t === O }, focus: function(t) { return t === B.activeElement && (!B.hasFocus || B.hasFocus()) && !!(t.type || t.href || ~t.tabIndex) }, enabled: function(t) { return t.disabled === !1 }, disabled: function(t) { return t.disabled === !0 }, checked: function(t) { var e = t.nodeName.toLowerCase(); return "input" === e && !!t.checked || "option" === e && !!t.selected }, selected: function(t) { return t.parentNode && t.parentNode.selectedIndex, t.selected === !0 }, empty: function(t) { for(t = t.firstChild; t; t = t.nextSibling)
							if(t.nodeType < 6) return !1; return !0 }, parent: function(t) { return !S.pseudos.empty(t) }, header: function(t) { return gt.test(t.nodeName) }, input: function(t) { return vt.test(t.nodeName) }, button: function(t) { var e = t.nodeName.toLowerCase(); return "input" === e && "button" === t.type || "button" === e }, text: function(t) { var e; return "input" === t.nodeName.toLowerCase() && "text" === t.type && (null == (e = t.getAttribute("type")) || "text" === e.toLowerCase()) }, first: u(function() { return [0] }), last: u(function(t, e) { return [e - 1] }), eq: u(function(t, e, r) { return [0 > r ? r + e : r] }), even: u(function(t, e) { for(var r = 0; e > r; r += 2) t.push(r); return t }), odd: u(function(t, e) { for(var r = 1; e > r; r += 2) t.push(r); return t }), lt: u(function(t, e, r) { for(var n = 0 > r ? r + e : r; --n >= 0;) t.push(n); return t }), gt: u(function(t, e, r) { for(var n = 0 > r ? r + e : r; ++n < e;) t.push(n); return t }) } }, S.pseudos.nth = S.pseudos.eq; for(x in { radio: !0, checkbox: !0, file: !0, password: !0, image: !0 }) S.pseudos[x] = a(x); for(x in { submit: !0, reset: !0 }) S.pseudos[x] = l(x); return c.prototype = S.filters = S.pseudos, S.setFilters = new c, _ = e.tokenize = function(t, r) { var n, i, o, s, a, l, u, h = W[t + " "]; if(h) return r ? 0 : h.slice(0); for(a = t, l = [], u = S.preFilter; a;) {
					(!n || (i = ut.exec(a))) && (i && (a = a.slice(i[0].length) || a), l.push(o = [])), n = !1, (i = ht.exec(a)) && (n = i.shift(), o.push({ value: n, type: i[0].replace(lt, " ") }), a = a.slice(n.length)); for(s in S.filter) !(i = ft[s].exec(a)) || u[s] && !(i = u[s](i)) || (n = i.shift(), o.push({ value: n, type: s, matches: i }), a = a.slice(n.length)); if(!n) break } return r ? a.length : a ? e.error(t) : W(t, l).slice(0) }, M = e.compile = function(t, e) { var r, n = [],
					i = [],
					o = V[t + " "]; if(!o) { for(e || (e = _(t)), r = e.length; r--;) o = y(e[r]), o[H] ? n.push(o) : i.push(o);
					o = V(t, T(i, n)), o.selector = t } return o }, w = e.select = function(t, e, r, n) { var i, o, s, a, l, u = "function" == typeof t && t,
					c = !n && _(t = u.selector || t); if(r = r || [], 1 === c.length) { if(o = c[0] = c[0].slice(0), o.length > 2 && "ID" === (s = o[0]).type && b.getById && 9 === e.nodeType && F && S.relative[o[1].type]) { if(e = (S.find.ID(s.matches[0].replace(bt, St), e) || [])[0], !e) return r;
						u && (e = e.parentNode), t = t.slice(o.shift().value.length) } for(i = ft.needsContext.test(t) ? 0 : o.length; i-- && (s = o[i], !S.relative[a = s.type]);)
						if((l = S.find[a]) && (n = l(s.matches[0].replace(bt, St), Tt.test(o[0].type) && h(e.parentNode) || e))) { if(o.splice(i, 1), t = n.length && p(o), !t) return $.apply(r, n), r; break } } return(u || M(t, c))(n, e, !F, r, Tt.test(t) && h(e.parentNode) || e), r }, b.sortStable = H.split("").sort(z).join("") === H, b.detectDuplicates = !!R, D(), b.sortDetached = i(function(t) { return 1 & t.compareDocumentPosition(B.createElement("div")) }), i(function(t) { return t.innerHTML = "<a href='#'></a>", "#" === t.firstChild.getAttribute("href") }) || o("type|href|height|width", function(t, e, r) { return r ? void 0 : t.getAttribute(e, "type" === e.toLowerCase() ? 1 : 2) }), b.attributes && i(function(t) { return t.innerHTML = "<input/>", t.firstChild.setAttribute("value", ""), "" === t.firstChild.getAttribute("value") }) || o("value", function(t, e, r) { return r || "input" !== t.nodeName.toLowerCase() ? void 0 : t.defaultValue }), i(function(t) { return null == t.getAttribute("disabled") }) || o(et, function(t, e, r) { var n; return r ? void 0 : t[e] === !0 ? e.toLowerCase() : (n = t.getAttributeNode(e)) && n.specified ? n.value : null }), e }(t);
		J.find = it, J.expr = it.selectors, J.expr[":"] = J.expr.pseudos, J.unique = it.uniqueSort, J.text = it.getText, J.isXMLDoc = it.isXML, J.contains = it.contains;
		var ot = J.expr.match.needsContext,
			st = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
			at = /^.[^:#\[\.,]*$/;
		J.filter = function(t, e, r) { var n = e[0]; return r && (t = ":not(" + t + ")"), 1 === e.length && 1 === n.nodeType ? J.find.matchesSelector(n, t) ? [n] : [] : J.find.matches(t, J.grep(e, function(t) { return 1 === t.nodeType })) }, J.fn.extend({ find: function(t) { var e, r = this.length,
					n = [],
					i = this; if("string" != typeof t) return this.pushStack(J(t).filter(function() { for(e = 0; r > e; e++)
						if(J.contains(i[e], this)) return !0 })); for(e = 0; r > e; e++) J.find(t, i[e], n); return n = this.pushStack(r > 1 ? J.unique(n) : n), n.selector = this.selector ? this.selector + " " + t : t, n }, filter: function(t) { return this.pushStack(n(this, t || [], !1)) }, not: function(t) { return this.pushStack(n(this, t || [], !0)) }, is: function(t) { return !!n(this, "string" == typeof t && ot.test(t) ? J(t) : t || [], !1).length } });
		var lt, ut = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,
			ht = J.fn.init = function(t, e) { var r, n; if(!t) return this; if("string" == typeof t) { if(r = "<" === t[0] && ">" === t[t.length - 1] && t.length >= 3 ? [null, t, null] : ut.exec(t), !r || !r[1] && e) return !e || e.jquery ? (e || lt).find(t) : this.constructor(e).find(t); if(r[1]) { if(e = e instanceof J ? e[0] : e, J.merge(this, J.parseHTML(r[1], e && e.nodeType ? e.ownerDocument || e : Z, !0)), st.test(r[1]) && J.isPlainObject(e))
							for(r in e) J.isFunction(this[r]) ? this[r](e[r]) : this.attr(r, e[r]); return this } return n = Z.getElementById(r[2]), n && n.parentNode && (this.length = 1, this[0] = n), this.context = Z, this.selector = t, this } return t.nodeType ? (this.context = this[0] = t, this.length = 1, this) : J.isFunction(t) ? "undefined" != typeof lt.ready ? lt.ready(t) : t(J) : (void 0 !== t.selector && (this.selector = t.selector, this.context = t.context), J.makeArray(t, this)) };
		ht.prototype = J.fn, lt = J(Z);
		var ct = /^(?:parents|prev(?:Until|All))/,
			pt = { children: !0, contents: !0, next: !0, prev: !0 };
		J.extend({ dir: function(t, e, r) { for(var n = [], i = void 0 !== r;
					(t = t[e]) && 9 !== t.nodeType;)
					if(1 === t.nodeType) { if(i && J(t).is(r)) break;
						n.push(t) }
				return n }, sibling: function(t, e) { for(var r = []; t; t = t.nextSibling) 1 === t.nodeType && t !== e && r.push(t); return r } }), J.fn.extend({ has: function(t) { var e = J(t, this),
					r = e.length; return this.filter(function() { for(var t = 0; r > t; t++)
						if(J.contains(this, e[t])) return !0 }) }, closest: function(t, e) { for(var r, n = 0, i = this.length, o = [], s = ot.test(t) || "string" != typeof t ? J(t, e || this.context) : 0; i > n; n++)
					for(r = this[n]; r && r !== e; r = r.parentNode)
						if(r.nodeType < 11 && (s ? s.index(r) > -1 : 1 === r.nodeType && J.find.matchesSelector(r, t))) { o.push(r); break }
				return this.pushStack(o.length > 1 ? J.unique(o) : o) }, index: function(t) { return t ? "string" == typeof t ? z.call(J(t), this[0]) : z.call(this, t.jquery ? t[0] : t) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1 }, add: function(t, e) { return this.pushStack(J.unique(J.merge(this.get(), J(t, e)))) }, addBack: function(t) { return this.add(null == t ? this.prevObject : this.prevObject.filter(t)) } }), J.each({ parent: function(t) { var e = t.parentNode; return e && 11 !== e.nodeType ? e : null }, parents: function(t) { return J.dir(t, "parentNode") }, parentsUntil: function(t, e, r) { return J.dir(t, "parentNode", r) }, next: function(t) { return i(t, "nextSibling") }, prev: function(t) { return i(t, "previousSibling") }, nextAll: function(t) { return J.dir(t, "nextSibling") }, prevAll: function(t) { return J.dir(t, "previousSibling") }, nextUntil: function(t, e, r) { return J.dir(t, "nextSibling", r) }, prevUntil: function(t, e, r) { return J.dir(t, "previousSibling", r) }, siblings: function(t) { return J.sibling((t.parentNode || {}).firstChild, t) }, children: function(t) { return J.sibling(t.firstChild) }, contents: function(t) { return t.contentDocument || J.merge([], t.childNodes) } }, function(t, e) { J.fn[t] = function(r, n) { var i = J.map(this, e, r); return "Until" !== t.slice(-5) && (n = r), n && "string" == typeof n && (i = J.filter(n, i)), this.length > 1 && (pt[t] || J.unique(i), ct.test(t) && i.reverse()), this.pushStack(i) } });
		var dt = /\S+/g,
			ft = {};
		J.Callbacks = function(t) { t = "string" == typeof t ? ft[t] || o(t) : J.extend({}, t); var e, r, n, i, s, a, l = [],
				u = !t.once && [],
				h = function(o) { for(e = t.memory && o, r = !0, a = i || 0, i = 0, s = l.length, n = !0; l && s > a; a++)
						if(l[a].apply(o[0], o[1]) === !1 && t.stopOnFalse) { e = !1; break }
					n = !1, l && (u ? u.length && h(u.shift()) : e ? l = [] : c.disable()) },
				c = { add: function() { if(l) { var r = l.length;! function o(e) { J.each(e, function(e, r) { var n = J.type(r); "function" === n ? t.unique && c.has(r) || l.push(r) : r && r.length && "string" !== n && o(r) }) }(arguments), n ? s = l.length : e && (i = r, h(e)) } return this }, remove: function() { return l && J.each(arguments, function(t, e) { for(var r;
								(r = J.inArray(e, l, r)) > -1;) l.splice(r, 1), n && (s >= r && s--, a >= r && a--) }), this }, has: function(t) { return t ? J.inArray(t, l) > -1 : !(!l || !l.length) }, empty: function() { return l = [], s = 0, this }, disable: function() { return l = u = e = void 0, this }, disabled: function() { return !l }, lock: function() { return u = void 0, e || c.disable(), this }, locked: function() { return !u }, fireWith: function(t, e) { return !l || r && !u || (e = e || [], e = [t, e.slice ? e.slice() : e], n ? u.push(e) : h(e)), this }, fire: function() { return c.fireWith(this, arguments), this }, fired: function() { return !!r } }; return c }, J.extend({ Deferred: function(t) { var e = [
						["resolve", "done", J.Callbacks("once memory"), "resolved"],
						["reject", "fail", J.Callbacks("once memory"), "rejected"],
						["notify", "progress", J.Callbacks("memory")]
					],
					r = "pending",
					n = { state: function() { return r }, always: function() { return i.done(arguments).fail(arguments), this }, then: function() { var t = arguments; return J.Deferred(function(r) { J.each(e, function(e, o) { var s = J.isFunction(t[e]) && t[e];
									i[o[1]](function() { var t = s && s.apply(this, arguments);
										t && J.isFunction(t.promise) ? t.promise().done(r.resolve).fail(r.reject).progress(r.notify) : r[o[0] + "With"](this === n ? r.promise() : this, s ? [t] : arguments) }) }), t = null }).promise() }, promise: function(t) { return null != t ? J.extend(t, n) : n } },
					i = {}; return n.pipe = n.then, J.each(e, function(t, o) { var s = o[2],
						a = o[3];
					n[o[1]] = s.add, a && s.add(function() { r = a }, e[1 ^ t][2].disable, e[2][2].lock), i[o[0]] = function() { return i[o[0] + "With"](this === i ? n : this, arguments), this }, i[o[0] + "With"] = s.fireWith }), n.promise(i), t && t.call(i, i), i }, when: function(t) { var e, r, n, i = 0,
					o = X.call(arguments),
					s = o.length,
					a = 1 !== s || t && J.isFunction(t.promise) ? s : 0,
					l = 1 === a ? t : J.Deferred(),
					u = function(t, r, n) { return function(i) { r[t] = this, n[t] = arguments.length > 1 ? X.call(arguments) : i, n === e ? l.notifyWith(r, n) : --a || l.resolveWith(r, n) } }; if(s > 1)
					for(e = new Array(s), r = new Array(s), n = new Array(s); s > i; i++) o[i] && J.isFunction(o[i].promise) ? o[i].promise().done(u(i, n, o)).fail(l.reject).progress(u(i, r, e)) : --a; return a || l.resolveWith(n, o), l.promise() } });
		var vt;
		J.fn.ready = function(t) { return J.ready.promise().done(t), this }, J.extend({ isReady: !1, readyWait: 1, holdReady: function(t) { t ? J.readyWait++ : J.ready(!0) }, ready: function(t) {
				(t === !0 ? --J.readyWait : J.isReady) || (J.isReady = !0, t !== !0 && --J.readyWait > 0 || (vt.resolveWith(Z, [J]), J.fn.triggerHandler && (J(Z).triggerHandler("ready"), J(Z).off("ready")))) } }), J.ready.promise = function(e) { return vt || (vt = J.Deferred(), "complete" === Z.readyState ? setTimeout(J.ready) : (Z.addEventListener("DOMContentLoaded", s, !1), t.addEventListener("load", s, !1))), vt.promise(e) }, J.ready.promise();
		var gt = J.access = function(t, e, r, n, i, o, s) { var a = 0,
				l = t.length,
				u = null == r; if("object" === J.type(r)) { i = !0; for(a in r) J.access(t, e, a, r[a], !0, o, s) } else if(void 0 !== n && (i = !0, J.isFunction(n) || (s = !0), u && (s ? (e.call(t, n), e = null) : (u = e, e = function(t, e, r) { return u.call(J(t), r) })), e))
				for(; l > a; a++) e(t[a], r, s ? n : n.call(t[a], a, e(t[a], r))); return i ? t : u ? e.call(t) : l ? e(t[0], r) : o };
		J.acceptData = function(t) { return 1 === t.nodeType || 9 === t.nodeType || !+t.nodeType }, a.uid = 1, a.accepts = J.acceptData, a.prototype = { key: function(t) { if(!a.accepts(t)) return 0; var e = {},
					r = t[this.expando]; if(!r) { r = a.uid++; try { e[this.expando] = { value: r }, Object.defineProperties(t, e) } catch(n) { e[this.expando] = r, J.extend(t, e) } } return this.cache[r] || (this.cache[r] = {}), r }, set: function(t, e, r) { var n, i = this.key(t),
					o = this.cache[i]; if("string" == typeof e) o[e] = r;
				else if(J.isEmptyObject(o)) J.extend(this.cache[i], e);
				else
					for(n in e) o[n] = e[n]; return o }, get: function(t, e) { var r = this.cache[this.key(t)]; return void 0 === e ? r : r[e] }, access: function(t, e, r) { var n; return void 0 === e || e && "string" == typeof e && void 0 === r ? (n = this.get(t, e), void 0 !== n ? n : this.get(t, J.camelCase(e))) : (this.set(t, e, r), void 0 !== r ? r : e) }, remove: function(t, e) { var r, n, i, o = this.key(t),
					s = this.cache[o]; if(void 0 === e) this.cache[o] = {};
				else { J.isArray(e) ? n = e.concat(e.map(J.camelCase)) : (i = J.camelCase(e), e in s ? n = [e, i] : (n = i, n = n in s ? [n] : n.match(dt) || [])), r = n.length; for(; r--;) delete s[n[r]] } }, hasData: function(t) { return !J.isEmptyObject(this.cache[t[this.expando]] || {}) }, discard: function(t) { t[this.expando] && delete this.cache[t[this.expando]] } };
		var mt = new a,
			yt = new a,
			Tt = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
			xt = /([A-Z])/g;
		J.extend({ hasData: function(t) { return yt.hasData(t) || mt.hasData(t) }, data: function(t, e, r) { return yt.access(t, e, r) }, removeData: function(t, e) { yt.remove(t, e) }, _data: function(t, e, r) { return mt.access(t, e, r) }, _removeData: function(t, e) { mt.remove(t, e) } }), J.fn.extend({ data: function(t, e) { var r, n, i, o = this[0],
					s = o && o.attributes; if(void 0 === t) { if(this.length && (i = yt.get(o), 1 === o.nodeType && !mt.get(o, "hasDataAttrs"))) { for(r = s.length; r--;) s[r] && (n = s[r].name, 0 === n.indexOf("data-") && (n = J.camelCase(n.slice(5)), l(o, n, i[n])));
						mt.set(o, "hasDataAttrs", !0) } return i } return "object" == typeof t ? this.each(function() { yt.set(this, t) }) : gt(this, function(e) { var r, n = J.camelCase(t); if(o && void 0 === e) { if(r = yt.get(o, t), void 0 !== r) return r; if(r = yt.get(o, n), void 0 !== r) return r; if(r = l(o, n, void 0), void 0 !== r) return r } else this.each(function() { var r = yt.get(this, n);
						yt.set(this, n, e), -1 !== t.indexOf("-") && void 0 !== r && yt.set(this, t, e) }) }, null, e, arguments.length > 1, null, !0) }, removeData: function(t) { return this.each(function() { yt.remove(this, t) }) } }), J.extend({ queue: function(t, e, r) { var n; return t ? (e = (e || "fx") + "queue", n = mt.get(t, e), r && (!n || J.isArray(r) ? n = mt.access(t, e, J.makeArray(r)) : n.push(r)), n || []) : void 0 }, dequeue: function(t, e) { e = e || "fx"; var r = J.queue(t, e),
					n = r.length,
					i = r.shift(),
					o = J._queueHooks(t, e),
					s = function() { J.dequeue(t, e) }; "inprogress" === i && (i = r.shift(), n--), i && ("fx" === e && r.unshift("inprogress"), delete o.stop, i.call(t, s, o)), !n && o && o.empty.fire() }, _queueHooks: function(t, e) { var r = e + "queueHooks"; return mt.get(t, r) || mt.access(t, r, { empty: J.Callbacks("once memory").add(function() { mt.remove(t, [e + "queue", r]) }) }) } }), J.fn.extend({ queue: function(t, e) { var r = 2; return "string" != typeof t && (e = t, t = "fx", r--), arguments.length < r ? J.queue(this[0], t) : void 0 === e ? this : this.each(function() { var r = J.queue(this, t, e);
					J._queueHooks(this, t), "fx" === t && "inprogress" !== r[0] && J.dequeue(this, t) }) }, dequeue: function(t) { return this.each(function() { J.dequeue(this, t) }) }, clearQueue: function(t) { return this.queue(t || "fx", []) }, promise: function(t, e) { var r, n = 1,
					i = J.Deferred(),
					o = this,
					s = this.length,
					a = function() {--n || i.resolveWith(o, [o]) }; for("string" != typeof t && (e = t, t = void 0), t = t || "fx"; s--;) r = mt.get(o[s], t + "queueHooks"), r && r.empty && (n++, r.empty.add(a)); return a(), i.promise(e) } });
		var bt = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
			St = ["Top", "Right", "Bottom", "Left"],
			Et = function(t, e) { return t = e || t, "none" === J.css(t, "display") || !J.contains(t.ownerDocument, t) },
			At = /^(?:checkbox|radio)$/i;
		! function() { var t = Z.createDocumentFragment(),
				e = t.appendChild(Z.createElement("div")),
				r = Z.createElement("input");
			r.setAttribute("type", "radio"), r.setAttribute("checked", "checked"), r.setAttribute("name", "t"), e.appendChild(r), Q.checkClone = e.cloneNode(!0).cloneNode(!0).lastChild.checked, e.innerHTML = "<textarea>x</textarea>", Q.noCloneChecked = !!e.cloneNode(!0).lastChild.defaultValue }();
		var _t = "undefined";
		Q.focusinBubbles = "onfocusin" in t;
		var Mt = /^key/,
			wt = /^(?:mouse|pointer|contextmenu)|click/,
			Ct = /^(?:focusinfocus|focusoutblur)$/,
			Pt = /^([^.]*)(?:\.(.+)|)$/;
		J.event = {
			global: {},
			add: function(t, e, r, n, i) { var o, s, a, l, u, h, c, p, d, f, v, g = mt.get(t); if(g)
					for(r.handler && (o = r, r = o.handler, i = o.selector), r.guid || (r.guid = J.guid++), (l = g.events) || (l = g.events = {}), (s = g.handle) || (s = g.handle = function(e) { return typeof J !== _t && J.event.triggered !== e.type ? J.event.dispatch.apply(t, arguments) : void 0 }), e = (e || "").match(dt) || [""], u = e.length; u--;) a = Pt.exec(e[u]) || [], d = v = a[1], f = (a[2] || "").split(".").sort(), d && (c = J.event.special[d] || {}, d = (i ? c.delegateType : c.bindType) || d, c = J.event.special[d] || {}, h = J.extend({ type: d, origType: v, data: n, handler: r, guid: r.guid, selector: i, needsContext: i && J.expr.match.needsContext.test(i), namespace: f.join(".") }, o), (p = l[d]) || (p = l[d] = [], p.delegateCount = 0, c.setup && c.setup.call(t, n, f, s) !== !1 || t.addEventListener && t.addEventListener(d, s, !1)), c.add && (c.add.call(t, h), h.handler.guid || (h.handler.guid = r.guid)), i ? p.splice(p.delegateCount++, 0, h) : p.push(h), J.event.global[d] = !0) },
			remove: function(t, e, r, n, i) { var o, s, a, l, u, h, c, p, d, f, v, g = mt.hasData(t) && mt.get(t); if(g && (l = g.events)) { for(e = (e || "").match(dt) || [""], u = e.length; u--;)
						if(a = Pt.exec(e[u]) || [], d = v = a[1], f = (a[2] || "").split(".").sort(), d) { for(c = J.event.special[d] || {}, d = (n ? c.delegateType : c.bindType) || d, p = l[d] || [], a = a[2] && new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)"), s = o = p.length; o--;) h = p[o], !i && v !== h.origType || r && r.guid !== h.guid || a && !a.test(h.namespace) || n && n !== h.selector && ("**" !== n || !h.selector) || (p.splice(o, 1), h.selector && p.delegateCount--, c.remove && c.remove.call(t, h));
							s && !p.length && (c.teardown && c.teardown.call(t, f, g.handle) !== !1 || J.removeEvent(t, d, g.handle), delete l[d]) } else
							for(d in l) J.event.remove(t, d + e[u], r, n, !0);
					J.isEmptyObject(l) && (delete g.handle, mt.remove(t, "events")) } },
			trigger: function(e, r, n, i) {
				var o, s, a, l, u, h, c, p = [n || Z],
					d = K.call(e, "type") ? e.type : e,
					f = K.call(e, "namespace") ? e.namespace.split(".") : [];
				if(s = a = n = n || Z, 3 !== n.nodeType && 8 !== n.nodeType && !Ct.test(d + J.event.triggered) && (d.indexOf(".") >= 0 && (f = d.split("."),
						d = f.shift(), f.sort()), u = d.indexOf(":") < 0 && "on" + d, e = e[J.expando] ? e : new J.Event(d, "object" == typeof e && e), e.isTrigger = i ? 2 : 3, e.namespace = f.join("."), e.namespace_re = e.namespace ? new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = n), r = null == r ? [e] : J.makeArray(r, [e]), c = J.event.special[d] || {}, i || !c.trigger || c.trigger.apply(n, r) !== !1)) { if(!i && !c.noBubble && !J.isWindow(n)) { for(l = c.delegateType || d, Ct.test(l + d) || (s = s.parentNode); s; s = s.parentNode) p.push(s), a = s;
						a === (n.ownerDocument || Z) && p.push(a.defaultView || a.parentWindow || t) } for(o = 0;
						(s = p[o++]) && !e.isPropagationStopped();) e.type = o > 1 ? l : c.bindType || d, h = (mt.get(s, "events") || {})[e.type] && mt.get(s, "handle"), h && h.apply(s, r), h = u && s[u], h && h.apply && J.acceptData(s) && (e.result = h.apply(s, r), e.result === !1 && e.preventDefault()); return e.type = d, i || e.isDefaultPrevented() || c._default && c._default.apply(p.pop(), r) !== !1 || !J.acceptData(n) || u && J.isFunction(n[d]) && !J.isWindow(n) && (a = n[u], a && (n[u] = null), J.event.triggered = d, n[d](), J.event.triggered = void 0, a && (n[u] = a)), e.result }
			},
			dispatch: function(t) { t = J.event.fix(t); var e, r, n, i, o, s = [],
					a = X.call(arguments),
					l = (mt.get(this, "events") || {})[t.type] || [],
					u = J.event.special[t.type] || {}; if(a[0] = t, t.delegateTarget = this, !u.preDispatch || u.preDispatch.call(this, t) !== !1) { for(s = J.event.handlers.call(this, t, l), e = 0;
						(i = s[e++]) && !t.isPropagationStopped();)
						for(t.currentTarget = i.elem, r = 0;
							(o = i.handlers[r++]) && !t.isImmediatePropagationStopped();)(!t.namespace_re || t.namespace_re.test(o.namespace)) && (t.handleObj = o, t.data = o.data, n = ((J.event.special[o.origType] || {}).handle || o.handler).apply(i.elem, a), void 0 !== n && (t.result = n) === !1 && (t.preventDefault(), t.stopPropagation())); return u.postDispatch && u.postDispatch.call(this, t), t.result } },
			handlers: function(t, e) { var r, n, i, o, s = [],
					a = e.delegateCount,
					l = t.target; if(a && l.nodeType && (!t.button || "click" !== t.type))
					for(; l !== this; l = l.parentNode || this)
						if(l.disabled !== !0 || "click" !== t.type) { for(n = [], r = 0; a > r; r++) o = e[r], i = o.selector + " ", void 0 === n[i] && (n[i] = o.needsContext ? J(i, this).index(l) >= 0 : J.find(i, this, null, [l]).length), n[i] && n.push(o);
							n.length && s.push({ elem: l, handlers: n }) }
				return a < e.length && s.push({ elem: this, handlers: e.slice(a) }), s },
			props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
			fixHooks: {},
			keyHooks: { props: "char charCode key keyCode".split(" "), filter: function(t, e) { return null == t.which && (t.which = null != e.charCode ? e.charCode : e.keyCode), t } },
			mouseHooks: { props: "button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "), filter: function(t, e) { var r, n, i, o = e.button; return null == t.pageX && null != e.clientX && (r = t.target.ownerDocument || Z, n = r.documentElement, i = r.body, t.pageX = e.clientX + (n && n.scrollLeft || i && i.scrollLeft || 0) - (n && n.clientLeft || i && i.clientLeft || 0), t.pageY = e.clientY + (n && n.scrollTop || i && i.scrollTop || 0) - (n && n.clientTop || i && i.clientTop || 0)), t.which || void 0 === o || (t.which = 1 & o ? 1 : 2 & o ? 3 : 4 & o ? 2 : 0), t } },
			fix: function(t) { if(t[J.expando]) return t; var e, r, n, i = t.type,
					o = t,
					s = this.fixHooks[i]; for(s || (this.fixHooks[i] = s = wt.test(i) ? this.mouseHooks : Mt.test(i) ? this.keyHooks : {}), n = s.props ? this.props.concat(s.props) : this.props, t = new J.Event(o), e = n.length; e--;) r = n[e], t[r] = o[r]; return t.target || (t.target = Z), 3 === t.target.nodeType && (t.target = t.target.parentNode), s.filter ? s.filter(t, o) : t },
			special: { load: { noBubble: !0 }, focus: { trigger: function() { return this !== c() && this.focus ? (this.focus(), !1) : void 0 }, delegateType: "focusin" }, blur: { trigger: function() { return this === c() && this.blur ? (this.blur(), !1) : void 0 }, delegateType: "focusout" }, click: { trigger: function() { return "checkbox" === this.type && this.click && J.nodeName(this, "input") ? (this.click(), !1) : void 0 }, _default: function(t) { return J.nodeName(t.target, "a") } }, beforeunload: { postDispatch: function(t) { void 0 !== t.result && t.originalEvent && (t.originalEvent.returnValue = t.result) } } },
			simulate: function(t, e, r, n) { var i = J.extend(new J.Event, r, { type: t, isSimulated: !0, originalEvent: {} });
				n ? J.event.trigger(i, null, e) : J.event.dispatch.call(e, i), i.isDefaultPrevented() && r.preventDefault() }
		}, J.removeEvent = function(t, e, r) { t.removeEventListener && t.removeEventListener(e, r, !1) }, J.Event = function(t, e) { return this instanceof J.Event ? (t && t.type ? (this.originalEvent = t, this.type = t.type, this.isDefaultPrevented = t.defaultPrevented || void 0 === t.defaultPrevented && t.returnValue === !1 ? u : h) : this.type = t, e && J.extend(this, e), this.timeStamp = t && t.timeStamp || J.now(), void(this[J.expando] = !0)) : new J.Event(t, e) }, J.Event.prototype = { isDefaultPrevented: h, isPropagationStopped: h, isImmediatePropagationStopped: h, preventDefault: function() { var t = this.originalEvent;
				this.isDefaultPrevented = u, t && t.preventDefault && t.preventDefault() }, stopPropagation: function() { var t = this.originalEvent;
				this.isPropagationStopped = u, t && t.stopPropagation && t.stopPropagation() }, stopImmediatePropagation: function() { var t = this.originalEvent;
				this.isImmediatePropagationStopped = u, t && t.stopImmediatePropagation && t.stopImmediatePropagation(), this.stopPropagation() } }, J.each({ mouseenter: "mouseover", mouseleave: "mouseout", pointerenter: "pointerover", pointerleave: "pointerout" }, function(t, e) { J.event.special[t] = { delegateType: e, bindType: e, handle: function(t) { var r, n = this,
						i = t.relatedTarget,
						o = t.handleObj; return(!i || i !== n && !J.contains(n, i)) && (t.type = o.origType, r = o.handler.apply(this, arguments), t.type = e), r } } }), Q.focusinBubbles || J.each({ focus: "focusin", blur: "focusout" }, function(t, e) { var r = function(t) { J.event.simulate(e, t.target, J.event.fix(t), !0) };
			J.event.special[e] = { setup: function() { var n = this.ownerDocument || this,
						i = mt.access(n, e);
					i || n.addEventListener(t, r, !0), mt.access(n, e, (i || 0) + 1) }, teardown: function() { var n = this.ownerDocument || this,
						i = mt.access(n, e) - 1;
					i ? mt.access(n, e, i) : (n.removeEventListener(t, r, !0), mt.remove(n, e)) } } }), J.fn.extend({ on: function(t, e, r, n, i) { var o, s; if("object" == typeof t) { "string" != typeof e && (r = r || e, e = void 0); for(s in t) this.on(s, e, r, t[s], i); return this } if(null == r && null == n ? (n = e, r = e = void 0) : null == n && ("string" == typeof e ? (n = r, r = void 0) : (n = r, r = e, e = void 0)), n === !1) n = h;
				else if(!n) return this; return 1 === i && (o = n, n = function(t) { return J().off(t), o.apply(this, arguments) }, n.guid = o.guid || (o.guid = J.guid++)), this.each(function() { J.event.add(this, t, n, r, e) }) }, one: function(t, e, r, n) { return this.on(t, e, r, n, 1) }, off: function(t, e, r) { var n, i; if(t && t.preventDefault && t.handleObj) return n = t.handleObj, J(t.delegateTarget).off(n.namespace ? n.origType + "." + n.namespace : n.origType, n.selector, n.handler), this; if("object" == typeof t) { for(i in t) this.off(i, e, t[i]); return this } return(e === !1 || "function" == typeof e) && (r = e, e = void 0), r === !1 && (r = h), this.each(function() { J.event.remove(this, t, r, e) }) }, trigger: function(t, e) { return this.each(function() { J.event.trigger(t, e, this) }) }, triggerHandler: function(t, e) { var r = this[0]; return r ? J.event.trigger(t, e, r, !0) : void 0 } });
		var Rt = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
			Dt = /<([\w:]+)/,
			Bt = /<|&#?\w+;/,
			Ot = /<(?:script|style|link)/i,
			Ft = /checked\s*(?:[^=]|=\s*.checked.)/i,
			Lt = /^$|\/(?:java|ecma)script/i,
			It = /^true\/(.*)/,
			Gt = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,
			Nt = { option: [1, "<select multiple='multiple'>", "</select>"], thead: [1, "<table>", "</table>"], col: [2, "<table><colgroup>", "</colgroup></table>"], tr: [2, "<table><tbody>", "</tbody></table>"], td: [3, "<table><tbody><tr>", "</tr></tbody></table>"], _default: [0, "", ""] };
		Nt.optgroup = Nt.option, Nt.tbody = Nt.tfoot = Nt.colgroup = Nt.caption = Nt.thead, Nt.th = Nt.td, J.extend({ clone: function(t, e, r) { var n, i, o, s, a = t.cloneNode(!0),
					l = J.contains(t.ownerDocument, t); if(!(Q.noCloneChecked || 1 !== t.nodeType && 11 !== t.nodeType || J.isXMLDoc(t)))
					for(s = m(a), o = m(t), n = 0, i = o.length; i > n; n++) y(o[n], s[n]); if(e)
					if(r)
						for(o = o || m(t), s = s || m(a), n = 0, i = o.length; i > n; n++) g(o[n], s[n]);
					else g(t, a); return s = m(a, "script"), s.length > 0 && v(s, !l && m(t, "script")), a }, buildFragment: function(t, e, r, n) { for(var i, o, s, a, l, u, h = e.createDocumentFragment(), c = [], p = 0, d = t.length; d > p; p++)
					if(i = t[p], i || 0 === i)
						if("object" === J.type(i)) J.merge(c, i.nodeType ? [i] : i);
						else if(Bt.test(i)) { for(o = o || h.appendChild(e.createElement("div")), s = (Dt.exec(i) || ["", ""])[1].toLowerCase(), a = Nt[s] || Nt._default, o.innerHTML = a[1] + i.replace(Rt, "<$1></$2>") + a[2], u = a[0]; u--;) o = o.lastChild;
					J.merge(c, o.childNodes), o = h.firstChild, o.textContent = "" } else c.push(e.createTextNode(i)); for(h.textContent = "", p = 0; i = c[p++];)
					if((!n || -1 === J.inArray(i, n)) && (l = J.contains(i.ownerDocument, i), o = m(h.appendChild(i), "script"), l && v(o), r))
						for(u = 0; i = o[u++];) Lt.test(i.type || "") && r.push(i); return h }, cleanData: function(t) { for(var e, r, n, i, o = J.event.special, s = 0; void 0 !== (r = t[s]); s++) { if(J.acceptData(r) && (i = r[mt.expando], i && (e = mt.cache[i]))) { if(e.events)
							for(n in e.events) o[n] ? J.event.remove(r, n) : J.removeEvent(r, n, e.handle);
						mt.cache[i] && delete mt.cache[i] } delete yt.cache[r[yt.expando]] } } }), J.fn.extend({ text: function(t) { return gt(this, function(t) { return void 0 === t ? J.text(this) : this.empty().each(function() {
						(1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) && (this.textContent = t) }) }, null, t, arguments.length) }, append: function() { return this.domManip(arguments, function(t) { if(1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) { var e = p(this, t);
						e.appendChild(t) } }) }, prepend: function() { return this.domManip(arguments, function(t) { if(1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) { var e = p(this, t);
						e.insertBefore(t, e.firstChild) } }) }, before: function() { return this.domManip(arguments, function(t) { this.parentNode && this.parentNode.insertBefore(t, this) }) }, after: function() { return this.domManip(arguments, function(t) { this.parentNode && this.parentNode.insertBefore(t, this.nextSibling) }) }, remove: function(t, e) { for(var r, n = t ? J.filter(t, this) : this, i = 0; null != (r = n[i]); i++) e || 1 !== r.nodeType || J.cleanData(m(r)), r.parentNode && (e && J.contains(r.ownerDocument, r) && v(m(r, "script")), r.parentNode.removeChild(r)); return this }, empty: function() { for(var t, e = 0; null != (t = this[e]); e++) 1 === t.nodeType && (J.cleanData(m(t, !1)), t.textContent = ""); return this }, clone: function(t, e) { return t = null == t ? !1 : t, e = null == e ? t : e, this.map(function() { return J.clone(this, t, e) }) }, html: function(t) { return gt(this, function(t) { var e = this[0] || {},
						r = 0,
						n = this.length; if(void 0 === t && 1 === e.nodeType) return e.innerHTML; if("string" == typeof t && !Ot.test(t) && !Nt[(Dt.exec(t) || ["", ""])[1].toLowerCase()]) { t = t.replace(Rt, "<$1></$2>"); try { for(; n > r; r++) e = this[r] || {}, 1 === e.nodeType && (J.cleanData(m(e, !1)), e.innerHTML = t);
							e = 0 } catch(i) {} } e && this.empty().append(t) }, null, t, arguments.length) }, replaceWith: function() { var t = arguments[0]; return this.domManip(arguments, function(e) { t = this.parentNode, J.cleanData(m(this)), t && t.replaceChild(e, this) }), t && (t.length || t.nodeType) ? this : this.remove() }, detach: function(t) { return this.remove(t, !0) }, domManip: function(t, e) { t = W.apply([], t); var r, n, i, o, s, a, l = 0,
					u = this.length,
					h = this,
					c = u - 1,
					p = t[0],
					v = J.isFunction(p); if(v || u > 1 && "string" == typeof p && !Q.checkClone && Ft.test(p)) return this.each(function(r) { var n = h.eq(r);
					v && (t[0] = p.call(this, r, n.html())), n.domManip(t, e) }); if(u && (r = J.buildFragment(t, this[0].ownerDocument, !1, this), n = r.firstChild, 1 === r.childNodes.length && (r = n), n)) { for(i = J.map(m(r, "script"), d), o = i.length; u > l; l++) s = r, l !== c && (s = J.clone(s, !0, !0), o && J.merge(i, m(s, "script"))), e.call(this[l], s, l); if(o)
						for(a = i[i.length - 1].ownerDocument, J.map(i, f), l = 0; o > l; l++) s = i[l], Lt.test(s.type || "") && !mt.access(s, "globalEval") && J.contains(a, s) && (s.src ? J._evalUrl && J._evalUrl(s.src) : J.globalEval(s.textContent.replace(Gt, ""))) } return this } }), J.each({ appendTo: "append", prependTo: "prepend", insertBefore: "before", insertAfter: "after", replaceAll: "replaceWith" }, function(t, e) { J.fn[t] = function(t) { for(var r, n = [], i = J(t), o = i.length - 1, s = 0; o >= s; s++) r = s === o ? this : this.clone(!0), J(i[s])[e](r), V.apply(n, r.get()); return this.pushStack(n) } });
		var Ht, kt = {},
			Ut = /^margin/,
			jt = new RegExp("^(" + bt + ")(?!px)[a-z%]+$", "i"),
			Xt = function(e) { return e.ownerDocument.defaultView.opener ? e.ownerDocument.defaultView.getComputedStyle(e, null) : t.getComputedStyle(e, null) };
		! function() {
			function e() { s.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:block;margin-top:1%;top:1%;border:1px;padding:1px;width:4px;position:absolute", s.innerHTML = "", i.appendChild(o); var e = t.getComputedStyle(s, null);
				r = "1%" !== e.top, n = "4px" === e.width, i.removeChild(o) } var r, n, i = Z.documentElement,
				o = Z.createElement("div"),
				s = Z.createElement("div");
			s.style && (s.style.backgroundClip = "content-box", s.cloneNode(!0).style.backgroundClip = "", Q.clearCloneStyle = "content-box" === s.style.backgroundClip, o.style.cssText = "border:0;width:0;height:0;top:0;left:-9999px;margin-top:1px;position:absolute", o.appendChild(s), t.getComputedStyle && J.extend(Q, { pixelPosition: function() { return e(), r }, boxSizingReliable: function() { return null == n && e(), n }, reliableMarginRight: function() { var e, r = s.appendChild(Z.createElement("div")); return r.style.cssText = s.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", r.style.marginRight = r.style.width = "0", s.style.width = "1px", i.appendChild(o), e = !parseFloat(t.getComputedStyle(r, null).marginRight), i.removeChild(o), s.removeChild(r), e } })) }(), J.swap = function(t, e, r, n) { var i, o, s = {}; for(o in e) s[o] = t.style[o], t.style[o] = e[o];
			i = r.apply(t, n || []); for(o in e) t.style[o] = s[o]; return i };
		var Wt = /^(none|table(?!-c[ea]).+)/,
			Vt = new RegExp("^(" + bt + ")(.*)$", "i"),
			zt = new RegExp("^([+-])=(" + bt + ")", "i"),
			Yt = { position: "absolute", visibility: "hidden", display: "block" },
			qt = { letterSpacing: "0", fontWeight: "400" },
			Kt = ["Webkit", "O", "Moz", "ms"];
		J.extend({ cssHooks: { opacity: { get: function(t, e) { if(e) { var r = b(t, "opacity"); return "" === r ? "1" : r } } } }, cssNumber: { columnCount: !0, fillOpacity: !0, flexGrow: !0, flexShrink: !0, fontWeight: !0, lineHeight: !0, opacity: !0, order: !0, orphans: !0, widows: !0, zIndex: !0, zoom: !0 }, cssProps: { "float": "cssFloat" }, style: function(t, e, r, n) { if(t && 3 !== t.nodeType && 8 !== t.nodeType && t.style) { var i, o, s, a = J.camelCase(e),
						l = t.style; return e = J.cssProps[a] || (J.cssProps[a] = E(l, a)), s = J.cssHooks[e] || J.cssHooks[a], void 0 === r ? s && "get" in s && void 0 !== (i = s.get(t, !1, n)) ? i : l[e] : (o = typeof r, "string" === o && (i = zt.exec(r)) && (r = (i[1] + 1) * i[2] + parseFloat(J.css(t, e)), o = "number"), void(null != r && r === r && ("number" !== o || J.cssNumber[a] || (r += "px"), Q.clearCloneStyle || "" !== r || 0 !== e.indexOf("background") || (l[e] = "inherit"), s && "set" in s && void 0 === (r = s.set(t, r, n)) || (l[e] = r)))) } }, css: function(t, e, r, n) { var i, o, s, a = J.camelCase(e); return e = J.cssProps[a] || (J.cssProps[a] = E(t.style, a)), s = J.cssHooks[e] || J.cssHooks[a], s && "get" in s && (i = s.get(t, !0, r)), void 0 === i && (i = b(t, e, n)), "normal" === i && e in qt && (i = qt[e]), "" === r || r ? (o = parseFloat(i), r === !0 || J.isNumeric(o) ? o || 0 : i) : i } }), J.each(["height", "width"], function(t, e) { J.cssHooks[e] = { get: function(t, r, n) { return r ? Wt.test(J.css(t, "display")) && 0 === t.offsetWidth ? J.swap(t, Yt, function() { return M(t, e, n) }) : M(t, e, n) : void 0 }, set: function(t, r, n) { var i = n && Xt(t); return A(t, r, n ? _(t, e, n, "border-box" === J.css(t, "boxSizing", !1, i), i) : 0) } } }), J.cssHooks.marginRight = S(Q.reliableMarginRight, function(t, e) { return e ? J.swap(t, { display: "inline-block" }, b, [t, "marginRight"]) : void 0 }), J.each({ margin: "", padding: "", border: "Width" }, function(t, e) { J.cssHooks[t + e] = { expand: function(r) { for(var n = 0, i = {}, o = "string" == typeof r ? r.split(" ") : [r]; 4 > n; n++) i[t + St[n] + e] = o[n] || o[n - 2] || o[0]; return i } }, Ut.test(t) || (J.cssHooks[t + e].set = A) }), J.fn.extend({ css: function(t, e) { return gt(this, function(t, e, r) { var n, i, o = {},
						s = 0; if(J.isArray(e)) { for(n = Xt(t), i = e.length; i > s; s++) o[e[s]] = J.css(t, e[s], !1, n); return o } return void 0 !== r ? J.style(t, e, r) : J.css(t, e) }, t, e, arguments.length > 1) }, show: function() { return w(this, !0) }, hide: function() { return w(this) }, toggle: function(t) { return "boolean" == typeof t ? t ? this.show() : this.hide() : this.each(function() { Et(this) ? J(this).show() : J(this).hide() }) } }), J.Tween = C, C.prototype = { constructor: C, init: function(t, e, r, n, i, o) { this.elem = t, this.prop = r, this.easing = i || "swing", this.options = e, this.start = this.now = this.cur(), this.end = n, this.unit = o || (J.cssNumber[r] ? "" : "px") }, cur: function() { var t = C.propHooks[this.prop]; return t && t.get ? t.get(this) : C.propHooks._default.get(this) }, run: function(t) { var e, r = C.propHooks[this.prop]; return this.options.duration ? this.pos = e = J.easing[this.easing](t, this.options.duration * t, 0, 1, this.options.duration) : this.pos = e = t, this.now = (this.end - this.start) * e + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), r && r.set ? r.set(this) : C.propHooks._default.set(this), this } }, C.prototype.init.prototype = C.prototype, C.propHooks = { _default: { get: function(t) { var e; return null == t.elem[t.prop] || t.elem.style && null != t.elem.style[t.prop] ? (e = J.css(t.elem, t.prop, ""), e && "auto" !== e ? e : 0) : t.elem[t.prop] }, set: function(t) { J.fx.step[t.prop] ? J.fx.step[t.prop](t) : t.elem.style && (null != t.elem.style[J.cssProps[t.prop]] || J.cssHooks[t.prop]) ? J.style(t.elem, t.prop, t.now + t.unit) : t.elem[t.prop] = t.now } } }, C.propHooks.scrollTop = C.propHooks.scrollLeft = { set: function(t) { t.elem.nodeType && t.elem.parentNode && (t.elem[t.prop] = t.now) } }, J.easing = { linear: function(t) { return t }, swing: function(t) { return .5 - Math.cos(t * Math.PI) / 2 } }, J.fx = C.prototype.init, J.fx.step = {};
		var Qt, Zt, $t = /^(?:toggle|show|hide)$/,
			Jt = new RegExp("^(?:([+-])=|)(" + bt + ")([a-z%]*)$", "i"),
			te = /queueHooks$/,
			ee = [B],
			re = { "*": [function(t, e) { var r = this.createTween(t, e),
						n = r.cur(),
						i = Jt.exec(e),
						o = i && i[3] || (J.cssNumber[t] ? "" : "px"),
						s = (J.cssNumber[t] || "px" !== o && +n) && Jt.exec(J.css(r.elem, t)),
						a = 1,
						l = 20; if(s && s[3] !== o) { o = o || s[3], i = i || [], s = +n || 1;
						do a = a || ".5", s /= a, J.style(r.elem, t, s + o); while (a !== (a = r.cur() / n) && 1 !== a && --l) } return i && (s = r.start = +s || +n || 0, r.unit = o, r.end = i[1] ? s + (i[1] + 1) * i[2] : +i[2]), r }] };
		J.Animation = J.extend(F, { tweener: function(t, e) { J.isFunction(t) ? (e = t, t = ["*"]) : t = t.split(" "); for(var r, n = 0, i = t.length; i > n; n++) r = t[n], re[r] = re[r] || [], re[r].unshift(e) }, prefilter: function(t, e) { e ? ee.unshift(t) : ee.push(t) } }), J.speed = function(t, e, r) { var n = t && "object" == typeof t ? J.extend({}, t) : { complete: r || !r && e || J.isFunction(t) && t, duration: t, easing: r && e || e && !J.isFunction(e) && e }; return n.duration = J.fx.off ? 0 : "number" == typeof n.duration ? n.duration : n.duration in J.fx.speeds ? J.fx.speeds[n.duration] : J.fx.speeds._default, (null == n.queue || n.queue === !0) && (n.queue = "fx"), n.old = n.complete, n.complete = function() { J.isFunction(n.old) && n.old.call(this), n.queue && J.dequeue(this, n.queue) }, n }, J.fn.extend({ fadeTo: function(t, e, r, n) { return this.filter(Et).css("opacity", 0).show().end().animate({ opacity: e }, t, r, n) }, animate: function(t, e, r, n) { var i = J.isEmptyObject(t),
						o = J.speed(e, r, n),
						s = function() { var e = F(this, J.extend({}, t), o);
							(i || mt.get(this, "finish")) && e.stop(!0) }; return s.finish = s, i || o.queue === !1 ? this.each(s) : this.queue(o.queue, s) }, stop: function(t, e, r) { var n = function(t) { var e = t.stop;
						delete t.stop, e(r) }; return "string" != typeof t && (r = e, e = t, t = void 0), e && t !== !1 && this.queue(t || "fx", []), this.each(function() { var e = !0,
							i = null != t && t + "queueHooks",
							o = J.timers,
							s = mt.get(this); if(i) s[i] && s[i].stop && n(s[i]);
						else
							for(i in s) s[i] && s[i].stop && te.test(i) && n(s[i]); for(i = o.length; i--;) o[i].elem !== this || null != t && o[i].queue !== t || (o[i].anim.stop(r), e = !1, o.splice(i, 1));
						(e || !r) && J.dequeue(this, t) }) }, finish: function(t) { return t !== !1 && (t = t || "fx"), this.each(function() { var e, r = mt.get(this),
							n = r[t + "queue"],
							i = r[t + "queueHooks"],
							o = J.timers,
							s = n ? n.length : 0; for(r.finish = !0, J.queue(this, t, []), i && i.stop && i.stop.call(this, !0), e = o.length; e--;) o[e].elem === this && o[e].queue === t && (o[e].anim.stop(!0), o.splice(e, 1)); for(e = 0; s > e; e++) n[e] && n[e].finish && n[e].finish.call(this);
						delete r.finish }) } }), J.each(["toggle", "show", "hide"], function(t, e) { var r = J.fn[e];
				J.fn[e] = function(t, n, i) { return null == t || "boolean" == typeof t ? r.apply(this, arguments) : this.animate(R(e, !0), t, n, i) } }), J.each({ slideDown: R("show"), slideUp: R("hide"), slideToggle: R("toggle"), fadeIn: { opacity: "show" }, fadeOut: { opacity: "hide" }, fadeToggle: { opacity: "toggle" } }, function(t, e) { J.fn[t] = function(t, r, n) { return this.animate(e, t, r, n) } }), J.timers = [], J.fx.tick = function() { var t, e = 0,
					r = J.timers; for(Qt = J.now(); e < r.length; e++) t = r[e], t() || r[e] !== t || r.splice(e--, 1);
				r.length || J.fx.stop(), Qt = void 0 }, J.fx.timer = function(t) { J.timers.push(t), t() ? J.fx.start() : J.timers.pop() }, J.fx.interval = 13, J.fx.start = function() { Zt || (Zt = setInterval(J.fx.tick, J.fx.interval)) }, J.fx.stop = function() { clearInterval(Zt), Zt = null }, J.fx.speeds = { slow: 600, fast: 200, _default: 400 }, J.fn.delay = function(t, e) { return t = J.fx ? J.fx.speeds[t] || t : t, e = e || "fx", this.queue(e, function(e, r) { var n = setTimeout(e, t);
					r.stop = function() { clearTimeout(n) } }) },
			function() { var t = Z.createElement("input"),
					e = Z.createElement("select"),
					r = e.appendChild(Z.createElement("option"));
				t.type = "checkbox", Q.checkOn = "" !== t.value, Q.optSelected = r.selected, e.disabled = !0, Q.optDisabled = !r.disabled, t = Z.createElement("input"), t.value = "t", t.type = "radio", Q.radioValue = "t" === t.value }();
		var ne, ie, oe = J.expr.attrHandle;
		J.fn.extend({ attr: function(t, e) { return gt(this, J.attr, t, e, arguments.length > 1) }, removeAttr: function(t) { return this.each(function() { J.removeAttr(this, t) }) } }), J.extend({ attr: function(t, e, r) { var n, i, o = t.nodeType; return t && 3 !== o && 8 !== o && 2 !== o ? typeof t.getAttribute === _t ? J.prop(t, e, r) : (1 === o && J.isXMLDoc(t) || (e = e.toLowerCase(), n = J.attrHooks[e] || (J.expr.match.bool.test(e) ? ie : ne)), void 0 === r ? n && "get" in n && null !== (i = n.get(t, e)) ? i : (i = J.find.attr(t, e), null == i ? void 0 : i) : null !== r ? n && "set" in n && void 0 !== (i = n.set(t, r, e)) ? i : (t.setAttribute(e, r + ""), r) : void J.removeAttr(t, e)) : void 0 }, removeAttr: function(t, e) { var r, n, i = 0,
					o = e && e.match(dt); if(o && 1 === t.nodeType)
					for(; r = o[i++];) n = J.propFix[r] || r, J.expr.match.bool.test(r) && (t[n] = !1), t.removeAttribute(r) }, attrHooks: { type: { set: function(t, e) { if(!Q.radioValue && "radio" === e && J.nodeName(t, "input")) { var r = t.value; return t.setAttribute("type", e), r && (t.value = r), e } } } } }), ie = { set: function(t, e, r) { return e === !1 ? J.removeAttr(t, r) : t.setAttribute(r, r), r } }, J.each(J.expr.match.bool.source.match(/\w+/g), function(t, e) { var r = oe[e] || J.find.attr;
			oe[e] = function(t, e, n) { var i, o; return n || (o = oe[e], oe[e] = i, i = null != r(t, e, n) ? e.toLowerCase() : null, oe[e] = o), i } });
		var se = /^(?:input|select|textarea|button)$/i;
		J.fn.extend({ prop: function(t, e) { return gt(this, J.prop, t, e, arguments.length > 1) }, removeProp: function(t) { return this.each(function() { delete this[J.propFix[t] || t] }) } }), J.extend({ propFix: { "for": "htmlFor", "class": "className" }, prop: function(t, e, r) { var n, i, o, s = t.nodeType; return t && 3 !== s && 8 !== s && 2 !== s ? (o = 1 !== s || !J.isXMLDoc(t), o && (e = J.propFix[e] || e, i = J.propHooks[e]), void 0 !== r ? i && "set" in i && void 0 !== (n = i.set(t, r, e)) ? n : t[e] = r : i && "get" in i && null !== (n = i.get(t, e)) ? n : t[e]) : void 0 }, propHooks: { tabIndex: { get: function(t) { return t.hasAttribute("tabindex") || se.test(t.nodeName) || t.href ? t.tabIndex : -1 } } } }), Q.optSelected || (J.propHooks.selected = { get: function(t) { var e = t.parentNode; return e && e.parentNode && e.parentNode.selectedIndex, null } }), J.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() { J.propFix[this.toLowerCase()] = this });
		var ae = /[\t\r\n\f]/g;
		J.fn.extend({ addClass: function(t) { var e, r, n, i, o, s, a = "string" == typeof t && t,
					l = 0,
					u = this.length; if(J.isFunction(t)) return this.each(function(e) { J(this).addClass(t.call(this, e, this.className)) }); if(a)
					for(e = (t || "").match(dt) || []; u > l; l++)
						if(r = this[l], n = 1 === r.nodeType && (r.className ? (" " + r.className + " ").replace(ae, " ") : " ")) { for(o = 0; i = e[o++];) n.indexOf(" " + i + " ") < 0 && (n += i + " ");
							s = J.trim(n), r.className !== s && (r.className = s) }
				return this }, removeClass: function(t) { var e, r, n, i, o, s, a = 0 === arguments.length || "string" == typeof t && t,
					l = 0,
					u = this.length; if(J.isFunction(t)) return this.each(function(e) { J(this).removeClass(t.call(this, e, this.className)) }); if(a)
					for(e = (t || "").match(dt) || []; u > l; l++)
						if(r = this[l], n = 1 === r.nodeType && (r.className ? (" " + r.className + " ").replace(ae, " ") : "")) { for(o = 0; i = e[o++];)
								for(; n.indexOf(" " + i + " ") >= 0;) n = n.replace(" " + i + " ", " ");
							s = t ? J.trim(n) : "", r.className !== s && (r.className = s) }
				return this }, toggleClass: function(t, e) { var r = typeof t; return "boolean" == typeof e && "string" === r ? e ? this.addClass(t) : this.removeClass(t) : this.each(J.isFunction(t) ? function(r) { J(this).toggleClass(t.call(this, r, this.className, e), e) } : function() { if("string" === r)
						for(var e, n = 0, i = J(this), o = t.match(dt) || []; e = o[n++];) i.hasClass(e) ? i.removeClass(e) : i.addClass(e);
					else(r === _t || "boolean" === r) && (this.className && mt.set(this, "__className__", this.className), this.className = this.className || t === !1 ? "" : mt.get(this, "__className__") || "") }) }, hasClass: function(t) { for(var e = " " + t + " ", r = 0, n = this.length; n > r; r++)
					if(1 === this[r].nodeType && (" " + this[r].className + " ").replace(ae, " ").indexOf(e) >= 0) return !0; return !1 } });
		var le = /\r/g;
		J.fn.extend({ val: function(t) { var e, r, n, i = this[0]; return arguments.length ? (n = J.isFunction(t), this.each(function(r) { var i;
					1 === this.nodeType && (i = n ? t.call(this, r, J(this).val()) : t, null == i ? i = "" : "number" == typeof i ? i += "" : J.isArray(i) && (i = J.map(i, function(t) { return null == t ? "" : t + "" })), e = J.valHooks[this.type] || J.valHooks[this.nodeName.toLowerCase()], e && "set" in e && void 0 !== e.set(this, i, "value") || (this.value = i)) })) : i ? (e = J.valHooks[i.type] || J.valHooks[i.nodeName.toLowerCase()], e && "get" in e && void 0 !== (r = e.get(i, "value")) ? r : (r = i.value, "string" == typeof r ? r.replace(le, "") : null == r ? "" : r)) : void 0 } }), J.extend({ valHooks: { option: { get: function(t) { var e = J.find.attr(t, "value"); return null != e ? e : J.trim(J.text(t)) } }, select: { get: function(t) { for(var e, r, n = t.options, i = t.selectedIndex, o = "select-one" === t.type || 0 > i, s = o ? null : [], a = o ? i + 1 : n.length, l = 0 > i ? a : o ? i : 0; a > l; l++)
							if(r = n[l], !(!r.selected && l !== i || (Q.optDisabled ? r.disabled : null !== r.getAttribute("disabled")) || r.parentNode.disabled && J.nodeName(r.parentNode, "optgroup"))) { if(e = J(r).val(), o) return e;
								s.push(e) }
						return s }, set: function(t, e) { for(var r, n, i = t.options, o = J.makeArray(e), s = i.length; s--;) n = i[s], (n.selected = J.inArray(n.value, o) >= 0) && (r = !0); return r || (t.selectedIndex = -1), o } } } }), J.each(["radio", "checkbox"], function() { J.valHooks[this] = { set: function(t, e) { return J.isArray(e) ? t.checked = J.inArray(J(t).val(), e) >= 0 : void 0 } }, Q.checkOn || (J.valHooks[this].get = function(t) { return null === t.getAttribute("value") ? "on" : t.value }) }), J.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function(t, e) { J.fn[e] = function(t, r) { return arguments.length > 0 ? this.on(e, null, t, r) : this.trigger(e) } }), J.fn.extend({ hover: function(t, e) { return this.mouseenter(t).mouseleave(e || t) }, bind: function(t, e, r) { return this.on(t, null, e, r) }, unbind: function(t, e) { return this.off(t, null, e) }, delegate: function(t, e, r, n) { return this.on(e, t, r, n) }, undelegate: function(t, e, r) { return 1 === arguments.length ? this.off(t, "**") : this.off(e, t || "**", r) } });
		var ue = J.now(),
			he = /\?/;
		J.parseJSON = function(t) { return JSON.parse(t + "") }, J.parseXML = function(t) { var e, r; if(!t || "string" != typeof t) return null; try { r = new DOMParser, e = r.parseFromString(t, "text/xml") } catch(n) { e = void 0 } return(!e || e.getElementsByTagName("parsererror").length) && J.error("Invalid XML: " + t), e };
		var ce = /#.*$/,
			pe = /([?&])_=[^&]*/,
			de = /^(.*?):[ \t]*([^\r\n]*)$/gm,
			fe = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
			ve = /^(?:GET|HEAD)$/,
			ge = /^\/\//,
			me = /^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,
			ye = {},
			Te = {},
			xe = "*/".concat("*"),
			be = t.location.href,
			Se = me.exec(be.toLowerCase()) || [];
		J.extend({ active: 0, lastModified: {}, etag: {}, ajaxSettings: { url: be, type: "GET", isLocal: fe.test(Se[1]), global: !0, processData: !0, async: !0, contentType: "application/x-www-form-urlencoded; charset=UTF-8", accepts: { "*": xe, text: "text/plain", html: "text/html", xml: "application/xml, text/xml", json: "application/json, text/javascript" }, contents: { xml: /xml/, html: /html/, json: /json/ }, responseFields: { xml: "responseXML", text: "responseText", json: "responseJSON" }, converters: { "* text": String, "text html": !0, "text json": J.parseJSON, "text xml": J.parseXML }, flatOptions: { url: !0, context: !0 } }, ajaxSetup: function(t, e) { return e ? G(G(t, J.ajaxSettings), e) : G(J.ajaxSettings, t) }, ajaxPrefilter: L(ye), ajaxTransport: L(Te), ajax: function(t, e) {
					function r(t, e, r, s) { var l, h, m, y, x, S = e;
						2 !== T && (T = 2, a && clearTimeout(a), n = void 0, o = s || "", b.readyState = t > 0 ? 4 : 0, l = t >= 200 && 300 > t || 304 === t, r && (y = N(c, b, r)), y = H(c, y, b, l), l ? (c.ifModified && (x = b.getResponseHeader("Last-Modified"), x && (J.lastModified[i] = x), x = b.getResponseHeader("etag"), x && (J.etag[i] = x)), 204 === t || "HEAD" === c.type ? S = "nocontent" : 304 === t ? S = "notmodified" : (S = y.state, h = y.data, m = y.error, l = !m)) : (m = S, (t || !S) && (S = "error", 0 > t && (t = 0))), b.status = t, b.statusText = (e || S) + "", l ? f.resolveWith(p, [h, S, b]) : f.rejectWith(p, [b, S, m]), b.statusCode(g), g = void 0, u && d.trigger(l ? "ajaxSuccess" : "ajaxError", [b, c, l ? h : m]), v.fireWith(p, [b, S]), u && (d.trigger("ajaxComplete", [b, c]), --J.active || J.event.trigger("ajaxStop"))) } "object" == typeof t && (e = t, t = void 0), e = e || {}; var n, i, o, s, a, l, u, h, c = J.ajaxSetup({}, e),
						p = c.context || c,
						d = c.context && (p.nodeType || p.jquery) ? J(p) : J.event,
						f = J.Deferred(),
						v = J.Callbacks("once memory"),
						g = c.statusCode || {},
						m = {},
						y = {},
						T = 0,
						x = "canceled",
						b = { readyState: 0, getResponseHeader: function(t) { var e; if(2 === T) { if(!s)
										for(s = {}; e = de.exec(o);) s[e[1].toLowerCase()] = e[2];
									e = s[t.toLowerCase()] } return null == e ? null : e }, getAllResponseHeaders: function() { return 2 === T ? o : null }, setRequestHeader: function(t, e) { var r = t.toLowerCase(); return T || (t = y[r] = y[r] || t, m[t] = e), this }, overrideMimeType: function(t) { return T || (c.mimeType = t), this }, statusCode: function(t) { var e; if(t)
									if(2 > T)
										for(e in t) g[e] = [g[e], t[e]];
									else b.always(t[b.status]); return this }, abort: function(t) { var e = t || x; return n && n.abort(e), r(0, e), this } }; if(f.promise(b).complete = v.add, b.success = b.done, b.error = b.fail, c.url = ((t || c.url || be) + "").replace(ce, "").replace(ge, Se[1] + "//"), c.type = e.method || e.type || c.method || c.type, c.dataTypes = J.trim(c.dataType || "*").toLowerCase().match(dt) || [""], null == c.crossDomain && (l = me.exec(c.url.toLowerCase()), c.crossDomain = !(!l || l[1] === Se[1] && l[2] === Se[2] && (l[3] || ("http:" === l[1] ? "80" : "443")) === (Se[3] || ("http:" === Se[1] ? "80" : "443")))), c.data && c.processData && "string" != typeof c.data && (c.data = J.param(c.data, c.traditional)), I(ye, c, e, b), 2 === T) return b;
					u = J.event && c.global, u && 0 === J.active++ && J.event.trigger("ajaxStart"), c.type = c.type.toUpperCase(), c.hasContent = !ve.test(c.type), i = c.url, c.hasContent || (c.data && (i = c.url += (he.test(i) ? "&" : "?") + c.data, delete c.data), c.cache === !1 && (c.url = pe.test(i) ? i.replace(pe, "$1_=" + ue++) : i + (he.test(i) ? "&" : "?") + "_=" + ue++)), c.ifModified && (J.lastModified[i] && b.setRequestHeader("If-Modified-Since", J.lastModified[i]), J.etag[i] && b.setRequestHeader("If-None-Match", J.etag[i])), (c.data && c.hasContent && c.contentType !== !1 || e.contentType) && b.setRequestHeader("Content-Type", c.contentType), b.setRequestHeader("Accept", c.dataTypes[0] && c.accepts[c.dataTypes[0]] ? c.accepts[c.dataTypes[0]] + ("*" !== c.dataTypes[0] ? ", " + xe + "; q=0.01" : "") : c.accepts["*"]); for(h in c.headers) b.setRequestHeader(h, c.headers[h]); if(c.beforeSend && (c.beforeSend.call(p, b, c) === !1 || 2 === T)) return b.abort();
					x = "abort"; for(h in { success: 1, error: 1, complete: 1 }) b[h](c[h]); if(n = I(Te, c, e, b)) { b.readyState = 1, u && d.trigger("ajaxSend", [b, c]), c.async && c.timeout > 0 && (a = setTimeout(function() { b.abort("timeout") }, c.timeout)); try { T = 1, n.send(m, r) } catch(S) { if(!(2 > T)) throw S;
							r(-1, S) } } else r(-1, "No Transport"); return b }, getJSON: function(t, e, r) { return J.get(t, e, r, "json") }, getScript: function(t, e) { return J.get(t, void 0, e, "script") } }), J.each(["get", "post"], function(t, e) { J[e] = function(t, r, n, i) { return J.isFunction(r) && (i = i || n, n = r, r = void 0), J.ajax({ url: t, type: e, dataType: i, data: r, success: n }) } }), J._evalUrl = function(t) { return J.ajax({ url: t, type: "GET", dataType: "script", async: !1, global: !1, "throws": !0 }) }, J.fn.extend({ wrapAll: function(t) { var e; return J.isFunction(t) ? this.each(function(e) { J(this).wrapAll(t.call(this, e)) }) : (this[0] && (e = J(t, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && e.insertBefore(this[0]), e.map(function() { for(var t = this; t.firstElementChild;) t = t.firstElementChild; return t }).append(this)), this) }, wrapInner: function(t) { return this.each(J.isFunction(t) ? function(e) { J(this).wrapInner(t.call(this, e)) } : function() { var e = J(this),
							r = e.contents();
						r.length ? r.wrapAll(t) : e.append(t) }) }, wrap: function(t) { var e = J.isFunction(t); return this.each(function(r) { J(this).wrapAll(e ? t.call(this, r) : t) }) }, unwrap: function() { return this.parent().each(function() { J.nodeName(this, "body") || J(this).replaceWith(this.childNodes) }).end() } }), J.expr.filters.hidden = function(t) { return t.offsetWidth <= 0 && t.offsetHeight <= 0 },
			J.expr.filters.visible = function(t) { return !J.expr.filters.hidden(t) };
		var Ee = /%20/g,
			Ae = /\[\]$/,
			_e = /\r?\n/g,
			Me = /^(?:submit|button|image|reset|file)$/i,
			we = /^(?:input|select|textarea|keygen)/i;
		J.param = function(t, e) { var r, n = [],
				i = function(t, e) { e = J.isFunction(e) ? e() : null == e ? "" : e, n[n.length] = encodeURIComponent(t) + "=" + encodeURIComponent(e) }; if(void 0 === e && (e = J.ajaxSettings && J.ajaxSettings.traditional), J.isArray(t) || t.jquery && !J.isPlainObject(t)) J.each(t, function() { i(this.name, this.value) });
			else
				for(r in t) k(r, t[r], e, i); return n.join("&").replace(Ee, "+") }, J.fn.extend({ serialize: function() { return J.param(this.serializeArray()) }, serializeArray: function() { return this.map(function() { var t = J.prop(this, "elements"); return t ? J.makeArray(t) : this }).filter(function() { var t = this.type; return this.name && !J(this).is(":disabled") && we.test(this.nodeName) && !Me.test(t) && (this.checked || !At.test(t)) }).map(function(t, e) { var r = J(this).val(); return null == r ? null : J.isArray(r) ? J.map(r, function(t) { return { name: e.name, value: t.replace(_e, "\r\n") } }) : { name: e.name, value: r.replace(_e, "\r\n") } }).get() } }), J.ajaxSettings.xhr = function() { try { return new XMLHttpRequest } catch(t) {} };
		var Ce = 0,
			Pe = {},
			Re = { 0: 200, 1223: 204 },
			De = J.ajaxSettings.xhr();
		t.attachEvent && t.attachEvent("onunload", function() { for(var t in Pe) Pe[t]() }), Q.cors = !!De && "withCredentials" in De, Q.ajax = De = !!De, J.ajaxTransport(function(t) { var e; return Q.cors || De && !t.crossDomain ? { send: function(r, n) { var i, o = t.xhr(),
						s = ++Ce; if(o.open(t.type, t.url, t.async, t.username, t.password), t.xhrFields)
						for(i in t.xhrFields) o[i] = t.xhrFields[i];
					t.mimeType && o.overrideMimeType && o.overrideMimeType(t.mimeType), t.crossDomain || r["X-Requested-With"] || (r["X-Requested-With"] = "XMLHttpRequest"); for(i in r) o.setRequestHeader(i, r[i]);
					e = function(t) { return function() { e && (delete Pe[s], e = o.onload = o.onerror = null, "abort" === t ? o.abort() : "error" === t ? n(o.status, o.statusText) : n(Re[o.status] || o.status, o.statusText, "string" == typeof o.responseText ? { text: o.responseText } : void 0, o.getAllResponseHeaders())) } }, o.onload = e(), o.onerror = e("error"), e = Pe[s] = e("abort"); try { o.send(t.hasContent && t.data || null) } catch(a) { if(e) throw a } }, abort: function() { e && e() } } : void 0 }), J.ajaxSetup({ accepts: { script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript" }, contents: { script: /(?:java|ecma)script/ }, converters: { "text script": function(t) { return J.globalEval(t), t } } }), J.ajaxPrefilter("script", function(t) { void 0 === t.cache && (t.cache = !1), t.crossDomain && (t.type = "GET") }), J.ajaxTransport("script", function(t) { if(t.crossDomain) { var e, r; return { send: function(n, i) { e = J("<script>").prop({ async: !0, charset: t.scriptCharset, src: t.url }).on("load error", r = function(t) { e.remove(), r = null, t && i("error" === t.type ? 404 : 200, t.type) }), Z.head.appendChild(e[0]) }, abort: function() { r && r() } } } });
		var Be = [],
			Oe = /(=)\?(?=&|$)|\?\?/;
		J.ajaxSetup({ jsonp: "callback", jsonpCallback: function() { var t = Be.pop() || J.expando + "_" + ue++; return this[t] = !0, t } }), J.ajaxPrefilter("json jsonp", function(e, r, n) { var i, o, s, a = e.jsonp !== !1 && (Oe.test(e.url) ? "url" : "string" == typeof e.data && !(e.contentType || "").indexOf("application/x-www-form-urlencoded") && Oe.test(e.data) && "data"); return a || "jsonp" === e.dataTypes[0] ? (i = e.jsonpCallback = J.isFunction(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, a ? e[a] = e[a].replace(Oe, "$1" + i) : e.jsonp !== !1 && (e.url += (he.test(e.url) ? "&" : "?") + e.jsonp + "=" + i), e.converters["script json"] = function() { return s || J.error(i + " was not called"), s[0] }, e.dataTypes[0] = "json", o = t[i], t[i] = function() { s = arguments }, n.always(function() { t[i] = o, e[i] && (e.jsonpCallback = r.jsonpCallback, Be.push(i)), s && J.isFunction(o) && o(s[0]), s = o = void 0 }), "script") : void 0 }), J.parseHTML = function(t, e, r) { if(!t || "string" != typeof t) return null; "boolean" == typeof e && (r = e, e = !1), e = e || Z; var n = st.exec(t),
				i = !r && []; return n ? [e.createElement(n[1])] : (n = J.buildFragment([t], e, i), i && i.length && J(i).remove(), J.merge([], n.childNodes)) };
		var Fe = J.fn.load;
		J.fn.load = function(t, e, r) { if("string" != typeof t && Fe) return Fe.apply(this, arguments); var n, i, o, s = this,
				a = t.indexOf(" "); return a >= 0 && (n = J.trim(t.slice(a)), t = t.slice(0, a)), J.isFunction(e) ? (r = e, e = void 0) : e && "object" == typeof e && (i = "POST"), s.length > 0 && J.ajax({ url: t, type: i, dataType: "html", data: e }).done(function(t) { o = arguments, s.html(n ? J("<div>").append(J.parseHTML(t)).find(n) : t) }).complete(r && function(t, e) { s.each(r, o || [t.responseText, e, t]) }), this }, J.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(t, e) { J.fn[e] = function(t) { return this.on(e, t) } }), J.expr.filters.animated = function(t) { return J.grep(J.timers, function(e) { return t === e.elem }).length };
		var Le = t.document.documentElement;
		J.offset = { setOffset: function(t, e, r) { var n, i, o, s, a, l, u, h = J.css(t, "position"),
					c = J(t),
					p = {}; "static" === h && (t.style.position = "relative"), a = c.offset(), o = J.css(t, "top"), l = J.css(t, "left"), u = ("absolute" === h || "fixed" === h) && (o + l).indexOf("auto") > -1, u ? (n = c.position(), s = n.top, i = n.left) : (s = parseFloat(o) || 0, i = parseFloat(l) || 0), J.isFunction(e) && (e = e.call(t, r, a)), null != e.top && (p.top = e.top - a.top + s), null != e.left && (p.left = e.left - a.left + i), "using" in e ? e.using.call(t, p) : c.css(p) } }, J.fn.extend({ offset: function(t) { if(arguments.length) return void 0 === t ? this : this.each(function(e) { J.offset.setOffset(this, t, e) }); var e, r, n = this[0],
					i = { top: 0, left: 0 },
					o = n && n.ownerDocument; return o ? (e = o.documentElement, J.contains(e, n) ? (typeof n.getBoundingClientRect !== _t && (i = n.getBoundingClientRect()), r = U(o), { top: i.top + r.pageYOffset - e.clientTop, left: i.left + r.pageXOffset - e.clientLeft }) : i) : void 0 }, position: function() { if(this[0]) { var t, e, r = this[0],
						n = { top: 0, left: 0 }; return "fixed" === J.css(r, "position") ? e = r.getBoundingClientRect() : (t = this.offsetParent(), e = this.offset(), J.nodeName(t[0], "html") || (n = t.offset()), n.top += J.css(t[0], "borderTopWidth", !0), n.left += J.css(t[0], "borderLeftWidth", !0)), { top: e.top - n.top - J.css(r, "marginTop", !0), left: e.left - n.left - J.css(r, "marginLeft", !0) } } }, offsetParent: function() { return this.map(function() { for(var t = this.offsetParent || Le; t && !J.nodeName(t, "html") && "static" === J.css(t, "position");) t = t.offsetParent; return t || Le }) } }), J.each({ scrollLeft: "pageXOffset", scrollTop: "pageYOffset" }, function(e, r) { var n = "pageYOffset" === r;
			J.fn[e] = function(i) { return gt(this, function(e, i, o) { var s = U(e); return void 0 === o ? s ? s[r] : e[i] : void(s ? s.scrollTo(n ? t.pageXOffset : o, n ? o : t.pageYOffset) : e[i] = o) }, e, i, arguments.length, null) } }), J.each(["top", "left"], function(t, e) { J.cssHooks[e] = S(Q.pixelPosition, function(t, r) { return r ? (r = b(t, e), jt.test(r) ? J(t).position()[e] + "px" : r) : void 0 }) }), J.each({ Height: "height", Width: "width" }, function(t, e) { J.each({ padding: "inner" + t, content: e, "": "outer" + t }, function(r, n) { J.fn[n] = function(n, i) { var o = arguments.length && (r || "boolean" != typeof n),
						s = r || (n === !0 || i === !0 ? "margin" : "border"); return gt(this, function(e, r, n) { var i; return J.isWindow(e) ? e.document.documentElement["client" + t] : 9 === e.nodeType ? (i = e.documentElement, Math.max(e.body["scroll" + t], i["scroll" + t], e.body["offset" + t], i["offset" + t], i["client" + t])) : void 0 === n ? J.css(e, r, s) : J.style(e, r, n, s) }, e, o ? n : void 0, o, null) } }) }), J.fn.size = function() { return this.length }, J.fn.andSelf = J.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function() { return J });
		var Ie = t.jQuery,
			Ge = t.$;
		return J.noConflict = function(e) { return t.$ === J && (t.$ = Ge), e && t.jQuery === J && (t.jQuery = Ie), J }, typeof e === _t && (t.jQuery = t.$ = J), J
	}), ! function(t, e) {
		t(function() {
			"use strict";

			function t(t, e) { return null != t && null != e && t.toLowerCase() === e.toLowerCase() }

			function r(t, e) { var r, n, i = t.length; if(!i || !e) return !1; for(r = e.toLowerCase(), n = 0; i > n; ++n)
					if(r === t[n].toLowerCase()) return !0; return !1 }

			function n(t) { for(var e in t) a.call(t, e) && (t[e] = new RegExp(t[e], "i")) }

			function i(t, e) { this.ua = t || "", this._cache = {}, this.maxPhoneWidth = e || 600 }
			var o = {};
			o.mobileDetectRules = {
				phones: { iPhone: "\\biPhone\\b|\\biPod\\b", BlackBerry: "BlackBerry|\\bBB10\\b|rim[0-9]+", HTC: "HTC|HTC.*(Sensation|Evo|Vision|Explorer|6800|8100|8900|A7272|S510e|C110e|Legend|Desire|T8282)|APX515CKT|Qtek9090|APA9292KT|HD_mini|Sensation.*Z710e|PG86100|Z715e|Desire.*(A8181|HD)|ADR6200|ADR6400L|ADR6425|001HT|Inspire 4G|Android.*\\bEVO\\b|T-Mobile G1|Z520m", Nexus: "Nexus One|Nexus S|Galaxy.*Nexus|Android.*Nexus.*Mobile|Nexus 4|Nexus 5|Nexus 6", Dell: "Dell.*Streak|Dell.*Aero|Dell.*Venue|DELL.*Venue Pro|Dell Flash|Dell Smoke|Dell Mini 3iX|XCD28|XCD35|\\b001DL\\b|\\b101DL\\b|\\bGS01\\b", Motorola: "Motorola|DROIDX|DROID BIONIC|\\bDroid\\b.*Build|Android.*Xoom|HRI39|MOT-|A1260|A1680|A555|A853|A855|A953|A955|A956|Motorola.*ELECTRIFY|Motorola.*i1|i867|i940|MB200|MB300|MB501|MB502|MB508|MB511|MB520|MB525|MB526|MB611|MB612|MB632|MB810|MB855|MB860|MB861|MB865|MB870|ME501|ME502|ME511|ME525|ME600|ME632|ME722|ME811|ME860|ME863|ME865|MT620|MT710|MT716|MT720|MT810|MT870|MT917|Motorola.*TITANIUM|WX435|WX445|XT300|XT301|XT311|XT316|XT317|XT319|XT320|XT390|XT502|XT530|XT531|XT532|XT535|XT603|XT610|XT611|XT615|XT681|XT701|XT702|XT711|XT720|XT800|XT806|XT860|XT862|XT875|XT882|XT883|XT894|XT901|XT907|XT909|XT910|XT912|XT928|XT926|XT915|XT919|XT925|XT1021|\\bMoto E\\b", Samsung: "Samsung|SM-G9250|GT-19300|SGH-I337|BGT-S5230|GT-B2100|GT-B2700|GT-B2710|GT-B3210|GT-B3310|GT-B3410|GT-B3730|GT-B3740|GT-B5510|GT-B5512|GT-B5722|GT-B6520|GT-B7300|GT-B7320|GT-B7330|GT-B7350|GT-B7510|GT-B7722|GT-B7800|GT-C3010|GT-C3011|GT-C3060|GT-C3200|GT-C3212|GT-C3212I|GT-C3262|GT-C3222|GT-C3300|GT-C3300K|GT-C3303|GT-C3303K|GT-C3310|GT-C3322|GT-C3330|GT-C3350|GT-C3500|GT-C3510|GT-C3530|GT-C3630|GT-C3780|GT-C5010|GT-C5212|GT-C6620|GT-C6625|GT-C6712|GT-E1050|GT-E1070|GT-E1075|GT-E1080|GT-E1081|GT-E1085|GT-E1087|GT-E1100|GT-E1107|GT-E1110|GT-E1120|GT-E1125|GT-E1130|GT-E1160|GT-E1170|GT-E1175|GT-E1180|GT-E1182|GT-E1200|GT-E1210|GT-E1225|GT-E1230|GT-E1390|GT-E2100|GT-E2120|GT-E2121|GT-E2152|GT-E2220|GT-E2222|GT-E2230|GT-E2232|GT-E2250|GT-E2370|GT-E2550|GT-E2652|GT-E3210|GT-E3213|GT-I5500|GT-I5503|GT-I5700|GT-I5800|GT-I5801|GT-I6410|GT-I6420|GT-I7110|GT-I7410|GT-I7500|GT-I8000|GT-I8150|GT-I8160|GT-I8190|GT-I8320|GT-I8330|GT-I8350|GT-I8530|GT-I8700|GT-I8703|GT-I8910|GT-I9000|GT-I9001|GT-I9003|GT-I9010|GT-I9020|GT-I9023|GT-I9070|GT-I9082|GT-I9100|GT-I9103|GT-I9220|GT-I9250|GT-I9300|GT-I9305|GT-I9500|GT-I9505|GT-M3510|GT-M5650|GT-M7500|GT-M7600|GT-M7603|GT-M8800|GT-M8910|GT-N7000|GT-S3110|GT-S3310|GT-S3350|GT-S3353|GT-S3370|GT-S3650|GT-S3653|GT-S3770|GT-S3850|GT-S5210|GT-S5220|GT-S5229|GT-S5230|GT-S5233|GT-S5250|GT-S5253|GT-S5260|GT-S5263|GT-S5270|GT-S5300|GT-S5330|GT-S5350|GT-S5360|GT-S5363|GT-S5369|GT-S5380|GT-S5380D|GT-S5560|GT-S5570|GT-S5600|GT-S5603|GT-S5610|GT-S5620|GT-S5660|GT-S5670|GT-S5690|GT-S5750|GT-S5780|GT-S5830|GT-S5839|GT-S6102|GT-S6500|GT-S7070|GT-S7200|GT-S7220|GT-S7230|GT-S7233|GT-S7250|GT-S7500|GT-S7530|GT-S7550|GT-S7562|GT-S7710|GT-S8000|GT-S8003|GT-S8500|GT-S8530|GT-S8600|SCH-A310|SCH-A530|SCH-A570|SCH-A610|SCH-A630|SCH-A650|SCH-A790|SCH-A795|SCH-A850|SCH-A870|SCH-A890|SCH-A930|SCH-A950|SCH-A970|SCH-A990|SCH-I100|SCH-I110|SCH-I400|SCH-I405|SCH-I500|SCH-I510|SCH-I515|SCH-I600|SCH-I730|SCH-I760|SCH-I770|SCH-I830|SCH-I910|SCH-I920|SCH-I959|SCH-LC11|SCH-N150|SCH-N300|SCH-R100|SCH-R300|SCH-R351|SCH-R400|SCH-R410|SCH-T300|SCH-U310|SCH-U320|SCH-U350|SCH-U360|SCH-U365|SCH-U370|SCH-U380|SCH-U410|SCH-U430|SCH-U450|SCH-U460|SCH-U470|SCH-U490|SCH-U540|SCH-U550|SCH-U620|SCH-U640|SCH-U650|SCH-U660|SCH-U700|SCH-U740|SCH-U750|SCH-U810|SCH-U820|SCH-U900|SCH-U940|SCH-U960|SCS-26UC|SGH-A107|SGH-A117|SGH-A127|SGH-A137|SGH-A157|SGH-A167|SGH-A177|SGH-A187|SGH-A197|SGH-A227|SGH-A237|SGH-A257|SGH-A437|SGH-A517|SGH-A597|SGH-A637|SGH-A657|SGH-A667|SGH-A687|SGH-A697|SGH-A707|SGH-A717|SGH-A727|SGH-A737|SGH-A747|SGH-A767|SGH-A777|SGH-A797|SGH-A817|SGH-A827|SGH-A837|SGH-A847|SGH-A867|SGH-A877|SGH-A887|SGH-A897|SGH-A927|SGH-B100|SGH-B130|SGH-B200|SGH-B220|SGH-C100|SGH-C110|SGH-C120|SGH-C130|SGH-C140|SGH-C160|SGH-C170|SGH-C180|SGH-C200|SGH-C207|SGH-C210|SGH-C225|SGH-C230|SGH-C417|SGH-C450|SGH-D307|SGH-D347|SGH-D357|SGH-D407|SGH-D415|SGH-D780|SGH-D807|SGH-D980|SGH-E105|SGH-E200|SGH-E315|SGH-E316|SGH-E317|SGH-E335|SGH-E590|SGH-E635|SGH-E715|SGH-E890|SGH-F300|SGH-F480|SGH-I200|SGH-I300|SGH-I320|SGH-I550|SGH-I577|SGH-I600|SGH-I607|SGH-I617|SGH-I627|SGH-I637|SGH-I677|SGH-I700|SGH-I717|SGH-I727|SGH-i747M|SGH-I777|SGH-I780|SGH-I827|SGH-I847|SGH-I857|SGH-I896|SGH-I897|SGH-I900|SGH-I907|SGH-I917|SGH-I927|SGH-I937|SGH-I997|SGH-J150|SGH-J200|SGH-L170|SGH-L700|SGH-M110|SGH-M150|SGH-M200|SGH-N105|SGH-N500|SGH-N600|SGH-N620|SGH-N625|SGH-N700|SGH-N710|SGH-P107|SGH-P207|SGH-P300|SGH-P310|SGH-P520|SGH-P735|SGH-P777|SGH-Q105|SGH-R210|SGH-R220|SGH-R225|SGH-S105|SGH-S307|SGH-T109|SGH-T119|SGH-T139|SGH-T209|SGH-T219|SGH-T229|SGH-T239|SGH-T249|SGH-T259|SGH-T309|SGH-T319|SGH-T329|SGH-T339|SGH-T349|SGH-T359|SGH-T369|SGH-T379|SGH-T409|SGH-T429|SGH-T439|SGH-T459|SGH-T469|SGH-T479|SGH-T499|SGH-T509|SGH-T519|SGH-T539|SGH-T559|SGH-T589|SGH-T609|SGH-T619|SGH-T629|SGH-T639|SGH-T659|SGH-T669|SGH-T679|SGH-T709|SGH-T719|SGH-T729|SGH-T739|SGH-T746|SGH-T749|SGH-T759|SGH-T769|SGH-T809|SGH-T819|SGH-T839|SGH-T919|SGH-T929|SGH-T939|SGH-T959|SGH-T989|SGH-U100|SGH-U200|SGH-U800|SGH-V205|SGH-V206|SGH-X100|SGH-X105|SGH-X120|SGH-X140|SGH-X426|SGH-X427|SGH-X475|SGH-X495|SGH-X497|SGH-X507|SGH-X600|SGH-X610|SGH-X620|SGH-X630|SGH-X700|SGH-X820|SGH-X890|SGH-Z130|SGH-Z150|SGH-Z170|SGH-ZX10|SGH-ZX20|SHW-M110|SPH-A120|SPH-A400|SPH-A420|SPH-A460|SPH-A500|SPH-A560|SPH-A600|SPH-A620|SPH-A660|SPH-A700|SPH-A740|SPH-A760|SPH-A790|SPH-A800|SPH-A820|SPH-A840|SPH-A880|SPH-A900|SPH-A940|SPH-A960|SPH-D600|SPH-D700|SPH-D710|SPH-D720|SPH-I300|SPH-I325|SPH-I330|SPH-I350|SPH-I500|SPH-I600|SPH-I700|SPH-L700|SPH-M100|SPH-M220|SPH-M240|SPH-M300|SPH-M305|SPH-M320|SPH-M330|SPH-M350|SPH-M360|SPH-M370|SPH-M380|SPH-M510|SPH-M540|SPH-M550|SPH-M560|SPH-M570|SPH-M580|SPH-M610|SPH-M620|SPH-M630|SPH-M800|SPH-M810|SPH-M850|SPH-M900|SPH-M910|SPH-M920|SPH-M930|SPH-N100|SPH-N200|SPH-N240|SPH-N300|SPH-N400|SPH-Z400|SWC-E100|SCH-i909|GT-N7100|GT-N7105|SCH-I535|SM-N900A|SGH-I317|SGH-T999L|GT-S5360B|GT-I8262|GT-S6802|GT-S6312|GT-S6310|GT-S5312|GT-S5310|GT-I9105|GT-I8510|GT-S6790N|SM-G7105|SM-N9005|GT-S5301|GT-I9295|GT-I9195|SM-C101|GT-S7392|GT-S7560|GT-B7610|GT-I5510|GT-S7582|GT-S7530E|GT-I8750|SM-G9006V|SM-G9008V|SM-G9009D|SM-G900A|SM-G900D|SM-G900F|SM-G900H|SM-G900I|SM-G900J|SM-G900K|SM-G900L|SM-G900M|SM-G900P|SM-G900R4|SM-G900S|SM-G900T|SM-G900V|SM-G900W8|SHV-E160K|SCH-P709|SCH-P729|SM-T2558|GT-I9205", LG: "\\bLG\\b;|LG[- ]?(C800|C900|E400|E610|E900|E-900|F160|F180K|F180L|F180S|730|855|L160|LS740|LS840|LS970|LU6200|MS690|MS695|MS770|MS840|MS870|MS910|P500|P700|P705|VM696|AS680|AS695|AX840|C729|E970|GS505|272|C395|E739BK|E960|L55C|L75C|LS696|LS860|P769BK|P350|P500|P509|P870|UN272|US730|VS840|VS950|LN272|LN510|LS670|LS855|LW690|MN270|MN510|P509|P769|P930|UN200|UN270|UN510|UN610|US670|US740|US760|UX265|UX840|VN271|VN530|VS660|VS700|VS740|VS750|VS910|VS920|VS930|VX9200|VX11000|AX840A|LW770|P506|P925|P999|E612|D955|D802|MS323)", Sony: "SonyST|SonyLT|SonyEricsson|SonyEricssonLT15iv|LT18i|E10i|LT28h|LT26w|SonyEricssonMT27i|C5303|C6902|C6903|C6906|C6943|D2533", Asus: "Asus.*Galaxy|PadFone.*Mobile", Micromax: "Micromax.*\\b(A210|A92|A88|A72|A111|A110Q|A115|A116|A110|A90S|A26|A51|A35|A54|A25|A27|A89|A68|A65|A57|A90)\\b", Palm: "PalmSource|Palm", Vertu: "Vertu|Vertu.*Ltd|Vertu.*Ascent|Vertu.*Ayxta|Vertu.*Constellation(F|Quest)?|Vertu.*Monika|Vertu.*Signature", Pantech: "PANTECH|IM-A850S|IM-A840S|IM-A830L|IM-A830K|IM-A830S|IM-A820L|IM-A810K|IM-A810S|IM-A800S|IM-T100K|IM-A725L|IM-A780L|IM-A775C|IM-A770K|IM-A760S|IM-A750K|IM-A740S|IM-A730S|IM-A720L|IM-A710K|IM-A690L|IM-A690S|IM-A650S|IM-A630K|IM-A600S|VEGA PTL21|PT003|P8010|ADR910L|P6030|P6020|P9070|P4100|P9060|P5000|CDM8992|TXT8045|ADR8995|IS11PT|P2030|P6010|P8000|PT002|IS06|CDM8999|P9050|PT001|TXT8040|P2020|P9020|P2000|P7040|P7000|C790", Fly: "IQ230|IQ444|IQ450|IQ440|IQ442|IQ441|IQ245|IQ256|IQ236|IQ255|IQ235|IQ245|IQ275|IQ240|IQ285|IQ280|IQ270|IQ260|IQ250", Wiko: "KITE 4G|HIGHWAY|GETAWAY|STAIRWAY|DARKSIDE|DARKFULL|DARKNIGHT|DARKMOON|SLIDE|WAX 4G|RAINBOW|BLOOM|SUNSET|GOA|LENNY|BARRY|IGGY|OZZY|CINK FIVE|CINK PEAX|CINK PEAX 2|CINK SLIM|CINK SLIM 2|CINK +|CINK KING|CINK PEAX|CINK SLIM|SUBLIM", iMobile: "i-mobile (IQ|i-STYLE|idea|ZAA|Hitz)", SimValley: "\\b(SP-80|XT-930|SX-340|XT-930|SX-310|SP-360|SP60|SPT-800|SP-120|SPT-800|SP-140|SPX-5|SPX-8|SP-100|SPX-8|SPX-12)\\b", Wolfgang: "AT-B24D|AT-AS50HD|AT-AS40W|AT-AS55HD|AT-AS45q2|AT-B26D|AT-AS50Q", Alcatel: "Alcatel", Nintendo: "Nintendo 3DS", Amoi: "Amoi", INQ: "INQ", GenericPhone: "Tapatalk|PDA;|SAGEM|\\bmmp\\b|pocket|\\bpsp\\b|symbian|Smartphone|smartfon|treo|up.browser|up.link|vodafone|\\bwap\\b|nokia|Series40|Series60|S60|SonyEricsson|N900|MAUI.*WAP.*Browser" },
				tablets: {
					iPad: "iPad|iPad.*Mobile",
					NexusTablet: "Android.*Nexus[\\s]+(7|9|10)",
					SamsungTablet: "SAMSUNG.*Tablet|Galaxy.*Tab|SC-01C|GT-P1000|GT-P1003|GT-P1010|GT-P3105|GT-P6210|GT-P6800|GT-P6810|GT-P7100|GT-P7300|GT-P7310|GT-P7500|GT-P7510|SCH-I800|SCH-I815|SCH-I905|SGH-I957|SGH-I987|SGH-T849|SGH-T859|SGH-T869|SPH-P100|GT-P3100|GT-P3108|GT-P3110|GT-P5100|GT-P5110|GT-P6200|GT-P7320|GT-P7511|GT-N8000|GT-P8510|SGH-I497|SPH-P500|SGH-T779|SCH-I705|SCH-I915|GT-N8013|GT-P3113|GT-P5113|GT-P8110|GT-N8010|GT-N8005|GT-N8020|GT-P1013|GT-P6201|GT-P7501|GT-N5100|GT-N5105|GT-N5110|SHV-E140K|SHV-E140L|SHV-E140S|SHV-E150S|SHV-E230K|SHV-E230L|SHV-E230S|SHW-M180K|SHW-M180L|SHW-M180S|SHW-M180W|SHW-M300W|SHW-M305W|SHW-M380K|SHW-M380S|SHW-M380W|SHW-M430W|SHW-M480K|SHW-M480S|SHW-M480W|SHW-M485W|SHW-M486W|SHW-M500W|GT-I9228|SCH-P739|SCH-I925|GT-I9200|GT-P5200|GT-P5210|GT-P5210X|SM-T311|SM-T310|SM-T310X|SM-T210|SM-T210R|SM-T211|SM-P600|SM-P601|SM-P605|SM-P900|SM-P901|SM-T217|SM-T217A|SM-T217S|SM-P6000|SM-T3100|SGH-I467|XE500|SM-T110|GT-P5220|GT-I9200X|GT-N5110X|GT-N5120|SM-P905|SM-T111|SM-T2105|SM-T315|SM-T320|SM-T320X|SM-T321|SM-T520|SM-T525|SM-T530NU|SM-T230NU|SM-T330NU|SM-T900|XE500T1C|SM-P605V|SM-P905V|SM-T337V|SM-T537V|SM-T707V|SM-T807V|SM-P600X|SM-P900X|SM-T210X|SM-T230|SM-T230X|SM-T325|GT-P7503|SM-T531|SM-T330|SM-T530|SM-T705|SM-T705C|SM-T535|SM-T331|SM-T800|SM-T700|SM-T537|SM-T807|SM-P907A|SM-T337A|SM-T537A|SM-T707A|SM-T807A|SM-T237|SM-T807P|SM-P607T|SM-T217T|SM-T337T|SM-T807T|SM-T116NQ|SM-P550|SM-T350|SM-T550|SM-T9000|SM-P9000|SM-T705Y|SM-T805|GT-P3113|SM-T710|SM-T810|SM-T360|SM-T533|SM-T113|SM-T335|SM-T715",
					Kindle: "Kindle|Silk.*Accelerated|Android.*\\b(KFOT|KFTT|KFJWI|KFJWA|KFOTE|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|WFJWAE|KFSAWA|KFSAWI|KFASWI)\\b",
					SurfaceTablet: "Windows NT [0-9.]+; ARM;.*(Tablet|ARMBJS)",
					HPTablet: "HP Slate (7|8|10)|HP ElitePad 900|hp-tablet|EliteBook.*Touch|HP 8|Slate 21|HP SlateBook 10",
					AsusTablet: "^.*PadFone((?!Mobile).)*$|Transformer|TF101|TF101G|TF300T|TF300TG|TF300TL|TF700T|TF700KL|TF701T|TF810C|ME171|ME301T|ME302C|ME371MG|ME370T|ME372MG|ME172V|ME173X|ME400C|Slider SL101|\\bK00F\\b|\\bK00C\\b|\\bK00E\\b|\\bK00L\\b|TX201LA|ME176C|ME102A|\\bM80TA\\b|ME372CL|ME560CG|ME372CG|ME302KL| K010 | K017 |ME572C|ME103K|ME170C|ME171C|\\bME70C\\b|ME581C|ME581CL|ME8510C|ME181C",
					BlackBerryTablet: "PlayBook|RIM Tablet",
					HTCtablet: "HTC_Flyer_P512|HTC Flyer|HTC Jetstream|HTC-P715a|HTC EVO View 4G|PG41200|PG09410",
					MotorolaTablet: "xoom|sholest|MZ615|MZ605|MZ505|MZ601|MZ602|MZ603|MZ604|MZ606|MZ607|MZ608|MZ609|MZ615|MZ616|MZ617",
					NookTablet: "Android.*Nook|NookColor|nook browser|BNRV200|BNRV200A|BNTV250|BNTV250A|BNTV400|BNTV600|LogicPD Zoom2",
					AcerTablet: "Android.*; \\b(A100|A101|A110|A200|A210|A211|A500|A501|A510|A511|A700|A701|W500|W500P|W501|W501P|W510|W511|W700|G100|G100W|B1-A71|B1-710|B1-711|A1-810|A1-811|A1-830)\\b|W3-810|\\bA3-A10\\b|\\bA3-A11\\b",
					ToshibaTablet: "Android.*(AT100|AT105|AT200|AT205|AT270|AT275|AT300|AT305|AT1S5|AT500|AT570|AT700|AT830)|TOSHIBA.*FOLIO",
					LGTablet: "\\bL-06C|LG-V909|LG-V900|LG-V700|LG-V510|LG-V500|LG-V410|LG-V400|LG-VK810\\b",
					FujitsuTablet: "Android.*\\b(F-01D|F-02F|F-05E|F-10D|M532|Q572)\\b",
					PrestigioTablet: "PMP3170B|PMP3270B|PMP3470B|PMP7170B|PMP3370B|PMP3570C|PMP5870C|PMP3670B|PMP5570C|PMP5770D|PMP3970B|PMP3870C|PMP5580C|PMP5880D|PMP5780D|PMP5588C|PMP7280C|PMP7280C3G|PMP7280|PMP7880D|PMP5597D|PMP5597|PMP7100D|PER3464|PER3274|PER3574|PER3884|PER5274|PER5474|PMP5097CPRO|PMP5097|PMP7380D|PMP5297C|PMP5297C_QUAD|PMP812E|PMP812E3G|PMP812F|PMP810E|PMP880TD|PMT3017|PMT3037|PMT3047|PMT3057|PMT7008|PMT5887|PMT5001|PMT5002",
					LenovoTablet: "Idea(Tab|Pad)( A1|A10| K1|)|ThinkPad([ ]+)?Tablet|Lenovo.*(S2109|S2110|S5000|S6000|K3011|A3000|A3500|A1000|A2107|A2109|A1107|A5500|A7600|B6000|B8000|B8080)(-|)(FL|F|HV|H|)",
					DellTablet: "Venue 11|Venue 8|Venue 7|Dell Streak 10|Dell Streak 7",
					YarvikTablet: "Android.*\\b(TAB210|TAB211|TAB224|TAB250|TAB260|TAB264|TAB310|TAB360|TAB364|TAB410|TAB411|TAB420|TAB424|TAB450|TAB460|TAB461|TAB464|TAB465|TAB467|TAB468|TAB07-100|TAB07-101|TAB07-150|TAB07-151|TAB07-152|TAB07-200|TAB07-201-3G|TAB07-210|TAB07-211|TAB07-212|TAB07-214|TAB07-220|TAB07-400|TAB07-485|TAB08-150|TAB08-200|TAB08-201-3G|TAB08-201-30|TAB09-100|TAB09-211|TAB09-410|TAB10-150|TAB10-201|TAB10-211|TAB10-400|TAB10-410|TAB13-201|TAB274EUK|TAB275EUK|TAB374EUK|TAB462EUK|TAB474EUK|TAB9-200)\\b",
					MedionTablet: "Android.*\\bOYO\\b|LIFE.*(P9212|P9514|P9516|S9512)|LIFETAB",
					ArnovaTablet: "AN10G2|AN7bG3|AN7fG3|AN8G3|AN8cG3|AN7G3|AN9G3|AN7dG3|AN7dG3ST|AN7dG3ChildPad|AN10bG3|AN10bG3DT|AN9G2",
					IntensoTablet: "INM8002KP|INM1010FP|INM805ND|Intenso Tab|TAB1004",
					IRUTablet: "M702pro",
					MegafonTablet: "MegaFon V9|\\bZTE V9\\b|Android.*\\bMT7A\\b",
					EbodaTablet: "E-Boda (Supreme|Impresspeed|Izzycomm|Essential)",
					AllViewTablet: "Allview.*(Viva|Alldro|City|Speed|All TV|Frenzy|Quasar|Shine|TX1|AX1|AX2)",
					ArchosTablet: "\\b(101G9|80G9|A101IT)\\b|Qilive 97R|Archos5|\\bARCHOS (70|79|80|90|97|101|FAMILYPAD|)(b|)(G10| Cobalt| TITANIUM(HD|)| Xenon| Neon|XSK| 2| XS 2| PLATINUM| CARBON|GAMEPAD)\\b",
					AinolTablet: "NOVO7|NOVO8|NOVO10|Novo7Aurora|Novo7Basic|NOVO7PALADIN|novo9-Spark",
					SonyTablet: "Sony.*Tablet|Xperia Tablet|Sony Tablet S|SO-03E|SGPT12|SGPT13|SGPT114|SGPT121|SGPT122|SGPT123|SGPT111|SGPT112|SGPT113|SGPT131|SGPT132|SGPT133|SGPT211|SGPT212|SGPT213|SGP311|SGP312|SGP321|EBRD1101|EBRD1102|EBRD1201|SGP351|SGP341|SGP511|SGP512|SGP521|SGP541|SGP551|SGP621|SGP612|SOT31",
					PhilipsTablet: "\\b(PI2010|PI3000|PI3100|PI3105|PI3110|PI3205|PI3210|PI3900|PI4010|PI7000|PI7100)\\b",
					CubeTablet: "Android.*(K8GT|U9GT|U10GT|U16GT|U17GT|U18GT|U19GT|U20GT|U23GT|U30GT)|CUBE U8GT",
					CobyTablet: "MID1042|MID1045|MID1125|MID1126|MID7012|MID7014|MID7015|MID7034|MID7035|MID7036|MID7042|MID7048|MID7127|MID8042|MID8048|MID8127|MID9042|MID9740|MID9742|MID7022|MID7010",
					MIDTablet: "M9701|M9000|M9100|M806|M1052|M806|T703|MID701|MID713|MID710|MID727|MID760|MID830|MID728|MID933|MID125|MID810|MID732|MID120|MID930|MID800|MID731|MID900|MID100|MID820|MID735|MID980|MID130|MID833|MID737|MID960|MID135|MID860|MID736|MID140|MID930|MID835|MID733",
					MSITablet: "MSI \\b(Primo 73K|Primo 73L|Primo 81L|Primo 77|Primo 93|Primo 75|Primo 76|Primo 73|Primo 81|Primo 91|Primo 90|Enjoy 71|Enjoy 7|Enjoy 10)\\b",
					SMiTTablet: "Android.*(\\bMID\\b|MID-560|MTV-T1200|MTV-PND531|MTV-P1101|MTV-PND530)",
					RockChipTablet: "Android.*(RK2818|RK2808A|RK2918|RK3066)|RK2738|RK2808A",
					FlyTablet: "IQ310|Fly Vision",
					bqTablet: "Android.*(bq)?.*(Elcano|Curie|Edison|Maxwell|Kepler|Pascal|Tesla|Hypatia|Platon|Newton|Livingstone|Cervantes|Avant|Aquaris E10)|Maxwell.*Lite|Maxwell.*Plus",
					HuaweiTablet: "MediaPad|MediaPad 7 Youth|IDEOS S7|S7-201c|S7-202u|S7-101|S7-103|S7-104|S7-105|S7-106|S7-201|S7-Slim",
					NecTablet: "\\bN-06D|\\bN-08D",
					PantechTablet: "Pantech.*P4100",
					BronchoTablet: "Broncho.*(N701|N708|N802|a710)",
					VersusTablet: "TOUCHPAD.*[78910]|\\bTOUCHTAB\\b",
					ZyncTablet: "z1000|Z99 2G|z99|z930|z999|z990|z909|Z919|z900",
					PositivoTablet: "TB07STA|TB10STA|TB07FTA|TB10FTA",
					NabiTablet: "Android.*\\bNabi",
					KoboTablet: "Kobo Touch|\\bK080\\b|\\bVox\\b Build|\\bArc\\b Build",
					DanewTablet: "DSlide.*\\b(700|701R|702|703R|704|802|970|971|972|973|974|1010|1012)\\b",
					TexetTablet: "NaviPad|TB-772A|TM-7045|TM-7055|TM-9750|TM-7016|TM-7024|TM-7026|TM-7041|TM-7043|TM-7047|TM-8041|TM-9741|TM-9747|TM-9748|TM-9751|TM-7022|TM-7021|TM-7020|TM-7011|TM-7010|TM-7023|TM-7025|TM-7037W|TM-7038W|TM-7027W|TM-9720|TM-9725|TM-9737W|TM-1020|TM-9738W|TM-9740|TM-9743W|TB-807A|TB-771A|TB-727A|TB-725A|TB-719A|TB-823A|TB-805A|TB-723A|TB-715A|TB-707A|TB-705A|TB-709A|TB-711A|TB-890HD|TB-880HD|TB-790HD|TB-780HD|TB-770HD|TB-721HD|TB-710HD|TB-434HD|TB-860HD|TB-840HD|TB-760HD|TB-750HD|TB-740HD|TB-730HD|TB-722HD|TB-720HD|TB-700HD|TB-500HD|TB-470HD|TB-431HD|TB-430HD|TB-506|TB-504|TB-446|TB-436|TB-416|TB-146SE|TB-126SE",
					PlaystationTablet: "Playstation.*(Portable|Vita)",
					TrekstorTablet: "ST10416-1|VT10416-1|ST70408-1|ST702xx-1|ST702xx-2|ST80208|ST97216|ST70104-2|VT10416-2|ST10216-2A|SurfTab",
					PyleAudioTablet: "\\b(PTBL10CEU|PTBL10C|PTBL72BC|PTBL72BCEU|PTBL7CEU|PTBL7C|PTBL92BC|PTBL92BCEU|PTBL9CEU|PTBL9CUK|PTBL9C)\\b",
					AdvanTablet: "Android.* \\b(E3A|T3X|T5C|T5B|T3E|T3C|T3B|T1J|T1F|T2A|T1H|T1i|E1C|T1-E|T5-A|T4|E1-B|T2Ci|T1-B|T1-D|O1-A|E1-A|T1-A|T3A|T4i)\\b ",
					DanyTechTablet: "Genius Tab G3|Genius Tab S2|Genius Tab Q3|Genius Tab G4|Genius Tab Q4|Genius Tab G-II|Genius TAB GII|Genius TAB GIII|Genius Tab S1",
					GalapadTablet: "Android.*\\bG1\\b",
					MicromaxTablet: "Funbook|Micromax.*\\b(P250|P560|P360|P362|P600|P300|P350|P500|P275)\\b",
					KarbonnTablet: "Android.*\\b(A39|A37|A34|ST8|ST10|ST7|Smart Tab3|Smart Tab2)\\b",
					AllFineTablet: "Fine7 Genius|Fine7 Shine|Fine7 Air|Fine8 Style|Fine9 More|Fine10 Joy|Fine11 Wide",
					PROSCANTablet: "\\b(PEM63|PLT1023G|PLT1041|PLT1044|PLT1044G|PLT1091|PLT4311|PLT4311PL|PLT4315|PLT7030|PLT7033|PLT7033D|PLT7035|PLT7035D|PLT7044K|PLT7045K|PLT7045KB|PLT7071KG|PLT7072|PLT7223G|PLT7225G|PLT7777G|PLT7810K|PLT7849G|PLT7851G|PLT7852G|PLT8015|PLT8031|PLT8034|PLT8036|PLT8080K|PLT8082|PLT8088|PLT8223G|PLT8234G|PLT8235G|PLT8816K|PLT9011|PLT9045K|PLT9233G|PLT9735|PLT9760G|PLT9770G)\\b",
					YONESTablet: "BQ1078|BC1003|BC1077|RK9702|BC9730|BC9001|IT9001|BC7008|BC7010|BC708|BC728|BC7012|BC7030|BC7027|BC7026",
					ChangJiaTablet: "TPC7102|TPC7103|TPC7105|TPC7106|TPC7107|TPC7201|TPC7203|TPC7205|TPC7210|TPC7708|TPC7709|TPC7712|TPC7110|TPC8101|TPC8103|TPC8105|TPC8106|TPC8203|TPC8205|TPC8503|TPC9106|TPC9701|TPC97101|TPC97103|TPC97105|TPC97106|TPC97111|TPC97113|TPC97203|TPC97603|TPC97809|TPC97205|TPC10101|TPC10103|TPC10106|TPC10111|TPC10203|TPC10205|TPC10503",
					GUTablet: "TX-A1301|TX-M9002|Q702|kf026",
					PointOfViewTablet: "TAB-P506|TAB-navi-7-3G-M|TAB-P517|TAB-P-527|TAB-P701|TAB-P703|TAB-P721|TAB-P731N|TAB-P741|TAB-P825|TAB-P905|TAB-P925|TAB-PR945|TAB-PL1015|TAB-P1025|TAB-PI1045|TAB-P1325|TAB-PROTAB[0-9]+|TAB-PROTAB25|TAB-PROTAB26|TAB-PROTAB27|TAB-PROTAB26XL|TAB-PROTAB2-IPS9|TAB-PROTAB30-IPS9|TAB-PROTAB25XXL|TAB-PROTAB26-IPS10|TAB-PROTAB30-IPS10",
					OvermaxTablet: "OV-(SteelCore|NewBase|Basecore|Baseone|Exellen|Quattor|EduTab|Solution|ACTION|BasicTab|TeddyTab|MagicTab|Stream|TB-08|TB-09)",
					HCLTablet: "HCL.*Tablet|Connect-3G-2.0|Connect-2G-2.0|ME Tablet U1|ME Tablet U2|ME Tablet G1|ME Tablet X1|ME Tablet Y2|ME Tablet Sync",
					DPSTablet: "DPS Dream 9|DPS Dual 7",
					VistureTablet: "V97 HD|i75 3G|Visture V4( HD)?|Visture V5( HD)?|Visture V10",
					CrestaTablet: "CTP(-)?810|CTP(-)?818|CTP(-)?828|CTP(-)?838|CTP(-)?888|CTP(-)?978|CTP(-)?980|CTP(-)?987|CTP(-)?988|CTP(-)?989",
					MediatekTablet: "\\bMT8125|MT8389|MT8135|MT8377\\b",
					ConcordeTablet: "Concorde([ ]+)?Tab|ConCorde ReadMan",
					GoCleverTablet: "GOCLEVER TAB|A7GOCLEVER|M1042|M7841|M742|R1042BK|R1041|TAB A975|TAB A7842|TAB A741|TAB A741L|TAB M723G|TAB M721|TAB A1021|TAB I921|TAB R721|TAB I720|TAB T76|TAB R70|TAB R76.2|TAB R106|TAB R83.2|TAB M813G|TAB I721|GCTA722|TAB I70|TAB I71|TAB S73|TAB R73|TAB R74|TAB R93|TAB R75|TAB R76.1|TAB A73|TAB A93|TAB A93.2|TAB T72|TAB R83|TAB R974|TAB R973|TAB A101|TAB A103|TAB A104|TAB A104.2|R105BK|M713G|A972BK|TAB A971|TAB R974.2|TAB R104|TAB R83.3|TAB A1042",
					ModecomTablet: "FreeTAB 9000|FreeTAB 7.4|FreeTAB 7004|FreeTAB 7800|FreeTAB 2096|FreeTAB 7.5|FreeTAB 1014|FreeTAB 1001 |FreeTAB 8001|FreeTAB 9706|FreeTAB 9702|FreeTAB 7003|FreeTAB 7002|FreeTAB 1002|FreeTAB 7801|FreeTAB 1331|FreeTAB 1004|FreeTAB 8002|FreeTAB 8014|FreeTAB 9704|FreeTAB 1003",
					VoninoTablet: "\\b(Argus[ _]?S|Diamond[ _]?79HD|Emerald[ _]?78E|Luna[ _]?70C|Onyx[ _]?S|Onyx[ _]?Z|Orin[ _]?HD|Orin[ _]?S|Otis[ _]?S|SpeedStar[ _]?S|Magnet[ _]?M9|Primus[ _]?94[ _]?3G|Primus[ _]?94HD|Primus[ _]?QS|Android.*\\bQ8\\b|Sirius[ _]?EVO[ _]?QS|Sirius[ _]?QS|Spirit[ _]?S)\\b",
					ECSTablet: "V07OT2|TM105A|S10OT1|TR10CS1",
					StorexTablet: "eZee[_']?(Tab|Go)[0-9]+|TabLC7|Looney Tunes Tab",
					VodafoneTablet: "SmartTab([ ]+)?[0-9]+|SmartTabII10|SmartTabII7",
					EssentielBTablet: "Smart[ ']?TAB[ ]+?[0-9]+|Family[ ']?TAB2",
					RossMoorTablet: "RM-790|RM-997|RMD-878G|RMD-974R|RMT-705A|RMT-701|RME-601|RMT-501|RMT-711",
					iMobileTablet: "i-mobile i-note",
					TolinoTablet: "tolino tab [0-9.]+|tolino shine",
					AudioSonicTablet: "\\bC-22Q|T7-QC|T-17B|T-17P\\b",
					AMPETablet: "Android.* A78 ",
					SkkTablet: "Android.* (SKYPAD|PHOENIX|CYCLOPS)",
					TecnoTablet: "TECNO P9",
					JXDTablet: "Android.*\\b(F3000|A3300|JXD5000|JXD3000|JXD2000|JXD300B|JXD300|S5800|S7800|S602b|S5110b|S7300|S5300|S602|S603|S5100|S5110|S601|S7100a|P3000F|P3000s|P101|P200s|P1000m|P200m|P9100|P1000s|S6600b|S908|P1000|P300|S18|S6600|S9100)\\b",
					iJoyTablet: "Tablet (Spirit 7|Essentia|Galatea|Fusion|Onix 7|Landa|Titan|Scooby|Deox|Stella|Themis|Argon|Unique 7|Sygnus|Hexen|Finity 7|Cream|Cream X2|Jade|Neon 7|Neron 7|Kandy|Scape|Saphyr 7|Rebel|Biox|Rebel|Rebel 8GB|Myst|Draco 7|Myst|Tab7-004|Myst|Tadeo Jones|Tablet Boing|Arrow|Draco Dual Cam|Aurix|Mint|Amity|Revolution|Finity 9|Neon 9|T9w|Amity 4GB Dual Cam|Stone 4GB|Stone 8GB|Andromeda|Silken|X2|Andromeda II|Halley|Flame|Saphyr 9,7|Touch 8|Planet|Triton|Unique 10|Hexen 10|Memphis 4GB|Memphis 8GB|Onix 10)",
					FX2Tablet: "FX2 PAD7|FX2 PAD10",
					XoroTablet: "KidsPAD 701|PAD[ ]?712|PAD[ ]?714|PAD[ ]?716|PAD[ ]?717|PAD[ ]?718|PAD[ ]?720|PAD[ ]?721|PAD[ ]?722|PAD[ ]?790|PAD[ ]?792|PAD[ ]?900|PAD[ ]?9715D|PAD[ ]?9716DR|PAD[ ]?9718DR|PAD[ ]?9719QR|PAD[ ]?9720QR|TelePAD1030|Telepad1032|TelePAD730|TelePAD731|TelePAD732|TelePAD735Q|TelePAD830|TelePAD9730|TelePAD795|MegaPAD 1331|MegaPAD 1851|MegaPAD 2151",
					ViewsonicTablet: "ViewPad 10pi|ViewPad 10e|ViewPad 10s|ViewPad E72|ViewPad7|ViewPad E100|ViewPad 7e|ViewSonic VB733|VB100a",
					OdysTablet: "LOOX|XENO10|ODYS[ -](Space|EVO|Xpress|NOON)|\\bXELIO\\b|Xelio10Pro|XELIO7PHONETAB|XELIO10EXTREME|XELIOPT2|NEO_QUAD10",
					CaptivaTablet: "CAPTIVA PAD",
					IconbitTablet: "NetTAB|NT-3702|NT-3702S|NT-3702S|NT-3603P|NT-3603P|NT-0704S|NT-0704S|NT-3805C|NT-3805C|NT-0806C|NT-0806C|NT-0909T|NT-0909T|NT-0907S|NT-0907S|NT-0902S|NT-0902S",
					TeclastTablet: "T98 4G|\\bP80\\b|\\bX90HD\\b|X98 Air|X98 Air 3G|\\bX89\\b|P80 3G|\\bX80h\\b|P98 Air|\\bX89HD\\b|P98 3G|\\bP90HD\\b|P89 3G|X98 3G|\\bP70h\\b|P79HD 3G|G18d 3G|\\bP79HD\\b|\\bP89s\\b|\\bA88\\b|\\bP10HD\\b|\\bP19HD\\b|G18 3G|\\bP78HD\\b|\\bA78\\b|\\bP75\\b|G17s 3G|G17h 3G|\\bP85t\\b|\\bP90\\b|\\bP11\\b|\\bP98t\\b|\\bP98HD\\b|\\bG18d\\b|\\bP85s\\b|\\bP11HD\\b|\\bP88s\\b|\\bA80HD\\b|\\bA80se\\b|\\bA10h\\b|\\bP89\\b|\\bP78s\\b|\\bG18\\b|\\bP85\\b|\\bA70h\\b|\\bA70\\b|\\bG17\\b|\\bP18\\b|\\bA80s\\b|\\bA11s\\b|\\bP88HD\\b|\\bA80h\\b|\\bP76s\\b|\\bP76h\\b|\\bP98\\b|\\bA10HD\\b|\\bP78\\b|\\bP88\\b|\\bA11\\b|\\bA10t\\b|\\bP76a\\b|\\bP76t\\b|\\bP76e\\b|\\bP85HD\\b|\\bP85a\\b|\\bP86\\b|\\bP75HD\\b|\\bP76v\\b|\\bA12\\b|\\bP75a\\b|\\bA15\\b|\\bP76Ti\\b|\\bP81HD\\b|\\bA10\\b|\\bT760VE\\b|\\bT720HD\\b|\\bP76\\b|\\bP73\\b|\\bP71\\b|\\bP72\\b|\\bT720SE\\b|\\bC520Ti\\b|\\bT760\\b|\\bT720VE\\b|T720-3GE|T720-WiFi",
					OndaTablet: "\\b(V975i|Vi30|VX530|V701|Vi60|V701s|Vi50|V801s|V719|Vx610w|VX610W|V819i|Vi10|VX580W|Vi10|V711s|V813|V811|V820w|V820|Vi20|V711|VI30W|V712|V891w|V972|V819w|V820w|Vi60|V820w|V711|V813s|V801|V819|V975s|V801|V819|V819|V818|V811|V712|V975m|V101w|V961w|V812|V818|V971|V971s|V919|V989|V116w|V102w|V973|Vi40)\\b[\\s]+",
					JaytechTablet: "TPC-PA762",
					BlaupunktTablet: "Endeavour 800NG|Endeavour 1010",
					DigmaTablet: "\\b(iDx10|iDx9|iDx8|iDx7|iDxD7|iDxD8|iDsQ8|iDsQ7|iDsQ8|iDsD10|iDnD7|3TS804H|iDsQ11|iDj7|iDs10)\\b",
					EvolioTablet: "ARIA_Mini_wifi|Aria[ _]Mini|Evolio X10|Evolio X7|Evolio X8|\\bEvotab\\b|\\bNeura\\b",
					LavaTablet: "QPAD E704|\\bIvoryS\\b|E-TAB IVORY|\\bE-TAB\\b",
					AocTablet: "MW0811|MW0812|MW0922|MTK8382",
					CelkonTablet: "CT695|CT888|CT[\\s]?910|CT7 Tab|CT9 Tab|CT3 Tab|CT2 Tab|CT1 Tab|C820|C720|\\bCT-1\\b",
					WolderTablet: "miTab \\b(DIAMOND|SPACE|BROOKLYN|NEO|FLY|MANHATTAN|FUNK|EVOLUTION|SKY|GOCAR|IRON|GENIUS|POP|MINT|EPSILON|BROADWAY|JUMP|HOP|LEGEND|NEW AGE|LINE|ADVANCE|FEEL|FOLLOW|LIKE|LINK|LIVE|THINK|FREEDOM|CHICAGO|CLEVELAND|BALTIMORE-GH|IOWA|BOSTON|SEATTLE|PHOENIX|DALLAS|IN 101|MasterChef)\\b",
					MiTablet: "\\bMI PAD\\b|\\bHM NOTE 1W\\b",
					NibiruTablet: "Nibiru M1|Nibiru Jupiter One",
					NexoTablet: "NEXO NOVA|NEXO 10|NEXO AVIO|NEXO FREE|NEXO GO|NEXO EVO|NEXO 3G|NEXO SMART|NEXO KIDDO|NEXO MOBI",
					LeaderTablet: "TBLT10Q|TBLT10I|TBL-10WDKB|TBL-10WDKBO2013|TBL-W230V2|TBL-W450|TBL-W500|SV572|TBLT7I|TBA-AC7-8G|TBLT79|TBL-8W16|TBL-10W32|TBL-10WKB|TBL-W100",
					UbislateTablet: "UbiSlate[\\s]?7C",
					PocketBookTablet: "Pocketbook",
					Hudl: "Hudl HT7S3|Hudl 2",
					TelstraTablet: "T-Hub2",
					GenericTablet: "Android.*\\b97D\\b|Tablet(?!.*PC)|BNTV250A|MID-WCDMA|LogicPD Zoom2|\\bA7EB\\b|CatNova8|A1_07|CT704|CT1002|\\bM721\\b|rk30sdk|\\bEVOTAB\\b|M758A|ET904|ALUMIUM10|Smartfren Tab|Endeavour 1010|Tablet-PC-4|Tagi Tab|\\bM6pro\\b|CT1020W|arc 10HD|\\bJolla\\b|\\bTP750\\b"
				},
				oss: { AndroidOS: "Android", BlackBerryOS: "blackberry|\\bBB10\\b|rim tablet os", PalmOS: "PalmOS|avantgo|blazer|elaine|hiptop|palm|plucker|xiino", SymbianOS: "Symbian|SymbOS|Series60|Series40|SYB-[0-9]+|\\bS60\\b", WindowsMobileOS: "Windows CE.*(PPC|Smartphone|Mobile|[0-9]{3}x[0-9]{3})|Window Mobile|Windows Phone [0-9.]+|WCE;", WindowsPhoneOS: "Windows Phone 10.0|Windows Phone 8.1|Windows Phone 8.0|Windows Phone OS|XBLWP7|ZuneWP7|Windows NT 6.[23]; ARM;", iOS: "\\biPhone.*Mobile|\\biPod|\\biPad", MeeGoOS: "MeeGo", MaemoOS: "Maemo", JavaOS: "J2ME/|\\bMIDP\\b|\\bCLDC\\b", webOS: "webOS|hpwOS", badaOS: "\\bBada\\b", BREWOS: "BREW" },
				uas: { Chrome: "\\bCrMo\\b|CriOS|Android.*Chrome/[.0-9]* (Mobile)?", Dolfin: "\\bDolfin\\b", Opera: "Opera.*Mini|Opera.*Mobi|Android.*Opera|Mobile.*OPR/[0-9.]+|Coast/[0-9.]+", Skyfire: "Skyfire", IE: "IEMobile|MSIEMobile", Firefox: "fennec|firefox.*maemo|(Mobile|Tablet).*Firefox|Firefox.*Mobile", Bolt: "bolt", TeaShark: "teashark", Blazer: "Blazer", Safari: "Version.*Mobile.*Safari|Safari.*Mobile|MobileSafari", Tizen: "Tizen", UCBrowser: "UC.*Browser|UCWEB", baiduboxapp: "baiduboxapp", baidubrowser: "baidubrowser", DiigoBrowser: "DiigoBrowser", Puffin: "Puffin", Mercury: "\\bMercury\\b", ObigoBrowser: "Obigo", NetFront: "NF-Browser", GenericBrowser: "NokiaBrowser|OviBrowser|OneBrowser|TwonkyBeamBrowser|SEMC.*Browser|FlyFlow|Minimo|NetFront|Novarra-Vision|MQQBrowser|MicroMessenger" },
				props: { Mobile: "Mobile/[VER]", Build: "Build/[VER]", Version: "Version/[VER]", VendorID: "VendorID/[VER]", iPad: "iPad.*CPU[a-z ]+[VER]", iPhone: "iPhone.*CPU[a-z ]+[VER]", iPod: "iPod.*CPU[a-z ]+[VER]", Kindle: "Kindle/[VER]", Chrome: ["Chrome/[VER]", "CriOS/[VER]", "CrMo/[VER]"], Coast: ["Coast/[VER]"], Dolfin: "Dolfin/[VER]", Firefox: "Firefox/[VER]", Fennec: "Fennec/[VER]", IE: ["IEMobile/[VER];", "IEMobile [VER]", "MSIE [VER];", "Trident/[0-9.]+;.*rv:[VER]"], NetFront: "NetFront/[VER]", NokiaBrowser: "NokiaBrowser/[VER]", Opera: [" OPR/[VER]", "Opera Mini/[VER]", "Version/[VER]"], "Opera Mini": "Opera Mini/[VER]", "Opera Mobi": "Version/[VER]", "UC Browser": "UC Browser[VER]", MQQBrowser: "MQQBrowser/[VER]", MicroMessenger: "MicroMessenger/[VER]", baiduboxapp: "baiduboxapp/[VER]", baidubrowser: "baidubrowser/[VER]", Iron: "Iron/[VER]", Safari: ["Version/[VER]", "Safari/[VER]"], Skyfire: "Skyfire/[VER]", Tizen: "Tizen/[VER]", Webkit: "webkit[ /][VER]", Gecko: "Gecko/[VER]", Trident: "Trident/[VER]", Presto: "Presto/[VER]", iOS: " \\bi?OS\\b [VER][ ;]{1}", Android: "Android [VER]", BlackBerry: ["BlackBerry[\\w]+/[VER]", "BlackBerry.*Version/[VER]", "Version/[VER]"], BREW: "BREW [VER]", Java: "Java/[VER]", "Windows Phone OS": ["Windows Phone OS [VER]", "Windows Phone [VER]"], "Windows Phone": "Windows Phone [VER]", "Windows CE": "Windows CE/[VER]", "Windows NT": "Windows NT [VER]", Symbian: ["SymbianOS/[VER]", "Symbian/[VER]"], webOS: ["webOS/[VER]", "hpwOS/[VER];"] },
				utils: { Bot: "Googlebot|facebookexternalhit|AdsBot-Google|Google Keyword Suggestion|Facebot|YandexBot|bingbot|ia_archiver|AhrefsBot|Ezooms|GSLFbot|WBSearchBot|Twitterbot|TweetmemeBot|Twikle|PaperLiBot|Wotbox|UnwindFetchor|Exabot|MJ12bot|YandexImages|TurnitinBot|Pingdom", MobileBot: "Googlebot-Mobile|AdsBot-Google-Mobile|YahooSeeker/M1A1-R2D2", DesktopMode: "WPDesktop", TV: "SonyDTV|HbbTV", WebKit: "(webkit)[ /]([\\w.]+)", Console: "\\b(Nintendo|Nintendo WiiU|Nintendo 3DS|PLAYSTATION|Xbox)\\b", Watch: "SM-V700" }
			}, o.detectMobileBrowsers = { fullPattern: /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i, shortPattern: /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i, tabletPattern: /android|ipad|playbook|silk/i };
			var s, a = Object.prototype.hasOwnProperty;
			return o.FALLBACK_PHONE = "UnknownPhone", o.FALLBACK_TABLET = "UnknownTablet", o.FALLBACK_MOBILE = "UnknownMobile", s = "isArray" in Array ? Array.isArray : function(t) { return "[object Array]" === Object.prototype.toString.call(t) },
				function() { var t, e, r, i, l, u, h = o.mobileDetectRules; for(t in h.props)
						if(a.call(h.props, t)) { for(e = h.props[t], s(e) || (e = [e]), l = e.length, i = 0; l > i; ++i) r = e[i], u = r.indexOf("[VER]"), u >= 0 && (r = r.substring(0, u) + "([\\w._\\+]+)" + r.substring(u + 5)), e[i] = new RegExp(r, "i");
							h.props[t] = e }
					n(h.oss), n(h.phones), n(h.tablets), n(h.uas), n(h.utils), h.oss0 = { WindowsPhoneOS: h.oss.WindowsPhoneOS, WindowsMobileOS: h.oss.WindowsMobileOS } }(), o.findMatch = function(t, e) { for(var r in t)
						if(a.call(t, r) && t[r].test(e)) return r; return null }, o.findMatches = function(t, e) { var r = []; for(var n in t) a.call(t, n) && t[n].test(e) && r.push(n); return r }, o.getVersionStr = function(t, e) { var r, n, i, s, l = o.mobileDetectRules.props; if(a.call(l, t))
						for(r = l[t], i = r.length, n = 0; i > n; ++n)
							if(s = r[n].exec(e), null !== s) return s[1]; return null }, o.getVersion = function(t, e) { var r = o.getVersionStr(t, e); return r ? o.prepareVersionNo(r) : NaN }, o.prepareVersionNo = function(t) { var e; return e = t.split(/[a-z._ \/\-]/i), 1 === e.length && (t = e[0]), e.length > 1 && (t = e[0] + ".", e.shift(), t += e.join("")), Number(t) }, o.isMobileFallback = function(t) { return o.detectMobileBrowsers.fullPattern.test(t) || o.detectMobileBrowsers.shortPattern.test(t.substr(0, 4)) }, o.isTabletFallback = function(t) { return o.detectMobileBrowsers.tabletPattern.test(t) }, o.prepareDetectionCache = function(t, r, n) { if(t.mobile === e) { var s, a, l; return(a = o.findMatch(o.mobileDetectRules.tablets, r)) ? (t.mobile = t.tablet = a, void(t.phone = null)) : (s = o.findMatch(o.mobileDetectRules.phones, r)) ? (t.mobile = t.phone = s, void(t.tablet = null)) : void(o.isMobileFallback(r) ? (l = i.isPhoneSized(n), l === e ? (t.mobile = o.FALLBACK_MOBILE, t.tablet = t.phone = null) : l ? (t.mobile = t.phone = o.FALLBACK_PHONE, t.tablet = null) : (t.mobile = t.tablet = o.FALLBACK_TABLET, t.phone = null)) : o.isTabletFallback(r) ? (t.mobile = t.tablet = o.FALLBACK_TABLET, t.phone = null) : t.mobile = t.tablet = t.phone = null) } }, o.mobileGrade = function(t) { var e = null !== t.mobile(); return t.os("iOS") && t.version("iPad") >= 4.3 || t.os("iOS") && t.version("iPhone") >= 3.1 || t.os("iOS") && t.version("iPod") >= 3.1 || t.version("Android") > 2.1 && t.is("Webkit") || t.version("Windows Phone OS") >= 7 || t.is("BlackBerry") && t.version("BlackBerry") >= 6 || t.match("Playbook.*Tablet") || t.version("webOS") >= 1.4 && t.match("Palm|Pre|Pixi") || t.match("hp.*TouchPad") || t.is("Firefox") && t.version("Firefox") >= 12 || t.is("Chrome") && t.is("AndroidOS") && t.version("Android") >= 4 || t.is("Skyfire") && t.version("Skyfire") >= 4.1 && t.is("AndroidOS") && t.version("Android") >= 2.3 || t.is("Opera") && t.version("Opera Mobi") > 11 && t.is("AndroidOS") || t.is("MeeGoOS") || t.is("Tizen") || t.is("Dolfin") && t.version("Bada") >= 2 || (t.is("UC Browser") || t.is("Dolfin")) && t.version("Android") >= 2.3 || t.match("Kindle Fire") || t.is("Kindle") && t.version("Kindle") >= 3 || t.is("AndroidOS") && t.is("NookTablet") || t.version("Chrome") >= 11 && !e || t.version("Safari") >= 5 && !e || t.version("Firefox") >= 4 && !e || t.version("MSIE") >= 7 && !e || t.version("Opera") >= 10 && !e ? "A" : t.os("iOS") && t.version("iPad") < 4.3 || t.os("iOS") && t.version("iPhone") < 3.1 || t.os("iOS") && t.version("iPod") < 3.1 || t.is("Blackberry") && t.version("BlackBerry") >= 5 && t.version("BlackBerry") < 6 || t.version("Opera Mini") >= 5 && t.version("Opera Mini") <= 6.5 && (t.version("Android") >= 2.3 || t.is("iOS")) || t.match("NokiaN8|NokiaC7|N97.*Series60|Symbian/3") || t.version("Opera Mobi") >= 11 && t.is("SymbianOS") ? "B" : (t.version("BlackBerry") < 5 || t.match("MSIEMobile|Windows CE.*Mobile") || t.version("Windows Mobile") <= 5.2, "C") }, o.detectOS = function(t) { return o.findMatch(o.mobileDetectRules.oss0, t) || o.findMatch(o.mobileDetectRules.oss, t) }, o.getDeviceSmallerSide = function() { return window.screen.width < window.screen.height ? window.screen.width : window.screen.height }, i.prototype = { constructor: i, mobile: function() { return o.prepareDetectionCache(this._cache, this.ua, this.maxPhoneWidth), this._cache.mobile }, phone: function() { return o.prepareDetectionCache(this._cache, this.ua, this.maxPhoneWidth), this._cache.phone }, tablet: function() { return o.prepareDetectionCache(this._cache, this.ua, this.maxPhoneWidth), this._cache.tablet }, userAgent: function() { return this._cache.userAgent === e && (this._cache.userAgent = o.findMatch(o.mobileDetectRules.uas, this.ua)), this._cache.userAgent }, userAgents: function() { return this._cache.userAgents === e && (this._cache.userAgents = o.findMatches(o.mobileDetectRules.uas, this.ua)), this._cache.userAgents }, os: function() { return this._cache.os === e && (this._cache.os = o.detectOS(this.ua)), this._cache.os }, version: function(t) { return o.getVersion(t, this.ua) }, versionStr: function(t) { return o.getVersionStr(t, this.ua) }, is: function(e) { return r(this.userAgents(), e) || t(e, this.os()) || t(e, this.phone()) || t(e, this.tablet()) || r(o.findMatches(o.mobileDetectRules.utils, this.ua), e) }, match: function(t) { return t instanceof RegExp || (t = new RegExp(t, "i")), t.test(this.ua) }, isPhoneSized: function(t) { return i.isPhoneSized(t || this.maxPhoneWidth) }, mobileGrade: function() { return this._cache.grade === e && (this._cache.grade = o.mobileGrade(this)), this._cache.grade } }, "undefined" != typeof window && window.screen ? i.isPhoneSized = function(t) { return 0 > t ? e : o.getDeviceSmallerSide() <= t } : i.isPhoneSized = function() {}, i._impl = o, i
		})
	}(function(t) { if("undefined" != typeof module && module.exports) return function(t) { module.exports = t() }; if("function" == typeof define && define.amd) return define; if("undefined" != typeof window) return function(t) { window.MobileDetect = t() }; throw new Error("unknown environment") }()), ! function(t) { if("object" == typeof exports && "undefined" != typeof module) module.exports = t();
		else if("function" == typeof define && define.amd) define([], t);
		else { var e;
			e = "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : this, e.PIXI = t() } }(function() {
		var t;
		return function e(t, r, n) {
			function i(s, a) { if(!r[s]) { if(!t[s]) { var l = "function" == typeof require && require; if(!a && l) return l(s, !0); if(o) return o(s, !0); var u = new Error("Cannot find module '" + s + "'"); throw u.code = "MODULE_NOT_FOUND", u } var h = r[s] = { exports: {} };
					t[s][0].call(h.exports, function(e) { var r = t[s][1][e]; return i(r ? r : e) }, h, h.exports, e, t, r, n) } return r[s].exports } for(var o = "function" == typeof require && require, s = 0; s < n.length; s++) i(n[s]); return i }({
			1: [function(e, r, n) {
				(function(e, n) {! function() {
						function i() {}

						function o(t) { return t }

						function s(t) { return !!t }

						function a(t) { return !t }

						function l(t) { return function() { if(null === t) throw new Error("Callback was already called.");
								t.apply(this, arguments), t = null } }

						function u(t) { return function() { null !== t && (t.apply(this, arguments), t = null) } }

						function h(t) { return k(t) || "number" == typeof t.length && t.length >= 0 && t.length % 1 === 0 }

						function c(t, e) { for(var r = -1, n = t.length; ++r < n;) e(t[r], r, t) }

						function p(t, e) { for(var r = -1, n = t.length, i = Array(n); ++r < n;) i[r] = e(t[r], r, t); return i }

						function d(t) { return p(Array(t), function(t, e) { return e }) }

						function f(t, e, r) { return c(t, function(t, n, i) { r = e(r, t, n, i) }), r }

						function v(t, e) { c(j(t), function(r) { e(t[r], r) }) }

						function g(t, e) { for(var r = 0; r < t.length; r++)
								if(t[r] === e) return r; return -1 }

						function m(t) { var e, r, n = -1; return h(t) ? (e = t.length, function() { return n++, e > n ? n : null }) : (r = j(t), e = r.length, function() { return n++, e > n ? r[n] : null }) }

						function y(t, e) { return e = null == e ? t.length - 1 : +e,
								function() { for(var r = Math.max(arguments.length - e, 0), n = Array(r), i = 0; r > i; i++) n[i] = arguments[i + e]; switch(e) {
										case 0:
											return t.call(this, n);
										case 1:
											return t.call(this, arguments[0], n) } } }

						function T(t) { return function(e, r, n) { return t(e, n) } }

						function x(t) { return function(e, r, n) { n = u(n || i), e = e || []; var o = m(e); if(0 >= t) return n(null); var s = !1,
									a = 0,
									h = !1;! function c() { if(s && 0 >= a) return n(null); for(; t > a && !h;) { var i = o(); if(null === i) return s = !0, void(0 >= a && n(null));
										a += 1, r(e[i], i, l(function(t) { a -= 1, t ? (n(t), h = !0) : c() })) } }() } }

						function b(t) { return function(e, r, n) { return t(G.eachOf, e, r, n) } }

						function S(t) { return function(e, r, n, i) { return t(x(r), e, n, i) } }

						function E(t) { return function(e, r, n) { return t(G.eachOfSeries, e, r, n) } }

						function A(t, e, r, n) { n = u(n || i), e = e || []; var o = h(e) ? [] : {};
							t(e, function(t, e, n) { r(t, function(t, r) { o[e] = r, n(t) }) }, function(t) { n(t, o) }) }

						function _(t, e, r, n) { var i = [];
							t(e, function(t, e, n) { r(t, function(r) { r && i.push({ index: e, value: t }), n() }) }, function() { n(p(i.sort(function(t, e) { return t.index - e.index }), function(t) { return t.value })) }) }

						function M(t, e, r, n) { _(t, e, function(t, e) { r(t, function(t) { e(!t) }) }, n) }

						function w(t, e, r) { return function(n, i, o, s) {
								function a() { s && s(r(!1, void 0)) }

								function l(t, n, i) { return s ? void o(t, function(n) { s && e(n) && (s(r(!0, t)), s = o = !1), i() }) : i() } arguments.length > 3 ? t(n, i, l, a) : (s = o, o = i, t(n, l, a)) } }

						function C(t, e) { return e }

						function P(t, e, r) { r = r || i; var n = h(e) ? [] : {};
							t(e, function(t, e, r) { t(y(function(t, i) { i.length <= 1 && (i = i[0]), n[e] = i, r(t) })) }, function(t) { r(t, n) }) }

						function R(t, e, r, n) { var i = [];
							t(e, function(t, e, n) { r(t, function(t, e) { i = i.concat(e || []), n(t) }) }, function(t) { n(t, i) }) }

						function D(t, e, r) {
							function n(t, e, r, n) { if(null != n && "function" != typeof n) throw new Error("task callback must be a function"); return t.started = !0, k(e) || (e = [e]), 0 === e.length && t.idle() ? G.setImmediate(function() { t.drain() }) : (c(e, function(e) { var o = { data: e, callback: n || i };
									r ? t.tasks.unshift(o) : t.tasks.push(o), t.tasks.length === t.concurrency && t.saturated() }), void G.setImmediate(t.process)) }

							function o(t, e) { return function() { s -= 1; var r = !1,
										n = arguments;
									c(e, function(t) { c(a, function(e, n) { e !== t || r || (a.splice(n, 1), r = !0) }), t.callback.apply(t, n) }), t.tasks.length + s === 0 && t.drain(), t.process() } } if(null == e) e = 1;
							else if(0 === e) throw new Error("Concurrency must not be zero"); var s = 0,
								a = [],
								u = { tasks: [], concurrency: e, payload: r, saturated: i, empty: i, drain: i, started: !1, paused: !1, push: function(t, e) { n(u, t, !1, e) }, kill: function() { u.drain = i, u.tasks = [] }, unshift: function(t, e) { n(u, t, !0, e) }, process: function() { if(!u.paused && s < u.concurrency && u.tasks.length)
											for(; s < u.concurrency && u.tasks.length;) { var e = u.payload ? u.tasks.splice(0, u.payload) : u.tasks.splice(0, u.tasks.length),
													r = p(e, function(t) { return t.data });
												0 === u.tasks.length && u.empty(), s += 1, a.push(e[0]); var n = l(o(u, e));
												t(r, n) } }, length: function() { return u.tasks.length }, running: function() { return s }, workersList: function() { return a }, idle: function() { return u.tasks.length + s === 0 }, pause: function() { u.paused = !0 }, resume: function() { if(u.paused !== !1) { u.paused = !1; for(var t = Math.min(u.concurrency, u.tasks.length), e = 1; t >= e; e++) G.setImmediate(u.process) } } }; return u }

						function B(t) { return y(function(e, r) { e.apply(null, r.concat([y(function(e, r) { "object" == typeof console && (e ? console.error && console.error(e) : console[t] && c(r, function(e) { console[t](e) })) })])) }) }

						function O(t) { return function(e, r, n) { t(d(e), r, n) } }

						function F(t) { return y(function(e, r) { var n = y(function(r) { var n = this,
										i = r.pop(); return t(e, function(t, e, i) { t.apply(n, r.concat([i])) }, i) }); return r.length ? n.apply(this, r) : n }) }

						function L(t) { return y(function(e) { var r = e.pop();
								e.push(function() { var t = arguments;
									n ? G.setImmediate(function() { r.apply(null, t) }) : r.apply(null, t) }); var n = !0;
								t.apply(this, e), n = !1 }) } var I, G = {},
							N = "object" == typeof self && self.self === self && self || "object" == typeof n && n.global === n && n || this;
						null != N && (I = N.async), G.noConflict = function() { return N.async = I, G }; var H = Object.prototype.toString,
							k = Array.isArray || function(t) { return "[object Array]" === H.call(t) },
							U = function(t) { var e = typeof t; return "function" === e || "object" === e && !!t },
							j = Object.keys || function(t) { var e = []; for(var r in t) t.hasOwnProperty(r) && e.push(r); return e },
							X = "function" == typeof setImmediate && setImmediate,
							W = X ? function(t) { X(t) } : function(t) { setTimeout(t, 0) }; "object" == typeof e && "function" == typeof e.nextTick ? G.nextTick = e.nextTick : G.nextTick = W, G.setImmediate = X ? W : G.nextTick, G.forEach = G.each = function(t, e, r) { return G.eachOf(t, T(e), r) }, G.forEachSeries = G.eachSeries = function(t, e, r) { return G.eachOfSeries(t, T(e), r) }, G.forEachLimit = G.eachLimit = function(t, e, r, n) { return x(e)(t, T(r), n) }, G.forEachOf = G.eachOf = function(t, e, r) {
							function n(t) { a--, t ? r(t) : null === o && 0 >= a && r(null) } r = u(r || i), t = t || []; for(var o, s = m(t), a = 0; null != (o = s());) a += 1, e(t[o], o, l(n));
							0 === a && r(null) }, G.forEachOfSeries = G.eachOfSeries = function(t, e, r) {
							function n() { var i = !0; return null === s ? r(null) : (e(t[s], s, l(function(t) { if(t) r(t);
									else { if(s = o(), null === s) return r(null);
										i ? G.setImmediate(n) : n() } })), void(i = !1)) } r = u(r || i), t = t || []; var o = m(t),
								s = o();
							n() }, G.forEachOfLimit = G.eachOfLimit = function(t, e, r, n) { x(e)(t, r, n) }, G.map = b(A), G.mapSeries = E(A), G.mapLimit = S(A), G.inject = G.foldl = G.reduce = function(t, e, r, n) { G.eachOfSeries(t, function(t, n, i) { r(e, t, function(t, r) { e = r, i(t) }) }, function(t) { n(t, e) }) }, G.foldr = G.reduceRight = function(t, e, r, n) { var i = p(t, o).reverse();
							G.reduce(i, e, r, n) }, G.transform = function(t, e, r, n) { 3 === arguments.length && (n = r, r = e, e = k(t) ? [] : {}), G.eachOf(t, function(t, n, i) { r(e, t, n, i) }, function(t) { n(t, e) }) }, G.select = G.filter = b(_), G.selectLimit = G.filterLimit = S(_), G.selectSeries = G.filterSeries = E(_), G.reject = b(M), G.rejectLimit = S(M), G.rejectSeries = E(M), G.any = G.some = w(G.eachOf, s, o), G.someLimit = w(G.eachOfLimit, s, o), G.all = G.every = w(G.eachOf, a, a), G.everyLimit = w(G.eachOfLimit, a, a), G.detect = w(G.eachOf, o, C), G.detectSeries = w(G.eachOfSeries, o, C), G.detectLimit = w(G.eachOfLimit, o, C), G.sortBy = function(t, e, r) {
							function n(t, e) { var r = t.criteria,
									n = e.criteria; return n > r ? -1 : r > n ? 1 : 0 } G.map(t, function(t, r) { e(t, function(e, n) { e ? r(e) : r(null, { value: t, criteria: n }) }) }, function(t, e) { return t ? r(t) : void r(null, p(e.sort(n), function(t) { return t.value })) }) }, G.auto = function(t, e, r) {
							function n(t) { d.unshift(t) }

							function o(t) { var e = g(d, t);
								e >= 0 && d.splice(e, 1) }

							function s() { l--, c(d.slice(0), function(t) { t() }) } r || (r = e, e = null), r = u(r || i); var a = j(t),
								l = a.length; if(!l) return r(null);
							e || (e = l); var h = {},
								p = 0,
								d = [];
							n(function() { l || r(null, h) }), c(a, function(i) {
								function a() { return e > p && f(m, function(t, e) { return t && h.hasOwnProperty(e) }, !0) && !h.hasOwnProperty(i) }

								function l() { a() && (p++, o(l), c[c.length - 1](d, h)) } for(var u, c = k(t[i]) ? t[i] : [t[i]], d = y(function(t, e) { if(p--, e.length <= 1 && (e = e[0]), t) { var n = {};
											v(h, function(t, e) { n[e] = t }), n[i] = e, r(t, n) } else h[i] = e, G.setImmediate(s) }), m = c.slice(0, c.length - 1), T = m.length; T--;) { if(!(u = t[m[T]])) throw new Error("Has inexistant dependency"); if(k(u) && g(u, i) >= 0) throw new Error("Has cyclic dependencies") } a() ? (p++, c[c.length - 1](d, h)) : n(l) }) }, G.retry = function(t, e, r) {
							function n(t, e) { if("number" == typeof e) t.times = parseInt(e, 10) || o;
								else { if("object" != typeof e) throw new Error("Unsupported argument type for 'times': " + typeof e);
									t.times = parseInt(e.times, 10) || o, t.interval = parseInt(e.interval, 10) || s } }

							function i(t, e) {
								function r(t, r) { return function(n) { t(function(t, e) { n(!t || r, { err: t, result: e }) }, e) } }

								function n(t) { return function(e) { setTimeout(function() { e(null) }, t) } } for(; l.times;) { var i = !(l.times -= 1);
									a.push(r(l.task, i)), !i && l.interval > 0 && a.push(n(l.interval)) } G.series(a, function(e, r) { r = r[r.length - 1], (t || l.callback)(r.err, r.result) }) } var o = 5,
								s = 0,
								a = [],
								l = { times: o, interval: s },
								u = arguments.length; if(1 > u || u > 3) throw new Error("Invalid arguments - must be either (task), (task, callback), (times, task) or (times, task, callback)"); return 2 >= u && "function" == typeof t && (r = e, e = t), "function" != typeof t && n(l, t), l.callback = r, l.task = e, l.callback ? i() : i }, G.waterfall = function(t, e) {
							function r(t) { return y(function(n, i) { if(n) e.apply(null, [n].concat(i));
									else { var o = t.next();
										o ? i.push(r(o)) : i.push(e), L(t).apply(null, i) } }) } if(e = u(e || i), !k(t)) { var n = new Error("First argument to waterfall must be an array of functions"); return e(n) } return t.length ? void r(G.iterator(t))() : e() }, G.parallel = function(t, e) { P(G.eachOf, t, e) }, G.parallelLimit = function(t, e, r) { P(x(e), t, r) }, G.series = function(t, e) { P(G.eachOfSeries, t, e) }, G.iterator = function(t) {
							function e(r) {
								function n() { return t.length && t[r].apply(null, arguments), n.next() } return n.next = function() { return r < t.length - 1 ? e(r + 1) : null }, n } return e(0) }, G.apply = y(function(t, e) { return y(function(r) { return t.apply(null, e.concat(r)) }) }), G.concat = b(R), G.concatSeries = E(R), G.whilst = function(t, e, r) { if(r = r || i, t()) { var n = y(function(i, o) { i ? r(i) : t.apply(this, o) ? e(n) : r(null) });
								e(n) } else r(null) }, G.doWhilst = function(t, e, r) { var n = 0; return G.whilst(function() { return ++n <= 1 || e.apply(this, arguments) }, t, r) }, G.until = function(t, e, r) { return G.whilst(function() { return !t.apply(this, arguments) }, e, r) }, G.doUntil = function(t, e, r) { return G.doWhilst(t, function() { return !e.apply(this, arguments) }, r) }, G.during = function(t, e, r) { r = r || i; var n = y(function(e, n) { e ? r(e) : (n.push(o), t.apply(this, n)) }),
								o = function(t, i) { t ? r(t) : i ? e(n) : r(null) };
							t(o) }, G.doDuring = function(t, e, r) { var n = 0;
							G.during(function(t) { n++ < 1 ? t(null, !0) : e.apply(this, arguments) }, t, r) }, G.queue = function(t, e) { var r = D(function(e, r) { t(e[0], r) }, e, 1); return r }, G.priorityQueue = function(t, e) {
							function r(t, e) { return t.priority - e.priority }

							function n(t, e, r) { for(var n = -1, i = t.length - 1; i > n;) { var o = n + (i - n + 1 >>> 1);
									r(e, t[o]) >= 0 ? n = o : i = o - 1 } return n }

							function o(t, e, o, s) { if(null != s && "function" != typeof s) throw new Error("task callback must be a function"); return t.started = !0, k(e) || (e = [e]), 0 === e.length ? G.setImmediate(function() { t.drain() }) : void c(e, function(e) { var a = { data: e, priority: o, callback: "function" == typeof s ? s : i };
									t.tasks.splice(n(t.tasks, a, r) + 1, 0, a), t.tasks.length === t.concurrency && t.saturated(), G.setImmediate(t.process) }) } var s = G.queue(t, e); return s.push = function(t, e, r) { o(s, t, e, r) }, delete s.unshift, s }, G.cargo = function(t, e) { return D(t, 1, e) }, G.log = B("log"), G.dir = B("dir"), G.memoize = function(t, e) { var r = {},
								n = {};
							e = e || o; var i = y(function(i) { var o = i.pop(),
									s = e.apply(null, i);
								s in r ? G.setImmediate(function() { o.apply(null, r[s]) }) : s in n ? n[s].push(o) : (n[s] = [o], t.apply(null, i.concat([y(function(t) { r[s] = t; var e = n[s];
									delete n[s]; for(var i = 0, o = e.length; o > i; i++) e[i].apply(null, t) })]))) }); return i.memo = r, i.unmemoized = t, i }, G.unmemoize = function(t) { return function() { return(t.unmemoized || t).apply(null, arguments) } }, G.times = O(G.map), G.timesSeries = O(G.mapSeries), G.timesLimit = function(t, e, r, n) { return G.mapLimit(d(t), e, r, n) }, G.seq = function() { var t = arguments; return y(function(e) { var r = this,
									n = e[e.length - 1]; "function" == typeof n ? e.pop() : n = i, G.reduce(t, e, function(t, e, n) { e.apply(r, t.concat([y(function(t, e) { n(t, e) })])) }, function(t, e) { n.apply(r, [t].concat(e)) }) }) }, G.compose = function() { return G.seq.apply(null, Array.prototype.reverse.call(arguments)) }, G.applyEach = F(G.eachOf), G.applyEachSeries = F(G.eachOfSeries), G.forever = function(t, e) {
							function r(t) { return t ? n(t) : void o(r) } var n = l(e || i),
								o = L(t);
							r() }, G.ensureAsync = L, G.constant = y(function(t) { var e = [null].concat(t); return function(t) { return t.apply(this, e) } }), G.wrapSync = G.asyncify = function(t) { return y(function(e) { var r, n = e.pop(); try { r = t.apply(this, e) } catch(i) { return n(i) } U(r) && "function" == typeof r.then ? r.then(function(t) { n(null, t) })["catch"](function(t) { n(t.message ? t : new Error(t)) }) : n(null, r) }) }, "object" == typeof r && r.exports ? r.exports = G : "function" == typeof t && t.amd ? t([], function() { return G }) : N.async = G }() }).call(this, e("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}) }, { _process: 3 }],
			2: [function(t, e, r) {
				(function(t) {
					function e(t, e) { for(var r = 0, n = t.length - 1; n >= 0; n--) { var i = t[n]; "." === i ? t.splice(n, 1) : ".." === i ? (t.splice(n, 1), r++) : r && (t.splice(n, 1), r--) } if(e)
							for(; r--; r) t.unshift(".."); return t }

					function n(t, e) { if(t.filter) return t.filter(e); for(var r = [], n = 0; n < t.length; n++) e(t[n], n, t) && r.push(t[n]); return r } var i = /^(\/?|)([\s\S]*?)((?:\.{1,2}|[^\/]+?|)(\.[^.\/]*|))(?:[\/]*)$/,
						o = function(t) { return i.exec(t).slice(1) };
					r.resolve = function() { for(var r = "", i = !1, o = arguments.length - 1; o >= -1 && !i; o--) { var s = o >= 0 ? arguments[o] : t.cwd(); if("string" != typeof s) throw new TypeError("Arguments to path.resolve must be strings");
							s && (r = s + "/" + r, i = "/" === s.charAt(0)) } return r = e(n(r.split("/"), function(t) { return !!t }), !i).join("/"), (i ? "/" : "") + r || "." }, r.normalize = function(t) { var i = r.isAbsolute(t),
							o = "/" === s(t, -1); return t = e(n(t.split("/"), function(t) { return !!t }), !i).join("/"), t || i || (t = "."), t && o && (t += "/"), (i ? "/" : "") + t }, r.isAbsolute = function(t) { return "/" === t.charAt(0) }, r.join = function() { var t = Array.prototype.slice.call(arguments, 0); return r.normalize(n(t, function(t, e) { if("string" != typeof t) throw new TypeError("Arguments to path.join must be strings"); return t }).join("/")) }, r.relative = function(t, e) {
						function n(t) { for(var e = 0; e < t.length && "" === t[e]; e++); for(var r = t.length - 1; r >= 0 && "" === t[r]; r--); return e > r ? [] : t.slice(e, r - e + 1) } t = r.resolve(t).substr(1), e = r.resolve(e).substr(1); for(var i = n(t.split("/")), o = n(e.split("/")), s = Math.min(i.length, o.length), a = s, l = 0; s > l; l++)
							if(i[l] !== o[l]) { a = l; break }
						for(var u = [], l = a; l < i.length; l++) u.push(".."); return u = u.concat(o.slice(a)), u.join("/") }, r.sep = "/", r.delimiter = ":", r.dirname = function(t) { var e = o(t),
							r = e[0],
							n = e[1]; return r || n ? (n && (n = n.substr(0, n.length - 1)), r + n) : "." }, r.basename = function(t, e) { var r = o(t)[2]; return e && r.substr(-1 * e.length) === e && (r = r.substr(0, r.length - e.length)), r }, r.extname = function(t) { return o(t)[3] }; var s = "b" === "ab".substr(-1) ? function(t, e, r) { return t.substr(e, r) } : function(t, e, r) { return 0 > e && (e = t.length + e), t.substr(e, r) } }).call(this, t("_process")) }, { _process: 3 }],
			3: [function(t, e, r) {
				function n() { h = !1, a.length ? u = a.concat(u) : c = -1, u.length && i() }

				function i() { if(!h) { var t = setTimeout(n);
						h = !0; for(var e = u.length; e;) { for(a = u, u = []; ++c < e;) a && a[c].run();
							c = -1, e = u.length } a = null, h = !1, clearTimeout(t) } }

				function o(t, e) { this.fun = t, this.array = e }

				function s() {} var a, l = e.exports = {},
					u = [],
					h = !1,
					c = -1;
				l.nextTick = function(t) { var e = new Array(arguments.length - 1); if(arguments.length > 1)
						for(var r = 1; r < arguments.length; r++) e[r - 1] = arguments[r];
					u.push(new o(t, e)), 1 !== u.length || h || setTimeout(i, 0) }, o.prototype.run = function() { this.fun.apply(null, this.array) }, l.title = "browser", l.browser = !0, l.env = {}, l.argv = [], l.version = "", l.versions = {}, l.on = s, l.addListener = s, l.once = s, l.off = s, l.removeListener = s, l.removeAllListeners = s, l.emit = s, l.binding = function(t) { throw new Error("process.binding is not supported") }, l.cwd = function() { return "/" }, l.chdir = function(t) { throw new Error("process.chdir is not supported") }, l.umask = function() { return 0 } }, {}],
			4: [function(e, r, n) {
				(function(e) {! function(i) {
						function o(t) { throw RangeError(F[t]) }

						function s(t, e) { for(var r = t.length, n = []; r--;) n[r] = e(t[r]); return n }

						function a(t, e) { var r = t.split("@"),
								n = "";
							r.length > 1 && (n = r[0] + "@", t = r[1]), t = t.replace(O, "."); var i = t.split("."),
								o = s(i, e).join("."); return n + o }

						function l(t) { for(var e, r, n = [], i = 0, o = t.length; o > i;) e = t.charCodeAt(i++), e >= 55296 && 56319 >= e && o > i ? (r = t.charCodeAt(i++), 56320 == (64512 & r) ? n.push(((1023 & e) << 10) + (1023 & r) + 65536) : (n.push(e), i--)) : n.push(e); return n }

						function u(t) { return s(t, function(t) { var e = ""; return t > 65535 && (t -= 65536, e += G(t >>> 10 & 1023 | 55296), t = 56320 | 1023 & t), e += G(t) }).join("") }

						function h(t) { return 10 > t - 48 ? t - 22 : 26 > t - 65 ? t - 65 : 26 > t - 97 ? t - 97 : E }

						function c(t, e) { return t + 22 + 75 * (26 > t) - ((0 != e) << 5) }

						function p(t, e, r) { var n = 0; for(t = r ? I(t / w) : t >> 1, t += I(t / e); t > L * _ >> 1; n += E) t = I(t / L); return I(n + (L + 1) * t / (t + M)) }

						function d(t) { var e, r, n, i, s, a, l, c, d, f, v = [],
								g = t.length,
								m = 0,
								y = P,
								T = C; for(r = t.lastIndexOf(R), 0 > r && (r = 0), n = 0; r > n; ++n) t.charCodeAt(n) >= 128 && o("not-basic"), v.push(t.charCodeAt(n)); for(i = r > 0 ? r + 1 : 0; g > i;) { for(s = m, a = 1, l = E; i >= g && o("invalid-input"), c = h(t.charCodeAt(i++)), (c >= E || c > I((S - m) / a)) && o("overflow"), m += c * a, d = T >= l ? A : l >= T + _ ? _ : l - T, !(d > c); l += E) f = E - d, a > I(S / f) && o("overflow"), a *= f;
								e = v.length + 1, T = p(m - s, e, 0 == s), I(m / e) > S - y && o("overflow"), y += I(m / e), m %= e, v.splice(m++, 0, y) } return u(v) }

						function f(t) { var e, r, n, i, s, a, u, h, d, f, v, g, m, y, T, x = []; for(t = l(t), g = t.length, e = P, r = 0, s = C, a = 0; g > a; ++a) v = t[a], 128 > v && x.push(G(v)); for(n = i = x.length, i && x.push(R); g > n;) { for(u = S, a = 0; g > a; ++a) v = t[a], v >= e && u > v && (u = v); for(m = n + 1, u - e > I((S - r) / m) && o("overflow"), r += (u - e) * m, e = u, a = 0; g > a; ++a)
									if(v = t[a], e > v && ++r > S && o("overflow"), v == e) { for(h = r, d = E; f = s >= d ? A : d >= s + _ ? _ : d - s, !(f > h); d += E) T = h - f, y = E - f, x.push(G(c(f + T % y, 0))), h = I(T / y);
										x.push(G(c(h, 0))), s = p(r, m, n == i), r = 0, ++n }++r, ++e } return x.join("") }

						function v(t) { return a(t, function(t) { return D.test(t) ? d(t.slice(4).toLowerCase()) : t }) }

						function g(t) { return a(t, function(t) { return B.test(t) ? "xn--" + f(t) : t }) } var m = "object" == typeof n && n && !n.nodeType && n,
							y = "object" == typeof r && r && !r.nodeType && r,
							T = "object" == typeof e && e;
						(T.global === T || T.window === T || T.self === T) && (i = T); var x, b, S = 2147483647,
							E = 36,
							A = 1,
							_ = 26,
							M = 38,
							w = 700,
							C = 72,
							P = 128,
							R = "-",
							D = /^xn--/,
							B = /[^\x20-\x7E]/,
							O = /[\x2E\u3002\uFF0E\uFF61]/g,
							F = { overflow: "Overflow: input needs wider integers to process", "not-basic": "Illegal input >= 0x80 (not a basic code point)", "invalid-input": "Invalid input" },
							L = E - A,
							I = Math.floor,
							G = String.fromCharCode; if(x = { version: "1.3.2", ucs2: { decode: l, encode: u }, decode: d, encode: f, toASCII: g, toUnicode: v }, "function" == typeof t && "object" == typeof t.amd && t.amd) t("punycode", function() { return x });
						else if(m && y)
							if(r.exports == m) y.exports = x;
							else
								for(b in x) x.hasOwnProperty(b) && (m[b] = x[b]);
						else i.punycode = x }(this) }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}) }, {}],
			5: [function(t, e, r) { "use strict";

				function n(t, e) { return Object.prototype.hasOwnProperty.call(t, e) } e.exports = function(t, e, r, o) { e = e || "&", r = r || "="; var s = {}; if("string" != typeof t || 0 === t.length) return s; var a = /\+/g;
					t = t.split(e); var l = 1e3;
					o && "number" == typeof o.maxKeys && (l = o.maxKeys); var u = t.length;
					l > 0 && u > l && (u = l); for(var h = 0; u > h; ++h) { var c, p, d, f, v = t[h].replace(a, "%20"),
							g = v.indexOf(r);
						g >= 0 ? (c = v.substr(0, g), p = v.substr(g + 1)) : (c = v, p = ""), d = decodeURIComponent(c), f = decodeURIComponent(p), n(s, d) ? i(s[d]) ? s[d].push(f) : s[d] = [s[d], f] : s[d] = f } return s }; var i = Array.isArray || function(t) { return "[object Array]" === Object.prototype.toString.call(t) } }, {}],
			6: [function(t, e, r) { "use strict";

				function n(t, e) { if(t.map) return t.map(e); for(var r = [], n = 0; n < t.length; n++) r.push(e(t[n], n)); return r } var i = function(t) { switch(typeof t) {
						case "string":
							return t;
						case "boolean":
							return t ? "true" : "false";
						case "number":
							return isFinite(t) ? t : "";
						default:
							return "" } };
				e.exports = function(t, e, r, a) { return e = e || "&", r = r || "=", null === t && (t = void 0), "object" == typeof t ? n(s(t), function(s) { var a = encodeURIComponent(i(s)) + r; return o(t[s]) ? n(t[s], function(t) { return a + encodeURIComponent(i(t)) }).join(e) : a + encodeURIComponent(i(t[s])) }).join(e) : a ? encodeURIComponent(i(a)) + r + encodeURIComponent(i(t)) : "" }; var o = Array.isArray || function(t) { return "[object Array]" === Object.prototype.toString.call(t) },
					s = Object.keys || function(t) { var e = []; for(var r in t) Object.prototype.hasOwnProperty.call(t, r) && e.push(r); return e } }, {}],
			7: [function(t, e, r) {
				"use strict";
				r.decode = r.parse = t("./decode"),
					r.encode = r.stringify = t("./encode")
			}, { "./decode": 5, "./encode": 6 }],
			8: [function(t, e, r) {
				function n() { this.protocol = null, this.slashes = null, this.auth = null, this.host = null, this.port = null, this.hostname = null, this.hash = null, this.search = null, this.query = null, this.pathname = null, this.path = null, this.href = null }

				function i(t, e, r) { if(t && u(t) && t instanceof n) return t; var i = new n; return i.parse(t, e, r), i }

				function o(t) { return l(t) && (t = i(t)), t instanceof n ? t.format() : n.prototype.format.call(t) }

				function s(t, e) { return i(t, !1, !0).resolve(e) }

				function a(t, e) { return t ? i(t, !1, !0).resolveObject(e) : e }

				function l(t) { return "string" == typeof t }

				function u(t) { return "object" == typeof t && null !== t }

				function h(t) { return null === t }

				function c(t) { return null == t } var p = t("punycode");
				r.parse = i, r.resolve = s, r.resolveObject = a, r.format = o, r.Url = n; var d = /^([a-z0-9.+-]+:)/i,
					f = /:[0-9]*$/,
					v = ["<", ">", '"', "`", " ", "\r", "\n", "	"],
					g = ["{", "}", "|", "\\", "^", "`"].concat(v),
					m = ["'"].concat(g),
					y = ["%", "/", "?", ";", "#"].concat(m),
					T = ["/", "?", "#"],
					x = 255,
					b = /^[a-z0-9A-Z_-]{0,63}$/,
					S = /^([a-z0-9A-Z_-]{0,63})(.*)$/,
					E = { javascript: !0, "javascript:": !0 },
					A = { javascript: !0, "javascript:": !0 },
					_ = { http: !0, https: !0, ftp: !0, gopher: !0, file: !0, "http:": !0, "https:": !0, "ftp:": !0, "gopher:": !0, "file:": !0 },
					M = t("querystring");
				n.prototype.parse = function(t, e, r) { if(!l(t)) throw new TypeError("Parameter 'url' must be a string, not " + typeof t); var n = t;
					n = n.trim(); var i = d.exec(n); if(i) { i = i[0]; var o = i.toLowerCase();
						this.protocol = o, n = n.substr(i.length) } if(r || i || n.match(/^\/\/[^@\/]+@[^@\/]+/)) { var s = "//" === n.substr(0, 2);!s || i && A[i] || (n = n.substr(2), this.slashes = !0) } if(!A[i] && (s || i && !_[i])) { for(var a = -1, u = 0; u < T.length; u++) { var h = n.indexOf(T[u]); - 1 !== h && (-1 === a || a > h) && (a = h) } var c, f;
						f = -1 === a ? n.lastIndexOf("@") : n.lastIndexOf("@", a), -1 !== f && (c = n.slice(0, f), n = n.slice(f + 1), this.auth = decodeURIComponent(c)), a = -1; for(var u = 0; u < y.length; u++) { var h = n.indexOf(y[u]); - 1 !== h && (-1 === a || a > h) && (a = h) } - 1 === a && (a = n.length), this.host = n.slice(0, a), n = n.slice(a), this.parseHost(), this.hostname = this.hostname || ""; var v = "[" === this.hostname[0] && "]" === this.hostname[this.hostname.length - 1]; if(!v)
							for(var g = this.hostname.split(/\./), u = 0, w = g.length; w > u; u++) { var C = g[u]; if(C && !C.match(b)) { for(var P = "", R = 0, D = C.length; D > R; R++) P += C.charCodeAt(R) > 127 ? "x" : C[R]; if(!P.match(b)) { var B = g.slice(0, u),
											O = g.slice(u + 1),
											F = C.match(S);
										F && (B.push(F[1]), O.unshift(F[2])), O.length && (n = "/" + O.join(".") + n), this.hostname = B.join("."); break } } }
						if(this.hostname.length > x ? this.hostname = "" : this.hostname = this.hostname.toLowerCase(), !v) { for(var L = this.hostname.split("."), I = [], u = 0; u < L.length; ++u) { var G = L[u];
								I.push(G.match(/[^A-Za-z0-9_-]/) ? "xn--" + p.encode(G) : G) } this.hostname = I.join(".") } var N = this.port ? ":" + this.port : "",
							H = this.hostname || "";
						this.host = H + N, this.href += this.host, v && (this.hostname = this.hostname.substr(1, this.hostname.length - 2), "/" !== n[0] && (n = "/" + n)) } if(!E[o])
						for(var u = 0, w = m.length; w > u; u++) { var k = m[u],
								U = encodeURIComponent(k);
							U === k && (U = escape(k)), n = n.split(k).join(U) }
					var j = n.indexOf("#"); - 1 !== j && (this.hash = n.substr(j), n = n.slice(0, j)); var X = n.indexOf("?"); if(-1 !== X ? (this.search = n.substr(X), this.query = n.substr(X + 1), e && (this.query = M.parse(this.query)), n = n.slice(0, X)) : e && (this.search = "", this.query = {}), n && (this.pathname = n), _[o] && this.hostname && !this.pathname && (this.pathname = "/"), this.pathname || this.search) { var N = this.pathname || "",
							G = this.search || "";
						this.path = N + G } return this.href = this.format(), this }, n.prototype.format = function() { var t = this.auth || "";
					t && (t = encodeURIComponent(t), t = t.replace(/%3A/i, ":"), t += "@"); var e = this.protocol || "",
						r = this.pathname || "",
						n = this.hash || "",
						i = !1,
						o = "";
					this.host ? i = t + this.host : this.hostname && (i = t + (-1 === this.hostname.indexOf(":") ? this.hostname : "[" + this.hostname + "]"), this.port && (i += ":" + this.port)), this.query && u(this.query) && Object.keys(this.query).length && (o = M.stringify(this.query)); var s = this.search || o && "?" + o || ""; return e && ":" !== e.substr(-1) && (e += ":"), this.slashes || (!e || _[e]) && i !== !1 ? (i = "//" + (i || ""), r && "/" !== r.charAt(0) && (r = "/" + r)) : i || (i = ""), n && "#" !== n.charAt(0) && (n = "#" + n), s && "?" !== s.charAt(0) && (s = "?" + s), r = r.replace(/[?#]/g, function(t) { return encodeURIComponent(t) }), s = s.replace("#", "%23"), e + i + r + s + n }, n.prototype.resolve = function(t) { return this.resolveObject(i(t, !1, !0)).format() }, n.prototype.resolveObject = function(t) { if(l(t)) { var e = new n;
						e.parse(t, !1, !0), t = e } var r = new n; if(Object.keys(this).forEach(function(t) { r[t] = this[t] }, this), r.hash = t.hash, "" === t.href) return r.href = r.format(), r; if(t.slashes && !t.protocol) return Object.keys(t).forEach(function(e) { "protocol" !== e && (r[e] = t[e]) }), _[r.protocol] && r.hostname && !r.pathname && (r.path = r.pathname = "/"), r.href = r.format(), r; if(t.protocol && t.protocol !== r.protocol) { if(!_[t.protocol]) return Object.keys(t).forEach(function(e) { r[e] = t[e] }), r.href = r.format(), r; if(r.protocol = t.protocol, t.host || A[t.protocol]) r.pathname = t.pathname;
						else { for(var i = (t.pathname || "").split("/"); i.length && !(t.host = i.shift()););
							t.host || (t.host = ""), t.hostname || (t.hostname = ""), "" !== i[0] && i.unshift(""), i.length < 2 && i.unshift(""), r.pathname = i.join("/") } if(r.search = t.search, r.query = t.query, r.host = t.host || "", r.auth = t.auth, r.hostname = t.hostname || t.host, r.port = t.port, r.pathname || r.search) { var o = r.pathname || "",
								s = r.search || "";
							r.path = o + s } return r.slashes = r.slashes || t.slashes, r.href = r.format(), r } var a = r.pathname && "/" === r.pathname.charAt(0),
						u = t.host || t.pathname && "/" === t.pathname.charAt(0),
						p = u || a || r.host && t.pathname,
						d = p,
						f = r.pathname && r.pathname.split("/") || [],
						i = t.pathname && t.pathname.split("/") || [],
						v = r.protocol && !_[r.protocol]; if(v && (r.hostname = "", r.port = null, r.host && ("" === f[0] ? f[0] = r.host : f.unshift(r.host)), r.host = "", t.protocol && (t.hostname = null, t.port = null, t.host && ("" === i[0] ? i[0] = t.host : i.unshift(t.host)), t.host = null), p = p && ("" === i[0] || "" === f[0])), u) r.host = t.host || "" === t.host ? t.host : r.host, r.hostname = t.hostname || "" === t.hostname ? t.hostname : r.hostname, r.search = t.search, r.query = t.query, f = i;
					else if(i.length) f || (f = []), f.pop(), f = f.concat(i), r.search = t.search, r.query = t.query;
					else if(!c(t.search)) { if(v) { r.hostname = r.host = f.shift(); var g = r.host && r.host.indexOf("@") > 0 ? r.host.split("@") : !1;
							g && (r.auth = g.shift(), r.host = r.hostname = g.shift()) } return r.search = t.search, r.query = t.query, h(r.pathname) && h(r.search) || (r.path = (r.pathname ? r.pathname : "") + (r.search ? r.search : "")), r.href = r.format(), r } if(!f.length) return r.pathname = null, r.search ? r.path = "/" + r.search : r.path = null, r.href = r.format(), r; for(var m = f.slice(-1)[0], y = (r.host || t.host) && ("." === m || ".." === m) || "" === m, T = 0, x = f.length; x >= 0; x--) m = f[x], "." == m ? f.splice(x, 1) : ".." === m ? (f.splice(x, 1), T++) : T && (f.splice(x, 1), T--); if(!p && !d)
						for(; T--; T) f.unshift("..");!p || "" === f[0] || f[0] && "/" === f[0].charAt(0) || f.unshift(""), y && "/" !== f.join("/").substr(-1) && f.push(""); var b = "" === f[0] || f[0] && "/" === f[0].charAt(0); if(v) { r.hostname = r.host = b ? "" : f.length ? f.shift() : ""; var g = r.host && r.host.indexOf("@") > 0 ? r.host.split("@") : !1;
						g && (r.auth = g.shift(), r.host = r.hostname = g.shift()) } return p = p || r.host && f.length, p && !b && f.unshift(""), f.length ? r.pathname = f.join("/") : (r.pathname = null, r.path = null), h(r.pathname) && h(r.search) || (r.path = (r.pathname ? r.pathname : "") + (r.search ? r.search : "")), r.auth = t.auth || r.auth, r.slashes = r.slashes || t.slashes, r.href = r.format(), r }, n.prototype.parseHost = function() { var t = this.host,
						e = f.exec(t);
					e && (e = e[0], ":" !== e && (this.port = e.substr(1)), t = t.substr(0, t.length - e.length)), t && (this.hostname = t) } }, { punycode: 4, querystring: 7 }],
			9: [function(t, e, r) { "use strict";

				function n(t, e, r) { r = r || 2; var n = e && e.length,
						o = n ? e[0] * r : t.length,
						a = i(t, 0, o, r, !0),
						l = []; if(!a) return l; var u, h, p, d, f, v, g; if(n && (a = c(t, e, a, r)), t.length > 80 * r) { u = p = t[0], h = d = t[1]; for(var m = r; o > m; m += r) f = t[m], v = t[m + 1], u > f && (u = f), h > v && (h = v), f > p && (p = f), v > d && (d = v);
						g = Math.max(p - u, d - h) } return s(a, l, r, u, h, g), l }

				function i(t, e, r, n, i) { var o, s, a, l = 0; for(o = e, s = r - n; r > o; o += n) l += (t[s] - t[o]) * (t[o + 1] + t[s + 1]), s = o; if(i === l > 0)
						for(o = e; r > o; o += n) a = C(o, t[o], t[o + 1], a);
					else
						for(o = r - n; o >= e; o -= n) a = C(o, t[o], t[o + 1], a); return a }

				function o(t, e) { if(!t) return t;
					e || (e = t); var r, n = t;
					do
						if(r = !1, n.steiner || !S(n, n.next) && 0 !== b(n.prev, n, n.next)) n = n.next;
						else { if(P(n), n = e = n.prev, n === n.next) return null;
							r = !0 } while(r || n !== e);
					return e }

				function s(t, e, r, n, i, c, p) { if(t) {!p && c && v(t, n, i, c); for(var d, f, g = t; t.prev !== t.next;)
							if(d = t.prev, f = t.next, c ? l(t, n, i, c) : a(t)) e.push(d.i / r), e.push(t.i / r), e.push(f.i / r), P(t), t = f.next, g = f.next;
							else if(t = f, t === g) { p ? 1 === p ? (t = u(t, e, r), s(t, e, r, n, i, c, 2)) : 2 === p && h(t, e, r, n, i, c) : s(o(t), e, r, n, i, c, 1); break } } }

				function a(t) { var e = t.prev,
						r = t,
						n = t.next; if(b(e, r, n) >= 0) return !1; for(var i = t.next.next; i !== t.prev;) { if(T(e.x, e.y, r.x, r.y, n.x, n.y, i.x, i.y) && b(i.prev, i, i.next) >= 0) return !1;
						i = i.next } return !0 }

				function l(t, e, r, n) { var i = t.prev,
						o = t,
						s = t.next; if(b(i, o, s) >= 0) return !1; for(var a = i.x < o.x ? i.x < s.x ? i.x : s.x : o.x < s.x ? o.x : s.x, l = i.y < o.y ? i.y < s.y ? i.y : s.y : o.y < s.y ? o.y : s.y, u = i.x > o.x ? i.x > s.x ? i.x : s.x : o.x > s.x ? o.x : s.x, h = i.y > o.y ? i.y > s.y ? i.y : s.y : o.y > s.y ? o.y : s.y, c = m(a, l, e, r, n), p = m(u, h, e, r, n), d = t.nextZ; d && d.z <= p;) { if(d !== t.prev && d !== t.next && T(i.x, i.y, o.x, o.y, s.x, s.y, d.x, d.y) && b(d.prev, d, d.next) >= 0) return !1;
						d = d.nextZ } for(d = t.prevZ; d && d.z >= c;) { if(d !== t.prev && d !== t.next && T(i.x, i.y, o.x, o.y, s.x, s.y, d.x, d.y) && b(d.prev, d, d.next) >= 0) return !1;
						d = d.prevZ } return !0 }

				function u(t, e, r) { var n = t;
					do { var i = n.prev,
							o = n.next.next;
						E(i, n, n.next, o) && _(i, o) && _(o, i) && (e.push(i.i / r), e.push(n.i / r), e.push(o.i / r), P(n), P(n.next), n = t = o), n = n.next } while (n !== t); return n }

				function h(t, e, r, n, i, a) { var l = t;
					do { for(var u = l.next.next; u !== l.prev;) { if(l.i !== u.i && x(l, u)) { var h = w(l, u); return l = o(l, l.next), h = o(h, h.next), s(l, e, r, n, i, a), void s(h, e, r, n, i, a) } u = u.next } l = l.next } while (l !== t) }

				function c(t, e, r, n) { var s, a, l, u, h, c = []; for(s = 0, a = e.length; a > s; s++) l = e[s] * n, u = a - 1 > s ? e[s + 1] * n : t.length, h = i(t, l, u, n, !1), h === h.next && (h.steiner = !0), c.push(y(h)); for(c.sort(p), s = 0; s < c.length; s++) d(c[s], r), r = o(r, r.next); return r }

				function p(t, e) { return t.x - e.x }

				function d(t, e) { if(e = f(t, e)) { var r = w(e, t);
						o(r, r.next) } }

				function f(t, e) { var r, n = e,
						i = t.x,
						o = t.y,
						s = -(1 / 0);
					do { if(o <= n.y && o >= n.next.y) { var a = n.x + (o - n.y) * (n.next.x - n.x) / (n.next.y - n.y);
							i >= a && a > s && (s = a, r = n.x < n.next.x ? n : n.next) } n = n.next } while (n !== e); if(!r) return null; var l, u = r,
						h = 1 / 0; for(n = r.next; n !== u;) i >= n.x && n.x >= r.x && T(o < r.y ? i : s, o, r.x, r.y, o < r.y ? s : i, o, n.x, n.y) && (l = Math.abs(o - n.y) / (i - n.x), (h > l || l === h && n.x > r.x) && _(n, t) && (r = n, h = l)), n = n.next; return r }

				function v(t, e, r, n) { var i = t;
					do null === i.z && (i.z = m(i.x, i.y, e, r, n)), i.prevZ = i.prev, i.nextZ = i.next, i = i.next; while (i !== t);
					i.prevZ.nextZ = null, i.prevZ = null, g(i) }

				function g(t) { var e, r, n, i, o, s, a, l, u = 1;
					do { for(r = t, t = null, o = null, s = 0; r;) { for(s++, n = r, a = 0, e = 0; u > e && (a++, n = n.nextZ); e++); for(l = u; a > 0 || l > 0 && n;) 0 === a ? (i = n, n = n.nextZ, l--) : 0 !== l && n ? r.z <= n.z ? (i = r, r = r.nextZ, a--) : (i = n, n = n.nextZ, l--) : (i = r, r = r.nextZ, a--), o ? o.nextZ = i : t = i, i.prevZ = o, o = i;
							r = n } o.nextZ = null, u *= 2 } while (s > 1); return t }

				function m(t, e, r, n, i) { return t = 32767 * (t - r) / i, e = 32767 * (e - n) / i, t = 16711935 & (t | t << 8), t = 252645135 & (t | t << 4), t = 858993459 & (t | t << 2), t = 1431655765 & (t | t << 1), e = 16711935 & (e | e << 8), e = 252645135 & (e | e << 4), e = 858993459 & (e | e << 2), e = 1431655765 & (e | e << 1), t | e << 1 }

				function y(t) { var e = t,
						r = t;
					do e.x < r.x && (r = e), e = e.next; while (e !== t); return r }

				function T(t, e, r, n, i, o, s, a) { return(i - s) * (e - a) - (t - s) * (o - a) >= 0 && (t - s) * (n - a) - (r - s) * (e - a) >= 0 && (r - s) * (o - a) - (i - s) * (n - a) >= 0 }

				function x(t, e) { return S(t, e) || t.next.i !== e.i && t.prev.i !== e.i && !A(t, e) && _(t, e) && _(e, t) && M(t, e) }

				function b(t, e, r) { return(e.y - t.y) * (r.x - e.x) - (e.x - t.x) * (r.y - e.y) }

				function S(t, e) { return t.x === e.x && t.y === e.y }

				function E(t, e, r, n) { return b(t, e, r) > 0 != b(t, e, n) > 0 && b(r, n, t) > 0 != b(r, n, e) > 0 }

				function A(t, e) { var r = t;
					do { if(r.i !== t.i && r.next.i !== t.i && r.i !== e.i && r.next.i !== e.i && E(r, r.next, t, e)) return !0;
						r = r.next } while (r !== t); return !1 }

				function _(t, e) { return b(t.prev, t, t.next) < 0 ? b(t, e, t.next) >= 0 && b(t, t.prev, e) >= 0 : b(t, e, t.prev) < 0 || b(t, t.next, e) < 0 }

				function M(t, e) { var r = t,
						n = !1,
						i = (t.x + e.x) / 2,
						o = (t.y + e.y) / 2;
					do r.y > o != r.next.y > o && i < (r.next.x - r.x) * (o - r.y) / (r.next.y - r.y) + r.x && (n = !n), r = r.next; while (r !== t); return n }

				function w(t, e) { var r = new R(t.i, t.x, t.y),
						n = new R(e.i, e.x, e.y),
						i = t.next,
						o = e.prev; return t.next = e, e.prev = t, r.next = i, i.prev = r, n.next = r, r.prev = n, o.next = n, n.prev = o, n }

				function C(t, e, r, n) { var i = new R(t, e, r); return n ? (i.next = n.next, i.prev = n, n.next.prev = i, n.next = i) : (i.prev = i, i.next = i), i }

				function P(t) { t.next.prev = t.prev, t.prev.next = t.next, t.prevZ && (t.prevZ.nextZ = t.nextZ), t.nextZ && (t.nextZ.prevZ = t.prevZ) }

				function R(t, e, r) { this.i = t, this.x = e, this.y = r, this.prev = null, this.next = null, this.z = null, this.prevZ = null, this.nextZ = null, this.steiner = !1 } e.exports = n }, {}],
			10: [function(t, e, r) { "use strict";

				function n(t, e, r) { this.fn = t, this.context = e, this.once = r || !1 }

				function i() {} var o = "function" != typeof Object.create ? "~" : !1;
				i.prototype._events = void 0, i.prototype.listeners = function(t, e) { var r = o ? o + t : t,
						n = this._events && this._events[r]; if(e) return !!n; if(!n) return []; if(n.fn) return [n.fn]; for(var i = 0, s = n.length, a = new Array(s); s > i; i++) a[i] = n[i].fn; return a }, i.prototype.emit = function(t, e, r, n, i, s) { var a = o ? o + t : t; if(!this._events || !this._events[a]) return !1; var l, u, h = this._events[a],
						c = arguments.length; if("function" == typeof h.fn) { switch(h.once && this.removeListener(t, h.fn, void 0, !0), c) {
							case 1:
								return h.fn.call(h.context), !0;
							case 2:
								return h.fn.call(h.context, e), !0;
							case 3:
								return h.fn.call(h.context, e, r), !0;
							case 4:
								return h.fn.call(h.context, e, r, n), !0;
							case 5:
								return h.fn.call(h.context, e, r, n, i), !0;
							case 6:
								return h.fn.call(h.context, e, r, n, i, s), !0 } for(u = 1, l = new Array(c - 1); c > u; u++) l[u - 1] = arguments[u];
						h.fn.apply(h.context, l) } else { var p, d = h.length; for(u = 0; d > u; u++) switch(h[u].once && this.removeListener(t, h[u].fn, void 0, !0), c) {
							case 1:
								h[u].fn.call(h[u].context); break;
							case 2:
								h[u].fn.call(h[u].context, e); break;
							case 3:
								h[u].fn.call(h[u].context, e, r); break;
							default:
								if(!l)
									for(p = 1, l = new Array(c - 1); c > p; p++) l[p - 1] = arguments[p];
								h[u].fn.apply(h[u].context, l) } } return !0 }, i.prototype.on = function(t, e, r) { var i = new n(e, r || this),
						s = o ? o + t : t; return this._events || (this._events = o ? {} : Object.create(null)), this._events[s] ? this._events[s].fn ? this._events[s] = [this._events[s], i] : this._events[s].push(i) : this._events[s] = i, this }, i.prototype.once = function(t, e, r) { var i = new n(e, r || this, !0),
						s = o ? o + t : t; return this._events || (this._events = o ? {} : Object.create(null)), this._events[s] ? this._events[s].fn ? this._events[s] = [this._events[s], i] : this._events[s].push(i) : this._events[s] = i, this }, i.prototype.removeListener = function(t, e, r, n) { var i = o ? o + t : t; if(!this._events || !this._events[i]) return this; var s = this._events[i],
						a = []; if(e)
						if(s.fn)(s.fn !== e || n && !s.once || r && s.context !== r) && a.push(s);
						else
							for(var l = 0, u = s.length; u > l; l++)(s[l].fn !== e || n && !s[l].once || r && s[l].context !== r) && a.push(s[l]); return a.length ? this._events[i] = 1 === a.length ? a[0] : a : delete this._events[i], this }, i.prototype.removeAllListeners = function(t) { return this._events ? (t ? delete this._events[o ? o + t : t] : this._events = o ? {} : Object.create(null), this) : this }, i.prototype.off = i.prototype.removeListener, i.prototype.addListener = i.prototype.on, i.prototype.setMaxListeners = function() { return this }, i.prefixed = o, "undefined" != typeof e && (e.exports = i) }, {}],
			11: [function(t, e, r) { "use strict";

				function n(t) { if(null === t || void 0 === t) throw new TypeError("Object.assign cannot be called with null or undefined"); return Object(t) } var i = Object.prototype.hasOwnProperty,
					o = Object.prototype.propertyIsEnumerable;
				e.exports = Object.assign || function(t, e) { for(var r, s, a = n(t), l = 1; l < arguments.length; l++) { r = Object(arguments[l]); for(var u in r) i.call(r, u) && (a[u] = r[u]); if(Object.getOwnPropertySymbols) { s = Object.getOwnPropertySymbols(r); for(var h = 0; h < s.length; h++) o.call(r, s[h]) && (a[s[h]] = r[s[h]]) } } return a } }, {}],
			12: [function(t, e, r) { e.exports = { name: "pixi.js", version: "3.0.9", description: "Pixi.js is a fast lightweight 2D library that works across all devices.", author: "Mat Groves", contributors: ["Chad Engler <chad@pantherdev.com>", "Richard Davey <rdavey@gmail.com>"], main: "./src/index.js", homepage: "http://goodboydigital.com/", bugs: "https://github.com/pixijs/pixi.js/issues", license: "MIT", repository: { type: "git", url: "https://github.com/pixijs/pixi.js.git" }, scripts: { start: "gulp && gulp watch", test: "gulp && testem ci", build: "gulp", docs: "jsdoc -c ./gulp/util/jsdoc.conf.json -R README.md" }, files: ["bin/", "src/", "CONTRIBUTING.md", "LICENSE", "package.json", "README.md"], dependencies: { async: "^1.5.0", brfs: "^1.4.1", earcut: "^2.0.7", eventemitter3: "^1.1.1", "object-assign": "^4.0.1", "resource-loader": "^1.6.4" }, devDependencies: { browserify: "^11.1.0", chai: "^3.2.0", del: "^2.0.2", gulp: "^3.9.0", "gulp-cached": "^1.1.0", "gulp-concat": "^2.6.0", "gulp-debug": "^2.1.0", "gulp-header": "^1.7.1", "gulp-jshint": "^1.11.2", "gulp-mirror": "^0.4.0", "gulp-plumber": "^1.0.1", "gulp-rename": "^1.2.2", "gulp-sourcemaps": "^1.5.2", "gulp-uglify": "^1.4.1", "gulp-util": "^3.0.6", "jaguarjs-jsdoc": "git+https://github.com/davidshimjs/jaguarjs-jsdoc.git", jsdoc: "^3.3.2", "jshint-summary": "^0.4.0", minimist: "^1.2.0", mocha: "^2.3.2", "require-dir": "^0.3.0", "run-sequence": "^1.1.2", testem: "^0.9.4", "vinyl-buffer": "^1.0.0", "vinyl-source-stream": "^1.1.0", watchify: "^3.4.0" }, browserify: { transform: ["brfs"] } } }, {}],
			13: [function(t, e, r) {
				function n(t) { var e = document.createElement("div");
					e.style.width = "100px", e.style.height = "100px", e.style.position = "absolute", e.style.top = 0, e.style.left = 0, e.style.zIndex = 2, this.div = e, this.pool = [], this.renderId = 0, this.debug = !1, this.renderer = t, this.children = [], this._onKeyDown = this._onKeyDown.bind(this), this._onMouseMove = this._onMouseMove.bind(this), this.isActive = !1, window.addEventListener("keydown", this._onKeyDown, !1) } var i = t("../core");
				Object.assign(i.DisplayObject.prototype, t("./accessibleTarget")), n.prototype.constructor = n, e.exports = n, n.prototype.activate = function() { this.isActive || (this.isActive = !0, window.document.addEventListener("mousemove", this._onMouseMove, !0), window.removeEventListener("keydown", this._onKeyDown, !1), this.renderer.on("postrender", this.update, this), this.renderer.view.parentNode.appendChild(this.div)) }, n.prototype.deactivate = function() { this.isActive && (this.isActive = !1, window.document.removeEventListener("mousemove", this._onMouseMove), window.addEventListener("keydown", this._onKeyDown, !1), this.renderer.off("postrender", this.update), this.div.parentNode.removeChild(this.div)) }, n.prototype.updateAccessibleObjects = function(t) { if(t.visible) { t.accessible && t.interactive && (t._accessibleActive || this.addChild(t), t.renderId = this.renderId); for(var e = t.children, r = e.length - 1; r >= 0; r--) this.updateAccessibleObjects(e[r]) } }, n.prototype.update = function() { this.updateAccessibleObjects(this.renderer._lastObjectRendered); var t = this.renderer.view.getBoundingClientRect(),
						e = t.width / this.renderer.width,
						r = t.height / this.renderer.height,
						n = this.div;
					n.style.left = t.left + "px", n.style.top = t.top + "px", n.style.width = this.renderer.width + "px", n.style.height = this.renderer.height + "px"; for(var o = 0; o < this.children.length; o++) { var s = this.children[o]; if(s.renderId !== this.renderId) s._accessibleActive = !1, i.utils.removeItems(this.children, o, 1), this.div.removeChild(s._accessibleDiv), this.pool.push(s._accessibleDiv), s._accessibleDiv = null, o--, 0 === this.children.length && this.deactivate();
						else { n = s._accessibleDiv; var a = s.hitArea,
								l = s.worldTransform;
							s.hitArea ? (n.style.left = (l.tx + a.x * l.a) * e + "px", n.style.top = (l.ty + a.y * l.d) * r + "px", n.style.width = a.width * l.a * e + "px", n.style.height = a.height * l.d * r + "px") : (a = s.getBounds(), this.capHitArea(a), n.style.left = a.x * e + "px", n.style.top = a.y * r + "px", n.style.width = a.width * e + "px", n.style.height = a.height * r + "px") } } this.renderId++ }, n.prototype.capHitArea = function(t) { t.x < 0 && (t.width += t.x, t.x = 0), t.y < 0 && (t.height += t.y, t.y = 0), t.x + t.width > this.renderer.width && (t.width = this.renderer.width - t.x), t.y + t.height > this.renderer.height && (t.height = this.renderer.height - t.y) }, n.prototype.addChild = function(t) { var e = this.pool.pop();
					e || (e = document.createElement("button"), e.style.width = "100px", e.style.height = "100px", e.style.backgroundColor = this.debug ? "rgba(255,0,0,0.5)" : "transparent", e.style.position = "absolute", e.style.zIndex = 2, e.style.borderStyle = "none", e.addEventListener("click", this._onClick.bind(this)), e.addEventListener("focus", this._onFocus.bind(this)), e.addEventListener("focusout", this._onFocusOut.bind(this))), e.title = t.accessibleTitle || "displayObject " + this.tabIndex, t._accessibleActive = !0, t._accessibleDiv = e, e.displayObject = t, this.children.push(t), this.div.appendChild(t._accessibleDiv), t._accessibleDiv.tabIndex = t.tabIndex }, n.prototype._onClick = function(t) { var e = this.renderer.plugins.interaction;
					e.dispatchEvent(t.target.displayObject, "click", e.eventData) }, n.prototype._onFocus = function(t) { var e = this.renderer.plugins.interaction;
					e.dispatchEvent(t.target.displayObject, "mouseover", e.eventData) }, n.prototype._onFocusOut = function(t) { var e = this.renderer.plugins.interaction;
					e.dispatchEvent(t.target.displayObject, "mouseout", e.eventData) }, n.prototype._onKeyDown = function(t) { 9 === t.keyCode && this.activate() }, n.prototype._onMouseMove = function() { this.deactivate() }, n.prototype.destroy = function() { this.div = null; for(var t = 0; t < this.children.length; t++) this.children[t].div = null;
					window.document.removeEventListener("mousemove", this._onMouseMove), window.removeEventListener("keydown", this._onKeyDown), this.pool = null, this.children = null, this.renderer = null }, i.WebGLRenderer.registerPlugin("accessibility", n), i.CanvasRenderer.registerPlugin("accessibility", n) }, { "../core": 23, "./accessibleTarget": 14 }],
			14: [function(t, e, r) { var n = { accessible: !1, accessibleTitle: null, tabIndex: 0, _accessibleActive: !1, _accessibleDiv: !1 };
				e.exports = n }, {}],
			15: [function(t, e, r) { e.exports = { accessibleTarget: t("./accessibleTarget"), AccessibilityManager: t("./AccessibilityManager") } }, { "./AccessibilityManager": 13, "./accessibleTarget": 14 }],
			16: [function(t, e, r) { var n = { VERSION: t("../../package.json").version, PI_2: 2 * Math.PI, RAD_TO_DEG: 180 / Math.PI, DEG_TO_RAD: Math.PI / 180, TARGET_FPMS: .06, RENDERER_TYPE: { UNKNOWN: 0, WEBGL: 1, CANVAS: 2 }, BLEND_MODES: { NORMAL: 0, ADD: 1, MULTIPLY: 2, SCREEN: 3, OVERLAY: 4, DARKEN: 5, LIGHTEN: 6, COLOR_DODGE: 7, COLOR_BURN: 8, HARD_LIGHT: 9, SOFT_LIGHT: 10, DIFFERENCE: 11, EXCLUSION: 12, HUE: 13, SATURATION: 14, COLOR: 15, LUMINOSITY: 16 }, DRAW_MODES: { POINTS: 0, LINES: 1, LINE_LOOP: 2, LINE_STRIP: 3, TRIANGLES: 4, TRIANGLE_STRIP: 5, TRIANGLE_FAN: 6 }, SCALE_MODES: { DEFAULT: 0, LINEAR: 0, NEAREST: 1 }, RETINA_PREFIX: /@(.+)x/, RESOLUTION: 1, FILTER_RESOLUTION: 1, DEFAULT_RENDER_OPTIONS: { view: null, resolution: 1, antialias: !1, forceFXAA: !1, autoResize: !1, transparent: !1, backgroundColor: 0, clearBeforeRender: !0, preserveDrawingBuffer: !1, roundPixels: !1 }, SHAPES: { POLY: 0, RECT: 1, CIRC: 2, ELIP: 3, RREC: 4 }, SPRITE_BATCH_SIZE: 2e3 };
				e.exports = n }, { "../../package.json": 12 }],
			17: [function(t, e, r) {
				function n() { s.call(this), this.children = [] } var i = t("../math"),
					o = t("../utils"),
					s = t("./DisplayObject"),
					a = t("../textures/RenderTexture"),
					l = new i.Matrix;
				n.prototype = Object.create(s.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { width: { get: function() { return this.scale.x * this.getLocalBounds().width }, set: function(t) { var e = this.getLocalBounds().width;
							0 !== e ? this.scale.x = t / e : this.scale.x = 1, this._width = t } }, height: { get: function() { return this.scale.y * this.getLocalBounds().height }, set: function(t) { var e = this.getLocalBounds().height;
							0 !== e ? this.scale.y = t / e : this.scale.y = 1, this._height = t } } }), n.prototype.onChildrenChange = function() {}, n.prototype.addChild = function(t) { var e = arguments.length; if(e > 1)
						for(var r = 0; e > r; r++) this.addChild(arguments[r]);
					else t.parent && t.parent.removeChild(t), t.parent = this, this.children.push(t), this.onChildrenChange(this.children.length - 1), t.emit("added", this); return t }, n.prototype.addChildAt = function(t, e) { if(e >= 0 && e <= this.children.length) return t.parent && t.parent.removeChild(t), t.parent = this, this.children.splice(e, 0, t), this.onChildrenChange(e), t.emit("added", this), t; throw new Error(t + "addChildAt: The index " + e + " supplied is out of bounds " + this.children.length) }, n.prototype.swapChildren = function(t, e) { if(t !== e) { var r = this.getChildIndex(t),
							n = this.getChildIndex(e); if(0 > r || 0 > n) throw new Error("swapChildren: Both the supplied DisplayObjects must be children of the caller.");
						this.children[r] = e, this.children[n] = t, this.onChildrenChange(n > r ? r : n) } }, n.prototype.getChildIndex = function(t) { var e = this.children.indexOf(t); if(-1 === e) throw new Error("The supplied DisplayObject must be a child of the caller"); return e }, n.prototype.setChildIndex = function(t, e) { if(0 > e || e >= this.children.length) throw new Error("The supplied index is out of bounds"); var r = this.getChildIndex(t);
					o.removeItems(this.children, r, 1), this.children.splice(e, 0, t), this.onChildrenChange(e) }, n.prototype.getChildAt = function(t) { if(0 > t || t >= this.children.length) throw new Error("getChildAt: Supplied index " + t + " does not exist in the child list, or the supplied DisplayObject is not a child of the caller"); return this.children[t] }, n.prototype.removeChild = function(t) { var e = arguments.length; if(e > 1)
						for(var r = 0; e > r; r++) this.removeChild(arguments[r]);
					else { var n = this.children.indexOf(t); if(-1 === n) return;
						t.parent = null, o.removeItems(this.children, n, 1), this.onChildrenChange(n), t.emit("removed", this) } return t }, n.prototype.removeChildAt = function(t) { var e = this.getChildAt(t); return e.parent = null, o.removeItems(this.children, t, 1), this.onChildrenChange(t), e.emit("removed", this), e }, n.prototype.removeChildren = function(t, e) { var r, n, i = t || 0,
						o = "number" == typeof e ? e : this.children.length,
						s = o - i; if(s > 0 && o >= s) { for(r = this.children.splice(i, s), n = 0; n < r.length; ++n) r[n].parent = null; for(this.onChildrenChange(t), n = 0; n < r.length; ++n) r[n].emit("removed", this); return r } if(0 === s && 0 === this.children.length) return []; throw new RangeError("removeChildren: numeric values are outside the acceptable range.") }, n.prototype.generateTexture = function(t, e, r) { var n = this.getLocalBounds(),
						i = new a(t, 0 | n.width, 0 | n.height, r, e); return l.tx = -n.x, l.ty = -n.y, i.render(this, l), i }, n.prototype.updateTransform = function() { if(this.visible) { this.displayObjectUpdateTransform(); for(var t = 0, e = this.children.length; e > t; ++t) this.children[t].updateTransform() } }, n.prototype.containerUpdateTransform = n.prototype.updateTransform, n.prototype.getBounds = function() { if(!this._currentBounds) { if(0 === this.children.length) return i.Rectangle.EMPTY; for(var t, e, r, n = 1 / 0, o = 1 / 0, s = -(1 / 0), a = -(1 / 0), l = !1, u = 0, h = this.children.length; h > u; ++u) { var c = this.children[u];
							c.visible && (l = !0, t = this.children[u].getBounds(), n = n < t.x ? n : t.x, o = o < t.y ? o : t.y, e = t.width + t.x, r = t.height + t.y, s = s > e ? s : e, a = a > r ? a : r) } if(!l) return i.Rectangle.EMPTY; var p = this._bounds;
						p.x = n, p.y = o, p.width = s - n, p.height = a - o, this._currentBounds = p } return this._currentBounds }, n.prototype.containerGetBounds = n.prototype.getBounds, n.prototype.getLocalBounds = function() { var t = this.worldTransform;
					this.worldTransform = i.Matrix.IDENTITY; for(var e = 0, r = this.children.length; r > e; ++e) this.children[e].updateTransform(); return this.worldTransform = t, this._currentBounds = null, this.getBounds(i.Matrix.IDENTITY) }, n.prototype.renderWebGL = function(t) { if(this.visible && !(this.worldAlpha <= 0) && this.renderable) { var e, r; if(this._mask || this._filters) { for(t.currentRenderer.flush(), this._filters && this._filters.length && t.filterManager.pushFilter(this, this._filters), this._mask && t.maskManager.pushMask(this, this._mask), t.currentRenderer.start(), this._renderWebGL(t), e = 0, r = this.children.length; r > e; e++) this.children[e].renderWebGL(t);
							t.currentRenderer.flush(), this._mask && t.maskManager.popMask(this, this._mask), this._filters && t.filterManager.popFilter(), t.currentRenderer.start() } else
							for(this._renderWebGL(t), e = 0, r = this.children.length; r > e; ++e) this.children[e].renderWebGL(t) } }, n.prototype._renderWebGL = function(t) {}, n.prototype._renderCanvas = function(t) {}, n.prototype.renderCanvas = function(t) { if(this.visible && !(this.alpha <= 0) && this.renderable) { this._mask && t.maskManager.pushMask(this._mask, t), this._renderCanvas(t); for(var e = 0, r = this.children.length; r > e; ++e) this.children[e].renderCanvas(t);
						this._mask && t.maskManager.popMask(t) } }, n.prototype.destroy = function(t) { if(s.prototype.destroy.call(this), t)
						for(var e = 0, r = this.children.length; r > e; ++e) this.children[e].destroy(t);
					this.removeChildren(), this.children = null } }, { "../math": 26, "../textures/RenderTexture": 64, "../utils": 70, "./DisplayObject": 18 }],
			18: [function(t, e, r) {
				function n() { s.call(this), this.position = new i.Point, this.scale = new i.Point(1, 1), this.pivot = new i.Point(0, 0), this.skew = new i.Point(0, 0), this.rotation = 0, this.alpha = 1, this.visible = !0, this.renderable = !0, this.parent = null, this.worldAlpha = 1, this.worldTransform = new i.Matrix, this.filterArea = null, this._sr = 0, this._cr = 1, this._bounds = new i.Rectangle(0, 0, 1, 1), this._currentBounds = null, this._mask = null } var i = t("../math"),
					o = t("../textures/RenderTexture"),
					s = t("eventemitter3"),
					a = t("../const"),
					l = new i.Matrix,
					u = { worldTransform: new i.Matrix, worldAlpha: 1, children: [] };
				n.prototype = Object.create(s.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { x: { get: function() { return this.position.x }, set: function(t) { this.position.x = t } }, y: { get: function() { return this.position.y }, set: function(t) { this.position.y = t } }, worldVisible: { get: function() { var t = this;
							do { if(!t.visible) return !1;
								t = t.parent } while (t); return !0 } }, mask: { get: function() { return this._mask }, set: function(t) { this._mask && (this._mask.renderable = !0), this._mask = t, this._mask && (this._mask.renderable = !1) } }, filters: { get: function() { return this._filters && this._filters.slice() }, set: function(t) { this._filters = t && t.slice() } } }), n.prototype.updateTransform = function() { var t, e, r, n, i, o, s = this.parent.worldTransform,
						u = this.worldTransform;
					this.skew.x || this.skew.y ? (l.setTransform(this.position.x, this.position.y, this.pivot.x, this.pivot.y, this.scale.x, this.scale.y, this.rotation, this.skew.x, this.skew.y), u.a = l.a * s.a + l.b * s.c, u.b = l.a * s.b + l.b * s.d, u.c = l.c * s.a + l.d * s.c, u.d = l.c * s.b + l.d * s.d, u.tx = l.tx * s.a + l.ty * s.c + s.tx, u.ty = l.tx * s.b + l.ty * s.d + s.ty) : this.rotation % a.PI_2 ? (this.rotation !== this.rotationCache && (this.rotationCache = this.rotation, this._sr = Math.sin(this.rotation), this._cr = Math.cos(this.rotation)), t = this._cr * this.scale.x, e = this._sr * this.scale.x, r = -this._sr * this.scale.y, n = this._cr * this.scale.y, i = this.position.x, o = this.position.y, (this.pivot.x || this.pivot.y) && (i -= this.pivot.x * t + this.pivot.y * r, o -= this.pivot.x * e + this.pivot.y * n), u.a = t * s.a + e * s.c, u.b = t * s.b + e * s.d, u.c = r * s.a + n * s.c, u.d = r * s.b + n * s.d, u.tx = i * s.a + o * s.c + s.tx, u.ty = i * s.b + o * s.d + s.ty) : (t = this.scale.x, n = this.scale.y, i = this.position.x - this.pivot.x * t, o = this.position.y - this.pivot.y * n, u.a = t * s.a, u.b = t * s.b, u.c = n * s.c, u.d = n * s.d, u.tx = i * s.a + o * s.c + s.tx, u.ty = i * s.b + o * s.d + s.ty), this.worldAlpha = this.alpha * this.parent.worldAlpha, this._currentBounds = null }, n.prototype.displayObjectUpdateTransform = n.prototype.updateTransform, n.prototype.getBounds = function(t) { return i.Rectangle.EMPTY }, n.prototype.getLocalBounds = function() { return this.getBounds(i.Matrix.IDENTITY) }, n.prototype.toGlobal = function(t) { return this.parent ? this.displayObjectUpdateTransform() : (this.parent = u, this.displayObjectUpdateTransform(), this.parent = null), this.worldTransform.apply(t) }, n.prototype.toLocal = function(t, e, r) { return e && (t = e.toGlobal(t)), this.parent ? this.displayObjectUpdateTransform() : (this.parent = u, this.displayObjectUpdateTransform(), this.parent = null), this.worldTransform.applyInverse(t, r) }, n.prototype.renderWebGL = function(t) {}, n.prototype.renderCanvas = function(t) {}, n.prototype.generateTexture = function(t, e, r) { var n = this.getLocalBounds(),
						i = new o(t, 0 | n.width, 0 | n.height, e, r); return l.tx = -n.x, l.ty = -n.y, i.render(this, l), i }, n.prototype.setParent = function(t) { if(!t || !t.addChild) throw new Error("setParent: Argument must be a Container"); return t.addChild(this), t }, n.prototype.setTransform = function(t, e, r, n, i, o, s, a, l) { return this.position.x = t || 0, this.position.y = e || 0, this.scale.x = r ? r : 1, this.scale.y = n ? n : 1, this.rotation = i || 0, this.skew.x = o || 0, this.skew.y = s || 0, this.pivot.x = a || 0, this.pivot.y = l || 0, this }, n.prototype.destroy = function() { this.position = null, this.scale = null, this.pivot = null, this.skew = null, this.parent = null, this._bounds = null, this._currentBounds = null, this._mask = null, this.worldTransform = null, this.filterArea = null } }, { "../const": 16, "../math": 26, "../textures/RenderTexture": 64, eventemitter3: 10 }],
			19: [function(t, e, r) {
				function n() { i.call(this), this.fillAlpha = 1, this.lineWidth = 0, this.lineColor = 0, this.graphicsData = [], this.tint = 16777215, this._prevTint = 16777215, this.blendMode = h.BLEND_MODES.NORMAL, this.currentPath = null, this._webGL = {}, this.isMask = !1, this.boundsPadding = 0, this._localBounds = new u.Rectangle(0, 0, 1, 1), this.dirty = !0, this.glDirty = !1, this.boundsDirty = !0, this.cachedSpriteDirty = !1 }
				var i = t("../display/Container"),
					o = t("../textures/Texture"),
					s = t("../renderers/canvas/utils/CanvasBuffer"),
					a = t("../renderers/canvas/utils/CanvasGraphics"),
					l = t("./GraphicsData"),
					u = t("../math"),
					h = t("../const"),
					c = new u.Point;
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.clone = function() { var t = new n;
					t.renderable = this.renderable, t.fillAlpha = this.fillAlpha, t.lineWidth = this.lineWidth, t.lineColor = this.lineColor, t.tint = this.tint, t.blendMode = this.blendMode, t.isMask = this.isMask, t.boundsPadding = this.boundsPadding, t.dirty = !0, t.glDirty = !0, t.cachedSpriteDirty = this.cachedSpriteDirty; for(var e = 0; e < this.graphicsData.length; ++e) t.graphicsData.push(this.graphicsData[e].clone()); return t.currentPath = t.graphicsData[t.graphicsData.length - 1], t.updateLocalBounds(), t }, n.prototype.lineStyle = function(t, e, r) { if(this.lineWidth = t || 0, this.lineColor = e || 0, this.lineAlpha = void 0 === r ? 1 : r, this.currentPath)
						if(this.currentPath.shape.points.length) { var n = new u.Polygon(this.currentPath.shape.points.slice(-2));
							n.closed = !1, this.drawShape(n) } else this.currentPath.lineWidth = this.lineWidth, this.currentPath.lineColor = this.lineColor, this.currentPath.lineAlpha = this.lineAlpha; return this }, n.prototype.moveTo = function(t, e) { var r = new u.Polygon([t, e]); return r.closed = !1, this.drawShape(r), this }, n.prototype.lineTo = function(t, e) { return this.currentPath.shape.points.push(t, e), this.dirty = !0, this }, n.prototype.quadraticCurveTo = function(t, e, r, n) { this.currentPath ? 0 === this.currentPath.shape.points.length && (this.currentPath.shape.points = [0, 0]) : this.moveTo(0, 0); var i, o, s = 20,
						a = this.currentPath.shape.points;
					0 === a.length && this.moveTo(0, 0); for(var l = a[a.length - 2], u = a[a.length - 1], h = 0, c = 1; s >= c; ++c) h = c / s, i = l + (t - l) * h, o = u + (e - u) * h, a.push(i + (t + (r - t) * h - i) * h, o + (e + (n - e) * h - o) * h); return this.dirty = this.boundsDirty = !0, this }, n.prototype.bezierCurveTo = function(t, e, r, n, i, o) { this.currentPath ? 0 === this.currentPath.shape.points.length && (this.currentPath.shape.points = [0, 0]) : this.moveTo(0, 0); for(var s, a, l, u, h, c = 20, p = this.currentPath.shape.points, d = p[p.length - 2], f = p[p.length - 1], v = 0, g = 1; c >= g; ++g) v = g / c, s = 1 - v, a = s * s, l = a * s, u = v * v, h = u * v, p.push(l * d + 3 * a * v * t + 3 * s * u * r + h * i, l * f + 3 * a * v * e + 3 * s * u * n + h * o); return this.dirty = this.boundsDirty = !0, this }, n.prototype.arcTo = function(t, e, r, n, i) { this.currentPath ? 0 === this.currentPath.shape.points.length && this.currentPath.shape.points.push(t, e) : this.moveTo(t, e); var o = this.currentPath.shape.points,
						s = o[o.length - 2],
						a = o[o.length - 1],
						l = a - e,
						u = s - t,
						h = n - e,
						c = r - t,
						p = Math.abs(l * c - u * h); if(1e-8 > p || 0 === i)(o[o.length - 2] !== t || o[o.length - 1] !== e) && o.push(t, e);
					else { var d = l * l + u * u,
							f = h * h + c * c,
							v = l * h + u * c,
							g = i * Math.sqrt(d) / p,
							m = i * Math.sqrt(f) / p,
							y = g * v / d,
							T = m * v / f,
							x = g * c + m * u,
							b = g * h + m * l,
							S = u * (m + y),
							E = l * (m + y),
							A = c * (g + T),
							_ = h * (g + T),
							M = Math.atan2(E - b, S - x),
							w = Math.atan2(_ - b, A - x);
						this.arc(x + t, b + e, i, M, w, u * h > c * l) } return this.dirty = this.boundsDirty = !0, this }, n.prototype.arc = function(t, e, r, n, i, o) { if(o = o || !1, n === i) return this;!o && n >= i ? i += 2 * Math.PI : o && i >= n && (n += 2 * Math.PI); var s = o ? -1 * (n - i) : i - n,
						a = 40 * Math.ceil(Math.abs(s) / (2 * Math.PI)); if(0 === s) return this; var l = t + Math.cos(n) * r,
						u = e + Math.sin(n) * r;
					this.currentPath ? this.currentPath.shape.points.push(l, u) : this.moveTo(l, u); for(var h = this.currentPath.shape.points, c = s / (2 * a), p = 2 * c, d = Math.cos(c), f = Math.sin(c), v = a - 1, g = v % 1 / v, m = 0; v >= m; m++) { var y = m + g * m,
							T = c + n + p * y,
							x = Math.cos(T),
							b = -Math.sin(T);
						h.push((d * x + f * b) * r + t, (d * -b + f * x) * r + e) } return this.dirty = this.boundsDirty = !0, this }, n.prototype.beginFill = function(t, e) { return this.filling = !0, this.fillColor = t || 0, this.fillAlpha = void 0 === e ? 1 : e, this.currentPath && this.currentPath.shape.points.length <= 2 && (this.currentPath.fill = this.filling, this.currentPath.fillColor = this.fillColor, this.currentPath.fillAlpha = this.fillAlpha), this }, n.prototype.endFill = function() { return this.filling = !1, this.fillColor = null, this.fillAlpha = 1, this }, n.prototype.drawRect = function(t, e, r, n) { return this.drawShape(new u.Rectangle(t, e, r, n)), this }, n.prototype.drawRoundedRect = function(t, e, r, n, i) { return this.drawShape(new u.RoundedRectangle(t, e, r, n, i)), this }, n.prototype.drawCircle = function(t, e, r) { return this.drawShape(new u.Circle(t, e, r)), this }, n.prototype.drawEllipse = function(t, e, r, n) { return this.drawShape(new u.Ellipse(t, e, r, n)), this }, n.prototype.drawPolygon = function(t) { var e = t,
						r = !0; if(e instanceof u.Polygon && (r = e.closed, e = e.points), !Array.isArray(e)) { e = new Array(arguments.length); for(var n = 0; n < e.length; ++n) e[n] = arguments[n] } var i = new u.Polygon(e); return i.closed = r, this.drawShape(i), this }, n.prototype.clear = function() { return this.lineWidth = 0, this.filling = !1, this.dirty = !0, this.clearDirty = !0, this.graphicsData = [], this }, n.prototype.generateTexture = function(t, e, r) { e = e || 1; var n = this.getLocalBounds(),
						i = new s(n.width * e, n.height * e),
						l = o.fromCanvas(i.canvas, r); return l.baseTexture.resolution = e, i.context.scale(e, e), i.context.translate(-n.x, -n.y), a.renderGraphics(this, i.context), l }, n.prototype._renderWebGL = function(t) { this.glDirty && (this.dirty = !0, this.glDirty = !1), t.setObjectRenderer(t.plugins.graphics), t.plugins.graphics.render(this) }, n.prototype._renderCanvas = function(t) { if(this.isMask !== !0) { this._prevTint !== this.tint && (this.dirty = !0); var e = t.context,
							r = this.worldTransform,
							n = t.blendModes[this.blendMode];
						n !== e.globalCompositeOperation && (e.globalCompositeOperation = n); var i = t.resolution;
						e.setTransform(r.a * i, r.b * i, r.c * i, r.d * i, r.tx * i, r.ty * i), a.renderGraphics(this, e) } }, n.prototype.getBounds = function(t) { if(!this._currentBounds) { if(!this.renderable) return u.Rectangle.EMPTY;
						this.boundsDirty && (this.updateLocalBounds(), this.glDirty = !0, this.cachedSpriteDirty = !0, this.boundsDirty = !1); var e = this._localBounds,
							r = e.x,
							n = e.width + e.x,
							i = e.y,
							o = e.height + e.y,
							s = t || this.worldTransform,
							a = s.a,
							l = s.b,
							h = s.c,
							c = s.d,
							p = s.tx,
							d = s.ty,
							f = a * n + h * o + p,
							v = c * o + l * n + d,
							g = a * r + h * o + p,
							m = c * o + l * r + d,
							y = a * r + h * i + p,
							T = c * i + l * r + d,
							x = a * n + h * i + p,
							b = c * i + l * n + d,
							S = f,
							E = v,
							A = f,
							_ = v;
						A = A > g ? g : A, A = A > y ? y : A, A = A > x ? x : A, _ = _ > m ? m : _, _ = _ > T ? T : _, _ = _ > b ? b : _, S = g > S ? g : S, S = y > S ? y : S, S = x > S ? x : S, E = m > E ? m : E, E = T > E ? T : E, E = b > E ? b : E, this._bounds.x = A, this._bounds.width = S - A, this._bounds.y = _, this._bounds.height = E - _, this._currentBounds = this._bounds } return this._currentBounds }, n.prototype.containsPoint = function(t) { this.worldTransform.applyInverse(t, c); for(var e = this.graphicsData, r = 0; r < e.length; r++) { var n = e[r]; if(n.fill && n.shape && n.shape.contains(c.x, c.y)) return !0 } return !1 }, n.prototype.updateLocalBounds = function() { var t = 1 / 0,
						e = -(1 / 0),
						r = 1 / 0,
						n = -(1 / 0); if(this.graphicsData.length)
						for(var i, o, s, a, l, u, c = 0; c < this.graphicsData.length; c++) { var p = this.graphicsData[c],
								d = p.type,
								f = p.lineWidth; if(i = p.shape, d === h.SHAPES.RECT || d === h.SHAPES.RREC) s = i.x - f / 2, a = i.y - f / 2, l = i.width + f, u = i.height + f, t = t > s ? s : t, e = s + l > e ? s + l : e, r = r > a ? a : r, n = a + u > n ? a + u : n;
							else if(d === h.SHAPES.CIRC) s = i.x, a = i.y, l = i.radius + f / 2, u = i.radius + f / 2, t = t > s - l ? s - l : t, e = s + l > e ? s + l : e, r = r > a - u ? a - u : r, n = a + u > n ? a + u : n;
							else if(d === h.SHAPES.ELIP) s = i.x, a = i.y, l = i.width + f / 2, u = i.height + f / 2, t = t > s - l ? s - l : t, e = s + l > e ? s + l : e, r = r > a - u ? a - u : r, n = a + u > n ? a + u : n;
							else { o = i.points; for(var v = 0; v < o.length; v += 2) s = o[v], a = o[v + 1], t = t > s - f ? s - f : t, e = s + f > e ? s + f : e, r = r > a - f ? a - f : r, n = a + f > n ? a + f : n } } else t = 0, e = 0, r = 0, n = 0; var g = this.boundsPadding;
					this._localBounds.x = t - g, this._localBounds.width = e - t + 2 * g, this._localBounds.y = r - g, this._localBounds.height = n - r + 2 * g }, n.prototype.drawShape = function(t) { this.currentPath && this.currentPath.shape.points.length <= 2 && this.graphicsData.pop(), this.currentPath = null; var e = new l(this.lineWidth, this.lineColor, this.lineAlpha, this.fillColor, this.fillAlpha, this.filling, t); return this.graphicsData.push(e), e.type === h.SHAPES.POLY && (e.shape.closed = e.shape.closed || this.filling, this.currentPath = e), this.dirty = this.boundsDirty = !0, e }, n.prototype.destroy = function() { i.prototype.destroy.apply(this, arguments); for(var t = 0; t < this.graphicsData.length; ++t) this.graphicsData[t].destroy(); for(var e in this._webgl)
						for(var r = 0; r < this._webgl[e].data.length; ++r) this._webgl[e].data[r].destroy();
					this.graphicsData = null, this.currentPath = null, this._webgl = null, this._localBounds = null }
			}, { "../const": 16, "../display/Container": 17, "../math": 26, "../renderers/canvas/utils/CanvasBuffer": 38, "../renderers/canvas/utils/CanvasGraphics": 39, "../textures/Texture": 65, "./GraphicsData": 20 }],
			20: [function(t, e, r) {
				function n(t, e, r, n, i, o, s) { this.lineWidth = t, this.lineColor = e, this.lineAlpha = r, this._lineTint = e, this.fillColor = n, this.fillAlpha = i, this._fillTint = n, this.fill = o, this.shape = s, this.type = s.type } n.prototype.constructor = n, e.exports = n, n.prototype.clone = function() { return new n(this.lineWidth, this.lineColor, this.lineAlpha, this.fillColor, this.fillAlpha, this.fill, this.shape) }, n.prototype.destroy = function() { this.shape = null } }, {}],
			21: [function(t, e, r) {
				function n(t) { a.call(this, t), this.graphicsDataPool = [], this.primitiveShader = null, this.complexPrimitiveShader = null, this.maximumSimplePolySize = 200 } var i = t("../../utils"),
					o = t("../../math"),
					s = t("../../const"),
					a = t("../../renderers/webgl/utils/ObjectRenderer"),
					l = t("../../renderers/webgl/WebGLRenderer"),
					u = t("./WebGLGraphicsData"),
					h = t("earcut");
				n.prototype = Object.create(a.prototype), n.prototype.constructor = n, e.exports = n, l.registerPlugin("graphics", n), n.prototype.onContextChange = function() {}, n.prototype.destroy = function() { a.prototype.destroy.call(this); for(var t = 0; t < this.graphicsDataPool.length; ++t) this.graphicsDataPool[t].destroy();
					this.graphicsDataPool = null }, n.prototype.render = function(t) { var e, r = this.renderer,
						n = r.gl,
						o = r.shaderManager.plugins.primitiveShader;
					(t.dirty || !t._webGL[n.id]) && this.updateGraphics(t); var s = t._webGL[n.id];
					r.blendModeManager.setBlendMode(t.blendMode); for(var a = 0, l = s.data.length; l > a; a++) e = s.data[a], 1 === s.data[a].mode ? (r.stencilManager.pushStencil(t, e), n.uniform1f(r.shaderManager.complexPrimitiveShader.uniforms.alpha._location, t.worldAlpha * e.alpha), n.drawElements(n.TRIANGLE_FAN, 4, n.UNSIGNED_SHORT, 2 * (e.indices.length - 4)), r.stencilManager.popStencil(t, e)) : (o = r.shaderManager.primitiveShader, r.shaderManager.setShader(o), n.uniformMatrix3fv(o.uniforms.translationMatrix._location, !1, t.worldTransform.toArray(!0)), n.uniformMatrix3fv(o.uniforms.projectionMatrix._location, !1, r.currentRenderTarget.projectionMatrix.toArray(!0)), n.uniform3fv(o.uniforms.tint._location, i.hex2rgb(t.tint)), n.uniform1f(o.uniforms.alpha._location, t.worldAlpha), n.bindBuffer(n.ARRAY_BUFFER, e.buffer), n.vertexAttribPointer(o.attributes.aVertexPosition, 2, n.FLOAT, !1, 24, 0), n.vertexAttribPointer(o.attributes.aColor, 4, n.FLOAT, !1, 24, 8), n.bindBuffer(n.ELEMENT_ARRAY_BUFFER, e.indexBuffer), n.drawElements(n.TRIANGLE_STRIP, e.indices.length, n.UNSIGNED_SHORT, 0)), r.drawCount++ }, n.prototype.updateGraphics = function(t) { var e = this.renderer.gl,
						r = t._webGL[e.id];
					r || (r = t._webGL[e.id] = { lastIndex: 0, data: [], gl: e }), t.dirty = !1; var n; if(t.clearDirty) { for(t.clearDirty = !1, n = 0; n < r.data.length; n++) { var i = r.data[n];
							i.reset(), this.graphicsDataPool.push(i) } r.data = [], r.lastIndex = 0 } var o; for(n = r.lastIndex; n < t.graphicsData.length; n++) { var a = t.graphicsData[n]; if(a.type === s.SHAPES.POLY) { if(a.points = a.shape.points.slice(), a.shape.closed && (a.points[0] !== a.points[a.points.length - 2] || a.points[1] !== a.points[a.points.length - 1]) && a.points.push(a.points[0], a.points[1]), a.fill && a.points.length >= 6)
								if(a.points.length < 2 * this.maximumSimplePolySize) { o = this.switchMode(r, 0); var l = this.buildPoly(a, o);
									l || (o = this.switchMode(r, 1), this.buildComplexPoly(a, o)) } else o = this.switchMode(r, 1), this.buildComplexPoly(a, o);
							a.lineWidth > 0 && (o = this.switchMode(r, 0), this.buildLine(a, o)) } else o = this.switchMode(r, 0), a.type === s.SHAPES.RECT ? this.buildRectangle(a, o) : a.type === s.SHAPES.CIRC || a.type === s.SHAPES.ELIP ? this.buildCircle(a, o) : a.type === s.SHAPES.RREC && this.buildRoundedRectangle(a, o);
						r.lastIndex++ } for(n = 0; n < r.data.length; n++) o = r.data[n], o.dirty && o.upload() }, n.prototype.switchMode = function(t, e) { var r; return t.data.length ? (r = t.data[t.data.length - 1], (r.points.length > 32e4 || r.mode !== e || 1 === e) && (r = this.graphicsDataPool.pop() || new u(t.gl), r.mode = e, t.data.push(r))) : (r = this.graphicsDataPool.pop() || new u(t.gl), r.mode = e, t.data.push(r)), r.dirty = !0, r }, n.prototype.buildRectangle = function(t, e) { var r = t.shape,
						n = r.x,
						o = r.y,
						s = r.width,
						a = r.height; if(t.fill) { var l = i.hex2rgb(t.fillColor),
							u = t.fillAlpha,
							h = l[0] * u,
							c = l[1] * u,
							p = l[2] * u,
							d = e.points,
							f = e.indices,
							v = d.length / 6;
						d.push(n, o), d.push(h, c, p, u), d.push(n + s, o), d.push(h, c, p, u), d.push(n, o + a), d.push(h, c, p, u), d.push(n + s, o + a), d.push(h, c, p, u), f.push(v, v, v + 1, v + 2, v + 3, v + 3) } if(t.lineWidth) { var g = t.points;
						t.points = [n, o, n + s, o, n + s, o + a, n, o + a, n, o], this.buildLine(t, e), t.points = g } }, n.prototype.buildRoundedRectangle = function(t, e) { var r = t.shape,
						n = r.x,
						o = r.y,
						s = r.width,
						a = r.height,
						l = r.radius,
						u = []; if(u.push(n, o + l), this.quadraticBezierCurve(n, o + a - l, n, o + a, n + l, o + a, u), this.quadraticBezierCurve(n + s - l, o + a, n + s, o + a, n + s, o + a - l, u), this.quadraticBezierCurve(n + s, o + l, n + s, o, n + s - l, o, u), this.quadraticBezierCurve(n + l, o, n, o, n, o + l + 1e-10, u), t.fill) { var c = i.hex2rgb(t.fillColor),
							p = t.fillAlpha,
							d = c[0] * p,
							f = c[1] * p,
							v = c[2] * p,
							g = e.points,
							m = e.indices,
							y = g.length / 6,
							T = h(u, null, 2),
							x = 0; for(x = 0; x < T.length; x += 3) m.push(T[x] + y), m.push(T[x] + y), m.push(T[x + 1] + y), m.push(T[x + 2] + y), m.push(T[x + 2] + y); for(x = 0; x < u.length; x++) g.push(u[x], u[++x], d, f, v, p) } if(t.lineWidth) { var b = t.points;
						t.points = u, this.buildLine(t, e), t.points = b } }, n.prototype.quadraticBezierCurve = function(t, e, r, n, i, o, s) {
					function a(t, e, r) { var n = e - t; return t + n * r } for(var l, u, h, c, p, d, f = 20, v = s || [], g = 0, m = 0; f >= m; m++) g = m / f, l = a(t, r, g), u = a(e, n, g), h = a(r, i, g), c = a(n, o, g), p = a(l, h, g), d = a(u, c, g), v.push(p, d); return v }, n.prototype.buildCircle = function(t, e) { var r, n, o = t.shape,
						a = o.x,
						l = o.y;
					t.type === s.SHAPES.CIRC ? (r = o.radius, n = o.radius) : (r = o.width, n = o.height); var u = Math.floor(30 * Math.sqrt(o.radius)) || Math.floor(15 * Math.sqrt(o.width + o.height)),
						h = 2 * Math.PI / u,
						c = 0; if(t.fill) { var p = i.hex2rgb(t.fillColor),
							d = t.fillAlpha,
							f = p[0] * d,
							v = p[1] * d,
							g = p[2] * d,
							m = e.points,
							y = e.indices,
							T = m.length / 6; for(y.push(T), c = 0; u + 1 > c; c++) m.push(a, l, f, v, g, d), m.push(a + Math.sin(h * c) * r, l + Math.cos(h * c) * n, f, v, g, d), y.push(T++, T++);
						y.push(T - 1) } if(t.lineWidth) { var x = t.points; for(t.points = [], c = 0; u + 1 > c; c++) t.points.push(a + Math.sin(h * c) * r, l + Math.cos(h * c) * n);
						this.buildLine(t, e), t.points = x } }, n.prototype.buildLine = function(t, e) { var r = 0,
						n = t.points; if(0 !== n.length) { var s = new o.Point(n[0], n[1]),
							a = new o.Point(n[n.length - 2], n[n.length - 1]); if(s.x === a.x && s.y === a.y) { n = n.slice(), n.pop(), n.pop(), a = new o.Point(n[n.length - 2], n[n.length - 1]); var l = a.x + .5 * (s.x - a.x),
								u = a.y + .5 * (s.y - a.y);
							n.unshift(l, u), n.push(l, u) } var h, c, p, d, f, v, g, m, y, T, x, b, S, E, A, _, M, w, C, P, R, D, B, O = e.points,
							F = e.indices,
							L = n.length / 2,
							I = n.length,
							G = O.length / 6,
							N = t.lineWidth / 2,
							H = i.hex2rgb(t.lineColor),
							k = t.lineAlpha,
							U = H[0] * k,
							j = H[1] * k,
							X = H[2] * k; for(p = n[0], d = n[1], f = n[2], v = n[3], y = -(d - v), T = p - f, B = Math.sqrt(y * y + T * T), y /= B, T /= B, y *= N, T *= N, O.push(p - y, d - T, U, j, X, k), O.push(p + y, d + T, U, j, X, k), r = 1; L - 1 > r; r++) p = n[2 * (r - 1)], d = n[2 * (r - 1) + 1], f = n[2 * r], v = n[2 * r + 1], g = n[2 * (r + 1)], m = n[2 * (r + 1) + 1], y = -(d - v), T = p - f, B = Math.sqrt(y * y + T * T), y /= B, T /= B, y *= N, T *= N, x = -(v - m), b = f - g, B = Math.sqrt(x * x + b * b), x /= B, b /= B, x *= N, b *= N, A = -T + d - (-T + v), _ = -y + f - (-y + p), M = (-y + p) * (-T + v) - (-y + f) * (-T + d), w = -b + m - (-b + v), C = -x + f - (-x + g), P = (-x + g) * (-b + v) - (-x + f) * (-b + m), R = A * C - w * _, Math.abs(R) < .1 ? (R += 10.1, O.push(f - y, v - T, U, j, X, k), O.push(f + y, v + T, U, j, X, k)) : (h = (_ * P - C * M) / R, c = (w * M - A * P) / R, D = (h - f) * (h - f) + (c - v) * (c - v), D > 19600 ? (S = y - x, E = T - b, B = Math.sqrt(S * S + E * E), S /= B, E /= B, S *= N, E *= N, O.push(f - S, v - E), O.push(U, j, X, k), O.push(f + S, v + E), O.push(U, j, X, k), O.push(f - S, v - E), O.push(U, j, X, k), I++) : (O.push(h, c), O.push(U, j, X, k), O.push(f - (h - f), v - (c - v)), O.push(U, j, X, k))); for(p = n[2 * (L - 2)], d = n[2 * (L - 2) + 1], f = n[2 * (L - 1)], v = n[2 * (L - 1) + 1], y = -(d - v), T = p - f, B = Math.sqrt(y * y + T * T), y /= B, T /= B, y *= N, T *= N, O.push(f - y, v - T), O.push(U, j, X, k), O.push(f + y, v + T), O.push(U, j, X, k), F.push(G), r = 0; I > r; r++) F.push(G++);
						F.push(G - 1) } }, n.prototype.buildComplexPoly = function(t, e) { var r = t.points.slice(); if(!(r.length < 6)) { var n = e.indices;
						e.points = r, e.alpha = t.fillAlpha, e.color = i.hex2rgb(t.fillColor); for(var o, s, a = 1 / 0, l = -(1 / 0), u = 1 / 0, h = -(1 / 0), c = 0; c < r.length; c += 2) o = r[c], s = r[c + 1], a = a > o ? o : a, l = o > l ? o : l, u = u > s ? s : u, h = s > h ? s : h;
						r.push(a, u, l, u, l, h, a, h); var p = r.length / 2; for(c = 0; p > c; c++) n.push(c) } }, n.prototype.buildPoly = function(t, e) { var r = t.points; if(!(r.length < 6)) { var n = e.points,
							o = e.indices,
							s = r.length / 2,
							a = i.hex2rgb(t.fillColor),
							l = t.fillAlpha,
							u = a[0] * l,
							c = a[1] * l,
							p = a[2] * l,
							d = h(r, null, 2); if(!d) return !1; var f = n.length / 6,
							v = 0; for(v = 0; v < d.length; v += 3) o.push(d[v] + f), o.push(d[v] + f), o.push(d[v + 1] + f), o.push(d[v + 2] + f), o.push(d[v + 2] + f); for(v = 0; s > v; v++) n.push(r[2 * v], r[2 * v + 1], u, c, p, l); return !0 } } }, { "../../const": 16, "../../math": 26, "../../renderers/webgl/WebGLRenderer": 42, "../../renderers/webgl/utils/ObjectRenderer": 56, "../../utils": 70, "./WebGLGraphicsData": 22, earcut: 9 }],
			22: [function(t, e, r) {
				function n(t) { this.gl = t, this.color = [0, 0, 0], this.points = [], this.indices = [], this.buffer = t.createBuffer(), this.indexBuffer = t.createBuffer(), this.mode = 1, this.alpha = 1, this.dirty = !0, this.glPoints = null, this.glIndices = null } n.prototype.constructor = n, e.exports = n, n.prototype.reset = function() { this.points.length = 0, this.indices.length = 0 }, n.prototype.upload = function() { var t = this.gl;
					this.glPoints = new Float32Array(this.points), t.bindBuffer(t.ARRAY_BUFFER, this.buffer), t.bufferData(t.ARRAY_BUFFER, this.glPoints, t.STATIC_DRAW), this.glIndices = new Uint16Array(this.indices), t.bindBuffer(t.ELEMENT_ARRAY_BUFFER, this.indexBuffer), t.bufferData(t.ELEMENT_ARRAY_BUFFER, this.glIndices, t.STATIC_DRAW), this.dirty = !1 }, n.prototype.destroy = function() { this.color = null, this.points = null, this.indices = null, this.gl.deleteBuffer(this.buffer), this.gl.deleteBuffer(this.indexBuffer), this.gl = null, this.buffer = null, this.indexBuffer = null, this.glPoints = null, this.glIndices = null } }, {}],
			23: [function(t, e, r) { var n = e.exports = Object.assign(t("./const"), t("./math"), { utils: t("./utils"), ticker: t("./ticker"), DisplayObject: t("./display/DisplayObject"), Container: t("./display/Container"), Sprite: t("./sprites/Sprite"), ParticleContainer: t("./particles/ParticleContainer"), SpriteRenderer: t("./sprites/webgl/SpriteRenderer"), ParticleRenderer: t("./particles/webgl/ParticleRenderer"), Text: t("./text/Text"), Graphics: t("./graphics/Graphics"), GraphicsData: t("./graphics/GraphicsData"), GraphicsRenderer: t("./graphics/webgl/GraphicsRenderer"), Texture: t("./textures/Texture"), BaseTexture: t("./textures/BaseTexture"), RenderTexture: t("./textures/RenderTexture"), VideoBaseTexture: t("./textures/VideoBaseTexture"), TextureUvs: t("./textures/TextureUvs"), CanvasRenderer: t("./renderers/canvas/CanvasRenderer"), CanvasGraphics: t("./renderers/canvas/utils/CanvasGraphics"), CanvasBuffer: t("./renderers/canvas/utils/CanvasBuffer"), WebGLRenderer: t("./renderers/webgl/WebGLRenderer"), WebGLManager: t("./renderers/webgl/managers/WebGLManager"), ShaderManager: t("./renderers/webgl/managers/ShaderManager"), Shader: t("./renderers/webgl/shaders/Shader"), ObjectRenderer: t("./renderers/webgl/utils/ObjectRenderer"), RenderTarget: t("./renderers/webgl/utils/RenderTarget"), AbstractFilter: t("./renderers/webgl/filters/AbstractFilter"), FXAAFilter: t("./renderers/webgl/filters/FXAAFilter"), SpriteMaskFilter: t("./renderers/webgl/filters/SpriteMaskFilter"), autoDetectRenderer: function(t, e, r, i) { return t = t || 800, e = e || 600, !i && n.utils.isWebGLSupported() ? new n.WebGLRenderer(t, e, r) : new n.CanvasRenderer(t, e, r) } }) }, { "./const": 16, "./display/Container": 17, "./display/DisplayObject": 18, "./graphics/Graphics": 19, "./graphics/GraphicsData": 20, "./graphics/webgl/GraphicsRenderer": 21, "./math": 26, "./particles/ParticleContainer": 32, "./particles/webgl/ParticleRenderer": 34, "./renderers/canvas/CanvasRenderer": 37, "./renderers/canvas/utils/CanvasBuffer": 38, "./renderers/canvas/utils/CanvasGraphics": 39, "./renderers/webgl/WebGLRenderer": 42, "./renderers/webgl/filters/AbstractFilter": 43, "./renderers/webgl/filters/FXAAFilter": 44, "./renderers/webgl/filters/SpriteMaskFilter": 45, "./renderers/webgl/managers/ShaderManager": 49, "./renderers/webgl/managers/WebGLManager": 51, "./renderers/webgl/shaders/Shader": 54, "./renderers/webgl/utils/ObjectRenderer": 56, "./renderers/webgl/utils/RenderTarget": 58, "./sprites/Sprite": 60, "./sprites/webgl/SpriteRenderer": 61, "./text/Text": 62, "./textures/BaseTexture": 63, "./textures/RenderTexture": 64, "./textures/Texture": 65, "./textures/TextureUvs": 66, "./textures/VideoBaseTexture": 67, "./ticker": 69, "./utils": 70 }],
			24: [function(t, e, r) {
				function n() { this.a = 1, this.b = 0, this.c = 0, this.d = 1, this.tx = 0, this.ty = 0 } var i = t("./Point");
				n.prototype.constructor = n, e.exports = n, n.prototype.fromArray = function(t) { this.a = t[0], this.b = t[1], this.c = t[3], this.d = t[4], this.tx = t[2], this.ty = t[5] }, n.prototype.set = function(t, e, r, n, i, o) { return this.a = t, this.b = e, this.c = r, this.d = n, this.tx = i, this.ty = o, this }, n.prototype.toArray = function(t, e) { this.array || (this.array = new Float32Array(9)); var r = e || this.array; return t ? (r[0] = this.a, r[1] = this.b, r[2] = 0, r[3] = this.c, r[4] = this.d, r[5] = 0, r[6] = this.tx, r[7] = this.ty, r[8] = 1) : (r[0] = this.a, r[1] = this.c, r[2] = this.tx, r[3] = this.b, r[4] = this.d, r[5] = this.ty, r[6] = 0, r[7] = 0, r[8] = 1), r }, n.prototype.apply = function(t, e) { e = e || new i; var r = t.x,
						n = t.y; return e.x = this.a * r + this.c * n + this.tx, e.y = this.b * r + this.d * n + this.ty, e }, n.prototype.applyInverse = function(t, e) { e = e || new i; var r = 1 / (this.a * this.d + this.c * -this.b),
						n = t.x,
						o = t.y; return e.x = this.d * r * n + -this.c * r * o + (this.ty * this.c - this.tx * this.d) * r, e.y = this.a * r * o + -this.b * r * n + (-this.ty * this.a + this.tx * this.b) * r, e }, n.prototype.translate = function(t, e) { return this.tx += t, this.ty += e, this }, n.prototype.scale = function(t, e) { return this.a *= t, this.d *= e, this.c *= t, this.b *= e, this.tx *= t, this.ty *= e, this }, n.prototype.rotate = function(t) { var e = Math.cos(t),
						r = Math.sin(t),
						n = this.a,
						i = this.c,
						o = this.tx; return this.a = n * e - this.b * r, this.b = n * r + this.b * e, this.c = i * e - this.d * r, this.d = i * r + this.d * e, this.tx = o * e - this.ty * r, this.ty = o * r + this.ty * e, this }, n.prototype.append = function(t) { var e = this.a,
						r = this.b,
						n = this.c,
						i = this.d; return this.a = t.a * e + t.b * n, this.b = t.a * r + t.b * i, this.c = t.c * e + t.d * n, this.d = t.c * r + t.d * i, this.tx = t.tx * e + t.ty * n + this.tx, this.ty = t.tx * r + t.ty * i + this.ty, this }, n.prototype.setTransform = function(t, e, r, n, i, o, s, a, l) { var u, h, c, p, d, f, v, g, m, y; return d = Math.sin(s), f = Math.cos(s), v = Math.cos(l), g = Math.sin(l), m = -Math.sin(a), y = Math.cos(a), u = f * i, h = d * i, c = -d * o, p = f * o, this.a = v * u + g * c, this.b = v * h + g * p, this.c = m * u + y * c, this.d = m * h + y * p, this.tx = t + (r * u + n * c), this.ty = e + (r * h + n * p), this }, n.prototype.prepend = function(t) { var e = this.tx; if(1 !== t.a || 0 !== t.b || 0 !== t.c || 1 !== t.d) { var r = this.a,
							n = this.c;
						this.a = r * t.a + this.b * t.c, this.b = r * t.b + this.b * t.d, this.c = n * t.a + this.d * t.c, this.d = n * t.b + this.d * t.d } return this.tx = e * t.a + this.ty * t.c + t.tx, this.ty = e * t.b + this.ty * t.d + t.ty, this }, n.prototype.invert = function() { var t = this.a,
						e = this.b,
						r = this.c,
						n = this.d,
						i = this.tx,
						o = t * n - e * r; return this.a = n / o, this.b = -e / o, this.c = -r / o, this.d = t / o, this.tx = (r * this.ty - n * i) / o, this.ty = -(t * this.ty - e * i) / o, this }, n.prototype.identity = function() { return this.a = 1, this.b = 0, this.c = 0, this.d = 1, this.tx = 0, this.ty = 0, this }, n.prototype.clone = function() { var t = new n; return t.a = this.a, t.b = this.b, t.c = this.c, t.d = this.d, t.tx = this.tx, t.ty = this.ty, t }, n.prototype.copy = function(t) { return t.a = this.a, t.b = this.b, t.c = this.c, t.d = this.d, t.tx = this.tx, t.ty = this.ty, t }, n.IDENTITY = new n, n.TEMP_MATRIX = new n }, { "./Point": 25 }],
			25: [function(t, e, r) {
				function n(t, e) { this.x = t || 0, this.y = e || 0 } n.prototype.constructor = n, e.exports = n, n.prototype.clone = function() { return new n(this.x, this.y) }, n.prototype.copy = function(t) { this.set(t.x, t.y) }, n.prototype.equals = function(t) { return t.x === this.x && t.y === this.y }, n.prototype.set = function(t, e) { this.x = t || 0, this.y = e || (0 !== e ? this.x : 0) } }, {}],
			26: [function(t, e, r) { e.exports = { Point: t("./Point"), Matrix: t("./Matrix"), Circle: t("./shapes/Circle"), Ellipse: t("./shapes/Ellipse"), Polygon: t("./shapes/Polygon"), Rectangle: t("./shapes/Rectangle"), RoundedRectangle: t("./shapes/RoundedRectangle") } }, { "./Matrix": 24, "./Point": 25, "./shapes/Circle": 27, "./shapes/Ellipse": 28, "./shapes/Polygon": 29, "./shapes/Rectangle": 30, "./shapes/RoundedRectangle": 31 }],
			27: [function(t, e, r) {
				function n(t, e, r) { this.x = t || 0, this.y = e || 0, this.radius = r || 0, this.type = o.SHAPES.CIRC } var i = t("./Rectangle"),
					o = t("../../const");
				n.prototype.constructor = n, e.exports = n, n.prototype.clone = function() { return new n(this.x, this.y, this.radius) }, n.prototype.contains = function(t, e) { if(this.radius <= 0) return !1; var r = this.x - t,
						n = this.y - e,
						i = this.radius * this.radius; return r *= r, n *= n, i >= r + n }, n.prototype.getBounds = function() { return new i(this.x - this.radius, this.y - this.radius, 2 * this.radius, 2 * this.radius) } }, { "../../const": 16, "./Rectangle": 30 }],
			28: [function(t, e, r) {
				function n(t, e, r, n) { this.x = t || 0, this.y = e || 0, this.width = r || 0, this.height = n || 0, this.type = o.SHAPES.ELIP } var i = t("./Rectangle"),
					o = t("../../const");
				n.prototype.constructor = n, e.exports = n, n.prototype.clone = function() { return new n(this.x, this.y, this.width, this.height) }, n.prototype.contains = function(t, e) { if(this.width <= 0 || this.height <= 0) return !1; var r = (t - this.x) / this.width,
						n = (e - this.y) / this.height; return r *= r, n *= n, 1 >= r + n }, n.prototype.getBounds = function() { return new i(this.x - this.width, this.y - this.height, this.width, this.height) } }, { "../../const": 16, "./Rectangle": 30 }],
			29: [function(t, e, r) {
				function n(t) { var e = t; if(!Array.isArray(e)) { e = new Array(arguments.length); for(var r = 0; r < e.length; ++r) e[r] = arguments[r] } if(e[0] instanceof i) { for(var n = [], s = 0, a = e.length; a > s; s++) n.push(e[s].x, e[s].y);
						e = n } this.closed = !0, this.points = e, this.type = o.SHAPES.POLY } var i = t("../Point"),
					o = t("../../const");
				n.prototype.constructor = n, e.exports = n, n.prototype.clone = function() { return new n(this.points.slice()) }, n.prototype.contains = function(t, e) { for(var r = !1, n = this.points.length / 2, i = 0, o = n - 1; n > i; o = i++) { var s = this.points[2 * i],
							a = this.points[2 * i + 1],
							l = this.points[2 * o],
							u = this.points[2 * o + 1],
							h = a > e != u > e && (l - s) * (e - a) / (u - a) + s > t;
						h && (r = !r) } return r } }, { "../../const": 16, "../Point": 25 }],
			30: [function(t, e, r) {
				function n(t, e, r, n) { this.x = t || 0, this.y = e || 0, this.width = r || 0, this.height = n || 0, this.type = i.SHAPES.RECT } var i = t("../../const");
				n.prototype.constructor = n, e.exports = n, n.EMPTY = new n(0, 0, 0, 0), n.prototype.clone = function() { return new n(this.x, this.y, this.width, this.height) }, n.prototype.contains = function(t, e) { return this.width <= 0 || this.height <= 0 ? !1 : t >= this.x && t < this.x + this.width && e >= this.y && e < this.y + this.height ? !0 : !1 } }, { "../../const": 16 }],
			31: [function(t, e, r) {
				function n(t, e, r, n, o) { this.x = t || 0, this.y = e || 0, this.width = r || 0, this.height = n || 0, this.radius = o || 20, this.type = i.SHAPES.RREC } var i = t("../../const");
				n.prototype.constructor = n, e.exports = n, n.prototype.clone = function() { return new n(this.x, this.y, this.width, this.height, this.radius) }, n.prototype.contains = function(t, e) { return this.width <= 0 || this.height <= 0 ? !1 : t >= this.x && t <= this.x + this.width && e >= this.y && e <= this.y + this.height ? !0 : !1 } }, { "../../const": 16 }],
			32: [function(t, e, r) {
				function n(t, e, r) { i.call(this), r = r || 15e3, t = t || 15e3; var n = 16384;
					r > n && (r = n), r > t && (r = t), this._properties = [!1, !0, !1, !1, !1], this._maxSize = t, this._batchSize = r, this._buffers = null, this._bufferToUpdate = 0, this.interactiveChildren = !1, this.blendMode = o.BLEND_MODES.NORMAL, this.roundPixels = !0, this.setProperties(e) } var i = t("../display/Container"),
					o = t("../const");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.setProperties = function(t) { t && (this._properties[0] = "scale" in t ? !!t.scale : this._properties[0], this._properties[1] = "position" in t ? !!t.position : this._properties[1], this._properties[2] = "rotation" in t ? !!t.rotation : this._properties[2], this._properties[3] = "uvs" in t ? !!t.uvs : this._properties[3], this._properties[4] = "alpha" in t ? !!t.alpha : this._properties[4]) }, n.prototype.updateTransform = function() { this.displayObjectUpdateTransform() }, n.prototype.renderWebGL = function(t) { this.visible && !(this.worldAlpha <= 0) && this.children.length && this.renderable && (t.setObjectRenderer(t.plugins.particle), t.plugins.particle.render(this)) }, n.prototype.onChildrenChange = function(t) { var e = Math.floor(t / this._batchSize);
					e < this._bufferToUpdate && (this._bufferToUpdate = e) }, n.prototype.renderCanvas = function(t) { if(this.visible && !(this.worldAlpha <= 0) && this.children.length && this.renderable) { var e = t.context,
							r = this.worldTransform,
							n = !0,
							i = 0,
							o = 0,
							s = 0,
							a = 0,
							l = t.blendModes[this.blendMode];
						l !== e.globalCompositeOperation && (e.globalCompositeOperation = l), e.globalAlpha = this.worldAlpha, this.displayObjectUpdateTransform(); for(var u = 0; u < this.children.length; ++u) { var h = this.children[u]; if(h.visible) { var c = h.texture.frame; if(e.globalAlpha = this.worldAlpha * h.alpha, h.rotation % (2 * Math.PI) === 0) n && (e.setTransform(r.a, r.b, r.c, r.d, r.tx, r.ty), n = !1), i = h.anchor.x * (-c.width * h.scale.x) + h.position.x + .5, o = h.anchor.y * (-c.height * h.scale.y) + h.position.y + .5, s = c.width * h.scale.x, a = c.height * h.scale.y;
								else { n || (n = !0), h.displayObjectUpdateTransform(); var p = h.worldTransform;
									t.roundPixels ? e.setTransform(p.a, p.b, p.c, p.d, 0 | p.tx, 0 | p.ty) : e.setTransform(p.a, p.b, p.c, p.d, p.tx, p.ty), i = h.anchor.x * -c.width + .5, o = h.anchor.y * -c.height + .5, s = c.width, a = c.height } e.drawImage(h.texture.baseTexture.source, c.x, c.y, c.width, c.height, i, o, s, a) } } } }, n.prototype.destroy = function() { if(i.prototype.destroy.apply(this, arguments), this._buffers)
						for(var t = 0; t < this._buffers.length; ++t) this._buffers[t].destroy();
					this._properties = null, this._buffers = null } }, { "../const": 16, "../display/Container": 17 }],
			33: [function(t, e, r) {
				function n(t, e, r, n) { this.gl = t, this.vertSize = 2, this.vertByteSize = 4 * this.vertSize, this.size = n, this.dynamicProperties = [], this.staticProperties = []; for(var i = 0; i < e.length; i++) { var o = e[i];
						r[i] ? this.dynamicProperties.push(o) : this.staticProperties.push(o) } this.staticStride = 0, this.staticBuffer = null, this.staticData = null, this.dynamicStride = 0, this.dynamicBuffer = null, this.dynamicData = null, this.initBuffers() } n.prototype.constructor = n, e.exports = n, n.prototype.initBuffers = function() { var t, e, r = this.gl,
						n = 0; for(this.dynamicStride = 0, t = 0; t < this.dynamicProperties.length; t++) e = this.dynamicProperties[t], e.offset = n, n += e.size, this.dynamicStride += e.size;
					this.dynamicData = new Float32Array(this.size * this.dynamicStride * 4), this.dynamicBuffer = r.createBuffer(), r.bindBuffer(r.ARRAY_BUFFER, this.dynamicBuffer), r.bufferData(r.ARRAY_BUFFER, this.dynamicData, r.DYNAMIC_DRAW); var i = 0; for(this.staticStride = 0, t = 0; t < this.staticProperties.length; t++) e = this.staticProperties[t], e.offset = i, i += e.size, this.staticStride += e.size;
					this.staticData = new Float32Array(this.size * this.staticStride * 4), this.staticBuffer = r.createBuffer(), r.bindBuffer(r.ARRAY_BUFFER, this.staticBuffer), r.bufferData(r.ARRAY_BUFFER, this.staticData, r.DYNAMIC_DRAW) }, n.prototype.uploadDynamic = function(t, e, r) { for(var n = this.gl, i = 0; i < this.dynamicProperties.length; i++) { var o = this.dynamicProperties[i];
						o.uploadFunction(t, e, r, this.dynamicData, this.dynamicStride, o.offset) } n.bindBuffer(n.ARRAY_BUFFER, this.dynamicBuffer), n.bufferSubData(n.ARRAY_BUFFER, 0, this.dynamicData) }, n.prototype.uploadStatic = function(t, e, r) { for(var n = this.gl, i = 0; i < this.staticProperties.length; i++) { var o = this.staticProperties[i];
						o.uploadFunction(t, e, r, this.staticData, this.staticStride, o.offset) } n.bindBuffer(n.ARRAY_BUFFER, this.staticBuffer), n.bufferSubData(n.ARRAY_BUFFER, 0, this.staticData) }, n.prototype.bind = function() { var t, e, r = this.gl; for(r.bindBuffer(r.ARRAY_BUFFER, this.dynamicBuffer), t = 0; t < this.dynamicProperties.length; t++) e = this.dynamicProperties[t], r.vertexAttribPointer(e.attribute, e.size, r.FLOAT, !1, 4 * this.dynamicStride, 4 * e.offset); for(r.bindBuffer(r.ARRAY_BUFFER, this.staticBuffer), t = 0; t < this.staticProperties.length; t++) e = this.staticProperties[t], r.vertexAttribPointer(e.attribute, e.size, r.FLOAT, !1, 4 * this.staticStride, 4 * e.offset) }, n.prototype.destroy = function() { this.dynamicProperties = null, this.dynamicData = null, this.gl.deleteBuffer(this.dynamicBuffer), this.staticProperties = null, this.staticData = null, this.gl.deleteBuffer(this.staticBuffer) } }, {}],
			34: [function(t, e, r) {
				function n(t) { i.call(this, t); var e = 98304;
					this.indices = new Uint16Array(e); for(var r = 0, n = 0; e > r; r += 6, n += 4) this.indices[r + 0] = n + 0, this.indices[r + 1] = n + 1, this.indices[r + 2] = n + 2, this.indices[r + 3] = n + 0, this.indices[r + 4] = n + 2, this.indices[r + 5] = n + 3;
					this.shader = null, this.indexBuffer = null, this.properties = null, this.tempMatrix = new l.Matrix }
				var i = t("../../renderers/webgl/utils/ObjectRenderer"),
					o = t("../../renderers/webgl/WebGLRenderer"),
					s = t("./ParticleShader"),
					a = t("./ParticleBuffer"),
					l = t("../../math");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, o.registerPlugin("particle", n), n.prototype.onContextChange = function() {
					var t = this.renderer.gl;
					this.shader = new s(this.renderer.shaderManager), this.indexBuffer = t.createBuffer(), t.bindBuffer(t.ELEMENT_ARRAY_BUFFER, this.indexBuffer), t.bufferData(t.ELEMENT_ARRAY_BUFFER, this.indices, t.STATIC_DRAW), this.properties = [{ attribute: this.shader.attributes.aVertexPosition, size: 2, uploadFunction: this.uploadVertices, offset: 0 }, { attribute: this.shader.attributes.aPositionCoord, size: 2, uploadFunction: this.uploadPosition, offset: 0 }, { attribute: this.shader.attributes.aRotation, size: 1, uploadFunction: this.uploadRotation, offset: 0 }, {
						attribute: this.shader.attributes.aTextureCoord,
						size: 2,
						uploadFunction: this.uploadUvs,
						offset: 0
					}, { attribute: this.shader.attributes.aColor, size: 1, uploadFunction: this.uploadAlpha, offset: 0 }]
				}, n.prototype.start = function() { var t = this.renderer.gl;
					t.activeTexture(t.TEXTURE0), t.bindBuffer(t.ELEMENT_ARRAY_BUFFER, this.indexBuffer); var e = this.shader;
					this.renderer.shaderManager.setShader(e) }, n.prototype.render = function(t) { var e = t.children,
						r = e.length,
						n = t._maxSize,
						i = t._batchSize; if(0 !== r) { r > n && (r = n), t._buffers || (t._buffers = this.generateBuffers(t)), this.renderer.blendModeManager.setBlendMode(t.blendMode); var o = this.renderer.gl,
							s = t.worldTransform.copy(this.tempMatrix);
						s.prepend(this.renderer.currentRenderTarget.projectionMatrix), o.uniformMatrix3fv(this.shader.uniforms.projectionMatrix._location, !1, s.toArray(!0)), o.uniform1f(this.shader.uniforms.uAlpha._location, t.worldAlpha); var a = e[0]._texture.baseTexture; if(a._glTextures[o.id]) o.bindTexture(o.TEXTURE_2D, a._glTextures[o.id]);
						else { if(!this.renderer.updateTexture(a)) return;
							t._properties[0] && t._properties[3] || (t._bufferToUpdate = 0) } for(var l = 0, u = 0; r > l; l += i, u += 1) { var h = r - l;
							h > i && (h = i); var c = t._buffers[u];
							c.uploadDynamic(e, l, h), t._bufferToUpdate === u && (c.uploadStatic(e, l, h), t._bufferToUpdate = u + 1), c.bind(this.shader), o.drawElements(o.TRIANGLES, 6 * h, o.UNSIGNED_SHORT, 0), this.renderer.drawCount++ } } }, n.prototype.generateBuffers = function(t) { var e, r = this.renderer.gl,
						n = [],
						i = t._maxSize,
						o = t._batchSize,
						s = t._properties; for(e = 0; i > e; e += o) n.push(new a(r, this.properties, s, o)); return n }, n.prototype.uploadVertices = function(t, e, r, n, i, o) { for(var s, a, l, u, h, c, p, d, f, v = 0; r > v; v++) s = t[e + v], a = s._texture, u = s.scale.x, h = s.scale.y, a.trim ? (l = a.trim, p = l.x - s.anchor.x * l.width, c = p + a.crop.width, f = l.y - s.anchor.y * l.height, d = f + a.crop.height) : (c = a._frame.width * (1 - s.anchor.x), p = a._frame.width * -s.anchor.x, d = a._frame.height * (1 - s.anchor.y), f = a._frame.height * -s.anchor.y), n[o] = p * u, n[o + 1] = f * h, n[o + i] = c * u, n[o + i + 1] = f * h, n[o + 2 * i] = c * u, n[o + 2 * i + 1] = d * h, n[o + 3 * i] = p * u, n[o + 3 * i + 1] = d * h, o += 4 * i }, n.prototype.uploadPosition = function(t, e, r, n, i, o) { for(var s = 0; r > s; s++) { var a = t[e + s].position;
						n[o] = a.x, n[o + 1] = a.y, n[o + i] = a.x, n[o + i + 1] = a.y, n[o + 2 * i] = a.x, n[o + 2 * i + 1] = a.y, n[o + 3 * i] = a.x, n[o + 3 * i + 1] = a.y, o += 4 * i } }, n.prototype.uploadRotation = function(t, e, r, n, i, o) { for(var s = 0; r > s; s++) { var a = t[e + s].rotation;
						n[o] = a, n[o + i] = a, n[o + 2 * i] = a, n[o + 3 * i] = a, o += 4 * i } }, n.prototype.uploadUvs = function(t, e, r, n, i, o) { for(var s = 0; r > s; s++) { var a = t[e + s]._texture._uvs;
						a ? (n[o] = a.x0, n[o + 1] = a.y0, n[o + i] = a.x1, n[o + i + 1] = a.y1, n[o + 2 * i] = a.x2, n[o + 2 * i + 1] = a.y2, n[o + 3 * i] = a.x3, n[o + 3 * i + 1] = a.y3, o += 4 * i) : (n[o] = 0, n[o + 1] = 0, n[o + i] = 0, n[o + i + 1] = 0, n[o + 2 * i] = 0, n[o + 2 * i + 1] = 0, n[o + 3 * i] = 0, n[o + 3 * i + 1] = 0, o += 4 * i) } }, n.prototype.uploadAlpha = function(t, e, r, n, i, o) { for(var s = 0; r > s; s++) { var a = t[e + s].alpha;
						n[o] = a, n[o + i] = a, n[o + 2 * i] = a, n[o + 3 * i] = a, o += 4 * i } }, n.prototype.destroy = function() { this.renderer.gl && this.renderer.gl.deleteBuffer(this.indexBuffer), i.prototype.destroy.apply(this, arguments), this.shader.destroy(), this.indices = null, this.tempMatrix = null }
			}, { "../../math": 26, "../../renderers/webgl/WebGLRenderer": 42, "../../renderers/webgl/utils/ObjectRenderer": 56, "./ParticleBuffer": 33, "./ParticleShader": 35 }],
			35: [function(t, e, r) {
				function n(t) { i.call(this, t, ["attribute vec2 aVertexPosition;", "attribute vec2 aTextureCoord;", "attribute float aColor;", "attribute vec2 aPositionCoord;", "attribute vec2 aScale;", "attribute float aRotation;", "uniform mat3 projectionMatrix;", "varying vec2 vTextureCoord;", "varying float vColor;", "void main(void){", "   vec2 v = aVertexPosition;", "   v.x = (aVertexPosition.x) * cos(aRotation) - (aVertexPosition.y) * sin(aRotation);", "   v.y = (aVertexPosition.x) * sin(aRotation) + (aVertexPosition.y) * cos(aRotation);", "   v = v + aPositionCoord;", "   gl_Position = vec4((projectionMatrix * vec3(v, 1.0)).xy, 0.0, 1.0);", "   vTextureCoord = aTextureCoord;", "   vColor = aColor;", "}"].join("\n"), ["precision lowp float;", "varying vec2 vTextureCoord;", "varying float vColor;", "uniform sampler2D uSampler;", "uniform float uAlpha;", "void main(void){", "  vec4 color = texture2D(uSampler, vTextureCoord) * vColor * uAlpha;", "  if (color.a == 0.0) discard;", "  gl_FragColor = color;", "}"].join("\n"), { uAlpha: { type: "1f", value: 1 } }, { aPositionCoord: 0, aRotation: 0 }) } var i = t("../../renderers/webgl/shaders/TextureShader");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n }, { "../../renderers/webgl/shaders/TextureShader": 55 }],
			36: [function(t, e, r) {
				function n(t, e, r, n) { if(a.call(this), i.sayHello(t), n)
						for(var l in s.DEFAULT_RENDER_OPTIONS) "undefined" == typeof n[l] && (n[l] = s.DEFAULT_RENDER_OPTIONS[l]);
					else n = s.DEFAULT_RENDER_OPTIONS;
					this.type = s.RENDERER_TYPE.UNKNOWN, this.width = e || 800, this.height = r || 600, this.view = n.view || document.createElement("canvas"), this.resolution = n.resolution, this.transparent = n.transparent, this.autoResize = n.autoResize || !1, this.blendModes = null, this.preserveDrawingBuffer = n.preserveDrawingBuffer, this.clearBeforeRender = n.clearBeforeRender, this.roundPixels = n.roundPixels, this._backgroundColor = 0, this._backgroundColorRgb = [0, 0, 0], this._backgroundColorString = "#000000", this.backgroundColor = n.backgroundColor || this._backgroundColor, this._tempDisplayObjectParent = { worldTransform: new o.Matrix, worldAlpha: 1, children: [] }, this._lastObjectRendered = this._tempDisplayObjectParent } var i = t("../utils"),
					o = t("../math"),
					s = t("../const"),
					a = t("eventemitter3");
				n.prototype = Object.create(a.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { backgroundColor: { get: function() { return this._backgroundColor }, set: function(t) { this._backgroundColor = t, this._backgroundColorString = i.hex2string(t), i.hex2rgb(t, this._backgroundColorRgb) } } }), n.prototype.resize = function(t, e) { this.width = t * this.resolution, this.height = e * this.resolution, this.view.width = this.width, this.view.height = this.height, this.autoResize && (this.view.style.width = this.width / this.resolution + "px", this.view.style.height = this.height / this.resolution + "px") }, n.prototype.destroy = function(t) { t && this.view.parentNode && this.view.parentNode.removeChild(this.view), this.type = s.RENDERER_TYPE.UNKNOWN, this.width = 0, this.height = 0, this.view = null, this.resolution = 0, this.transparent = !1, this.autoResize = !1, this.blendModes = null, this.preserveDrawingBuffer = !1, this.clearBeforeRender = !1, this.roundPixels = !1, this._backgroundColor = 0, this._backgroundColorRgb = null, this._backgroundColorString = null } }, { "../const": 16, "../math": 26, "../utils": 70, eventemitter3: 10 }],
			37: [function(t, e, r) {
				function n(t, e, r) { r = r || {}, i.call(this, "Canvas", t, e, r), this.type = l.RENDERER_TYPE.CANVAS, this.context = this.view.getContext("2d", { alpha: this.transparent }), this.refresh = !0, this.maskManager = new o, this.smoothProperty = "imageSmoothingEnabled", this.context.imageSmoothingEnabled || (this.context.webkitImageSmoothingEnabled ? this.smoothProperty = "webkitImageSmoothingEnabled" : this.context.mozImageSmoothingEnabled ? this.smoothProperty = "mozImageSmoothingEnabled" : this.context.oImageSmoothingEnabled ? this.smoothProperty = "oImageSmoothingEnabled" : this.context.msImageSmoothingEnabled && (this.smoothProperty = "msImageSmoothingEnabled")), this.initPlugins(), this._mapBlendModes(), this._tempDisplayObjectParent = { worldTransform: new a.Matrix, worldAlpha: 1 }, this.resize(t, e) } var i = t("../SystemRenderer"),
					o = t("./utils/CanvasMaskManager"),
					s = t("../../utils"),
					a = t("../../math"),
					l = t("../../const");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, s.pluginTarget.mixin(n), n.prototype.render = function(t) { this.emit("prerender"); var e = t.parent;
					this._lastObjectRendered = t, t.parent = this._tempDisplayObjectParent, t.updateTransform(), t.parent = e, this.context.setTransform(1, 0, 0, 1, 0, 0), this.context.globalAlpha = 1, this.context.globalCompositeOperation = this.blendModes[l.BLEND_MODES.NORMAL], navigator.isCocoonJS && this.view.screencanvas && (this.context.fillStyle = "black", this.context.clear()), this.clearBeforeRender && (this.transparent ? this.context.clearRect(0, 0, this.width, this.height) : (this.context.fillStyle = this._backgroundColorString, this.context.fillRect(0, 0, this.width, this.height))), this.renderDisplayObject(t, this.context), this.emit("postrender") }, n.prototype.destroy = function(t) { this.destroyPlugins(), i.prototype.destroy.call(this, t), this.context = null, this.refresh = !0, this.maskManager.destroy(), this.maskManager = null, this.smoothProperty = null }, n.prototype.renderDisplayObject = function(t, e) { var r = this.context;
					this.context = e, t.renderCanvas(this), this.context = r }, n.prototype.resize = function(t, e) { i.prototype.resize.call(this, t, e), this.smoothProperty && (this.context[this.smoothProperty] = l.SCALE_MODES.DEFAULT === l.SCALE_MODES.LINEAR) }, n.prototype._mapBlendModes = function() { this.blendModes || (this.blendModes = {}, s.canUseNewCanvasBlendModes() ? (this.blendModes[l.BLEND_MODES.NORMAL] = "source-over", this.blendModes[l.BLEND_MODES.ADD] = "lighter", this.blendModes[l.BLEND_MODES.MULTIPLY] = "multiply", this.blendModes[l.BLEND_MODES.SCREEN] = "screen", this.blendModes[l.BLEND_MODES.OVERLAY] = "overlay", this.blendModes[l.BLEND_MODES.DARKEN] = "darken", this.blendModes[l.BLEND_MODES.LIGHTEN] = "lighten", this.blendModes[l.BLEND_MODES.COLOR_DODGE] = "color-dodge", this.blendModes[l.BLEND_MODES.COLOR_BURN] = "color-burn", this.blendModes[l.BLEND_MODES.HARD_LIGHT] = "hard-light", this.blendModes[l.BLEND_MODES.SOFT_LIGHT] = "soft-light", this.blendModes[l.BLEND_MODES.DIFFERENCE] = "difference", this.blendModes[l.BLEND_MODES.EXCLUSION] = "exclusion", this.blendModes[l.BLEND_MODES.HUE] = "hue", this.blendModes[l.BLEND_MODES.SATURATION] = "saturate", this.blendModes[l.BLEND_MODES.COLOR] = "color", this.blendModes[l.BLEND_MODES.LUMINOSITY] = "luminosity") : (this.blendModes[l.BLEND_MODES.NORMAL] = "source-over", this.blendModes[l.BLEND_MODES.ADD] = "lighter", this.blendModes[l.BLEND_MODES.MULTIPLY] = "source-over", this.blendModes[l.BLEND_MODES.SCREEN] = "source-over", this.blendModes[l.BLEND_MODES.OVERLAY] = "source-over", this.blendModes[l.BLEND_MODES.DARKEN] = "source-over", this.blendModes[l.BLEND_MODES.LIGHTEN] = "source-over", this.blendModes[l.BLEND_MODES.COLOR_DODGE] = "source-over", this.blendModes[l.BLEND_MODES.COLOR_BURN] = "source-over", this.blendModes[l.BLEND_MODES.HARD_LIGHT] = "source-over", this.blendModes[l.BLEND_MODES.SOFT_LIGHT] = "source-over", this.blendModes[l.BLEND_MODES.DIFFERENCE] = "source-over", this.blendModes[l.BLEND_MODES.EXCLUSION] = "source-over", this.blendModes[l.BLEND_MODES.HUE] = "source-over", this.blendModes[l.BLEND_MODES.SATURATION] = "source-over", this.blendModes[l.BLEND_MODES.COLOR] = "source-over", this.blendModes[l.BLEND_MODES.LUMINOSITY] = "source-over")) } }, { "../../const": 16, "../../math": 26, "../../utils": 70, "../SystemRenderer": 36, "./utils/CanvasMaskManager": 40 }],
			38: [function(t, e, r) {
				function n(t, e) { this.canvas = document.createElement("canvas"), this.context = this.canvas.getContext("2d"), this.canvas.width = t, this.canvas.height = e } n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { width: { get: function() { return this.canvas.width }, set: function(t) { this.canvas.width = t } }, height: { get: function() { return this.canvas.height }, set: function(t) { this.canvas.height = t } } }), n.prototype.clear = function() { this.context.setTransform(1, 0, 0, 1, 0, 0), this.context.clearRect(0, 0, this.canvas.width, this.canvas.height) }, n.prototype.resize = function(t, e) { this.canvas.width = t, this.canvas.height = e }, n.prototype.destroy = function() { this.context = null, this.canvas = null } }, {}],
			39: [function(t, e, r) { var n = t("../../../const"),
					i = {};
				e.exports = i, i.renderGraphics = function(t, e) { var r = t.worldAlpha;
					t.dirty && (this.updateGraphicsTint(t), t.dirty = !1); for(var i = 0; i < t.graphicsData.length; i++) { var o = t.graphicsData[i],
							s = o.shape,
							a = o._fillTint,
							l = o._lineTint; if(e.lineWidth = o.lineWidth, o.type === n.SHAPES.POLY) { e.beginPath(); var u = s.points;
							e.moveTo(u[0], u[1]); for(var h = 1; h < u.length / 2; h++) e.lineTo(u[2 * h], u[2 * h + 1]);
							s.closed && e.lineTo(u[0], u[1]), u[0] === u[u.length - 2] && u[1] === u[u.length - 1] && e.closePath(), o.fill && (e.globalAlpha = o.fillAlpha * r, e.fillStyle = "#" + ("00000" + (0 | a).toString(16)).substr(-6), e.fill()), o.lineWidth && (e.globalAlpha = o.lineAlpha * r, e.strokeStyle = "#" + ("00000" + (0 | l).toString(16)).substr(-6), e.stroke()) } else if(o.type === n.SHAPES.RECT)(o.fillColor || 0 === o.fillColor) && (e.globalAlpha = o.fillAlpha * r, e.fillStyle = "#" + ("00000" + (0 | a).toString(16)).substr(-6), e.fillRect(s.x, s.y, s.width, s.height)), o.lineWidth && (e.globalAlpha = o.lineAlpha * r, e.strokeStyle = "#" + ("00000" + (0 | l).toString(16)).substr(-6), e.strokeRect(s.x, s.y, s.width, s.height));
						else if(o.type === n.SHAPES.CIRC) e.beginPath(), e.arc(s.x, s.y, s.radius, 0, 2 * Math.PI), e.closePath(), o.fill && (e.globalAlpha = o.fillAlpha * r, e.fillStyle = "#" + ("00000" + (0 | a).toString(16)).substr(-6), e.fill()), o.lineWidth && (e.globalAlpha = o.lineAlpha * r, e.strokeStyle = "#" + ("00000" + (0 | l).toString(16)).substr(-6), e.stroke());
						else if(o.type === n.SHAPES.ELIP) { var c = 2 * s.width,
								p = 2 * s.height,
								d = s.x - c / 2,
								f = s.y - p / 2;
							e.beginPath(); var v = .5522848,
								g = c / 2 * v,
								m = p / 2 * v,
								y = d + c,
								T = f + p,
								x = d + c / 2,
								b = f + p / 2;
							e.moveTo(d, b), e.bezierCurveTo(d, b - m, x - g, f, x, f), e.bezierCurveTo(x + g, f, y, b - m, y, b), e.bezierCurveTo(y, b + m, x + g, T, x, T), e.bezierCurveTo(x - g, T, d, b + m, d, b), e.closePath(), o.fill && (e.globalAlpha = o.fillAlpha * r, e.fillStyle = "#" + ("00000" + (0 | a).toString(16)).substr(-6), e.fill()), o.lineWidth && (e.globalAlpha = o.lineAlpha * r, e.strokeStyle = "#" + ("00000" + (0 | l).toString(16)).substr(-6), e.stroke()) } else if(o.type === n.SHAPES.RREC) { var S = s.x,
								E = s.y,
								A = s.width,
								_ = s.height,
								M = s.radius,
								w = Math.min(A, _) / 2 | 0;
							M = M > w ? w : M, e.beginPath(), e.moveTo(S, E + M), e.lineTo(S, E + _ - M), e.quadraticCurveTo(S, E + _, S + M, E + _), e.lineTo(S + A - M, E + _), e.quadraticCurveTo(S + A, E + _, S + A, E + _ - M), e.lineTo(S + A, E + M), e.quadraticCurveTo(S + A, E, S + A - M, E), e.lineTo(S + M, E), e.quadraticCurveTo(S, E, S, E + M), e.closePath(), (o.fillColor || 0 === o.fillColor) && (e.globalAlpha = o.fillAlpha * r, e.fillStyle = "#" + ("00000" + (0 | a).toString(16)).substr(-6), e.fill()), o.lineWidth && (e.globalAlpha = o.lineAlpha * r, e.strokeStyle = "#" + ("00000" + (0 | l).toString(16)).substr(-6), e.stroke()) } } }, i.renderGraphicsMask = function(t, e) { var r = t.graphicsData.length; if(0 !== r) { e.beginPath(); for(var i = 0; r > i; i++) { var o = t.graphicsData[i],
								s = o.shape; if(o.type === n.SHAPES.POLY) { var a = s.points;
								e.moveTo(a[0], a[1]); for(var l = 1; l < a.length / 2; l++) e.lineTo(a[2 * l], a[2 * l + 1]);
								a[0] === a[a.length - 2] && a[1] === a[a.length - 1] && e.closePath() } else if(o.type === n.SHAPES.RECT) e.rect(s.x, s.y, s.width, s.height), e.closePath();
							else if(o.type === n.SHAPES.CIRC) e.arc(s.x, s.y, s.radius, 0, 2 * Math.PI), e.closePath();
							else if(o.type === n.SHAPES.ELIP) { var u = 2 * s.width,
									h = 2 * s.height,
									c = s.x - u / 2,
									p = s.y - h / 2,
									d = .5522848,
									f = u / 2 * d,
									v = h / 2 * d,
									g = c + u,
									m = p + h,
									y = c + u / 2,
									T = p + h / 2;
								e.moveTo(c, T), e.bezierCurveTo(c, T - v, y - f, p, y, p), e.bezierCurveTo(y + f, p, g, T - v, g, T), e.bezierCurveTo(g, T + v, y + f, m, y, m), e.bezierCurveTo(y - f, m, c, T + v, c, T), e.closePath() } else if(o.type === n.SHAPES.RREC) { var x = s.x,
									b = s.y,
									S = s.width,
									E = s.height,
									A = s.radius,
									_ = Math.min(S, E) / 2 | 0;
								A = A > _ ? _ : A, e.moveTo(x, b + A), e.lineTo(x, b + E - A), e.quadraticCurveTo(x, b + E, x + A, b + E), e.lineTo(x + S - A, b + E), e.quadraticCurveTo(x + S, b + E, x + S, b + E - A), e.lineTo(x + S, b + A), e.quadraticCurveTo(x + S, b, x + S - A, b), e.lineTo(x + A, b), e.quadraticCurveTo(x, b, x, b + A), e.closePath() } } } }, i.updateGraphicsTint = function(t) { if(16777215 !== t.tint || t._prevTint !== t.tint) { t._prevTint = t.tint; for(var e = (t.tint >> 16 & 255) / 255, r = (t.tint >> 8 & 255) / 255, n = (255 & t.tint) / 255, i = 0; i < t.graphicsData.length; i++) { var o = t.graphicsData[i],
								s = 0 | o.fillColor,
								a = 0 | o.lineColor;
							o._fillTint = ((s >> 16 & 255) / 255 * e * 255 << 16) + ((s >> 8 & 255) / 255 * r * 255 << 8) + (255 & s) / 255 * n * 255, o._lineTint = ((a >> 16 & 255) / 255 * e * 255 << 16) + ((a >> 8 & 255) / 255 * r * 255 << 8) + (255 & a) / 255 * n * 255 } } } }, { "../../../const": 16 }],
			40: [function(t, e, r) {
				function n() {} var i = t("./CanvasGraphics");
				n.prototype.constructor = n, e.exports = n, n.prototype.pushMask = function(t, e) { e.context.save(); var r = t.alpha,
						n = t.worldTransform,
						o = e.resolution;
					e.context.setTransform(n.a * o, n.b * o, n.c * o, n.d * o, n.tx * o, n.ty * o), t.texture || (i.renderGraphicsMask(t, e.context), e.context.clip()), t.worldAlpha = r }, n.prototype.popMask = function(t) { t.context.restore() }, n.prototype.destroy = function() {} }, { "./CanvasGraphics": 39 }],
			41: [function(t, e, r) { var n = t("../../../utils"),
					i = {};
				e.exports = i, i.getTintedTexture = function(t, e) { var r = t.texture;
					e = i.roundColor(e); var n = "#" + ("00000" + (0 | e).toString(16)).substr(-6); if(r.tintCache = r.tintCache || {}, r.tintCache[n]) return r.tintCache[n]; var o = i.canvas || document.createElement("canvas"); if(i.tintMethod(r, e, o), i.convertTintToImage) { var s = new Image;
						s.src = o.toDataURL(), r.tintCache[n] = s } else r.tintCache[n] = o, i.canvas = null; return o }, i.tintWithMultiply = function(t, e, r) { var n = r.getContext("2d"),
						i = t.baseTexture.resolution,
						o = t.crop.clone();
					o.x *= i, o.y *= i, o.width *= i, o.height *= i, r.width = o.width, r.height = o.height, n.fillStyle = "#" + ("00000" + (0 | e).toString(16)).substr(-6), n.fillRect(0, 0, o.width, o.height), n.globalCompositeOperation = "multiply", n.drawImage(t.baseTexture.source, o.x, o.y, o.width, o.height, 0, 0, o.width, o.height), n.globalCompositeOperation = "destination-atop", n.drawImage(t.baseTexture.source, o.x, o.y, o.width, o.height, 0, 0, o.width, o.height) }, i.tintWithOverlay = function(t, e, r) { var n = r.getContext("2d"),
						i = t.baseTexture.resolution,
						o = t.crop.clone();
					o.x *= i, o.y *= i, o.width *= i, o.height *= i, r.width = o.width, r.height = o.height, n.globalCompositeOperation = "copy", n.fillStyle = "#" + ("00000" + (0 | e).toString(16)).substr(-6), n.fillRect(0, 0, o.width, o.height), n.globalCompositeOperation = "destination-atop", n.drawImage(t.baseTexture.source, o.x, o.y, o.width, o.height, 0, 0, o.width, o.height) }, i.tintWithPerPixel = function(t, e, r) { var i = r.getContext("2d"),
						o = t.baseTexture.resolution,
						s = t.crop.clone();
					s.x *= o, s.y *= o, s.width *= o, s.height *= o, r.width = s.width, r.height = s.height, i.globalCompositeOperation = "copy", i.drawImage(t.baseTexture.source, s.x, s.y, s.width, s.height, 0, 0, s.width, s.height); for(var a = n.hex2rgb(e), l = a[0], u = a[1], h = a[2], c = i.getImageData(0, 0, s.width, s.height), p = c.data, d = 0; d < p.length; d += 4) p[d + 0] *= l, p[d + 1] *= u, p[d + 2] *= h;
					i.putImageData(c, 0, 0) }, i.roundColor = function(t) { var e = i.cacheStepsPerColorChannel,
						r = n.hex2rgb(t); return r[0] = Math.min(255, r[0] / e * e), r[1] = Math.min(255, r[1] / e * e), r[2] = Math.min(255, r[2] / e * e), n.rgb2hex(r) }, i.cacheStepsPerColorChannel = 8, i.convertTintToImage = !1, i.canUseMultiply = n.canUseNewCanvasBlendModes(), i.tintMethod = i.canUseMultiply ? i.tintWithMultiply : i.tintWithPerPixel }, { "../../../utils": 70 }],
			42: [function(t, e, r) {
				function n(t, e, r) { r = r || {}, i.call(this, "WebGL", t, e, r), this.type = f.RENDERER_TYPE.WEBGL, this.handleContextLost = this.handleContextLost.bind(this), this.handleContextRestored = this.handleContextRestored.bind(this), this.view.addEventListener("webglcontextlost", this.handleContextLost, !1), this.view.addEventListener("webglcontextrestored", this.handleContextRestored, !1), this._useFXAA = !!r.forceFXAA && r.antialias, this._FXAAFilter = null, this._contextOptions = { alpha: this.transparent, antialias: r.antialias, premultipliedAlpha: this.transparent && "notMultiplied" !== this.transparent, stencil: !0, preserveDrawingBuffer: r.preserveDrawingBuffer }, this.drawCount = 0, this.shaderManager = new o(this), this.maskManager = new s(this), this.stencilManager = new a(this), this.filterManager = new l(this), this.blendModeManager = new u(this), this.currentRenderTarget = null, this.currentRenderer = new c(this), this.initPlugins(), this._createContext(), this._initContext(), this._mapGlModes(), this._managedTextures = [], this._renderTargetStack = [] } var i = t("../SystemRenderer"),
					o = t("./managers/ShaderManager"),
					s = t("./managers/MaskManager"),
					a = t("./managers/StencilManager"),
					l = t("./managers/FilterManager"),
					u = t("./managers/BlendModeManager"),
					h = t("./utils/RenderTarget"),
					c = t("./utils/ObjectRenderer"),
					p = t("./filters/FXAAFilter"),
					d = t("../../utils"),
					f = t("../../const");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, d.pluginTarget.mixin(n), n.glContextId = 0, n.prototype._createContext = function() { var t = this.view.getContext("webgl", this._contextOptions) || this.view.getContext("experimental-webgl", this._contextOptions); if(this.gl = t, !t) throw new Error("This browser does not support webGL. Try using the canvas renderer");
					this.glContextId = n.glContextId++, t.id = this.glContextId, t.renderer = this }, n.prototype._initContext = function() { var t = this.gl;
					t.disable(t.DEPTH_TEST), t.disable(t.CULL_FACE), t.enable(t.BLEND), this.renderTarget = new h(t, this.width, this.height, null, this.resolution, !0), this.setRenderTarget(this.renderTarget), this.emit("context", t), this.resize(this.width, this.height), this._useFXAA || (this._useFXAA = this._contextOptions.antialias && !t.getContextAttributes().antialias), this._useFXAA && (window.console.warn("FXAA antialiasing being used instead of native antialiasing"), this._FXAAFilter = [new p]) }, n.prototype.render = function(t) { if(this.emit("prerender"), !this.gl.isContextLost()) { this.drawCount = 0, this._lastObjectRendered = t, this._useFXAA && (this._FXAAFilter[0].uniforms.resolution.value.x = this.width, this._FXAAFilter[0].uniforms.resolution.value.y = this.height, t.filterArea = this.renderTarget.size, t.filters = this._FXAAFilter); var e = t.parent;
						t.parent = this._tempDisplayObjectParent, t.updateTransform(), t.parent = e; var r = this.gl;
						this.setRenderTarget(this.renderTarget), this.clearBeforeRender && (this.transparent ? r.clearColor(0, 0, 0, 0) : r.clearColor(this._backgroundColorRgb[0], this._backgroundColorRgb[1], this._backgroundColorRgb[2], 1), r.clear(r.COLOR_BUFFER_BIT)), this.renderDisplayObject(t, this.renderTarget), this.emit("postrender") } }, n.prototype.renderDisplayObject = function(t, e, r) { this.setRenderTarget(e), r && e.clear(), this.filterManager.setFilterStack(e.filterStack), t.renderWebGL(this), this.currentRenderer.flush() }, n.prototype.setObjectRenderer = function(t) { this.currentRenderer !== t && (this.currentRenderer.stop(), this.currentRenderer = t, this.currentRenderer.start()) }, n.prototype.setRenderTarget = function(t) { this.currentRenderTarget !== t && (this.currentRenderTarget = t, this.currentRenderTarget.activate(), this.stencilManager.setMaskStack(t.stencilMaskStack)) }, n.prototype.resize = function(t, e) { i.prototype.resize.call(this, t, e), this.filterManager.resize(t, e), this.renderTarget.resize(t, e), this.currentRenderTarget === this.renderTarget && (this.renderTarget.activate(), this.gl.viewport(0, 0, this.width, this.height)) }, n.prototype.updateTexture = function(t) { if(t = t.baseTexture || t, t.hasLoaded) { var e = this.gl; return t._glTextures[e.id] || (t._glTextures[e.id] = e.createTexture(), t.on("update", this.updateTexture, this), t.on("dispose", this.destroyTexture, this), this._managedTextures.push(t)), e.bindTexture(e.TEXTURE_2D, t._glTextures[e.id]), e.pixelStorei(e.UNPACK_PREMULTIPLY_ALPHA_WEBGL, t.premultipliedAlpha), e.texImage2D(e.TEXTURE_2D, 0, e.RGBA, e.RGBA, e.UNSIGNED_BYTE, t.source), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_MAG_FILTER, t.scaleMode === f.SCALE_MODES.LINEAR ? e.LINEAR : e.NEAREST), t.mipmap && t.isPowerOfTwo ? (e.texParameteri(e.TEXTURE_2D, e.TEXTURE_MIN_FILTER, t.scaleMode === f.SCALE_MODES.LINEAR ? e.LINEAR_MIPMAP_LINEAR : e.NEAREST_MIPMAP_NEAREST), e.generateMipmap(e.TEXTURE_2D)) : e.texParameteri(e.TEXTURE_2D, e.TEXTURE_MIN_FILTER, t.scaleMode === f.SCALE_MODES.LINEAR ? e.LINEAR : e.NEAREST), t.isPowerOfTwo ? (e.texParameteri(e.TEXTURE_2D, e.TEXTURE_WRAP_S, e.REPEAT), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_WRAP_T, e.REPEAT)) : (e.texParameteri(e.TEXTURE_2D, e.TEXTURE_WRAP_S, e.CLAMP_TO_EDGE), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_WRAP_T, e.CLAMP_TO_EDGE)), t._glTextures[e.id] } }, n.prototype.destroyTexture = function(t, e) { if(t = t.baseTexture || t, t.hasLoaded && t._glTextures[this.gl.id] && (this.gl.deleteTexture(t._glTextures[this.gl.id]), delete t._glTextures[this.gl.id], !e)) { var r = this._managedTextures.indexOf(t); - 1 !== r && d.removeItems(this._managedTextures, r, 1) } }, n.prototype.handleContextLost = function(t) { t.preventDefault() }, n.prototype.handleContextRestored = function() { this._initContext(); for(var t = 0; t < this._managedTextures.length; ++t) { var e = this._managedTextures[t];
						e._glTextures[this.gl.id] && delete e._glTextures[this.gl.id] } }, n.prototype.destroy = function(t) { this.destroyPlugins(), this.view.removeEventListener("webglcontextlost", this.handleContextLost), this.view.removeEventListener("webglcontextrestored", this.handleContextRestored); for(var e = 0; e < this._managedTextures.length; ++e) { var r = this._managedTextures[e];
						this.destroyTexture(r, !0), r.off("update", this.updateTexture, this), r.off("dispose", this.destroyTexture, this) } i.prototype.destroy.call(this, t), this.uid = 0, this.shaderManager.destroy(), this.maskManager.destroy(), this.stencilManager.destroy(), this.filterManager.destroy(), this.blendModeManager.destroy(), this.shaderManager = null, this.maskManager = null, this.filterManager = null, this.blendModeManager = null, this.currentRenderer = null, this.handleContextLost = null, this.handleContextRestored = null, this._contextOptions = null, this._managedTextures = null, this.drawCount = 0, this.gl.useProgram(null), this.gl = null }, n.prototype._mapGlModes = function() { var t = this.gl;
					this.blendModes || (this.blendModes = {}, this.blendModes[f.BLEND_MODES.NORMAL] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.ADD] = [t.SRC_ALPHA, t.DST_ALPHA], this.blendModes[f.BLEND_MODES.MULTIPLY] = [t.DST_COLOR, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.SCREEN] = [t.SRC_ALPHA, t.ONE], this.blendModes[f.BLEND_MODES.OVERLAY] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.DARKEN] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.LIGHTEN] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.COLOR_DODGE] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.COLOR_BURN] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.HARD_LIGHT] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.SOFT_LIGHT] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.DIFFERENCE] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.EXCLUSION] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.HUE] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.SATURATION] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.COLOR] = [t.ONE, t.ONE_MINUS_SRC_ALPHA], this.blendModes[f.BLEND_MODES.LUMINOSITY] = [t.ONE, t.ONE_MINUS_SRC_ALPHA]), this.drawModes || (this.drawModes = {}, this.drawModes[f.DRAW_MODES.POINTS] = t.POINTS, this.drawModes[f.DRAW_MODES.LINES] = t.LINES, this.drawModes[f.DRAW_MODES.LINE_LOOP] = t.LINE_LOOP, this.drawModes[f.DRAW_MODES.LINE_STRIP] = t.LINE_STRIP, this.drawModes[f.DRAW_MODES.TRIANGLES] = t.TRIANGLES, this.drawModes[f.DRAW_MODES.TRIANGLE_STRIP] = t.TRIANGLE_STRIP, this.drawModes[f.DRAW_MODES.TRIANGLE_FAN] = t.TRIANGLE_FAN) } }, { "../../const": 16, "../../utils": 70, "../SystemRenderer": 36, "./filters/FXAAFilter": 44, "./managers/BlendModeManager": 46, "./managers/FilterManager": 47, "./managers/MaskManager": 48, "./managers/ShaderManager": 49, "./managers/StencilManager": 50, "./utils/ObjectRenderer": 56, "./utils/RenderTarget": 58 }],
			43: [function(t, e, r) {
				function n(t, e, r) { this.shaders = [], this.padding = 0, this.uniforms = r || {}, this.vertexSrc = t || i.defaultVertexSrc, this.fragmentSrc = e || i.defaultFragmentSrc } var i = t("../shaders/TextureShader");
				n.prototype.constructor = n, e.exports = n, n.prototype.getShader = function(t) { var e = t.gl,
						r = this.shaders[e.id]; return r || (r = new i(t.shaderManager, this.vertexSrc, this.fragmentSrc, this.uniforms, this.attributes), this.shaders[e.id] = r), r }, n.prototype.applyFilter = function(t, e, r, n) { var i = this.getShader(t);
					t.filterManager.applyFilter(i, e, r, n) }, n.prototype.syncUniform = function(t) { for(var e = 0, r = this.shaders.length; r > e; ++e) this.shaders[e].syncUniform(t) } }, { "../shaders/TextureShader": 55 }],
			44: [function(t, e, r) {
				function n() {
					i.call(this, "\nprecision mediump float;\n\nattribute vec2 aVertexPosition;\nattribute vec2 aTextureCoord;\nattribute vec4 aColor;\n\nuniform mat3 projectionMatrix;\nuniform vec2 resolution;\n\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\n\nvarying vec2 vResolution;\n\n//texcoords computed in vertex step\n//to avoid dependent texture reads\nvarying vec2 v_rgbNW;\nvarying vec2 v_rgbNE;\nvarying vec2 v_rgbSW;\nvarying vec2 v_rgbSE;\nvarying vec2 v_rgbM;\n\n\nvoid texcoords(vec2 fragCoord, vec2 resolution,\n            out vec2 v_rgbNW, out vec2 v_rgbNE,\n            out vec2 v_rgbSW, out vec2 v_rgbSE,\n            out vec2 v_rgbM) {\n    vec2 inverseVP = 1.0 / resolution.xy;\n    v_rgbNW = (fragCoord + vec2(-1.0, -1.0)) * inverseVP;\n    v_rgbNE = (fragCoord + vec2(1.0, -1.0)) * inverseVP;\n    v_rgbSW = (fragCoord + vec2(-1.0, 1.0)) * inverseVP;\n    v_rgbSE = (fragCoord + vec2(1.0, 1.0)) * inverseVP;\n    v_rgbM = vec2(fragCoord * inverseVP);\n}\n\nvoid main(void){\n   gl_Position = vec4((projectionMatrix * vec3(aVertexPosition, 1.0)).xy, 0.0, 1.0);\n   vTextureCoord = aTextureCoord;\n   vColor = vec4(aColor.rgb * aColor.a, aColor.a);\n   vResolution = resolution;\n\n   //compute the texture coords and send them to varyings\n   texcoords(aTextureCoord * resolution, resolution, v_rgbNW, v_rgbNE, v_rgbSW, v_rgbSE, v_rgbM);\n}\n", 'precision lowp float;\n\n\n/**\nBasic FXAA implementation based on the code on geeks3d.com with the\nmodification that the texture2DLod stuff was removed since it\'s\nunsupported by WebGL.\n\n--\n\nFrom:\nhttps://github.com/mitsuhiko/webgl-meincraft\n\nCopyright (c) 2011 by Armin Ronacher.\n\nSome rights reserved.\n\nRedistribution and use in source and binary forms, with or without\nmodification, are permitted provided that the following conditions are\nmet:\n\n    * Redistributions of source code must retain the above copyright\n      notice, this list of conditions and the following disclaimer.\n\n    * Redistributions in binary form must reproduce the above\n      copyright notice, this list of conditions and the following\n      disclaimer in the documentation and/or other materials provided\n      with the distribution.\n\n    * The names of the contributors may not be used to endorse or\n      promote products derived from this software without specific\n      prior written permission.\n\nTHIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS\n"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT\nLIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR\nA PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT\nOWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,\nSPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT\nLIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,\nDATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY\nTHEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT\n(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE\nOF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.\n*/\n\n#ifndef FXAA_REDUCE_MIN\n    #define FXAA_REDUCE_MIN   (1.0/ 128.0)\n#endif\n#ifndef FXAA_REDUCE_MUL\n    #define FXAA_REDUCE_MUL   (1.0 / 8.0)\n#endif\n#ifndef FXAA_SPAN_MAX\n    #define FXAA_SPAN_MAX     8.0\n#endif\n\n//optimized version for mobile, where dependent\n//texture reads can be a bottleneck\nvec4 fxaa(sampler2D tex, vec2 fragCoord, vec2 resolution,\n            vec2 v_rgbNW, vec2 v_rgbNE,\n            vec2 v_rgbSW, vec2 v_rgbSE,\n            vec2 v_rgbM) {\n    vec4 color;\n    mediump vec2 inverseVP = vec2(1.0 / resolution.x, 1.0 / resolution.y);\n    vec3 rgbNW = texture2D(tex, v_rgbNW).xyz;\n    vec3 rgbNE = texture2D(tex, v_rgbNE).xyz;\n    vec3 rgbSW = texture2D(tex, v_rgbSW).xyz;\n    vec3 rgbSE = texture2D(tex, v_rgbSE).xyz;\n    vec4 texColor = texture2D(tex, v_rgbM);\n    vec3 rgbM  = texColor.xyz;\n    vec3 luma = vec3(0.299, 0.587, 0.114);\n    float lumaNW = dot(rgbNW, luma);\n    float lumaNE = dot(rgbNE, luma);\n    float lumaSW = dot(rgbSW, luma);\n    float lumaSE = dot(rgbSE, luma);\n    float lumaM  = dot(rgbM,  luma);\n    float lumaMin = min(lumaM, min(min(lumaNW, lumaNE), min(lumaSW, lumaSE)));\n    float lumaMax = max(lumaM, max(max(lumaNW, lumaNE), max(lumaSW, lumaSE)));\n\n    mediump vec2 dir;\n    dir.x = -((lumaNW + lumaNE) - (lumaSW + lumaSE));\n    dir.y =  ((lumaNW + lumaSW) - (lumaNE + lumaSE));\n\n    float dirReduce = max((lumaNW + lumaNE + lumaSW + lumaSE) *\n                          (0.25 * FXAA_REDUCE_MUL), FXAA_REDUCE_MIN);\n\n    float rcpDirMin = 1.0 / (min(abs(dir.x), abs(dir.y)) + dirReduce);\n    dir = min(vec2(FXAA_SPAN_MAX, FXAA_SPAN_MAX),\n              max(vec2(-FXAA_SPAN_MAX, -FXAA_SPAN_MAX),\n              dir * rcpDirMin)) * inverseVP;\n\n    vec3 rgbA = 0.5 * (\n        texture2D(tex, fragCoord * inverseVP + dir * (1.0 / 3.0 - 0.5)).xyz +\n        texture2D(tex, fragCoord * inverseVP + dir * (2.0 / 3.0 - 0.5)).xyz);\n    vec3 rgbB = rgbA * 0.5 + 0.25 * (\n        texture2D(tex, fragCoord * inverseVP + dir * -0.5).xyz +\n        texture2D(tex, fragCoord * inverseVP + dir * 0.5).xyz);\n\n    float lumaB = dot(rgbB, luma);\n    if ((lumaB < lumaMin) || (lumaB > lumaMax))\n        color = vec4(rgbA, texColor.a);\n    else\n        color = vec4(rgbB, texColor.a);\n    return color;\n}\n\n\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\nvarying vec2 vResolution;\n\n//texcoords computed in vertex step\n//to avoid dependent texture reads\nvarying vec2 v_rgbNW;\nvarying vec2 v_rgbNE;\nvarying vec2 v_rgbSW;\nvarying vec2 v_rgbSE;\nvarying vec2 v_rgbM;\n\nuniform sampler2D uSampler;\n\n\nvoid main(void){\n\n    gl_FragColor = fxaa(uSampler, vTextureCoord * vResolution, vResolution, v_rgbNW, v_rgbNE, v_rgbSW, v_rgbSE, v_rgbM);\n\n}\n', {
						resolution: { type: "v2", value: { x: 1, y: 1 } }
					})
				}
				var i = t("./AbstractFilter");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r) { var n = t.filterManager,
						i = this.getShader(t);
					n.applyFilter(i, e, r) }
			}, { "./AbstractFilter": 43 }],
			45: [function(t, e, r) {
				function n(t) { var e = new o.Matrix;
					i.call(this, "attribute vec2 aVertexPosition;\nattribute vec2 aTextureCoord;\nattribute vec4 aColor;\n\nuniform mat3 projectionMatrix;\nuniform mat3 otherMatrix;\n\nvarying vec2 vMaskCoord;\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\n\nvoid main(void)\n{\n    gl_Position = vec4((projectionMatrix * vec3(aVertexPosition, 1.0)).xy, 0.0, 1.0);\n    vTextureCoord = aTextureCoord;\n    vMaskCoord = ( otherMatrix * vec3( aTextureCoord, 1.0)  ).xy;\n    vColor = vec4(aColor.rgb * aColor.a, aColor.a);\n}\n", "precision lowp float;\n\nvarying vec2 vMaskCoord;\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\n\nuniform sampler2D uSampler;\nuniform float alpha;\nuniform sampler2D mask;\n\nvoid main(void)\n{\n    // check clip! this will stop the mask bleeding out from the edges\n    vec2 text = abs( vMaskCoord - 0.5 );\n    text = step(0.5, text);\n    float clip = 1.0 - max(text.y, text.x);\n    vec4 original = texture2D(uSampler, vTextureCoord);\n    vec4 masky = texture2D(mask, vMaskCoord);\n    original *= (masky.r * masky.a * alpha * clip);\n    gl_FragColor = original;\n}\n", { mask: { type: "sampler2D", value: t._texture }, alpha: { type: "f", value: 1 }, otherMatrix: { type: "mat3", value: e.toArray(!0) } }), this.maskSprite = t, this.maskMatrix = e } var i = t("./AbstractFilter"),
					o = t("../../../math");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r) { var n = t.filterManager;
					this.uniforms.mask.value = this.maskSprite._texture, n.calculateMappedMatrix(e.frame, this.maskSprite, this.maskMatrix), this.uniforms.otherMatrix.value = this.maskMatrix.toArray(!0), this.uniforms.alpha.value = this.maskSprite.worldAlpha; var i = this.getShader(t);
					n.applyFilter(i, e, r) }, Object.defineProperties(n.prototype, { map: { get: function() { return this.uniforms.mask.value }, set: function(t) { this.uniforms.mask.value = t } }, offset: { get: function() { return this.uniforms.offset.value }, set: function(t) { this.uniforms.offset.value = t } } }) }, { "../../../math": 26, "./AbstractFilter": 43 }],
			46: [function(t, e, r) {
				function n(t) { i.call(this, t), this.currentBlendMode = 99999 } var i = t("./WebGLManager");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.setBlendMode = function(t) { if(this.currentBlendMode === t) return !1;
					this.currentBlendMode = t; var e = this.renderer.blendModes[this.currentBlendMode]; return this.renderer.gl.blendFunc(e[0], e[1]), !0 } }, { "./WebGLManager": 51 }],
			47: [function(t, e, r) {
				function n(t) { i.call(this, t), this.filterStack = [], this.filterStack.push({ renderTarget: t.currentRenderTarget, filter: [], bounds: null }), this.texturePool = [], this.textureSize = new l.Rectangle(0, 0, t.width, t.height), this.currentFrame = null } var i = t("./WebGLManager"),
					o = t("../utils/RenderTarget"),
					s = t("../../../const"),
					a = t("../utils/Quad"),
					l = t("../../../math");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.onContextChange = function() { this.texturePool.length = 0; var t = this.renderer.gl;
					this.quad = new a(t) }, n.prototype.setFilterStack = function(t) { this.filterStack = t }, n.prototype.pushFilter = function(t, e) { var r = t.filterArea ? t.filterArea.clone() : t.getBounds();
					r.x = 0 | r.x, r.y = 0 | r.y, r.width = 0 | r.width, r.height = 0 | r.height; var n = 0 | e[0].padding; if(r.x -= n, r.y -= n, r.width += 2 * n, r.height += 2 * n, this.renderer.currentRenderTarget.transform) { var i = this.renderer.currentRenderTarget.transform;
						r.x += i.tx, r.y += i.ty, this.capFilterArea(r), r.x -= i.tx, r.y -= i.ty } else this.capFilterArea(r); if(r.width > 0 && r.height > 0) { this.currentFrame = r; var o = this.getRenderTarget();
						this.renderer.setRenderTarget(o), o.clear(), this.filterStack.push({ renderTarget: o, filter: e }) } else this.filterStack.push({ renderTarget: null, filter: e }) }, n.prototype.popFilter = function() { var t = this.filterStack.pop(),
						e = this.filterStack[this.filterStack.length - 1],
						r = t.renderTarget; if(t.renderTarget) { var n = e.renderTarget,
							i = this.renderer.gl;
						this.currentFrame = r.frame, this.quad.map(this.textureSize, r.frame), i.bindBuffer(i.ARRAY_BUFFER, this.quad.vertexBuffer), i.bindBuffer(i.ELEMENT_ARRAY_BUFFER, this.quad.indexBuffer); var o = t.filter; if(i.vertexAttribPointer(this.renderer.shaderManager.defaultShader.attributes.aVertexPosition, 2, i.FLOAT, !1, 0, 0), i.vertexAttribPointer(this.renderer.shaderManager.defaultShader.attributes.aTextureCoord, 2, i.FLOAT, !1, 0, 32), i.vertexAttribPointer(this.renderer.shaderManager.defaultShader.attributes.aColor, 4, i.FLOAT, !1, 0, 64), this.renderer.blendModeManager.setBlendMode(s.BLEND_MODES.NORMAL), 1 === o.length) o[0].uniforms.dimensions && (o[0].uniforms.dimensions.value[0] = this.renderer.width, o[0].uniforms.dimensions.value[1] = this.renderer.height, o[0].uniforms.dimensions.value[2] = this.quad.vertices[0], o[0].uniforms.dimensions.value[3] = this.quad.vertices[5]), o[0].applyFilter(this.renderer, r, n), this.returnRenderTarget(r);
						else { for(var a = r, l = this.getRenderTarget(!0), u = 0; u < o.length - 1; u++) { var h = o[u];
								h.uniforms.dimensions && (h.uniforms.dimensions.value[0] = this.renderer.width, h.uniforms.dimensions.value[1] = this.renderer.height, h.uniforms.dimensions.value[2] = this.quad.vertices[0], h.uniforms.dimensions.value[3] = this.quad.vertices[5]), h.applyFilter(this.renderer, a, l); var c = a;
								a = l, l = c } o[o.length - 1].applyFilter(this.renderer, a, n), this.returnRenderTarget(a), this.returnRenderTarget(l) } return t.filter } }, n.prototype.getRenderTarget = function(t) { var e = this.texturePool.pop() || new o(this.renderer.gl, this.textureSize.width, this.textureSize.height, s.SCALE_MODES.LINEAR, this.renderer.resolution * s.FILTER_RESOLUTION); return e.frame = this.currentFrame, t && e.clear(!0), e }, n.prototype.returnRenderTarget = function(t) { this.texturePool.push(t) }, n.prototype.applyFilter = function(t, e, r, n) { var i = this.renderer.gl;
					this.renderer.setRenderTarget(r), n && r.clear(), this.renderer.shaderManager.setShader(t), t.uniforms.projectionMatrix.value = this.renderer.currentRenderTarget.projectionMatrix.toArray(!0), t.syncUniforms(), i.activeTexture(i.TEXTURE0), i.bindTexture(i.TEXTURE_2D, e.texture), i.drawElements(i.TRIANGLES, 6, i.UNSIGNED_SHORT, 0), this.renderer.drawCount++ }, n.prototype.calculateMappedMatrix = function(t, e, r) { var n = e.worldTransform.copy(l.Matrix.TEMP_MATRIX),
						i = e._texture.baseTexture,
						o = r.identity(),
						s = this.textureSize.height / this.textureSize.width;
					o.translate(t.x / this.textureSize.width, t.y / this.textureSize.height), o.scale(1, s); var a = this.textureSize.width / i.width,
						u = this.textureSize.height / i.height; return n.tx /= i.width * a, n.ty /= i.width * a, n.invert(), o.prepend(n), o.scale(1, 1 / s), o.scale(a, u), o.translate(e.anchor.x, e.anchor.y), o }, n.prototype.capFilterArea = function(t) { t.x < 0 && (t.width += t.x, t.x = 0), t.y < 0 && (t.height += t.y, t.y = 0), t.x + t.width > this.textureSize.width && (t.width = this.textureSize.width - t.x), t.y + t.height > this.textureSize.height && (t.height = this.textureSize.height - t.y) }, n.prototype.resize = function(t, e) { this.textureSize.width = t, this.textureSize.height = e; for(var r = 0; r < this.texturePool.length; r++) this.texturePool[r].resize(t, e) }, n.prototype.destroy = function() { this.quad.destroy(), i.prototype.destroy.call(this), this.filterStack = null, this.offsetY = 0; for(var t = 0; t < this.texturePool.length; t++) this.texturePool[t].destroy();
					this.texturePool = null } }, { "../../../const": 16, "../../../math": 26, "../utils/Quad": 57, "../utils/RenderTarget": 58, "./WebGLManager": 51 }],
			48: [function(t, e, r) {
				function n(t) { i.call(this, t), this.stencilStack = [], this.reverse = !0, this.count = 0, this.alphaMaskPool = [] } var i = t("./WebGLManager"),
					o = t("../filters/SpriteMaskFilter");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.pushMask = function(t, e) { e.texture ? this.pushSpriteMask(t, e) : this.pushStencilMask(t, e) }, n.prototype.popMask = function(t, e) { e.texture ? this.popSpriteMask(t, e) : this.popStencilMask(t, e) }, n.prototype.pushSpriteMask = function(t, e) { var r = this.alphaMaskPool.pop();
					r || (r = [new o(e)]), r[0].maskSprite = e, this.renderer.filterManager.pushFilter(t, r) }, n.prototype.popSpriteMask = function() { var t = this.renderer.filterManager.popFilter();
					this.alphaMaskPool.push(t) }, n.prototype.pushStencilMask = function(t, e) { this.renderer.stencilManager.pushMask(e) }, n.prototype.popStencilMask = function(t, e) { this.renderer.stencilManager.popMask(e) } }, { "../filters/SpriteMaskFilter": 45, "./WebGLManager": 51 }],
			49: [function(t, e, r) {
				function n(t) { i.call(this, t), this.maxAttibs = 10, this.attribState = [], this.tempAttribState = []; for(var e = 0; e < this.maxAttibs; e++) this.attribState[e] = !1;
					this.stack = [], this._currentId = -1, this.currentShader = null } var i = t("./WebGLManager"),
					o = t("../shaders/TextureShader"),
					s = t("../shaders/ComplexPrimitiveShader"),
					a = t("../shaders/PrimitiveShader"),
					l = t("../../../utils");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, l.pluginTarget.mixin(n), e.exports = n, n.prototype.onContextChange = function() { this.initPlugins(); var t = this.renderer.gl;
					this.maxAttibs = t.getParameter(t.MAX_VERTEX_ATTRIBS), this.attribState = []; for(var e = 0; e < this.maxAttibs; e++) this.attribState[e] = !1;
					this.defaultShader = new o(this), this.primitiveShader = new a(this), this.complexPrimitiveShader = new s(this) }, n.prototype.setAttribs = function(t) { var e; for(e = 0; e < this.tempAttribState.length; e++) this.tempAttribState[e] = !1; for(var r in t) this.tempAttribState[t[r]] = !0; var n = this.renderer.gl; for(e = 0; e < this.attribState.length; e++) this.attribState[e] !== this.tempAttribState[e] && (this.attribState[e] = this.tempAttribState[e], this.attribState[e] ? n.enableVertexAttribArray(e) : n.disableVertexAttribArray(e)) }, n.prototype.setShader = function(t) { return this._currentId === t.uid ? !1 : (this._currentId = t.uid, this.currentShader = t, this.renderer.gl.useProgram(t.program), this.setAttribs(t.attributes), !0) }, n.prototype.destroy = function() { this.primitiveShader.destroy(), this.complexPrimitiveShader.destroy(), i.prototype.destroy.call(this), this.destroyPlugins(), this.attribState = null, this.tempAttribState = null } }, { "../../../utils": 70, "../shaders/ComplexPrimitiveShader": 52, "../shaders/PrimitiveShader": 53, "../shaders/TextureShader": 55, "./WebGLManager": 51 }],
			50: [function(t, e, r) {
				function n(t) { i.call(this, t), this.stencilMaskStack = null } var i = t("./WebGLManager"),
					o = t("../../../utils");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.setMaskStack = function(t) { this.stencilMaskStack = t; var e = this.renderer.gl;
					0 === t.stencilStack.length ? e.disable(e.STENCIL_TEST) : e.enable(e.STENCIL_TEST) }, n.prototype.pushStencil = function(t, e) { this.renderer.currentRenderTarget.attachStencilBuffer(); var r = this.renderer.gl,
						n = this.stencilMaskStack;
					this.bindGraphics(t, e), 0 === n.stencilStack.length && (r.enable(r.STENCIL_TEST), r.clear(r.STENCIL_BUFFER_BIT), n.reverse = !0, n.count = 0), n.stencilStack.push(e); var i = n.count;
					r.colorMask(!1, !1, !1, !1), r.stencilFunc(r.ALWAYS, 0, 255), r.stencilOp(r.KEEP, r.KEEP, r.INVERT), 1 === e.mode ? (r.drawElements(r.TRIANGLE_FAN, e.indices.length - 4, r.UNSIGNED_SHORT, 0), n.reverse ? (r.stencilFunc(r.EQUAL, 255 - i, 255), r.stencilOp(r.KEEP, r.KEEP, r.DECR)) : (r.stencilFunc(r.EQUAL, i, 255), r.stencilOp(r.KEEP, r.KEEP, r.INCR)), r.drawElements(r.TRIANGLE_FAN, 4, r.UNSIGNED_SHORT, 2 * (e.indices.length - 4)), n.reverse ? r.stencilFunc(r.EQUAL, 255 - (i + 1), 255) : r.stencilFunc(r.EQUAL, i + 1, 255), n.reverse = !n.reverse) : (n.reverse ? (r.stencilFunc(r.EQUAL, i, 255), r.stencilOp(r.KEEP, r.KEEP, r.INCR)) : (r.stencilFunc(r.EQUAL, 255 - i, 255), r.stencilOp(r.KEEP, r.KEEP, r.DECR)), r.drawElements(r.TRIANGLE_STRIP, e.indices.length, r.UNSIGNED_SHORT, 0), n.reverse ? r.stencilFunc(r.EQUAL, i + 1, 255) : r.stencilFunc(r.EQUAL, 255 - (i + 1), 255)), r.colorMask(!0, !0, !0, !0), r.stencilOp(r.KEEP, r.KEEP, r.KEEP), n.count++ }, n.prototype.bindGraphics = function(t, e) { var r, n = this.renderer.gl;
					1 === e.mode ? (r = this.renderer.shaderManager.complexPrimitiveShader, this.renderer.shaderManager.setShader(r), n.uniformMatrix3fv(r.uniforms.translationMatrix._location, !1, t.worldTransform.toArray(!0)), n.uniformMatrix3fv(r.uniforms.projectionMatrix._location, !1, this.renderer.currentRenderTarget.projectionMatrix.toArray(!0)), n.uniform3fv(r.uniforms.tint._location, o.hex2rgb(t.tint)), n.uniform3fv(r.uniforms.color._location, e.color), n.uniform1f(r.uniforms.alpha._location, t.worldAlpha), n.bindBuffer(n.ARRAY_BUFFER, e.buffer), n.vertexAttribPointer(r.attributes.aVertexPosition, 2, n.FLOAT, !1, 8, 0), n.bindBuffer(n.ELEMENT_ARRAY_BUFFER, e.indexBuffer)) : (r = this.renderer.shaderManager.primitiveShader, this.renderer.shaderManager.setShader(r), n.uniformMatrix3fv(r.uniforms.translationMatrix._location, !1, t.worldTransform.toArray(!0)), n.uniformMatrix3fv(r.uniforms.projectionMatrix._location, !1, this.renderer.currentRenderTarget.projectionMatrix.toArray(!0)), n.uniform3fv(r.uniforms.tint._location, o.hex2rgb(t.tint)), n.uniform1f(r.uniforms.alpha._location, t.worldAlpha), n.bindBuffer(n.ARRAY_BUFFER, e.buffer), n.vertexAttribPointer(r.attributes.aVertexPosition, 2, n.FLOAT, !1, 24, 0), n.vertexAttribPointer(r.attributes.aColor, 4, n.FLOAT, !1, 24, 8), n.bindBuffer(n.ELEMENT_ARRAY_BUFFER, e.indexBuffer)) }, n.prototype.popStencil = function(t, e) { var r = this.renderer.gl,
						n = this.stencilMaskStack; if(n.stencilStack.pop(), n.count--, 0 === n.stencilStack.length) r.disable(r.STENCIL_TEST);
					else { var i = n.count;
						this.bindGraphics(t, e), r.colorMask(!1, !1, !1, !1), 1 === e.mode ? (n.reverse = !n.reverse, n.reverse ? (r.stencilFunc(r.EQUAL, 255 - (i + 1), 255), r.stencilOp(r.KEEP, r.KEEP, r.INCR)) : (r.stencilFunc(r.EQUAL, i + 1, 255), r.stencilOp(r.KEEP, r.KEEP, r.DECR)), r.drawElements(r.TRIANGLE_FAN, 4, r.UNSIGNED_SHORT, 2 * (e.indices.length - 4)), r.stencilFunc(r.ALWAYS, 0, 255), r.stencilOp(r.KEEP, r.KEEP, r.INVERT), r.drawElements(r.TRIANGLE_FAN, e.indices.length - 4, r.UNSIGNED_SHORT, 0), this.renderer.drawCount += 2, n.reverse ? r.stencilFunc(r.EQUAL, i, 255) : r.stencilFunc(r.EQUAL, 255 - i, 255)) : (n.reverse ? (r.stencilFunc(r.EQUAL, i + 1, 255), r.stencilOp(r.KEEP, r.KEEP, r.DECR)) : (r.stencilFunc(r.EQUAL, 255 - (i + 1), 255), r.stencilOp(r.KEEP, r.KEEP, r.INCR)), r.drawElements(r.TRIANGLE_STRIP, e.indices.length, r.UNSIGNED_SHORT, 0), this.renderer.drawCount++, n.reverse ? r.stencilFunc(r.EQUAL, i, 255) : r.stencilFunc(r.EQUAL, 255 - i, 255)), r.colorMask(!0, !0, !0, !0), r.stencilOp(r.KEEP, r.KEEP, r.KEEP) } }, n.prototype.destroy = function() { i.prototype.destroy.call(this), this.stencilMaskStack.stencilStack = null }, n.prototype.pushMask = function(t) { this.renderer.setObjectRenderer(this.renderer.plugins.graphics), t.dirty && this.renderer.plugins.graphics.updateGraphics(t, this.renderer.gl), t._webGL[this.renderer.gl.id].data.length && this.pushStencil(t, t._webGL[this.renderer.gl.id].data[0]) }, n.prototype.popMask = function(t) { this.renderer.setObjectRenderer(this.renderer.plugins.graphics), this.popStencil(t, t._webGL[this.renderer.gl.id].data[0]) } }, { "../../../utils": 70, "./WebGLManager": 51 }],
			51: [function(t, e, r) {
				function n(t) { this.renderer = t, this.renderer.on("context", this.onContextChange, this) } n.prototype.constructor = n, e.exports = n, n.prototype.onContextChange = function() {}, n.prototype.destroy = function() { this.renderer.off("context", this.onContextChange, this), this.renderer = null } }, {}],
			52: [function(t, e, r) {
				function n(t) { i.call(this, t, ["attribute vec2 aVertexPosition;", "uniform mat3 translationMatrix;", "uniform mat3 projectionMatrix;", "uniform vec3 tint;", "uniform float alpha;", "uniform vec3 color;", "varying vec4 vColor;", "void main(void){", "   gl_Position = vec4((projectionMatrix * translationMatrix * vec3(aVertexPosition, 1.0)).xy, 0.0, 1.0);", "   vColor = vec4(color * alpha * tint, alpha);", "}"].join("\n"), ["precision mediump float;", "varying vec4 vColor;", "void main(void){", "   gl_FragColor = vColor;", "}"].join("\n"), { tint: { type: "3f", value: [0, 0, 0] }, alpha: { type: "1f", value: 0 }, color: { type: "3f", value: [0, 0, 0] }, translationMatrix: { type: "mat3", value: new Float32Array(9) }, projectionMatrix: { type: "mat3", value: new Float32Array(9) } }, { aVertexPosition: 0 }) } var i = t("./Shader");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n }, { "./Shader": 54 }],
			53: [function(t, e, r) {
				function n(t) { i.call(this, t, ["attribute vec2 aVertexPosition;", "attribute vec4 aColor;", "uniform mat3 translationMatrix;", "uniform mat3 projectionMatrix;", "uniform float alpha;", "uniform float flipY;", "uniform vec3 tint;", "varying vec4 vColor;", "void main(void){", "   gl_Position = vec4((projectionMatrix * translationMatrix * vec3(aVertexPosition, 1.0)).xy, 0.0, 1.0);", "   vColor = aColor * vec4(tint * alpha, alpha);", "}"].join("\n"), ["precision mediump float;", "varying vec4 vColor;", "void main(void){", "   gl_FragColor = vColor;", "}"].join("\n"), { tint: { type: "3f", value: [0, 0, 0] }, alpha: { type: "1f", value: 0 }, translationMatrix: { type: "mat3", value: new Float32Array(9) }, projectionMatrix: { type: "mat3", value: new Float32Array(9) } }, { aVertexPosition: 0, aColor: 0 }) } var i = t("./Shader");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n }, { "./Shader": 54 }],
			54: [function(t, e, r) {
				function n(t, e, r, n, o) { if(!e || !r) throw new Error("Pixi.js Error. Shader requires vertexSrc and fragmentSrc");
					this.uid = i.uid(), this.gl = t.renderer.gl, this.shaderManager = t, this.program = null, this.uniforms = n || {}, this.attributes = o || {}, this.textureCount = 1, this.vertexSrc = e, this.fragmentSrc = r, this.init() } var i = t("../../../utils");
				n.prototype.constructor = n, e.exports = n, n.prototype.init = function() { this.compile(), this.gl.useProgram(this.program), this.cacheUniformLocations(Object.keys(this.uniforms)), this.cacheAttributeLocations(Object.keys(this.attributes)) }, n.prototype.cacheUniformLocations = function(t) { for(var e = 0; e < t.length; ++e) this.uniforms[t[e]]._location = this.gl.getUniformLocation(this.program, t[e]) }, n.prototype.cacheAttributeLocations = function(t) { for(var e = 0; e < t.length; ++e) this.attributes[t[e]] = this.gl.getAttribLocation(this.program, t[e]) }, n.prototype.compile = function() { var t = this.gl,
						e = this._glCompile(t.VERTEX_SHADER, this.vertexSrc),
						r = this._glCompile(t.FRAGMENT_SHADER, this.fragmentSrc),
						n = t.createProgram(); return t.attachShader(n, e), t.attachShader(n, r), t.linkProgram(n), t.getProgramParameter(n, t.LINK_STATUS) || (console.error("Pixi.js Error: Could not initialize shader."), console.error("gl.VALIDATE_STATUS", t.getProgramParameter(n, t.VALIDATE_STATUS)), console.error("gl.getError()", t.getError()), "" !== t.getProgramInfoLog(n) && console.warn("Pixi.js Warning: gl.getProgramInfoLog()", t.getProgramInfoLog(n)), t.deleteProgram(n), n = null), t.deleteShader(e), t.deleteShader(r), this.program = n }, n.prototype.syncUniform = function(t) { var e, r, n = t._location,
						o = t.value,
						s = this.gl; switch(t.type) {
						case "b":
						case "bool":
						case "boolean":
							s.uniform1i(n, o ? 1 : 0); break;
						case "i":
						case "1i":
							s.uniform1i(n, o); break;
						case "f":
						case "1f":
							s.uniform1f(n, o); break;
						case "2f":
							s.uniform2f(n, o[0], o[1]); break;
						case "3f":
							s.uniform3f(n, o[0], o[1], o[2]); break;
						case "4f":
							s.uniform4f(n, o[0], o[1], o[2], o[3]); break;
						case "v2":
							s.uniform2f(n, o.x, o.y); break;
						case "v3":
							s.uniform3f(n, o.x, o.y, o.z); break;
						case "v4":
							s.uniform4f(n, o.x, o.y, o.z, o.w); break;
						case "1iv":
							s.uniform1iv(n, o); break;
						case "2iv":
							s.uniform2iv(n, o); break;
						case "3iv":
							s.uniform3iv(n, o); break;
						case "4iv":
							s.uniform4iv(n, o); break;
						case "1fv":
							s.uniform1fv(n, o); break;
						case "2fv":
							s.uniform2fv(n, o); break;
						case "3fv":
							s.uniform3fv(n, o); break;
						case "4fv":
							s.uniform4fv(n, o); break;
						case "m2":
						case "mat2":
						case "Matrix2fv":
							s.uniformMatrix2fv(n, t.transpose, o); break;
						case "m3":
						case "mat3":
						case "Matrix3fv":
							s.uniformMatrix3fv(n, t.transpose, o); break;
						case "m4":
						case "mat4":
						case "Matrix4fv":
							s.uniformMatrix4fv(n, t.transpose, o); break;
						case "c":
							"number" == typeof o && (o = i.hex2rgb(o)), s.uniform3f(n, o[0], o[1], o[2]); break;
						case "iv1":
							s.uniform1iv(n, o); break;
						case "iv":
							s.uniform3iv(n, o); break;
						case "fv1":
							s.uniform1fv(n, o); break;
						case "fv":
							s.uniform3fv(n, o); break;
						case "v2v":
							for(t._array || (t._array = new Float32Array(2 * o.length)), e = 0, r = o.length; r > e; ++e) t._array[2 * e] = o[e].x, t._array[2 * e + 1] = o[e].y;
							s.uniform2fv(n, t._array); break;
						case "v3v":
							for(t._array || (t._array = new Float32Array(3 * o.length)), e = 0, r = o.length; r > e; ++e) t._array[3 * e] = o[e].x, t._array[3 * e + 1] = o[e].y, t._array[3 * e + 2] = o[e].z;
							s.uniform3fv(n, t._array); break;
						case "v4v":
							for(t._array || (t._array = new Float32Array(4 * o.length)), e = 0, r = o.length; r > e; ++e) t._array[4 * e] = o[e].x, t._array[4 * e + 1] = o[e].y, t._array[4 * e + 2] = o[e].z, t._array[4 * e + 3] = o[e].w;
							s.uniform4fv(n, t._array); break;
						case "t":
						case "sampler2D":
							if(!t.value || !t.value.baseTexture.hasLoaded) break;
							s.activeTexture(s["TEXTURE" + this.textureCount]); var a = t.value.baseTexture._glTextures[s.id];
							a || (this.initSampler2D(t), a = t.value.baseTexture._glTextures[s.id]), s.bindTexture(s.TEXTURE_2D, a), s.uniform1i(t._location, this.textureCount), this.textureCount++; break;
						default:
							console.warn("Pixi.js Shader Warning: Unknown uniform type: " + t.type) } }, n.prototype.syncUniforms = function() { this.textureCount = 1; for(var t in this.uniforms) this.syncUniform(this.uniforms[t]) }, n.prototype.initSampler2D = function(t) { var e = this.gl,
						r = t.value.baseTexture; if(r.hasLoaded)
						if(t.textureData) { var n = t.textureData;
							r._glTextures[e.id] = e.createTexture(), e.bindTexture(e.TEXTURE_2D, r._glTextures[e.id]), e.pixelStorei(e.UNPACK_PREMULTIPLY_ALPHA_WEBGL, r.premultipliedAlpha), e.texImage2D(e.TEXTURE_2D, 0, n.luminance ? e.LUMINANCE : e.RGBA, e.RGBA, e.UNSIGNED_BYTE, r.source), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_MAG_FILTER, n.magFilter ? n.magFilter : e.LINEAR), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_MIN_FILTER, n.wrapS ? n.wrapS : e.CLAMP_TO_EDGE), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_WRAP_T, n.wrapS ? n.wrapS : e.CLAMP_TO_EDGE), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_WRAP_S, n.wrapT ? n.wrapT : e.CLAMP_TO_EDGE) } else this.shaderManager.renderer.updateTexture(r) }, n.prototype.destroy = function() { this.gl.deleteProgram(this.program), this.gl = null, this.uniforms = null, this.attributes = null, this.vertexSrc = null, this.fragmentSrc = null }, n.prototype._glCompile = function(t, e) { var r = this.gl.createShader(t); return this.gl.shaderSource(r, e), this.gl.compileShader(r), this.gl.getShaderParameter(r, this.gl.COMPILE_STATUS) ? r : (console.log(this.gl.getShaderInfoLog(r)), null) } }, { "../../../utils": 70 }],
			55: [function(t, e, r) {
				function n(t, e, r, o, s) { var a = { uSampler: { type: "sampler2D", value: 0 }, projectionMatrix: { type: "mat3", value: new Float32Array([1, 0, 0, 0, 1, 0, 0, 0, 1]) } }; if(o)
						for(var l in o) a[l] = o[l]; var u = { aVertexPosition: 0, aTextureCoord: 0, aColor: 0 }; if(s)
						for(var h in s) u[h] = s[h];
					e = e || n.defaultVertexSrc, r = r || n.defaultFragmentSrc, i.call(this, t, e, r, a, u) } var i = t("./Shader");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.defaultVertexSrc = ["precision lowp float;", "attribute vec2 aVertexPosition;", "attribute vec2 aTextureCoord;", "attribute vec4 aColor;", "uniform mat3 projectionMatrix;", "varying vec2 vTextureCoord;", "varying vec4 vColor;", "void main(void){", "   gl_Position = vec4((projectionMatrix * vec3(aVertexPosition, 1.0)).xy, 0.0, 1.0);", "   vTextureCoord = aTextureCoord;", "   vColor = vec4(aColor.rgb * aColor.a, aColor.a);", "}"].join("\n"), n.defaultFragmentSrc = ["precision lowp float;", "varying vec2 vTextureCoord;", "varying vec4 vColor;", "uniform sampler2D uSampler;", "void main(void){", "   gl_FragColor = texture2D(uSampler, vTextureCoord) * vColor ;", "}"].join("\n") }, { "./Shader": 54 }],
			56: [function(t, e, r) {
				function n(t) { i.call(this, t) } var i = t("../managers/WebGLManager");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.start = function() {}, n.prototype.stop = function() { this.flush() }, n.prototype.flush = function() {}, n.prototype.render = function(t) {} }, { "../managers/WebGLManager": 51 }],
			57: [function(t, e, r) {
				function n(t) { this.gl = t, this.vertices = new Float32Array([0, 0, 200, 0, 200, 200, 0, 200]), this.uvs = new Float32Array([0, 0, 1, 0, 1, 1, 0, 1]), this.colors = new Float32Array([1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1]), this.indices = new Uint16Array([0, 1, 2, 0, 3, 2]), this.vertexBuffer = t.createBuffer(), this.indexBuffer = t.createBuffer(), t.bindBuffer(t.ARRAY_BUFFER, this.vertexBuffer), t.bufferData(t.ARRAY_BUFFER, 128, t.DYNAMIC_DRAW), t.bindBuffer(t.ELEMENT_ARRAY_BUFFER, this.indexBuffer), t.bufferData(t.ELEMENT_ARRAY_BUFFER, this.indices, t.STATIC_DRAW), this.upload() } n.prototype.constructor = n, n.prototype.map = function(t, e) { var r = 0,
						n = 0;
					this.uvs[0] = r, this.uvs[1] = n, this.uvs[2] = r + e.width / t.width, this.uvs[3] = n, this.uvs[4] = r + e.width / t.width, this.uvs[5] = n + e.height / t.height, this.uvs[6] = r, this.uvs[7] = n + e.height / t.height, r = e.x, n = e.y, this.vertices[0] = r, this.vertices[1] = n, this.vertices[2] = r + e.width, this.vertices[3] = n, this.vertices[4] = r + e.width, this.vertices[5] = n + e.height, this.vertices[6] = r, this.vertices[7] = n + e.height, this.upload() }, n.prototype.upload = function() { var t = this.gl;
					t.bindBuffer(t.ARRAY_BUFFER, this.vertexBuffer), t.bufferSubData(t.ARRAY_BUFFER, 0, this.vertices), t.bufferSubData(t.ARRAY_BUFFER, 32, this.uvs), t.bufferSubData(t.ARRAY_BUFFER, 64, this.colors) }, n.prototype.destroy = function() { var t = this.gl;
					t.deleteBuffer(this.vertexBuffer), t.deleteBuffer(this.indexBuffer) }, e.exports = n }, {}],
			58: [function(t, e, r) { var n = t("../../../math"),
					i = t("../../../utils"),
					o = t("../../../const"),
					s = t("./StencilMaskStack"),
					a = function(t, e, r, a, l, u) { if(this.gl = t, this.frameBuffer = null, this.texture = null, this.size = new n.Rectangle(0, 0, 1, 1), this.resolution = l || o.RESOLUTION, this.projectionMatrix = new n.Matrix, this.transform = null, this.frame = null, this.stencilBuffer = null, this.stencilMaskStack = new s, this.filterStack = [{ renderTarget: this, filter: [], bounds: this.size }], this.scaleMode = a || o.SCALE_MODES.DEFAULT, this.root = u, !this.root) { this.frameBuffer = t.createFramebuffer(), this.texture = t.createTexture(), t.bindTexture(t.TEXTURE_2D, this.texture), t.texParameteri(t.TEXTURE_2D, t.TEXTURE_MAG_FILTER, a === o.SCALE_MODES.LINEAR ? t.LINEAR : t.NEAREST), t.texParameteri(t.TEXTURE_2D, t.TEXTURE_MIN_FILTER, a === o.SCALE_MODES.LINEAR ? t.LINEAR : t.NEAREST); var h = i.isPowerOfTwo(e, r);
							h ? (t.texParameteri(t.TEXTURE_2D, t.TEXTURE_WRAP_S, t.REPEAT), t.texParameteri(t.TEXTURE_2D, t.TEXTURE_WRAP_T, t.REPEAT)) : (t.texParameteri(t.TEXTURE_2D, t.TEXTURE_WRAP_S, t.CLAMP_TO_EDGE), t.texParameteri(t.TEXTURE_2D, t.TEXTURE_WRAP_T, t.CLAMP_TO_EDGE)), t.bindFramebuffer(t.FRAMEBUFFER, this.frameBuffer), t.framebufferTexture2D(t.FRAMEBUFFER, t.COLOR_ATTACHMENT0, t.TEXTURE_2D, this.texture, 0) } this.resize(e, r) };
				a.prototype.constructor = a, e.exports = a, a.prototype.clear = function(t) { var e = this.gl;
					t && e.bindFramebuffer(e.FRAMEBUFFER, this.frameBuffer), e.clearColor(0, 0, 0, 0), e.clear(e.COLOR_BUFFER_BIT) }, a.prototype.attachStencilBuffer = function() { if(!this.stencilBuffer && !this.root) { var t = this.gl;
						this.stencilBuffer = t.createRenderbuffer(), t.bindRenderbuffer(t.RENDERBUFFER, this.stencilBuffer), t.framebufferRenderbuffer(t.FRAMEBUFFER, t.DEPTH_STENCIL_ATTACHMENT, t.RENDERBUFFER, this.stencilBuffer), t.renderbufferStorage(t.RENDERBUFFER, t.DEPTH_STENCIL, this.size.width * this.resolution, this.size.height * this.resolution) } }, a.prototype.activate = function() { var t = this.gl;
					t.bindFramebuffer(t.FRAMEBUFFER, this.frameBuffer); var e = this.frame || this.size;
					this.calculateProjection(e), this.transform && this.projectionMatrix.append(this.transform), t.viewport(0, 0, e.width * this.resolution, e.height * this.resolution) }, a.prototype.calculateProjection = function(t) { var e = this.projectionMatrix;
					e.identity(), this.root ? (e.a = 1 / t.width * 2, e.d = -1 / t.height * 2, e.tx = -1 - t.x * e.a, e.ty = 1 - t.y * e.d) : (e.a = 1 / t.width * 2, e.d = 1 / t.height * 2, e.tx = -1 - t.x * e.a, e.ty = -1 - t.y * e.d) }, a.prototype.resize = function(t, e) { if(t = 0 | t, e = 0 | e, this.size.width !== t || this.size.height !== e) { if(this.size.width = t, this.size.height = e, !this.root) { var r = this.gl;
							r.bindTexture(r.TEXTURE_2D, this.texture), r.texImage2D(r.TEXTURE_2D, 0, r.RGBA, t * this.resolution, e * this.resolution, 0, r.RGBA, r.UNSIGNED_BYTE, null), this.stencilBuffer && (r.bindRenderbuffer(r.RENDERBUFFER, this.stencilBuffer), r.renderbufferStorage(r.RENDERBUFFER, r.DEPTH_STENCIL, t * this.resolution, e * this.resolution)) } var n = this.frame || this.size;
						this.calculateProjection(n) } }, a.prototype.destroy = function() { var t = this.gl;
					t.deleteRenderbuffer(this.stencilBuffer), t.deleteFramebuffer(this.frameBuffer), t.deleteTexture(this.texture), this.frameBuffer = null, this.texture = null } }, { "../../../const": 16, "../../../math": 26, "../../../utils": 70, "./StencilMaskStack": 59 }],
			59: [function(t, e, r) {
				function n() { this.stencilStack = [], this.reverse = !0, this.count = 0 } n.prototype.constructor = n, e.exports = n }, {}],
			60: [function(t, e, r) {
				function n(t) { s.call(this), this.anchor = new i.Point, this._texture = null, this._width = 0, this._height = 0, this.tint = 16777215, this.blendMode = u.BLEND_MODES.NORMAL, this.shader = null, this.cachedTint = 16777215, this.texture = t || o.EMPTY }
				var i = t("../math"),
					o = t("../textures/Texture"),
					s = t("../display/Container"),
					a = t("../renderers/canvas/utils/CanvasTinter"),
					l = t("../utils"),
					u = t("../const"),
					h = new i.Point;
				n.prototype = Object.create(s.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { width: { get: function() { return Math.abs(this.scale.x) * this.texture._frame.width }, set: function(t) { var e = l.sign(this.scale.x) || 1;
							this.scale.x = e * t / this.texture._frame.width, this._width = t } }, height: { get: function() { return Math.abs(this.scale.y) * this.texture._frame.height }, set: function(t) { var e = l.sign(this.scale.y) || 1;
							this.scale.y = e * t / this.texture._frame.height, this._height = t } }, texture: { get: function() { return this._texture }, set: function(t) { this._texture !== t && (this._texture = t, this.cachedTint = 16777215, t && (t.baseTexture.hasLoaded ? this._onTextureUpdate() : t.once("update", this._onTextureUpdate, this))) } } }), n.prototype._onTextureUpdate = function() { this._width && (this.scale.x = l.sign(this.scale.x) * this._width / this.texture.frame.width), this._height && (this.scale.y = l.sign(this.scale.y) * this._height / this.texture.frame.height) }, n.prototype._renderWebGL = function(t) { t.setObjectRenderer(t.plugins.sprite), t.plugins.sprite.render(this) }, n.prototype.getBounds = function(t) { if(!this._currentBounds) { var e, r, n, i, o = this._texture._frame.width,
							s = this._texture._frame.height,
							a = o * (1 - this.anchor.x),
							l = o * -this.anchor.x,
							u = s * (1 - this.anchor.y),
							h = s * -this.anchor.y,
							c = t || this.worldTransform,
							p = c.a,
							d = c.b,
							f = c.c,
							v = c.d,
							g = c.tx,
							m = c.ty,
							y = p * l + f * h + g,
							T = v * h + d * l + m,
							x = p * a + f * h + g,
							b = v * h + d * a + m,
							S = p * a + f * u + g,
							E = v * u + d * a + m,
							A = p * l + f * u + g,
							_ = v * u + d * l + m; if(e = y, e = e > x ? x : e, e = e > S ? S : e, e = e > A ? A : e, n = T, n = n > b ? b : n, n = n > E ? E : n, n = n > _ ? _ : n, r = y, r = x > r ? x : r, r = S > r ? S : r, r = A > r ? A : r, i = T, i = b > i ? b : i, i = E > i ? E : i, i = _ > i ? _ : i, this.children.length) { var M = this.containerGetBounds();
							a = M.x, l = M.x + M.width, u = M.y, h = M.y + M.height, e = a > e ? e : a, n = u > n ? n : u, r = r > l ? r : l, i = i > h ? i : h } var w = this._bounds;
						w.x = e, w.width = r - e, w.y = n, w.height = i - n, this._currentBounds = w } return this._currentBounds }, n.prototype.getLocalBounds = function() { return this._bounds.x = -this._texture._frame.width * this.anchor.x, this._bounds.y = -this._texture._frame.height * this.anchor.y, this._bounds.width = this._texture._frame.width, this._bounds.height = this._texture._frame.height, this._bounds }, n.prototype.containsPoint = function(t) { this.worldTransform.applyInverse(t, h); var e, r = this._texture._frame.width,
						n = this._texture._frame.height,
						i = -r * this.anchor.x; return h.x > i && h.x < i + r && (e = -n * this.anchor.y, h.y > e && h.y < e + n) ? !0 : !1 }, n.prototype._renderCanvas = function(t) {
					if(!(this.texture.crop.width <= 0 || this.texture.crop.height <= 0)) {
						var e = t.blendModes[this.blendMode];
						if(e !== t.context.globalCompositeOperation && (t.context.globalCompositeOperation = e), this.texture.valid) {
							var r, n, i, o, s = this._texture,
								l = this.worldTransform;
							t.context.globalAlpha = this.worldAlpha;
							var h = s.baseTexture.scaleMode === u.SCALE_MODES.LINEAR;
							if(t.smoothProperty && t.context[t.smoothProperty] !== h && (t.context[t.smoothProperty] = h), s.rotate) { i = s.crop.height, o = s.crop.width, r = s.trim ? s.trim.y - this.anchor.y * s.trim.height : this.anchor.y * -s._frame.height, n = s.trim ? s.trim.x - this.anchor.x * s.trim.width : this.anchor.x * -s._frame.width, r += i, l.tx = n * l.a + r * l.c + l.tx, l.ty = n * l.b + r * l.d + l.ty; var c = l.a;
								l.a = -l.c, l.c = c, c = l.b, l.b = -l.d, l.d = c, r = 0, n = 0 } else i = s.crop.width, o = s.crop.height, r = s.trim ? s.trim.x - this.anchor.x * s.trim.width : this.anchor.x * -s._frame.width, n = s.trim ? s.trim.y - this.anchor.y * s.trim.height : this.anchor.y * -s._frame.height;
							t.roundPixels ? (t.context.setTransform(l.a, l.b, l.c, l.d, l.tx * t.resolution | 0, l.ty * t.resolution | 0), r = 0 | r, n = 0 | n) : t.context.setTransform(l.a, l.b, l.c, l.d, l.tx * t.resolution, l.ty * t.resolution);
							var p = s.baseTexture.resolution;
							16777215 !== this.tint ? (this.cachedTint !== this.tint && (this.cachedTint = this.tint, this.tintedTexture = a.getTintedTexture(this, this.tint)), t.context.drawImage(this.tintedTexture, 0, 0, i * p, o * p, r * t.resolution, n * t.resolution, i * t.resolution, o * t.resolution)) : t.context.drawImage(s.baseTexture.source, s.crop.x * p, s.crop.y * p, i * p, o * p, r * t.resolution, n * t.resolution, i * t.resolution, o * t.resolution);
						}
					}
				}, n.prototype.destroy = function(t, e) { s.prototype.destroy.call(this), this.anchor = null, t && this._texture.destroy(e), this._texture = null, this.shader = null }, n.fromFrame = function(t) { var e = l.TextureCache[t]; if(!e) throw new Error('The frameId "' + t + '" does not exist in the texture cache'); return new n(e) }, n.fromImage = function(t, e, r) { return new n(o.fromImage(t, e, r)) }
			}, { "../const": 16, "../display/Container": 17, "../math": 26, "../renderers/canvas/utils/CanvasTinter": 41, "../textures/Texture": 65, "../utils": 70 }],
			61: [function(t, e, r) {
				function n(t) { i.call(this, t), this.vertSize = 5, this.vertByteSize = 4 * this.vertSize, this.size = s.SPRITE_BATCH_SIZE; var e = 4 * this.size * this.vertByteSize,
						r = 6 * this.size;
					this.vertices = new ArrayBuffer(e), this.positions = new Float32Array(this.vertices), this.colors = new Uint32Array(this.vertices), this.indices = new Uint16Array(r); for(var n = 0, o = 0; r > n; n += 6, o += 4) this.indices[n + 0] = o + 0, this.indices[n + 1] = o + 1, this.indices[n + 2] = o + 2, this.indices[n + 3] = o + 0, this.indices[n + 4] = o + 2, this.indices[n + 5] = o + 3;
					this.currentBatchSize = 0, this.sprites = [], this.shader = null } var i = t("../../renderers/webgl/utils/ObjectRenderer"),
					o = t("../../renderers/webgl/WebGLRenderer"),
					s = t("../../const");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, o.registerPlugin("sprite", n), n.prototype.onContextChange = function() { var t = this.renderer.gl;
					this.shader = this.renderer.shaderManager.defaultShader, this.vertexBuffer = t.createBuffer(), this.indexBuffer = t.createBuffer(), t.bindBuffer(t.ELEMENT_ARRAY_BUFFER, this.indexBuffer), t.bufferData(t.ELEMENT_ARRAY_BUFFER, this.indices, t.STATIC_DRAW), t.bindBuffer(t.ARRAY_BUFFER, this.vertexBuffer), t.bufferData(t.ARRAY_BUFFER, this.vertices, t.DYNAMIC_DRAW), this.currentBlendMode = 99999 }, n.prototype.render = function(t) { var e = t._texture;
					this.currentBatchSize >= this.size && this.flush(); var r = e._uvs; if(r) { var n, i, o, s, a = t.anchor.x,
							l = t.anchor.y; if(e.trim && void 0 === t.tileScale) { var u = e.trim;
							i = u.x - a * u.width, n = i + e.crop.width, s = u.y - l * u.height, o = s + e.crop.height } else n = e._frame.width * (1 - a), i = e._frame.width * -a, o = e._frame.height * (1 - l), s = e._frame.height * -l; var h = this.currentBatchSize * this.vertByteSize,
							c = t.worldTransform,
							p = c.a,
							d = c.b,
							f = c.c,
							v = c.d,
							g = c.tx,
							m = c.ty,
							y = this.colors,
							T = this.positions; if(this.renderer.roundPixels) { var x = this.renderer.resolution;
							T[h] = ((p * i + f * s + g) * x | 0) / x, T[h + 1] = ((v * s + d * i + m) * x | 0) / x, T[h + 5] = ((p * n + f * s + g) * x | 0) / x, T[h + 6] = ((v * s + d * n + m) * x | 0) / x, T[h + 10] = ((p * n + f * o + g) * x | 0) / x, T[h + 11] = ((v * o + d * n + m) * x | 0) / x, T[h + 15] = ((p * i + f * o + g) * x | 0) / x, T[h + 16] = ((v * o + d * i + m) * x | 0) / x } else T[h] = p * i + f * s + g, T[h + 1] = v * s + d * i + m, T[h + 5] = p * n + f * s + g, T[h + 6] = v * s + d * n + m, T[h + 10] = p * n + f * o + g, T[h + 11] = v * o + d * n + m, T[h + 15] = p * i + f * o + g, T[h + 16] = v * o + d * i + m;
						T[h + 2] = r.x0, T[h + 3] = r.y0, T[h + 7] = r.x1, T[h + 8] = r.y1, T[h + 12] = r.x2, T[h + 13] = r.y2, T[h + 17] = r.x3, T[h + 18] = r.y3; var b = t.tint;
						y[h + 4] = y[h + 9] = y[h + 14] = y[h + 19] = (b >> 16) + (65280 & b) + ((255 & b) << 16) + (255 * t.worldAlpha << 24), this.sprites[this.currentBatchSize++] = t } }, n.prototype.flush = function() { if(0 !== this.currentBatchSize) { var t, e = this.renderer.gl; if(this.currentBatchSize > .5 * this.size) e.bufferSubData(e.ARRAY_BUFFER, 0, this.vertices);
						else { var r = this.positions.subarray(0, this.currentBatchSize * this.vertByteSize);
							e.bufferSubData(e.ARRAY_BUFFER, 0, r) } for(var n, i, o, s, a = 0, l = 0, u = null, h = this.renderer.blendModeManager.currentBlendMode, c = null, p = !1, d = !1, f = 0, v = this.currentBatchSize; v > f; f++) s = this.sprites[f], n = s._texture.baseTexture, i = s.blendMode, o = s.shader || this.shader, p = h !== i, d = c !== o, (u !== n || p || d) && (this.renderBatch(u, a, l), l = f, a = 0, u = n, p && (h = i, this.renderer.blendModeManager.setBlendMode(h)), d && (c = o, t = c.shaders ? c.shaders[e.id] : c, t || (t = c.getShader(this.renderer)), this.renderer.shaderManager.setShader(t), t.uniforms.projectionMatrix.value = this.renderer.currentRenderTarget.projectionMatrix.toArray(!0), t.syncUniforms(), e.activeTexture(e.TEXTURE0))), a++;
						this.renderBatch(u, a, l), this.currentBatchSize = 0 } }, n.prototype.renderBatch = function(t, e, r) { if(0 !== e) { var n = this.renderer.gl;
						t._glTextures[n.id] ? n.bindTexture(n.TEXTURE_2D, t._glTextures[n.id]) : this.renderer.updateTexture(t), n.drawElements(n.TRIANGLES, 6 * e, n.UNSIGNED_SHORT, 6 * r * 2), this.renderer.drawCount++ } }, n.prototype.start = function() { var t = this.renderer.gl;
					t.bindBuffer(t.ARRAY_BUFFER, this.vertexBuffer), t.bindBuffer(t.ELEMENT_ARRAY_BUFFER, this.indexBuffer); var e = this.vertByteSize;
					t.vertexAttribPointer(this.shader.attributes.aVertexPosition, 2, t.FLOAT, !1, e, 0), t.vertexAttribPointer(this.shader.attributes.aTextureCoord, 2, t.FLOAT, !1, e, 8), t.vertexAttribPointer(this.shader.attributes.aColor, 4, t.UNSIGNED_BYTE, !0, e, 16) }, n.prototype.destroy = function() { this.renderer.gl.deleteBuffer(this.vertexBuffer), this.renderer.gl.deleteBuffer(this.indexBuffer), i.prototype.destroy.call(this), this.shader.destroy(), this.renderer = null, this.vertices = null, this.positions = null, this.colors = null, this.indices = null, this.vertexBuffer = null, this.indexBuffer = null, this.sprites = null, this.shader = null } }, { "../../const": 16, "../../renderers/webgl/WebGLRenderer": 42, "../../renderers/webgl/utils/ObjectRenderer": 56 }],
			62: [function(t, e, r) {
				function n(t, e, r) { this.canvas = document.createElement("canvas"), this.context = this.canvas.getContext("2d"), this.resolution = r || l.RESOLUTION, this._text = null, this._style = null; var n = o.fromCanvas(this.canvas);
					n.trim = new s.Rectangle, i.call(this, n), this.text = t, this.style = e } var i = t("../sprites/Sprite"),
					o = t("../textures/Texture"),
					s = t("../math"),
					a = t("../utils"),
					l = t("../const");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.fontPropertiesCache = {}, n.fontPropertiesCanvas = document.createElement("canvas"), n.fontPropertiesContext = n.fontPropertiesCanvas.getContext("2d"), Object.defineProperties(n.prototype, { width: { get: function() { return this.dirty && this.updateText(), this.scale.x * this._texture._frame.width }, set: function(t) { this.scale.x = t / this._texture._frame.width, this._width = t } }, height: { get: function() { return this.dirty && this.updateText(), this.scale.y * this._texture._frame.height }, set: function(t) { this.scale.y = t / this._texture._frame.height, this._height = t } }, style: { get: function() { return this._style }, set: function(t) { t = t || {}, "number" == typeof t.fill && (t.fill = a.hex2string(t.fill)), "number" == typeof t.stroke && (t.stroke = a.hex2string(t.stroke)), "number" == typeof t.dropShadowColor && (t.dropShadowColor = a.hex2string(t.dropShadowColor)), t.font = t.font || "bold 20pt Arial", t.fill = t.fill || "black", t.align = t.align || "left", t.stroke = t.stroke || "black", t.strokeThickness = t.strokeThickness || 0, t.wordWrap = t.wordWrap || !1, t.wordWrapWidth = t.wordWrapWidth || 100, t.dropShadow = t.dropShadow || !1, t.dropShadowColor = t.dropShadowColor || "#000000", t.dropShadowAngle = void 0 !== t.dropShadowAngle ? t.dropShadowAngle : Math.PI / 6, t.dropShadowDistance = void 0 !== t.dropShadowDistance ? t.dropShadowDistance : 5, t.dropShadowBlur = void 0 !== t.dropShadowBlur ? t.dropShadowBlur : 0, t.padding = t.padding || 0, t.textBaseline = t.textBaseline || "alphabetic", t.lineJoin = t.lineJoin || "miter", t.miterLimit = t.miterLimit || 10, this._style = t, this.dirty = !0 } }, text: { get: function() { return this._text }, set: function(t) { t = t.toString() || " ", this._text !== t && (this._text = t, this.dirty = !0) } } }), n.prototype.updateText = function() { var t = this._style;
					this.context.font = t.font; for(var e = t.wordWrap ? this.wordWrap(this._text) : this._text, r = e.split(/(?:\r\n|\r|\n)/), n = new Array(r.length), i = 0, o = this.determineFontProperties(t.font), s = 0; s < r.length; s++) { var a = this.context.measureText(r[s]).width;
						n[s] = a, i = Math.max(i, a) } var l = i + t.strokeThickness;
					t.dropShadow && (l += t.dropShadowDistance), this.canvas.width = (l + this.context.lineWidth) * this.resolution; var u = this.style.lineHeight || o.fontSize + t.strokeThickness,
						h = u * r.length;
					t.dropShadow && (h += t.dropShadowDistance), this.canvas.height = (h + 2 * this._style.padding) * this.resolution, this.context.scale(this.resolution, this.resolution), navigator.isCocoonJS && this.context.clearRect(0, 0, this.canvas.width, this.canvas.height), this.context.font = t.font, this.context.strokeStyle = t.stroke, this.context.lineWidth = t.strokeThickness, this.context.textBaseline = t.textBaseline, this.context.lineJoin = t.lineJoin, this.context.miterLimit = t.miterLimit; var c, p; if(t.dropShadow) { t.dropShadowBlur > 0 ? (this.context.shadowColor = t.dropShadowColor, this.context.shadowBlur = t.dropShadowBlur) : this.context.fillStyle = t.dropShadowColor; var d = Math.cos(t.dropShadowAngle) * t.dropShadowDistance,
							f = Math.sin(t.dropShadowAngle) * t.dropShadowDistance; for(s = 0; s < r.length; s++) c = t.strokeThickness / 2, p = t.strokeThickness / 2 + s * u + o.ascent, "right" === t.align ? c += i - n[s] : "center" === t.align && (c += (i - n[s]) / 2), t.fill && this.context.fillText(r[s], c + d, p + f + this._style.padding) } for(this.context.fillStyle = t.fill, s = 0; s < r.length; s++) c = t.strokeThickness / 2, p = t.strokeThickness / 2 + s * u + o.ascent, "right" === t.align ? c += i - n[s] : "center" === t.align && (c += (i - n[s]) / 2), t.stroke && t.strokeThickness && this.context.strokeText(r[s], c, p + this._style.padding), t.fill && this.context.fillText(r[s], c, p + this._style.padding);
					this.updateTexture() }, n.prototype.updateTexture = function() { var t = this._texture;
					t.baseTexture.hasLoaded = !0, t.baseTexture.resolution = this.resolution, t.baseTexture.width = this.canvas.width / this.resolution, t.baseTexture.height = this.canvas.height / this.resolution, t.crop.width = t._frame.width = this.canvas.width / this.resolution, t.crop.height = t._frame.height = this.canvas.height / this.resolution, t.trim.x = 0, t.trim.y = -this._style.padding, t.trim.width = t._frame.width, t.trim.height = t._frame.height - 2 * this._style.padding, this._width = this.canvas.width / this.resolution, this._height = this.canvas.height / this.resolution, t.baseTexture.emit("update", t.baseTexture), this.dirty = !1 }, n.prototype.renderWebGL = function(t) { this.dirty && this.updateText(), i.prototype.renderWebGL.call(this, t) }, n.prototype._renderCanvas = function(t) { this.dirty && this.updateText(), i.prototype._renderCanvas.call(this, t) }, n.prototype.determineFontProperties = function(t) { var e = n.fontPropertiesCache[t]; if(!e) { e = {}; var r = n.fontPropertiesCanvas,
							i = n.fontPropertiesContext;
						i.font = t; var o = Math.ceil(i.measureText("|MÉq").width),
							s = Math.ceil(i.measureText("M").width),
							a = 2 * s;
						s = 1.4 * s | 0, r.width = o, r.height = a, i.fillStyle = "#f00", i.fillRect(0, 0, o, a), i.font = t, i.textBaseline = "alphabetic", i.fillStyle = "#000", i.fillText("|MÉq", 0, s); var l, u, h = i.getImageData(0, 0, o, a).data,
							c = h.length,
							p = 4 * o,
							d = 0,
							f = !1; for(l = 0; s > l; l++) { for(u = 0; p > u; u += 4)
								if(255 !== h[d + u]) { f = !0; break }
							if(f) break;
							d += p } for(e.ascent = s - l, d = c - p, f = !1, l = a; l > s; l--) { for(u = 0; p > u; u += 4)
								if(255 !== h[d + u]) { f = !0; break }
							if(f) break;
							d -= p } e.descent = l - s, e.fontSize = e.ascent + e.descent, n.fontPropertiesCache[t] = e } return e }, n.prototype.wordWrap = function(t) { for(var e = "", r = t.split("\n"), n = this._style.wordWrapWidth, i = 0; i < r.length; i++) { for(var o = n, s = r[i].split(" "), a = 0; a < s.length; a++) { var l = this.context.measureText(s[a]).width,
								u = l + this.context.measureText(" ").width;
							0 === a || u > o ? (a > 0 && (e += "\n"), e += s[a], o = n - l) : (o -= u, e += " " + s[a]) } i < r.length - 1 && (e += "\n") } return e }, n.prototype.getBounds = function(t) { return this.dirty && this.updateText(), i.prototype.getBounds.call(this, t) }, n.prototype.destroy = function(t) { this.context = null, this.canvas = null, this._style = null, this._texture.destroy(void 0 === t ? !0 : t) } }, { "../const": 16, "../math": 26, "../sprites/Sprite": 60, "../textures/Texture": 65, "../utils": 70 }],
			63: [function(t, e, r) {
				function n(t, e, r) { s.call(this), this.uid = i.uid(), this.resolution = r || 1, this.width = 100, this.height = 100, this.realWidth = 100, this.realHeight = 100, this.scaleMode = e || o.SCALE_MODES.DEFAULT, this.hasLoaded = !1, this.isLoading = !1, this.source = null, this.premultipliedAlpha = !0, this.imageUrl = null, this.isPowerOfTwo = !1, this.mipmap = !1, this._glTextures = {}, t && this.loadSource(t) } var i = t("../utils"),
					o = t("../const"),
					s = t("eventemitter3");
				n.prototype = Object.create(s.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.update = function() { this.realWidth = this.source.naturalWidth || this.source.width, this.realHeight = this.source.naturalHeight || this.source.height, this.width = this.realWidth / this.resolution, this.height = this.realHeight / this.resolution, this.isPowerOfTwo = i.isPowerOfTwo(this.realWidth, this.realHeight), this.emit("update", this) }, n.prototype.loadSource = function(t) { var e = this.isLoading; if(this.hasLoaded = !1, this.isLoading = !1, e && this.source && (this.source.onload = null, this.source.onerror = null), this.source = t, (this.source.complete || this.source.getContext) && this.source.width && this.source.height) this._sourceLoaded();
					else if(!t.getContext) { this.isLoading = !0; var r = this;
						t.onload = function() { t.onload = null, t.onerror = null, r.isLoading && (r.isLoading = !1, r._sourceLoaded(), r.emit("loaded", r)) }, t.onerror = function() { t.onload = null, t.onerror = null, r.isLoading && (r.isLoading = !1, r.emit("error", r)) }, t.complete && t.src && (this.isLoading = !1, t.onload = null, t.onerror = null, t.width && t.height ? (this._sourceLoaded(), e && this.emit("loaded", this)) : e && this.emit("error", this)) } }, n.prototype._sourceLoaded = function() { this.hasLoaded = !0, this.update() }, n.prototype.destroy = function() { this.imageUrl ? (delete i.BaseTextureCache[this.imageUrl], delete i.TextureCache[this.imageUrl], this.imageUrl = null, navigator.isCocoonJS || (this.source.src = "")) : this.source && this.source._pixiId && delete i.BaseTextureCache[this.source._pixiId], this.source = null, this.dispose() }, n.prototype.dispose = function() { this.emit("dispose", this) }, n.prototype.updateSourceImage = function(t) { this.source.src = t, this.loadSource(this.source) }, n.fromImage = function(t, e, r) { var o = i.BaseTextureCache[t]; if(void 0 === e && 0 !== t.indexOf("data:") && (e = !0), !o) { var s = new Image;
						e && (s.crossOrigin = ""), o = new n(s, r), o.imageUrl = t, s.src = t, i.BaseTextureCache[t] = o, o.resolution = i.getResolutionOfUrl(t) } return o }, n.fromCanvas = function(t, e) { t._pixiId || (t._pixiId = "canvas_" + i.uid()); var r = i.BaseTextureCache[t._pixiId]; return r || (r = new n(t, e), i.BaseTextureCache[t._pixiId] = r), r } }, { "../const": 16, "../utils": 70, eventemitter3: 10 }],
			64: [function(t, e, r) {
				function n(t, e, r, n, c) { if(!t) throw new Error("Unable to create RenderTexture, you must pass a renderer into the constructor.");
					e = e || 100, r = r || 100, c = c || h.RESOLUTION; var p = new i; if(p.width = e, p.height = r, p.resolution = c, p.scaleMode = n || h.SCALE_MODES.DEFAULT, p.hasLoaded = !0, o.call(this, p, new u.Rectangle(0, 0, e, r)), this.width = e, this.height = r, this.resolution = c, this.render = null, this.renderer = t, this.renderer.type === h.RENDERER_TYPE.WEBGL) { var d = this.renderer.gl;
						this.textureBuffer = new s(d, this.width, this.height, p.scaleMode, this.resolution), this.baseTexture._glTextures[d.id] = this.textureBuffer.texture, this.filterManager = new a(this.renderer), this.filterManager.onContextChange(), this.filterManager.resize(e, r), this.render = this.renderWebGL, this.renderer.currentRenderer.start(), this.renderer.currentRenderTarget.activate() } else this.render = this.renderCanvas, this.textureBuffer = new l(this.width * this.resolution, this.height * this.resolution), this.baseTexture.source = this.textureBuffer.canvas;
					this.valid = !0, this._updateUvs() } var i = t("./BaseTexture"),
					o = t("./Texture"),
					s = t("../renderers/webgl/utils/RenderTarget"),
					a = t("../renderers/webgl/managers/FilterManager"),
					l = t("../renderers/canvas/utils/CanvasBuffer"),
					u = t("../math"),
					h = t("../const"),
					c = new u.Matrix;
				n.prototype = Object.create(o.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.resize = function(t, e, r) {
					(t !== this.width || e !== this.height) && (this.valid = t > 0 && e > 0, this.width = this._frame.width = this.crop.width = t, this.height = this._frame.height = this.crop.height = e, r && (this.baseTexture.width = this.width, this.baseTexture.height = this.height), this.valid && (this.textureBuffer.resize(this.width, this.height), this.filterManager && this.filterManager.resize(this.width, this.height))) }, n.prototype.clear = function() { this.valid && (this.renderer.type === h.RENDERER_TYPE.WEBGL && this.renderer.gl.bindFramebuffer(this.renderer.gl.FRAMEBUFFER, this.textureBuffer.frameBuffer), this.textureBuffer.clear()) }, n.prototype.renderWebGL = function(t, e, r, n) { if(this.valid) { if(n = void 0 !== n ? n : !0, this.textureBuffer.transform = e, this.textureBuffer.activate(), t.worldAlpha = 1, n) { t.worldTransform.identity(), t.currentBounds = null; var i, o, s = t.children; for(i = 0, o = s.length; o > i; ++i) s[i].updateTransform() } var a = this.renderer.filterManager;
						this.renderer.filterManager = this.filterManager, this.renderer.renderDisplayObject(t, this.textureBuffer, r), this.renderer.filterManager = a } }, n.prototype.renderCanvas = function(t, e, r, n) { if(this.valid) { n = !!n; var i = c;
						i.identity(), e && i.append(e); var o = t.worldTransform;
						t.worldTransform = i, t.worldAlpha = 1; var s, a, l = t.children; for(s = 0, a = l.length; a > s; ++s) l[s].updateTransform();
						r && this.textureBuffer.clear(); var u = this.textureBuffer.context,
							h = this.renderer.resolution;
						this.renderer.resolution = this.resolution, this.renderer.renderDisplayObject(t, u), this.renderer.resolution = h, t.worldTransform === i && (t.worldTransform = o) } }, n.prototype.destroy = function() { o.prototype.destroy.call(this, !0), this.textureBuffer.destroy(), this.filterManager && this.filterManager.destroy(), this.renderer = null }, n.prototype.getImage = function() { var t = new Image; return t.src = this.getBase64(), t }, n.prototype.getBase64 = function() { return this.getCanvas().toDataURL() }, n.prototype.getCanvas = function() { if(this.renderer.type === h.RENDERER_TYPE.WEBGL) { var t = this.renderer.gl,
							e = this.textureBuffer.size.width,
							r = this.textureBuffer.size.height,
							n = new Uint8Array(4 * e * r);
						t.bindFramebuffer(t.FRAMEBUFFER, this.textureBuffer.frameBuffer), t.readPixels(0, 0, e, r, t.RGBA, t.UNSIGNED_BYTE, n), t.bindFramebuffer(t.FRAMEBUFFER, null); var i = new l(e, r),
							o = i.context.getImageData(0, 0, e, r); return o.data.set(n), i.context.putImageData(o, 0, 0), i.canvas } return this.textureBuffer.canvas }, n.prototype.getPixels = function() { var t, e; if(this.renderer.type === h.RENDERER_TYPE.WEBGL) { var r = this.renderer.gl;
						t = this.textureBuffer.size.width, e = this.textureBuffer.size.height; var n = new Uint8Array(4 * t * e); return r.bindFramebuffer(r.FRAMEBUFFER, this.textureBuffer.frameBuffer), r.readPixels(0, 0, t, e, r.RGBA, r.UNSIGNED_BYTE, n), r.bindFramebuffer(r.FRAMEBUFFER, null), n } return t = this.textureBuffer.canvas.width, e = this.textureBuffer.canvas.height, this.textureBuffer.canvas.getContext("2d").getImageData(0, 0, t, e).data }, n.prototype.getPixel = function(t, e) { if(this.renderer.type === h.RENDERER_TYPE.WEBGL) { var r = this.renderer.gl,
							n = new Uint8Array(4); return r.bindFramebuffer(r.FRAMEBUFFER, this.textureBuffer.frameBuffer), r.readPixels(t, e, 1, 1, r.RGBA, r.UNSIGNED_BYTE, n), r.bindFramebuffer(r.FRAMEBUFFER, null), n } return this.textureBuffer.canvas.getContext("2d").getImageData(t, e, 1, 1).data } }, { "../const": 16, "../math": 26, "../renderers/canvas/utils/CanvasBuffer": 38, "../renderers/webgl/managers/FilterManager": 47, "../renderers/webgl/utils/RenderTarget": 58, "./BaseTexture": 63, "./Texture": 65 }],
			65: [function(t, e, r) {
				function n(t, e, r, i, o) { a.call(this), this.noFrame = !1, e || (this.noFrame = !0, e = new l.Rectangle(0, 0, 1, 1)), t instanceof n && (t = t.baseTexture), this.baseTexture = t, this._frame = e, this.trim = i, this.valid = !1, this.requiresUpdate = !1, this._uvs = null, this.width = 0, this.height = 0, this.crop = r || e, this.rotate = !!o, t.hasLoaded ? (this.noFrame && (e = new l.Rectangle(0, 0, t.width, t.height), t.on("update", this.onBaseTextureUpdated, this)), this.frame = e) : t.once("loaded", this.onBaseTextureLoaded, this) } var i = t("./BaseTexture"),
					o = t("./VideoBaseTexture"),
					s = t("./TextureUvs"),
					a = t("eventemitter3"),
					l = t("../math"),
					u = t("../utils");
				n.prototype = Object.create(a.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { frame: { get: function() { return this._frame }, set: function(t) { if(this._frame = t, this.noFrame = !1, this.width = t.width, this.height = t.height, !this.trim && !this.rotate && (t.x + t.width > this.baseTexture.width || t.y + t.height > this.baseTexture.height)) throw new Error("Texture Error: frame does not fit inside the base Texture dimensions " + this);
							this.valid = t && t.width && t.height && this.baseTexture.hasLoaded, this.trim ? (this.width = this.trim.width, this.height = this.trim.height, this._frame.width = this.trim.width, this._frame.height = this.trim.height) : this.crop = t, this.valid && this._updateUvs() } } }), n.prototype.update = function() { this.baseTexture.update() }, n.prototype.onBaseTextureLoaded = function(t) { this.noFrame ? this.frame = new l.Rectangle(0, 0, t.width, t.height) : this.frame = this._frame, this.emit("update", this) }, n.prototype.onBaseTextureUpdated = function(t) { this._frame.width = t.width, this._frame.height = t.height, this.emit("update", this) }, n.prototype.destroy = function(t) { this.baseTexture && (t && this.baseTexture.destroy(), this.baseTexture.off("update", this.onBaseTextureUpdated, this), this.baseTexture.off("loaded", this.onBaseTextureLoaded, this), this.baseTexture = null), this._frame = null, this._uvs = null, this.trim = null, this.crop = null, this.valid = !1, this.off("dispose", this.dispose, this), this.off("update", this.update, this) }, n.prototype.clone = function() { return new n(this.baseTexture, this.frame, this.crop, this.trim, this.rotate) }, n.prototype._updateUvs = function() { this._uvs || (this._uvs = new s), this._uvs.set(this.crop, this.baseTexture, this.rotate) }, n.fromImage = function(t, e, r) { var o = u.TextureCache[t]; return o || (o = new n(i.fromImage(t, e, r)), u.TextureCache[t] = o), o }, n.fromFrame = function(t) { var e = u.TextureCache[t]; if(!e) throw new Error('The frameId "' + t + '" does not exist in the texture cache'); return e }, n.fromCanvas = function(t, e) { return new n(i.fromCanvas(t, e)) }, n.fromVideo = function(t, e) { return "string" == typeof t ? n.fromVideoUrl(t, e) : new n(o.fromVideo(t, e)) }, n.fromVideoUrl = function(t, e) { return new n(o.fromUrl(t, e)) }, n.addTextureToCache = function(t, e) { u.TextureCache[e] = t }, n.removeTextureFromCache = function(t) { var e = u.TextureCache[t]; return delete u.TextureCache[t], delete u.BaseTextureCache[t], e }, n.EMPTY = new n(new i) }, { "../math": 26, "../utils": 70, "./BaseTexture": 63, "./TextureUvs": 66, "./VideoBaseTexture": 67, eventemitter3: 10 }],
			66: [function(t, e, r) {
				function n() { this.x0 = 0, this.y0 = 0, this.x1 = 1, this.y1 = 0, this.x2 = 1, this.y2 = 1, this.x3 = 0, this.y3 = 1 } e.exports = n, n.prototype.set = function(t, e, r) { var n = e.width,
						i = e.height;
					r ? (this.x0 = (t.x + t.height) / n, this.y0 = t.y / i, this.x1 = (t.x + t.height) / n, this.y1 = (t.y + t.width) / i, this.x2 = t.x / n, this.y2 = (t.y + t.width) / i, this.x3 = t.x / n, this.y3 = t.y / i) : (this.x0 = t.x / n, this.y0 = t.y / i, this.x1 = (t.x + t.width) / n, this.y1 = t.y / i, this.x2 = (t.x + t.width) / n, this.y2 = (t.y + t.height) / i, this.x3 = t.x / n, this.y3 = (t.y + t.height) / i) } }, {}],
			67: [function(t, e, r) {
				function n(t, e) { if(!t) throw new Error("No video source element specified.");
					(t.readyState === t.HAVE_ENOUGH_DATA || t.readyState === t.HAVE_FUTURE_DATA) && t.width && t.height && (t.complete = !0), o.call(this, t, e), this.autoUpdate = !1, this._onUpdate = this._onUpdate.bind(this), this._onCanPlay = this._onCanPlay.bind(this), t.complete || (t.addEventListener("canplay", this._onCanPlay), t.addEventListener("canplaythrough", this._onCanPlay), t.addEventListener("play", this._onPlayStart.bind(this)), t.addEventListener("pause", this._onPlayStop.bind(this))), this.__loaded = !1 }

				function i(t, e) { e || (e = "video/" + t.substr(t.lastIndexOf(".") + 1)); var r = document.createElement("source"); return r.src = t, r.type = e, r } var o = t("./BaseTexture"),
					s = t("../utils");
				n.prototype = Object.create(o.prototype), n.prototype.constructor = n, e.exports = n, n.prototype._onUpdate = function() { this.autoUpdate && (window.requestAnimationFrame(this._onUpdate), this.update()) }, n.prototype._onPlayStart = function() { this.autoUpdate || (window.requestAnimationFrame(this._onUpdate), this.autoUpdate = !0) }, n.prototype._onPlayStop = function() { this.autoUpdate = !1 }, n.prototype._onCanPlay = function() { this.hasLoaded = !0, this.source && (this.source.removeEventListener("canplay", this._onCanPlay), this.source.removeEventListener("canplaythrough", this._onCanPlay), this.width = this.source.videoWidth, this.height = this.source.videoHeight, this.source.play(), this.__loaded || (this.__loaded = !0, this.emit("loaded", this))) }, n.prototype.destroy = function() { this.source && this.source._pixiId && (delete s.BaseTextureCache[this.source._pixiId], delete this.source._pixiId), o.prototype.destroy.call(this) }, n.fromVideo = function(t, e) { t._pixiId || (t._pixiId = "video_" + s.uid()); var r = s.BaseTextureCache[t._pixiId]; return r || (r = new n(t, e), s.BaseTextureCache[t._pixiId] = r), r }, n.fromUrl = function(t, e) { var r = document.createElement("video"); if(Array.isArray(t))
						for(var o = 0; o < t.length; ++o) r.appendChild(i(t[o].src || t[o], t[o].mime));
					else r.appendChild(i(t.src || t, t.mime)); return r.load(), r.play(), n.fromVideo(r, e) }, n.fromUrls = n.fromUrl }, { "../utils": 70, "./BaseTexture": 63 }],
			68: [function(t, e, r) {
				function n() { var t = this;
					this._tick = function(e) { t._requestId = null, t.started && (t.update(e), t.started && null === t._requestId && t._emitter.listeners(s, !0) && (t._requestId = requestAnimationFrame(t._tick))) }, this._emitter = new o, this._requestId = null, this._maxElapsedMS = 100, this.autoStart = !1, this.deltaTime = 1, this.elapsedMS = 1 / i.TARGET_FPMS, this.lastTime = 0, this.speed = 1, this.started = !1 } var i = t("../const"),
					o = t("eventemitter3"),
					s = "tick";
				Object.defineProperties(n.prototype, { FPS: { get: function() { return 1e3 / this.elapsedMS } }, minFPS: { get: function() { return 1e3 / this._maxElapsedMS }, set: function(t) { var e = Math.min(Math.max(0, t) / 1e3, i.TARGET_FPMS);
							this._maxElapsedMS = 1 / e } } }), n.prototype._requestIfNeeded = function() { null === this._requestId && this._emitter.listeners(s, !0) && (this.lastTime = performance.now(), this._requestId = requestAnimationFrame(this._tick)) }, n.prototype._cancelIfNeeded = function() { null !== this._requestId && (cancelAnimationFrame(this._requestId), this._requestId = null) }, n.prototype._startIfPossible = function() { this.started ? this._requestIfNeeded() : this.autoStart && this.start() }, n.prototype.add = function(t, e) { return this._emitter.on(s, t, e), this._startIfPossible(), this }, n.prototype.addOnce = function(t, e) { return this._emitter.once(s, t, e), this._startIfPossible(), this }, n.prototype.remove = function(t, e) { return this._emitter.off(s, t, e), this._emitter.listeners(s, !0) || this._cancelIfNeeded(), this }, n.prototype.start = function() { this.started || (this.started = !0, this._requestIfNeeded()) }, n.prototype.stop = function() { this.started && (this.started = !1, this._cancelIfNeeded()) }, n.prototype.update = function(t) { var e;
					t = t || performance.now(), e = this.elapsedMS = t - this.lastTime, e > this._maxElapsedMS && (e = this._maxElapsedMS), this.deltaTime = e * i.TARGET_FPMS * this.speed, this._emitter.emit(s, this.deltaTime), this.lastTime = t }, e.exports = n }, { "../const": 16, eventemitter3: 10 }],
			69: [function(t, e, r) { var n = t("./Ticker"),
					i = new n;
				i.autoStart = !0, e.exports = { shared: i, Ticker: n } }, { "./Ticker": 68 }],
			70: [function(t, e, r) { var n = t("../const"),
					i = e.exports = { _uid: 0, _saidHello: !1, EventEmitter: t("eventemitter3"), pluginTarget: t("./pluginTarget"), async: t("async"), uid: function() { return ++i._uid }, hex2rgb: function(t, e) { return e = e || [], e[0] = (t >> 16 & 255) / 255, e[1] = (t >> 8 & 255) / 255, e[2] = (255 & t) / 255, e }, hex2string: function(t) { return t = t.toString(16), t = "000000".substr(0, 6 - t.length) + t, "#" + t }, rgb2hex: function(t) { return(255 * t[0] << 16) + (255 * t[1] << 8) + 255 * t[2] }, canUseNewCanvasBlendModes: function() { if("undefined" == typeof document) return !1; var t = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAABAQMAAADD8p2OAAAAA1BMVEX/",
								e = "AAAACklEQVQI12NgAAAAAgAB4iG8MwAAAABJRU5ErkJggg==",
								r = new Image;
							r.src = t + "AP804Oa6" + e; var n = new Image;
							n.src = t + "/wCKxvRF" + e; var i = document.createElement("canvas");
							i.width = 6, i.height = 1; var o = i.getContext("2d");
							o.globalCompositeOperation = "multiply", o.drawImage(r, 0, 0), o.drawImage(n, 2, 0); var s = o.getImageData(2, 0, 1, 1).data; return 255 === s[0] && 0 === s[1] && 0 === s[2] }, getNextPowerOfTwo: function(t) { if(t > 0 && 0 === (t & t - 1)) return t; for(var e = 1; t > e;) e <<= 1; return e }, isPowerOfTwo: function(t, e) { return t > 0 && 0 === (t & t - 1) && e > 0 && 0 === (e & e - 1) }, getResolutionOfUrl: function(t) { var e = n.RETINA_PREFIX.exec(t); return e ? parseFloat(e[1]) : 1 }, sayHello: function(t) { if(!i._saidHello) { if(navigator.userAgent.toLowerCase().indexOf("chrome") > -1) { var e = ["\n %c %c %c Pixi.js " + n.VERSION + " - ✰ " + t + " ✰  %c  %c    %c %c ♥%c♥%c♥ \n\n", "background: #ff66a5; padding:5px 0;", "background: #ff66a5; padding:5px 0;", "color: #ff66a5; background: #030307; padding:5px 0;", "background: #ff66a5; padding:5px 0;", "background: #ffc3dc; padding:5px 0;", "background: #ff66a5; padding:5px 0;", "color: #ff2424; background: #fff; padding:5px 0;", "color: #ff2424; background: #fff; padding:5px 0;", "color: #ff2424; background: #fff; padding:5px 0;"];
									window.console.log.apply(console, e) } else window.console && window.console.log("Pixi.js " + n.VERSION + " - " + t + " - ");
								i._saidHello = !0 } }, isWebGLSupported: function() { var t = { stencil: !0 }; try { if(!window.WebGLRenderingContext) return !1; var e = document.createElement("canvas"),
									r = e.getContext("webgl", t) || e.getContext("experimental-webgl", t); return !(!r || !r.getContextAttributes().stencil) } catch(n) { return !1 } }, sign: function(t) { return t ? 0 > t ? -1 : 1 : 0 }, removeItems: function(t, e, r) { var n = t.length; if(!(e >= n || 0 === r)) { r = e + r > n ? n - e : r; for(var i = e, o = n - r; o > i; ++i) t[i] = t[i + r];
								t.length = o } }, TextureCache: {}, BaseTextureCache: {} } }, { "../const": 16, "./pluginTarget": 71, async: 1, eventemitter3: 10 }],
			71: [function(t, e, r) {
				function n(t) { t.__plugins = {}, t.registerPlugin = function(e, r) { t.__plugins[e] = r }, t.prototype.initPlugins = function() { this.plugins = this.plugins || {}; for(var e in t.__plugins) this.plugins[e] = new t.__plugins[e](this) }, t.prototype.destroyPlugins = function() { for(var t in this.plugins) this.plugins[t].destroy(), this.plugins[t] = null;
						this.plugins = null } } e.exports = { mixin: function(t) { n(t) } } }, {}],
			72: [function(t, e, r) {
				var n = t("./core"),
					i = t("./mesh"),
					o = t("./extras"),
					s = t("./filters");
				n.SpriteBatch = function() { throw new ReferenceError("SpriteBatch does not exist any more, please use the new ParticleContainer instead.") }, n.AssetLoader = function() { throw new ReferenceError("The loader system was overhauled in pixi v3, please see the new PIXI.loaders.Loader class.") }, Object.defineProperties(n, { Stage: { get: function() { return console.warn("You do not need to use a PIXI Stage any more, you can simply render any container."), n.Container } }, DisplayObjectContainer: { get: function() { return console.warn("DisplayObjectContainer has been shortened to Container, please use Container from now on."), n.Container } }, Strip: { get: function() { return console.warn("The Strip class has been renamed to Mesh and moved to mesh.Mesh, please use mesh.Mesh from now on."), i.Mesh } }, Rope: { get: function() { return console.warn("The Rope class has been moved to mesh.Rope, please use mesh.Rope from now on."), i.Rope } }, MovieClip: { get: function() { return console.warn("The MovieClip class has been moved to extras.MovieClip, please use extras.MovieClip from now on."), o.MovieClip } }, TilingSprite: { get: function() { return console.warn("The TilingSprite class has been moved to extras.TilingSprite, please use extras.TilingSprite from now on."), o.TilingSprite } }, BitmapText: { get: function() { return console.warn("The BitmapText class has been moved to extras.BitmapText, please use extras.BitmapText from now on."), o.BitmapText } }, blendModes: { get: function() { return console.warn("The blendModes has been moved to BLEND_MODES, please use BLEND_MODES from now on."), n.BLEND_MODES } }, scaleModes: { get: function() { return console.warn("The scaleModes has been moved to SCALE_MODES, please use SCALE_MODES from now on."), n.SCALE_MODES } }, BaseTextureCache: { get: function() { return console.warn("The BaseTextureCache class has been moved to utils.BaseTextureCache, please use utils.BaseTextureCache from now on."), n.utils.BaseTextureCache } }, TextureCache: { get: function() { return console.warn("The TextureCache class has been moved to utils.TextureCache, please use utils.TextureCache from now on."), n.utils.TextureCache } }, math: { get: function() { return console.warn("The math namespace is deprecated, please access members already accessible on PIXI."), n } } }), n.Sprite.prototype.setTexture = function(t) { this.texture = t, console.warn("setTexture is now deprecated, please use the texture property, e.g : sprite.texture = texture;") }, o.BitmapText.prototype.setText = function(t) { this.text = t, console.warn("setText is now deprecated, please use the text property, e.g : myBitmapText.text = 'my text';") }, n.Text.prototype.setText = function(t) { this.text = t, console.warn("setText is now deprecated, please use the text property, e.g : myText.text = 'my text';") }, n.Text.prototype.setStyle = function(t) { this.style = t, console.warn("setStyle is now deprecated, please use the style property, e.g : myText.style = style;") }, n.Texture.prototype.setFrame = function(t) { this.frame = t, console.warn("setFrame is now deprecated, please use the frame property, e.g : myTexture.frame = frame;") }, Object.defineProperties(s, {
					AbstractFilter: { get: function() { return console.warn("filters.AbstractFilter is an undocumented alias, please use AbstractFilter from now on."), n.AbstractFilter } },
					FXAAFilter: {
						get: function() {
							return console.warn("filters.FXAAFilter is an undocumented alias, please use FXAAFilter from now on."), n.FXAAFilter
						}
					},
					SpriteMaskFilter: { get: function() { return console.warn("filters.SpriteMaskFilter is an undocumented alias, please use SpriteMaskFilter from now on."), n.SpriteMaskFilter } }
				}), n.utils.uuid = function() { return console.warn("utils.uuid() is deprecated, please use utils.uid() from now on."), n.utils.uid() }
			}, { "./core": 23, "./extras": 79, "./filters": 96, "./mesh": 121 }],
			73: [function(t, e, r) {
				function n(t, e) { i.Container.call(this), e = e || {}, this.textWidth = 0, this.textHeight = 0, this._glyphs = [], this._font = { tint: void 0 !== e.tint ? e.tint : 16777215, align: e.align || "left", name: null, size: 0 }, this.font = e.font, this._text = t, this.maxWidth = 0, this.maxLineHeight = 0, this.dirty = !1, this.updateText() } var i = t("../core");
				n.prototype = Object.create(i.Container.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { tint: { get: function() { return this._font.tint }, set: function(t) { this._font.tint = "number" == typeof t && t >= 0 ? t : 16777215, this.dirty = !0 } }, align: { get: function() { return this._font.align }, set: function(t) { this._font.align = t || "left", this.dirty = !0 } }, font: { get: function() { return this._font }, set: function(t) { t && ("string" == typeof t ? (t = t.split(" "), this._font.name = 1 === t.length ? t[0] : t.slice(1).join(" "), this._font.size = t.length >= 2 ? parseInt(t[0], 10) : n.fonts[this._font.name].size) : (this._font.name = t.name, this._font.size = "number" == typeof t.size ? t.size : parseInt(t.size, 10)), this.dirty = !0) } }, text: { get: function() { return this._text }, set: function(t) { t = t.toString() || " ", this._text !== t && (this._text = t, this.dirty = !0) } } }), n.prototype.updateText = function() { for(var t = n.fonts[this._font.name], e = new i.Point, r = null, o = [], s = 0, a = 0, l = [], u = 0, h = this._font.size / t.size, c = -1, p = 0, d = 0; d < this.text.length; d++) { var f = this.text.charCodeAt(d); if(c = /(\s)/.test(this.text.charAt(d)) ? d : c, /(?:\r\n|\r|\n)/.test(this.text.charAt(d))) l.push(s), a = Math.max(a, s), u++, e.x = 0, e.y += t.lineHeight, r = null;
						else if(-1 !== c && this.maxWidth > 0 && e.x * h > this.maxWidth) i.utils.removeItems(o, c, d - c), d = c, c = -1, l.push(s), a = Math.max(a, s), u++, e.x = 0, e.y += t.lineHeight, r = null;
						else { var v = t.chars[f];
							v && (r && v.kerning[r] && (e.x += v.kerning[r]), o.push({ texture: v.texture, line: u, charCode: f, position: new i.Point(e.x + v.xOffset, e.y + v.yOffset) }), s = e.x + (v.texture.width + v.xOffset), e.x += v.xAdvance, p = Math.max(p, v.yOffset + v.texture.height), r = f) } } l.push(s), a = Math.max(a, s); var g = []; for(d = 0; u >= d; d++) { var m = 0; "right" === this._font.align ? m = a - l[d] : "center" === this._font.align && (m = (a - l[d]) / 2), g.push(m) } var y = o.length,
						T = this.tint; for(d = 0; y > d; d++) { var x = this._glyphs[d];
						x ? x.texture = o[d].texture : (x = new i.Sprite(o[d].texture), this._glyphs.push(x)), x.position.x = (o[d].position.x + g[o[d].line]) * h, x.position.y = o[d].position.y * h, x.scale.x = x.scale.y = h, x.tint = T, x.parent || this.addChild(x) } for(d = y; d < this._glyphs.length; ++d) this.removeChild(this._glyphs[d]);
					this.textWidth = a * h, this.textHeight = (e.y + t.lineHeight) * h, this.maxLineHeight = p * h }, n.prototype.updateTransform = function() { this.validate(), this.containerUpdateTransform() }, n.prototype.getLocalBounds = function() { return this.validate(), i.Container.prototype.getLocalBounds.call(this) }, n.prototype.validate = function() { this.dirty && (this.updateText(), this.dirty = !1) }, n.fonts = {} }, { "../core": 23 }],
			74: [function(t, e, r) {
				function n(t) { i.Sprite.call(this, t[0] instanceof i.Texture ? t[0] : t[0].texture), this._textures = null, this._durations = null, this.textures = t, this.animationSpeed = 1, this.loop = !0, this.onComplete = null, this._currentTime = 0, this.playing = !1 } var i = t("../core");
				n.prototype = Object.create(i.Sprite.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { totalFrames: { get: function() { return this._textures.length } }, textures: { get: function() { return this._textures }, set: function(t) { if(t[0] instanceof i.Texture) this._textures = t, this._durations = null;
							else { this._textures = [], this._durations = []; for(var e = 0; e < t.length; e++) this._textures.push(t[e].texture), this._durations.push(t[e].time) } } }, currentFrame: { get: function() { var t = Math.floor(this._currentTime) % this._textures.length; return 0 > t && (t += this._textures.length), t } } }), n.prototype.stop = function() { this.playing && (this.playing = !1, i.ticker.shared.remove(this.update, this)) }, n.prototype.play = function() { this.playing || (this.playing = !0, i.ticker.shared.add(this.update, this)) }, n.prototype.gotoAndStop = function(t) { this.stop(), this._currentTime = t, this._texture = this._textures[this.currentFrame] }, n.prototype.gotoAndPlay = function(t) { this._currentTime = t, this.play() }, n.prototype.update = function(t) { var e = this.animationSpeed * t; if(null !== this._durations) { var r = this._currentTime % 1 * this._durations[this.currentFrame]; for(r += e / 60 * 1e3; 0 > r;) this._currentTime--, r += this._durations[this.currentFrame]; var n = Math.sign(this.animationSpeed * t); for(this._currentTime = Math.floor(this._currentTime); r >= this._durations[this.currentFrame];) r -= this._durations[this.currentFrame] * n, this._currentTime += n;
						this._currentTime += r / this._durations[this.currentFrame] } else this._currentTime += e;
					this._currentTime < 0 && !this.loop ? (this.gotoAndStop(0), this.onComplete && this.onComplete()) : this._currentTime >= this._textures.length && !this.loop ? (this.gotoAndStop(this._textures.length - 1), this.onComplete && this.onComplete()) : this._texture = this._textures[this.currentFrame] }, n.prototype.destroy = function() { this.stop(), i.Sprite.prototype.destroy.call(this) }, n.fromFrames = function(t) { for(var e = [], r = 0; r < t.length; ++r) e.push(new i.Texture.fromFrame(t[r])); return new n(e) }, n.fromImages = function(t) { for(var e = [], r = 0; r < t.length; ++r) e.push(new i.Texture.fromImage(t[r])); return new n(e) } }, { "../core": 23 }],
			75: [function(t, e, r) {
				function n(t, e, r) { i.Sprite.call(this, t), this.tileScale = new i.Point(1, 1), this.tilePosition = new i.Point(0, 0), this._width = e || 100, this._height = r || 100, this._uvs = new i.TextureUvs, this._canvasPattern = null, this.shader = new i.AbstractFilter(["precision lowp float;", "attribute vec2 aVertexPosition;", "attribute vec2 aTextureCoord;", "attribute vec4 aColor;", "uniform mat3 projectionMatrix;", "uniform vec4 uFrame;", "uniform vec4 uTransform;", "varying vec2 vTextureCoord;", "varying vec4 vColor;", "void main(void){", "   gl_Position = vec4((projectionMatrix * vec3(aVertexPosition, 1.0)).xy, 0.0, 1.0);", "   vec2 coord = aTextureCoord;", "   coord -= uTransform.xy;", "   coord /= uTransform.zw;", "   vTextureCoord = coord;", "   vColor = vec4(aColor.rgb * aColor.a, aColor.a);", "}"].join("\n"), ["precision lowp float;", "varying vec2 vTextureCoord;", "varying vec4 vColor;", "uniform sampler2D uSampler;", "uniform vec4 uFrame;", "uniform vec2 uPixelSize;", "void main(void){", "   vec2 coord = mod(vTextureCoord, uFrame.zw);", "   coord = clamp(coord, uPixelSize, uFrame.zw - uPixelSize);", "   coord += uFrame.xy;", "   gl_FragColor =  texture2D(uSampler, coord) * vColor ;", "}"].join("\n"), { uFrame: { type: "4fv", value: [0, 0, 1, 1] }, uTransform: { type: "4fv", value: [0, 0, 1, 1] }, uPixelSize: { type: "2fv", value: [1, 1] } }) } var i = t("../core"),
					o = new i.Point,
					s = t("../core/renderers/canvas/utils/CanvasTinter");
				n.prototype = Object.create(i.Sprite.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { width: { get: function() { return this._width }, set: function(t) { this._width = t } }, height: { get: function() { return this._height }, set: function(t) { this._height = t } } }), n.prototype._onTextureUpdate = function() {}, n.prototype._renderWebGL = function(t) { var e = this._texture; if(e && e._uvs) { var r = e._uvs,
							n = e._frame.width,
							i = e._frame.height,
							o = e.baseTexture.width,
							s = e.baseTexture.height;
						e._uvs = this._uvs, e._frame.width = this.width, e._frame.height = this.height, this.shader.uniforms.uPixelSize.value[0] = 1 / o, this.shader.uniforms.uPixelSize.value[1] = 1 / s, this.shader.uniforms.uFrame.value[0] = r.x0, this.shader.uniforms.uFrame.value[1] = r.y0, this.shader.uniforms.uFrame.value[2] = r.x1 - r.x0, this.shader.uniforms.uFrame.value[3] = r.y2 - r.y0, this.shader.uniforms.uTransform.value[0] = this.tilePosition.x % (n * this.tileScale.x) / this._width, this.shader.uniforms.uTransform.value[1] = this.tilePosition.y % (i * this.tileScale.y) / this._height, this.shader.uniforms.uTransform.value[2] = o / this._width * this.tileScale.x, this.shader.uniforms.uTransform.value[3] = s / this._height * this.tileScale.y, t.setObjectRenderer(t.plugins.sprite), t.plugins.sprite.render(this), e._uvs = r, e._frame.width = n, e._frame.height = i } }, n.prototype._renderCanvas = function(t) { var e = this._texture; if(e.baseTexture.hasLoaded) { var r = t.context,
							n = this.worldTransform,
							o = t.resolution,
							a = e.baseTexture,
							l = this.tilePosition.x / this.tileScale.x % e._frame.width,
							u = this.tilePosition.y / this.tileScale.y % e._frame.height; if(!this._canvasPattern) { var h = new i.CanvasBuffer(e._frame.width, e._frame.height);
							16777215 !== this.tint ? (this.cachedTint !== this.tint && (this.cachedTint = this.tint, this.tintedTexture = s.getTintedTexture(this, this.tint)), h.context.drawImage(this.tintedTexture, 0, 0)) : h.context.drawImage(a.source, -e._frame.x, -e._frame.y), this._canvasPattern = h.context.createPattern(h.canvas, "repeat") } r.globalAlpha = this.worldAlpha, r.setTransform(n.a * o, n.b * o, n.c * o, n.d * o, n.tx * o, n.ty * o), r.scale(this.tileScale.x, this.tileScale.y), r.translate(l + this.anchor.x * -this._width, u + this.anchor.y * -this._height); var c = t.blendModes[this.blendMode];
						c !== t.context.globalCompositeOperation && (r.globalCompositeOperation = c), r.fillStyle = this._canvasPattern, r.fillRect(-l, -u, this._width / this.tileScale.x, this._height / this.tileScale.y) } }, n.prototype.getBounds = function() { var t, e, r, n, i = this._width,
						o = this._height,
						s = i * (1 - this.anchor.x),
						a = i * -this.anchor.x,
						l = o * (1 - this.anchor.y),
						u = o * -this.anchor.y,
						h = this.worldTransform,
						c = h.a,
						p = h.b,
						d = h.c,
						f = h.d,
						v = h.tx,
						g = h.ty,
						m = c * a + d * u + v,
						y = f * u + p * a + g,
						T = c * s + d * u + v,
						x = f * u + p * s + g,
						b = c * s + d * l + v,
						S = f * l + p * s + g,
						E = c * a + d * l + v,
						A = f * l + p * a + g;
					t = m, t = t > T ? T : t, t = t > b ? b : t, t = t > E ? E : t, r = y, r = r > x ? x : r, r = r > S ? S : r, r = r > A ? A : r, e = m, e = T > e ? T : e, e = b > e ? b : e, e = E > e ? E : e, n = y, n = x > n ? x : n, n = S > n ? S : n, n = A > n ? A : n; var _ = this._bounds; return _.x = t, _.width = e - t, _.y = r, _.height = n - r, this._currentBounds = _, _ }, n.prototype.containsPoint = function(t) { this.worldTransform.applyInverse(t, o); var e, r = this._width,
						n = this._height,
						i = -r * this.anchor.x; return o.x > i && o.x < i + r && (e = -n * this.anchor.y, o.y > e && o.y < e + n) ? !0 : !1 }, n.prototype.destroy = function() { i.Sprite.prototype.destroy.call(this), this.tileScale = null, this._tileScaleOffset = null, this.tilePosition = null, this._uvs = null }, n.fromFrame = function(t, e, r) { var o = i.utils.TextureCache[t]; if(!o) throw new Error('The frameId "' + t + '" does not exist in the texture cache ' + this); return new n(o, e, r) }, n.fromImage = function(t, e, r, o, s) { return new n(i.Texture.fromImage(t, o, s), e, r) } }, { "../core": 23, "../core/renderers/canvas/utils/CanvasTinter": 41 }],
			76: [function(t, e, r) { var n = t("../core"),
					i = n.DisplayObject,
					o = new n.Matrix;
				i.prototype._cacheAsBitmap = !1, i.prototype._originalRenderWebGL = null, i.prototype._originalRenderCanvas = null, i.prototype._originalUpdateTransform = null, i.prototype._originalHitTest = null, i.prototype._originalDestroy = null, i.prototype._cachedSprite = null, Object.defineProperties(i.prototype, { cacheAsBitmap: { get: function() { return this._cacheAsBitmap }, set: function(t) { this._cacheAsBitmap !== t && (this._cacheAsBitmap = t, t ? (this._originalRenderWebGL = this.renderWebGL, this._originalRenderCanvas = this.renderCanvas, this._originalUpdateTransform = this.updateTransform, this._originalGetBounds = this.getBounds, this._originalDestroy = this.destroy, this._originalContainsPoint = this.containsPoint, this.renderWebGL = this._renderCachedWebGL, this.renderCanvas = this._renderCachedCanvas, this.destroy = this._cacheAsBitmapDestroy) : (this._cachedSprite && this._destroyCachedDisplayObject(), this.renderWebGL = this._originalRenderWebGL, this.renderCanvas = this._originalRenderCanvas, this.getBounds = this._originalGetBounds, this.destroy = this._originalDestroy, this.updateTransform = this._originalUpdateTransform, this.containsPoint = this._originalContainsPoint)) } } }), i.prototype._renderCachedWebGL = function(t) {!this.visible || this.worldAlpha <= 0 || !this.renderable || (this._initCachedDisplayObject(t), this._cachedSprite.worldAlpha = this.worldAlpha, t.setObjectRenderer(t.plugins.sprite), t.plugins.sprite.render(this._cachedSprite)) }, i.prototype._initCachedDisplayObject = function(t) { if(!this._cachedSprite) { t.currentRenderer.flush(); var e = this.getLocalBounds().clone(); if(this._filters) { var r = this._filters[0].padding;
							e.x -= r, e.y -= r, e.width += 2 * r, e.height += 2 * r } var i = t.currentRenderTarget,
							s = t.filterManager.filterStack,
							a = new n.RenderTexture(t, 0 | e.width, 0 | e.height),
							l = o;
						l.tx = -e.x, l.ty = -e.y, this.renderWebGL = this._originalRenderWebGL, a.render(this, l, !0, !0), t.setRenderTarget(i), t.filterManager.filterStack = s, this.renderWebGL = this._renderCachedWebGL, this.updateTransform = this.displayObjectUpdateTransform, this.getBounds = this._getCachedBounds, this._cachedSprite = new n.Sprite(a), this._cachedSprite.worldTransform = this.worldTransform, this._cachedSprite.anchor.x = -(e.x / e.width), this._cachedSprite.anchor.y = -(e.y / e.height), this.updateTransform(), this.containsPoint = this._cachedSprite.containsPoint.bind(this._cachedSprite) } }, i.prototype._renderCachedCanvas = function(t) {!this.visible || this.worldAlpha <= 0 || !this.renderable || (this._initCachedDisplayObjectCanvas(t), this._cachedSprite.worldAlpha = this.worldAlpha, this._cachedSprite.renderCanvas(t)) }, i.prototype._initCachedDisplayObjectCanvas = function(t) { if(!this._cachedSprite) { var e = this.getLocalBounds(),
							r = t.context,
							i = new n.RenderTexture(t, 0 | e.width, 0 | e.height),
							s = o;
						s.tx = -e.x, s.ty = -e.y, this.renderCanvas = this._originalRenderCanvas, i.render(this, s, !0), t.context = r, this.renderCanvas = this._renderCachedCanvas, this.updateTransform = this.displayObjectUpdateTransform, this.getBounds = this._getCachedBounds, this._cachedSprite = new n.Sprite(i), this._cachedSprite.worldTransform = this.worldTransform, this._cachedSprite.anchor.x = -(e.x / e.width), this._cachedSprite.anchor.y = -(e.y / e.height), this.updateTransform(), this.containsPoint = this._cachedSprite.containsPoint.bind(this._cachedSprite) } }, i.prototype._getCachedBounds = function() { return this._cachedSprite._currentBounds = null, this._cachedSprite.getBounds() }, i.prototype._destroyCachedDisplayObject = function() { this._cachedSprite._texture.destroy(), this._cachedSprite = null }, i.prototype._cacheAsBitmapDestroy = function() { this.cacheAsBitmap = !1, this._originalDestroy() } }, { "../core": 23 }],
			77: [function(t, e, r) { var n = t("../core");
				n.DisplayObject.prototype.name = null, n.Container.prototype.getChildByName = function(t) { for(var e = 0; e < this.children.length; e++)
						if(this.children[e].name === t) return this.children[e]; return null } }, { "../core": 23 }],
			78: [function(t, e, r) { var n = t("../core");
				n.DisplayObject.prototype.getGlobalPosition = function(t) { return t = t || new n.Point, this.parent ? (this.displayObjectUpdateTransform(), t.x = this.worldTransform.tx, t.y = this.worldTransform.ty) : (t.x = this.position.x, t.y = this.position.y), t } }, { "../core": 23 }],
			79: [function(t, e, r) { t("./cacheAsBitmap"), t("./getChildByName"), t("./getGlobalPosition"), e.exports = { MovieClip: t("./MovieClip"), TilingSprite: t("./TilingSprite"), BitmapText: t("./BitmapText") } }, { "./BitmapText": 73, "./MovieClip": 74, "./TilingSprite": 75, "./cacheAsBitmap": 76, "./getChildByName": 77, "./getGlobalPosition": 78 }],
			80: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nuniform vec4 dimensions;\nuniform float pixelSize;\nuniform sampler2D uSampler;\n\nfloat character(float n, vec2 p)\n{\n    p = floor(p*vec2(4.0, -4.0) + 2.5);\n    if (clamp(p.x, 0.0, 4.0) == p.x && clamp(p.y, 0.0, 4.0) == p.y)\n    {\n        if (int(mod(n/exp2(p.x + 5.0*p.y), 2.0)) == 1) return 1.0;\n    }\n    return 0.0;\n}\n\nvoid main()\n{\n    vec2 uv = gl_FragCoord.xy;\n\n    vec3 col = texture2D(uSampler, floor( uv / pixelSize ) * pixelSize / dimensions.xy).rgb;\n\n    float gray = (col.r + col.g + col.b) / 3.0;\n\n    float n =  65536.0;             // .\n    if (gray > 0.2) n = 65600.0;    // :\n    if (gray > 0.3) n = 332772.0;   // *\n    if (gray > 0.4) n = 15255086.0; // o\n    if (gray > 0.5) n = 23385164.0; // &\n    if (gray > 0.6) n = 15252014.0; // 8\n    if (gray > 0.7) n = 13199452.0; // @\n    if (gray > 0.8) n = 11512810.0; // #\n\n    vec2 p = mod( uv / ( pixelSize * 0.5 ), 2.0) - vec2(1.0);\n    col = col * character(n, p);\n\n    gl_FragColor = vec4(col, 1.0);\n}\n", { dimensions: { type: "4fv", value: new Float32Array([0, 0, 0, 0]) }, pixelSize: { type: "1f", value: 8 } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { size: { get: function() { return this.uniforms.pixelSize.value }, set: function(t) { this.uniforms.pixelSize.value = t } } }) }, { "../../core": 23 }],
			81: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this), this.blurXFilter = new o, this.blurYFilter = new s, this.defaultFilter = new i.AbstractFilter } var i = t("../../core"),
					o = t("../blur/BlurXFilter"),
					s = t("../blur/BlurYFilter");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r) { var n = t.filterManager.getRenderTarget(!0);
					this.defaultFilter.applyFilter(t, e, r), this.blurXFilter.applyFilter(t, e, n), t.blendModeManager.setBlendMode(i.BLEND_MODES.SCREEN), this.blurYFilter.applyFilter(t, n, r), t.blendModeManager.setBlendMode(i.BLEND_MODES.NORMAL), t.filterManager.returnRenderTarget(n) }, Object.defineProperties(n.prototype, { blur: { get: function() { return this.blurXFilter.blur }, set: function(t) { this.blurXFilter.blur = this.blurYFilter.blur = t } }, blurX: { get: function() { return this.blurXFilter.blur }, set: function(t) { this.blurXFilter.blur = t } }, blurY: { get: function() { return this.blurYFilter.blur }, set: function(t) { this.blurYFilter.blur = t } } }) }, { "../../core": 23, "../blur/BlurXFilter": 84, "../blur/BlurYFilter": 85 }],
			82: [function(t, e, r) {
				function n(t, e) { i.AbstractFilter.call(this, "attribute vec2 aVertexPosition;\nattribute vec2 aTextureCoord;\nattribute vec4 aColor;\n\nuniform float strength;\nuniform float dirX;\nuniform float dirY;\nuniform mat3 projectionMatrix;\n\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\nvarying vec2 vBlurTexCoords[3];\n\nvoid main(void)\n{\n    gl_Position = vec4((projectionMatrix * vec3((aVertexPosition), 1.0)).xy, 0.0, 1.0);\n    vTextureCoord = aTextureCoord;\n\n    vBlurTexCoords[0] = aTextureCoord + vec2( (0.004 * strength) * dirX, (0.004 * strength) * dirY );\n    vBlurTexCoords[1] = aTextureCoord + vec2( (0.008 * strength) * dirX, (0.008 * strength) * dirY );\n    vBlurTexCoords[2] = aTextureCoord + vec2( (0.012 * strength) * dirX, (0.012 * strength) * dirY );\n\n    vColor = vec4(aColor.rgb * aColor.a, aColor.a);\n}\n", "precision lowp float;\n\nvarying vec2 vTextureCoord;\nvarying vec2 vBlurTexCoords[3];\nvarying vec4 vColor;\n\nuniform sampler2D uSampler;\n\nvoid main(void)\n{\n    gl_FragColor = vec4(0.0);\n\n    gl_FragColor += texture2D(uSampler, vTextureCoord     ) * 0.3989422804014327;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 0]) * 0.2419707245191454;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 1]) * 0.05399096651318985;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 2]) * 0.004431848411938341;\n}\n", { strength: { type: "1f", value: 1 }, dirX: { type: "1f", value: t || 0 }, dirY: { type: "1f", value: e || 0 } }), this.defaultFilter = new i.AbstractFilter, this.passes = 1, this.dirX = t || 0, this.dirY = e || 0, this.strength = 4 } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r, n) { var i = this.getShader(t); if(this.uniforms.strength.value = this.strength / 4 / this.passes * (e.frame.width / e.size.width), 1 === this.passes) t.filterManager.applyFilter(i, e, r, n);
					else { var o = t.filterManager.getRenderTarget(!0);
						t.filterManager.applyFilter(i, e, o, n); for(var s = 0; s < this.passes - 2; s++) t.filterManager.applyFilter(i, o, o, n);
						t.filterManager.applyFilter(i, o, r, n), t.filterManager.returnRenderTarget(o) } }, Object.defineProperties(n.prototype, { blur: { get: function() { return this.strength }, set: function(t) { this.padding = .5 * t, this.strength = t } }, dirX: { get: function() { return this.dirX }, set: function(t) { this.uniforms.dirX.value = t } }, dirY: { get: function() { return this.dirY }, set: function(t) { this.uniforms.dirY.value = t } } }) }, { "../../core": 23 }],
			83: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this), this.blurXFilter = new o, this.blurYFilter = new s } var i = t("../../core"),
					o = t("./BlurXFilter"),
					s = t("./BlurYFilter");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r) { var n = t.filterManager.getRenderTarget(!0);
					this.blurXFilter.applyFilter(t, e, n), this.blurYFilter.applyFilter(t, n, r), t.filterManager.returnRenderTarget(n) }, Object.defineProperties(n.prototype, { blur: { get: function() { return this.blurXFilter.blur }, set: function(t) { this.padding = .5 * Math.abs(t), this.blurXFilter.blur = this.blurYFilter.blur = t } }, passes: { get: function() { return this.blurXFilter.passes }, set: function(t) { this.blurXFilter.passes = this.blurYFilter.passes = t } }, blurX: { get: function() { return this.blurXFilter.blur }, set: function(t) { this.blurXFilter.blur = t } }, blurY: { get: function() { return this.blurYFilter.blur }, set: function(t) { this.blurYFilter.blur = t } } }) }, { "../../core": 23, "./BlurXFilter": 84, "./BlurYFilter": 85 }],
			84: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, "attribute vec2 aVertexPosition;\nattribute vec2 aTextureCoord;\nattribute vec4 aColor;\n\nuniform float strength;\nuniform mat3 projectionMatrix;\n\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\nvarying vec2 vBlurTexCoords[6];\n\nvoid main(void)\n{\n    gl_Position = vec4((projectionMatrix * vec3((aVertexPosition), 1.0)).xy, 0.0, 1.0);\n    vTextureCoord = aTextureCoord;\n\n    vBlurTexCoords[ 0] = aTextureCoord + vec2(-0.012 * strength, 0.0);\n    vBlurTexCoords[ 1] = aTextureCoord + vec2(-0.008 * strength, 0.0);\n    vBlurTexCoords[ 2] = aTextureCoord + vec2(-0.004 * strength, 0.0);\n    vBlurTexCoords[ 3] = aTextureCoord + vec2( 0.004 * strength, 0.0);\n    vBlurTexCoords[ 4] = aTextureCoord + vec2( 0.008 * strength, 0.0);\n    vBlurTexCoords[ 5] = aTextureCoord + vec2( 0.012 * strength, 0.0);\n\n    vColor = vec4(aColor.rgb * aColor.a, aColor.a);\n}\n", "precision lowp float;\n\nvarying vec2 vTextureCoord;\nvarying vec2 vBlurTexCoords[6];\nvarying vec4 vColor;\n\nuniform sampler2D uSampler;\n\nvoid main(void)\n{\n    gl_FragColor = vec4(0.0);\n\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 0])*0.004431848411938341;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 1])*0.05399096651318985;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 2])*0.2419707245191454;\n    gl_FragColor += texture2D(uSampler, vTextureCoord     )*0.3989422804014327;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 3])*0.2419707245191454;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 4])*0.05399096651318985;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 5])*0.004431848411938341;\n}\n", { strength: { type: "1f", value: 1 } }), this.passes = 1, this.strength = 4 } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r, n) { var i = this.getShader(t); if(this.uniforms.strength.value = this.strength / 4 / this.passes * (e.frame.width / e.size.width), 1 === this.passes) t.filterManager.applyFilter(i, e, r, n);
					else { for(var o = t.filterManager.getRenderTarget(!0), s = e, a = o, l = 0; l < this.passes - 1; l++) { t.filterManager.applyFilter(i, s, a, !0); var u = a;
							a = s, s = u } t.filterManager.applyFilter(i, s, r, n), t.filterManager.returnRenderTarget(o) } }, Object.defineProperties(n.prototype, { blur: { get: function() { return this.strength }, set: function(t) { this.padding = .5 * Math.abs(t), this.strength = t } } }) }, { "../../core": 23 }],
			85: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, "attribute vec2 aVertexPosition;\nattribute vec2 aTextureCoord;\nattribute vec4 aColor;\n\nuniform float strength;\nuniform mat3 projectionMatrix;\n\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\nvarying vec2 vBlurTexCoords[6];\n\nvoid main(void)\n{\n    gl_Position = vec4((projectionMatrix * vec3((aVertexPosition), 1.0)).xy, 0.0, 1.0);\n    vTextureCoord = aTextureCoord;\n\n    vBlurTexCoords[ 0] = aTextureCoord + vec2(0.0, -0.012 * strength);\n    vBlurTexCoords[ 1] = aTextureCoord + vec2(0.0, -0.008 * strength);\n    vBlurTexCoords[ 2] = aTextureCoord + vec2(0.0, -0.004 * strength);\n    vBlurTexCoords[ 3] = aTextureCoord + vec2(0.0,  0.004 * strength);\n    vBlurTexCoords[ 4] = aTextureCoord + vec2(0.0,  0.008 * strength);\n    vBlurTexCoords[ 5] = aTextureCoord + vec2(0.0,  0.012 * strength);\n\n   vColor = vec4(aColor.rgb * aColor.a, aColor.a);\n}\n", "precision lowp float;\n\nvarying vec2 vTextureCoord;\nvarying vec2 vBlurTexCoords[6];\nvarying vec4 vColor;\n\nuniform sampler2D uSampler;\n\nvoid main(void)\n{\n    gl_FragColor = vec4(0.0);\n\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 0])*0.004431848411938341;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 1])*0.05399096651318985;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 2])*0.2419707245191454;\n    gl_FragColor += texture2D(uSampler, vTextureCoord     )*0.3989422804014327;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 3])*0.2419707245191454;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 4])*0.05399096651318985;\n    gl_FragColor += texture2D(uSampler, vBlurTexCoords[ 5])*0.004431848411938341;\n}\n", { strength: { type: "1f", value: 1 } }), this.passes = 1, this.strength = 4 } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r, n) { var i = this.getShader(t); if(this.uniforms.strength.value = Math.abs(this.strength) / 4 / this.passes * (e.frame.height / e.size.height), 1 === this.passes) t.filterManager.applyFilter(i, e, r, n);
					else { for(var o = t.filterManager.getRenderTarget(!0), s = e, a = o, l = 0; l < this.passes - 1; l++) { t.filterManager.applyFilter(i, s, a, !0); var u = a;
							a = s, s = u } t.filterManager.applyFilter(i, s, r, n), t.filterManager.returnRenderTarget(o) } }, Object.defineProperties(n.prototype, { blur: { get: function() { return this.strength }, set: function(t) { this.padding = .5 * Math.abs(t), this.strength = t } } }) }, { "../../core": 23 }],
			86: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\n\nuniform sampler2D uSampler;\nuniform vec2 delta;\n\nfloat random(vec3 scale, float seed)\n{\n    return fract(sin(dot(gl_FragCoord.xyz + seed, scale)) * 43758.5453 + seed);\n}\n\nvoid main(void)\n{\n    vec4 color = vec4(0.0);\n    float total = 0.0;\n\n    float offset = random(vec3(12.9898, 78.233, 151.7182), 0.0);\n\n    for (float t = -30.0; t <= 30.0; t++)\n    {\n        float percent = (t + offset - 0.5) / 30.0;\n        float weight = 1.0 - abs(percent);\n        vec4 sample = texture2D(uSampler, vTextureCoord + delta * percent);\n        sample.rgb *= sample.a;\n        color += sample * weight;\n        total += weight;\n    }\n\n    gl_FragColor = color / total;\n    gl_FragColor.rgb /= gl_FragColor.a + 0.00001;\n}\n", { delta: { type: "v2", value: { x: .1, y: 0 } } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n }, { "../../core": 23 }],
			87: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\nuniform sampler2D uSampler;\nuniform float m[25];\n\nvoid main(void)\n{\n\n    vec4 c = texture2D(uSampler, vTextureCoord);\n\n    gl_FragColor.r = (m[0] * c.r);\n        gl_FragColor.r += (m[1] * c.g);\n        gl_FragColor.r += (m[2] * c.b);\n        gl_FragColor.r += (m[3] * c.a);\n        gl_FragColor.r += m[4];\n\n    gl_FragColor.g = (m[5] * c.r);\n        gl_FragColor.g += (m[6] * c.g);\n        gl_FragColor.g += (m[7] * c.b);\n        gl_FragColor.g += (m[8] * c.a);\n        gl_FragColor.g += m[9];\n\n     gl_FragColor.b = (m[10] * c.r);\n        gl_FragColor.b += (m[11] * c.g);\n        gl_FragColor.b += (m[12] * c.b);\n        gl_FragColor.b += (m[13] * c.a);\n        gl_FragColor.b += m[14];\n\n     gl_FragColor.a = (m[15] * c.r);\n        gl_FragColor.a += (m[16] * c.g);\n        gl_FragColor.a += (m[17] * c.b);\n        gl_FragColor.a += (m[18] * c.a);\n        gl_FragColor.a += m[19];\n\n}\n", { m: { type: "1fv", value: [1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0] } }) }
				var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype._loadMatrix = function(t, e) { e = !!e; var r = t;
					e && (this._multiply(r, this.uniforms.m.value, t), r = this._colorMatrix(r)), this.uniforms.m.value = r }, n.prototype._multiply = function(t, e, r) { return t[0] = e[0] * r[0] + e[1] * r[5] + e[2] * r[10] + e[3] * r[15], t[1] = e[0] * r[1] + e[1] * r[6] + e[2] * r[11] + e[3] * r[16], t[2] = e[0] * r[2] + e[1] * r[7] + e[2] * r[12] + e[3] * r[17], t[3] = e[0] * r[3] + e[1] * r[8] + e[2] * r[13] + e[3] * r[18], t[4] = e[0] * r[4] + e[1] * r[9] + e[2] * r[14] + e[3] * r[19], t[5] = e[5] * r[0] + e[6] * r[5] + e[7] * r[10] + e[8] * r[15], t[6] = e[5] * r[1] + e[6] * r[6] + e[7] * r[11] + e[8] * r[16], t[7] = e[5] * r[2] + e[6] * r[7] + e[7] * r[12] + e[8] * r[17], t[8] = e[5] * r[3] + e[6] * r[8] + e[7] * r[13] + e[8] * r[18], t[9] = e[5] * r[4] + e[6] * r[9] + e[7] * r[14] + e[8] * r[19], t[10] = e[10] * r[0] + e[11] * r[5] + e[12] * r[10] + e[13] * r[15], t[11] = e[10] * r[1] + e[11] * r[6] + e[12] * r[11] + e[13] * r[16], t[12] = e[10] * r[2] + e[11] * r[7] + e[12] * r[12] + e[13] * r[17], t[13] = e[10] * r[3] + e[11] * r[8] + e[12] * r[13] + e[13] * r[18], t[14] = e[10] * r[4] + e[11] * r[9] + e[12] * r[14] + e[13] * r[19], t[15] = e[15] * r[0] + e[16] * r[5] + e[17] * r[10] + e[18] * r[15], t[16] = e[15] * r[1] + e[16] * r[6] + e[17] * r[11] + e[18] * r[16], t[17] = e[15] * r[2] + e[16] * r[7] + e[17] * r[12] + e[18] * r[17], t[18] = e[15] * r[3] + e[16] * r[8] + e[17] * r[13] + e[18] * r[18], t[19] = e[15] * r[4] + e[16] * r[9] + e[17] * r[14] + e[18] * r[19], t }, n.prototype._colorMatrix = function(t) { var e = new Float32Array(t); return e[4] /= 255, e[9] /= 255, e[14] /= 255, e[19] /= 255, e }, n.prototype.brightness = function(t, e) { var r = [t, 0, 0, 0, 0, 0, t, 0, 0, 0, 0, 0, t, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(r, e) }, n.prototype.greyscale = function(t, e) { var r = [t, t, t, 0, 0, t, t, t, 0, 0, t, t, t, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(r, e) }, n.prototype.grayscale = n.prototype.greyscale, n.prototype.blackAndWhite = function(t) { var e = [.3, .6, .1, 0, 0, .3, .6, .1, 0, 0, .3, .6, .1, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t) }, n.prototype.hue = function(t, e) { t = (t || 0) / 180 * Math.PI; var r = Math.cos(t),
						n = Math.sin(t),
						i = .213,
						o = .715,
						s = .072,
						a = [i + r * (1 - i) + n * -i, o + r * -o + n * -o, s + r * -s + n * (1 - s), 0, 0, i + r * -i + .143 * n, o + r * (1 - o) + .14 * n, s + r * -s + n * -.283, 0, 0, i + r * -i + n * -(1 - i), o + r * -o + n * o, s + r * (1 - s) + n * s, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(a, e) }, n.prototype.contrast = function(t, e) { var r = (t || 0) + 1,
						n = -128 * (r - 1),
						i = [r, 0, 0, 0, n, 0, r, 0, 0, n, 0, 0, r, 0, n, 0, 0, 0, 1, 0];
					this._loadMatrix(i, e) }, n.prototype.saturate = function(t, e) { var r = 2 * (t || 0) / 3 + 1,
						n = (r - 1) * -.5,
						i = [r, n, n, 0, 0, n, r, n, 0, 0, n, n, r, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(i, e) }, n.prototype.desaturate = function(t) { this.saturate(-1) }, n.prototype.negative = function(t) { var e = [0, 1, 1, 0, 0, 1, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t) }, n.prototype.sepia = function(t) { var e = [.393, .7689999, .18899999, 0, 0, .349, .6859999, .16799999, 0, 0, .272, .5339999, .13099999, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t) }, n.prototype.technicolor = function(t) { var e = [1.9125277891456083, -.8545344976951645, -.09155508482755585, 0, 11.793603434377337, -.3087833385928097, 1.7658908555458428, -.10601743074722245, 0, -70.35205161461398, -.231103377548616, -.7501899197440212, 1.847597816108189, 0, 30.950940869491138, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t) }, n.prototype.polaroid = function(t) { var e = [1.438, -.062, -.062, 0, 0, -.122, 1.378, -.122, 0, 0, -.016, -.016, 1.483, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t) }, n.prototype.toBGR = function(t) { var e = [0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t) }, n.prototype.kodachrome = function(t) { var e = [1.1285582396593525, -.3967382283601348, -.03992559172921793, 0, 63.72958762196502, -.16404339962244616, 1.0835251566291304, -.05498805115633132, 0, 24.732407896706203, -.16786010706155763, -.5603416277695248, 1.6014850761964943, 0, 35.62982807460946, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t) }, n.prototype.browni = function(t) { var e = [.5997023498159715, .34553243048391263, -.2708298674538042, 0, 47.43192855600873, -.037703249837783157, .8609577587992641, .15059552388459913, 0, -36.96841498319127, .24113635128153335, -.07441037908422492, .44972182064877153, 0, -7.562075277591283, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t) }, n.prototype.vintage = function(t) {
					var e = [.6279345635605994, .3202183420819367, -.03965408211312453, 0, 9.651285835294123, .02578397704808868, .6441188644374771, .03259127616149294, 0, 7.462829176470591, .0466055556782719, -.0851232987247891, .5241648018700465, 0, 5.159190588235296, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t)
				}, n.prototype.colorTone = function(t, e, r, n, i) { t = t || .2, e = e || .15, r = r || 16770432, n = n || 3375104; var o = (r >> 16 & 255) / 255,
						s = (r >> 8 & 255) / 255,
						a = (255 & r) / 255,
						l = (n >> 16 & 255) / 255,
						u = (n >> 8 & 255) / 255,
						h = (255 & n) / 255,
						c = [.3, .59, .11, 0, 0, o, s, a, t, 0, l, u, h, e, 0, o - l, s - u, a - h, 0, 0];
					this._loadMatrix(c, i) }, n.prototype.night = function(t, e) { t = t || .1; var r = [-2 * t, -t, 0, 0, 0, -t, 0, t, 0, 0, 0, t, 2 * t, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(r, e) }, n.prototype.predator = function(t, e) { var r = [11.224130630493164 * t, -4.794486999511719 * t, -2.8746118545532227 * t, 0 * t, .40342438220977783 * t, -3.6330697536468506 * t, 9.193157196044922 * t, -2.951810836791992 * t, 0 * t, -1.316135048866272 * t, -3.2184197902679443 * t, -4.2375030517578125 * t, 7.476448059082031 * t, 0 * t, .8044459223747253 * t, 0, 0, 0, 1, 0];
					this._loadMatrix(r, e) }, n.prototype.lsd = function(t) { var e = [2, -.4, .5, 0, 0, -.5, 2, -.4, 0, 0, -.4, -.5, 3, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(e, t) }, n.prototype.reset = function() { var t = [1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0];
					this._loadMatrix(t, !1) }, Object.defineProperties(n.prototype, { matrix: { get: function() { return this.uniforms.m.value }, set: function(t) { this.uniforms.m.value = t } } })
			}, { "../../core": 23 }],
			88: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\n\nuniform sampler2D uSampler;\nuniform float step;\n\nvoid main(void)\n{\n    vec4 color = texture2D(uSampler, vTextureCoord);\n\n    color = floor(color * step) / step;\n\n    gl_FragColor = color;\n}\n", { step: { type: "1f", value: 5 } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { step: { get: function() { return this.uniforms.step.value }, set: function(t) { this.uniforms.step.value = t } } }) }, { "../../core": 23 }],
			89: [function(t, e, r) {
				function n(t, e, r) { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying mediump vec2 vTextureCoord;\n\nuniform sampler2D uSampler;\nuniform vec2 texelSize;\nuniform float matrix[9];\n\nvoid main(void)\n{\n   vec4 c11 = texture2D(uSampler, vTextureCoord - texelSize); // top left\n   vec4 c12 = texture2D(uSampler, vec2(vTextureCoord.x, vTextureCoord.y - texelSize.y)); // top center\n   vec4 c13 = texture2D(uSampler, vec2(vTextureCoord.x + texelSize.x, vTextureCoord.y - texelSize.y)); // top right\n\n   vec4 c21 = texture2D(uSampler, vec2(vTextureCoord.x - texelSize.x, vTextureCoord.y)); // mid left\n   vec4 c22 = texture2D(uSampler, vTextureCoord); // mid center\n   vec4 c23 = texture2D(uSampler, vec2(vTextureCoord.x + texelSize.x, vTextureCoord.y)); // mid right\n\n   vec4 c31 = texture2D(uSampler, vec2(vTextureCoord.x - texelSize.x, vTextureCoord.y + texelSize.y)); // bottom left\n   vec4 c32 = texture2D(uSampler, vec2(vTextureCoord.x, vTextureCoord.y + texelSize.y)); // bottom center\n   vec4 c33 = texture2D(uSampler, vTextureCoord + texelSize); // bottom right\n\n   gl_FragColor =\n       c11 * matrix[0] + c12 * matrix[1] + c13 * matrix[2] +\n       c21 * matrix[3] + c22 * matrix[4] + c23 * matrix[5] +\n       c31 * matrix[6] + c32 * matrix[7] + c33 * matrix[8];\n\n   gl_FragColor.a = c22.a;\n}\n", { matrix: { type: "1fv", value: new Float32Array(t) }, texelSize: { type: "v2", value: { x: 1 / e, y: 1 / r } } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { matrix: { get: function() { return this.uniforms.matrix.value }, set: function(t) { this.uniforms.matrix.value = new Float32Array(t) } }, width: { get: function() { return 1 / this.uniforms.texelSize.value.x }, set: function(t) { this.uniforms.texelSize.value.x = 1 / t } }, height: { get: function() { return 1 / this.uniforms.texelSize.value.y }, set: function(t) { this.uniforms.texelSize.value.y = 1 / t } } }) }, { "../../core": 23 }],
			90: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\n\nuniform sampler2D uSampler;\n\nvoid main(void)\n{\n    float lum = length(texture2D(uSampler, vTextureCoord.xy).rgb);\n\n    gl_FragColor = vec4(1.0, 1.0, 1.0, 1.0);\n\n    if (lum < 1.00)\n    {\n        if (mod(gl_FragCoord.x + gl_FragCoord.y, 10.0) == 0.0)\n        {\n            gl_FragColor = vec4(0.0, 0.0, 0.0, 1.0);\n        }\n    }\n\n    if (lum < 0.75)\n    {\n        if (mod(gl_FragCoord.x - gl_FragCoord.y, 10.0) == 0.0)\n        {\n            gl_FragColor = vec4(0.0, 0.0, 0.0, 1.0);\n        }\n    }\n\n    if (lum < 0.50)\n    {\n        if (mod(gl_FragCoord.x + gl_FragCoord.y - 5.0, 10.0) == 0.0)\n        {\n            gl_FragColor = vec4(0.0, 0.0, 0.0, 1.0);\n        }\n    }\n\n    if (lum < 0.3)\n    {\n        if (mod(gl_FragCoord.x - gl_FragCoord.y - 5.0, 10.0) == 0.0)\n        {\n            gl_FragColor = vec4(0.0, 0.0, 0.0, 1.0);\n        }\n    }\n}\n") } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n }, { "../../core": 23 }],
			91: [function(t, e, r) {
				function n(t, e) { var r = new i.Matrix;
					t.renderable = !1, i.AbstractFilter.call(this, "attribute vec2 aVertexPosition;\nattribute vec2 aTextureCoord;\nattribute vec4 aColor;\n\nuniform mat3 projectionMatrix;\nuniform mat3 otherMatrix;\n\nvarying vec2 vMapCoord;\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\n\nvoid main(void)\n{\n   gl_Position = vec4((projectionMatrix * vec3(aVertexPosition, 1.0)).xy, 0.0, 1.0);\n   vTextureCoord = aTextureCoord;\n   vMapCoord = ( otherMatrix * vec3( aTextureCoord, 1.0)  ).xy;\n   vColor = vec4(aColor.rgb * aColor.a, aColor.a);\n}\n", "precision mediump float;\n\nvarying vec2 vMapCoord;\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\n\nuniform vec2 scale;\n\nuniform sampler2D uSampler;\nuniform sampler2D mapSampler;\n\nvoid main(void)\n{\n   vec4 map =  texture2D(mapSampler, vMapCoord);\n\n   map -= 0.5;\n   map.xy *= scale;\n\n   gl_FragColor = texture2D(uSampler, vec2(vTextureCoord.x + map.x, vTextureCoord.y + map.y));\n}\n", { mapSampler: { type: "sampler2D", value: t.texture }, otherMatrix: { type: "mat3", value: r.toArray(!0) }, scale: { type: "v2", value: { x: 1, y: 1 } } }), this.maskSprite = t, this.maskMatrix = r, (null === e || void 0 === e) && (e = 20), this.scale = new i.Point(e, e) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r) { var n = t.filterManager;
					n.calculateMappedMatrix(e.frame, this.maskSprite, this.maskMatrix), this.uniforms.otherMatrix.value = this.maskMatrix.toArray(!0), this.uniforms.scale.value.x = this.scale.x * (1 / e.frame.width), this.uniforms.scale.value.y = this.scale.y * (1 / e.frame.height); var i = this.getShader(t);
					n.applyFilter(i, e, r) }, Object.defineProperties(n.prototype, { map: { get: function() { return this.uniforms.mapSampler.value }, set: function(t) { this.uniforms.mapSampler.value = t } } }) }, { "../../core": 23 }],
			92: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\n\nuniform vec4 dimensions;\nuniform sampler2D uSampler;\n\nuniform float angle;\nuniform float scale;\n\nfloat pattern()\n{\n   float s = sin(angle), c = cos(angle);\n   vec2 tex = vTextureCoord * dimensions.xy;\n   vec2 point = vec2(\n       c * tex.x - s * tex.y,\n       s * tex.x + c * tex.y\n   ) * scale;\n   return (sin(point.x) * sin(point.y)) * 4.0;\n}\n\nvoid main()\n{\n   vec4 color = texture2D(uSampler, vTextureCoord);\n   float average = (color.r + color.g + color.b) / 3.0;\n   gl_FragColor = vec4(vec3(average * 10.0 - 5.0 + pattern()), color.a);\n}\n", { scale: { type: "1f", value: 1 }, angle: { type: "1f", value: 5 }, dimensions: { type: "4fv", value: [0, 0, 0, 0] } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { scale: { get: function() { return this.uniforms.scale.value }, set: function(t) { this.uniforms.scale.value = t } }, angle: { get: function() { return this.uniforms.angle.value }, set: function(t) { this.uniforms.angle.value = t } } }) }, { "../../core": 23 }],
			93: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, "attribute vec2 aVertexPosition;\nattribute vec2 aTextureCoord;\nattribute vec4 aColor;\n\nuniform float strength;\nuniform vec2 offset;\n\nuniform mat3 projectionMatrix;\n\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\nvarying vec2 vBlurTexCoords[6];\n\nvoid main(void)\n{\n    gl_Position = vec4((projectionMatrix * vec3((aVertexPosition+offset), 1.0)).xy, 0.0, 1.0);\n    vTextureCoord = aTextureCoord;\n\n    vBlurTexCoords[ 0] = aTextureCoord + vec2(0.0, -0.012 * strength);\n    vBlurTexCoords[ 1] = aTextureCoord + vec2(0.0, -0.008 * strength);\n    vBlurTexCoords[ 2] = aTextureCoord + vec2(0.0, -0.004 * strength);\n    vBlurTexCoords[ 3] = aTextureCoord + vec2(0.0,  0.004 * strength);\n    vBlurTexCoords[ 4] = aTextureCoord + vec2(0.0,  0.008 * strength);\n    vBlurTexCoords[ 5] = aTextureCoord + vec2(0.0,  0.012 * strength);\n\n   vColor = vec4(aColor.rgb * aColor.a, aColor.a);\n}\n", "precision lowp float;\n\nvarying vec2 vTextureCoord;\nvarying vec2 vBlurTexCoords[6];\nvarying vec4 vColor;\n\nuniform vec3 color;\nuniform float alpha;\n\nuniform sampler2D uSampler;\n\nvoid main(void)\n{\n    vec4 sum = vec4(0.0);\n\n    sum += texture2D(uSampler, vBlurTexCoords[ 0])*0.004431848411938341;\n    sum += texture2D(uSampler, vBlurTexCoords[ 1])*0.05399096651318985;\n    sum += texture2D(uSampler, vBlurTexCoords[ 2])*0.2419707245191454;\n    sum += texture2D(uSampler, vTextureCoord     )*0.3989422804014327;\n    sum += texture2D(uSampler, vBlurTexCoords[ 3])*0.2419707245191454;\n    sum += texture2D(uSampler, vBlurTexCoords[ 4])*0.05399096651318985;\n    sum += texture2D(uSampler, vBlurTexCoords[ 5])*0.004431848411938341;\n\n    gl_FragColor = vec4( color.rgb * sum.a * alpha, sum.a * alpha );\n}\n", { blur: { type: "1f", value: 1 / 512 }, color: { type: "c", value: [0, 0, 0] }, alpha: { type: "1f", value: .7 }, offset: { type: "2f", value: [5, 5] }, strength: { type: "1f", value: 1 } }), this.passes = 1, this.strength = 4 } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r, n) { var i = this.getShader(t); if(this.uniforms.strength.value = this.strength / 4 / this.passes * (e.frame.height / e.size.height), 1 === this.passes) t.filterManager.applyFilter(i, e, r, n);
					else { for(var o = t.filterManager.getRenderTarget(!0), s = e, a = o, l = 0; l < this.passes - 1; l++) { t.filterManager.applyFilter(i, s, a, n); var u = a;
							a = s, s = u } t.filterManager.applyFilter(i, s, r, n), t.filterManager.returnRenderTarget(o) } }, Object.defineProperties(n.prototype, { blur: { get: function() { return this.strength }, set: function(t) { this.padding = .5 * t, this.strength = t } } }) }, { "../../core": 23 }],
			94: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this), this.blurXFilter = new o, this.blurYTintFilter = new s, this.defaultFilter = new i.AbstractFilter, this.padding = 30, this._dirtyPosition = !0, this._angle = 45 * Math.PI / 180, this._distance = 10, this.alpha = .75, this.hideObject = !1, this.blendMode = i.BLEND_MODES.MULTIPLY } var i = t("../../core"),
					o = t("../blur/BlurXFilter"),
					s = t("./BlurYTintFilter");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r) { var n = t.filterManager.getRenderTarget(!0);
					this._dirtyPosition && (this._dirtyPosition = !1, this.blurYTintFilter.uniforms.offset.value[0] = Math.sin(this._angle) * this._distance, this.blurYTintFilter.uniforms.offset.value[1] = Math.cos(this._angle) * this._distance), this.blurXFilter.applyFilter(t, e, n), t.blendModeManager.setBlendMode(this.blendMode), this.blurYTintFilter.applyFilter(t, n, r), t.blendModeManager.setBlendMode(i.BLEND_MODES.NORMAL), this.hideObject || this.defaultFilter.applyFilter(t, e, r), t.filterManager.returnRenderTarget(n) }, Object.defineProperties(n.prototype, { blur: { get: function() { return this.blurXFilter.blur }, set: function(t) { this.blurXFilter.blur = this.blurYTintFilter.blur = t } }, blurX: { get: function() { return this.blurXFilter.blur }, set: function(t) { this.blurXFilter.blur = t } }, blurY: { get: function() { return this.blurYTintFilter.blur }, set: function(t) { this.blurYTintFilter.blur = t } }, color: { get: function() { return i.utils.rgb2hex(this.blurYTintFilter.uniforms.color.value) }, set: function(t) { this.blurYTintFilter.uniforms.color.value = i.utils.hex2rgb(t) } }, alpha: { get: function() { return this.blurYTintFilter.uniforms.alpha.value }, set: function(t) { this.blurYTintFilter.uniforms.alpha.value = t } }, distance: { get: function() { return this._distance }, set: function(t) { this._dirtyPosition = !0, this._distance = t } }, angle: { get: function() { return this._angle }, set: function(t) { this._dirtyPosition = !0, this._angle = t } } }) }, { "../../core": 23, "../blur/BlurXFilter": 84, "./BlurYTintFilter": 93 }],
			95: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\n\nuniform sampler2D uSampler;\nuniform float gray;\n\nvoid main(void)\n{\n   gl_FragColor = texture2D(uSampler, vTextureCoord);\n   gl_FragColor.rgb = mix(gl_FragColor.rgb, vec3(0.2126*gl_FragColor.r + 0.7152*gl_FragColor.g + 0.0722*gl_FragColor.b), gray);\n}\n", { gray: { type: "1f", value: 1 } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { gray: { get: function() { return this.uniforms.gray.value }, set: function(t) { this.uniforms.gray.value = t } } }) }, { "../../core": 23 }],
			96: [function(t, e, r) { e.exports = { AsciiFilter: t("./ascii/AsciiFilter"), BloomFilter: t("./bloom/BloomFilter"), BlurFilter: t("./blur/BlurFilter"), BlurXFilter: t("./blur/BlurXFilter"), BlurYFilter: t("./blur/BlurYFilter"), BlurDirFilter: t("./blur/BlurDirFilter"), ColorMatrixFilter: t("./color/ColorMatrixFilter"), ColorStepFilter: t("./color/ColorStepFilter"), ConvolutionFilter: t("./convolution/ConvolutionFilter"), CrossHatchFilter: t("./crosshatch/CrossHatchFilter"), DisplacementFilter: t("./displacement/DisplacementFilter"), DotScreenFilter: t("./dot/DotScreenFilter"), GrayFilter: t("./gray/GrayFilter"), DropShadowFilter: t("./dropshadow/DropShadowFilter"), InvertFilter: t("./invert/InvertFilter"), NoiseFilter: t("./noise/NoiseFilter"), PixelateFilter: t("./pixelate/PixelateFilter"), RGBSplitFilter: t("./rgb/RGBSplitFilter"), ShockwaveFilter: t("./shockwave/ShockwaveFilter"), SepiaFilter: t("./sepia/SepiaFilter"), SmartBlurFilter: t("./blur/SmartBlurFilter"), TiltShiftFilter: t("./tiltshift/TiltShiftFilter"), TiltShiftXFilter: t("./tiltshift/TiltShiftXFilter"), TiltShiftYFilter: t("./tiltshift/TiltShiftYFilter"), TwistFilter: t("./twist/TwistFilter") } }, { "./ascii/AsciiFilter": 80, "./bloom/BloomFilter": 81, "./blur/BlurDirFilter": 82, "./blur/BlurFilter": 83, "./blur/BlurXFilter": 84, "./blur/BlurYFilter": 85, "./blur/SmartBlurFilter": 86, "./color/ColorMatrixFilter": 87, "./color/ColorStepFilter": 88, "./convolution/ConvolutionFilter": 89, "./crosshatch/CrossHatchFilter": 90, "./displacement/DisplacementFilter": 91, "./dot/DotScreenFilter": 92, "./dropshadow/DropShadowFilter": 94, "./gray/GrayFilter": 95, "./invert/InvertFilter": 97, "./noise/NoiseFilter": 98, "./pixelate/PixelateFilter": 99, "./rgb/RGBSplitFilter": 100, "./sepia/SepiaFilter": 101, "./shockwave/ShockwaveFilter": 102, "./tiltshift/TiltShiftFilter": 104, "./tiltshift/TiltShiftXFilter": 105, "./tiltshift/TiltShiftYFilter": 106, "./twist/TwistFilter": 107 }],
			97: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\n\nuniform float invert;\nuniform sampler2D uSampler;\n\nvoid main(void)\n{\n    gl_FragColor = texture2D(uSampler, vTextureCoord);\n\n    gl_FragColor.rgb = mix( (vec3(1)-gl_FragColor.rgb) * gl_FragColor.a, gl_FragColor.rgb, 1.0 - invert);\n}\n", { invert: { type: "1f", value: 1 } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { invert: { get: function() { return this.uniforms.invert.value }, set: function(t) { this.uniforms.invert.value = t } } }) }, { "../../core": 23 }],
			98: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision highp float;\n\nvarying vec2 vTextureCoord;\nvarying vec4 vColor;\n\nuniform float noise;\nuniform sampler2D uSampler;\n\nfloat rand(vec2 co)\n{\n    return fract(sin(dot(co.xy, vec2(12.9898, 78.233))) * 43758.5453);\n}\n\nvoid main()\n{\n    vec4 color = texture2D(uSampler, vTextureCoord);\n\n    float diff = (rand(vTextureCoord) - 0.5) * noise;\n\n    color.r += diff;\n    color.g += diff;\n    color.b += diff;\n\n    gl_FragColor = color;\n}\n", { noise: { type: "1f", value: .5 } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { noise: { get: function() { return this.uniforms.noise.value }, set: function(t) { this.uniforms.noise.value = t } } }) }, { "../../core": 23 }],
			99: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\n\nuniform vec4 dimensions;\nuniform vec2 pixelSize;\nuniform sampler2D uSampler;\n\nvoid main(void)\n{\n    vec2 coord = vTextureCoord;\n\n    vec2 size = dimensions.xy / pixelSize;\n\n    vec2 color = floor( ( vTextureCoord * size ) ) / size + pixelSize/dimensions.xy * 0.5;\n\n    gl_FragColor = texture2D(uSampler, color);\n}\n", { dimensions: { type: "4fv", value: new Float32Array([0, 0, 0, 0]) }, pixelSize: { type: "v2", value: { x: 10, y: 10 } } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { size: { get: function() { return this.uniforms.pixelSize.value }, set: function(t) { this.uniforms.pixelSize.value = t } } }) }, { "../../core": 23 }],
			100: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\n\nuniform sampler2D uSampler;\nuniform vec4 dimensions;\nuniform vec2 red;\nuniform vec2 green;\nuniform vec2 blue;\n\nvoid main(void)\n{\n   gl_FragColor.r = texture2D(uSampler, vTextureCoord + red/dimensions.xy).r;\n   gl_FragColor.g = texture2D(uSampler, vTextureCoord + green/dimensions.xy).g;\n   gl_FragColor.b = texture2D(uSampler, vTextureCoord + blue/dimensions.xy).b;\n   gl_FragColor.a = texture2D(uSampler, vTextureCoord).a;\n}\n", { red: { type: "v2", value: { x: 20, y: 20 } }, green: { type: "v2", value: { x: -20, y: 20 } }, blue: { type: "v2", value: { x: 20, y: -20 } }, dimensions: { type: "4fv", value: [0, 0, 0, 0] } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { red: { get: function() { return this.uniforms.red.value }, set: function(t) { this.uniforms.red.value = t } }, green: { get: function() { return this.uniforms.green.value }, set: function(t) { this.uniforms.green.value = t } }, blue: { get: function() { return this.uniforms.blue.value }, set: function(t) { this.uniforms.blue.value = t } } }) }, { "../../core": 23 }],
			101: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\n\nuniform sampler2D uSampler;\nuniform float sepia;\n\nconst mat3 sepiaMatrix = mat3(0.3588, 0.7044, 0.1368, 0.2990, 0.5870, 0.1140, 0.2392, 0.4696, 0.0912);\n\nvoid main(void)\n{\n   gl_FragColor = texture2D(uSampler, vTextureCoord);\n   gl_FragColor.rgb = mix( gl_FragColor.rgb, gl_FragColor.rgb * sepiaMatrix, sepia);\n}\n", { sepia: { type: "1f", value: 1 } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { sepia: { get: function() { return this.uniforms.sepia.value }, set: function(t) { this.uniforms.sepia.value = t } } }) }, { "../../core": 23 }],
			102: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision lowp float;\n\nvarying vec2 vTextureCoord;\n\nuniform sampler2D uSampler;\n\nuniform vec2 center;\nuniform vec3 params; // 10.0, 0.8, 0.1\nuniform float time;\n\nvoid main()\n{\n    vec2 uv = vTextureCoord;\n    vec2 texCoord = uv;\n\n    float dist = distance(uv, center);\n\n    if ( (dist <= (time + params.z)) && (dist >= (time - params.z)) )\n    {\n        float diff = (dist - time);\n        float powDiff = 1.0 - pow(abs(diff*params.x), params.y);\n\n        float diffTime = diff  * powDiff;\n        vec2 diffUV = normalize(uv - center);\n        texCoord = uv + (diffUV * diffTime);\n    }\n\n    gl_FragColor = texture2D(uSampler, texCoord);\n}\n", { center: { type: "v2", value: { x: .5, y: .5 } }, params: { type: "v3", value: { x: 10, y: .8, z: .1 } }, time: { type: "1f", value: 0 } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { center: { get: function() { return this.uniforms.center.value }, set: function(t) { this.uniforms.center.value = t } }, params: { get: function() { return this.uniforms.params.value }, set: function(t) { this.uniforms.params.value = t } }, time: { get: function() { return this.uniforms.time.value }, set: function(t) { this.uniforms.time.value = t } } }) }, { "../../core": 23 }],
			103: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\n\nuniform sampler2D uSampler;\nuniform float blur;\nuniform float gradientBlur;\nuniform vec2 start;\nuniform vec2 end;\nuniform vec2 delta;\nuniform vec2 texSize;\n\nfloat random(vec3 scale, float seed)\n{\n    return fract(sin(dot(gl_FragCoord.xyz + seed, scale)) * 43758.5453 + seed);\n}\n\nvoid main(void)\n{\n    vec4 color = vec4(0.0);\n    float total = 0.0;\n\n    float offset = random(vec3(12.9898, 78.233, 151.7182), 0.0);\n    vec2 normal = normalize(vec2(start.y - end.y, end.x - start.x));\n    float radius = smoothstep(0.0, 1.0, abs(dot(vTextureCoord * texSize - start, normal)) / gradientBlur) * blur;\n\n    for (float t = -30.0; t <= 30.0; t++)\n    {\n        float percent = (t + offset - 0.5) / 30.0;\n        float weight = 1.0 - abs(percent);\n        vec4 sample = texture2D(uSampler, vTextureCoord + delta / texSize * percent * radius);\n        sample.rgb *= sample.a;\n        color += sample * weight;\n        total += weight;\n    }\n\n    gl_FragColor = color / total;\n    gl_FragColor.rgb /= gl_FragColor.a + 0.00001;\n}\n", { blur: { type: "1f", value: 100 }, gradientBlur: { type: "1f", value: 600 }, start: { type: "v2", value: { x: 0, y: window.innerHeight / 2 } }, end: { type: "v2", value: { x: 600, y: window.innerHeight / 2 } }, delta: { type: "v2", value: { x: 30, y: 30 } }, texSize: { type: "v2", value: { x: window.innerWidth, y: window.innerHeight } } }), this.updateDelta() } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.updateDelta = function() { this.uniforms.delta.value.x = 0, this.uniforms.delta.value.y = 0 }, Object.defineProperties(n.prototype, { blur: { get: function() { return this.uniforms.blur.value }, set: function(t) { this.uniforms.blur.value = t } }, gradientBlur: { get: function() { return this.uniforms.gradientBlur.value }, set: function(t) { this.uniforms.gradientBlur.value = t } }, start: { get: function() { return this.uniforms.start.value }, set: function(t) { this.uniforms.start.value = t, this.updateDelta() } }, end: { get: function() { return this.uniforms.end.value }, set: function(t) { this.uniforms.end.value = t, this.updateDelta() } } }) }, { "../../core": 23 }],
			104: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this), this.tiltShiftXFilter = new o, this.tiltShiftYFilter = new s } var i = t("../../core"),
					o = t("./TiltShiftXFilter"),
					s = t("./TiltShiftYFilter");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.applyFilter = function(t, e, r) { var n = t.filterManager.getRenderTarget(!0);
					this.tiltShiftXFilter.applyFilter(t, e, n), this.tiltShiftYFilter.applyFilter(t, n, r), t.filterManager.returnRenderTarget(n) }, Object.defineProperties(n.prototype, { blur: { get: function() { return this.tiltShiftXFilter.blur }, set: function(t) { this.tiltShiftXFilter.blur = this.tiltShiftYFilter.blur = t } }, gradientBlur: { get: function() { return this.tiltShiftXFilter.gradientBlur }, set: function(t) { this.tiltShiftXFilter.gradientBlur = this.tiltShiftYFilter.gradientBlur = t } }, start: { get: function() { return this.tiltShiftXFilter.start }, set: function(t) { this.tiltShiftXFilter.start = this.tiltShiftYFilter.start = t } }, end: { get: function() { return this.tiltShiftXFilter.end }, set: function(t) { this.tiltShiftXFilter.end = this.tiltShiftYFilter.end = t } } }) }, { "../../core": 23, "./TiltShiftXFilter": 105, "./TiltShiftYFilter": 106 }],
			105: [function(t, e, r) {
				function n() { i.call(this) } var i = t("./TiltShiftAxisFilter");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.updateDelta = function() { var t = this.uniforms.end.value.x - this.uniforms.start.value.x,
						e = this.uniforms.end.value.y - this.uniforms.start.value.y,
						r = Math.sqrt(t * t + e * e);
					this.uniforms.delta.value.x = t / r, this.uniforms.delta.value.y = e / r } }, { "./TiltShiftAxisFilter": 103 }],
			106: [function(t, e, r) {
				function n() { i.call(this) } var i = t("./TiltShiftAxisFilter");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.updateDelta = function() { var t = this.uniforms.end.value.x - this.uniforms.start.value.x,
						e = this.uniforms.end.value.y - this.uniforms.start.value.y,
						r = Math.sqrt(t * t + e * e);
					this.uniforms.delta.value.x = -e / r, this.uniforms.delta.value.y = t / r } }, { "./TiltShiftAxisFilter": 103 }],
			107: [function(t, e, r) {
				function n() { i.AbstractFilter.call(this, null, "precision mediump float;\n\nvarying vec2 vTextureCoord;\n\nuniform sampler2D uSampler;\nuniform float radius;\nuniform float angle;\nuniform vec2 offset;\n\nvoid main(void)\n{\n   vec2 coord = vTextureCoord - offset;\n   float dist = length(coord);\n\n   if (dist < radius)\n   {\n       float ratio = (radius - dist) / radius;\n       float angleMod = ratio * ratio * angle;\n       float s = sin(angleMod);\n       float c = cos(angleMod);\n       coord = vec2(coord.x * c - coord.y * s, coord.x * s + coord.y * c);\n   }\n\n   gl_FragColor = texture2D(uSampler, coord+offset);\n}\n", { radius: { type: "1f", value: .5 }, angle: { type: "1f", value: 5 }, offset: { type: "v2", value: { x: .5, y: .5 } } }) } var i = t("../../core");
				n.prototype = Object.create(i.AbstractFilter.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { offset: { get: function() { return this.uniforms.offset.value }, set: function(t) { this.uniforms.offset.value = t } }, radius: { get: function() { return this.uniforms.radius.value }, set: function(t) { this.uniforms.radius.value = t } }, angle: { get: function() { return this.uniforms.angle.value }, set: function(t) { this.uniforms.angle.value = t } } }) }, { "../../core": 23 }],
			108: [function(t, e, r) {
				(function(r) { t("./polyfill"); var n = e.exports = t("./core");
					n.extras = t("./extras"), n.filters = t("./filters"), n.interaction = t("./interaction"), n.loaders = t("./loaders"), n.mesh = t("./mesh"), n.accessibility = t("./accessibility"), n.loader = new n.loaders.Loader, Object.assign(n, t("./deprecation")), r.PIXI = n }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}) }, { "./accessibility": 15, "./core": 23, "./deprecation": 72, "./extras": 79, "./filters": 96, "./interaction": 111, "./loaders": 114, "./mesh": 121, "./polyfill": 126 }],
			109: [function(t, e, r) {
				function n() { this.global = new i.Point, this.target = null, this.originalEvent = null } var i = t("../core");
				n.prototype.constructor = n, e.exports = n, n.prototype.getLocalPosition = function(t, e, r) { return t.worldTransform.applyInverse(r || this.global, e) } }, { "../core": 23 }],
			110: [function(t, e, r) {
				function n(t, e) { e = e || {}, this.renderer = t, this.autoPreventDefault = void 0 !== e.autoPreventDefault ? e.autoPreventDefault : !0, this.interactionFrequency = e.interactionFrequency || 10, this.mouse = new o, this.eventData = { stopped: !1, target: null, type: null, data: this.mouse, stopPropagation: function() { this.stopped = !0 } }, this.interactiveDataPool = [], this.interactionDOMElement = null, this.eventsAdded = !1, this.onMouseUp = this.onMouseUp.bind(this), this.processMouseUp = this.processMouseUp.bind(this), this.onMouseDown = this.onMouseDown.bind(this), this.processMouseDown = this.processMouseDown.bind(this), this.onMouseMove = this.onMouseMove.bind(this), this.processMouseMove = this.processMouseMove.bind(this), this.onMouseOut = this.onMouseOut.bind(this), this.processMouseOverOut = this.processMouseOverOut.bind(this), this.onTouchStart = this.onTouchStart.bind(this), this.processTouchStart = this.processTouchStart.bind(this), this.onTouchEnd = this.onTouchEnd.bind(this), this.processTouchEnd = this.processTouchEnd.bind(this), this.onTouchMove = this.onTouchMove.bind(this), this.processTouchMove = this.processTouchMove.bind(this), this.last = 0, this.currentCursorStyle = "inherit", this._tempPoint = new i.Point, this.resolution = 1, this.setTargetElement(this.renderer.view, this.renderer.resolution) }
				var i = t("../core"),
					o = t("./InteractionData");
				Object.assign(i.DisplayObject.prototype, t("./interactiveTarget")), n.prototype.constructor = n, e.exports = n, n.prototype.setTargetElement = function(t, e) { this.removeEvents(), this.interactionDOMElement = t, this.resolution = e || 1, this.addEvents() }, n.prototype.addEvents = function() { this.interactionDOMElement && (i.ticker.shared.add(this.update, this), window.navigator.msPointerEnabled && (this.interactionDOMElement.style["-ms-content-zooming"] = "none", this.interactionDOMElement.style["-ms-touch-action"] = "none"), window.document.addEventListener("mousemove", this.onMouseMove, !0), this.interactionDOMElement.addEventListener("mousedown", this.onMouseDown, !0), this.interactionDOMElement.addEventListener("mouseout", this.onMouseOut, !0), this.interactionDOMElement.addEventListener("touchstart", this.onTouchStart, !0), this.interactionDOMElement.addEventListener("touchend", this.onTouchEnd, !0), this.interactionDOMElement.addEventListener("touchmove", this.onTouchMove, !0), window.addEventListener("mouseup", this.onMouseUp, !0), this.eventsAdded = !0) }, n.prototype.removeEvents = function() { this.interactionDOMElement && (i.ticker.shared.remove(this.update), window.navigator.msPointerEnabled && (this.interactionDOMElement.style["-ms-content-zooming"] = "", this.interactionDOMElement.style["-ms-touch-action"] = ""), window.document.removeEventListener("mousemove", this.onMouseMove, !0), this.interactionDOMElement.removeEventListener("mousedown", this.onMouseDown, !0), this.interactionDOMElement.removeEventListener("mouseout", this.onMouseOut, !0), this.interactionDOMElement.removeEventListener("touchstart", this.onTouchStart, !0), this.interactionDOMElement.removeEventListener("touchend", this.onTouchEnd, !0), this.interactionDOMElement.removeEventListener("touchmove", this.onTouchMove, !0), this.interactionDOMElement = null, window.removeEventListener("mouseup", this.onMouseUp, !0), this.eventsAdded = !1) }, n.prototype.update = function(t) { if(this._deltaTime += t, !(this._deltaTime < this.interactionFrequency) && (this._deltaTime = 0, this.interactionDOMElement)) { if(this.didMove) return void(this.didMove = !1);
							this.cursor = "inherit", this.processInteractive(this.mouse.global, this.renderer._lastObjectRendered, this.processMouseOverOut, !0), this.currentCursorStyle !== this.cursor && (this.currentCursorStyle = this.cursor, this.interactionDOMElement.style.cursor = this.cursor) } }, n.prototype.dispatchEvent = function(t, e, r) { r.stopped || (r.target = t, r.type = e, t.emit(e, r), t[e] && t[e](r)) }, n.prototype.mapPositionToPoint = function(t, e, r) { var n = this.interactionDOMElement.getBoundingClientRect();
						t.x = (e - n.left) * (this.interactionDOMElement.width / n.width) / this.resolution, t.y = (r - n.top) * (this.interactionDOMElement.height / n.height) / this.resolution }, n.prototype.processInteractive = function(t, e, r, n, i) { if(!e || !e.visible) return !1; var o = !1,
							s = i = e.interactive || i; if(e.hitArea && (s = !1), e.interactiveChildren)
							for(var a = e.children, l = a.length - 1; l >= 0; l--) this.processInteractive(t, a[l], r, n, s) && (o = !0, s = !1, a[l].interactive && (n = !1)); return i && (n && !o && (e.hitArea ? (e.worldTransform.applyInverse(t, this._tempPoint), o = e.hitArea.contains(this._tempPoint.x, this._tempPoint.y)) : e.containsPoint && (o = e.containsPoint(t))), e.interactive && r(e, o)), o }, n.prototype.onMouseDown = function(t) { this.mouse.originalEvent = t, this.eventData.data = this.mouse, this.eventData.stopped = !1, this.mapPositionToPoint(this.mouse.global, t.clientX, t.clientY), this.autoPreventDefault && this.mouse.originalEvent.preventDefault(), this.processInteractive(this.mouse.global, this.renderer._lastObjectRendered, this.processMouseDown, !0) }, n.prototype.processMouseDown = function(t, e) { var r = this.mouse.originalEvent,
							n = 2 === r.button || 3 === r.which;
						e && (t[n ? "_isRightDown" : "_isLeftDown"] = !0, this.dispatchEvent(t, n ? "rightdown" : "mousedown", this.eventData)) },
					n.prototype.onMouseUp = function(t) { this.mouse.originalEvent = t, this.eventData.data = this.mouse, this.eventData.stopped = !1, this.mapPositionToPoint(this.mouse.global, t.clientX, t.clientY), this.processInteractive(this.mouse.global, this.renderer._lastObjectRendered, this.processMouseUp, !0) }, n.prototype.processMouseUp = function(t, e) { var r = this.mouse.originalEvent,
							n = 2 === r.button || 3 === r.which,
							i = n ? "_isRightDown" : "_isLeftDown";
						e ? (this.dispatchEvent(t, n ? "rightup" : "mouseup", this.eventData), t[i] && (t[i] = !1, this.dispatchEvent(t, n ? "rightclick" : "click", this.eventData))) : t[i] && (t[i] = !1, this.dispatchEvent(t, n ? "rightupoutside" : "mouseupoutside", this.eventData)) }, n.prototype.onMouseMove = function(t) { this.mouse.originalEvent = t, this.eventData.data = this.mouse, this.eventData.stopped = !1, this.mapPositionToPoint(this.mouse.global, t.clientX, t.clientY), this.didMove = !0, this.cursor = "inherit", this.processInteractive(this.mouse.global, this.renderer._lastObjectRendered, this.processMouseMove, !0), this.currentCursorStyle !== this.cursor && (this.currentCursorStyle = this.cursor, this.interactionDOMElement.style.cursor = this.cursor) }, n.prototype.processMouseMove = function(t, e) { this.dispatchEvent(t, "mousemove", this.eventData), this.processMouseOverOut(t, e) }, n.prototype.onMouseOut = function(t) { this.mouse.originalEvent = t, this.eventData.stopped = !1, this.mapPositionToPoint(this.mouse.global, t.clientX, t.clientY), this.interactionDOMElement.style.cursor = "inherit", this.mapPositionToPoint(this.mouse.global, t.clientX, t.clientY), this.processInteractive(this.mouse.global, this.renderer._lastObjectRendered, this.processMouseOverOut, !1) }, n.prototype.processMouseOverOut = function(t, e) { e ? (t._over || (t._over = !0, this.dispatchEvent(t, "mouseover", this.eventData)), t.buttonMode && (this.cursor = t.defaultCursor)) : t._over && (t._over = !1, this.dispatchEvent(t, "mouseout", this.eventData)) }, n.prototype.onTouchStart = function(t) { this.autoPreventDefault && t.preventDefault(); for(var e = t.changedTouches, r = e.length, n = 0; r > n; n++) { var i = e[n],
								o = this.getTouchData(i);
							o.originalEvent = t, this.eventData.data = o, this.eventData.stopped = !1, this.processInteractive(o.global, this.renderer._lastObjectRendered, this.processTouchStart, !0), this.returnTouchData(o) } }, n.prototype.processTouchStart = function(t, e) { e && (t._touchDown = !0, this.dispatchEvent(t, "touchstart", this.eventData)) }, n.prototype.onTouchEnd = function(t) { this.autoPreventDefault && t.preventDefault(); for(var e = t.changedTouches, r = e.length, n = 0; r > n; n++) { var i = e[n],
								o = this.getTouchData(i);
							o.originalEvent = t, this.eventData.data = o, this.eventData.stopped = !1, this.processInteractive(o.global, this.renderer._lastObjectRendered, this.processTouchEnd, !0), this.returnTouchData(o) } }, n.prototype.processTouchEnd = function(t, e) { e ? (this.dispatchEvent(t, "touchend", this.eventData), t._touchDown && (t._touchDown = !1, this.dispatchEvent(t, "tap", this.eventData))) : t._touchDown && (t._touchDown = !1, this.dispatchEvent(t, "touchendoutside", this.eventData)) }, n.prototype.onTouchMove = function(t) { this.autoPreventDefault && t.preventDefault(); for(var e = t.changedTouches, r = e.length, n = 0; r > n; n++) { var i = e[n],
								o = this.getTouchData(i);
							o.originalEvent = t, this.eventData.data = o, this.eventData.stopped = !1, this.processInteractive(o.global, this.renderer._lastObjectRendered, this.processTouchMove, !0), this.returnTouchData(o) } }, n.prototype.processTouchMove = function(t, e) { e = e, this.dispatchEvent(t, "touchmove", this.eventData) }, n.prototype.getTouchData = function(t) { var e = this.interactiveDataPool.pop(); return e || (e = new o), e.identifier = t.identifier, this.mapPositionToPoint(e.global, t.clientX, t.clientY), navigator.isCocoonJS && (e.global.x = e.global.x / this.resolution, e.global.y = e.global.y / this.resolution), t.globalX = e.global.x, t.globalY = e.global.y, e }, n.prototype.returnTouchData = function(t) { this.interactiveDataPool.push(t) }, n.prototype.destroy = function() { this.removeEvents(), this.renderer = null, this.mouse = null, this.eventData = null, this.interactiveDataPool = null, this.interactionDOMElement = null, this.onMouseUp = null, this.processMouseUp = null, this.onMouseDown = null, this.processMouseDown = null, this.onMouseMove = null, this.processMouseMove = null, this.onMouseOut = null, this.processMouseOverOut = null, this.onTouchStart = null, this.processTouchStart = null, this.onTouchEnd = null, this.processTouchEnd = null, this.onTouchMove = null, this.processTouchMove = null, this._tempPoint = null }, i.WebGLRenderer.registerPlugin("interaction", n), i.CanvasRenderer.registerPlugin("interaction", n)
			}, { "../core": 23, "./InteractionData": 109, "./interactiveTarget": 112 }],
			111: [function(t, e, r) { e.exports = { InteractionData: t("./InteractionData"), InteractionManager: t("./InteractionManager"), interactiveTarget: t("./interactiveTarget") } }, { "./InteractionData": 109, "./InteractionManager": 110, "./interactiveTarget": 112 }],
			112: [function(t, e, r) { var n = { interactive: !1, buttonMode: !1, interactiveChildren: !0, defaultCursor: "pointer", _over: !1, _touchDown: !1 };
				e.exports = n }, {}],
			113: [function(t, e, r) {
				function n(t, e) { var r = {},
						n = t.data.getElementsByTagName("info")[0],
						i = t.data.getElementsByTagName("common")[0];
					r.font = n.getAttribute("face"), r.size = parseInt(n.getAttribute("size"), 10), r.lineHeight = parseInt(i.getAttribute("lineHeight"), 10), r.chars = {}; for(var a = t.data.getElementsByTagName("char"), l = 0; l < a.length; l++) { var u = parseInt(a[l].getAttribute("id"), 10),
							h = new o.Rectangle(parseInt(a[l].getAttribute("x"), 10) + e.frame.x, parseInt(a[l].getAttribute("y"), 10) + e.frame.y, parseInt(a[l].getAttribute("width"), 10), parseInt(a[l].getAttribute("height"), 10));
						r.chars[u] = { xOffset: parseInt(a[l].getAttribute("xoffset"), 10), yOffset: parseInt(a[l].getAttribute("yoffset"), 10), xAdvance: parseInt(a[l].getAttribute("xadvance"), 10), kerning: {}, texture: new o.Texture(e.baseTexture, h) } } var c = t.data.getElementsByTagName("kerning"); for(l = 0; l < c.length; l++) { var p = parseInt(c[l].getAttribute("first"), 10),
							d = parseInt(c[l].getAttribute("second"), 10),
							f = parseInt(c[l].getAttribute("amount"), 10);
						r.chars[d].kerning[p] = f } t.bitmapFont = r, s.BitmapText.fonts[r.font] = r } var i = t("resource-loader").Resource,
					o = t("../core"),
					s = t("../extras"),
					a = t("path");
				e.exports = function() { return function(t, e) { if(!t.data || !t.isXml) return e(); if(0 === t.data.getElementsByTagName("page").length || 0 === t.data.getElementsByTagName("info").length || null === t.data.getElementsByTagName("info")[0].getAttribute("face")) return e(); var r = a.dirname(t.url); "." === r && (r = ""), this.baseUrl && r && ("/" === this.baseUrl.charAt(this.baseUrl.length - 1) && (r += "/"), r = r.replace(this.baseUrl, "")), r && "/" !== r.charAt(r.length - 1) && (r += "/"); var s = r + t.data.getElementsByTagName("page")[0].getAttribute("file"); if(o.utils.TextureCache[s]) n(t, o.utils.TextureCache[s]), e();
						else { var l = { crossOrigin: t.crossOrigin, loadType: i.LOAD_TYPE.IMAGE, metadata: t.metadata.imageMetadata };
							this.add(t.name + "_image", s, l, function(r) { n(t, r.texture), e() }) } } } }, { "../core": 23, "../extras": 79, path: 2, "resource-loader": 133 }],
			114: [function(t, e, r) { e.exports = { Loader: t("./loader"), bitmapFontParser: t("./bitmapFontParser"), spritesheetParser: t("./spritesheetParser"), textureParser: t("./textureParser"), Resource: t("resource-loader").Resource } }, { "./bitmapFontParser": 113, "./loader": 115, "./spritesheetParser": 116, "./textureParser": 117, "resource-loader": 133 }],
			115: [function(t, e, r) {
				function n(t, e) { i.call(this, t, e); for(var r = 0; r < n._pixiMiddleware.length; ++r) this.use(n._pixiMiddleware[r]()) } var i = t("resource-loader"),
					o = t("./textureParser"),
					s = t("./spritesheetParser"),
					a = t("./bitmapFontParser");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n._pixiMiddleware = [i.middleware.parsing.blob, o, s, a], n.addPixiMiddleware = function(t) { n._pixiMiddleware.push(t) }; var l = i.Resource;
				l.setExtensionXhrType("fnt", l.XHR_RESPONSE_TYPE.DOCUMENT) }, { "./bitmapFontParser": 113, "./spritesheetParser": 116, "./textureParser": 117, "resource-loader": 133 }],
			116: [function(t, e, r) { var n = t("resource-loader").Resource,
					i = t("path"),
					o = t("../core");
				e.exports = function() { return function(t, e) { if(!t.data || !t.isJson || !t.data.frames) return e(); var r = { crossOrigin: t.crossOrigin, loadType: n.LOAD_TYPE.IMAGE, metadata: t.metadata.imageMetadata },
							s = i.dirname(t.url.replace(this.baseUrl, "")),
							a = o.utils.getResolutionOfUrl(t.url);
						this.add(t.name + "_image", s + "/" + t.data.meta.image, r, function(r) { t.textures = {}; var n = t.data.frames; for(var i in n) { var s = n[i].frame; if(s) { var l = null,
										u = null; if(l = n[i].rotated ? new o.Rectangle(s.x, s.y, s.h, s.w) : new o.Rectangle(s.x, s.y, s.w, s.h), n[i].trimmed && (u = new o.Rectangle(n[i].spriteSourceSize.x / a, n[i].spriteSourceSize.y / a, n[i].sourceSize.w / a, n[i].sourceSize.h / a)), n[i].rotated) { var h = l.width;
										l.width = l.height, l.height = h } l.x /= a, l.y /= a, l.width /= a, l.height /= a, t.textures[i] = new o.Texture(r.texture.baseTexture, l, l.clone(), u, n[i].rotated), o.utils.TextureCache[i] = t.textures[i] } } e() }) } } }, { "../core": 23, path: 2, "resource-loader": 133 }],
			117: [function(t, e, r) { var n = t("../core");
				e.exports = function() { return function(t, e) { if(t.data && t.isImage) { var r = new n.BaseTexture(t.data, null, n.utils.getResolutionOfUrl(t.url));
							r.imageUrl = t.url, t.texture = new n.Texture(r), n.utils.BaseTextureCache[t.url] = r, n.utils.TextureCache[t.url] = t.texture } e() } } }, { "../core": 23 }],
			118: [function(t, e, r) {
				function n(t, e, r, o, s) { i.Container.call(this), this._texture = null, this.uvs = r || new Float32Array([0, 0, 1, 0, 1, 1, 0, 1]), this.vertices = e || new Float32Array([0, 0, 100, 0, 100, 100, 0, 100]), this.indices = o || new Uint16Array([0, 1, 3, 2]), this.dirty = !0, this.blendMode = i.BLEND_MODES.NORMAL, this.canvasPadding = 0, this.drawMode = s || n.DRAW_MODES.TRIANGLE_MESH, this.texture = t, this.shader = null } var i = t("../core"),
					o = new i.Point,
					s = new i.Polygon;
				n.prototype = Object.create(i.Container.prototype), n.prototype.constructor = n, e.exports = n, Object.defineProperties(n.prototype, { texture: { get: function() { return this._texture }, set: function(t) { this._texture !== t && (this._texture = t, t && (t.baseTexture.hasLoaded ? this._onTextureUpdate() : t.once("update", this._onTextureUpdate, this))) } } }), n.prototype._renderWebGL = function(t) { t.setObjectRenderer(t.plugins.mesh), t.plugins.mesh.render(this) }, n.prototype._renderCanvas = function(t) { var e = t.context,
						r = this.worldTransform;
					t.roundPixels ? e.setTransform(r.a, r.b, r.c, r.d, 0 | r.tx, 0 | r.ty) : e.setTransform(r.a, r.b, r.c, r.d, r.tx, r.ty), this.drawMode === n.DRAW_MODES.TRIANGLE_MESH ? this._renderCanvasTriangleMesh(e) : this._renderCanvasTriangles(e) }, n.prototype._renderCanvasTriangleMesh = function(t) { for(var e = this.vertices, r = this.uvs, n = e.length / 2, i = 0; n - 2 > i; i++) { var o = 2 * i;
						this._renderCanvasDrawTriangle(t, e, r, o, o + 2, o + 4) } }, n.prototype._renderCanvasTriangles = function(t) { for(var e = this.vertices, r = this.uvs, n = this.indices, i = n.length, o = 0; i > o; o += 3) { var s = 2 * n[o],
							a = 2 * n[o + 1],
							l = 2 * n[o + 2];
						this._renderCanvasDrawTriangle(t, e, r, s, a, l) } }, n.prototype._renderCanvasDrawTriangle = function(t, e, r, n, i, o) { var s = this._texture.baseTexture.source,
						a = this._texture.baseTexture.width,
						l = this._texture.baseTexture.height,
						u = e[n],
						h = e[i],
						c = e[o],
						p = e[n + 1],
						d = e[i + 1],
						f = e[o + 1],
						v = r[n] * a,
						g = r[i] * a,
						m = r[o] * a,
						y = r[n + 1] * l,
						T = r[i + 1] * l,
						x = r[o + 1] * l; if(this.canvasPadding > 0) { var b = this.canvasPadding / this.worldTransform.a,
							S = this.canvasPadding / this.worldTransform.d,
							E = (u + h + c) / 3,
							A = (p + d + f) / 3,
							_ = u - E,
							M = p - A,
							w = Math.sqrt(_ * _ + M * M);
						u = E + _ / w * (w + b), p = A + M / w * (w + S), _ = h - E, M = d - A, w = Math.sqrt(_ * _ + M * M), h = E + _ / w * (w + b), d = A + M / w * (w + S), _ = c - E, M = f - A, w = Math.sqrt(_ * _ + M * M), c = E + _ / w * (w + b), f = A + M / w * (w + S) } t.save(), t.beginPath(), t.moveTo(u, p), t.lineTo(h, d), t.lineTo(c, f), t.closePath(), t.clip(); var C = v * T + y * m + g * x - T * m - y * g - v * x,
						P = u * T + y * c + h * x - T * c - y * h - u * x,
						R = v * h + u * m + g * c - h * m - u * g - v * c,
						D = v * T * c + y * h * m + u * g * x - u * T * m - y * g * c - v * h * x,
						B = p * T + y * f + d * x - T * f - y * d - p * x,
						O = v * d + p * m + g * f - d * m - p * g - v * f,
						F = v * T * f + y * d * m + p * g * x - p * T * m - y * g * f - v * d * x;
					t.transform(P / C, B / C, R / C, O / C, D / C, F / C), t.drawImage(s, 0, 0), t.restore() }, n.prototype.renderMeshFlat = function(t) { var e = this.context,
						r = t.vertices,
						n = r.length / 2;
					e.beginPath(); for(var i = 1; n - 2 > i; i++) { var o = 2 * i,
							s = r[o],
							a = r[o + 2],
							l = r[o + 4],
							u = r[o + 1],
							h = r[o + 3],
							c = r[o + 5];
						e.moveTo(s, u), e.lineTo(a, h), e.lineTo(l, c) } e.fillStyle = "#FF0000", e.fill(), e.closePath() }, n.prototype._onTextureUpdate = function() { this.updateFrame = !0 }, n.prototype.getBounds = function(t) { if(!this._currentBounds) { for(var e = t || this.worldTransform, r = e.a, n = e.b, o = e.c, s = e.d, a = e.tx, l = e.ty, u = -(1 / 0), h = -(1 / 0), c = 1 / 0, p = 1 / 0, d = this.vertices, f = 0, v = d.length; v > f; f += 2) { var g = d[f],
								m = d[f + 1],
								y = r * g + o * m + a,
								T = s * m + n * g + l;
							c = c > y ? y : c, p = p > T ? T : p, u = y > u ? y : u, h = T > h ? T : h } if(c === -(1 / 0) || h === 1 / 0) return i.Rectangle.EMPTY; var x = this._bounds;
						x.x = c, x.width = u - c, x.y = p, x.height = h - p, this._currentBounds = x } return this._currentBounds }, n.prototype.containsPoint = function(t) { if(!this.getBounds().contains(t.x, t.y)) return !1;
					this.worldTransform.applyInverse(t, o); var e, r, i = this.vertices,
						a = s.points; if(this.drawMode === n.DRAW_MODES.TRIANGLES) { var l = this.indices; for(r = this.indices.length, e = 0; r > e; e += 3) { var u = 2 * l[e],
								h = 2 * l[e + 1],
								c = 2 * l[e + 2]; if(a[0] = i[u], a[1] = i[u + 1], a[2] = i[h], a[3] = i[h + 1], a[4] = i[c], a[5] = i[c + 1], s.contains(o.x, o.y)) return !0 } } else
						for(r = i.length, e = 0; r > e; e += 6)
							if(a[0] = i[e], a[1] = i[e + 1], a[2] = i[e + 2], a[3] = i[e + 3], a[4] = i[e + 4], a[5] = i[e + 5], s.contains(o.x, o.y)) return !0; return !1 }, n.DRAW_MODES = { TRIANGLE_MESH: 0, TRIANGLES: 1 } }, { "../core": 23 }],
			119: [function(t, e, r) {
				function n(t, e, r) { i.call(this, t), this._ready = !0, this.segmentsX = e || 10, this.segmentsY = r || 10, this.drawMode = i.DRAW_MODES.TRIANGLES, this.refresh() } var i = t("./Mesh");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.refresh = function() { var t = this.segmentsX * this.segmentsY,
						e = [],
						r = [],
						n = [],
						i = [],
						o = this.texture,
						s = this.segmentsX - 1,
						a = this.segmentsY - 1,
						l = 0,
						u = o.width / s,
						h = o.height / a; for(l = 0; t > l; l++) { var c = l % this.segmentsX,
							p = l / this.segmentsX | 0;
						e.push(c * u, p * h), n.push(c / (this.segmentsX - 1), p / (this.segmentsY - 1)) } var d = s * a; for(l = 0; d > l; l++) { var f = l % s,
							v = l / s | 0,
							g = v * this.segmentsX + f,
							m = v * this.segmentsX + f + 1,
							y = (v + 1) * this.segmentsX + f,
							T = (v + 1) * this.segmentsX + f + 1;
						i.push(g, m, y), i.push(m, T, y) } this.vertices = new Float32Array(e), this.uvs = new Float32Array(n), this.colors = new Float32Array(r), this.indices = new Uint16Array(i) }, n.prototype._onTextureUpdate = function() { i.prototype._onTextureUpdate.call(this), this._ready && this.refresh() } }, { "./Mesh": 118 }],
			120: [function(t, e, r) {
				function n(t, e) { i.call(this, t), this.points = e, this.vertices = new Float32Array(4 * e.length), this.uvs = new Float32Array(4 * e.length), this.colors = new Float32Array(2 * e.length), this.indices = new Uint16Array(2 * e.length), this._ready = !0, this.refresh() } var i = t("./Mesh"),
					o = t("../core");
				n.prototype = Object.create(i.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.refresh = function() { var t = this.points; if(!(t.length < 1) && this._texture._uvs) { var e = this.uvs,
							r = this.indices,
							n = this.colors,
							i = this._texture._uvs,
							s = new o.Point(i.x0, i.y0),
							a = new o.Point(i.x2 - i.x0, i.y2 - i.y0);
						e[0] = 0 + s.x, e[1] = 0 + s.y, e[2] = 0 + s.x, e[3] = 1 * a.y + s.y, n[0] = 1, n[1] = 1, r[0] = 0, r[1] = 1; for(var l, u, h, c = t.length, p = 1; c > p; p++) l = t[p], u = 4 * p, h = p / (c - 1), e[u] = h * a.x + s.x, e[u + 1] = 0 + s.y, e[u + 2] = h * a.x + s.x, e[u + 3] = 1 * a.y + s.y, u = 2 * p, n[u] = 1, n[u + 1] = 1, u = 2 * p, r[u] = u, r[u + 1] = u + 1;
						this.dirty = !0 } }, n.prototype._onTextureUpdate = function() { i.prototype._onTextureUpdate.call(this), this._ready && this.refresh() }, n.prototype.updateTransform = function() { var t = this.points; if(!(t.length < 1)) { for(var e, r, n, i, o, s, a = t[0], l = 0, u = 0, h = this.vertices, c = t.length, p = 0; c > p; p++) r = t[p], n = 4 * p, e = p < t.length - 1 ? t[p + 1] : r, u = -(e.x - a.x), l = e.y - a.y, i = 10 * (1 - p / (c - 1)), i > 1 && (i = 1), o = Math.sqrt(l * l + u * u), s = this._texture.height / 2, l /= o, u /= o, l *= s, u *= s, h[n] = r.x + l, h[n + 1] = r.y + u, h[n + 2] = r.x - l, h[n + 3] = r.y - u, a = r;
						this.containerUpdateTransform() } } }, { "../core": 23, "./Mesh": 118 }],
			121: [function(t, e, r) { e.exports = { Mesh: t("./Mesh"), Plane: t("./Plane"), Rope: t("./Rope"), MeshRenderer: t("./webgl/MeshRenderer"), MeshShader: t("./webgl/MeshShader") } }, { "./Mesh": 118, "./Plane": 119, "./Rope": 120, "./webgl/MeshRenderer": 122, "./webgl/MeshShader": 123 }],
			122: [function(t, e, r) {
				function n(t) { i.ObjectRenderer.call(this, t), this.indices = new Uint16Array(15e3); for(var e = 0, r = 0; 15e3 > e; e += 6, r += 4) this.indices[e + 0] = r + 0, this.indices[e + 1] = r + 1, this.indices[e + 2] = r + 2, this.indices[e + 3] = r + 0, this.indices[e + 4] = r + 2, this.indices[e + 5] = r + 3;
					this.currentShader = null } var i = t("../../core"),
					o = t("../Mesh");
				n.prototype = Object.create(i.ObjectRenderer.prototype), n.prototype.constructor = n, e.exports = n, i.WebGLRenderer.registerPlugin("mesh", n), n.prototype.onContextChange = function() {}, n.prototype.render = function(t) { t._vertexBuffer || this._initWebGL(t); var e = this.renderer,
						r = e.gl,
						n = t._texture.baseTexture,
						i = t.shader,
						s = t.drawMode === o.DRAW_MODES.TRIANGLE_MESH ? r.TRIANGLE_STRIP : r.TRIANGLES;
					e.blendModeManager.setBlendMode(t.blendMode), i = i ? i.shaders[r.id] || i.getShader(e) : e.shaderManager.plugins.meshShader, this.renderer.shaderManager.setShader(i), i.uniforms.translationMatrix.value = t.worldTransform.toArray(!0), i.uniforms.projectionMatrix.value = e.currentRenderTarget.projectionMatrix.toArray(!0), i.uniforms.alpha.value = t.worldAlpha, i.syncUniforms(), t.dirty ? (t.dirty = !1, r.bindBuffer(r.ARRAY_BUFFER, t._vertexBuffer), r.bufferData(r.ARRAY_BUFFER, t.vertices, r.STATIC_DRAW), r.vertexAttribPointer(i.attributes.aVertexPosition, 2, r.FLOAT, !1, 0, 0), r.bindBuffer(r.ARRAY_BUFFER, t._uvBuffer), r.bufferData(r.ARRAY_BUFFER, t.uvs, r.STATIC_DRAW), r.vertexAttribPointer(i.attributes.aTextureCoord, 2, r.FLOAT, !1, 0, 0), r.activeTexture(r.TEXTURE0), n._glTextures[r.id] ? r.bindTexture(r.TEXTURE_2D, n._glTextures[r.id]) : this.renderer.updateTexture(n), r.bindBuffer(r.ELEMENT_ARRAY_BUFFER, t._indexBuffer), r.bufferData(r.ELEMENT_ARRAY_BUFFER, t.indices, r.STATIC_DRAW)) : (r.bindBuffer(r.ARRAY_BUFFER, t._vertexBuffer), r.bufferSubData(r.ARRAY_BUFFER, 0, t.vertices), r.vertexAttribPointer(i.attributes.aVertexPosition, 2, r.FLOAT, !1, 0, 0), r.bindBuffer(r.ARRAY_BUFFER, t._uvBuffer), r.vertexAttribPointer(i.attributes.aTextureCoord, 2, r.FLOAT, !1, 0, 0), r.activeTexture(r.TEXTURE0), n._glTextures[r.id] ? r.bindTexture(r.TEXTURE_2D, n._glTextures[r.id]) : this.renderer.updateTexture(n), r.bindBuffer(r.ELEMENT_ARRAY_BUFFER, t._indexBuffer), r.bufferSubData(r.ELEMENT_ARRAY_BUFFER, 0, t.indices)), r.drawElements(s, t.indices.length, r.UNSIGNED_SHORT, 0) }, n.prototype._initWebGL = function(t) { var e = this.renderer.gl;
					t._vertexBuffer = e.createBuffer(), t._indexBuffer = e.createBuffer(), t._uvBuffer = e.createBuffer(), e.bindBuffer(e.ARRAY_BUFFER, t._vertexBuffer), e.bufferData(e.ARRAY_BUFFER, t.vertices, e.DYNAMIC_DRAW), e.bindBuffer(e.ARRAY_BUFFER, t._uvBuffer), e.bufferData(e.ARRAY_BUFFER, t.uvs, e.STATIC_DRAW), t.colors && (t._colorBuffer = e.createBuffer(), e.bindBuffer(e.ARRAY_BUFFER, t._colorBuffer), e.bufferData(e.ARRAY_BUFFER, t.colors, e.STATIC_DRAW)), e.bindBuffer(e.ELEMENT_ARRAY_BUFFER, t._indexBuffer), e.bufferData(e.ELEMENT_ARRAY_BUFFER, t.indices, e.STATIC_DRAW) }, n.prototype.flush = function() {}, n.prototype.start = function() { this.currentShader = null }, n.prototype.destroy = function() { i.ObjectRenderer.prototype.destroy.call(this) } }, { "../../core": 23, "../Mesh": 118 }],
			123: [function(t, e, r) {
				function n(t) { i.Shader.call(this, t, ["precision lowp float;", "attribute vec2 aVertexPosition;", "attribute vec2 aTextureCoord;", "uniform mat3 translationMatrix;", "uniform mat3 projectionMatrix;", "varying vec2 vTextureCoord;", "void main(void){", "   gl_Position = vec4((projectionMatrix * translationMatrix * vec3(aVertexPosition, 1.0)).xy, 0.0, 1.0);", "   vTextureCoord = aTextureCoord;", "}"].join("\n"), ["precision lowp float;", "varying vec2 vTextureCoord;", "uniform float alpha;", "uniform sampler2D uSampler;", "void main(void){", "   gl_FragColor = texture2D(uSampler, vTextureCoord) * alpha ;", "}"].join("\n"), { alpha: { type: "1f", value: 0 }, translationMatrix: { type: "mat3", value: new Float32Array(9) }, projectionMatrix: { type: "mat3", value: new Float32Array(9) } }, { aVertexPosition: 0, aTextureCoord: 0 }) } var i = t("../../core");
				n.prototype = Object.create(i.Shader.prototype), n.prototype.constructor = n, e.exports = n, i.ShaderManager.registerPlugin("meshShader", n) }, { "../../core": 23 }],
			124: [function(t, e, r) { Math.sign || (Math.sign = function(t) { return t = +t, 0 === t || isNaN(t) ? t : t > 0 ? 1 : -1 }) }, {}],
			125: [function(t, e, r) { Object.assign || (Object.assign = t("object-assign")) }, { "object-assign": 11 }],
			126: [function(t, e, r) { t("./Object.assign"), t("./requestAnimationFrame"), t("./Math.sign") }, { "./Math.sign": 124, "./Object.assign": 125, "./requestAnimationFrame": 127 }],
			127: [function(t, e, r) {
				(function(t) { if(Date.now && Date.prototype.getTime || (Date.now = function() { return(new Date).getTime() }), !t.performance || !t.performance.now) { var e = Date.now();
						t.performance || (t.performance = {}), t.performance.now = function() { return Date.now() - e } } for(var r = Date.now(), n = ["ms", "moz", "webkit", "o"], i = 0; i < n.length && !t.requestAnimationFrame; ++i) t.requestAnimationFrame = t[n[i] + "RequestAnimationFrame"], t.cancelAnimationFrame = t[n[i] + "CancelAnimationFrame"] || t[n[i] + "CancelRequestAnimationFrame"];
					t.requestAnimationFrame || (t.requestAnimationFrame = function(t) { if("function" != typeof t) throw new TypeError(t + "is not a function"); var e = Date.now(),
							n = 16 + r - e; return 0 > n && (n = 0), r = e, setTimeout(function() { r = Date.now(), t(performance.now()) }, n) }), t.cancelAnimationFrame || (t.cancelAnimationFrame = function(t) { clearTimeout(t) }) }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}) }, {}],
			128: [function(e, r, n) {
				(function(e) {
					! function() {
						function n(t) { var e = !1; return function() { if(e) throw new Error("Callback was already called.");
								e = !0, t.apply(i, arguments) } }
						var i, o, s = {};
						i = this, null != i && (o = i.async), s.noConflict = function() { return i.async = o, s };
						var a = Object.prototype.toString,
							l = Array.isArray || function(t) { return "[object Array]" === a.call(t) },
							u = function(t, e) { if(t.forEach) return t.forEach(e); for(var r = 0; r < t.length; r += 1) e(t[r], r, t) },
							h = function(t, e) { if(t.map) return t.map(e); var r = []; return u(t, function(t, n, i) { r.push(e(t, n, i)) }), r },
							c = function(t, e, r) { return t.reduce ? t.reduce(e, r) : (u(t, function(t, n, i) { r = e(r, t, n, i) }), r) },
							p = function(t) { if(Object.keys) return Object.keys(t); var e = []; for(var r in t) t.hasOwnProperty(r) && e.push(r); return e };
						"undefined" != typeof e && e.nextTick ? (s.nextTick = e.nextTick, "undefined" != typeof setImmediate ? s.setImmediate = function(t) { setImmediate(t) } : s.setImmediate = s.nextTick) : "function" == typeof setImmediate ? (s.nextTick = function(t) { setImmediate(t) }, s.setImmediate = s.nextTick) : (s.nextTick = function(t) { setTimeout(t, 0) }, s.setImmediate = s.nextTick), s.each = function(t, e, r) {
							function i(e) { e ? (r(e), r = function() {}) : (o += 1, o >= t.length && r()) } if(r = r || function() {}, !t.length) return r(); var o = 0;
							u(t, function(t) { e(t, n(i)) }) }, s.forEach = s.each, s.eachSeries = function(t, e, r) { if(r = r || function() {}, !t.length) return r(); var n = 0,
								i = function() { e(t[n], function(e) { e ? (r(e), r = function() {}) : (n += 1, n >= t.length ? r() : i()) }) };
							i() }, s.forEachSeries = s.eachSeries, s.eachLimit = function(t, e, r, n) { var i = d(e);
							i.apply(null, [t, r, n]) }, s.forEachLimit = s.eachLimit;
						var d = function(t) { return function(e, r, n) { if(n = n || function() {}, !e.length || 0 >= t) return n(); var i = 0,
										o = 0,
										s = 0;! function a() { if(i >= e.length) return n(); for(; t > s && o < e.length;) o += 1, s += 1, r(e[o - 1], function(t) { t ? (n(t), n = function() {}) : (i += 1, s -= 1, i >= e.length ? n() : a()) }) }() } },
							f = function(t) { return function() { var e = Array.prototype.slice.call(arguments); return t.apply(null, [s.each].concat(e)) } },
							v = function(t, e) { return function() { var r = Array.prototype.slice.call(arguments); return e.apply(null, [d(t)].concat(r)) } },
							g = function(t) { return function() { var e = Array.prototype.slice.call(arguments); return t.apply(null, [s.eachSeries].concat(e)) } },
							m = function(t, e, r, n) { if(e = h(e, function(t, e) { return { index: e, value: t } }), n) { var i = [];
									t(e, function(t, e) { r(t.value, function(r, n) { i[t.index] = n, e(r) }) }, function(t) { n(t, i) }) } else t(e, function(t, e) { r(t.value, function(t) { e(t) }) }) };
						s.map = f(m), s.mapSeries = g(m), s.mapLimit = function(t, e, r, n) { return y(e)(t, r, n) };
						var y = function(t) { return v(t, m) };
						s.reduce = function(t, e, r, n) { s.eachSeries(t, function(t, n) { r(e, t, function(t, r) { e = r, n(t) }) }, function(t) { n(t, e) }) }, s.inject = s.reduce, s.foldl = s.reduce, s.reduceRight = function(t, e, r, n) { var i = h(t, function(t) { return t }).reverse();
							s.reduce(i, e, r, n) }, s.foldr = s.reduceRight;
						var T = function(t, e, r, n) { var i = [];
							e = h(e, function(t, e) { return { index: e, value: t } }), t(e, function(t, e) { r(t.value, function(r) { r && i.push(t), e() }) }, function(t) { n(h(i.sort(function(t, e) { return t.index - e.index }), function(t) { return t.value })) }) };
						s.filter = f(T), s.filterSeries = g(T), s.select = s.filter, s.selectSeries = s.filterSeries;
						var x = function(t, e, r, n) { var i = [];
							e = h(e, function(t, e) { return { index: e, value: t } }), t(e, function(t, e) { r(t.value, function(r) { r || i.push(t), e() }) }, function(t) { n(h(i.sort(function(t, e) { return t.index - e.index }), function(t) { return t.value })) }) };
						s.reject = f(x), s.rejectSeries = g(x);
						var b = function(t, e, r, n) { t(e, function(t, e) { r(t, function(r) { r ? (n(t), n = function() {}) : e() }) }, function(t) { n() }) };
						s.detect = f(b), s.detectSeries = g(b), s.some = function(t, e, r) { s.each(t, function(t, n) { e(t, function(t) { t && (r(!0), r = function() {}), n() }) }, function(t) { r(!1) }) }, s.any = s.some, s.every = function(t, e, r) { s.each(t, function(t, n) { e(t, function(t) { t || (r(!1), r = function() {}), n() }) }, function(t) { r(!0) }) }, s.all = s.every, s.sortBy = function(t, e, r) { s.map(t, function(t, r) { e(t, function(e, n) { e ? r(e) : r(null, { value: t, criteria: n }) }) }, function(t, e) { if(t) return r(t); var n = function(t, e) { var r = t.criteria,
										n = e.criteria; return n > r ? -1 : r > n ? 1 : 0 };
								r(null, h(e.sort(n), function(t) { return t.value })) }) }, s.auto = function(t, e) { e = e || function() {}; var r = p(t),
								n = r.length; if(!n) return e(); var i = {},
								o = [],
								a = function(t) { o.unshift(t) },
								h = function(t) { for(var e = 0; e < o.length; e += 1)
										if(o[e] === t) return void o.splice(e, 1) },
								d = function() { n--, u(o.slice(0), function(t) { t() }) };
							a(function() { if(!n) { var t = e;
									e = function() {}, t(null, i) } }), u(r, function(r) { var n = l(t[r]) ? t[r] : [t[r]],
									o = function(t) { var n = Array.prototype.slice.call(arguments, 1); if(n.length <= 1 && (n = n[0]), t) { var o = {};
											u(p(i), function(t) { o[t] = i[t] }), o[r] = n, e(t, o), e = function() {} } else i[r] = n, s.setImmediate(d) },
									f = n.slice(0, Math.abs(n.length - 1)) || [],
									v = function() { return c(f, function(t, e) { return t && i.hasOwnProperty(e) }, !0) && !i.hasOwnProperty(r) }; if(v()) n[n.length - 1](o, i);
								else { var g = function() { v() && (h(g), n[n.length - 1](o, i)) };
									a(g) } }) }, s.retry = function(t, e, r) { var n = 5,
								i = []; "function" == typeof t && (r = e, e = t, t = n), t = parseInt(t, 10) || n; var o = function(n, o) { for(var a = function(t, e) { return function(r) { t(function(t, n) { r(!t || e, { err: t, result: n }) }, o) } }; t;) i.push(a(e, !(t -= 1)));
								s.series(i, function(t, e) { e = e[e.length - 1], (n || r)(e.err, e.result) }) }; return r ? o() : o }, s.waterfall = function(t, e) { if(e = e || function() {}, !l(t)) { var r = new Error("First argument to waterfall must be an array of functions"); return e(r) } if(!t.length) return e(); var n = function(t) { return function(r) { if(r) e.apply(null, arguments), e = function() {};
									else { var i = Array.prototype.slice.call(arguments, 1),
											o = t.next();
										o ? i.push(n(o)) : i.push(e), s.setImmediate(function() { t.apply(null, i) }) } } };
							n(s.iterator(t))() };
						var S = function(t, e, r) { if(r = r || function() {}, l(e)) t.map(e, function(t, e) { t && t(function(t) { var r = Array.prototype.slice.call(arguments, 1);
									r.length <= 1 && (r = r[0]), e.call(null, t, r) }) }, r);
							else { var n = {};
								t.each(p(e), function(t, r) { e[t](function(e) { var i = Array.prototype.slice.call(arguments, 1);
										i.length <= 1 && (i = i[0]), n[t] = i, r(e) }) }, function(t) { r(t, n) }) } };
						s.parallel = function(t, e) { S({ map: s.map, each: s.each }, t, e) }, s.parallelLimit = function(t, e, r) { S({ map: y(e), each: d(e) }, t, r) }, s.series = function(t, e) { if(e = e || function() {}, l(t)) s.mapSeries(t, function(t, e) { t && t(function(t) { var r = Array.prototype.slice.call(arguments, 1);
									r.length <= 1 && (r = r[0]), e.call(null, t, r) }) }, e);
							else { var r = {};
								s.eachSeries(p(t), function(e, n) { t[e](function(t) { var i = Array.prototype.slice.call(arguments, 1);
										i.length <= 1 && (i = i[0]), r[e] = i, n(t) }) }, function(t) { e(t, r) }) } }, s.iterator = function(t) { var e = function(r) { var n = function() { return t.length && t[r].apply(null, arguments), n.next() }; return n.next = function() { return r < t.length - 1 ? e(r + 1) : null }, n }; return e(0) }, s.apply = function(t) { var e = Array.prototype.slice.call(arguments, 1); return function() { return t.apply(null, e.concat(Array.prototype.slice.call(arguments))) } };
						var E = function(t, e, r, n) { var i = [];
							t(e, function(t, e) { r(t, function(t, r) { i = i.concat(r || []), e(t) }) }, function(t) { n(t, i) }) };
						s.concat = f(E), s.concatSeries = g(E), s.whilst = function(t, e, r) { t() ? e(function(n) { return n ? r(n) : void s.whilst(t, e, r) }) : r() }, s.doWhilst = function(t, e, r) { t(function(n) { if(n) return r(n); var i = Array.prototype.slice.call(arguments, 1);
								e.apply(null, i) ? s.doWhilst(t, e, r) : r() }) }, s.until = function(t, e, r) { t() ? r() : e(function(n) { return n ? r(n) : void s.until(t, e, r) }) }, s.doUntil = function(t, e, r) { t(function(n) { if(n) return r(n); var i = Array.prototype.slice.call(arguments, 1);
								e.apply(null, i) ? r() : s.doUntil(t, e, r) }) }, s.queue = function(t, e) {
							function r(t, e, r, n) { return t.started || (t.started = !0), l(e) || (e = [e]), 0 == e.length ? s.setImmediate(function() { t.drain && t.drain() }) : void u(e, function(e) { var i = { data: e, callback: "function" == typeof n ? n : null };
									r ? t.tasks.unshift(i) : t.tasks.push(i), t.saturated && t.tasks.length === t.concurrency && t.saturated(), s.setImmediate(t.process) }) } void 0 === e && (e = 1); var i = 0,
								o = { tasks: [], concurrency: e, saturated: null, empty: null, drain: null, started: !1, paused: !1, push: function(t, e) { r(o, t, !1, e) }, kill: function() { o.drain = null, o.tasks = [] }, unshift: function(t, e) { r(o, t, !0, e) }, process: function() { if(!o.paused && i < o.concurrency && o.tasks.length) { var e = o.tasks.shift();
											o.empty && 0 === o.tasks.length && o.empty(), i += 1; var r = function() { i -= 1, e.callback && e.callback.apply(e, arguments), o.drain && o.tasks.length + i === 0 && o.drain(), o.process() },
												s = n(r);
											t(e.data, s) } }, length: function() { return o.tasks.length }, running: function() { return i }, idle: function() { return o.tasks.length + i === 0 }, pause: function() { o.paused !== !0 && (o.paused = !0, o.process()) }, resume: function() { o.paused !== !1 && (o.paused = !1, o.process()) } }; return o }, s.priorityQueue = function(t, e) {
							function r(t, e) { return t.priority - e.priority }

							function n(t, e, r) { for(var n = -1, i = t.length - 1; i > n;) { var o = n + (i - n + 1 >>> 1);
									r(e, t[o]) >= 0 ? n = o : i = o - 1 } return n }

							function i(t, e, i, o) { return t.started || (t.started = !0), l(e) || (e = [e]), 0 == e.length ? s.setImmediate(function() { t.drain && t.drain() }) : void u(e, function(e) { var a = { data: e, priority: i, callback: "function" == typeof o ? o : null };
									t.tasks.splice(n(t.tasks, a, r) + 1, 0, a), t.saturated && t.tasks.length === t.concurrency && t.saturated(), s.setImmediate(t.process) }) } var o = s.queue(t, e); return o.push = function(t, e, r) { i(o, t, e, r) }, delete o.unshift, o }, s.cargo = function(t, e) { var r = !1,
								n = [],
								i = { tasks: n, payload: e, saturated: null, empty: null, drain: null, drained: !0, push: function(t, r) { l(t) || (t = [t]), u(t, function(t) { n.push({ data: t, callback: "function" == typeof r ? r : null }), i.drained = !1, i.saturated && n.length === e && i.saturated() }), s.setImmediate(i.process) }, process: function o() { if(!r) { if(0 === n.length) return i.drain && !i.drained && i.drain(), void(i.drained = !0); var s = "number" == typeof e ? n.splice(0, e) : n.splice(0, n.length),
												a = h(s, function(t) { return t.data });
											i.empty && i.empty(), r = !0, t(a, function() { r = !1; var t = arguments;
												u(s, function(e) { e.callback && e.callback.apply(null, t) }), o() }) } }, length: function() { return n.length }, running: function() { return r } }; return i };
						var A = function(t) { return function(e) { var r = Array.prototype.slice.call(arguments, 1);
								e.apply(null, r.concat([function(e) { var r = Array.prototype.slice.call(arguments, 1); "undefined" != typeof console && (e ? console.error && console.error(e) : console[t] && u(r, function(e) { console[t](e) })) }])) } };
						s.log = A("log"), s.dir = A("dir"), s.memoize = function(t, e) { var r = {},
								n = {};
							e = e || function(t) { return t }; var i = function() { var i = Array.prototype.slice.call(arguments),
									o = i.pop(),
									a = e.apply(null, i);
								a in r ? s.nextTick(function() { o.apply(null, r[a]) }) : a in n ? n[a].push(o) : (n[a] = [o], t.apply(null, i.concat([function() { r[a] = arguments; var t = n[a];
									delete n[a]; for(var e = 0, i = t.length; i > e; e++) t[e].apply(null, arguments) }]))) }; return i.memo = r, i.unmemoized = t, i }, s.unmemoize = function(t) { return function() { return(t.unmemoized || t).apply(null, arguments) } }, s.times = function(t, e, r) { for(var n = [], i = 0; t > i; i++) n.push(i); return s.map(n, e, r) }, s.timesSeries = function(t, e, r) { for(var n = [], i = 0; t > i; i++) n.push(i); return s.mapSeries(n, e, r) }, s.seq = function() { var t = arguments; return function() { var e = this,
									r = Array.prototype.slice.call(arguments),
									n = r.pop();
								s.reduce(t, r, function(t, r, n) { r.apply(e, t.concat([function() { var t = arguments[0],
											e = Array.prototype.slice.call(arguments, 1);
										n(t, e) }])) }, function(t, r) { n.apply(e, [t].concat(r)) }) } }, s.compose = function() { return s.seq.apply(null, Array.prototype.reverse.call(arguments)) };
						var _ = function(t, e) { var r = function() { var r = this,
									n = Array.prototype.slice.call(arguments),
									i = n.pop(); return t(e, function(t, e) { t.apply(r, n.concat([e])) }, i) }; if(arguments.length > 2) { var n = Array.prototype.slice.call(arguments, 2); return r.apply(this, n) } return r };
						s.applyEach = f(_), s.applyEachSeries = g(_), s.forever = function(t, e) {
							function r(n) { if(n) { if(e) return e(n); throw n } t(r) } r();
						}, "undefined" != typeof r && r.exports ? r.exports = s : "undefined" != typeof t && t.amd ? t([], function() { return s }) : i.async = s
					}()
				}).call(this, e("_process"))
			}, { _process: 3 }],
			129: [function(t, e, r) { "use strict";

				function n(t, e, r) { this.fn = t, this.context = e, this.once = r || !1 }

				function i() {} var o = "function" != typeof Object.create ? "~" : !1;
				i.prototype._events = void 0, i.prototype.listeners = function(t, e) { var r = o ? o + t : t,
						n = this._events && this._events[r]; if(e) return !!n; if(!n) return []; if(this._events[r].fn) return [this._events[r].fn]; for(var i = 0, s = this._events[r].length, a = new Array(s); s > i; i++) a[i] = this._events[r][i].fn; return a }, i.prototype.emit = function(t, e, r, n, i, s) { var a = o ? o + t : t; if(!this._events || !this._events[a]) return !1; var l, u, h = this._events[a],
						c = arguments.length; if("function" == typeof h.fn) { switch(h.once && this.removeListener(t, h.fn, void 0, !0), c) {
							case 1:
								return h.fn.call(h.context), !0;
							case 2:
								return h.fn.call(h.context, e), !0;
							case 3:
								return h.fn.call(h.context, e, r), !0;
							case 4:
								return h.fn.call(h.context, e, r, n), !0;
							case 5:
								return h.fn.call(h.context, e, r, n, i), !0;
							case 6:
								return h.fn.call(h.context, e, r, n, i, s), !0 } for(u = 1, l = new Array(c - 1); c > u; u++) l[u - 1] = arguments[u];
						h.fn.apply(h.context, l) } else { var p, d = h.length; for(u = 0; d > u; u++) switch(h[u].once && this.removeListener(t, h[u].fn, void 0, !0), c) {
							case 1:
								h[u].fn.call(h[u].context); break;
							case 2:
								h[u].fn.call(h[u].context, e); break;
							case 3:
								h[u].fn.call(h[u].context, e, r); break;
							default:
								if(!l)
									for(p = 1, l = new Array(c - 1); c > p; p++) l[p - 1] = arguments[p];
								h[u].fn.apply(h[u].context, l) } } return !0 }, i.prototype.on = function(t, e, r) { var i = new n(e, r || this),
						s = o ? o + t : t; return this._events || (this._events = o ? {} : Object.create(null)), this._events[s] ? this._events[s].fn ? this._events[s] = [this._events[s], i] : this._events[s].push(i) : this._events[s] = i, this }, i.prototype.once = function(t, e, r) { var i = new n(e, r || this, !0),
						s = o ? o + t : t; return this._events || (this._events = o ? {} : Object.create(null)), this._events[s] ? this._events[s].fn ? this._events[s] = [this._events[s], i] : this._events[s].push(i) : this._events[s] = i, this }, i.prototype.removeListener = function(t, e, r, n) { var i = o ? o + t : t; if(!this._events || !this._events[i]) return this; var s = this._events[i],
						a = []; if(e)
						if(s.fn)(s.fn !== e || n && !s.once || r && s.context !== r) && a.push(s);
						else
							for(var l = 0, u = s.length; u > l; l++)(s[l].fn !== e || n && !s[l].once || r && s[l].context !== r) && a.push(s[l]); return a.length ? this._events[i] = 1 === a.length ? a[0] : a : delete this._events[i], this }, i.prototype.removeAllListeners = function(t) { return this._events ? (t ? delete this._events[o ? o + t : t] : this._events = o ? {} : Object.create(null), this) : this }, i.prototype.off = i.prototype.removeListener, i.prototype.addListener = i.prototype.on, i.prototype.setMaxListeners = function() { return this }, i.prefixed = o, e.exports = i }, {}],
			130: [function(t, e, r) {
				function n(t, e) { a.call(this), e = e || 10, this.baseUrl = t || "", this.progress = 0, this.loading = !1, this._progressChunk = 0, this._beforeMiddleware = [], this._afterMiddleware = [], this._boundLoadResource = this._loadResource.bind(this), this._boundOnLoad = this._onLoad.bind(this), this._buffer = [], this._numToLoad = 0, this._queue = i.queue(this._boundLoadResource, e), this.resources = {} } var i = t("async"),
					o = t("url"),
					s = t("./Resource"),
					a = t("eventemitter3");
				n.prototype = Object.create(a.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.add = n.prototype.enqueue = function(t, e, r, n) { if(Array.isArray(t)) { for(var i = 0; i < t.length; ++i) this.add(t[i]); return this } if("object" == typeof t && (n = e || t.callback || t.onComplete, r = t, e = t.url, t = t.name || t.key || t.url), "string" != typeof e && (n = r, r = e, e = t), "string" != typeof e) throw new Error("No url passed to add resource to loader."); if("function" == typeof r && (n = r, r = null), this.resources[t]) throw new Error('Resource with name "' + t + '" already exists.'); return e = this._handleBaseUrl(e), this.resources[t] = new s(t, e, r), "function" == typeof n && this.resources[t].once("afterMiddleware", n), this._numToLoad++, this._queue.started ? (this._queue.push(this.resources[t]), this._progressChunk = (100 - this.progress) / (this._queue.length() + this._queue.running())) : (this._buffer.push(this.resources[t]), this._progressChunk = 100 / this._buffer.length), this }, n.prototype._handleBaseUrl = function(t) { var e = o.parse(t); return e.protocol || 0 === e.pathname.indexOf("//") ? t : this.baseUrl.length && this.baseUrl.lastIndexOf("/") !== this.baseUrl.length - 1 && "/" !== t.charAt(0) ? this.baseUrl + "/" + t : this.baseUrl + t }, n.prototype.before = n.prototype.pre = function(t) { return this._beforeMiddleware.push(t), this }, n.prototype.after = n.prototype.use = function(t) { return this._afterMiddleware.push(t), this }, n.prototype.reset = function() { this.progress = 0, this.loading = !1, this._progressChunk = 0, this._buffer.length = 0, this._numToLoad = 0, this._queue.kill(), this._queue.started = !1, this.resources = {} }, n.prototype.load = function(t) { if("function" == typeof t && this.once("complete", t), this._queue.started) return this;
					this.emit("start", this); for(var e = 0; e < this._buffer.length; ++e) this._queue.push(this._buffer[e]); return this._buffer.length = 0, this }, n.prototype._loadResource = function(t, e) { var r = this;
					t._dequeue = e, this._runMiddleware(t, this._beforeMiddleware, function() { t.load(r._boundOnLoad) }) }, n.prototype._onComplete = function() { this.emit("complete", this, this.resources) }, n.prototype._onLoad = function(t) { this.progress += this._progressChunk, this.emit("progress", this, t), this._runMiddleware(t, this._afterMiddleware, function() { t.emit("afterMiddleware", t), this._numToLoad--, 0 === this._numToLoad && (this.progress = 100, this._onComplete()), t.error ? this.emit("error", t.error, this, t) : this.emit("load", this, t) }), t._dequeue() }, n.prototype._runMiddleware = function(t, e, r) { var n = this;
					i.eachSeries(e, function(e, r) { e.call(n, t, r) }, r.bind(this, t)) }, n.LOAD_TYPE = s.LOAD_TYPE, n.XHR_READY_STATE = s.XHR_READY_STATE, n.XHR_RESPONSE_TYPE = s.XHR_RESPONSE_TYPE }, { "./Resource": 131, async: 128, eventemitter3: 129, url: 8 }],
			131: [function(t, e, r) {
				function n(t, e, r) { if(s.call(this), r = r || {}, "string" != typeof t || "string" != typeof e) throw new Error("Both name and url are required for constructing a resource.");
					this.name = t, this.url = e, this.isDataUrl = 0 === this.url.indexOf("data:"), this.data = null, this.crossOrigin = r.crossOrigin === !0 ? "anonymous" : r.crossOrigin, this.loadType = r.loadType || this._determineLoadType(), this.xhrType = r.xhrType, this.metadata = r.metadata || {}, this.error = null, this.xhr = null, this.isJson = !1, this.isXml = !1, this.isImage = !1, this.isAudio = !1, this.isVideo = !1, this._dequeue = null, this._boundComplete = this.complete.bind(this), this._boundOnError = this._onError.bind(this), this._boundOnProgress = this._onProgress.bind(this), this._boundXhrOnError = this._xhrOnError.bind(this), this._boundXhrOnAbort = this._xhrOnAbort.bind(this), this._boundXhrOnLoad = this._xhrOnLoad.bind(this), this._boundXdrOnTimeout = this._xdrOnTimeout.bind(this) }

				function i(t) { return t.toString().replace("object ", "") }

				function o(t, e, r) { e && 0 === e.indexOf(".") && (e = e.substring(1)), e && (t[e] = r) } var s = t("eventemitter3"),
					a = t("url"),
					l = !(!window.XDomainRequest || "withCredentials" in new XMLHttpRequest),
					u = null;
				n.prototype = Object.create(s.prototype), n.prototype.constructor = n, e.exports = n, n.prototype.complete = function() { this.data && this.data.removeEventListener && (this.data.removeEventListener("error", this._boundOnError), this.data.removeEventListener("load", this._boundComplete), this.data.removeEventListener("progress", this._boundOnProgress), this.data.removeEventListener("canplaythrough", this._boundComplete)), this.xhr && (this.xhr.removeEventListener ? (this.xhr.removeEventListener("error", this._boundXhrOnError), this.xhr.removeEventListener("abort", this._boundXhrOnAbort), this.xhr.removeEventListener("progress", this._boundOnProgress), this.xhr.removeEventListener("load", this._boundXhrOnLoad)) : (this.xhr.onerror = null, this.xhr.ontimeout = null, this.xhr.onprogress = null, this.xhr.onload = null)), this.emit("complete", this) }, n.prototype.load = function(t) { switch(this.emit("start", this), t && this.once("complete", t), (this.crossOrigin === !1 || "string" != typeof this.crossOrigin) && (this.crossOrigin = this._determineCrossOrigin(this.url)), this.loadType) {
						case n.LOAD_TYPE.IMAGE:
							this._loadImage(); break;
						case n.LOAD_TYPE.AUDIO:
							this._loadElement("audio"); break;
						case n.LOAD_TYPE.VIDEO:
							this._loadElement("video"); break;
						case n.LOAD_TYPE.XHR:
						default:
							l && this.crossOrigin ? this._loadXdr() : this._loadXhr() } }, n.prototype._loadImage = function() { this.data = new Image, this.crossOrigin && (this.data.crossOrigin = this.crossOrigin), this.data.src = this.url, this.isImage = !0, this.data.addEventListener("error", this._boundOnError, !1), this.data.addEventListener("load", this._boundComplete, !1), this.data.addEventListener("progress", this._boundOnProgress, !1) }, n.prototype._loadElement = function(t) { if("audio" === t && "undefined" != typeof Audio ? this.data = new Audio : this.data = document.createElement(t), null === this.data) return this.error = new Error("Unsupported element " + t), void this.complete(); if(navigator.isCocoonJS) this.data.src = Array.isArray(this.url) ? this.url[0] : this.url;
					else if(Array.isArray(this.url))
						for(var e = 0; e < this.url.length; ++e) this.data.appendChild(this._createSource(t, this.url[e]));
					else this.data.appendChild(this._createSource(t, this.url));
					this["is" + t[0].toUpperCase() + t.substring(1)] = !0, this.data.addEventListener("error", this._boundOnError, !1), this.data.addEventListener("load", this._boundComplete, !1), this.data.addEventListener("progress", this._boundOnProgress, !1), this.data.addEventListener("canplaythrough", this._boundComplete, !1), this.data.load() }, n.prototype._loadXhr = function() { "string" != typeof this.xhrType && (this.xhrType = this._determineXhrType()); var t = this.xhr = new XMLHttpRequest;
					t.open("GET", this.url, !0), this.xhrType === n.XHR_RESPONSE_TYPE.JSON || this.xhrType === n.XHR_RESPONSE_TYPE.DOCUMENT ? t.responseType = n.XHR_RESPONSE_TYPE.TEXT : t.responseType = this.xhrType, t.addEventListener("error", this._boundXhrOnError, !1), t.addEventListener("abort", this._boundXhrOnAbort, !1), t.addEventListener("progress", this._boundOnProgress, !1), t.addEventListener("load", this._boundXhrOnLoad, !1), t.send() }, n.prototype._loadXdr = function() { "string" != typeof this.xhrType && (this.xhrType = this._determineXhrType()); var t = this.xhr = new XDomainRequest;
					t.timeout = 5e3, t.onerror = this._boundXhrOnError, t.ontimeout = this._boundXdrOnTimeout, t.onprogress = this._boundOnProgress, t.onload = this._boundXhrOnLoad, t.open("GET", this.url, !0), setTimeout(function() { t.send() }, 0) }, n.prototype._createSource = function(t, e, r) { r || (r = t + "/" + e.substr(e.lastIndexOf(".") + 1)); var n = document.createElement("source"); return n.src = e, n.type = r, n }, n.prototype._onError = function(t) { this.error = new Error("Failed to load element using " + t.target.nodeName), this.complete() }, n.prototype._onProgress = function(t) { t && t.lengthComputable && this.emit("progress", this, t.loaded / t.total) }, n.prototype._xhrOnError = function() { this.error = new Error(i(this.xhr) + " Request failed. Status: " + this.xhr.status + ', text: "' + this.xhr.statusText + '"'), this.complete() }, n.prototype._xhrOnAbort = function() { this.error = new Error(i(this.xhr) + " Request was aborted by the user."), this.complete() }, n.prototype._xdrOnTimeout = function() { this.error = new Error(i(this.xhr) + " Request timed out."), this.complete() }, n.prototype._xhrOnLoad = function() { var t = this.xhr,
						e = void 0 !== t.status ? t.status : 200; if(200 === e || 204 === e || 0 === e && t.responseText.length > 0)
						if(this.xhrType === n.XHR_RESPONSE_TYPE.TEXT) this.data = t.responseText;
						else if(this.xhrType === n.XHR_RESPONSE_TYPE.JSON) try { this.data = JSON.parse(t.responseText), this.isJson = !0 } catch(r) { this.error = new Error("Error trying to parse loaded json:", r) } else if(this.xhrType === n.XHR_RESPONSE_TYPE.DOCUMENT) try { if(window.DOMParser) { var i = new DOMParser;
								this.data = i.parseFromString(t.responseText, "text/xml") } else { var o = document.createElement("div");
								o.innerHTML = t.responseText, this.data = o } this.isXml = !0 } catch(r) { this.error = new Error("Error trying to parse loaded xml:", r) } else this.data = t.response || t.responseText;
						else this.error = new Error("[" + t.status + "]" + t.statusText + ":" + t.responseURL);
					this.complete() }, n.prototype._determineCrossOrigin = function(t, e) { if(0 === t.indexOf("data:")) return "";
					e = e || window.location, u || (u = document.createElement("a")), u.href = t, t = a.parse(u.href); var r = !t.port && "" === e.port || t.port === e.port; return t.hostname === e.hostname && r && t.protocol === e.protocol ? "" : "anonymous" }, n.prototype._determineXhrType = function() { return n._xhrTypeMap[this._getExtension()] || n.XHR_RESPONSE_TYPE.TEXT }, n.prototype._determineLoadType = function() { return n._loadTypeMap[this._getExtension()] || n.LOAD_TYPE.XHR }, n.prototype._getExtension = function() { var t, e = this.url; if(this.isDataUrl) { var r = e.indexOf("/");
						t = e.substring(r + 1, e.indexOf(";", r)) } else { var n = e.indexOf("?"); - 1 !== n && (e = e.substring(0, n)), t = e.substring(e.lastIndexOf(".") + 1) } return t }, n.prototype._getMimeFromXhrType = function(t) { switch(t) {
						case n.XHR_RESPONSE_TYPE.BUFFER:
							return "application/octet-binary";
						case n.XHR_RESPONSE_TYPE.BLOB:
							return "application/blob";
						case n.XHR_RESPONSE_TYPE.DOCUMENT:
							return "application/xml";
						case n.XHR_RESPONSE_TYPE.JSON:
							return "application/json";
						case n.XHR_RESPONSE_TYPE.DEFAULT:
						case n.XHR_RESPONSE_TYPE.TEXT:
						default:
							return "text/plain" } }, n.LOAD_TYPE = { XHR: 1, IMAGE: 2, AUDIO: 3, VIDEO: 4 }, n.XHR_READY_STATE = { UNSENT: 0, OPENED: 1, HEADERS_RECEIVED: 2, LOADING: 3, DONE: 4 }, n.XHR_RESPONSE_TYPE = { DEFAULT: "text", BUFFER: "arraybuffer", BLOB: "blob", DOCUMENT: "document", JSON: "json", TEXT: "text" }, n._loadTypeMap = { gif: n.LOAD_TYPE.IMAGE, png: n.LOAD_TYPE.IMAGE, bmp: n.LOAD_TYPE.IMAGE, jpg: n.LOAD_TYPE.IMAGE, jpeg: n.LOAD_TYPE.IMAGE, tif: n.LOAD_TYPE.IMAGE, tiff: n.LOAD_TYPE.IMAGE, webp: n.LOAD_TYPE.IMAGE, tga: n.LOAD_TYPE.IMAGE }, n._xhrTypeMap = { xhtml: n.XHR_RESPONSE_TYPE.DOCUMENT, html: n.XHR_RESPONSE_TYPE.DOCUMENT, htm: n.XHR_RESPONSE_TYPE.DOCUMENT, xml: n.XHR_RESPONSE_TYPE.DOCUMENT, tmx: n.XHR_RESPONSE_TYPE.DOCUMENT, tsx: n.XHR_RESPONSE_TYPE.DOCUMENT, svg: n.XHR_RESPONSE_TYPE.DOCUMENT, gif: n.XHR_RESPONSE_TYPE.BLOB, png: n.XHR_RESPONSE_TYPE.BLOB, bmp: n.XHR_RESPONSE_TYPE.BLOB, jpg: n.XHR_RESPONSE_TYPE.BLOB, jpeg: n.XHR_RESPONSE_TYPE.BLOB, tif: n.XHR_RESPONSE_TYPE.BLOB, tiff: n.XHR_RESPONSE_TYPE.BLOB, webp: n.XHR_RESPONSE_TYPE.BLOB, tga: n.XHR_RESPONSE_TYPE.BLOB, json: n.XHR_RESPONSE_TYPE.JSON, text: n.XHR_RESPONSE_TYPE.TEXT, txt: n.XHR_RESPONSE_TYPE.TEXT }, n.setExtensionLoadType = function(t, e) { o(n._loadTypeMap, t, e) }, n.setExtensionXhrType = function(t, e) { o(n._xhrTypeMap, t, e) } }, { eventemitter3: 129, url: 8 }],
			132: [function(t, e, r) { e.exports = { _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", encodeBinary: function(t) { for(var e, r = "", n = new Array(4), i = 0, o = 0, s = 0; i < t.length;) { for(e = new Array(3), o = 0; o < e.length; o++) i < t.length ? e[o] = 255 & t.charCodeAt(i++) : e[o] = 0; switch(n[0] = e[0] >> 2, n[1] = (3 & e[0]) << 4 | e[1] >> 4, n[2] = (15 & e[1]) << 2 | e[2] >> 6, n[3] = 63 & e[2], s = i - (t.length - 1)) {
								case 2:
									n[3] = 64, n[2] = 64; break;
								case 1:
									n[3] = 64 } for(o = 0; o < n.length; o++) r += this._keyStr.charAt(n[o]) } return r } } }, {}],
			133: [function(t, e, r) { e.exports = t("./Loader"), e.exports.Resource = t("./Resource"), e.exports.middleware = { caching: { memory: t("./middlewares/caching/memory") }, parsing: { blob: t("./middlewares/parsing/blob") } } }, { "./Loader": 130, "./Resource": 131, "./middlewares/caching/memory": 134, "./middlewares/parsing/blob": 135 }],
			134: [function(t, e, r) { var n = {};
				e.exports = function() { return function(t, e) { n[t.url] ? (t.data = n[t.url], t.complete()) : t.once("complete", function() { n[this.url] = this.data }), e() } } }, {}],
			135: [function(t, e, r) { var n = t("../../Resource"),
					i = t("../../b64");
				window.URL = window.URL || window.webkitURL, e.exports = function() { return function(t, e) { if(!t.data) return e(); if(t.xhr && t.xhrType === n.XHR_RESPONSE_TYPE.BLOB)
							if(window.Blob && "string" != typeof t.data) { if(0 === t.data.type.indexOf("image")) { var r = URL.createObjectURL(t.data);
									t.blob = t.data, t.data = new Image, t.data.src = r, t.isImage = !0, t.data.onload = function() { URL.revokeObjectURL(r), t.data.onload = null, e() } } } else { var o = t.xhr.getResponseHeader("content-type");
								o && 0 === o.indexOf("image") && (t.data = new Image, t.data.src = "data:" + o + ";base64," + i.encodeBinary(t.xhr.responseText), t.isImage = !0, t.data.onload = function() { t.data.onload = null, e() }) } else e() } } }, { "../../Resource": 131, "../../b64": 132 }]
		}, {}, [108])(108)
	}), PointerEventsPolyfill.initialize = function(t) { return null == PointerEventsPolyfill.singleton && (PointerEventsPolyfill.singleton = new PointerEventsPolyfill(t)), PointerEventsPolyfill.singleton }, PointerEventsPolyfill.prototype.register_mouse_events = function() { $(document).on(this.options.mouseEvents.join(" "), this.options.selector, function(t) { if("none" == $(this).css("pointer-events")) { var e = $(this).css("display");
				$(this).css("display", "none"); var r = document.elementFromPoint(t.clientX, t.clientY); return e ? $(this).css("display", e) : $(this).css("display", ""), t.target = r, $(r).trigger(t), !1 } return !0 }) };
var Stats = function() {
	function t(t, e, r) { return t = document.createElement(t), t.id = e, t.style.cssText = r, t }

	function e(e, r, n) { var i = t("div", e, "padding:0 0 3px 3px;text-align:left;background:" + n),
			o = t("div", e + "Text", "font-family:Helvetica,Arial,sans-serif;font-size:9px;font-weight:bold;line-height:15px;color:" + r); for(o.innerHTML = e.toUpperCase(), i.appendChild(o), e = t("div", e + "Graph", "width:74px;height:30px;background:" + r), i.appendChild(e), r = 0; 74 > r; r++) e.appendChild(t("span", "", "width:1px;height:30px;float:left;opacity:0.9;background:" + n)); return i }

	function r(t) { for(var e = u.children, r = 0; r < e.length; r++) e[r].style.display = r === t ? "block" : "none";
		l = t }

	function n(t, e) { t.appendChild(t.firstChild).style.height = Math.min(30, 30 - 30 * e) + "px" } var i = self.performance && self.performance.now ? self.performance.now.bind(performance) : Date.now,
		o = i(),
		s = o,
		a = 0,
		l = 0,
		u = t("div", "stats", "width:80px;opacity:0.9;cursor:pointer");
	u.addEventListener("mousedown", function(t) { t.preventDefault(), r(++l % u.children.length) }, !1); var h = 0,
		c = 1 / 0,
		p = 0,
		d = e("fps", "#0ff", "#002"),
		f = d.children[0],
		v = d.children[1];
	u.appendChild(d); var g = 0,
		m = 1 / 0,
		y = 0,
		d = e("ms", "#0f0", "#020"),
		T = d.children[0],
		x = d.children[1]; if(u.appendChild(d), self.performance && self.performance.memory) { var b = 0,
			S = 1 / 0,
			E = 0,
			d = e("mb", "#f08", "#201"),
			A = d.children[0],
			_ = d.children[1];
		u.appendChild(d) } return r(l), { REVISION: 14, domElement: u, setMode: r, begin: function() { o = i() }, end: function() { var t = i(); if(g = t - o, m = Math.min(m, g), y = Math.max(y, g), T.textContent = (0 | g) + " MS (" + (0 | m) + "-" + (0 | y) + ")", n(x, g / 200), a++, t > s + 1e3 && (h = Math.round(1e3 * a / (t - s)), c = Math.min(c, h), p = Math.max(p, h), f.textContent = h + " FPS (" + c + "-" + p + ")", n(v, h / 100), s = t, a = 0, void 0 !== b)) { var e = performance.memory.usedJSHeapSize,
					r = performance.memory.jsHeapSizeLimit;
				b = Math.round(9.54e-7 * e), S = Math.min(S, b), E = Math.max(E, b), A.textContent = b + " MB (" + S + "-" + E + ")", n(_, e / r) } return t }, update: function() { o = this.end() } } };
"object" == typeof module && (module.exports = Stats),
	function() { window.visibly = { q: document, p: void 0, prefixes: ["webkit", "ms", "o", "moz", "khtml"], props: ["VisibilityState", "visibilitychange", "Hidden"], m: ["focus", "blur"], visibleCallbacks: [], hiddenCallbacks: [], genericCallbacks: [], _callbacks: [], cachedPrefix: "", fn: null, onVisible: function(t) { "function" == typeof t && this.visibleCallbacks.push(t) }, onHidden: function(t) { "function" == typeof t && this.hiddenCallbacks.push(t) }, getPrefix: function() { if(!this.cachedPrefix)
					for(var t, e = 0; t = this.prefixes[e++];)
						if(t + this.props[2] in this.q) return this.cachedPrefix = t, this.cachedPrefix }, visibilityState: function() { return this._getProp(0) }, hidden: function() { return this._getProp(2) }, visibilitychange: function(t) { "function" == typeof t && this.genericCallbacks.push(t); var e = this.genericCallbacks.length; if(e)
					if(this.cachedPrefix)
						for(; e--;) this.genericCallbacks[e].call(this, this.visibilityState());
					else
						for(; e--;) this.genericCallbacks[e].call(this, arguments[0]) }, isSupported: function(t) { return this._getPropName(2) in this.q }, _getPropName: function(t) { return "" == this.cachedPrefix ? this.props[t].substring(0, 1).toLowerCase() + this.props[t].substring(1) : this.cachedPrefix + this.props[t] }, _getProp: function(t) { return this.q[this._getPropName(t)] }, _execute: function(t) { if(t) { this._callbacks = 1 == t ? this.visibleCallbacks : this.hiddenCallbacks; for(var e = this._callbacks.length; e--;) this._callbacks[e]() } }, _visible: function() { window.visibly._execute(1), window.visibly.visibilitychange.call(window.visibly, "visible") }, _hidden: function() { window.visibly._execute(2), window.visibly.visibilitychange.call(window.visibly, "hidden") }, _nativeSwitch: function() { this[this._getProp(2) ? "_hidden" : "_visible"]() }, _listen: function() { try { this.isSupported() ? this.q.addEventListener(this._getPropName(1), function() { window.visibly._nativeSwitch.apply(window.visibly, arguments) }, 1) : this.q.addEventListener ? (window.addEventListener(this.m[0], this._visible, 1), window.addEventListener(this.m[1], this._hidden, 1)) : this.q.attachEvent && (this.q.attachEvent("onfocusin", this._visible), this.q.attachEvent("onfocusout", this._hidden)) } catch(t) {} }, init: function() { this.getPrefix(), this._listen() } }, this.visibly.init() }();