function MarkerClusterer(e, t, n) {
    this.extend(MarkerClusterer, google.maps.OverlayView), this.map_ = e, this.markers_ = [], this.clusters_ = [], this.sizes = [53, 56, 66, 78, 90], this.styles_ = [], this.ready_ = !1;
    var i = n || {};
    this.gridSize_ = i.gridSize || 60, this.minClusterSize_ = i.minimumClusterSize || 2, this.maxZoom_ = i.maxZoom || null, this.styles_ = i.styles || [], this.imagePath_ = i.imagePath || this.MARKER_CLUSTER_IMAGE_PATH_, this.imageExtension_ = i.imageExtension || this.MARKER_CLUSTER_IMAGE_EXTENSION_, this.zoomOnClick_ = !0, i.zoomOnClick != undefined && (this.zoomOnClick_ = i.zoomOnClick), this.averageCenter_ = !1, i.averageCenter != undefined && (this.averageCenter_ = i.averageCenter), this.setupStyles_(), this.setMap(e), this.prevZoom_ = this.map_.getZoom();
    var r = this;
    google.maps.event.addListener(this.map_, "zoom_changed", function() {
        var e = r.map_.getZoom();
        r.prevZoom_ != e && (r.prevZoom_ = e, r.resetViewport())
    }), google.maps.event.addListener(this.map_, "idle", function() {
        r.redraw()
    }), t && t.length && this.addMarkers(t, !1)
}

function Cluster(e) {
    this.markerClusterer_ = e, this.map_ = e.getMap(), this.gridSize_ = e.getGridSize(), this.minClusterSize_ = e.getMinClusterSize(), this.averageCenter_ = e.isAverageCenter(), this.center_ = null, this.markers_ = [], this.bounds_ = null, this.clusterIcon_ = new ClusterIcon(this, e.getStyles(), e.getGridSize())
}

function ClusterIcon(e, t, n) {
    e.getMarkerClusterer().extend(ClusterIcon, google.maps.OverlayView), this.styles_ = t, this.padding_ = n || 0, this.cluster_ = e, this.center_ = null, this.map_ = e.getMap(), this.div_ = null, this.sums_ = null, this.visible_ = !1, this.setMap(this.map_)
}! function(e, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function(e) {
        if (!e.document) throw new Error("jQuery requires a window with a document");
        return t(e)
    } : t(e)
}("undefined" != typeof window ? window : this, function(_, e) {
    "use strict";

    function m(e, t, n) {
        var i, r, a = (n = n || Ce).createElement("script");
        if (a.text = e, t)
            for (i in xe)(r = t[i] || t.getAttribute && t.getAttribute(i)) && a.setAttribute(i, r);
        n.head.appendChild(a).parentNode.removeChild(a)
    }

    function v(e) {
        return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? he[fe.call(e)] || "object" : typeof e
    }

    function s(e) {
        var t = !!e && "length" in e && e.length,
            n = v(e);
        return !be(e) && !we(e) && ("array" === n || 0 === t || "number" == typeof t && 0 < t && t - 1 in e)
    }

    function u(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }

    function t(e, n, i) {
        return be(n) ? _e.grep(e, function(e, t) {
            return !!n.call(e, t, e) !== i
        }) : n.nodeType ? _e.grep(e, function(e) {
            return e === n !== i
        }) : "string" != typeof n ? _e.grep(e, function(e) {
            return -1 < pe.call(n, e) !== i
        }) : _e.filter(n, e, i)
    }

    function n(e, t) {
        for (;
            (e = e[t]) && 1 !== e.nodeType;);
        return e
    }

    function c(e) {
        var n = {};
        return _e.each(e.match(De) || [], function(e, t) {
            n[t] = !0
        }), n
    }

    function d(e) {
        return e
    }

    function p(e) {
        throw e
    }

    function l(e, t, n, i) {
        var r;
        try {
            e && be(r = e.promise) ? r.call(e).done(t).fail(n) : e && be(r = e.then) ? r.call(e, t, n) : t.apply(undefined, [e].slice(i))
        } catch (e) {
            n.apply(undefined, [e])
        }
    }

    function i() {
        Ce.removeEventListener("DOMContentLoaded", i), _.removeEventListener("load", i), _e.ready()
    }

    function r(e, t) {
        return t.toUpperCase()
    }

    function h(e) {
        return e.replace(ze, "ms-").replace(Ne, r)
    }

    function a() {
        this.expando = _e.expando + a.uid++
    }

    function o(e) {
        return "true" === e || "false" !== e && ("null" === e ? null : e === +e + "" ? +e : qe.test(e) ? JSON.parse(e) : e)
    }

    function f(e, t, n) {
        var i;
        if (n === undefined && 1 === e.nodeType)
            if (i = "data-" + t.replace(We, "-$&").toLowerCase(), "string" == typeof(n = e.getAttribute(i))) {
                try {
                    n = o(n)
                } catch (r) {}
                He.set(e, t, n)
            } else n = undefined;
        return n
    }

    function g(e, t, n, i) {
        var r, a, o = 20,
            s = i ? function() {
                return i.cur()
            } : function() {
                return _e.css(e, t, "")
            },
            l = s(),
            u = n && n[3] || (_e.cssNumber[t] ? "" : "px"),
            c = e.nodeType && (_e.cssNumber[t] || "px" !== u && +l) && Xe.exec(_e.css(e, t));
        if (c && c[3] !== u) {
            for (l /= 2, u = u || c[3], c = +l || 1; o--;) _e.style(e, t, c + u), (1 - a) * (1 - (a = s() / l || .5)) <= 0 && (o = 0), c /= a;
            c *= 2, _e.style(e, t, c + u), n = n || []
        }
        return n && (c = +c || +l || 0, r = n[1] ? c + (n[1] + 1) * n[2] : +n[2], i && (i.unit = u, i.start = c, i.end = r)), r
    }

    function y(e) {
        var t, n = e.ownerDocument,
            i = e.nodeName,
            r = Ke[i];
        return r || (t = n.body.appendChild(n.createElement(i)), r = _e.css(t, "display"), t.parentNode.removeChild(t), "none" === r && (r = "block"), Ke[i] = r)
    }

    function b(e, t) {
        for (var n, i, r = [], a = 0, o = e.length; a < o; a++)(i = e[a]).style && (n = i.style.display, t ? ("none" === n && (r[a] = Re.get(i, "display") || null, r[a] || (i.style.display = "")), "" === i.style.display && Ze(i) && (r[a] = y(i))) : "none" !== n && (r[a] = "none", Re.set(i, "display", n)));
        for (a = 0; a < o; a++) null != r[a] && (e[a].style.display = r[a]);
        return e
    }

    function w(e, t) {
        var n;
        return n = "undefined" != typeof e.getElementsByTagName ? e.getElementsByTagName(t || "*") : "undefined" != typeof e.querySelectorAll ? e.querySelectorAll(t || "*") : [], t === undefined || t && u(e, t) ? _e.merge([e], n) : n
    }

    function C(e, t) {
        for (var n = 0, i = e.length; n < i; n++) Re.set(e[n], "globalEval", !t || Re.get(t[n], "globalEval"))
    }

    function x(e, t, n, i, r) {
        for (var a, o, s, l, u, c, d = t.createDocumentFragment(), p = [], h = 0, f = e.length; h < f; h++)
            if ((a = e[h]) || 0 === a)
                if ("object" === v(a)) _e.merge(p, a.nodeType ? [a] : a);
                else if (at.test(a)) {
            for (o = o || d.appendChild(t.createElement("div")), s = (nt.exec(a) || ["", ""])[1].toLowerCase(), l = rt[s] || rt._default, o.innerHTML = l[1] + _e.htmlPrefilter(a) + l[2], c = l[0]; c--;) o = o.lastChild;
            _e.merge(p, o.childNodes), (o = d.firstChild).textContent = ""
        } else p.push(t.createTextNode(a));
        for (d.textContent = "", h = 0; a = p[h++];)
            if (i && -1 < _e.inArray(a, i)) r && r.push(a);
            else if (u = Ye(a), o = w(d.appendChild(a), "script"), u && C(o), n)
            for (c = 0; a = o[c++];) it.test(a.type || "") && n.push(a);
        return d
    }

    function k() {
        return !0
    }

    function E() {
        return !1
    }

    function S(e, t) {
        return e === T() == ("focus" === t)
    }

    function T() {
        try {
            return Ce.activeElement
        } catch (e) {}
    }

    function M(e, t, n, i, r, a) {
        var o, s;
        if ("object" == typeof t) {
            for (s in "string" != typeof n && (i = i || n, n = undefined), t) M(e, s, n, i, t[s], a);
            return e
        }
        if (null == i && null == r ? (r = n, i = n = undefined) : null == r && ("string" == typeof n ? (r = i, i = undefined) : (r = i, i = n, n = undefined)), !1 === r) r = E;
        else if (!r) return e;
        return 1 === a && (o = r, (r = function(e) {
            return _e().off(e), o.apply(this, arguments)
        }).guid = o.guid || (o.guid = _e.guid++)), e.each(function() {
            _e.event.add(this, t, r, i, n)
        })
    }

    function $(e, r, a) {
        a ? (Re.set(e, r, !1), _e.event.add(e, r, {
            namespace: !1,
            handler: function(e) {
                var t, n, i = Re.get(this, r);
                if (1 & e.isTrigger && this[r]) {
                    if (i.length)(_e.event.special[r] || {}).delegateType && e.stopPropagation();
                    else if (i = ue.call(arguments), Re.set(this, r, i), t = a(this, r), this[r](), i !== (n = Re.get(this, r)) || t ? Re.set(this, r, !1) : n = {}, i !== n) return e.stopImmediatePropagation(), e.preventDefault(), n.value
                } else i.length && (Re.set(this, r, {
                    value: _e.event.trigger(_e.extend(i[0], _e.Event.prototype), i.slice(1), this)
                }), e.stopImmediatePropagation())
            }
        })) : Re.get(e, r) === undefined && _e.event.add(e, r, k)
    }

    function A(e, t) {
        return u(e, "table") && u(11 !== t.nodeType ? t : t.firstChild, "tr") && _e(e).children("tbody")[0] || e
    }

    function I(e) {
        return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function P(e) {
        return "true/" === (e.type || "").slice(0, 5) ? e.type = e.type.slice(5) : e.removeAttribute("type"), e
    }

    function j(e, t) {
        var n, i, r, a, o, s;
        if (1 === t.nodeType) {
            if (Re.hasData(e) && (s = Re.get(e).events))
                for (r in Re.remove(t, "handle events"), s)
                    for (n = 0, i = s[r].length; n < i; n++) _e.event.add(t, r, s[r][n]);
            He.hasData(e) && (a = He.access(e), o = _e.extend({}, a), He.set(t, o))
        }
    }

    function D(e, t) {
        var n = t.nodeName.toLowerCase();
        "input" === n && tt.test(e.type) ? t.checked = e.checked : "input" !== n && "textarea" !== n || (t.defaultValue = e.defaultValue)
    }

    function L(n, i, r, a) {
        i = ce(i);
        var e, t, o, s, l, u, c = 0,
            d = n.length,
            p = d - 1,
            h = i[0],
            f = be(h);
        if (f || 1 < d && "string" == typeof h && !ye.checkClone && ct.test(h)) return n.each(function(e) {
            var t = n.eq(e);
            f && (i[0] = h.call(this, e, t.html())), L(t, i, r, a)
        });
        if (d && (t = (e = x(i, n[0].ownerDocument, !1, n, a)).firstChild, 1 === e.childNodes.length && (e = t), t || a)) {
            for (s = (o = _e.map(w(e, "script"), I)).length; c < d; c++) l = e, c !== p && (l = _e.clone(l, !0, !0), s && _e.merge(o, w(l, "script"))), r.call(n[c], l, c);
            if (s)
                for (u = o[o.length - 1].ownerDocument, _e.map(o, P), c = 0; c < s; c++) l = o[c], it.test(l.type || "") && !Re.access(l, "globalEval") && _e.contains(u, l) && (l.src && "module" !== (l.type || "").toLowerCase() ? _e._evalUrl && !l.noModule && _e._evalUrl(l.src, {
                    nonce: l.nonce || l.getAttribute("nonce")
                }, u) : m(l.textContent.replace(dt, ""), l, u))
        }
        return n
    }

    function F(e, t, n) {
        for (var i, r = t ? _e.filter(t, e) : e, a = 0; null != (i = r[a]); a++) n || 1 !== i.nodeType || _e.cleanData(w(i)), i.parentNode && (n && Ye(i) && C(w(i, "script")), i.parentNode.removeChild(i));
        return e
    }

    function O(e, t, n) {
        var i, r, a, o, s = e.style;
        return (n = n || ht(e)) && ("" !== (o = n.getPropertyValue(t) || n[t]) || Ye(e) || (o = _e.style(e, t)), !ye.pixelBoxStyles() && pt.test(o) && mt.test(t) && (i = s.width, r = s.minWidth, a = s.maxWidth, s.minWidth = s.maxWidth = s.width = o, o = n.width, s.width = i, s.minWidth = r, s.maxWidth = a)), o !== undefined ? o + "" : o
    }

    function z(e, t) {
        return {
            get: function() {
                if (!e()) return (this.get = t).apply(this, arguments);
                delete this.get
            }
        }
    }

    function N(e) {
        for (var t = e[0].toUpperCase() + e.slice(1), n = vt.length; n--;)
            if ((e = vt[n] + t) in gt) return e
    }

    function B(e) {
        var t = _e.cssProps[e] || yt[e];
        return t || (e in gt ? e : yt[e] = N(e) || e)
    }

    function R(e, t, n) {
        var i = Xe.exec(t);
        return i ? Math.max(0, i[2] - (n || 0)) + (i[3] || "px") : t
    }

    function H(e, t, n, i, r, a) {
        var o = "width" === t ? 1 : 0,
            s = 0,
            l = 0;
        if (n === (i ? "border" : "content")) return 0;
        for (; o < 4; o += 2) "margin" === n && (l += _e.css(e, n + Ge[o], !0, r)), i ? ("content" === n && (l -= _e.css(e, "padding" + Ge[o], !0, r)), "margin" !== n && (l -= _e.css(e, "border" + Ge[o] + "Width", !0, r))) : (l += _e.css(e, "padding" + Ge[o], !0, r), "padding" !== n ? l += _e.css(e, "border" + Ge[o] + "Width", !0, r) : s += _e.css(e, "border" + Ge[o] + "Width", !0, r));
        return !i && 0 <= a && (l += Math.max(0, Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - a - l - s - .5)) || 0), l
    }

    function q(e, t, n) {
        var i = ht(e),
            r = (!ye.boxSizingReliable() || n) && "border-box" === _e.css(e, "boxSizing", !1, i),
            a = r,
            o = O(e, t, i),
            s = "offset" + t[0].toUpperCase() + t.slice(1);
        if (pt.test(o)) {
            if (!n) return o;
            o = "auto"
        }
        return (!ye.boxSizingReliable() && r || !ye.reliableTrDimensions() && u(e, "tr") || "auto" === o || !parseFloat(o) && "inline" === _e.css(e, "display", !1, i)) && e.getClientRects().length && (r = "border-box" === _e.css(e, "boxSizing", !1, i), (a = s in e) && (o = e[s])), (o = parseFloat(o) || 0) + H(e, t, n || (r ? "border" : "content"), a, i, o) + "px"
    }

    function W(e, t, n, i, r) {
        return new W.prototype.init(e, t, n, i, r)
    }

    function V() {
        _t && (!1 === Ce.hidden && _.requestAnimationFrame ? _.requestAnimationFrame(V) : _.setTimeout(V, _e.fx.interval), _e.fx.tick())
    }

    function X() {
        return _.setTimeout(function() {
            kt = undefined
        }), kt = Date.now()
    }

    function G(e, t) {
        var n, i = 0,
            r = {
                height: e
            };
        for (t = t ? 1 : 0; i < 4; i += 2 - t) r["margin" + (n = Ge[i])] = r["padding" + n] = e;
        return t && (r.opacity = r.width = e), r
    }

    function U(e, t, n) {
        for (var i, r = (Z.tweeners[t] || []).concat(Z.tweeners["*"]), a = 0, o = r.length; a < o; a++)
            if (i = r[a].call(n, t, e)) return i
    }

    function Y(e, t, n) {
        var i, r, a, o, s, l, u, c, d = "width" in t || "height" in t,
            p = this,
            h = {},
            f = e.style,
            m = e.nodeType && Ze(e),
            v = Re.get(e, "fxshow");
        for (i in n.queue || (null == (o = _e._queueHooks(e, "fx")).unqueued && (o.unqueued = 0, s = o.empty.fire, o.empty.fire = function() {
                o.unqueued || s()
            }), o.unqueued++, p.always(function() {
                p.always(function() {
                    o.unqueued--, _e.queue(e, "fx").length || o.empty.fire()
                })
            })), t)
            if (r = t[i], Tt.test(r)) {
                if (delete t[i], a = a || "toggle" === r, r === (m ? "hide" : "show")) {
                    if ("show" !== r || !v || v[i] === undefined) continue;
                    m = !0
                }
                h[i] = v && v[i] || _e.style(e, i)
            } if ((l = !_e.isEmptyObject(t)) || !_e.isEmptyObject(h))
            for (i in d && 1 === e.nodeType && (n.overflow = [f.overflow, f.overflowX, f.overflowY], null == (u = v && v.display) && (u = Re.get(e, "display")), "none" === (c = _e.css(e, "display")) && (u ? c = u : (b([e], !0), u = e.style.display || u, c = _e.css(e, "display"), b([e]))), ("inline" === c || "inline-block" === c && null != u) && "none" === _e.css(e, "float") && (l || (p.done(function() {
                    f.display = u
                }), null == u && (c = f.display, u = "none" === c ? "" : c)), f.display = "inline-block")), n.overflow && (f.overflow = "hidden", p.always(function() {
                    f.overflow = n.overflow[0], f.overflowX = n.overflow[1], f.overflowY = n.overflow[2]
                })), l = !1, h) l || (v ? "hidden" in v && (m = v.hidden) : v = Re.access(e, "fxshow", {
                display: u
            }), a && (v.hidden = !m), m && b([e], !0), p.done(function() {
                for (i in m || b([e]), Re.remove(e, "fxshow"), h) _e.style(e, i, h[i])
            })), l = U(m ? v[i] : 0, i, p), i in v || (v[i] = l.start, m && (l.end = l.start, l.start = 0))
    }

    function Q(e, t) {
        var n, i, r, a, o;
        for (n in e)
            if (r = t[i = h(n)], a = e[n], Array.isArray(a) && (r = a[1], a = e[n] = a[0]), n !== i && (e[i] = a, delete e[n]), (o = _e.cssHooks[i]) && "expand" in o)
                for (n in a = o.expand(a), delete e[i], a) n in e || (e[n] = a[n], t[n] = r);
            else t[i] = r
    }

    function Z(a, e, t) {
        var n, o, i = 0,
            r = Z.prefilters.length,
            s = _e.Deferred().always(function() {
                delete l.elem
            }),
            l = function() {
                if (o) return !1;
                for (var e = kt || X(), t = Math.max(0, u.startTime + u.duration - e), n = 1 - (t / u.duration || 0), i = 0, r = u.tweens.length; i < r; i++) u.tweens[i].run(n);
                return s.notifyWith(a, [u, n, t]), n < 1 && r ? t : (r || s.notifyWith(a, [u, 1, 0]), s.resolveWith(a, [u]), !1)
            },
            u = s.promise({
                elem: a,
                props: _e.extend({}, e),
                opts: _e.extend(!0, {
                    specialEasing: {},
                    easing: _e.easing._default
                }, t),
                originalProperties: e,
                originalOptions: t,
                startTime: kt || X(),
                duration: t.duration,
                tweens: [],
                createTween: function(e, t) {
                    var n = _e.Tween(a, u.opts, e, t, u.opts.specialEasing[e] || u.opts.easing);
                    return u.tweens.push(n), n
                },
                stop: function(e) {
                    var t = 0,
                        n = e ? u.tweens.length : 0;
                    if (o) return this;
                    for (o = !0; t < n; t++) u.tweens[t].run(1);
                    return e ? (s.notifyWith(a, [u, 1, 0]), s.resolveWith(a, [u, e])) : s.rejectWith(a, [u, e]), this
                }
            }),
            c = u.props;
        for (Q(c, u.opts.specialEasing); i < r; i++)
            if (n = Z.prefilters[i].call(u, a, c, u.opts)) return be(n.stop) && (_e._queueHooks(u.elem, u.opts.queue).stop = n.stop.bind(n)), n;
        return _e.map(c, U, u), be(u.opts.start) && u.opts.start.call(a, u), u.progress(u.opts.progress).done(u.opts.done, u.opts.complete).fail(u.opts.fail).always(u.opts.always), _e.fx.timer(_e.extend(l, {
            elem: a,
            anim: u,
            queue: u.opts.queue
        })), u
    }

    function K(e) {
        return (e.match(De) || []).join(" ")
    }

    function J(e) {
        return e.getAttribute && e.getAttribute("class") || ""
    }

    function ee(e) {
        return Array.isArray(e) ? e : "string" == typeof e && e.match(De) || []
    }

    function te(n, e, i, r) {
        var t;
        if (Array.isArray(e)) _e.each(e, function(e, t) {
            i || Nt.test(n) ? r(n, t) : te(n + "[" + ("object" == typeof t && null != t ? e : "") + "]", t, i, r)
        });
        else if (i || "object" !== v(e)) r(n, e);
        else
            for (t in e) te(n + "[" + t + "]", e[t], i, r)
    }

    function ne(a) {
        return function(e, t) {
            "string" != typeof e && (t = e, e = "*");
            var n, i = 0,
                r = e.toLowerCase().match(De) || [];
            if (be(t))
                for (; n = r[i++];) "+" === n[0] ? (n = n.slice(1) || "*", (a[n] = a[n] || []).unshift(t)) : (a[n] = a[n] || []).push(t)
        }
    }

    function ie(t, r, a, o) {
        function s(e) {
            var i;
            return l[e] = !0, _e.each(t[e] || [], function(e, t) {
                var n = t(r, a, o);
                return "string" != typeof n || u || l[n] ? u ? !(i = n) : void 0 : (r.dataTypes.unshift(n), s(n), !1)
            }), i
        }
        var l = {},
            u = t === Zt;
        return s(r.dataTypes[0]) || !l["*"] && s("*")
    }

    function re(e, t) {
        var n, i, r = _e.ajaxSettings.flatOptions || {};
        for (n in t) t[n] !== undefined && ((r[n] ? e : i || (i = {}))[n] = t[n]);
        return i && _e.extend(!0, e, i), e
    }

    function ae(e, t, n) {
        for (var i, r, a, o, s = e.contents, l = e.dataTypes;
            "*" === l[0];) l.shift(), i === undefined && (i = e.mimeType || t.getResponseHeader("Content-Type"));
        if (i)
            for (r in s)
                if (s[r] && s[r].test(i)) {
                    l.unshift(r);
                    break
                } if (l[0] in n) a = l[0];
        else {
            for (r in n) {
                if (!l[0] || e.converters[r + " " + l[0]]) {
                    a = r;
                    break
                }
                o || (o = r)
            }
            a = a || o
        }
        if (a) return a !== l[0] && l.unshift(a), n[a]
    }

    function oe(e, t, n, i) {
        var r, a, o, s, l, u = {},
            c = e.dataTypes.slice();
        if (c[1])
            for (o in e.converters) u[o.toLowerCase()] = e.converters[o];
        for (a = c.shift(); a;)
            if (e.responseFields[a] && (n[e.responseFields[a]] = t), !l && i && e.dataFilter && (t = e.dataFilter(t, e.dataType)), l = a, a = c.shift())
                if ("*" === a) a = l;
                else if ("*" !== l && l !== a) {
            if (!(o = u[l + " " + a] || u["* " + a]))
                for (r in u)
                    if ((s = r.split(" "))[1] === a && (o = u[l + " " + s[0]] || u["* " + s[0]])) {
                        !0 === o ? o = u[r] : !0 !== u[r] && (a = s[0], c.unshift(s[1]));
                        break
                    } if (!0 !== o)
                if (o && e["throws"]) t = o(t);
                else try {
                    t = o(t)
                } catch (d) {
                    return {
                        state: "parsererror",
                        error: o ? d : "No conversion from " + l + " to " + a
                    }
                }
        }
        return {
            state: "success",
            data: t
        }
    }
    var se = [],
        le = Object.getPrototypeOf,
        ue = se.slice,
        ce = se.flat ? function(e) {
            return se.flat.call(e)
        } : function(e) {
            return se.concat.apply([], e)
        },
        de = se.push,
        pe = se.indexOf,
        he = {},
        fe = he.toString,
        me = he.hasOwnProperty,
        ve = me.toString,
        ge = ve.call(Object),
        ye = {},
        be = function be(e) {
            return "function" == typeof e && "number" != typeof e.nodeType
        },
        we = function we(e) {
            return null != e && e === e.window
        },
        Ce = _.document,
        xe = {
            type: !0,
            src: !0,
            nonce: !0,
            noModule: !0
        },
        ke = "3.5.1",
        _e = function(e, t) {
            return new _e.fn.init(e, t)
        };
    _e.fn = _e.prototype = {
        jquery: ke,
        constructor: _e,
        length: 0,
        toArray: function() {
            return ue.call(this)
        },
        get: function(e) {
            return null == e ? ue.call(this) : e < 0 ? this[e + this.length] : this[e]
        },
        pushStack: function(e) {
            var t = _e.merge(this.constructor(), e);
            return t.prevObject = this, t
        },
        each: function(e) {
            return _e.each(this, e)
        },
        map: function(n) {
            return this.pushStack(_e.map(this, function(e, t) {
                return n.call(e, t, e)
            }))
        },
        slice: function() {
            return this.pushStack(ue.apply(this, arguments))
        },
        first: function() {
            return this.eq(0)
        },
        last: function() {
            return this.eq(-1)
        },
        even: function() {
            return this.pushStack(_e.grep(this, function(e, t) {
                return (t + 1) % 2
            }))
        },
        odd: function() {
            return this.pushStack(_e.grep(this, function(e, t) {
                return t % 2
            }))
        },
        eq: function(e) {
            var t = this.length,
                n = +e + (e < 0 ? t : 0);
            return this.pushStack(0 <= n && n < t ? [this[n]] : [])
        },
        end: function() {
            return this.prevObject || this.constructor()
        },
        push: de,
        sort: se.sort,
        splice: se.splice
    }, _e.extend = _e.fn.extend = function(e) {
        var t, n, i, r, a, o, s = e || {},
            l = 1,
            u = arguments.length,
            c = !1;
        for ("boolean" == typeof s && (c = s, s = arguments[l] || {}, l++), "object" == typeof s || be(s) || (s = {}), l === u && (s = this, l--); l < u; l++)
            if (null != (t = arguments[l]))
                for (n in t) r = t[n], "__proto__" !== n && s !== r && (c && r && (_e.isPlainObject(r) || (a = Array.isArray(r))) ? (i = s[n], o = a && !Array.isArray(i) ? [] : a || _e.isPlainObject(i) ? i : {}, a = !1, s[n] = _e.extend(c, o, r)) : r !== undefined && (s[n] = r));
        return s
    }, _e.extend({
        expando: "jQuery" + (ke + Math.random()).replace(/\D/g, ""),
        isReady: !0,
        error: function(e) {
            throw new Error(e)
        },
        noop: function() {},
        isPlainObject: function(e) {
            var t, n;
            return !(!e || "[object Object]" !== fe.call(e)) && (!(t = le(e)) || "function" == typeof(n = me.call(t, "constructor") && t.constructor) && ve.call(n) === ge)
        },
        isEmptyObject: function(e) {
            var t;
            for (t in e) return !1;
            return !0
        },
        globalEval: function(e, t, n) {
            m(e, {
                nonce: t && t.nonce
            }, n)
        },
        each: function(e, t) {
            var n, i = 0;
            if (s(e))
                for (n = e.length; i < n && !1 !== t.call(e[i], i, e[i]); i++);
            else
                for (i in e)
                    if (!1 === t.call(e[i], i, e[i])) break;
            return e
        },
        makeArray: function(e, t) {
            var n = t || [];
            return null != e && (s(Object(e)) ? _e.merge(n, "string" == typeof e ? [e] : e) : de.call(n, e)), n
        },
        inArray: function(e, t, n) {
            return null == t ? -1 : pe.call(t, e, n)
        },
        merge: function(e, t) {
            for (var n = +t.length, i = 0, r = e.length; i < n; i++) e[r++] = t[i];
            return e.length = r, e
        },
        grep: function(e, t, n) {
            for (var i = [], r = 0, a = e.length, o = !n; r < a; r++) !t(e[r], r) !== o && i.push(e[r]);
            return i
        },
        map: function(e, t, n) {
            var i, r, a = 0,
                o = [];
            if (s(e))
                for (i = e.length; a < i; a++) null != (r = t(e[a], a, n)) && o.push(r);
            else
                for (a in e) null != (r = t(e[a], a, n)) && o.push(r);
            return ce(o)
        },
        guid: 1,
        support: ye
    }), "function" == typeof Symbol && (_e.fn[Symbol.iterator] = se[Symbol.iterator]), _e.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function(e, t) {
        he["[object " + t + "]"] = t.toLowerCase()
    });
    var Ee = function(n) {
        function w(e, t, n, i) {
            var r, a, o, s, l, u, c, d = t && t.ownerDocument,
                p = t ? t.nodeType : 9;
            if (n = n || [], "string" != typeof e || !e || 1 !== p && 9 !== p && 11 !== p) return n;
            if (!i && (P(t), t = t || j, L)) {
                if (11 !== p && (l = be.exec(e)))
                    if (r = l[1]) {
                        if (9 === p) {
                            if (!(o = t.getElementById(r))) return n;
                            if (o.id === r) return n.push(o), n
                        } else if (d && (o = d.getElementById(r)) && N(t, o) && o.id === r) return n.push(o), n
                    } else {
                        if (l[2]) return J.apply(n, t.getElementsByTagName(e)), n;
                        if ((r = l[3]) && x.getElementsByClassName && t.getElementsByClassName) return J.apply(n, t.getElementsByClassName(r)), n
                    } if (x.qsa && !G[e + " "] && (!F || !F.test(e)) && (1 !== p || "object" !== t.nodeName.toLowerCase())) {
                    if (c = e, d = t, 1 === p && (de.test(e) || ce.test(e))) {
                        for ((d = we.test(e) && f(t.parentNode) || t) === t && x.scope || ((s = t.getAttribute("id")) ? s = s.replace(ke, _e) : t.setAttribute("id", s = B)), a = (u = S(e)).length; a--;) u[a] = (s ? "#" + s : ":scope") + " " + m(u[a]);
                        c = u.join(",")
                    }
                    try {
                        return J.apply(n, d.querySelectorAll(c)), n
                    } catch (h) {
                        G(e, !0)
                    } finally {
                        s === B && t.removeAttribute("id")
                    }
                }
            }
            return M(e.replace(le, "$1"), t, n, i)
        }

        function e() {
            function n(e, t) {
                return i.push(e + " ") > k.cacheLength && delete n[i.shift()], n[e + " "] = t
            }
            var i = [];
            return n
        }

        function l(e) {
            return e[B] = !0, e
        }

        function r(e) {
            var t = j.createElement("fieldset");
            try {
                return !!e(t)
            } catch (n) {
                return !1
            } finally {
                t.parentNode && t.parentNode.removeChild(t), t = null
            }
        }

        function t(e, t) {
            for (var n = e.split("|"), i = n.length; i--;) k.attrHandle[n[i]] = t
        }

        function u(e, t) {
            var n = t && e,
                i = n && 1 === e.nodeType && 1 === t.nodeType && e.sourceIndex - t.sourceIndex;
            if (i) return i;
            if (n)
                for (; n = n.nextSibling;)
                    if (n === t) return -1;
            return e ? 1 : -1
        }

        function i(t) {
            return function(e) {
                return "input" === e.nodeName.toLowerCase() && e.type === t
            }
        }

        function a(n) {
            return function(e) {
                var t = e.nodeName.toLowerCase();
                return ("input" === t || "button" === t) && e.type === n
            }
        }

        function o(t) {
            return function(e) {
                return "form" in e ? e.parentNode && !1 === e.disabled ? "label" in e ? "label" in e.parentNode ? e.parentNode.disabled === t : e.disabled === t : e.isDisabled === t || e.isDisabled !== !t && Se(e) === t : e.disabled === t : "label" in e && e.disabled === t
            }
        }

        function s(o) {
            return l(function(a) {
                return a = +a, l(function(e, t) {
                    for (var n, i = o([], e.length, a), r = i.length; r--;) e[n = i[r]] && (e[n] = !(t[n] = e[n]))
                })
            })
        }

        function f(e) {
            return e && "undefined" != typeof e.getElementsByTagName && e
        }

        function c() {}

        function m(e) {
            for (var t = 0, n = e.length, i = ""; t < n; t++) i += e[t].value;
            return i
        }

        function d(s, e, t) {
            var l = e.dir,
                u = e.next,
                c = u || l,
                d = t && "parentNode" === c,
                p = q++;
            return e.first ? function(e, t, n) {
                for (; e = e[l];)
                    if (1 === e.nodeType || d) return s(e, t, n);
                return !1
            } : function(e, t, n) {
                var i, r, a, o = [H, p];
                if (n) {
                    for (; e = e[l];)
                        if ((1 === e.nodeType || d) && s(e, t, n)) return !0
                } else
                    for (; e = e[l];)
                        if (1 === e.nodeType || d)
                            if (r = (a = e[B] || (e[B] = {}))[e.uniqueID] || (a[e.uniqueID] = {}), u && u === e.nodeName.toLowerCase()) e = e[l] || e;
                            else {
                                if ((i = r[c]) && i[0] === H && i[1] === p) return o[2] = i[2];
                                if ((r[c] = o)[2] = s(e, t, n)) return !0
                            } return !1
            }
        }

        function p(r) {
            return 1 < r.length ? function(e, t, n) {
                for (var i = r.length; i--;)
                    if (!r[i](e, t, n)) return !1;
                return !0
            } : r[0]
        }

        function y(e, t, n) {
            for (var i = 0, r = t.length; i < r; i++) w(e, t[i], n);
            return n
        }

        function C(e, t, n, i, r) {
            for (var a, o = [], s = 0, l = e.length, u = null != t; s < l; s++)(a = e[s]) && (n && !n(a, i, r) || (o.push(a), u && t.push(s)));
            return o
        }

        function b(h, f, m, v, g, e) {
            return v && !v[B] && (v = b(v)), g && !g[B] && (g = b(g, e)), l(function(e, t, n, i) {
                var r, a, o, s = [],
                    l = [],
                    u = t.length,
                    c = e || y(f || "*", n.nodeType ? [n] : n, []),
                    d = !h || !e && f ? c : C(c, s, h, n, i),
                    p = m ? g || (e ? h : u || v) ? [] : t : d;
                if (m && m(d, p, n, i), v)
                    for (r = C(p, l), v(r, [], n, i), a = r.length; a--;)(o = r[a]) && (p[l[a]] = !(d[l[a]] = o));
                if (e) {
                    if (g || h) {
                        if (g) {
                            for (r = [], a = p.length; a--;)(o = p[a]) && r.push(d[a] = o);
                            g(null, p = [], r, i)
                        }
                        for (a = p.length; a--;)(o = p[a]) && -1 < (r = g ? te(e, o) : s[a]) && (e[r] = !(t[r] = o))
                    }
                } else p = C(p === t ? p.splice(u, p.length) : p), g ? g(null, t, p, i) : J.apply(t, p)
            })
        }

        function h(e) {
            for (var r, t, n, i = e.length, a = k.relative[e[0].type], o = a || k.relative[" "], s = a ? 1 : 0, l = d(function(e) {
                    return e === r
                }, o, !0), u = d(function(e) {
                    return -1 < te(r, e)
                }, o, !0), c = [function(e, t, n) {
                    var i = !a && (n || t !== $) || ((r = t).nodeType ? l(e, t, n) : u(e, t, n));
                    return r = null, i
                }]; s < i; s++)
                if (t = k.relative[e[s].type]) c = [d(p(c), t)];
                else {
                    if ((t = k.filter[e[s].type].apply(null, e[s].matches))[B]) {
                        for (n = ++s; n < i && !k.relative[e[n].type]; n++);
                        return b(1 < s && p(c), 1 < s && m(e.slice(0, s - 1).concat({
                            value: " " === e[s - 2].type ? "*" : ""
                        })).replace(le, "$1"), t, s < n && h(e.slice(s, n)), n < i && h(e = e.slice(n)), n < i && m(e))
                    }
                    c.push(t)
                } return p(c)
        }

        function v(v, g) {
            var y = 0 < g.length,
                b = 0 < v.length,
                e = function(e, t, n, i, r) {
                    var a, o, s, l = 0,
                        u = "0",
                        c = e && [],
                        d = [],
                        p = $,
                        h = e || b && k.find.TAG("*", r),
                        f = H += null == p ? 1 : Math.random() || .1,
                        m = h.length;
                    for (r && ($ = t == j || t || r); u !== m && null != (a = h[u]); u++) {
                        if (b && a) {
                            for (o = 0, t || a.ownerDocument == j || (P(a), n = !L); s = v[o++];)
                                if (s(a, t || j, n)) {
                                    i.push(a);
                                    break
                                } r && (H = f)
                        }
                        y && ((a = !s && a) && l--, e && c.push(a))
                    }
                    if (l += u, y && u !== l) {
                        for (o = 0; s = g[o++];) s(c, d, t, n);
                        if (e) {
                            if (0 < l)
                                for (; u--;) c[u] || d[u] || (d[u] = Z.call(i));
                            d = C(d)
                        }
                        J.apply(i, d), r && !e && 0 < d.length && 1 < l + g.length && w.uniqueSort(i)
                    }
                    return r && (H = f, $ = p), c
                };
            return y ? l(e) : e
        }
        var g, x, k, _, E, S, T, M, $, A, I, P, j, D, L, F, O, z, N, B = "sizzle" + 1 * new Date,
            R = n.document,
            H = 0,
            q = 0,
            W = e(),
            V = e(),
            X = e(),
            G = e(),
            U = function(e, t) {
                return e === t && (I = !0), 0
            },
            Y = {}.hasOwnProperty,
            Q = [],
            Z = Q.pop,
            K = Q.push,
            J = Q.push,
            ee = Q.slice,
            te = function(e, t) {
                for (var n = 0, i = e.length; n < i; n++)
                    if (e[n] === t) return n;
                return -1
            },
            ne = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            ie = "[\\x20\\t\\r\\n\\f]",
            re = "(?:\\\\[\\da-fA-F]{1,6}" + ie + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
            ae = "\\[" + ie + "*(" + re + ")(?:" + ie + "*([*^$|!~]?=)" + ie + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + re + "))|)" + ie + "*\\]",
            oe = ":(" + re + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + ae + ")*)|.*)\\)|)",
            se = new RegExp(ie + "+", "g"),
            le = new RegExp("^" + ie + "+|((?:^|[^\\\\])(?:\\\\.)*)" + ie + "+$", "g"),
            ue = new RegExp("^" + ie + "*," + ie + "*"),
            ce = new RegExp("^" + ie + "*([>+~]|" + ie + ")" + ie + "*"),
            de = new RegExp(ie + "|>"),
            pe = new RegExp(oe),
            he = new RegExp("^" + re + "$"),
            fe = {
                ID: new RegExp("^#(" + re + ")"),
                CLASS: new RegExp("^\\.(" + re + ")"),
                TAG: new RegExp("^(" + re + "|[*])"),
                ATTR: new RegExp("^" + ae),
                PSEUDO: new RegExp("^" + oe),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + ie + "*(even|odd|(([+-]|)(\\d*)n|)" + ie + "*(?:([+-]|)" + ie + "*(\\d+)|))" + ie + "*\\)|)", "i"),
                bool: new RegExp("^(?:" + ne + ")$", "i"),
                needsContext: new RegExp("^" + ie + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + ie + "*((?:-\\d)?\\d*)" + ie + "*\\)|)(?=[^-]|$)", "i")
            },
            me = /HTML$/i,
            ve = /^(?:input|select|textarea|button)$/i,
            ge = /^h\d$/i,
            ye = /^[^{]+\{\s*\[native \w/,
            be = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            we = /[+~]/,
            Ce = new RegExp("\\\\[\\da-fA-F]{1,6}" + ie + "?|\\\\([^\\r\\n\\f])", "g"),
            xe = function(e, t) {
                var n = "0x" + e.slice(1) - 65536;
                return t || (n < 0 ? String.fromCharCode(n + 65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320))
            },
            ke = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
            _e = function(e, t) {
                return t ? "\0" === e ? "\ufffd" : e.slice(0, -1) + "\\" + e.charCodeAt(e.length - 1).toString(16) + " " : "\\" + e
            },
            Ee = function() {
                P()
            },
            Se = d(function(e) {
                return !0 === e.disabled && "fieldset" === e.nodeName.toLowerCase()
            }, {
                dir: "parentNode",
                next: "legend"
            });
        try {
            J.apply(Q = ee.call(R.childNodes), R.childNodes), Q[R.childNodes.length].nodeType
        } catch (Te) {
            J = {
                apply: Q.length ? function(e, t) {
                    K.apply(e, ee.call(t))
                } : function(e, t) {
                    for (var n = e.length, i = 0; e[n++] = t[i++];);
                    e.length = n - 1
                }
            }
        }
        for (g in x = w.support = {}, E = w.isXML = function(e) {
                var t = e.namespaceURI,
                    n = (e.ownerDocument || e).documentElement;
                return !me.test(t || n && n.nodeName || "HTML")
            }, P = w.setDocument = function(e) {
                var t, n, i = e ? e.ownerDocument || e : R;
                return i != j && 9 === i.nodeType && i.documentElement && (D = (j = i).documentElement, L = !E(j), R != j && (n = j.defaultView) && n.top !== n && (n.addEventListener ? n.addEventListener("unload", Ee, !1) : n.attachEvent && n.attachEvent("onunload", Ee)), x.scope = r(function(e) {
                    return D.appendChild(e).appendChild(j.createElement("div")), "undefined" != typeof e.querySelectorAll && !e.querySelectorAll(":scope fieldset div").length
                }), x.attributes = r(function(e) {
                    return e.className = "i", !e.getAttribute("className")
                }), x.getElementsByTagName = r(function(e) {
                    return e.appendChild(j.createComment("")), !e.getElementsByTagName("*").length
                }), x.getElementsByClassName = ye.test(j.getElementsByClassName), x.getById = r(function(e) {
                    return D.appendChild(e).id = B, !j.getElementsByName || !j.getElementsByName(B).length
                }), x.getById ? (k.filter.ID = function(e) {
                    var t = e.replace(Ce, xe);
                    return function(e) {
                        return e.getAttribute("id") === t
                    }
                }, k.find.ID = function(e, t) {
                    if ("undefined" != typeof t.getElementById && L) {
                        var n = t.getElementById(e);
                        return n ? [n] : []
                    }
                }) : (k.filter.ID = function(e) {
                    var n = e.replace(Ce, xe);
                    return function(e) {
                        var t = "undefined" != typeof e.getAttributeNode && e.getAttributeNode("id");
                        return t && t.value === n
                    }
                }, k.find.ID = function(e, t) {
                    if ("undefined" != typeof t.getElementById && L) {
                        var n, i, r, a = t.getElementById(e);
                        if (a) {
                            if ((n = a.getAttributeNode("id")) && n.value === e) return [a];
                            for (r = t.getElementsByName(e), i = 0; a = r[i++];)
                                if ((n = a.getAttributeNode("id")) && n.value === e) return [a]
                        }
                        return []
                    }
                }), k.find.TAG = x.getElementsByTagName ? function(e, t) {
                    return "undefined" != typeof t.getElementsByTagName ? t.getElementsByTagName(e) : x.qsa ? t.querySelectorAll(e) : void 0
                } : function(e, t) {
                    var n, i = [],
                        r = 0,
                        a = t.getElementsByTagName(e);
                    if ("*" !== e) return a;
                    for (; n = a[r++];) 1 === n.nodeType && i.push(n);
                    return i
                }, k.find.CLASS = x.getElementsByClassName && function(e, t) {
                    if ("undefined" != typeof t.getElementsByClassName && L) return t.getElementsByClassName(e)
                }, O = [], F = [], (x.qsa = ye.test(j.querySelectorAll)) && (r(function(e) {
                    var t;
                    D.appendChild(e).innerHTML = "<a id='" + B + "'></a><select id='" + B + "-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && F.push("[*^$]=" + ie + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || F.push("\\[" + ie + "*(?:value|" + ne + ")"), e.querySelectorAll("[id~=" + B + "-]").length || F.push("~="), (t = j.createElement("input")).setAttribute("name", ""), e.appendChild(t), e.querySelectorAll("[name='']").length || F.push("\\[" + ie + "*name" + ie + "*=" + ie + "*(?:''|\"\")"), e.querySelectorAll(":checked").length || F.push(":checked"), e.querySelectorAll("a#" + B + "+*").length || F.push(".#.+[+~]"), e.querySelectorAll("\\\f"), F.push("[\\r\\n\\f]")
                }), r(function(e) {
                    e.innerHTML = "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                    var t = j.createElement("input");
                    t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && F.push("name" + ie + "*[*^$|!~]?="), 2 !== e.querySelectorAll(":enabled").length && F.push(":enabled", ":disabled"), D.appendChild(e).disabled = !0, 2 !== e.querySelectorAll(":disabled").length && F.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), F.push(",.*:")
                })), (x.matchesSelector = ye.test(z = D.matches || D.webkitMatchesSelector || D.mozMatchesSelector || D.oMatchesSelector || D.msMatchesSelector)) && r(function(e) {
                    x.disconnectedMatch = z.call(e, "*"), z.call(e, "[s!='']:x"), O.push("!=", oe)
                }), F = F.length && new RegExp(F.join("|")), O = O.length && new RegExp(O.join("|")), t = ye.test(D.compareDocumentPosition), N = t || ye.test(D.contains) ? function(e, t) {
                    var n = 9 === e.nodeType ? e.documentElement : e,
                        i = t && t.parentNode;
                    return e === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(i)))
                } : function(e, t) {
                    if (t)
                        for (; t = t.parentNode;)
                            if (t === e) return !0;
                    return !1
                }, U = t ? function(e, t) {
                    if (e === t) return I = !0, 0;
                    var n = !e.compareDocumentPosition - !t.compareDocumentPosition;
                    return n || (1 & (n = (e.ownerDocument || e) == (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !x.sortDetached && t.compareDocumentPosition(e) === n ? e == j || e.ownerDocument == R && N(R, e) ? -1 : t == j || t.ownerDocument == R && N(R, t) ? 1 : A ? te(A, e) - te(A, t) : 0 : 4 & n ? -1 : 1)
                } : function(e, t) {
                    if (e === t) return I = !0, 0;
                    var n, i = 0,
                        r = e.parentNode,
                        a = t.parentNode,
                        o = [e],
                        s = [t];
                    if (!r || !a) return e == j ? -1 : t == j ? 1 : r ? -1 : a ? 1 : A ? te(A, e) - te(A, t) : 0;
                    if (r === a) return u(e, t);
                    for (n = e; n = n.parentNode;) o.unshift(n);
                    for (n = t; n = n.parentNode;) s.unshift(n);
                    for (; o[i] === s[i];) i++;
                    return i ? u(o[i], s[i]) : o[i] == R ? -1 : s[i] == R ? 1 : 0
                }), j
            }, w.matches = function(e, t) {
                return w(e, null, null, t)
            }, w.matchesSelector = function(e, t) {
                if (P(e), x.matchesSelector && L && !G[t + " "] && (!O || !O.test(t)) && (!F || !F.test(t))) try {
                    var n = z.call(e, t);
                    if (n || x.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n
                } catch (Te) {
                    G(t, !0)
                }
                return 0 < w(t, j, null, [e]).length
            }, w.contains = function(e, t) {
                return (e.ownerDocument || e) != j && P(e), N(e, t)
            }, w.attr = function(e, t) {
                (e.ownerDocument || e) != j && P(e);
                var n = k.attrHandle[t.toLowerCase()],
                    i = n && Y.call(k.attrHandle, t.toLowerCase()) ? n(e, t, !L) : undefined;
                return i !== undefined ? i : x.attributes || !L ? e.getAttribute(t) : (i = e.getAttributeNode(t)) && i.specified ? i.value : null
            }, w.escape = function(e) {
                return (e + "").replace(ke, _e)
            }, w.error = function(e) {
                throw new Error("Syntax error, unrecognized expression: " + e)
            }, w.uniqueSort = function(e) {
                var t, n = [],
                    i = 0,
                    r = 0;
                if (I = !x.detectDuplicates, A = !x.sortStable && e.slice(0), e.sort(U), I) {
                    for (; t = e[r++];) t === e[r] && (i = n.push(r));
                    for (; i--;) e.splice(n[i], 1)
                }
                return A = null, e
            }, _ = w.getText = function(e) {
                var t, n = "",
                    i = 0,
                    r = e.nodeType;
                if (r) {
                    if (1 === r || 9 === r || 11 === r) {
                        if ("string" == typeof e.textContent) return e.textContent;
                        for (e = e.firstChild; e; e = e.nextSibling) n += _(e)
                    } else if (3 === r || 4 === r) return e.nodeValue
                } else
                    for (; t = e[i++];) n += _(t);
                return n
            }, (k = w.selectors = {
                cacheLength: 50,
                createPseudo: l,
                match: fe,
                attrHandle: {},
                find: {},
                relative: {
                    ">": {
                        dir: "parentNode",
                        first: !0
                    },
                    " ": {
                        dir: "parentNode"
                    },
                    "+": {
                        dir: "previousSibling",
                        first: !0
                    },
                    "~": {
                        dir: "previousSibling"
                    }
                },
                preFilter: {
                    ATTR: function(e) {
                        return e[1] = e[1].replace(Ce, xe), e[3] = (e[3] || e[4] || e[5] || "").replace(Ce, xe), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                    },
                    CHILD: function(e) {
                        return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || w.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && w.error(e[0]), e
                    },
                    PSEUDO: function(e) {
                        var t, n = !e[6] && e[2];
                        return fe.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && pe.test(n) && (t = S(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                    }
                },
                filter: {
                    TAG: function(e) {
                        var t = e.replace(Ce, xe).toLowerCase();
                        return "*" === e ? function() {
                            return !0
                        } : function(e) {
                            return e.nodeName && e.nodeName.toLowerCase() === t
                        }
                    },
                    CLASS: function(e) {
                        var t = W[e + " "];
                        return t || (t = new RegExp("(^|" + ie + ")" + e + "(" + ie + "|$)")) && W(e, function(e) {
                            return t.test("string" == typeof e.className && e.className || "undefined" != typeof e.getAttribute && e.getAttribute("class") || "")
                        })
                    },
                    ATTR: function(n, i, r) {
                        return function(e) {
                            var t = w.attr(e, n);
                            return null == t ? "!=" === i : !i || (t += "", "=" === i ? t === r : "!=" === i ? t !== r : "^=" === i ? r && 0 === t.indexOf(r) : "*=" === i ? r && -1 < t.indexOf(r) : "$=" === i ? r && t.slice(-r.length) === r : "~=" === i ? -1 < (" " + t.replace(se, " ") + " ").indexOf(r) : "|=" === i && (t === r || t.slice(0,
                                r.length + 1) === r + "-"))
                        }
                    },
                    CHILD: function(f, e, t, m, v) {
                        var g = "nth" !== f.slice(0, 3),
                            y = "last" !== f.slice(-4),
                            b = "of-type" === e;
                        return 1 === m && 0 === v ? function(e) {
                            return !!e.parentNode
                        } : function(e, t, n) {
                            var i, r, a, o, s, l, u = g !== y ? "nextSibling" : "previousSibling",
                                c = e.parentNode,
                                d = b && e.nodeName.toLowerCase(),
                                p = !n && !b,
                                h = !1;
                            if (c) {
                                if (g) {
                                    for (; u;) {
                                        for (o = e; o = o[u];)
                                            if (b ? o.nodeName.toLowerCase() === d : 1 === o.nodeType) return !1;
                                        l = u = "only" === f && !l && "nextSibling"
                                    }
                                    return !0
                                }
                                if (l = [y ? c.firstChild : c.lastChild], y && p) {
                                    for (h = (s = (i = (r = (a = (o = c)[B] || (o[B] = {}))[o.uniqueID] || (a[o.uniqueID] = {}))[f] || [])[0] === H && i[1]) && i[2], o = s && c.childNodes[s]; o = ++s && o && o[u] || (h = s = 0) || l.pop();)
                                        if (1 === o.nodeType && ++h && o === e) {
                                            r[f] = [H, s, h];
                                            break
                                        }
                                } else if (p && (h = s = (i = (r = (a = (o = e)[B] || (o[B] = {}))[o.uniqueID] || (a[o.uniqueID] = {}))[f] || [])[0] === H && i[1]), !1 === h)
                                    for (;
                                        (o = ++s && o && o[u] || (h = s = 0) || l.pop()) && ((b ? o.nodeName.toLowerCase() !== d : 1 !== o.nodeType) || !++h || (p && ((r = (a = o[B] || (o[B] = {}))[o.uniqueID] || (a[o.uniqueID] = {}))[f] = [H, h]), o !== e)););
                                return (h -= v) === m || h % m == 0 && 0 <= h / m
                            }
                        }
                    },
                    PSEUDO: function(e, a) {
                        var t, o = k.pseudos[e] || k.setFilters[e.toLowerCase()] || w.error("unsupported pseudo: " + e);
                        return o[B] ? o(a) : 1 < o.length ? (t = [e, e, "", a], k.setFilters.hasOwnProperty(e.toLowerCase()) ? l(function(e, t) {
                            for (var n, i = o(e, a), r = i.length; r--;) e[n = te(e, i[r])] = !(t[n] = i[r])
                        }) : function(e) {
                            return o(e, 0, t)
                        }) : o
                    }
                },
                pseudos: {
                    not: l(function(e) {
                        var i = [],
                            r = [],
                            s = T(e.replace(le, "$1"));
                        return s[B] ? l(function(e, t, n, i) {
                            for (var r, a = s(e, null, i, []), o = e.length; o--;)(r = a[o]) && (e[o] = !(t[o] = r))
                        }) : function(e, t, n) {
                            return i[0] = e, s(i, null, n, r), i[0] = null, !r.pop()
                        }
                    }),
                    has: l(function(t) {
                        return function(e) {
                            return 0 < w(t, e).length
                        }
                    }),
                    contains: l(function(t) {
                        return t = t.replace(Ce, xe),
                            function(e) {
                                return -1 < (e.textContent || _(e)).indexOf(t)
                            }
                    }),
                    lang: l(function(n) {
                        return he.test(n || "") || w.error("unsupported lang: " + n), n = n.replace(Ce, xe).toLowerCase(),
                            function(e) {
                                var t;
                                do {
                                    if (t = L ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (t = t.toLowerCase()) === n || 0 === t.indexOf(n + "-")
                                } while ((e = e.parentNode) && 1 === e.nodeType);
                                return !1
                            }
                    }),
                    target: function(e) {
                        var t = n.location && n.location.hash;
                        return t && t.slice(1) === e.id
                    },
                    root: function(e) {
                        return e === D
                    },
                    focus: function(e) {
                        return e === j.activeElement && (!j.hasFocus || j.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                    },
                    enabled: o(!1),
                    disabled: o(!0),
                    checked: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && !!e.checked || "option" === t && !!e.selected
                    },
                    selected: function(e) {
                        return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                    },
                    empty: function(e) {
                        for (e = e.firstChild; e; e = e.nextSibling)
                            if (e.nodeType < 6) return !1;
                        return !0
                    },
                    parent: function(e) {
                        return !k.pseudos.empty(e)
                    },
                    header: function(e) {
                        return ge.test(e.nodeName)
                    },
                    input: function(e) {
                        return ve.test(e.nodeName)
                    },
                    button: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && "button" === e.type || "button" === t
                    },
                    text: function(e) {
                        var t;
                        return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                    },
                    first: s(function() {
                        return [0]
                    }),
                    last: s(function(e, t) {
                        return [t - 1]
                    }),
                    eq: s(function(e, t, n) {
                        return [n < 0 ? n + t : n]
                    }),
                    even: s(function(e, t) {
                        for (var n = 0; n < t; n += 2) e.push(n);
                        return e
                    }),
                    odd: s(function(e, t) {
                        for (var n = 1; n < t; n += 2) e.push(n);
                        return e
                    }),
                    lt: s(function(e, t, n) {
                        for (var i = n < 0 ? n + t : t < n ? t : n; 0 <= --i;) e.push(i);
                        return e
                    }),
                    gt: s(function(e, t, n) {
                        for (var i = n < 0 ? n + t : n; ++i < t;) e.push(i);
                        return e
                    })
                }
            }).pseudos.nth = k.pseudos.eq, {
                radio: !0,
                checkbox: !0,
                file: !0,
                password: !0,
                image: !0
            }) k.pseudos[g] = i(g);
        for (g in {
                submit: !0,
                reset: !0
            }) k.pseudos[g] = a(g);
        return c.prototype = k.filters = k.pseudos, k.setFilters = new c, S = w.tokenize = function(e, t) {
            var n, i, r, a, o, s, l, u = V[e + " "];
            if (u) return t ? 0 : u.slice(0);
            for (o = e, s = [], l = k.preFilter; o;) {
                for (a in n && !(i = ue.exec(o)) || (i && (o = o.slice(i[0].length) || o), s.push(r = [])), n = !1, (i = ce.exec(o)) && (n = i.shift(), r.push({
                        value: n,
                        type: i[0].replace(le, " ")
                    }), o = o.slice(n.length)), k.filter) !(i = fe[a].exec(o)) || l[a] && !(i = l[a](i)) || (n = i.shift(), r.push({
                    value: n,
                    type: a,
                    matches: i
                }), o = o.slice(n.length));
                if (!n) break
            }
            return t ? o.length : o ? w.error(e) : V(e, s).slice(0)
        }, T = w.compile = function(e, t) {
            var n, i = [],
                r = [],
                a = X[e + " "];
            if (!a) {
                for (t || (t = S(e)), n = t.length; n--;)(a = h(t[n]))[B] ? i.push(a) : r.push(a);
                (a = X(e, v(r, i))).selector = e
            }
            return a
        }, M = w.select = function(e, t, n, i) {
            var r, a, o, s, l, u = "function" == typeof e && e,
                c = !i && S(e = u.selector || e);
            if (n = n || [], 1 === c.length) {
                if (2 < (a = c[0] = c[0].slice(0)).length && "ID" === (o = a[0]).type && 9 === t.nodeType && L && k.relative[a[1].type]) {
                    if (!(t = (k.find.ID(o.matches[0].replace(Ce, xe), t) || [])[0])) return n;
                    u && (t = t.parentNode), e = e.slice(a.shift().value.length)
                }
                for (r = fe.needsContext.test(e) ? 0 : a.length; r-- && (o = a[r], !k.relative[s = o.type]);)
                    if ((l = k.find[s]) && (i = l(o.matches[0].replace(Ce, xe), we.test(a[0].type) && f(t.parentNode) || t))) {
                        if (a.splice(r, 1), !(e = i.length && m(a))) return J.apply(n, i), n;
                        break
                    }
            }
            return (u || T(e, c))(i, t, !L, n, !t || we.test(e) && f(t.parentNode) || t), n
        }, x.sortStable = B.split("").sort(U).join("") === B, x.detectDuplicates = !!I, P(), x.sortDetached = r(function(e) {
            return 1 & e.compareDocumentPosition(j.createElement("fieldset"))
        }), r(function(e) {
            return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
        }) || t("type|href|height|width", function(e, t, n) {
            if (!n) return e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
        }), x.attributes && r(function(e) {
            return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
        }) || t("value", function(e, t, n) {
            if (!n && "input" === e.nodeName.toLowerCase()) return e.defaultValue
        }), r(function(e) {
            return null == e.getAttribute("disabled")
        }) || t(ne, function(e, t, n) {
            var i;
            if (!n) return !0 === e[t] ? t.toLowerCase() : (i = e.getAttributeNode(t)) && i.specified ? i.value : null
        }), w
    }(_);
    _e.find = Ee, _e.expr = Ee.selectors, _e.expr[":"] = _e.expr.pseudos, _e.uniqueSort = _e.unique = Ee.uniqueSort, _e.text = Ee.getText, _e.isXMLDoc = Ee.isXML, _e.contains = Ee.contains, _e.escapeSelector = Ee.escape;
    var Se = function(e, t, n) {
            for (var i = [], r = n !== undefined;
                (e = e[t]) && 9 !== e.nodeType;)
                if (1 === e.nodeType) {
                    if (r && _e(e).is(n)) break;
                    i.push(e)
                } return i
        },
        Te = function(e, t) {
            for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
            return n
        },
        Me = _e.expr.match.needsContext,
        $e = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;
    _e.filter = function(e, t, n) {
        var i = t[0];
        return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === i.nodeType ? _e.find.matchesSelector(i, e) ? [i] : [] : _e.find.matches(e, _e.grep(t, function(e) {
            return 1 === e.nodeType
        }))
    }, _e.fn.extend({
        find: function(e) {
            var t, n, i = this.length,
                r = this;
            if ("string" != typeof e) return this.pushStack(_e(e).filter(function() {
                for (t = 0; t < i; t++)
                    if (_e.contains(r[t], this)) return !0
            }));
            for (n = this.pushStack([]), t = 0; t < i; t++) _e.find(e, r[t], n);
            return 1 < i ? _e.uniqueSort(n) : n
        },
        filter: function(e) {
            return this.pushStack(t(this, e || [], !1))
        },
        not: function(e) {
            return this.pushStack(t(this, e || [], !0))
        },
        is: function(e) {
            return !!t(this, "string" == typeof e && Me.test(e) ? _e(e) : e || [], !1).length
        }
    });
    var Ae, Ie = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (_e.fn.init = function(e, t, n) {
        var i, r;
        if (!e) return this;
        if (n = n || Ae, "string" != typeof e) return e.nodeType ? (this[0] = e, this.length = 1, this) : be(e) ? n.ready !== undefined ? n.ready(e) : e(_e) : _e.makeArray(e, this);
        if (!(i = "<" === e[0] && ">" === e[e.length - 1] && 3 <= e.length ? [null, e, null] : Ie.exec(e)) || !i[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
        if (i[1]) {
            if (t = t instanceof _e ? t[0] : t, _e.merge(this, _e.parseHTML(i[1], t && t.nodeType ? t.ownerDocument || t : Ce, !0)), $e.test(i[1]) && _e.isPlainObject(t))
                for (i in t) be(this[i]) ? this[i](t[i]) : this.attr(i, t[i]);
            return this
        }
        return (r = Ce.getElementById(i[2])) && (this[0] = r, this.length = 1), this
    }).prototype = _e.fn, Ae = _e(Ce);
    var Pe = /^(?:parents|prev(?:Until|All))/,
        je = {
            children: !0,
            contents: !0,
            next: !0,
            prev: !0
        };
    _e.fn.extend({
        has: function(e) {
            var t = _e(e, this),
                n = t.length;
            return this.filter(function() {
                for (var e = 0; e < n; e++)
                    if (_e.contains(this, t[e])) return !0
            })
        },
        closest: function(e, t) {
            var n, i = 0,
                r = this.length,
                a = [],
                o = "string" != typeof e && _e(e);
            if (!Me.test(e))
                for (; i < r; i++)
                    for (n = this[i]; n && n !== t; n = n.parentNode)
                        if (n.nodeType < 11 && (o ? -1 < o.index(n) : 1 === n.nodeType && _e.find.matchesSelector(n, e))) {
                            a.push(n);
                            break
                        } return this.pushStack(1 < a.length ? _e.uniqueSort(a) : a)
        },
        index: function(e) {
            return e ? "string" == typeof e ? pe.call(_e(e), this[0]) : pe.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        },
        add: function(e, t) {
            return this.pushStack(_e.uniqueSort(_e.merge(this.get(), _e(e, t))))
        },
        addBack: function(e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), _e.each({
        parent: function(e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        },
        parents: function(e) {
            return Se(e, "parentNode")
        },
        parentsUntil: function(e, t, n) {
            return Se(e, "parentNode", n)
        },
        next: function(e) {
            return n(e, "nextSibling")
        },
        prev: function(e) {
            return n(e, "previousSibling")
        },
        nextAll: function(e) {
            return Se(e, "nextSibling")
        },
        prevAll: function(e) {
            return Se(e, "previousSibling")
        },
        nextUntil: function(e, t, n) {
            return Se(e, "nextSibling", n)
        },
        prevUntil: function(e, t, n) {
            return Se(e, "previousSibling", n)
        },
        siblings: function(e) {
            return Te((e.parentNode || {}).firstChild, e)
        },
        children: function(e) {
            return Te(e.firstChild)
        },
        contents: function(e) {
            return null != e.contentDocument && le(e.contentDocument) ? e.contentDocument : (u(e, "template") && (e = e.content || e), _e.merge([], e.childNodes))
        }
    }, function(i, r) {
        _e.fn[i] = function(e, t) {
            var n = _e.map(this, r, e);
            return "Until" !== i.slice(-5) && (t = e), t && "string" == typeof t && (n = _e.filter(t, n)), 1 < this.length && (je[i] || _e.uniqueSort(n), Pe.test(i) && n.reverse()), this.pushStack(n)
        }
    });
    var De = /[^\x20\t\r\n\f]+/g;
    _e.Callbacks = function(i) {
        i = "string" == typeof i ? c(i) : _e.extend({}, i);
        var r, e, t, n, a = [],
            o = [],
            s = -1,
            l = function() {
                for (n = n || i.once, t = r = !0; o.length; s = -1)
                    for (e = o.shift(); ++s < a.length;) !1 === a[s].apply(e[0], e[1]) && i.stopOnFalse && (s = a.length, e = !1);
                i.memory || (e = !1), r = !1, n && (a = e ? [] : "")
            },
            u = {
                add: function() {
                    return a && (e && !r && (s = a.length - 1, o.push(e)), function n(e) {
                        _e.each(e, function(e, t) {
                            be(t) ? i.unique && u.has(t) || a.push(t) : t && t.length && "string" !== v(t) && n(t)
                        })
                    }(arguments), e && !r && l()), this
                },
                remove: function() {
                    return _e.each(arguments, function(e, t) {
                        for (var n; - 1 < (n = _e.inArray(t, a, n));) a.splice(n, 1), n <= s && s--
                    }), this
                },
                has: function(e) {
                    return e ? -1 < _e.inArray(e, a) : 0 < a.length
                },
                empty: function() {
                    return a && (a = []), this
                },
                disable: function() {
                    return n = o = [], a = e = "", this
                },
                disabled: function() {
                    return !a
                },
                lock: function() {
                    return n = o = [], e || r || (a = e = ""), this
                },
                locked: function() {
                    return !!n
                },
                fireWith: function(e, t) {
                    return n || (t = [e, (t = t || []).slice ? t.slice() : t], o.push(t), r || l()), this
                },
                fire: function() {
                    return u.fireWith(this, arguments), this
                },
                fired: function() {
                    return !!t
                }
            };
        return u
    }, _e.extend({
        Deferred: function(e) {
            var a = [
                    ["notify", "progress", _e.Callbacks("memory"), _e.Callbacks("memory"), 2],
                    ["resolve", "done", _e.Callbacks("once memory"), _e.Callbacks("once memory"), 0, "resolved"],
                    ["reject", "fail", _e.Callbacks("once memory"), _e.Callbacks("once memory"), 1, "rejected"]
                ],
                r = "pending",
                o = {
                    state: function() {
                        return r
                    },
                    always: function() {
                        return s.done(arguments).fail(arguments), this
                    },
                    "catch": function(e) {
                        return o.then(null, e)
                    },
                    pipe: function() {
                        var r = arguments;
                        return _e.Deferred(function(i) {
                            _e.each(a, function(e, t) {
                                var n = be(r[t[4]]) && r[t[4]];
                                s[t[1]](function() {
                                    var e = n && n.apply(this, arguments);
                                    e && be(e.promise) ? e.promise().progress(i.notify).done(i.resolve).fail(i.reject) : i[t[0] + "With"](this, n ? [e] : arguments)
                                })
                            }), r = null
                        }).promise()
                    },
                    then: function(t, n, i) {
                        function u(a, o, s, l) {
                            return function() {
                                var n = this,
                                    i = arguments,
                                    t = function() {
                                        var e, t;
                                        if (!(a < c)) {
                                            if ((e = s.apply(n, i)) === o.promise()) throw new TypeError("Thenable self-resolution");
                                            t = e && ("object" == typeof e || "function" == typeof e) && e.then, be(t) ? l ? t.call(e, u(c, o, d, l), u(c, o, p, l)) : (c++, t.call(e, u(c, o, d, l), u(c, o, p, l), u(c, o, d, o.notifyWith))) : (s !== d && (n = undefined, i = [e]), (l || o.resolveWith)(n, i))
                                        }
                                    },
                                    r = l ? t : function() {
                                        try {
                                            t()
                                        } catch (e) {
                                            _e.Deferred.exceptionHook && _e.Deferred.exceptionHook(e, r.stackTrace), c <= a + 1 && (s !== p && (n = undefined, i = [e]), o.rejectWith(n, i))
                                        }
                                    };
                                a ? r() : (_e.Deferred.getStackHook && (r.stackTrace = _e.Deferred.getStackHook()), _.setTimeout(r))
                            }
                        }
                        var c = 0;
                        return _e.Deferred(function(e) {
                            a[0][3].add(u(0, e, be(i) ? i : d, e.notifyWith)), a[1][3].add(u(0, e, be(t) ? t : d)), a[2][3].add(u(0, e, be(n) ? n : p))
                        }).promise()
                    },
                    promise: function(e) {
                        return null != e ? _e.extend(e, o) : o
                    }
                },
                s = {};
            return _e.each(a, function(e, t) {
                var n = t[2],
                    i = t[5];
                o[t[1]] = n.add, i && n.add(function() {
                    r = i
                }, a[3 - e][2].disable, a[3 - e][3].disable, a[0][2].lock, a[0][3].lock), n.add(t[3].fire), s[t[0]] = function() {
                    return s[t[0] + "With"](this === s ? undefined : this, arguments), this
                }, s[t[0] + "With"] = n.fireWith
            }), o.promise(s), e && e.call(s, s), s
        },
        when: function(e) {
            var n = arguments.length,
                t = n,
                i = Array(t),
                r = ue.call(arguments),
                a = _e.Deferred(),
                o = function(t) {
                    return function(e) {
                        i[t] = this, r[t] = 1 < arguments.length ? ue.call(arguments) : e, --n || a.resolveWith(i, r)
                    }
                };
            if (n <= 1 && (l(e, a.done(o(t)).resolve, a.reject, !n), "pending" === a.state() || be(r[t] && r[t].then))) return a.then();
            for (; t--;) l(r[t], o(t), a.reject);
            return a.promise()
        }
    });
    var Le = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    _e.Deferred.exceptionHook = function(e, t) {
        _.console && _.console.warn && e && Le.test(e.name) && _.console.warn("jQuery.Deferred exception: " + e.message, e.stack, t)
    }, _e.readyException = function(e) {
        _.setTimeout(function() {
            throw e
        })
    };
    var Fe = _e.Deferred();
    _e.fn.ready = function(e) {
        return Fe.then(e)["catch"](function(e) {
            _e.readyException(e)
        }), this
    }, _e.extend({
        isReady: !1,
        readyWait: 1,
        ready: function(e) {
            (!0 === e ? --_e.readyWait : _e.isReady) || (_e.isReady = !0) !== e && 0 < --_e.readyWait || Fe.resolveWith(Ce, [_e])
        }
    }), _e.ready.then = Fe.then, "complete" === Ce.readyState || "loading" !== Ce.readyState && !Ce.documentElement.doScroll ? _.setTimeout(_e.ready) : (Ce.addEventListener("DOMContentLoaded", i), _.addEventListener("load", i));
    var Oe = function(e, t, n, i, r, a, o) {
            var s = 0,
                l = e.length,
                u = null == n;
            if ("object" === v(n))
                for (s in r = !0, n) Oe(e, t, s, n[s], !0, a, o);
            else if (i !== undefined && (r = !0, be(i) || (o = !0), u && (o ? (t.call(e, i), t = null) : (u = t, t = function(e, t, n) {
                    return u.call(_e(e), n)
                })), t))
                for (; s < l; s++) t(e[s], n, o ? i : i.call(e[s], s, t(e[s], n)));
            return r ? e : u ? t.call(e) : l ? t(e[0], n) : a
        },
        ze = /^-ms-/,
        Ne = /-([a-z])/g,
        Be = function(e) {
            return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
        };
    a.uid = 1, a.prototype = {
        cache: function(e) {
            var t = e[this.expando];
            return t || (t = {}, Be(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
                value: t,
                configurable: !0
            }))), t
        },
        set: function(e, t, n) {
            var i, r = this.cache(e);
            if ("string" == typeof t) r[h(t)] = n;
            else
                for (i in t) r[h(i)] = t[i];
            return r
        },
        get: function(e, t) {
            return t === undefined ? this.cache(e) : e[this.expando] && e[this.expando][h(t)]
        },
        access: function(e, t, n) {
            return t === undefined || t && "string" == typeof t && n === undefined ? this.get(e, t) : (this.set(e, t, n), n !== undefined ? n : t)
        },
        remove: function(e, t) {
            var n, i = e[this.expando];
            if (i !== undefined) {
                if (t !== undefined) {
                    n = (t = Array.isArray(t) ? t.map(h) : (t = h(t)) in i ? [t] : t.match(De) || []).length;
                    for (; n--;) delete i[t[n]]
                }(t === undefined || _e.isEmptyObject(i)) && (e.nodeType ? e[this.expando] = undefined : delete e[this.expando])
            }
        },
        hasData: function(e) {
            var t = e[this.expando];
            return t !== undefined && !_e.isEmptyObject(t)
        }
    };
    var Re = new a,
        He = new a,
        qe = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        We = /[A-Z]/g;
    _e.extend({
        hasData: function(e) {
            return He.hasData(e) || Re.hasData(e)
        },
        data: function(e, t, n) {
            return He.access(e, t, n)
        },
        removeData: function(e, t) {
            He.remove(e, t)
        },
        _data: function(e, t, n) {
            return Re.access(e, t, n)
        },
        _removeData: function(e, t) {
            Re.remove(e, t)
        }
    }), _e.fn.extend({
        data: function(n, e) {
            var t, i, r, a = this[0],
                o = a && a.attributes;
            if (n !== undefined) return "object" == typeof n ? this.each(function() {
                He.set(this, n)
            }) : Oe(this, function(e) {
                var t;
                if (a && e === undefined) return (t = He.get(a, n)) !== undefined ? t : (t = f(a, n)) !== undefined ? t : void 0;
                this.each(function() {
                    He.set(this, n, e)
                })
            }, null, e, 1 < arguments.length, null, !0);
            if (this.length && (r = He.get(a), 1 === a.nodeType && !Re.get(a, "hasDataAttrs"))) {
                for (t = o.length; t--;) o[t] && 0 === (i = o[t].name).indexOf("data-") && (i = h(i.slice(5)), f(a, i, r[i]));
                Re.set(a, "hasDataAttrs", !0)
            }
            return r
        },
        removeData: function(e) {
            return this.each(function() {
                He.remove(this, e)
            })
        }
    }), _e.extend({
        queue: function(e, t, n) {
            var i;
            if (e) return t = (t || "fx") + "queue", i = Re.get(e, t), n && (!i || Array.isArray(n) ? i = Re.access(e, t, _e.makeArray(n)) : i.push(n)), i || []
        },
        dequeue: function(e, t) {
            t = t || "fx";
            var n = _e.queue(e, t),
                i = n.length,
                r = n.shift(),
                a = _e._queueHooks(e, t),
                o = function() {
                    _e.dequeue(e, t)
                };
            "inprogress" === r && (r = n.shift(), i--), r && ("fx" === t && n.unshift("inprogress"), delete a.stop, r.call(e, o, a)), !i && a && a.empty.fire()
        },
        _queueHooks: function(e, t) {
            var n = t + "queueHooks";
            return Re.get(e, n) || Re.access(e, n, {
                empty: _e.Callbacks("once memory").add(function() {
                    Re.remove(e, [t + "queue", n])
                })
            })
        }
    }), _e.fn.extend({
        queue: function(t, n) {
            var e = 2;
            return "string" != typeof t && (n = t, t = "fx", e--), arguments.length < e ? _e.queue(this[0], t) : n === undefined ? this : this.each(function() {
                var e = _e.queue(this, t, n);
                _e._queueHooks(this, t), "fx" === t && "inprogress" !== e[0] && _e.dequeue(this, t)
            })
        },
        dequeue: function(e) {
            return this.each(function() {
                _e.dequeue(this, e)
            })
        },
        clearQueue: function(e) {
            return this.queue(e || "fx", [])
        },
        promise: function(e, t) {
            var n, i = 1,
                r = _e.Deferred(),
                a = this,
                o = this.length,
                s = function() {
                    --i || r.resolveWith(a, [a])
                };
            for ("string" != typeof e && (t = e, e = undefined), e = e || "fx"; o--;)(n = Re.get(a[o], e + "queueHooks")) && n.empty && (i++, n.empty.add(s));
            return s(), r.promise(t)
        }
    });
    var Ve = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        Xe = new RegExp("^(?:([+-])=|)(" + Ve + ")([a-z%]*)$", "i"),
        Ge = ["Top", "Right", "Bottom", "Left"],
        Ue = Ce.documentElement,
        Ye = function(e) {
            return _e.contains(e.ownerDocument, e)
        },
        Qe = {
            composed: !0
        };
    Ue.getRootNode && (Ye = function(e) {
        return _e.contains(e.ownerDocument, e) || e.getRootNode(Qe) === e.ownerDocument
    });
    var Ze = function(e, t) {
            return "none" === (e = t || e).style.display || "" === e.style.display && Ye(e) && "none" === _e.css(e, "display")
        },
        Ke = {};
    _e.fn.extend({
        show: function() {
            return b(this, !0)
        },
        hide: function() {
            return b(this)
        },
        toggle: function(e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function() {
                Ze(this) ? _e(this).show() : _e(this).hide()
            })
        }
    });
    var Je, et, tt = /^(?:checkbox|radio)$/i,
        nt = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
        it = /^$|^module$|\/(?:java|ecma)script/i;
    Je = Ce.createDocumentFragment().appendChild(Ce.createElement("div")), (et = Ce.createElement("input")).setAttribute("type", "radio"), et.setAttribute("checked", "checked"), et.setAttribute("name", "t"), Je.appendChild(et), ye.checkClone = Je.cloneNode(!0).cloneNode(!0).lastChild.checked, Je.innerHTML = "<textarea>x</textarea>", ye.noCloneChecked = !!Je.cloneNode(!0).lastChild.defaultValue, Je.innerHTML = "<option></option>", ye.option = !!Je.lastChild;
    var rt = {
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""]
    };
    rt.tbody = rt.tfoot = rt.colgroup = rt.caption = rt.thead, rt.th = rt.td, ye.option || (rt.optgroup = rt.option = [1, "<select multiple='multiple'>", "</select>"]);
    var at = /<|&#?\w+;/,
        ot = /^key/,
        st = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
        lt = /^([^.]*)(?:\.(.+)|)/;
    _e.event = {
        global: {},
        add: function(t, e, n, i, r) {
            var a, o, s, l, u, c, d, p, h, f, m, v = Re.get(t);
            if (Be(t))
                for (n.handler && (n = (a = n).handler, r = a.selector), r && _e.find.matchesSelector(Ue, r), n.guid || (n.guid = _e.guid++), (l = v.events) || (l = v.events = Object.create(null)), (o = v.handle) || (o = v.handle = function(e) {
                        return void 0 !== _e && _e.event.triggered !== e.type ? _e.event.dispatch.apply(t, arguments) : undefined
                    }), u = (e = (e || "").match(De) || [""]).length; u--;) h = m = (s = lt.exec(e[u]) || [])[1], f = (s[2] || "").split(".").sort(), h && (d = _e.event.special[h] || {}, h = (r ? d.delegateType : d.bindType) || h, d = _e.event.special[h] || {}, c = _e.extend({
                    type: h,
                    origType: m,
                    data: i,
                    handler: n,
                    guid: n.guid,
                    selector: r,
                    needsContext: r && _e.expr.match.needsContext.test(r),
                    namespace: f.join(".")
                }, a), (p = l[h]) || ((p = l[h] = []).delegateCount = 0, d.setup && !1 !== d.setup.call(t, i, f, o) || t.addEventListener && t.addEventListener(h, o)), d.add && (d.add.call(t, c), c.handler.guid || (c.handler.guid = n.guid)), r ? p.splice(p.delegateCount++, 0, c) : p.push(c), _e.event.global[h] = !0)
        },
        remove: function(e, t, n, i, r) {
            var a, o, s, l, u, c, d, p, h, f, m, v = Re.hasData(e) && Re.get(e);
            if (v && (l = v.events)) {
                for (u = (t = (t || "").match(De) || [""]).length; u--;)
                    if (h = m = (s = lt.exec(t[u]) || [])[1], f = (s[2] || "").split(".").sort(), h) {
                        for (d = _e.event.special[h] || {}, p = l[h = (i ? d.delegateType : d.bindType) || h] || [], s = s[2] && new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)"), o = a = p.length; a--;) c = p[a], !r && m !== c.origType || n && n.guid !== c.guid || s && !s.test(c.namespace) || i && i !== c.selector && ("**" !== i || !c.selector) || (p.splice(a, 1), c.selector && p.delegateCount--, d.remove && d.remove.call(e, c));
                        o && !p.length && (d.teardown && !1 !== d.teardown.call(e, f, v.handle) || _e.removeEvent(e, h, v.handle), delete l[h])
                    } else
                        for (h in l) _e.event.remove(e, h + t[u], n, i, !0);
                _e.isEmptyObject(l) && Re.remove(e, "handle events")
            }
        },
        dispatch: function(e) {
            var t, n, i, r, a, o, s = new Array(arguments.length),
                l = _e.event.fix(e),
                u = (Re.get(this, "events") || Object.create(null))[l.type] || [],
                c = _e.event.special[l.type] || {};
            for (s[0] = l, t = 1; t < arguments.length; t++) s[t] = arguments[t];
            if (l.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, l)) {
                for (o = _e.event.handlers.call(this, l, u), t = 0;
                    (r = o[t++]) && !l.isPropagationStopped();)
                    for (l.currentTarget = r.elem, n = 0;
                        (a = r.handlers[n++]) && !l.isImmediatePropagationStopped();) l.rnamespace && !1 !== a.namespace && !l.rnamespace.test(a.namespace) || (l.handleObj = a, l.data = a.data, (i = ((_e.event.special[a.origType] || {}).handle || a.handler).apply(r.elem, s)) !== undefined && !1 === (l.result = i) && (l.preventDefault(), l.stopPropagation()));
                return c.postDispatch && c.postDispatch.call(this, l), l.result
            }
        },
        handlers: function(e, t) {
            var n, i, r, a, o, s = [],
                l = t.delegateCount,
                u = e.target;
            if (l && u.nodeType && !("click" === e.type && 1 <= e.button))
                for (; u !== this; u = u.parentNode || this)
                    if (1 === u.nodeType && ("click" !== e.type || !0 !== u.disabled)) {
                        for (a = [], o = {}, n = 0; n < l; n++) o[r = (i = t[n]).selector + " "] === undefined && (o[r] = i.needsContext ? -1 < _e(r, this).index(u) : _e.find(r, this, null, [u]).length), o[r] && a.push(i);
                        a.length && s.push({
                            elem: u,
                            handlers: a
                        })
                    } return u = this, l < t.length && s.push({
                elem: u,
                handlers: t.slice(l)
            }), s
        },
        addProp: function(t, e) {
            Object.defineProperty(_e.Event.prototype, t, {
                enumerable: !0,
                configurable: !0,
                get: be(e) ? function() {
                    if (this.originalEvent) return e(this.originalEvent)
                } : function() {
                    if (this.originalEvent) return this.originalEvent[t]
                },
                set: function(e) {
                    Object.defineProperty(this, t, {
                        enumerable: !0,
                        configurable: !0,
                        writable: !0,
                        value: e
                    })
                }
            })
        },
        fix: function(e) {
            return e[_e.expando] ? e : new _e.Event(e)
        },
        special: {
            load: {
                noBubble: !0
            },
            click: {
                setup: function(e) {
                    var t = this || e;
                    return tt.test(t.type) && t.click && u(t, "input") && $(t, "click", k), !1
                },
                trigger: function(e) {
                    var t = this || e;
                    return tt.test(t.type) && t.click && u(t, "input") && $(t, "click"), !0
                },
                _default: function(e) {
                    var t = e.target;
                    return tt.test(t.type) && t.click && u(t, "input") && Re.get(t, "click") || u(t, "a")
                }
            },
            beforeunload: {
                postDispatch: function(e) {
                    e.result !== undefined && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        }
    }, _e.removeEvent = function(e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n)
    }, _e.Event = function(e, t) {
        if (!(this instanceof _e.Event)) return new _e.Event(e, t);
        e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || e.defaultPrevented === undefined && !1 === e.returnValue ? k : E, this.target = e.target && 3 === e.target.nodeType ? e.target.parentNode : e.target, this.currentTarget = e.currentTarget, this.relatedTarget = e.relatedTarget) : this.type = e, t && _e.extend(this, t), this.timeStamp = e && e.timeStamp || Date.now(), this[_e.expando] = !0
    }, _e.Event.prototype = {
        constructor: _e.Event,
        isDefaultPrevented: E,
        isPropagationStopped: E,
        isImmediatePropagationStopped: E,
        isSimulated: !1,
        preventDefault: function() {
            var e = this.originalEvent;
            this.isDefaultPrevented = k, e && !this.isSimulated && e.preventDefault()
        },
        stopPropagation: function() {
            var e = this.originalEvent;
            this.isPropagationStopped = k, e && !this.isSimulated && e.stopPropagation()
        },
        stopImmediatePropagation: function() {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = k, e && !this.isSimulated && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, _e.each({
        altKey: !0,
        bubbles: !0,
        cancelable: !0,
        changedTouches: !0,
        ctrlKey: !0,
        detail: !0,
        eventPhase: !0,
        metaKey: !0,
        pageX: !0,
        pageY: !0,
        shiftKey: !0,
        view: !0,
        "char": !0,
        code: !0,
        charCode: !0,
        key: !0,
        keyCode: !0,
        button: !0,
        buttons: !0,
        clientX: !0,
        clientY: !0,
        offsetX: !0,
        offsetY: !0,
        pointerId: !0,
        pointerType: !0,
        screenX: !0,
        screenY: !0,
        targetTouches: !0,
        toElement: !0,
        touches: !0,
        which: function(e) {
            var t = e.button;
            return null == e.which && ot.test(e.type) ? null != e.charCode ? e.charCode : e.keyCode : !e.which && t !== undefined && st.test(e.type) ? 1 & t ? 1 : 2 & t ? 3 : 4 & t ? 2 : 0 : e.which
        }
    }, _e.event.addProp), _e.each({
        focus: "focusin",
        blur: "focusout"
    }, function(e, t) {
        _e.event.special[e] = {
            setup: function() {
                return $(this, e, S), !1
            },
            trigger: function() {
                return $(this, e), !0
            },
            delegateType: t
        }
    }), _e.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function(e, a) {
        _e.event.special[e] = {
            delegateType: a,
            bindType: a,
            handle: function(e) {
                var t, n = this,
                    i = e.relatedTarget,
                    r = e.handleObj;
                return i && (i === n || _e.contains(n, i)) || (e.type = r.origType, t = r.handler.apply(this, arguments), e.type = a), t
            }
        }
    }), _e.fn.extend({
        on: function(e, t, n, i) {
            return M(this, e, t, n, i)
        },
        one: function(e, t, n, i) {
            return M(this, e, t, n, i, 1)
        },
        off: function(e, t, n) {
            var i, r;
            if (e && e.preventDefault && e.handleObj) return i = e.handleObj, _e(e.delegateTarget).off(i.namespace ? i.origType + "." + i.namespace : i.origType, i.selector, i.handler), this;
            if ("object" != typeof e) return !1 !== t && "function" != typeof t || (n = t, t = undefined), !1 === n && (n = E), this.each(function() {
                _e.event.remove(this, e, n, t)
            });
            for (r in e) this.off(r, t, e[r]);
            return this
        }
    });
    var ut = /<script|<style|<link/i,
        ct = /checked\s*(?:[^=]|=\s*.checked.)/i,
        dt = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;
    _e.extend({
        htmlPrefilter: function(e) {
            return e
        },
        clone: function(e, t, n) {
            var i, r, a, o, s = e.cloneNode(!0),
                l = Ye(e);
            if (!(ye.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || _e.isXMLDoc(e)))
                for (o = w(s), i = 0, r = (a = w(e)).length; i < r; i++) D(a[i], o[i]);
            if (t)
                if (n)
                    for (a = a || w(e), o = o || w(s), i = 0, r = a.length; i < r; i++) j(a[i], o[i]);
                else j(e, s);
            return 0 < (o = w(s, "script")).length && C(o, !l && w(e, "script")), s
        },
        cleanData: function(e) {
            for (var t, n, i, r = _e.event.special, a = 0;
                (n = e[a]) !== undefined; a++)
                if (Be(n)) {
                    if (t = n[Re.expando]) {
                        if (t.events)
                            for (i in t.events) r[i] ? _e.event.remove(n, i) : _e.removeEvent(n, i, t.handle);
                        n[Re.expando] = undefined
                    }
                    n[He.expando] && (n[He.expando] = undefined)
                }
        }
    }), _e.fn.extend({
        detach: function(e) {
            return F(this, e, !0)
        },
        remove: function(e) {
            return F(this, e)
        },
        text: function(e) {
            return Oe(this, function(e) {
                return e === undefined ? _e.text(this) : this.empty().each(function() {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = e)
                })
            }, null, e, arguments.length)
        },
        append: function() {
            return L(this, arguments, function(e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || A(this, e).appendChild(e)
            })
        },
        prepend: function() {
            return L(this, arguments, function(e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = A(this, e);
                    t.insertBefore(e, t.firstChild)
                }
            })
        },
        before: function() {
            return L(this, arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        },
        after: function() {
            return L(this, arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        },
        empty: function() {
            for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (_e.cleanData(w(e, !1)), e.textContent = "");
            return this
        },
        clone: function(e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map(function() {
                return _e.clone(this, e, t)
            })
        },
        html: function(e) {
            return Oe(this, function(e) {
                var t = this[0] || {},
                    n = 0,
                    i = this.length;
                if (e === undefined && 1 === t.nodeType) return t.innerHTML;
                if ("string" == typeof e && !ut.test(e) && !rt[(nt.exec(e) || ["", ""])[1].toLowerCase()]) {
                    e = _e.htmlPrefilter(e);
                    try {
                        for (; n < i; n++) 1 === (t = this[n] || {}).nodeType && (_e.cleanData(w(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (r) {}
                }
                t && this.empty().append(e)
            }, null, e, arguments.length)
        },
        replaceWith: function() {
            var n = [];
            return L(this, arguments, function(e) {
                var t = this.parentNode;
                _e.inArray(this, n) < 0 && (_e.cleanData(w(this)), t && t.replaceChild(e, this))
            }, n)
        }
    }), _e.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function(e, o) {
        _e.fn[e] = function(e) {
            for (var t, n = [], i = _e(e), r = i.length - 1, a = 0; a <= r; a++) t = a === r ? this : this.clone(!0), _e(i[a])[o](t), de.apply(n, t.get());
            return this.pushStack(n)
        }
    });
    var pt = new RegExp("^(" + Ve + ")(?!px)[a-z%]+$", "i"),
        ht = function(e) {
            var t = e.ownerDocument.defaultView;
            return t && t.opener || (t = _), t.getComputedStyle(e)
        },
        ft = function(e, t, n) {
            var i, r, a = {};
            for (r in t) a[r] = e.style[r], e.style[r] = t[r];
            for (r in i = n.call(e), t) e.style[r] = a[r];
            return i
        },
        mt = new RegExp(Ge.join("|"), "i");
    ! function() {
        function e() {
            if (u) {
                l.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", u.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", Ue.appendChild(l).appendChild(u);
                var e = _.getComputedStyle(u);
                n = "1%" !== e.top, s = 12 === t(e.marginLeft), u.style.right = "60%", a = 36 === t(e.right), i = 36 === t(e.width), u.style.position = "absolute", r = 12 === t(u.offsetWidth / 3), Ue.removeChild(l), u = null
            }
        }

        function t(e) {
            return Math.round(parseFloat(e))
        }
        var n, i, r, a, o, s, l = Ce.createElement("div"),
            u = Ce.createElement("div");
        u.style && (u.style.backgroundClip = "content-box", u.cloneNode(!0).style.backgroundClip = "", ye.clearCloneStyle = "content-box" === u.style.backgroundClip, _e.extend(ye, {
            boxSizingReliable: function() {
                return e(), i
            },
            pixelBoxStyles: function() {
                return e(), a
            },
            pixelPosition: function() {
                return e(), n
            },
            reliableMarginLeft: function() {
                return e(), s
            },
            scrollboxSize: function() {
                return e(), r
            },
            reliableTrDimensions: function() {
                var e, t, n, i;
                return null == o && (e = Ce.createElement("table"), t = Ce.createElement("tr"), n = Ce.createElement("div"), e.style.cssText = "position:absolute;left:-11111px", t.style.height = "1px", n.style.height = "9px", Ue.appendChild(e).appendChild(t).appendChild(n), i = _.getComputedStyle(t), o = 3 < parseInt(i.height), Ue.removeChild(e)), o
            }
        }))
    }();
    var vt = ["Webkit", "Moz", "ms"],
        gt = Ce.createElement("div").style,
        yt = {},
        bt = /^(none|table(?!-c[ea]).+)/,
        wt = /^--/,
        Ct = {
            position: "absolute",
            visibility: "hidden",
            display: "block"
        },
        xt = {
            letterSpacing: "0",
            fontWeight: "400"
        };
    _e.extend({
        cssHooks: {
            opacity: {
                get: function(e, t) {
                    if (t) {
                        var n = O(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            gridArea: !0,
            gridColumn: !0,
            gridColumnEnd: !0,
            gridColumnStart: !0,
            gridRow: !0,
            gridRowEnd: !0,
            gridRowStart: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {},
        style: function(e, t, n, i) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var r, a, o, s = h(t),
                    l = wt.test(t),
                    u = e.style;
                if (l || (t = B(s)), o = _e.cssHooks[t] || _e.cssHooks[s], n === undefined) return o && "get" in o && (r = o.get(e, !1, i)) !== undefined ? r : u[t];
                "string" === (a = typeof n) && (r = Xe.exec(n)) && r[1] && (n = g(e, t, r), a = "number"), null != n && n == n && ("number" !== a || l || (n += r && r[3] || (_e.cssNumber[s] ? "" : "px")), ye.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (u[t] = "inherit"), o && "set" in o && (n = o.set(e, n, i)) === undefined || (l ? u.setProperty(t, n) : u[t] = n))
            }
        },
        css: function(e, t, n, i) {
            var r, a, o, s = h(t);
            return wt.test(t) || (t = B(s)), (o = _e.cssHooks[t] || _e.cssHooks[s]) && "get" in o && (r = o.get(e, !0, n)), r === undefined && (r = O(e, t, i)), "normal" === r && t in xt && (r = xt[t]), "" === n || n ? (a = parseFloat(r), !0 === n || isFinite(a) ? a || 0 : r) : r
        }
    }), _e.each(["height", "width"], function(e, l) {
        _e.cssHooks[l] = {
            get: function(e, t, n) {
                if (t) return !bt.test(_e.css(e, "display")) || e.getClientRects().length && e.getBoundingClientRect().width ? q(e, l, n) : ft(e, Ct, function() {
                    return q(e, l, n)
                })
            },
            set: function(e, t, n) {
                var i, r = ht(e),
                    a = !ye.scrollboxSize() && "absolute" === r.position,
                    o = (a || n) && "border-box" === _e.css(e, "boxSizing", !1, r),
                    s = n ? H(e, l, n, o, r) : 0;
                return o && a && (s -= Math.ceil(e["offset" + l[0].toUpperCase() + l.slice(1)] - parseFloat(r[l]) - H(e, l, "border", !1, r) - .5)), s && (i = Xe.exec(t)) && "px" !== (i[3] || "px") && (e.style[l] = t, t = _e.css(e, l)), R(e, t, s)
            }
        }
    }), _e.cssHooks.marginLeft = z(ye.reliableMarginLeft, function(e, t) {
        if (t) return (parseFloat(O(e, "marginLeft")) || e.getBoundingClientRect().left - ft(e, {
            marginLeft: 0
        }, function() {
            return e.getBoundingClientRect().left
        })) + "px"
    }), _e.each({
        margin: "",
        padding: "",
        border: "Width"
    }, function(r, a) {
        _e.cssHooks[r + a] = {
            expand: function(e) {
                for (var t = 0, n = {}, i = "string" == typeof e ? e.split(" ") : [e]; t < 4; t++) n[r + Ge[t] + a] = i[t] || i[t - 2] || i[0];
                return n
            }
        }, "margin" !== r && (_e.cssHooks[r + a].set = R)
    }), _e.fn.extend({
        css: function(e, t) {
            return Oe(this, function(e, t, n) {
                var i, r, a = {},
                    o = 0;
                if (Array.isArray(t)) {
                    for (i = ht(e), r = t.length; o < r; o++) a[t[o]] = _e.css(e, t[o], !1, i);
                    return a
                }
                return n !== undefined ? _e.style(e, t, n) : _e.css(e, t)
            }, e, t, 1 < arguments.length)
        }
    }), (_e.Tween = W).prototype = {
        constructor: W,
        init: function(e, t, n, i, r, a) {
            this.elem = e, this.prop = n, this.easing = r || _e.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = i, this.unit = a || (_e.cssNumber[n] ? "" : "px")
        },
        cur: function() {
            var e = W.propHooks[this.prop];
            return e && e.get ? e.get(this) : W.propHooks._default.get(this)
        },
        run: function(e) {
            var t, n = W.propHooks[this.prop];
            return this.options.duration ? this.pos = t = _e.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : W.propHooks._default.set(this), this
        }
    }, W.prototype.init.prototype = W.prototype, W.propHooks = {
        _default: {
            get: function(e) {
                var t;
                return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = _e.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0
            },
            set: function(e) {
                _e.fx.step[e.prop] ? _e.fx.step[e.prop](e) : 1 !== e.elem.nodeType || !_e.cssHooks[e.prop] && null == e.elem.style[B(e.prop)] ? e.elem[e.prop] = e.now : _e.style(e.elem, e.prop, e.now + e.unit)
            }
        }
    }, W.propHooks.scrollTop = W.propHooks.scrollLeft = {
        set: function(e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, _e.easing = {
        linear: function(e) {
            return e
        },
        swing: function(e) {
            return .5 - Math.cos(e * Math.PI) / 2
        },
        _default: "swing"
    }, _e.fx = W.prototype.init, _e.fx.step = {};
    var kt, _t, Et, St, Tt = /^(?:toggle|show|hide)$/,
        Mt = /queueHooks$/;
    _e.Animation = _e.extend(Z, {
        tweeners: {
            "*": [function(e, t) {
                var n = this.createTween(e, t);
                return g(n.elem, e, Xe.exec(t), n), n
            }]
        },
        tweener: function(e, t) {
            be(e) ? (t = e, e = ["*"]) : e = e.match(De);
            for (var n, i = 0, r = e.length; i < r; i++) n = e[i], Z.tweeners[n] = Z.tweeners[n] || [], Z.tweeners[n].unshift(t)
        },
        prefilters: [Y],
        prefilter: function(e, t) {
            t ? Z.prefilters.unshift(e) : Z.prefilters.push(e)
        }
    }), _e.speed = function(e, t, n) {
        var i = e && "object" == typeof e ? _e.extend({}, e) : {
            complete: n || !n && t || be(e) && e,
            duration: e,
            easing: n && t || t && !be(t) && t
        };
        return _e.fx.off ? i.duration = 0 : "number" != typeof i.duration && (i.duration in _e.fx.speeds ? i.duration = _e.fx.speeds[i.duration] : i.duration = _e.fx.speeds._default), null != i.queue && !0 !== i.queue || (i.queue = "fx"), i.old = i.complete, i.complete = function() {
            be(i.old) && i.old.call(this), i.queue && _e.dequeue(this, i.queue)
        }, i
    }, _e.fn.extend({
        fadeTo: function(e, t, n, i) {
            return this.filter(Ze).css("opacity", 0).show().end().animate({
                opacity: t
            }, e, n, i)
        },
        animate: function(t, e, n, i) {
            var r = _e.isEmptyObject(t),
                a = _e.speed(e, n, i),
                o = function() {
                    var e = Z(this, _e.extend({}, t), a);
                    (r || Re.get(this, "finish")) && e.stop(!0)
                };
            return o.finish = o, r || !1 === a.queue ? this.each(o) : this.queue(a.queue, o)
        },
        stop: function(r, e, a) {
            var o = function(e) {
                var t = e.stop;
                delete e.stop, t(a)
            };
            return "string" != typeof r && (a = e, e = r, r = undefined), e && this.queue(r || "fx", []), this.each(function() {
                var e = !0,
                    t = null != r && r + "queueHooks",
                    n = _e.timers,
                    i = Re.get(this);
                if (t) i[t] && i[t].stop && o(i[t]);
                else
                    for (t in i) i[t] && i[t].stop && Mt.test(t) && o(i[t]);
                for (t = n.length; t--;) n[t].elem !== this || null != r && n[t].queue !== r || (n[t].anim.stop(a), e = !1, n.splice(t, 1));
                !e && a || _e.dequeue(this, r)
            })
        },
        finish: function(o) {
            return !1 !== o && (o = o || "fx"), this.each(function() {
                var e, t = Re.get(this),
                    n = t[o + "queue"],
                    i = t[o + "queueHooks"],
                    r = _e.timers,
                    a = n ? n.length : 0;
                for (t.finish = !0, _e.queue(this, o, []), i && i.stop && i.stop.call(this, !0), e = r.length; e--;) r[e].elem === this && r[e].queue === o && (r[e].anim.stop(!0), r.splice(e, 1));
                for (e = 0; e < a; e++) n[e] && n[e].finish && n[e].finish.call(this);
                delete t.finish
            })
        }
    }), _e.each(["toggle", "show", "hide"], function(e, i) {
        var r = _e.fn[i];
        _e.fn[i] = function(e, t, n) {
            return null == e || "boolean" == typeof e ? r.apply(this, arguments) : this.animate(G(i, !0), e, t, n)
        }
    }), _e.each({
        slideDown: G("show"),
        slideUp: G("hide"),
        slideToggle: G("toggle"),
        fadeIn: {
            opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        },
        fadeToggle: {
            opacity: "toggle"
        }
    }, function(e, i) {
        _e.fn[e] = function(e, t, n) {
            return this.animate(i, e, t, n)
        }
    }), _e.timers = [], _e.fx.tick = function() {
        var e, t = 0,
            n = _e.timers;
        for (kt = Date.now(); t < n.length; t++)(e = n[t])() || n[t] !== e || n.splice(t--, 1);
        n.length || _e.fx.stop(), kt = undefined
    }, _e.fx.timer = function(e) {
        _e.timers.push(e), _e.fx.start()
    }, _e.fx.interval = 13, _e.fx.start = function() {
        _t || (_t = !0, V())
    }, _e.fx.stop = function() {
        _t = null
    }, _e.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    }, _e.fn.delay = function(i, e) {
        return i = _e.fx && _e.fx.speeds[i] || i, e = e || "fx", this.queue(e, function(e, t) {
            var n = _.setTimeout(e, i);
            t.stop = function() {
                _.clearTimeout(n)
            }
        })
    }, Et = Ce.createElement("input"), St = Ce.createElement("select").appendChild(Ce.createElement("option")), Et.type = "checkbox", ye.checkOn = "" !== Et.value, ye.optSelected = St.selected, (Et = Ce.createElement("input")).value = "t", Et.type = "radio", ye.radioValue = "t" === Et.value;
    var $t, At = _e.expr.attrHandle;
    _e.fn.extend({
        attr: function(e, t) {
            return Oe(this, _e.attr, e, t, 1 < arguments.length)
        },
        removeAttr: function(e) {
            return this.each(function() {
                _e.removeAttr(this, e)
            })
        }
    }), _e.extend({
        attr: function(e, t, n) {
            var i, r, a = e.nodeType;
            if (3 !== a && 8 !== a && 2 !== a) return "undefined" == typeof e.getAttribute ? _e.prop(e, t, n) : (1 === a && _e.isXMLDoc(e) || (r = _e.attrHooks[t.toLowerCase()] || (_e.expr.match.bool.test(t) ? $t : undefined)), n !== undefined ? null === n ? void _e.removeAttr(e, t) : r && "set" in r && (i = r.set(e, n, t)) !== undefined ? i : (e.setAttribute(t, n + ""), n) : r && "get" in r && null !== (i = r.get(e, t)) ? i : null == (i = _e.find.attr(e, t)) ? undefined : i)
        },
        attrHooks: {
            type: {
                set: function(e, t) {
                    if (!ye.radioValue && "radio" === t && u(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        },
        removeAttr: function(e, t) {
            var n, i = 0,
                r = t && t.match(De);
            if (r && 1 === e.nodeType)
                for (; n = r[i++];) e.removeAttribute(n)
        }
    }), $t = {
        set: function(e, t, n) {
            return !1 === t ? _e.removeAttr(e, n) : e.setAttribute(n, n), n
        }
    }, _e.each(_e.expr.match.bool.source.match(/\w+/g), function(e, t) {
        var o = At[t] || _e.find.attr;
        At[t] = function(e, t, n) {
            var i, r, a = t.toLowerCase();
            return n || (r = At[a], At[a] = i, i = null != o(e, t, n) ? a : null, At[a] = r), i
        }
    });
    var It = /^(?:input|select|textarea|button)$/i,
        Pt = /^(?:a|area)$/i;
    _e.fn.extend({
        prop: function(e, t) {
            return Oe(this, _e.prop, e, t, 1 < arguments.length)
        },
        removeProp: function(e) {
            return this.each(function() {
                delete this[_e.propFix[e] || e]
            })
        }
    }), _e.extend({
        prop: function(e, t, n) {
            var i, r, a = e.nodeType;
            if (3 !== a && 8 !== a && 2 !== a) return 1 === a && _e.isXMLDoc(e) || (t = _e.propFix[t] || t, r = _e.propHooks[t]), n !== undefined ? r && "set" in r && (i = r.set(e, n, t)) !== undefined ? i : e[t] = n : r && "get" in r && null !== (i = r.get(e, t)) ? i : e[t]
        },
        propHooks: {
            tabIndex: {
                get: function(e) {
                    var t = _e.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : It.test(e.nodeName) || Pt.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        },
        propFix: {
            "for": "htmlFor",
            "class": "className"
        }
    }), ye.optSelected || (_e.propHooks.selected = {
        get: function(e) {
            var t = e.parentNode;
            return t && t.parentNode && t.parentNode.selectedIndex, null
        },
        set: function(e) {
            var t = e.parentNode;
            t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex)
        }
    }), _e.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
        _e.propFix[this.toLowerCase()] = this
    }), _e.fn.extend({
        addClass: function(t) {
            var e, n, i, r, a, o, s, l = 0;
            if (be(t)) return this.each(function(e) {
                _e(this).addClass(t.call(this, e, J(this)))
            });
            if ((e = ee(t)).length)
                for (; n = this[l++];)
                    if (r = J(n), i = 1 === n.nodeType && " " + K(r) + " ") {
                        for (o = 0; a = e[o++];) i.indexOf(" " + a + " ") < 0 && (i += a + " ");
                        r !== (s = K(i)) && n.setAttribute("class", s)
                    } return this
        },
        removeClass: function(t) {
            var e, n, i, r, a, o, s, l = 0;
            if (be(t)) return this.each(function(e) {
                _e(this).removeClass(t.call(this, e, J(this)))
            });
            if (!arguments.length) return this.attr("class", "");
            if ((e = ee(t)).length)
                for (; n = this[l++];)
                    if (r = J(n), i = 1 === n.nodeType && " " + K(r) + " ") {
                        for (o = 0; a = e[o++];)
                            for (; - 1 < i.indexOf(" " + a + " ");) i = i.replace(" " + a + " ", " ");
                        r !== (s = K(i)) && n.setAttribute("class", s)
                    } return this
        },
        toggleClass: function(r, t) {
            var a = typeof r,
                o = "string" === a || Array.isArray(r);
            return "boolean" == typeof t && o ? t ? this.addClass(r) : this.removeClass(r) : be(r) ? this.each(function(e) {
                _e(this).toggleClass(r.call(this, e, J(this), t), t)
            }) : this.each(function() {
                var e, t, n, i;
                if (o)
                    for (t = 0, n = _e(this), i = ee(r); e = i[t++];) n.hasClass(e) ? n.removeClass(e) : n.addClass(e);
                else r !== undefined && "boolean" !== a || ((e = J(this)) && Re.set(this, "__className__", e), this.setAttribute && this.setAttribute("class", e || !1 === r ? "" : Re.get(this, "__className__") || ""))
            })
        },
        hasClass: function(e) {
            var t, n, i = 0;
            for (t = " " + e + " "; n = this[i++];)
                if (1 === n.nodeType && -1 < (" " + K(J(n)) + " ").indexOf(t)) return !0;
            return !1
        }
    });
    var jt = /\r/g;
    _e.fn.extend({
        val: function(n) {
            var i, e, r, t = this[0];
            return arguments.length ? (r = be(n), this.each(function(e) {
                var t;
                1 === this.nodeType && (null == (t = r ? n.call(this, e, _e(this).val()) : n) ? t = "" : "number" == typeof t ? t += "" : Array.isArray(t) && (t = _e.map(t, function(e) {
                    return null == e ? "" : e + ""
                })), (i = _e.valHooks[this.type] || _e.valHooks[this.nodeName.toLowerCase()]) && "set" in i && i.set(this, t, "value") !== undefined || (this.value = t))
            })) : t ? (i = _e.valHooks[t.type] || _e.valHooks[t.nodeName.toLowerCase()]) && "get" in i && (e = i.get(t, "value")) !== undefined ? e : "string" == typeof(e = t.value) ? e.replace(jt, "") : null == e ? "" : e : void 0
        }
    }), _e.extend({
        valHooks: {
            option: {
                get: function(e) {
                    var t = _e.find.attr(e, "value");
                    return null != t ? t : K(_e.text(e))
                }
            },
            select: {
                get: function(e) {
                    var t, n, i, r = e.options,
                        a = e.selectedIndex,
                        o = "select-one" === e.type,
                        s = o ? null : [],
                        l = o ? a + 1 : r.length;
                    for (i = a < 0 ? l : o ? a : 0; i < l; i++)
                        if (((n = r[i]).selected || i === a) && !n.disabled && (!n.parentNode.disabled || !u(n.parentNode, "optgroup"))) {
                            if (t = _e(n).val(), o) return t;
                            s.push(t)
                        } return s
                },
                set: function(e, t) {
                    for (var n, i, r = e.options, a = _e.makeArray(t), o = r.length; o--;)((i = r[o]).selected = -1 < _e.inArray(_e.valHooks.option.get(i), a)) && (n = !0);
                    return n || (e.selectedIndex = -1), a
                }
            }
        }
    }), _e.each(["radio", "checkbox"], function() {
        _e.valHooks[this] = {
            set: function(e, t) {
                if (Array.isArray(t)) return e.checked = -1 < _e.inArray(_e(e).val(), t)
            }
        }, ye.checkOn || (_e.valHooks[this].get = function(e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    }), ye.focusin = "onfocusin" in _;
    var Dt = /^(?:focusinfocus|focusoutblur)$/,
        Lt = function(e) {
            e.stopPropagation()
        };
    _e.extend(_e.event, {
        trigger: function(e, t, n, i) {
            var r, a, o, s, l, u, c, d, p = [n || Ce],
                h = me.call(e, "type") ? e.type : e,
                f = me.call(e, "namespace") ? e.namespace.split(".") : [];
            if (a = d = o = n = n || Ce, 3 !== n.nodeType && 8 !== n.nodeType && !Dt.test(h + _e.event.triggered) && (-1 < h.indexOf(".") && (h = (f = h.split(".")).shift(), f.sort()), l = h.indexOf(":") < 0 && "on" + h, (e = e[_e.expando] ? e : new _e.Event(h, "object" == typeof e && e)).isTrigger = i ? 2 : 3, e.namespace = f.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = undefined, e.target || (e.target = n), t = null == t ? [e] : _e.makeArray(t, [e]), c = _e.event.special[h] || {}, i || !c.trigger || !1 !== c.trigger.apply(n, t))) {
                if (!i && !c.noBubble && !we(n)) {
                    for (s = c.delegateType || h, Dt.test(s + h) || (a = a.parentNode); a; a = a.parentNode) p.push(a), o = a;
                    o === (n.ownerDocument || Ce) && p.push(o.defaultView || o.parentWindow || _)
                }
                for (r = 0;
                    (a = p[r++]) && !e.isPropagationStopped();) d = a, e.type = 1 < r ? s : c.bindType || h, (u = (Re.get(a, "events") || Object.create(null))[e.type] && Re.get(a, "handle")) && u.apply(a, t), (u = l && a[l]) && u.apply && Be(a) && (e.result = u.apply(a, t), !1 === e.result && e.preventDefault());
                return e.type = h, i || e.isDefaultPrevented() || c._default && !1 !== c._default.apply(p.pop(), t) || !Be(n) || l && be(n[h]) && !we(n) && ((o = n[l]) && (n[l] = null), _e.event.triggered = h, e.isPropagationStopped() && d.addEventListener(h, Lt), n[h](), e.isPropagationStopped() && d.removeEventListener(h, Lt), _e.event.triggered = undefined, o && (n[l] = o)), e.result
            }
        },
        simulate: function(e, t, n) {
            var i = _e.extend(new _e.Event, n, {
                type: e,
                isSimulated: !0
            });
            _e.event.trigger(i, null, t)
        }
    }), _e.fn.extend({
        trigger: function(e, t) {
            return this.each(function() {
                _e.event.trigger(e, t, this)
            })
        },
        triggerHandler: function(e, t) {
            var n = this[0];
            if (n) return _e.event.trigger(e, t, n, !0)
        }
    }), ye.focusin || _e.each({
        focus: "focusin",
        blur: "focusout"
    }, function(n, i) {
        var r = function(e) {
            _e.event.simulate(i, e.target, _e.event.fix(e))
        };
        _e.event.special[i] = {
            setup: function() {
                var e = this.ownerDocument || this.document || this,
                    t = Re.access(e, i);
                t || e.addEventListener(n, r, !0), Re.access(e, i, (t || 0) + 1)
            },
            teardown: function() {
                var e = this.ownerDocument || this.document || this,
                    t = Re.access(e, i) - 1;
                t ? Re.access(e, i, t) : (e.removeEventListener(n, r, !0), Re.remove(e, i))
            }
        }
    });
    var Ft = _.location,
        Ot = {
            guid: Date.now()
        },
        zt = /\?/;
    _e.parseXML = function(e) {
        var t;
        if (!e || "string" != typeof e) return null;
        try {
            t = (new _.DOMParser).parseFromString(e, "text/xml")
        } catch (n) {
            t = undefined
        }
        return t && !t.getElementsByTagName("parsererror").length || _e.error("Invalid XML: " + e), t
    };
    var Nt = /\[\]$/,
        Bt = /\r?\n/g,
        Rt = /^(?:submit|button|image|reset|file)$/i,
        Ht = /^(?:input|select|textarea|keygen)/i;
    _e.param = function(e, t) {
        var n, i = [],
            r = function(e, t) {
                var n = be(t) ? t() : t;
                i[i.length] = encodeURIComponent(e) + "=" + encodeURIComponent(null == n ? "" : n)
            };
        if (null == e) return "";
        if (Array.isArray(e) || e.jquery && !_e.isPlainObject(e)) _e.each(e, function() {
            r(this.name, this.value)
        });
        else
            for (n in e) te(n, e[n], t, r);
        return i.join("&")
    }, _e.fn.extend({
        serialize: function() {
            return _e.param(this.serializeArray())
        },
        serializeArray: function() {
            return this.map(function() {
                var e = _e.prop(this, "elements");
                return e ? _e.makeArray(e) : this
            }).filter(function() {
                var e = this.type;
                return this.name && !_e(this).is(":disabled") && Ht.test(this.nodeName) && !Rt.test(e) && (this.checked || !tt.test(e))
            }).map(function(e, t) {
                var n = _e(this).val();
                return null == n ? null : Array.isArray(n) ? _e.map(n, function(e) {
                    return {
                        name: t.name,
                        value: e.replace(Bt, "\r\n")
                    }
                }) : {
                    name: t.name,
                    value: n.replace(Bt, "\r\n")
                }
            }).get()
        }
    });
    var qt = /%20/g,
        Wt = /#.*$/,
        Vt = /([?&])_=[^&]*/,
        Xt = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        Gt = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
        Ut = /^(?:GET|HEAD)$/,
        Yt = /^\/\//,
        Qt = {},
        Zt = {},
        Kt = "*/".concat("*"),
        Jt = Ce.createElement("a");
    Jt.href = Ft.href, _e.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: Ft.href,
            type: "GET",
            isLocal: Gt.test(Ft.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": Kt,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /\bxml\b/,
                html: /\bhtml/,
                json: /\bjson\b/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": JSON.parse,
                "text xml": _e.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        },
        ajaxSetup: function(e, t) {
            return t ? re(re(e, _e.ajaxSettings), t) : re(_e.ajaxSettings, e)
        },
        ajaxPrefilter: ne(Qt),
        ajaxTransport: ne(Zt),
        ajax: function(e, t) {
            function n(e, t, n, i) {
                var r, a, o, s, l, u = t;
                f || (f = !0, h && _.clearTimeout(h), c = undefined, p = i || "", x.readyState = 0 < e ? 4 : 0, r = 200 <= e && e < 300 || 304 === e, n && (s = ae(v, x, n)), !r && -1 < _e.inArray("script", v.dataTypes) && (v.converters["text script"] = function() {}), s = oe(v, s, x, r), r ? (v.ifModified && ((l = x.getResponseHeader("Last-Modified")) && (_e.lastModified[d] = l), (l = x.getResponseHeader("etag")) && (_e.etag[d] = l)), 204 === e || "HEAD" === v.type ? u = "nocontent" : 304 === e ? u = "notmodified" : (u = s.state, a = s.data, r = !(o = s.error))) : (o = u, !e && u || (u = "error", e < 0 && (e = 0))), x.status = e, x.statusText = (t || u) + "", r ? b.resolveWith(g, [a, u, x]) : b.rejectWith(g, [x, u, o]), x.statusCode(C), C = undefined, m && y.trigger(r ? "ajaxSuccess" : "ajaxError", [x, v, r ? a : o]), w.fireWith(g, [x, u]), m && (y.trigger("ajaxComplete", [x, v]), --_e.active || _e.event.trigger("ajaxStop")))
            }
            "object" == typeof e && (t = e, e = undefined), t = t || {};
            var c, d, p, i, h, r, f, m, a, o, v = _e.ajaxSetup({}, t),
                g = v.context || v,
                y = v.context && (g.nodeType || g.jquery) ? _e(g) : _e.event,
                b = _e.Deferred(),
                w = _e.Callbacks("once memory"),
                C = v.statusCode || {},
                s = {},
                l = {},
                u = "canceled",
                x = {
                    readyState: 0,
                    getResponseHeader: function(e) {
                        var t;
                        if (f) {
                            if (!i)
                                for (i = {}; t = Xt.exec(p);) i[t[1].toLowerCase() + " "] = (i[t[1].toLowerCase() + " "] || []).concat(t[2]);
                            t = i[e.toLowerCase() + " "]
                        }
                        return null == t ? null : t.join(", ")
                    },
                    getAllResponseHeaders: function() {
                        return f ? p : null
                    },
                    setRequestHeader: function(e, t) {
                        return null == f && (e = l[e.toLowerCase()] = l[e.toLowerCase()] || e, s[e] = t), this
                    },
                    overrideMimeType: function(e) {
                        return null == f && (v.mimeType = e), this
                    },
                    statusCode: function(e) {
                        var t;
                        if (e)
                            if (f) x.always(e[x.status]);
                            else
                                for (t in e) C[t] = [C[t], e[t]];
                        return this
                    },
                    abort: function(e) {
                        var t = e || u;
                        return c && c.abort(t), n(0, t), this
                    }
                };
            if (b.promise(x), v.url = ((e || v.url || Ft.href) + "").replace(Yt, Ft.protocol + "//"), v.type = t.method || t.type || v.method || v.type, v.dataTypes = (v.dataType || "*").toLowerCase().match(De) || [""], null == v.crossDomain) {
                r = Ce.createElement("a");
                try {
                    r.href = v.url, r.href = r.href, v.crossDomain = Jt.protocol + "//" + Jt.host != r.protocol + "//" + r.host
                } catch (k) {
                    v.crossDomain = !0
                }
            }
            if (v.data && v.processData && "string" != typeof v.data && (v.data = _e.param(v.data, v.traditional)), ie(Qt, v, t, x), f) return x;
            for (a in (m = _e.event && v.global) && 0 == _e.active++ && _e.event.trigger("ajaxStart"), v.type = v.type.toUpperCase(), v.hasContent = !Ut.test(v.type), d = v.url.replace(Wt, ""), v.hasContent ? v.data && v.processData && 0 === (v.contentType || "").indexOf("application/x-www-form-urlencoded") && (v.data = v.data.replace(qt, "+")) : (o = v.url.slice(d.length), v.data && (v.processData || "string" == typeof v.data) && (d += (zt.test(d) ? "&" : "?") + v.data, delete v.data), !1 === v.cache && (d = d.replace(Vt, "$1"), o = (zt.test(d) ? "&" : "?") + "_=" + Ot.guid++ + o), v.url = d + o), v.ifModified && (_e.lastModified[d] && x.setRequestHeader("If-Modified-Since", _e.lastModified[d]), _e.etag[d] && x.setRequestHeader("If-None-Match", _e.etag[d])), (v.data && v.hasContent && !1 !== v.contentType || t.contentType) && x.setRequestHeader("Content-Type", v.contentType), x.setRequestHeader("Accept", v.dataTypes[0] && v.accepts[v.dataTypes[0]] ? v.accepts[v.dataTypes[0]] + ("*" !== v.dataTypes[0] ? ", " + Kt + "; q=0.01" : "") : v.accepts["*"]), v.headers) x.setRequestHeader(a, v.headers[a]);
            if (v.beforeSend && (!1 === v.beforeSend.call(g, x, v) || f)) return x.abort();
            if (u = "abort", w.add(v.complete), x.done(v.success), x.fail(v.error), c = ie(Zt, v, t, x)) {
                if (x.readyState = 1, m && y.trigger("ajaxSend", [x, v]), f) return x;
                v.async && 0 < v.timeout && (h = _.setTimeout(function() {
                    x.abort("timeout")
                }, v.timeout));
                try {
                    f = !1, c.send(s, n)
                } catch (k) {
                    if (f) throw k;
                    n(-1, k)
                }
            } else n(-1, "No Transport");
            return x
        },
        getJSON: function(e, t, n) {
            return _e.get(e, t, n, "json")
        },
        getScript: function(e, t) {
            return _e.get(e, undefined, t, "script")
        }
    }), _e.each(["get", "post"], function(e, r) {
        _e[r] = function(e, t, n, i) {
            return be(t) && (i = i || n, n = t, t = undefined), _e.ajax(_e.extend({
                url: e,
                type: r,
                dataType: i,
                data: t,
                success: n
            }, _e.isPlainObject(e) && e))
        }
    }), _e.ajaxPrefilter(function(e) {
        var t;
        for (t in e.headers) "content-type" === t.toLowerCase() && (e.contentType = e.headers[t] || "")
    }), _e._evalUrl = function(e, t, n) {
        return _e.ajax({
            url: e,
            type: "GET",
            dataType: "script",
            cache: !0,
            async: !1,
            global: !1,
            converters: {
                "text script": function() {}
            },
            dataFilter: function(e) {
                _e.globalEval(e, t, n)
            }
        })
    }, _e.fn.extend({
        wrapAll: function(e) {
            var t;
            return this[0] && (be(e) && (e = e.call(this[0])), t = _e(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map(function() {
                for (var e = this; e.firstElementChild;) e = e.firstElementChild;
                return e
            }).append(this)), this
        },
        wrapInner: function(n) {
            return be(n) ? this.each(function(e) {
                _e(this).wrapInner(n.call(this, e))
            }) : this.each(function() {
                var e = _e(this),
                    t = e.contents();
                t.length ? t.wrapAll(n) : e.append(n)
            })
        },
        wrap: function(t) {
            var n = be(t);
            return this.each(function(e) {
                _e(this).wrapAll(n ? t.call(this, e) : t)
            })
        },
        unwrap: function(e) {
            return this.parent(e).not("body").each(function() {
                _e(this).replaceWith(this.childNodes)
            }), this
        }
    }), _e.expr.pseudos.hidden = function(e) {
        return !_e.expr.pseudos.visible(e)
    }, _e.expr.pseudos.visible = function(e) {
        return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length)
    }, _e.ajaxSettings.xhr = function() {
        try {
            return new _.XMLHttpRequest
        } catch (e) {}
    };
    var en = {
            0: 200,
            1223: 204
        },
        tn = _e.ajaxSettings.xhr();
    ye.cors = !!tn && "withCredentials" in tn, ye.ajax = tn = !!tn, _e.ajaxTransport(function(a) {
        var o, s;
        if (ye.cors || tn && !a.crossDomain) return {
            send: function(e, t) {
                var n, i = a.xhr();
                if (i.open(a.type, a.url, a.async, a.username, a.password), a.xhrFields)
                    for (n in a.xhrFields) i[n] = a.xhrFields[n];
                for (n in a.mimeType && i.overrideMimeType && i.overrideMimeType(a.mimeType), a.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest"), e) i.setRequestHeader(n, e[n]);
                o = function(e) {
                    return function() {
                        o && (o = s = i.onload = i.onerror = i.onabort = i.ontimeout = i.onreadystatechange = null, "abort" === e ? i.abort() : "error" === e ? "number" != typeof i.status ? t(0, "error") : t(i.status, i.statusText) : t(en[i.status] || i.status, i.statusText, "text" !== (i.responseType || "text") || "string" != typeof i.responseText ? {
                            binary: i.response
                        } : {
                            text: i.responseText
                        }, i.getAllResponseHeaders()))
                    }
                }, i.onload = o(), s = i.onerror = i.ontimeout = o("error"), i.onabort !== undefined ? i.onabort = s : i.onreadystatechange = function() {
                    4 === i.readyState && _.setTimeout(function() {
                        o && s()
                    })
                }, o = o("abort");
                // try {
                //     i.send(a.hasContent && a.data || null)
                // } catch (r) {
                //     if (o) throw r
                // }
            },
            abort: function() {
                o && o()
            }
        }
    }), _e.ajaxPrefilter(function(e) {
        e.crossDomain && (e.contents.script = !1)
    }), _e.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        contents: {
            script: /\b(?:java|ecma)script\b/
        },
        converters: {
            "text script": function(e) {
                return _e.globalEval(e), e
            }
        }
    }), _e.ajaxPrefilter("script", function(e) {
        e.cache === undefined && (e.cache = !1), e.crossDomain && (e.type = "GET")
    }), _e.ajaxTransport("script", function(n) {
        var i, r;
        if (n.crossDomain || n.scriptAttrs) return {
            send: function(e, t) {
                i = _e("<script>").attr(n.scriptAttrs || {}).prop({
                    charset: n.scriptCharset,
                    src: n.url
                }).on("load error", r = function(e) {
                    i.remove(), r = null, e && t("error" === e.type ? 404 : 200, e.type)
                }), Ce.head.appendChild(i[0])
            },
            abort: function() {
                r && r()
            }
        }
    });
    var nn, rn = [],
        an = /(=)\?(?=&|$)|\?\?/;
    _e.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function() {
            var e = rn.pop() || _e.expando + "_" + Ot.guid++;
            return this[e] = !0, e
        }
    }), _e.ajaxPrefilter("json jsonp", function(e, t, n) {
        var i, r, a, o = !1 !== e.jsonp && (an.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && an.test(e.data) && "data");
        if (o || "jsonp" === e.dataTypes[0]) return i = e.jsonpCallback = be(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, o ? e[o] = e[o].replace(an, "$1" + i) : !1 !== e.jsonp && (e.url += (zt.test(e.url) ? "&" : "?") + e.jsonp + "=" + i), e.converters["script json"] = function() {
            return a || _e.error(i + " was not called"), a[0]
        }, e.dataTypes[0] = "json", r = _[i], _[i] = function() {
            a = arguments
        }, n.always(function() {
            r === undefined ? _e(_).removeProp(i) : _[i] = r, e[i] && (e.jsonpCallback = t.jsonpCallback, rn.push(i)), a && be(r) && r(a[0]), a = r = undefined
        }), "script"
    }), ye.createHTMLDocument = ((nn = Ce.implementation.createHTMLDocument("").body).innerHTML = "<form></form><form></form>", 2 === nn.childNodes.length), _e.parseHTML = function(e, t, n) {
        return "string" != typeof e ? [] : ("boolean" == typeof t && (n = t, t = !1), t || (ye.createHTMLDocument ? ((i = (t = Ce.implementation.createHTMLDocument("")).createElement("base")).href = Ce.location.href, t.head.appendChild(i)) : t = Ce), a = !n && [], (r = $e.exec(e)) ? [t.createElement(r[1])] : (r = x([e], t, a), a && a.length && _e(a).remove(), _e.merge([], r.childNodes)));
        var i, r, a
    }, _e.fn.load = function(e, t, n) {
        var i, r, a, o = this,
            s = e.indexOf(" ");
        return -1 < s && (i = K(e.slice(s)), e = e.slice(0, s)), be(t) ? (n = t, t = undefined) : t && "object" == typeof t && (r = "POST"), 0 < o.length && _e.ajax({
            url: e,
            type: r || "GET",
            dataType: "html",
            data: t
        }).done(function(e) {
            a = arguments, o.html(i ? _e("<div>").append(_e.parseHTML(e)).find(i) : e)
        }).always(n && function(e, t) {
            o.each(function() {
                n.apply(this, a || [e.responseText, t, e])
            })
        }), this
    }, _e.expr.pseudos.animated = function(t) {
        return _e.grep(_e.timers, function(e) {
            return t === e.elem
        }).length
    }, _e.offset = {
        setOffset: function(e, t, n) {
            var i, r, a, o, s, l, u = _e.css(e, "position"),
                c = _e(e),
                d = {};
            "static" === u && (e.style.position = "relative"), s = c.offset(), a = _e.css(e, "top"), l = _e.css(e, "left"), ("absolute" === u || "fixed" === u) && -1 < (a + l).indexOf("auto") ? (o = (i = c.position()).top, r = i.left) : (o = parseFloat(a) || 0, r = parseFloat(l) || 0), be(t) && (t = t.call(e, n, _e.extend({}, s))), null != t.top && (d.top = t.top - s.top + o), null != t.left && (d.left = t.left - s.left + r), "using" in t ? t.using.call(e, d) : ("number" == typeof d.top && (d.top += "px"), "number" == typeof d.left && (d.left += "px"), c.css(d))
        }
    }, _e.fn.extend({
        offset: function(t) {
            if (arguments.length) return t === undefined ? this : this.each(function(e) {
                _e.offset.setOffset(this, t, e)
            });
            var e, n, i = this[0];
            return i ? i.getClientRects().length ? (e = i.getBoundingClientRect(), n = i.ownerDocument.defaultView, {
                top: e.top + n.pageYOffset,
                left: e.left + n.pageXOffset
            }) : {
                top: 0,
                left: 0
            } : void 0
        },
        position: function() {
            if (this[0]) {
                var e, t, n, i = this[0],
                    r = {
                        top: 0,
                        left: 0
                    };
                if ("fixed" === _e.css(i, "position")) t = i.getBoundingClientRect();
                else {
                    for (t = this.offset(), n = i.ownerDocument, e = i.offsetParent || n.documentElement; e && (e === n.body || e === n.documentElement) && "static" === _e.css(e, "position");) e = e.parentNode;
                    e && e !== i && 1 === e.nodeType && ((r = _e(e).offset()).top += _e.css(e, "borderTopWidth", !0), r.left += _e.css(e, "borderLeftWidth", !0))
                }
                return {
                    top: t.top - r.top - _e.css(i, "marginTop", !0),
                    left: t.left - r.left - _e.css(i, "marginLeft", !0)
                }
            }
        },
        offsetParent: function() {
            return this.map(function() {
                for (var e = this.offsetParent; e && "static" === _e.css(e, "position");) e = e.offsetParent;
                return e || Ue
            })
        }
    }), _e.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, function(t, r) {
        var a = "pageYOffset" === r;
        _e.fn[t] = function(e) {
            return Oe(this, function(e, t, n) {
                var i;
                if (we(e) ? i = e : 9 === e.nodeType && (i = e.defaultView), n === undefined) return i ? i[r] : e[t];
                i ? i.scrollTo(a ? i.pageXOffset : n, a ? n : i.pageYOffset) : e[t] = n
            }, t, e, arguments.length)
        }
    }), _e.each(["top", "left"], function(e, n) {
        _e.cssHooks[n] = z(ye.pixelPosition, function(e, t) {
            if (t) return t = O(e, n), pt.test(t) ? _e(e).position()[n] + "px" : t
        })
    }), _e.each({
        Height: "height",
        Width: "width"
    }, function(o, s) {
        _e.each({
            padding: "inner" + o,
            content: s,
            "": "outer" + o
        }, function(i, a) {
            _e.fn[a] = function(e, t) {
                var n = arguments.length && (i || "boolean" != typeof e),
                    r = i || (!0 === e || !0 === t ? "margin" : "border");
                return Oe(this, function(e, t, n) {
                    var i;
                    return we(e) ? 0 === a.indexOf("outer") ? e["inner" + o] : e.document.documentElement["client" + o] : 9 === e.nodeType ? (i = e.documentElement, Math.max(e.body["scroll" + o], i["scroll" + o], e.body["offset" + o], i["offset" + o], i["client" + o])) : n === undefined ? _e.css(e, t, r) : _e.style(e, t, n, r)
                }, s, n ? e : undefined, n)
            }
        })
    }), _e.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(e, t) {
        _e.fn[t] = function(e) {
            return this.on(t, e)
        }
    }), _e.fn.extend({
        bind: function(e, t, n) {
            return this.on(e, null, t, n)
        },
        unbind: function(e, t) {
            return this.off(e, null, t)
        },
        delegate: function(e, t, n, i) {
            return this.on(t, e, n, i)
        },
        undelegate: function(e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        },
        hover: function(e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        }
    }), _e.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function(e, n) {
        _e.fn[n] = function(e, t) {
            return 0 < arguments.length ? this.on(n, null, e, t) : this.trigger(n)
        }
    });
    var on = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    _e.proxy = function(e, t) {
        var n, i, r;
        return "string" == typeof t && (n = e[t], t = e, e = n), be(e) ? (i = ue.call(arguments, 2), (r = function() {
            return e.apply(t || this, i.concat(ue.call(arguments)))
        }).guid = e.guid = e.guid || _e.guid++, r) : undefined
    }, _e.holdReady = function(e) {
        e ? _e.readyWait++ : _e.ready(!0)
    }, _e.isArray = Array.isArray, _e.parseJSON = JSON.parse, _e.nodeName = u, _e.isFunction = be, _e.isWindow = we, _e.camelCase = h, _e.type = v, _e.now = Date.now, _e.isNumeric = function(e) {
        var t = _e.type(e);
        return ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
    }, _e.trim = function(e) {
        return null == e ? "" : (e + "").replace(on, "")
    }, "function" == typeof define && define.amd && define("jquery", [], function() {
        return _e
    });
    var sn = _.jQuery,
        ln = _.$;
    return _e.noConflict = function(e) {
        return _.$ === _e && (_.$ = ln), e && _.jQuery === _e && (_.jQuery = sn), _e
    }, void 0 === e && (_.jQuery = _.$ = _e), _e
}),
function() {
    var e = this;
    (function() {
        (function() {
            this.Rails = {
                linkClickSelector: "a[data-confirm], a[data-method], a[data-remote]:not([disabled]), a[data-disable-with], a[data-disable]",
                buttonClickSelector: {
                    selector: "button[data-remote]:not([form]), button[data-confirm]:not([form])",
                    exclude: "form button"
                },
                inputChangeSelector: "select[data-remote], input[data-remote], textarea[data-remote]",
                formSubmitSelector: "form",
                formInputClickSelector: "form input[type=submit], form input[type=image], form button[type=submit], form button:not([type]), input[type=submit][form], input[type=image][form], button[type=submit][form], button[form]:not([type])",
                formDisableSelector: "input[data-disable-with]:enabled, button[data-disable-with]:enabled, textarea[data-disable-with]:enabled, input[data-disable]:enabled, button[data-disable]:enabled, textarea[data-disable]:enabled",
                formEnableSelector: "input[data-disable-with]:disabled, button[data-disable-with]:disabled, textarea[data-disable-with]:disabled, input[data-disable]:disabled, button[data-disable]:disabled, textarea[data-disable]:disabled",
                fileInputSelector: "input[name][type=file]:not([disabled])",
                linkDisableSelector: "a[data-disable-with], a[data-disable]",
                buttonDisableSelector: "button[data-remote][data-disable-with], button[data-remote][data-disable]"
            }
        }).call(this)
    }).call(e);
    var y = e.Rails;
    (function() {
        (function() {
            var t;
            t = null, y.loadCSPNonce = function() {
                var e;
                return t = null != (e = document.querySelector("meta[name=csp-nonce]")) ? e.content : void 0
            }, y.cspNonce = function() {
                return null != t ? t : y.loadCSPNonce()
            }
        }).call(this),
            function() {
                var i, n;
                n = Element.prototype.matches || Element.prototype.matchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector || Element.prototype.oMatchesSelector || Element.prototype.webkitMatchesSelector, y.matches = function(e, t) {
                    return null != t.exclude ? n.call(e, t.selector) && !n.call(e, t.exclude) : n.call(e, t)
                }, i = "_ujsData", y.getData = function(e, t) {
                    var n;
                    return null != (n = e[i]) ? n[t] : void 0
                }, y.setData = function(e, t, n) {
                    return null == e[i] && (e[i] = {}), e[i][t] = n
                }, y.$ = function(e) {
                    return Array.prototype.slice.call(document.querySelectorAll(e))
                }
            }.call(this),
            function() {
                var n, i, r;
                n = y.$, r = y.csrfToken = function() {
                    var e;
                    return (e = document.querySelector("meta[name=csrf-token]")) && e.content
                }, i = y.csrfParam = function() {
                    var e;
                    return (e = document.querySelector("meta[name=csrf-param]")) && e.content
                }, y.CSRFProtection = function(e) {
                    var t;
                    if (null != (t = r())) return e.setRequestHeader("X-CSRF-Token", t)
                }, y.refreshCSRFTokens = function() {
                    var e, t;
                    if (t = r(), e = i(), null != t && null != e) return n('form input[name="' + e + '"]').forEach(function(e) {
                        return e.value = t
                    })
                }
            }.call(this),
            function() {
                var r, t, a, n;
                a = y.matches, "function" != typeof(r = window.CustomEvent) && ((r = function(e, t) {
                    var n;
                    return (n = document.createEvent("CustomEvent")).initCustomEvent(e, t.bubbles, t.cancelable, t.detail), n
                }).prototype = window.Event.prototype, n = r.prototype.preventDefault, r.prototype.preventDefault = function() {
                    var e;
                    return e = n.call(this), this.cancelable && !this.defaultPrevented && Object.defineProperty(this, "defaultPrevented", {
                        get: function() {
                            return !0
                        }
                    }), e
                }), t = y.fire = function(e, t, n) {
                    var i;
                    return i = new r(t, {
                        bubbles: !0,
                        cancelable: !0,
                        detail: n
                    }), e.dispatchEvent(i), !i.defaultPrevented
                }, y.stopEverything = function(e) {
                    return t(e.target, "ujs:everythingStopped"), e.preventDefault(), e.stopPropagation(), e.stopImmediatePropagation()
                }, y.delegate = function(e, n, t, i) {
                    return e.addEventListener(t, function(e) {
                        var t;
                        for (t = e.target; t instanceof Element && !a(t, n);) t = t.parentNode;
                        if (t instanceof Element && !1 === i.call(t, e)) return e.preventDefault(), e.stopPropagation()
                    })
                }
            }.call(this),
            // function() {
            //     var t, i, e, a, r, o;
            //     a = y.cspNonce, i = y.CSRFProtection, y.fire, t = {
            //         "*": "*/*",
            //         text: "text/plain",
            //         html: "text/html",
            //         xml: "application/xml, text/xml",
            //         json: "application/json, text/javascript",
            //         script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
            //     }, y.ajax = function(n) {
            //         var i;
            //         return n = r(n), i = e(n, function() {
            //             var e, t;
            //             return t = o(null != (e = i.response) ? e : i.responseText, i.getResponseHeader("Content-Type")), 2 === Math.floor(i.status / 100) ? "function" == typeof n.success && n.success(t, i.statusText, i) : "function" == typeof n.error && n.error(t, i.statusText, i), "function" == typeof n.complete ? n.complete(i, i.statusText) : void 0
            //         }), !(null != n.beforeSend && !n.beforeSend(i, n)) && (i.readyState === XMLHttpRequest.OPENED ? i.send(n.data) : void 0)
            //     }, r = function(e) {
            //         return e.url = e.url || location.href, e.type = e.type.toUpperCase(), "GET" === e.type && e.data && (e.url.indexOf("?") < 0 ? e.url += "?" + e.data : e.url += "&" + e.data), null == t[e.dataType] && (e.dataType = "*"), e.accept = t[e.dataType], "*" !== e.dataType && (e.accept += ", */*; q=0.01"), e
            //     }, e = function(e, t) {
            //         var n;
            //         return (n = new XMLHttpRequest).open(e.type, e.url, !0), n.setRequestHeader("Accept", e.accept), "string" == typeof e.data && n.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8"), e.crossDomain || (n.setRequestHeader("X-Requested-With", "XMLHttpRequest"), i(n)), n.withCredentials = !!e.withCredentials, n.onreadystatechange = function() {
            //             if (n.readyState === XMLHttpRequest.DONE) return t(n)
            //         }, n
            //     }, o = function(e, t) {
            //         var n, i;
            //         if ("string" == typeof e && "string" == typeof t)
            //             if (t.match(/\bjson\b/)) try {
            //                     e = JSON.parse(e)
            //                 } catch (r) {} else if (t.match(/\b(?:java|ecma)script\b/))(i = document.createElement("script")).setAttribute("nonce", a()), i.text = e, document.head.appendChild(i).parentNode.removeChild(i);
            //                 else if (t.match(/\b(xml|html|svg)\b/)) {
            //             n = new DOMParser, t = t.replace(/;.+/, "");
            //             try {
            //                 e = n.parseFromString(e, t)
            //             } catch (r) {}
            //         }
            //         return e
            //     }, y.href = function(e) {
            //         return e.href
            //     }, y.isCrossDomain = function(e) {
            //         var t, n;
            //         (t = document.createElement("a")).href = location.href, n = document.createElement("a");
            //         try {
            //             return n.href = e, !((!n.protocol || ":" === n.protocol) && !n.host || t.protocol + "//" + t.host == n.protocol + "//" + n.host)
            //         } catch (i) {
            //             return i, !0
            //         }
            //     }
            // }.call(this),
            function() {
                var r, a;
                r = y.matches, a = function(e) {
                    return Array.prototype.slice.call(e)
                }, y.serializeElement = function(e, t) {
                    var n, i;
                    return n = [e], r(e, "form") && (n = a(e.elements)), i = [], n.forEach(function(t) {
                        if (t.name && !t.disabled) return r(t, "select") ? a(t.options).forEach(function(e) {
                            if (e.selected) return i.push({
                                name: t.name,
                                value: e.value
                            })
                        }) : t.checked || -1 === ["radio", "checkbox", "submit"].indexOf(t.type) ? i.push({
                            name: t.name,
                            value: t.value
                        }) : void 0
                    }), t && i.push(t), i.map(function(e) {
                        return null != e.name ? encodeURIComponent(e.name) + "=" + encodeURIComponent(e.value) : e
                    }).join("&")
                }, y.formElements = function(e, t) {
                    return r(e, "form") ? a(e.elements).filter(function(e) {
                        return r(e, t)
                    }) : a(e.querySelectorAll(t))
                }
            }.call(this),
            function() {
                var t, a, n;
                a = y.fire,
                    n = y.stopEverything, y.handleConfirm = function(e) {
                        if (!t(this)) return n(e)
                    }, t = function(e) {
                        var t, n, i;
                        if (!(i = e.getAttribute("data-confirm"))) return !0;
                        if (t = !1, a(e, "confirm")) {
                            try {
                                t = confirm(i)
                            } catch (r) {}
                            n = a(e, "confirm:complete", [t])
                        }
                        return t && n
                    }
            }.call(this),
            function() {
                var n, i, r, a, o, s, t, l, u, c, d;
                u = y.matches, l = y.getData, c = y.setData, d = y.stopEverything, t = y.formElements, y.handleDisabledElement = function(e) {
                    if (this.disabled) return d(e)
                }, y.enableElement = function(e) {
                    var t;
                    return t = e instanceof Event ? e.target : e, u(t, y.linkDisableSelector) ? s(t) : u(t, y.buttonDisableSelector) || u(t, y.formEnableSelector) ? a(t) : u(t, y.formSubmitSelector) ? o(t) : void 0
                }, y.disableElement = function(e) {
                    var t;
                    return t = e instanceof Event ? e.target : e, u(t, y.linkDisableSelector) ? r(t) : u(t, y.buttonDisableSelector) || u(t, y.formDisableSelector) ? n(t) : u(t, y.formSubmitSelector) ? i(t) : void 0
                }, r = function(e) {
                    var t;
                    return null != (t = e.getAttribute("data-disable-with")) && (c(e, "ujs:enable-with", e.innerHTML), e.innerHTML = t), e.addEventListener("click", d), c(e, "ujs:disabled", !0)
                }, s = function(e) {
                    var t;
                    return null != (t = l(e, "ujs:enable-with")) && (e.innerHTML = t, c(e, "ujs:enable-with", null)), e.removeEventListener("click", d), c(e, "ujs:disabled", null)
                }, i = function(e) {
                    return t(e, y.formDisableSelector).forEach(n)
                }, n = function(e) {
                    var t;
                    return null != (t = e.getAttribute("data-disable-with")) && (u(e, "button") ? (c(e, "ujs:enable-with", e.innerHTML), e.innerHTML = t) : (c(e, "ujs:enable-with", e.value), e.value = t)), e.disabled = !0, c(e, "ujs:disabled", !0)
                }, o = function(e) {
                    return t(e, y.formEnableSelector).forEach(a)
                }, a = function(e) {
                    var t;
                    return null != (t = l(e, "ujs:enable-with")) && (u(e, "button") ? e.innerHTML = t : e.value = t, c(e, "ujs:enable-with", null)), e.disabled = !1, c(e, "ujs:disabled", null)
                }
            }.call(this),
            function() {
                var l;
                l = y.stopEverything, y.handleMethod = function(e) {
                    var t, n, i, r, a, o, s;
                    if (s = (o = this).getAttribute("data-method")) return a = y.href(o), n = y.csrfToken(), t = y.csrfParam(), i = document.createElement("form"), r = "<input name='_method' value='" + s + "' type='hidden' />", null == t || null == n || y.isCrossDomain(a) || (r += "<input name='" + t + "' value='" + n + "' type='hidden' />"), r += '<input type="submit" />', i.method = "post", i.action = a, i.target = o.target, i.innerHTML = r, i.style.display = "none", document.body.appendChild(i), i.querySelector('[type="submit"]').click(), l(e)
                }
            }.call(this),
            // function() {
            //     var l, u, c, d, p, h, f, m, v, g = [].slice;
            //     h = y.matches, c = y.getData, m = y.setData, u = y.fire, v = y.stopEverything, l = y.ajax, d = y.isCrossDomain, f = y.serializeElement, p = function(e) {
            //         var t;
            //         return null != (t = e.getAttribute("data-remote")) && "false" !== t
            //     }, y.handleRemote = function(e) {
            //         var t, n, i, r, a, o, s;
            //         return !p(r = this) || (u(r, "ajax:before") ? (s = r.getAttribute("data-with-credentials"), i = r.getAttribute("data-type") || "script", h(r, y.formSubmitSelector) ? (t = c(r, "ujs:submit-button"), a = c(r, "ujs:submit-button-formmethod") || r.method, o = c(r, "ujs:submit-button-formaction") || r.getAttribute("action") || location.href, "GET" === a.toUpperCase() && (o = o.replace(/\?.*$/, "")), "multipart/form-data" === r.enctype ? (n = new FormData(r), null != t && n.append(t.name, t.value)) : n = f(r, t), m(r, "ujs:submit-button", null), m(r, "ujs:submit-button-formmethod", null), m(r, "ujs:submit-button-formaction", null)) : h(r, y.buttonClickSelector) || h(r, y.inputChangeSelector) ? (a = r.getAttribute("data-method"), o = r.getAttribute("data-url"), n = f(r, r.getAttribute("data-params"))) : (a = r.getAttribute("data-method"), o = y.href(r), n = r.getAttribute("data-params")), l({
            //             type: a || "GET",
            //             url: o,
            //             data: n,
            //             dataType: i,
            //             beforeSend: function(e, t) {
            //                 return u(r, "ajax:beforeSend", [e, t]) ? u(r, "ajax:send", [e]) : (u(r, "ajax:stopped"), !1)
            //             },
            //             success: function() {
            //                 var e;
            //                 return e = 1 <= arguments.length ? g.call(arguments, 0) : [], u(r, "ajax:success", e)
            //             },
            //             error: function() {
            //                 var e;
            //                 return e = 1 <= arguments.length ? g.call(arguments, 0) : [], u(r, "ajax:error", e)
            //             },
            //             complete: function() {
            //                 var e;
            //                 return e = 1 <= arguments.length ? g.call(arguments, 0) : [], u(r, "ajax:complete", e)
            //             },
            //             // crossDomain: d(o),
            //             withCredentials: null != s && "false" !== s
            //         }), v(e)) : (u(r, "ajax:stopped"), !1))
            //     }, y.formSubmitButtonClick = function() {
            //         var e, t;
            //         if (t = (e = this).form) return e.name && m(t, "ujs:submit-button", {
            //             name: e.name,
            //             value: e.value
            //         }), m(t, "ujs:formnovalidate-button", e.formNoValidate), m(t, "ujs:submit-button-formaction", e.getAttribute("formaction")), m(t, "ujs:submit-button-formmethod", e.getAttribute("formmethod"))
            //     }, y.preventInsignificantClick = function(e) {
            //         var t, n, i, r;
            //         if (r = ((i = this).getAttribute("data-method") || "GET").toUpperCase(), t = i.getAttribute("data-params"), n = (e.metaKey || e.ctrlKey) && "GET" === r && !t, null != e.button && 0 !== e.button || n) return e.stopImmediatePropagation()
            //     }
            // }.call(this),
            function() {
                var e, i, t, n, r, a, o, s, l, u, c, d, p, h, f;
                if (a = y.fire, t = y.delegate, s = y.getData, e = y.$, f = y.refreshCSRFTokens, i = y.CSRFProtection, p = y.loadCSPNonce, r = y.enableElement, n = y.disableElement, u = y.handleDisabledElement, l = y.handleConfirm, h = y.preventInsignificantClick, d = y.handleRemote, o = y.formSubmitButtonClick, c = y.handleMethod, "undefined" != typeof jQuery && null !== jQuery && null != jQuery.ajax) {
                    if (jQuery.rails) throw new Error("If you load both jquery_ujs and rails-ujs, use rails-ujs only.");
                    jQuery.rails = y, jQuery.ajaxPrefilter(function(e, t, n) {
                        if (!e.crossDomain) return i(n)
                    })
                }
                y.start = function() {
                    if (window._rails_loaded) throw new Error("rails-ujs has already been loaded!");
                    return window.addEventListener("pageshow", function() {
                        return e(y.formEnableSelector).forEach(function(e) {
                            if (s(e, "ujs:disabled")) return r(e)
                        }), e(y.linkDisableSelector).forEach(function(e) {
                            if (s(e, "ujs:disabled")) return r(e)
                        })
                    }), t(document, y.linkDisableSelector, "ajax:complete", r), t(document, y.linkDisableSelector, "ajax:stopped", r), t(document, y.buttonDisableSelector, "ajax:complete", r), t(document, y.buttonDisableSelector, "ajax:stopped", r), t(document, y.linkClickSelector, "click", h), t(document, y.linkClickSelector, "click", u), t(document, y.linkClickSelector, "click", l), t(document, y.linkClickSelector, "click", n), t(document, y.linkClickSelector, "click", d), t(document, y.linkClickSelector, "click", c), t(document, y.buttonClickSelector, "click", h), t(document, y.buttonClickSelector, "click", u), t(document, y.buttonClickSelector, "click", l), t(document, y.buttonClickSelector, "click", n), t(document, y.buttonClickSelector, "click", d), t(document, y.inputChangeSelector, "change", u), t(document, y.inputChangeSelector, "change", l), t(document, y.inputChangeSelector, "change", d), t(document, y.formSubmitSelector, "submit", u), t(document, y.formSubmitSelector, "submit", l), t(document, y.formSubmitSelector, "submit", d), t(document, y.formSubmitSelector, "submit", function(e) {
                        return setTimeout(function() {
                            return n(e)
                        }, 13)
                    }), t(document, y.formSubmitSelector, "ajax:send", n), t(document, y.formSubmitSelector, "ajax:complete", r), t(document, y.formInputClickSelector, "click", h), t(document, y.formInputClickSelector, "click", u), t(document, y.formInputClickSelector, "click", l), t(document, y.formInputClickSelector, "click", o), document.addEventListener("DOMContentLoaded", f), document.addEventListener("DOMContentLoaded", p), window._rails_loaded = !0
                }, window.Rails === y && a(document, "rails:attachBindings") && y.start()
            }.call(this)
    }).call(this), "object" == typeof module && module.exports ? module.exports = y : "function" == typeof define && define.amd && define(y)
}.call(this),
function(n) {
    "function" == typeof define && define.amd ? define(["jquery"], n) : "object" == typeof module && module.exports ? module.exports = function(e, t) {
        return t === undefined && (t = "undefined" != typeof window ? require("jquery") : require("jquery")(e)), n(t), t
    } : n(jQuery)
}(function(d) {
    "use strict";
    var t = d(document),
        l = d(window),
        u = "selectric",
        e = "Input Items Open Disabled TempShow HideSelect Wrapper Focus Hover Responsive Above Below Scroll Group GroupLabel",
        n = ".sl",
        i = ["a", "e", "i", "o", "u", "n", "c", "y"],
        r = [/[\xE0-\xE5]/g, /[\xE8-\xEB]/g, /[\xEC-\xEF]/g, /[\xF2-\xF6]/g, /[\xF9-\xFC]/g, /[\xF1]/g, /[\xE7]/g, /[\xFD-\xFF]/g],
        a = function(e, t) {
            var n = this;
            n.element = e, n.$element = d(e), n.state = {
                multiple: !!n.$element.attr("multiple"),
                enabled: !1,
                opened: !1,
                currValue: -1,
                selectedIdx: -1,
                highlightedIdx: -1
            }, n.eventTriggers = {
                open: n.open,
                close: n.close,
                destroy: n.destroy,
                refresh: n.refresh,
                init: n.init
            }, n.init(t)
        };
    a.prototype = {
        utils: {
            isMobile: function() {
                return /android|ip(hone|od|ad)/i.test(navigator.userAgent)
            },
            escapeRegExp: function(e) {
                return e.replace(/[.*+?^${}()|[\]\\]/g, "\\$&")
            },
            replaceDiacritics: function(e) {
                for (var t = r.length; t--;) e = e.toLowerCase().replace(r[t], i[t]);
                return e
            },
            format: function(e) {
                var i = arguments;
                return ("" + e).replace(/\{(?:(\d+)|(\w+))\}/g, function(e, t, n) {
                    return n && i[1] ? i[1][n] : i[t]
                })
            },
            nextEnabledItem: function(e, t) {
                for (; e[t = (t + 1) % e.length].disabled;);
                return t
            },
            previousEnabledItem: function(e, t) {
                for (; e[t = (0 < t ? t : e.length) - 1].disabled;);
                return t
            },
            toDash: function(e) {
                return e.replace(/([a-z0-9])([A-Z])/g, "$1-$2").toLowerCase()
            },
            triggerCallback: function(e, t) {
                var n = t.element,
                    i = t.options["on" + e],
                    r = [n].concat([].slice.call(arguments).slice(1));
                "function" == typeof i && i.apply(n, r), d(n).trigger(u + "-" + this.toDash(e), r)
            },
            arrayToClassname: function(e) {
                return d.grep(e, function(e) {
                    return !!e
                }).join(" ").trim()
            }
        },
        init: function(e) {
            var t = this;
            if (t.options = d.extend(!0, {}, d.fn[u].defaults, t.options, e), t.utils.triggerCallback("BeforeInit", t), t.destroy(!0), t.options.disableOnMobile && t.utils.isMobile()) t.disableOnMobile = !0;
            else {
                t.classes = t.getClassNames();
                var n = d("<input/>", {
                        "class": t.classes.input,
                        readonly: t.utils.isMobile()
                    }),
                    i = d("<div/>", {
                        "class": t.classes.items,
                        tabindex: -1
                    }),
                    r = d("<div/>", {
                        "class": t.classes.scroll
                    }),
                    a = d("<div/>", {
                        "class": t.classes.prefix,
                        html: t.options.arrowButtonMarkup
                    }),
                    o = d("<span/>", {
                        "class": "label"
                    }),
                    s = t.$element.wrap("<div/>").parent().append(a.prepend(o), i, n),
                    l = d("<div/>", {
                        "class": t.classes.hideselect
                    });
                t.elements = {
                    input: n,
                    items: i,
                    itemsScroll: r,
                    wrapper: a,
                    label: o,
                    outerWrapper: s
                }, t.options.nativeOnMobile && t.utils.isMobile() && (t.elements.input = undefined, l.addClass(t.classes.prefix + "-is-native"), t.$element.on("change", function() {
                    t.refresh()
                })), t.$element.on(t.eventTriggers).wrap(l), t.originalTabindex = t.$element.prop("tabindex"), t.$element.prop("tabindex", -1), t.populate(), t.activate(), t.utils.triggerCallback("Init", t)
            }
        },
        activate: function() {
            var e = this,
                t = e.elements.items.closest(":visible").children(":hidden").addClass(e.classes.tempshow),
                n = e.$element.width();
            t.removeClass(e.classes.tempshow), e.utils.triggerCallback("BeforeActivate", e), e.elements.outerWrapper.prop("class", e.utils.arrayToClassname([e.classes.wrapper, e.$element.prop("class").replace(/\S+/g, e.classes.prefix + "-$&"), e.options.responsive ? e.classes.responsive : ""])), e.options.inheritOriginalWidth && 0 < n && e.elements.outerWrapper.width(n), e.unbindEvents(), e.$element.prop("disabled") ? (e.elements.outerWrapper.addClass(e.classes.disabled), e.elements.input && e.elements.input.prop("disabled", !0)) : (e.state.enabled = !0, e.elements.outerWrapper.removeClass(e.classes.disabled), e.$li = e.elements.items.removeAttr("style").find("li"), e.bindEvents()), e.utils.triggerCallback("Activate", e)
        },
        getClassNames: function() {
            var i = this,
                r = i.options.customClass,
                a = {};
            return d.each(e.split(" "), function(e, t) {
                var n = r.prefix + t;
                a[t.toLowerCase()] = r.camelCase ? n : i.utils.toDash(n)
            }), a.prefix = r.prefix, a
        },
        setLabel: function() {
            var n = this,
                t = n.options.labelBuilder;
            if (n.state.multiple) {
                var e = Array.isArray(n.state.currValue) ? n.state.currValue : [n.state.currValue];
                e = 0 === e.length ? [0] : e;
                var i = d.map(e, function(t) {
                    return d.grep(n.lookupItems, function(e) {
                        return e.index === t
                    })[0]
                });
                i = d.grep(i, function(e) {
                    return 1 < i.length || 0 === i.length ? "" !== e.value.trim() : e
                }), i = d.map(i, function(e) {
                    return "function" == typeof t ? t(e) : n.utils.format(t, e)
                }), n.options.multiple.maxLabelEntries && (i.length >= n.options.multiple.maxLabelEntries + 1 ? (i = i.slice(0, n.options.multiple.maxLabelEntries)).push("function" == typeof t ? t({
                    text: "..."
                }) : n.utils.format(t, {
                    text: "..."
                })) : i.slice(i.length - 1)), n.elements.label.html(i.join(n.options.multiple.separator))
            } else {
                var r = n.lookupItems[n.state.currValue];
                n.elements.label.html("function" == typeof t ? t(r) : n.utils.format(t, r))
            }
        },
        populate: function() {
            var i = this,
                e = i.$element.children(),
                t = i.$element.find("option"),
                n = t.filter(":selected"),
                r = t.index(n),
                a = 0,
                o = i.state.multiple ? [] : 0;
            1 < n.length && i.state.multiple && (r = [], n.each(function() {
                r.push(d(this).index())
            })), i.state.currValue = ~r ? r : o, i.state.selectedIdx = i.state.currValue, i.state.highlightedIdx = i.state.currValue, i.items = [], i.lookupItems = [], e.length && (e.each(function(e) {
                var t = d(this);
                if (t.is("optgroup")) {
                    var n = {
                        element: t,
                        label: t.prop("label"),
                        groupDisabled: t.prop("disabled"),
                        items: []
                    };
                    t.children().each(function(e) {
                        var t = d(this);
                        n.items[e] = i.getItemData(a, t, n.groupDisabled || t.prop("disabled")), i.lookupItems[a] = n.items[e], a++
                    }), i.items[e] = n
                } else i.items[e] = i.getItemData(a, t, t.prop("disabled")), i.lookupItems[a] = i.items[e], a++
            }), i.setLabel(), i.elements.items.append(i.elements.itemsScroll.html(i.getItemsMarkup(i.items))))
        },
        getItemData: function(e, t, n) {
            var i = this;
            return {
                index: e,
                element: t,
                value: t.val(),
                className: t.prop("class"),
                text: t.html(),
                slug: i.utils.replaceDiacritics(t.html()).trim(),
                alt: t.attr("data-alt"),
                selected: t.prop("selected"),
                disabled: n
            }
        },
        getItemsMarkup: function(e) {
            var n = this,
                i = "<ul>";
            return "function" == typeof n.options.listBuilder && n.options.listBuilder && (e = n.options.listBuilder(e)), d.each(e, function(e, t) {
                t.label !== undefined ? (i += n.utils.format('<ul class="{1}"><li class="{2}">{3}</li>', n.utils.arrayToClassname([n.classes.group, t.groupDisabled ? "disabled" : "", t.element.prop("class")]), n.classes.grouplabel, t.element.prop("label")), d.each(t.items, function(e, t) {
                    i += n.getItemMarkup(t.index, t)
                }), i += "</ul>") : i += n.getItemMarkup(t.index, t)
            }), i + "</ul>"
        },
        getItemMarkup: function(e, t) {
            var n = this,
                i = n.options.optionsItemBuilder,
                r = {
                    value: t.value,
                    text: t.text,
                    slug: t.slug,
                    index: t.index
                };
            return n.utils.format('<li data-index="{1}" class="{2}">{3}</li>', e, n.utils.arrayToClassname([t.className, e === n.items.length - 1 ? "last" : "", t.disabled ? "disabled" : "", t.selected ? "selected" : ""]), "function" == typeof i ? n.utils.format(i(t, this.$element, e), t) : n.utils.format(i, r))
        },
        unbindEvents: function() {
            var e = this;
            e.elements.wrapper.add(e.$element).add(e.elements.outerWrapper).add(e.elements.input).off(n)
        },
        bindEvents: function() {
            var a = this;
            a.elements.outerWrapper.on("mouseenter" + n + " mouseleave" + n, function(e) {
                d(this).toggleClass(a.classes.hover, "mouseenter" === e.type), a.options.openOnHover && (clearTimeout(a.closeTimer), "mouseleave" === e.type ? a.closeTimer = setTimeout(d.proxy(a.close, a), a.options.hoverIntentTimeout) : a.open())
            }), a.elements.wrapper.on("click" + n, function(e) {
                a.state.opened ? a.close() : a.open(e)
            }), a.options.nativeOnMobile && a.utils.isMobile() || (a.$element.on("focus" + n, function() {
                a.elements.input.focus()
            }), a.elements.input.prop({
                tabindex: a.originalTabindex,
                disabled: !1
            }).on("keydown" + n, d.proxy(a.handleKeys, a)).on("focusin" + n, function(e) {
                a.elements.outerWrapper.addClass(a.classes.focus), a.elements.input.one("blur", function() {
                    a.elements.input.trigger("blur")
                }), a.options.openOnFocus && !a.state.opened && a.open(e)
            }).on("focusout" + n, function() {
                a.elements.outerWrapper.removeClass(a.classes.focus)
            }).on("input propertychange", function() {
                var e = a.elements.input.val(),
                    r = new RegExp("^" + a.utils.escapeRegExp(e), "i");
                clearTimeout(a.resetStr), a.resetStr = setTimeout(function() {
                    a.elements.input.val("")
                }, a.options.keySearchTimeout), e.length && d.each(a.items, function(e, t) {
                    if (!t.disabled) {
                        if (r.test(t.text) || r.test(t.slug)) return a.highlight(e), !1;
                        if (t.alt)
                            for (var n = t.alt.split("|"), i = 0; i < n.length && n[i]; i++)
                                if (r.test(n[i].trim())) return a.highlight(e), !1
                    }
                })
            })), a.$li.on({
                mousedown: function(e) {
                    e.preventDefault(), e.stopPropagation()
                },
                click: function() {
                    return a.select(d(this).data("index")), !1
                }
            })
        },
        handleKeys: function(e) {
            var t = this,
                n = e.which,
                i = t.options.keys,
                r = -1 < d.inArray(n, i.previous),
                a = -1 < d.inArray(n, i.next),
                o = -1 < d.inArray(n, i.select),
                s = -1 < d.inArray(n, i.open),
                l = t.state.highlightedIdx,
                u = r && 0 === l || a && l + 1 === t.items.length,
                c = 0;
            if (13 !== n && 32 !== n || e.preventDefault(), r || a) {
                if (!t.options.allowWrap && u) return;
                r && (c = t.utils.previousEnabledItem(t.lookupItems, l)), a && (c = t.utils.nextEnabledItem(t.lookupItems, l)), t.highlight(c)
            }
            if (o && t.state.opened) return t.select(l), void(t.state.multiple && t.options.multiple.keepMenuOpen || t.close());
            s && !t.state.opened && t.open()
        },
        refresh: function() {
            var e = this;
            e.populate(), e.activate(), e.utils.triggerCallback("Refresh", e)
        },
        setOptionsDimensions: function() {
            var e = this,
                t = e.elements.items.closest(":visible").children(":hidden").addClass(e.classes.tempshow),
                n = e.options.maxHeight,
                i = e.elements.items.outerWidth(),
                r = e.elements.wrapper.outerWidth() - (i - e.elements.items.width());
            !e.options.expandToItemText || i < r ? e.finalWidth = r : (e.elements.items.css("overflow", "scroll"), e.elements.outerWrapper.width(9e4), e.finalWidth = e.elements.items.width(), e.elements.items.css("overflow", ""), e.elements.outerWrapper.width("")), e.elements.items.width(e.finalWidth).height() > n && e.elements.items.height(n), t.removeClass(e.classes.tempshow)
        },
        isInViewport: function() {
            var e = this;
            if (!0 === e.options.forceRenderAbove) e.elements.outerWrapper.addClass(e.classes.above);
            else if (!0 === e.options.forceRenderBelow) e.elements.outerWrapper.addClass(e.classes.below);
            else {
                var t = l.scrollTop(),
                    n = l.height(),
                    i = e.elements.outerWrapper.offset().top,
                    r = i + e.elements.outerWrapper.outerHeight() + e.itemsHeight <= t + n,
                    a = i - e.itemsHeight > t,
                    o = !r && a,
                    s = !o;
                e.elements.outerWrapper.toggleClass(e.classes.above, o), e.elements.outerWrapper.toggleClass(e.classes.below, s)
            }
        },
        detectItemVisibility: function(e) {
            var t = this,
                n = t.$li.filter("[data-index]");
            t.state.multiple && (e = Array.isArray(e) && 0 === e.length ? 0 : e, e = Array.isArray(e) ? Math.min.apply(Math, e) : e);
            var i = n.eq(e).outerHeight(),
                r = n[e].offsetTop,
                a = t.elements.itemsScroll.scrollTop(),
                o = r + 2 * i;
            t.elements.itemsScroll.scrollTop(o > a + t.itemsHeight ? o - t.itemsHeight : r - i < a ? r - i : a)
        },
        open: function(e) {
            var r = this;
            if (r.options.nativeOnMobile && r.utils.isMobile()) return !1;
            r.utils.triggerCallback("BeforeOpen", r), e && (e.preventDefault(), r.options.stopPropagation && e.stopPropagation()), r.state.enabled && (r.setOptionsDimensions(), d("." + r.classes.hideselect, "." + r.classes.open).children()[u]("close"), r.state.opened = !0, r.itemsHeight = r.elements.items.outerHeight(), r.itemsInnerHeight = r.elements.items.height(), r.elements.outerWrapper.addClass(r.classes.open), r.elements.input.val(""), e && "focusin" !== e.type && r.elements.input.trigger("focus"), setTimeout(function() {
                t.on("click" + n, d.proxy(r.close, r)).on("scroll" + n, d.proxy(r.isInViewport, r))
            }, 1), r.isInViewport(), r.options.preventWindowScroll && t.on("mousewheel" + n + " DOMMouseScroll" + n, "." + r.classes.scroll, function(e) {
                var t = e.originalEvent,
                    n = d(this).scrollTop(),
                    i = 0;
                "detail" in t && (i = -1 * t.detail), "wheelDelta" in t && (i = t.wheelDelta), "wheelDeltaY" in t && (i = t.wheelDeltaY), "deltaY" in t && (i = -1 * t.deltaY), (n === this.scrollHeight - r.itemsInnerHeight && i < 0 || 0 === n && 0 < i) && e.preventDefault()
            }), r.detectItemVisibility(r.state.selectedIdx), r.highlight(r.state.multiple ? -1 : r.state.selectedIdx), r.utils.triggerCallback("Open", r))
        },
        close: function() {
            var e = this;
            e.utils.triggerCallback("BeforeClose", e), t.off(n), e.elements.outerWrapper.removeClass(e.classes.open), e.state.opened = !1, e.utils.triggerCallback("Close", e)
        },
        change: function() {
            var n = this;
            n.utils.triggerCallback("BeforeChange", n), n.state.multiple ? (d.each(n.lookupItems, function(e) {
                n.lookupItems[e].selected = !1, n.$element.find("option").prop("selected", !1)
            }), d.each(n.state.selectedIdx, function(e, t) {
                n.lookupItems[t].selected = !0, n.$element.find("option").eq(t).prop("selected", !0)
            }), n.state.currValue = n.state.selectedIdx, n.setLabel(), n.utils.triggerCallback("Change", n)) : n.state.currValue !== n.state.selectedIdx && (n.$element.prop("selectedIndex", n.state.currValue = n.state.selectedIdx).data("value", n.lookupItems[n.state.selectedIdx].text), n.setLabel(), n.utils.triggerCallback("Change", n))
        },
        highlight: function(e) {
            var t = this,
                n = t.$li.filter("[data-index]").removeClass("highlighted");
            t.utils.triggerCallback("BeforeHighlight", t), e === undefined || -1 === e || t.lookupItems[e].disabled || (n.eq(t.state.highlightedIdx = e).addClass("highlighted"), t.detectItemVisibility(e), t.utils.triggerCallback("Highlight", t))
        },
        select: function(e) {
            var t = this,
                n = t.$li.filter("[data-index]");
            if (t.utils.triggerCallback("BeforeSelect", t, e), e !== undefined && -1 !== e && !t.lookupItems[e].disabled) {
                if (t.state.multiple) {
                    t.state.selectedIdx = Array.isArray(t.state.selectedIdx) ? t.state.selectedIdx : [t.state.selectedIdx];
                    var i = d.inArray(e, t.state.selectedIdx); - 1 !== i ? t.state.selectedIdx.splice(i, 1) : t.state.selectedIdx.push(e), n.removeClass("selected").filter(function(e) {
                        return -1 !== d.inArray(e, t.state.selectedIdx)
                    }).addClass("selected")
                } else n.removeClass("selected").eq(t.state.selectedIdx = e).addClass("selected");
                t.state.multiple && t.options.multiple.keepMenuOpen || t.close(), t.change(), t.utils.triggerCallback("Select", t, e)
            }
        },
        destroy: function(e) {
            var t = this;
            t.state && t.state.enabled && (t.elements.items.add(t.elements.wrapper).add(t.elements.input).remove(), e || t.$element.removeData(u).removeData("value"), t.$element.prop("tabindex", t.originalTabindex).off(n).off(t.eventTriggers).unwrap().unwrap(), t.state.enabled = !1)
        }
    }, d.fn[u] = function(t) {
        return this.each(function() {
            var e = d.data(this, u);
            e && !e.disableOnMobile ? "string" == typeof t && e[t] ? e[t]() : e.init(t) : d.data(this, u, new a(this, t))
        })
    }, d.fn[u].defaults = {
        onChange: function(e) {
            d(e).trigger("change")
        },
        maxHeight: 300,
        keySearchTimeout: 500,
        arrowButtonMarkup: '<b class="button">&#x25be;</b>',
        disableOnMobile: !1,
        nativeOnMobile: !0,
        openOnFocus: !0,
        openOnHover: !1,
        hoverIntentTimeout: 500,
        expandToItemText: !1,
        responsive: !1,
        preventWindowScroll: !0,
        inheritOriginalWidth: !1,
        allowWrap: !0,
        forceRenderAbove: !1,
        forceRenderBelow: !1,
        stopPropagation: !0,
        optionsItemBuilder: "{text}",
        labelBuilder: "{text}",
        listBuilder: !1,
        keys: {
            previous: [37, 38],
            next: [39, 40],
            select: [9, 13, 27],
            open: [13, 32, 37, 38, 39, 40],
            close: [9, 27]
        },
        customClass: {
            prefix: u,
            camelCase: !1
        },
        multiple: {
            separator: ", ",
            keepMenuOpen: !0,
            maxLabelEntries: !1
        }
    }
}),
function() {
    var e;
    e = function(e) {
        return new window.IMask(e, {
            mask: "(000) 000-00-00"
        })
    }, $(function() {
        if ($(".js-phone-validate").length) return e($(".js-phone-validate")[0]), $(".ad-form").on("ajax:success", function() {
            return setTimeout(function() {
                return e($(".js-phone-validate")[0]), 1e3
            })
        })
    })
}.call(this),
function() {
    $(function() {
        var e, t, n;
        if ($("#item_leased").on("change", function() {
                var e;
                return e = "false" === $(this).val(), $("#item_has_bill_of_sale").prop({
                    disabled: !e
                }).closest(".input").toggle(e), $("#item_has_mortgage").prop({
                    disabled: !e
                }).closest(".input").toggle(e)
            }), $("#item_leased").trigger("change"), $(".ad-form").on({
                "ajax:beforeSend": function(e) {
                    e.originalEvent.detail[1].indication = !1
                }
            }), 0 < $(".param_info").length && 0 < $(".map-link img").length) return t = $(".param_info").height(), e = $(".map-link img"), 220 < t ? (t = 10 * Math.ceil(t / 10), n = e.attr("data-src").replace("size=360x220", "size=360x" + t), e.height(t)) : n = e.attr("data-src"), e.attr("src", n), e.show()
    })
}.call(this),
function(t) {
    $.extend(t, {
        cacheEnableSelector: "",
        disableFormElements: function(e) {
            t.cacheEnableSelector = t.formElements(e, t.disableSelector).each(function() {
                t.disableFormElement($(this))
            })
        },
        enableFormElements: function(e) {
            t.formElements(e, t.cacheEnableSelector).each(function() {
                t.enableFormElement($(this))
            })
        }
    })
}($.rails),
function() {
    $(function() {
        var t, e, n;
        return t = 27, n = $(".locations_popup"), e = {
            keyPress: function(e) {
                if (e.keyCode === t && n.is(":visible")) return n.find(".ok").trigger("click")
            },
            click: function(e) {
                var t;
                if (n.is(":visible")) return (t = $(e.target)).hasClass("locations_popup") || 0 < t.closest(".locations_popup").length ? void 0 : n.find(".ok").trigger("click")
            }
        }, $(document).on({
            keydown: e.keyPress,
            click: e.click
        })
    })
}.call(this),
function() {
    $(function() {
        var e, t, n;
        if (t = $("#js-lotriver-bg-banner"), e = document.getElementById("banner_ad"), !t.data("hidden") && "undefined" != typeof window.adriver && 0 !== e.clientHeight) try {
            return new window.adriver("js-lotriver-bg-banner", {
                sid: 220686,
                bt: 52,
                bn: 4
            })
        } catch (i) {
            return n = i, window.console.error(n)
        }
    })
}.call(this),
function() {
    window.paymentFailed = function() {}, window.paymentFinished = function() {
        var e, r, t, a;
        if ((t = $('.reveal-modal_opened[class*="js-service-modal-"]')).length ? a = t.attr("class").match(/js-service-modal-(bump|vip|feature)/)[1] : location.reload(), r = $(".reveal-modal_opened"), e = $('[name="payment[target_id]"]').val(), a && e) return $.ajax({
            url: "/items/" + e + "/service_success/" + a,
            dataType: "html",
            success: function(e) {
                var t, n, i;
                return n = $(e).find("#balance").val(), 0 < (i = $(".az-payments-type-wallet .wallet-balance")).length && i.html(n), $("#" + a + "-success").remove(), $("body").append(e), t = $(e).find(".js-payment-success-date").html(), 0 !== r.find(".paid_until").length ? r.find(".paid_until").html(t) : !r.is("#bump_modal") && r.find(".reveal-service").addClass("active").before($('<div class="paid_until">').text(t))
            },
            complete: function() {
                return r.trigger("reveal:close"), $("#" + a + "-success").reveal({
                    animation: "fade"
                }), 0 < $(".offer").length && $(".offer").remove(), history.replaceState(null, document.title, location.pathname + location.search)
            }
        })
    }
}.call(this),
function() {
    $(document).on("click", ".js-show-phones", function() {
        var e;
        return e = location.pathname.replace(/\.html$/, ""), $.ajax({
            url: e + "/phones",
            dataType: "json",
            success: function(e) {
                var t, n, i, r;
                return i = $(".js-phones:not([data-type])"), n = $('.js-phones[data-type="link"]'), 0 < i.length && (t = $(e.phones).map(function() {
                    return "<li>" + this + "</li>"
                }).get().join(""), i.html("<ul>" + t + "</ul>")), 0 < n.length && (r = n.data("link-class"), t = $(e.phones).map(function() {
                    return "<li><a class='" + r + "' href='tel:" + this + "'>" + this + "</a></li>"
                }).get().join(""), n.html("<ul>" + t + "</ul>")), $(".js-show-phones").removeClass("active")
            }
        })
    })
}.call(this),
function() {
    var e;
    e = function() {
        function e(e) {
            this.el = e, this.thumbsContainer = this.el.find(".thumbnails"), this.thumbs = this.thumbsContainer.find("a"), this.resizeThumbs(), this.preload()
        }
        return e.prototype.PRELOAD_COUNT = 6, e.prototype.resizeThumbs = function() {
            return this.thumbsContainer.find("img").attr("width", this.calcThumbWidth()), this.thumbsContainer.addClass("thumbnails_resized")
        }, e.prototype.calcThumbWidth = function() {
            var e;
            return 30 < (e = this.thumbsContainer.data("count")) ? 58 : 20 < e ? 69 : 12 < e ? 85 : 6 < e ? 110 : 150
        }, e.prototype.preload = function() {
            return this.thumbs.slice(0, this.PRELOAD_COUNT).map(function() {
                return (new Image).src = this.href
            })
        }, e
    }(), $(function() {
        return new e($(".photos"))
    })
}.call(this),
function() {
    $(function() {
        return $(".pincode-modal").on("reveal:open", function() {
            var e;
            return e = $(this), setTimeout(function() {
                return e.find(".js-pincode-form-field").trigger("focus")
            }, 500)
        })
    })
}.call(this),
function() {
    $(function() {
        var e, t, n;
        if (-1 < window.location.href.indexOf("transactions?page") && (t = $("#js-profile-transactions").offset().top - 77, $("html, body").animate({
                scrollTop: t
            }, 200)), n = $("#js-profile-wallet-replenishment-success"), 0 < $("#js-profile-wallet-replenishment-failure").length && (window.paymentFailure = function() {
                return $(".reveal-modal_opened").trigger("reveal:close"), $("#js-profile-wallet-replenishment-failure").reveal({
                    animation: "fade"
                })
            }), 0 < n.length && (window.paymentFinished = function() {
                return $(".reveal-modal_opened").trigger("reveal:close"), $.ajax({
                    url: "/profile/transactions",
                    dataType: "html",
                    success: function(e) {
                        var t, n, i, r;
                        if (n = $(e).filter("#js-profile-transactions"), t = $(e).find(".js-profile-wallet-balance").html(), i = $(".js-profile-wallet-balance"), r = $("#js-profile-transactions"), i.html(t), -1 === window.location.href.indexOf("transactions?page")) return r.replaceWith(n)
                    },
                    complete: function() {
                        return $("#js-profile-wallet-replenishment-success").reveal({
                            animation: "fade"
                        })
                    }
                })
            }), 0 < (e = $(".flash-text_hide.no-react")).length) return setTimeout(function() {
            return e.parent().remove()
        }, 3e4), e.on("click", function() {
            return $(this).parent().remove()
        })
    })
}.call(this),
function() {
    $(function() {
        var t, e, n, i;
        return t = $(".quick-links_content"), e = $(".quick-links_tab"), i = [$("#js-quick-links_sale-tab"), $("#js-quick-links_sale")], n = [$("#js-quick-links_lease-tab"), $("#js-quick-links_lease")], e.on("click", function() {
            var e;
            if (!(e = $(this)).hasClass("active")) return $(".quick-links_lists-container.active").removeClass("active"), t.append("<div class='loading'></div>"), setTimeout(function() {
                return $(".quick-links_content").find(".loading").remove(), e.is(i[0]) ? (i[0].addClass("active"), n[0].removeClass("active"), i[1].addClass("active"), n[1].removeClass("active")) : (n[0].addClass("active"), i[0].removeClass("active"), n[1].addClass("active"), i[1].removeClass("active"))
            }, 200)
        })
    })
}.call(this),
function() {
    $(function() {
        var e;
        return (e = $("body")).on("click", 'a[href="#new_report"]', function() {
            return $(this).hide()
        }), e.on("ajax:success", "#new_report", function(e) {
            var t;
            return t = e.originalEvent.detail[2], $(this).replaceWith(t.responseText)
        }), e.on("ajax:error", "#new_report", function() {
            return alert("An error occured. Please, try again.")
        })
    })
}.call(this),
function() {
    $(function() {
        return $(".reveal-modal").on("reveal:open", function() {
            var e, t, n;
            return e = $(this), t = $(window), (n = function() {
                return setTimeout(function() {
                    return e.animate({
                        top: (t.height() - e.outerHeight()) / 2
                    }, 200)
                }, 400)
            })(), t.on("resize", function() {
                if (e.hasClass("reveal-modal_opened")) return n()
            })
        })
    })
}.call(this),
function() {
    $(function() {
        var e, t;
        return $(".loading").hide(), e = $("body"), new window.RowSlider, t = ".row .service_type_switcher a", e.on("ajax:beforeSend", t, function() {
            var e;
            return e = $(this).closest(".row"), this.loading_timeout = setTimeout(function() {
                return e.find(".loading").show()
            }, 500), null
        }), e.on("ajax:success", t, function(e) {
            var t, n, i, r, a;
            return a = e.originalEvent.detail[2], i = (r = $(this).closest(".row")).attr("id"), window.clearBookmarksData(), clearTimeout(this.loading_timeout), r.replaceWith(a.responseText), n = (t = $("#" + i)).find(".js-row-slider-btn"), new window.RowSlider(n), window.initializeSwipeCarousel(), window.turnBookmarkingOn(t.find(".items-i"))
        }), e.on("ajax:error", t, function() {
            var e;
            return e = $(this).closest(".row"), clearTimeout(this.loading_timeout), e.find(".loading").hide(), alert("An error occured while loading. Please, try again.")
        })
    })
}.call(this),
function() {
    window.RowSlider = function() {
        function e(e) {
            null == e && (e = null), this.btn = e || $(document).find(".js-row-slider-btn"), this.bindClick()
        }
        return e.prototype.prev = function(e) {
            var t, n;
            if (n = e.closest(".js-slider-row"), t = parseInt(n.attr("data-position")), -1 < parseInt(n.attr("data-max-position")) - t && n.attr({
                    "data-position": t - 1
                }), t < 1) return t = 0, n.attr({
                "data-position": t
            })
        }, e.prototype.next = function(e) {
            var t, n;
            if (n = e.closest(".js-slider-row"), (t = parseInt(n.attr("data-position"))) < parseInt(n.attr("data-max-position"))) return n.attr({
                "data-position": t + 1
            })
        }, e.prototype.bindClick = function() {
            var n;
            return (n = this).btn.off("click"), this.btn.on("click", function(e) {
                var t;
                return e.preventDefault(), (t = $(this)).is(".js-row-slider-lt") ? n.prev(t) : n.next(t)
            })
        }, e
    }()
}.call(this),
function() {
    var r, a;
    r = [], a = [], $(document).on({
        "ajax:beforeSend": function(e) {
            var t, n, i;
            return i = (n = e.originalEvent.detail)[0], n[1], -1 !== (t = a.indexOf(e.target)) && (r[t].abort(), r.splice(t, 1), a.splice(t, 1)), a.push(e.target), r.push(i), e.target.setAttribute("data-requests", a.length)
        },
        "ajax:complete": function(e) {
            var t;
            return t = a.indexOf(e.target), r.splice(t, 1), a.splice(t, 1), e.target.setAttribute("data-requests", a.length)
        }
    })
}.call(this),
// function() {
//     var e;
//     e = function() {
//         var e, n;
//         if (e = $(".js-number-validate"), n = {
//                 mask: Number,
//                 signed: !1,
//                 scale: 0
//             }, e.length) return e.each(function(e) {
//             var t;
//             return t = "masked_" + e, $(this).data("masked-id", t), window[t] = new window.IMask(this, n)
//         })
//     }, window.numberMaskThousandsSeparator = function(e, t) {
//         var n;
//         return null == t && (t = " "), n = $(e).data("masked-id"), window[n].updateOptions({
//             thousandsSeparator: t
//         })
//     }, window.addThousandsSeparator = function(e) {
//         var t;
//         return t = {
//             mask: Number,
//             signed: !1,
//             scale: 0,
//             thousandsSeparator: " "
//         }, window.IMask.createMask(t).resolve(e)
//     }, $(function() {
//         return e()
//     })
// }.call(this),
function() {
    var e;
    e = function() {
        function e() {
            var e;
            this.radioActivated = !1, this.locationsContainer = $("#js-search-filters-tags"), this.form = $("#new_q"), this.filtersPanel = $("#js-search-filters"), this.headerNav = $(".js-page-header"), this.handleFloorCheckboxes(), this.deselectRadioButtons(), this.bindFormElementsClick(), this.selectedLocations = {
                metro: [],
                region: [],
                landmark: []
            }, this.bindPaidDailyChange(), this.bindPaidDailyLabelClick(), this.bindCityChange(), setTimeout((e = this, function() {
                return e.renderSelectedFiltersCount()
            }), 0), this.handleResetButtonState(), this.bindResetBtn(), this.bindFiltersCollapseBtnClick(), this.bindFiltersBgClick(), this.bindLeasedSelectChenge()
        }
        return e.prototype.clearForm = function(e) {
            return null == e && (e = !0), this.locationsContainer.empty(), this.renderSelectedLocationsCount(), e && (this.radioActivated = !1, window.searchLocations.searchLocationsReset()), this.renderSelectedFiltersCount(), this.handleResetButtonState()
        }, e.prototype.closeFilter = function() {
            return $("#js-search-filters").parent().removeClass("opened"), $("#js-search-row-filters-btn").removeClass("active"), $("#js-search-filters-bg").removeClass("opened").removeAttr("style")
        }, e.prototype.updateLocations = function(e) {
            var r;
            return r = this, e.each(function() {
                var e, t, n, i;
                return e = $(this).data("id"), n = (t = $(document).find("[data-id='" + e + "']")).closest("[data-locations-items]").data("locations-items"), i = r.createLocationTag($(t[0])), r.locationsContainer.append(i), r.bindRemoveLocationTag(), r.renderSelectedLocationsCount(t[0], n)
            })
        }, e.prototype.createLocationTag = function(e) {
            var t, n;
            return t = e.text(), n = e.data("id"), "<div class='search-filters__tag" + (e.hasClass("search-locations__list_station") ? " metro" : "") + " js-search-filters-tag-delete' data-id='" + n + "'>" + t + "</div>"
        }, e.prototype.bindRemoveLocationTag = function() {
            return $(".js-search-filters-tag-delete").on("click", (a = this, function(e) {
                var t, n, i, r;
                return (r = $(e.currentTarget)).remove(), t = r.data("id"), i = (n = $(document).find("[data-id='" + t + "']")).closest("[data-locations-items]").data("locations-items"), a.renderSelectedLocationsCount(n, i, "delete"), window.searchLocations.searchLocationsRemove(t)
            }));
            var a
        }, e.prototype.renderSelectedLocationsCount = function(t, e, n) {
            var i, r, a, o;
            return null == t && (t = null), null == e && (e = null), null == n && (n = "append"), null === t ? ($("[data-locations-tab]").find(".count").html(""), Object.entries(this.selectedLocations).map(function(e) {
                return e[1].splice(0, e[1].length)
            })) : (t = $(t), o = $("[data-locations-tab='" + e + "']"), r = t.closest("[data-locations-items]").data("locations-items"), "append" === n ? this.selectedLocations[r].push(t) : "delete" === n && (this.selectedLocations[r] = this.selectedLocations[r].filter(function(e) {
                return e.data("id") !== t.data("id")
            })), a = 0 === (i = this.selectedLocations[r].length) ? "" : "(" + i + ")", o.find(".count").html(a))
        }, e.prototype.showAdsCount = function() {
            var e, t, n, i;
            if ($("#js-search-filters").parent().hasClass("opened")) return t = this.form.attr("action"), e = $(".js-search-filters-range-inputs"), window.searchFormRow.normalizeSearchRowInputValues(e), n = this.form.serialize(), e.find("input").each(function() {
                // return window.numberMaskThousandsSeparator(this)
            }), i = "/api" + t + "/count?" + n, $.ajax({
                url: i,
                method: "GET",
                dataType: "JSON",
                success: function(e) {
                    return $(".js-search-filters-items-count").html(e.filters.button)
                },
                error: function() {
                    // return console.log("showAdsCount request error")
                }
            })
        }, e.prototype.handleFloorCheckboxes = function() {
            var e, t;
            return t = $("#q_floor_from"), (e = $("#q_floor_first")).on("change", function() {
                var e;
                if ($(this).is(":checked") && "1" === t.val() && (t.val(""), e = t.data("masked-id"))) return window[e].updateValue()
            }), t.on("keyup", function() {
                if ("1" === $(this).val()) return e.prop("checked", !1)
            })
        }, e.prototype.deselectRadioButtons = function() {
            return $("input[type='radio']").each(function() {
                return $(this).on("click", function() {
                    return $(this).data("checked") ? ($(this).prop("checked", !1), $(this).data("checked", !1), $(this).trigger("change")) : ($(this).prop("checked", !0), $(this).data("checked", !0), $(this).parent().siblings().find("input[type='radio']").data("checked", !1))
                })
            })
        }, e.prototype.handleResetButtonState = function() {
            return setTimeout((e = this, function() {
                return $(".js-search-filters-reset").toggleClass("active", e.paramsAreChoosen())
            }), 0);
            var e
        }, e.prototype.paramsAreChoosen = function() {
            var e, t, n, i;
            return n = this.filtersPanel.find("select:not([disabled])"), t = this.filtersPanel.find("input:text:not([disabled])"), e = this.filtersPanel.find("input:checkbox, input:radio").filter(":not([disabled])"), i = 0, n.each(function() {
                if (this.multiple && -1 !== this.selectedIndex || !this.multiple && 0 !== this.selectedIndex) return i++
            }), t.each(function() {
                if ("" !== this.value) return i++
            }), e.each(function() {
                if (this.checked) return i++
            }), this.paidDailyCheckboxesBothChecked() && (i += 2), 0 < i
        }, e.prototype.updateParams = function() {
            return this.handleResetButtonState(), this.renderSelectedFiltersCount(), setTimeout((e = this, function() {
                return e.showAdsCount()
            }), 0);
            var e
        }, e.prototype.bindFormElementsClick = function() {
            var e;
            return this.form.find("input, select").on("change", (e = this, function() {
                if (!e.form.data("reset-form")) return e.updateParams()
            }))
        }, e.prototype.bindPaidDailyChange = function() {
            return $(".js-search-paid-daily").on("change", (e = this, function() {
                return e.disablePaidDailyCheckboxes()
            }));
            var e
        }, e.prototype.bindPaidDailyLabelClick = function() {
            return $(".js-search-paid-daily-label").on("click", function() {
                var e;
                if ((e = $(this)).find(".js-search-paid-daily")[0].hasAttribute("disabled")) return $(".js-search-paid-daily").prop("disabled", !1), e.find(".js-search-paid-daily").prop("checked", !e.is(":checked"))
            })
        }, e.prototype.bindLeasedSelectChenge = function() {
            return $(".js-search-leased").on("change", (t = this, function(e) {
                return setTimeout(function() {
                    return t.disablePaidDailyCheckboxes()
                }, 0), t.setMenuActiveTab($(e.currentTarget).val())
            }));
            var t
        }, e.prototype.setMenuActiveTab = function(e) {
            var t;
            return t = "true" === e ? ".rent" : ".sale", this.headerNav.find(".nav-i").removeClass("active"), this.headerNav.find(t).addClass("active")
        }, e.prototype.disablePaidDailyCheckboxes = function() {
            var e;
            if (1 < (e = $(".js-search-paid-daily")).filter(":checked").length) return e.prop("disabled", !0)
        }, e.prototype.renderSelectedFiltersCount = function() {
            var e, t;
            return e = $(".js-search-row-filters-count"), 0 < (t = this.selectedFiltersCount()) ? e.text(t) : e.text("")
        }, e.prototype.selectedFiltersCount = function() {
            var n, e, i;
            return e = $("#js-search-filters").find("input, select").serializeArray(), n = i = 0, $.each(e, function(e, t) {
                if (t.value.length) return 0 <= t.name.indexOf("location_ids") ? n++ : i++
            }), 0 < n && (i += 1), this.paidDailyCheckboxesBothChecked() && (i += 2), i
        }, e.prototype.paidDailyCheckboxesBothChecked = function() {
            var e, t, n, i;
            return t = 2 === (e = $(".js-search-paid-daily")).filter(":checked").length, i = "none" !== e.closest("[data-toggled-by-field]").css("display"), n = e.prop("disabled"), t && i && n
        }, e.prototype.bindCityChange = function() {
            return $("#q_city_id").on("selectric-change selectric-refresh selectric-init", (i = this, function(e) {
                var t, n;
                return n = $(e.currentTarget).val(), t = $("#js-search-filters-row-locations"), i.checkActiveLocationPopup(n), "" !== n && 0 < i.checkActiveLocationButtons(n) ? t.show() : t.hide()
            }));
            var i
        }, e.prototype.checkActiveLocationButtons = function(e) {
            var t, n;
            return t = $(".js-search-filters-location"), n = 0, t.hide(), $(".js-search-locations-city-wrap[data-city-id='" + e + "']").find(".js-locations-tabs [data-locations-tab]").map(function() {
                var e;
                return e = $(this).attr("data-locations-tab"), t.filter("[data-locations-tab='" + e + "']").show(), n++
            }), n
        }, e.prototype.checkActiveLocationPopup = function(e) {
            return $("#js-search-locations").find("[data-city-id]").removeClass("active"), $("#js-search-locations").find("[data-city-id='" + e + "']").addClass("active")
        }, e.prototype.bindResetBtn = function() {
            return $(".js-search-filters-reset").on("click", (t = this, function(e) {
                if (e.preventDefault(), $(e.currentTarget).hasClass("active")) return t.clearForm()
            }));
            var t
        }, e.prototype.bindFiltersCollapseBtnClick = function() {
            return $(".js-search-filters-hide").on("click", (t = this, function(e) {
                return e.preventDefault(), t.closeFilter()
            }));
            var t
        }, e.prototype.bindFiltersBgClick = function() {
            return $("#js-search-filters-bg").on("click", (e = this, function() {
                return e.closeFilter()
            }));
            var e
        }, e
    }(), $(function() {
        if ($("#new_q").length) return window.searchFilter = new e
    })
}.call(this),
function() {
    var e;
    e = function() {
        function e() {
            this.form = $("#new_q"), this.bindInputLabelCLick(), this.bindFieldFocus(), this.bindFieldBlur(), this.bindFiltersBtnClick(), this.bindFormSubmit(), this.setInputValues(), this.bodyOnClick(), this.bindDropdownOpen()
        }
        return e.prototype.setSearchInputValue = function(e) {
                var t, n, i, r, a, o, s, l;
                return t = e.find("input[id$='_from']"), r = e.find("input[id$='_to']"), n = t.attr("placeholder"), a = r.attr("placeholder"), i = t.val(), o = r.val(), l = e.find(".js-search-row-input-value"), "" !== i && "" === o ? (s = n + " " + window.addThousandsSeparator(i), e.addClass("filled")) : "" === i && "" !== o ? (s = a + " " + window.addThousandsSeparator(o), e.addClass("filled")) : "" !== i && "" !== o ? (s = window.addThousandsSeparator(i) + " \u2013 " + window.addThousandsSeparator(o), e.addClass("filled")) : (s = "", e.removeClass("filled")), l.text(s)
            }, e.prototype.setInputValues = function() {
                var e;
                if ($(".js-search-row-input").length) return e = this, $(".js-search-row-input").each(function() {
                    return e.setSearchInputValue($(this))
                })
            }, e.prototype.closeInputContainer = function() {
                var e;
                return (e = $(".js-search-row-input.focused")).add(".js-search-row-field-container.focused").removeClass("focused"), this.normalizeSearchRowInputValues(e), e.find(".js-search-row-field").trigger("blur")
            },
            e.prototype.bindInputLabelCLick = function() {
                return $(document).on("click", ".js-search-row-input-label", (n = this, function(e) {
                    var t;
                    return (t = $(e.currentTarget).closest(".js-search-row-input")).hasClass("focused") ? (t.removeClass("focused"), n.normalizeSearchRowInputValues(t)) : (n.closeInputContainer(), n.toggleFiltersPanel(!1), t.addClass("focused").find("input[id$='_from']").trigger("focus"), t.find("input").each(function() {
                        // return window.numberMaskThousandsSeparator(this)
                    }))
                }));
                var n
            }, e.prototype.bindFieldFocus = function() {
                return $(document).on("focus", ".js-search-row-field", function() {
                    return $(this).closest(".js-search-row-field-container").addClass("focused")
                })
            }, e.prototype.bindFieldBlur = function() {
                return $(document).on("blur", ".js-search-row-field", function() {
                    return $(this).closest(".js-search-row-field-container").removeClass("focused")
                })
            }, e.prototype.bindFiltersBtnClick = function() {
                return $(document).on("click", "#js-search-row-filters-btn", (e = this, function() {
                    return e.toggleFiltersPanel()
                }));
                var e
            }, 
            e.prototype.bindFormSubmit = function() {
                return this.form.on("submit", (e = this, function() {
                    // if (e.toggleFiltersPanel(!1), e.closeInputContainer(), e.closeDropdowns(), e.isSearchByItemId()) return e.form.removeAttr("data-remote")
                }));
                var e
            }, 
            e.prototype.bindDropdownOpen = function() {
                return $(".js-selectric").on("selectric-open", (e = this, function() {
                    return e.closeInputContainer(), e.toggleFiltersPanel(!1)
                }));
                var e
            }, e.prototype.bodyOnClick = function() {
                return $("body").on("click", (t = this, function(e) {
                    if (!$(e.target).closest(".js-search-row-input.focused").length) return t.closeInputContainer()
                }));
                var t
            }, 
            // e.prototype.isSearchByItemId = function() {
            //     return 0 < $(".js-search-item-id").val().length
            // }, 
            e.prototype.toggleFiltersPanel = function(e) {
                var t, n, i, r, a;
                return null == e && (e = null), i = $("#js-search-row-filters-btn"), t = $("#js-search-filters").parent(), n = $("#js-search-filters-bg"), r = $(".js-search-filters-range-inputs"), null === e ? (i.hasClass("active") ? i.removeClass("active") : i.addClass("active"), t.hasClass("opened") ? t.removeClass("opened") : t.addClass("opened"), n.hasClass("opened") ? n.removeClass("opened").removeAttr("style") : n.addClass("opened")) : (i.toggleClass("active", e, 0), t.toggleClass("opened", e, 0), e || n.toggleClass("opened", e, 0).removeAttr("style")), t.hasClass("opened") ? r.find("input").each(function() {
                    // return window.numberMaskThousandsSeparator(this)
                }) : window.searchFormRow.normalizeSearchRowInputValues(r), setTimeout((a = this, function() {
                    if (e || null === e && t.hasClass("opened")) return a.setFiltersBgHeight(), window.searchFilter.showAdsCount(), $("#js-search-filters").data("emptyFilters", !window.searchFilter.paramsAreChoosen())
                }), 200)
            }, e.prototype.closeDropdowns = function() {
                return $(".js-selectric").selectric("close")
            }, e.prototype.setFiltersBgHeight = function() {
                var e;
                if ($("#js-search-filters-bg").hasClass("opened")) return e = $(".content_bg").outerHeight(!0) + $(".page-foot-container").height(), $("#js-search-filters-bg").height(e)
            }, e.prototype.normalizeInputValues = function(e) {
                // return window.numberMaskThousandsSeparator(e, "")
            }, e.prototype.normalizeSearchRowInputValues = function(e) {
                var t;
                return t = this, e.find("input").each(function() {
                    return t.normalizeInputValues(this)
                })
            }, e
    }(), $(function() {
        if ($("#new_q").length) return window.searchFormRow = new e
    })
}.call(this),//select js work here
function() {
    window.SearchResultsLoading = function() {
        function e() {
            this.form = $("#new_q"), this.mainSelector = "#js-main-col", this.mainContainer = $(this.mainSelector), this.resultsSelector = "#js-search-results", this.itemsViewLink = ".js-items-view-link", this.paginationButtons = ".pagination a", this.filtersPanel = $("#js-search-filters"), this.inputObserversCount = 0, this.bindAjaxRequest(this.form), this.bindAjaxRequest($(this.itemsViewLink)), this.bindAjaxRequest($(this.paginationButtons)), this.bindSortingChange(), this.bindSelectChange(), this.bindMultiSelectChange(), this.bindInputChange(), this.bindResetBtn(), this.bindAreaChange(), this.bindTryAgainLinkClick()
        }
        return e.prototype.bindAjaxRequest = function(e) {
            return e.on({
                "ajax:beforeSend": (r = this, function() {
                    return r.beforeSend()
                }),
                "ajax:success": (i = this, function(e) {
                    return i.success(e)
                }),
                "ajax:error": (n = this, function() {
                    return n.error()
                }),
                "ajax:complete": (t = this, function() {
                    return t.complete()
                })
            });
            var t, n, i, r
        }, e.prototype.beforeSend = function() {
            if ($("#js-search-locations").trigger("reveal:close"), this.mainContainer.addClass("loading"), this.filtersPanel.hasClass("opened")) return $("#js-search-row-filters-btn").trigger("click")
        }, e.prototype.success = function(e) {
            var t, n;
            return n = e.originalEvent.detail[2], t = $(e.currentTarget), this.mainContainer.html($(n.responseText).find(this.mainSelector).html()), this.mainContainer.removeClass("loading"), document.title = $(this.resultsSelector).data("title"), this.updateBodyClasses(), this.preventPageRefresh(), $(this.itemsViewLink).length && this.bindAjaxRequest($(this.itemsViewLink)), $(this.paginationButtons).length && this.bindAjaxRequest($(this.paginationButtons)), t.hasClass("js-items-view-link") && (this.resetGmapsOnListViewSwitch(e.currentTarget), this.updateViewParameter(t)), t.parents(".pagination").length && this.updatePageParameter($(this.resultsSelector)), this.reinitializeScripts(), window.hit(), t.parents(".pagination").length && this.scrollToTop(), this.refreshBanners()
        }, e.prototype.error = function() {
            return setTimeout((e = this, function() {
                if (e.form.attr("data-requests") < 1) return e.showServerErrorMsg(), e.mainContainer.removeClass("loading")
            }), 100);
            var e
        }, e.prototype.complete = function() {}, e.prototype.preventPageRefresh = function() {
            var e;
            if ((e = $('meta[http-equiv="refresh"]')).length) return e.remove(), window.stop(), document.execCommand("Stop")
        }, e.prototype.scrollToTop = function() {
            return $("html, body").animate({
                scrollTop: 0
            }, 500)
        }, e.prototype.updateViewParameter = function(e) {
            return this.form.find("#items_view").val(e.data("view"))
        }, e.prototype.updatePageParameter = function(e) {
            return this.form.find("#page").val(e.data("page"))
        }, e.prototype.bindSortingChange = function() {
            return $(document).on("change", "#sorting_dropdown", (i = this, function(e) {
                var t, n;
                if (t = (n = $(e.currentTarget)).find(":selected"), !n.hasClass("custom")) return $("#sorting").val(t.val()), i.fireFormSubmit()
            }));
            var i
        }, e.prototype.bindSelectChange = function() {
            return $(document).on("change", ".js-selectric.single", (e = this, function() {
                if (!e.isResetFormAction()) return e.fireFormSubmit()
            }));
            var e
        }, e.prototype.bindMultiSelectChange = function() {
            return $(document).on("change", ".js-selectric.multiple", (e = this, function() {
                if (!e.isResetFormAction()) return e.fireFormSubmit(1e3)
            }));
            var e
        }, e.prototype.bindInputChange = function() {
            return $(document).on("change input keydown", ".js-search-row-field", (n = this, function(e) {
                var t;
                if (!n.isResetFormAction()) return 13 === (e.keyCode ? e.keyCode : e.which) ? (e.preventDefault(), void window.searchFormRow.closeInputContainer()) : (void 0 === (t = $(e.currentTarget)).data("prevValue") && t.data("prevValue", ""), t.val() !== t.data("prevValue") ? (n.bindInputClose(t), t.data("prevValue", t.val())) : void 0)
            }));
            var n
        }, e.prototype.bindInputClose = function(e) {
            var t, n, i;
            if (!(0 < this.inputObserversCount)) return t = e.closest(".js-search-row-input"), (n = new MutationObserver((i = this, function() {
                if (!t.hasClass("focused")) return window.searchFormRow.normalizeSearchRowInputValues(t), i.fireFormSubmit(), window.searchFormRow.setSearchInputValue(t), n.disconnect(), i.inputObserversCount = 0
            }))).observe(t[0], {
                attributes: !0
            }), this.inputObserversCount++
        }, e.prototype.fireFormSubmit = function(e) {
            return null == e && (e = 0), clearTimeout(this.submitTimeout), this.submitTimeout = setTimeout((t = this, function() {
                return Rails.fire(t.form[0], "submit"), t.form.data("reset-form", !1), window.searchFilter.updateParams(), t.filtersPanel.data("emptyFilters", !1)
            }), e);
            var t
        }, e.prototype.resetGmapsOnListViewSwitch = function(e) {
            if (-1 !== e.href.indexOf("items_view=list")) return window.google = {}
        }, e.prototype.updateBodyClasses = function() {
            return $("body").removeClass(function(e, t) {
                return t.match(/\blayout_\S+/g).join(" ")
            }).addClass("layout_items_search layout_items_search_index")
        }, e.prototype.reinitializeScripts = function() {
            return window.turnBookmarkingOn($(".items-i")), window.initializeSwipeCarousel(), window.contentHeightFix(), new window.MakeFeaturedAd, new window.MakeVippedAd, window.bindRevealModalActions()
        }, e.prototype.showServerErrorMsg = function() {
            // return this.mainContainer.html($("#js-search-server-error").show()), window.contentHeightFix()
        }, e.prototype.isResetFormAction = function() {
            return this.form.data("reset-form")
        }, e.prototype.bindResetBtn = function() {
            return $(".js-search-filters-reset").on("click", (t = this, function(e) {
                if (e.preventDefault(), $(e.currentTarget).hasClass("active")) return t.resetFilters()
            }));
            var t
        }, e.prototype.deactivateResetBtn = function() {
            return $(".js-search-filters-reset").removeClass("active")
        }, e.prototype.resetFormPre = function() {
            return this.form.data("reset-form", !0), this.resetCheckboxesOrRadios(), this.resetSelectricSelects(), this.resetTextInputs()
        }, e.prototype.resetFilters = function() {
            var i;
            return this.form.data("reset-form", !0), this.filtersPanel.find("input:checkbox, input:radio").prop("checked", !1).change(), this.filtersPanel.find("input:text").filter(":not([disabled])").each((i = this, function(e, t) {
                var n;
                return (n = $(t)).val("").change(), i.maskedUpdateValue(n)
            })), this.filtersPanel.data("empty-filters") ? (this.form.data("reset-form", !1), window.searchFilter.updateParams()) : this.fireFormSubmit()
        }, e.prototype.resetCheckboxesOrRadios = function() {
            return this.form.find("input:checkbox, input:radio").prop("checked", !1).change()
        }, e.prototype.resetSelectricSelects = function() {
            return $(".search-row select").each(function() {
                var e, t;
                return e = $(this), t = this.multiple ? -1 : 0, e.prop("selectedIndex", t).change(), e.selectric("refresh")
            })
        }, e.prototype.resetTextInputs = function() {
            var t;
            return (t = this).form.find("input:text").filter(":not(.selectric-input)").each(function() {
                var e;
                return (e = $(this)).val("").change(), t.maskedUpdateValue(e)
            }), $(".js-search-row-input-value").text("")
        }, e.prototype.maskedUpdateValue = function(e) {
            var t;
            if (t = e.data("masked-id")) return window[t].updateValue()
        }, e.prototype.bindAreaChange = function() {
            var r;
            return r = this, [
                [".js-search-area-from", "#q_area_from"],
                [".js-search-area-to", "#q_area_to"]
            ].forEach(function(e) {
                var n, i;
                return n = e[0], i = e[1], $(n).on("input", function() {
                    return $(this).change()
                }), 
                $(n).on("change", function() {
                    var e, t;
                    // return t = $(n).not(this), $(i).add(t).val(this.value.replace(" ", "")), (e = t.closest(".js-search-row-input")).length && window.searchFormRow.setSearchInputValue(e), r.maskedUpdateValue(t)
                })
            })
        }, e.prototype.refreshBanners = function() {
            return $(".rennab").each(function() {
                var e, t;
                return t = (e = $(this)).attr("src"), e.attr("src", "").attr("src", t)
            })
        }, e.prototype.bindTryAgainLinkClick = function() {
            return $(document).on("click", ".js-search-try-again-link", (t = this, function(e) {
                return e.preventDefault(), t.fireFormSubmit()
            }));
            var t
        }, e
    }()
}.call(this),
function() {
    var e, t = function(e, t) {
            function n() {
                this.constructor = e
            }
            for (var i in t) r.call(t, i) && (e[i] = t[i]);
            return n.prototype = t.prototype, e.prototype = new n, e.__super__ = t.prototype, e
        },
        r = {}.hasOwnProperty;
    e = function(e) {
        function n() {
            this.rememberNewHistoryState = !0, n.__super__.constructor.call(this), this.bindNavigation(), this.replaceHistoryState()
        }
        return t(n, e), n.prototype.success = function(e) {
            var t;
            return n.__super__.success.call(this, e), t = e.originalEvent.detail[2], this.pushHistoryState(t.responseURL), this.rememberNewHistoryState = !0
        }, n.prototype.complete = function() {
            return n.__super__.complete.apply(this, arguments), this.resetPageParameter()
        }, n.prototype.historyStateEnabled = function() {
            return $(this.resultsSelector).children("#js-items-search").length
        }, n.prototype.replaceHistoryState = function() {
            if (this.historyStateEnabled()) return history.replaceState(this.form.serializeArray(), document.title, window.location.href), this.resetPageParameter()
        }, n.prototype.pushHistoryState = function(e) {
            if (this.historyStateEnabled() && this.rememberNewHistoryState) return history.pushState(this.form.serializeArray(), document.title, e), this.resetPageParameter()
        }, n.prototype.bindNavigation = function() {
            return $(window).on("popstate", (n = this, function(t) {
                return setTimeout(function() {
                    var e;
                    if (n.rememberNewHistoryState = !1, (e = t.originalEvent.state) && "object" == typeof e) return n.arrayToForm(e), window.searchLocations.refreshSelectedLocations(), n.fireFormSubmit();
                    document.location.reload()
                }, 100)
            }));
            var n
        }, n.prototype.arrayToForm = function(e) {
            return this.resetFormFull(), $.each(e, (o = this, function(e, t) {
                var n, i, r, a;
                if ((a = t.value).length) return r = t.name, (i = o.form.find("[name='" + r + "']")).is(":radio") || o.checkboxWithValue(i, a) ? i.filter("[value='" + a + "']").prop("checked", !0) : i.is(":checkbox") ? i.prop("checked", !0) : i.is("select") ? (i.find("[value='" + a + "']").prop("selected", !0), i.selectric("refresh")) : (i.val(a), (n = i.closest(".js-search-row-input")).length && window.searchFormRow.setSearchInputValue(n), o.maskedUpdateValue(i)), i.change()
            }));
            var o
        }, n.prototype.checkboxWithValue = function(e, t) {
            return e.is(":checkbox") && e.filter("[value='" + t + "']").length
        }, n.prototype.resetFormFull = function() {
            return this.resetFormPre(), this.resetHiddenInputs(), this.deactivateResetBtn()
        }, n.prototype.resetHiddenInputs = function() {
            return this.form.find('[type="hidden"]').each(function() {
                return $(this).val("").change()
            })
        }, n.prototype.resetPageParameter = function() {
            return setTimeout((e = this, function() {
                return e.form.find("#page").val("")
            }), 0);
            var e
        }, n
    }(window.SearchResultsLoading), $(function() {
        if ($("#new_q").length) return new e
    })
}.call(this),
function() { //location js work here 
    var e;
    e = function() {
        function e() {
            this.setActiveLocationsCityWrap(), this.refreshSelectedLocations(), this.setLocationButtonState(), this.bindCityChange(), this.bindLocationItemClick(), this.bindLocationItemParentClick(), this.bindFiltersTagDeleteClick(), this.bindLocationsTabClick(), this.bindLocationsResetFiltersClick(), this.bindLocationsButtonClick(), this.bindLocationsSearchInput(), this.bindBodyClick(), this.bindLocationsSearchReset(), this.bindLocationsPopupClose(), this.bindClosePopupByEsc()
        }
        return e.prototype.refreshSelectedLocations = function() {
            var e, t;
            return this.selectCheckedLocations(), e = this.getSelectedLocationsFromCheckboxes(), setTimeout((t = this, function() {
                var a, o;
                return a = $("#js-search-filters-tags"), o = $(".js-search-locations-city-wrap.active .js-chosen-locations-wrap"), $(e).each(function() {
                    var e, t, n, i, r;
                    return n = (e = $(this)).data("id"), i = window.searchFilter.createLocationTag(e), r = (t = $(".js-location-item, .js-location-item-parent").filter("[data-id='" + n + "']").addClass("active")).closest("[data-locations-items]").data("locations-items"), window.searchFilter.renderSelectedLocationsCount(t[0], r), o.append(e.addClass("active").clone()), a.append(i)
                }), t.setLocationsResetButtonState()
            }), 0)
        }, e.prototype.selectCheckedLocations = function() {
            var t;
            return t = this, $(".location_check_box").each(function() {
                var e;
                if ($(this).prop("checked")) return e = $(this).val(), t.getLocationItemById(e).addClass("selected"), t.relativesState(t.getLocationItemById(e).first())
            })
        }, e.prototype.getSelectedLocationsFromCheckboxes = function() {
            var e, t;
            return t = ".js-location-item.selected, .js-location-item-parent.selected", e = ".js-search-locations-city-wrap.active .js-search-locations-list-wrap", $.grep($(t, e).clone(), function(e) {
                var t, n;
                return t = $(e).data("id"), void 0 !== (n = $(".location_check_box[value='" + t + "']").filter(":not([disabled])")[0]) && n.checked
            })
        }, e.prototype.setActiveLocationsCityWrap = function() {
            return $(".js-search-locations-city-wrap").removeClass("active"), this.activeLocationsCityWrap().addClass("active")
        }, e.prototype.setLocationsResetButtonState = function() {
            var e, t;
            return t = $(".js-search-locations-reset-filters"), e = $(".js-search-locations-city-wrap.active").find(".js-chosen-locations-wrap"), 0 < $(".js-location-item, .js-location-item-parent", e).length ? t.addClass("active") : t.removeClass("active")
        }, e.prototype.cityId = function() {
            return $("#q_city_id").val()
        }, e.prototype.activeLocationsCityWrap = function() {
            return $(".js-search-locations-city-wrap[data-city-id='" + this.cityId() + "']")
        }, e.prototype.getLocationItemById = function(e) {
            return $(".js-search-locations-city-wrap.active").find(".js-search-locations-list-wrap, .js-location-dropdown").find(".js-location-item[data-id='" + e + "'], .js-location-item-parent[data-id='" + e + "']")
        }, e.prototype.setLocationButtonState = function() {
            var e, t;
            return e = this.activeLocationsCityWrap(), t = $(".js-search-filters-location"), this.hasLocations(e) ? (t.show(), $(".location_check_box").prop("disabled", !1)) : (t.hide(), $(".location_check_box").prop("disabled", !0))
        }, e.prototype.hasLocations = function(e) {
            return e.has(".js-location-item").length
        }, e.prototype.relativesState = function(e) {
            return this.parentState(e), this.descendersState(e)
        }, e.prototype.markLocation = function(e, t) {
            var n, i, r;
            return r = $(e).data("id"), n = $(".location_check_box[value='" + r + "']"), i = null != t ? t : !this.popupItemChecked(e), n.prop("checked", i), n.prop("disabled", !i), $(e).toggleClass("selected active", i)
        }, e.prototype.parentState = function(e) {
            var t, n, i, r, a;
            if (t = $(e).data("id"), (i = $(".location_check_box[value='" + t + "']").data("parent-id")) && 1 < (r = $(".location_check_box[data-parent-id='" + i + "']")).length) return a = r.filter(":checked"), n = r.length === a.length, this.markLocation(this.getLocationItemById(i), n), r.prop("disabled", n)
        }, e.prototype.descendersState = function(n) {
            var i, e, t;
            if (t = $(n).data("id"), e = $(".location_check_box[data-parent-id='" + t + "']"), i = this, 0 < e.length) return e.map(function(e, t) {
                return i.getLocationItemById($(t).val())
            }).each(function(e, t) {
                return i.markLocation(t, i.popupItemChecked(n))
            }), e.each(function(e, t) {
                return $(t).prop("disabled", i.popupItemChecked(n))
            })
        }, e.prototype.popupItemChecked = function(e) {
            return $(e).hasClass("selected")
        }, e.prototype.bindCityChange = function() {
            return $("#q_city_id").on("selectric-change selectric-refresh", (e = this, function() {
                return e.searchLocationsReset(), $(".location_check_box").prop("checked", !1)
            }));
            var e
        }, e.prototype.bindLocationItemClick = function() {
            return $(document).on("click", ".js-location-item", function(e) {
                var t, n, i, r, a, o, s, l, u, c;
                if (u = (t = $(this)).closest(".js-search-locations-city-wrap"), o = u.find(".js-chosen-locations-wrap"), c = $(".js-search-locations-reset-filters"), a = t.data("id"), r = t.closest(".search-locations__list_item-wrap"), t.closest(".js-location-dropdown, .js-chosen-locations-wrap").length && (r = $(".js-search-locations-list-wrap", u).find("[data-id='" + a + "']").closest(".search-locations__list_item-wrap")), l = (s = r.find(".js-location-item-parent")).data("id"), u.find("[data-id='" + a + "']").toggleClass("active"), t.hasClass("active") ? (t.clone().removeAttr("style").appendTo(o), c.addClass("active")) : (o.find("[data-id='" + a + "']").remove(), $(".js-search-locations-list-wrap, .js-location-dropdown").find("[data-id='" + a + "']").removeClass("active"), o.find("[data-id='" + l + "']").remove(), t.closest(".js-location-dropdown").length && t.siblings(".js-location-item-parent").removeClass("active")), -1 !== Array.from(e.target.classList).indexOf("js-location-item-township") && (i = $(".js-location-item", r), n = $(".js-location-item.active", r), i.length === n.length ? (i.each(function() {
                        var e;
                        return e = $(this).data("id"), $(o).find("[data-id='" + e + "']").remove()
                    }), u.find("[data-id='" + l + "']").addClass("active"), s.clone().appendTo(o), c.addClass("active")) : n.length === i.length - 1 && s.hasClass("active") ? (s.removeClass("active"), o.find("[data-id='" + s.data("id") + "']").remove(), n.each(function() {
                        return $(this).clone().appendTo(o)
                    })) : (s.removeClass("active"), o.find("[data-id='" + s.data("id") + "']").remove()), 0 === $(".js-location-item, .js-location-item-parent", ".js-chosen-locations-wrap").length)) return c.removeClass("active")
            })
        }, e.prototype.bindLocationItemParentClick = function() {
            return $(document).on("click", ".js-location-item-parent", function() {
                var e, t, n, i, r, a;
                if (e = $(this), r = e.closest(".search-locations__city-wrap"), i = r.find(".js-chosen-locations-wrap"), t = e.nextAll(".js-location-item"), n = e.data("id"), a = $(".js-search-locations-reset-filters"), e.closest(".js-location-dropdown, .js-chosen-locations-wrap").length && (t = $(".js-search-locations-list-wrap", r).find("[data-id='" + n + "']").nextAll(".js-location-item")), r.find("[data-id='" + n + "']").toggleClass("active"), e.hasClass("active") ? (e.clone().removeAttr("style").appendTo(i), t.each(function() {
                        var e;
                        return e = $(this).data("id"), r.find("[data-id='" + e + "']").addClass("active"), i.find("[data-id='" + e + "']").remove()
                    }), a.addClass("active")) : (i.find("[data-id='" + n + "']").remove(), r.find("[data-id='" + n + "']").removeClass("active"), t.each(function() {
                        var e;
                        return e = $(this).data("id"), r.find("[data-id='" + e + "']").removeClass("active")
                    })), 0 === $(".js-location-item, .js-location-item-parent", i).length) return a.removeClass("active")
            })
        }, e.prototype.bindFiltersTagDeleteClick = function() {
            return $(document).on("click", ".js-search-filters-tag-delete", (a = this, function(e) {
                var t, n, i, r;
                return (r = $(e.currentTarget)).remove(), t = r.data("id"), n = $(".js-location-item, .js-location-item-parent").filter("[data-id='" + t + "']"), $(".js-chosen-locations-wrap").find("[data-id='" + t + "']").remove(), a.markLocation(n), a.relativesState(n), i = (n = $(".js-search-locations-city-wrap.active .js-search-locations-list-wrap").find("[data-id='" + t + "']")).closest("[data-locations-items]").data("locations-items"), window.searchFilter.renderSelectedLocationsCount(n, i, "delete"), window.searchFilter.updateParams()
            }));
            var a
        }, e.prototype.searchLocationsReset = function() {
            return $(".js-chosen-locations-wrap").empty(), $("#js-search-locations .js-location-item-parent").removeClass("active selected"), $("#js-search-locations .js-location-item").removeClass("active selected"), window.searchFilter.clearForm(!1)
        }, e.prototype.searchLocationsRemove = function(e) {
            var t;
            if ((t = $(".js-chosen-locations-wrap")).find("[data-id='" + e + "']").remove(), $(".js-search-locations-list-wrap").find("[data-id='" + e + "']").removeClass("active"), 0 === t.children().length) return $(".js-search-locations-reset-filters").removeClass("active")
        }, e.prototype.bindLocationsTabClick = function() {
            return $("[data-locations-tab]").on("click", function() {
                var e, t, n, i;
                return i = $(this).closest(".search-container"), n = $("[data-locations-tab]", i), e = $(this).data("locations-tab"), t = $("[data-locations-items]", i), n.removeClass("active"), t.removeClass("active"), $(".js-locations-tabs").find("[data-locations-tab='" + e + "']").addClass("active"), $(".location_group__" + e).addClass("active")
            })
        }, e.prototype.bindLocationsResetFiltersClick = function() {
            return $(".js-search-locations-reset-filters").on("click", (e = this, function() {
                return e.searchLocationsReset(), $(".location_check_box").prop("checked", !1), $(".js-chosen-locations-wrap").empty(), $(".js-search-locations-reset-filters").removeClass("active"), window.searchFilter.updateParams(), $("#js-search-locations").trigger("reveal:close")
            }));
            var e
        }, e.prototype.sendCheckedLocations = function(e) {
            var t;
            return t = this, $(".location_check_box").each(function() {
                return $(this).prop("checked", !1)
            }), e.each(function() {
                var e;
                return e = $(this).data("id"), t.markLocation(t.getLocationItemById(e), !0), t.relativesState(t.getLocationItemById(e))
            })
        }, e.prototype.bindLocationsButtonClick = function() {
            return $(".js-search-locations-button").on("click", (i = this, function(e) {
                var t, n;
                return n = $(e.currentTarget).prev(".js-chosen-locations-wrap"), t = $(".js-location-item, .js-location-item-parent", n), window.searchFilter.clearForm(!1), i.sendCheckedLocations(t), window.searchFilter.updateLocations(t), window.searchFilter.updateParams(), $("#js-search-locations").trigger("reveal:close")
            }));
            var i
        }, e.prototype.bindLocationsSearchInput = function() {
            return $(".js-search-locations-search-input").on("input keydown", function() {
                var e, t, n, i, r, a, o;
                e = $(".js-search-locations-city-wrap.active"), t = $(".search-locations__tabs_tab.active", e).data("locations-tab"), r = (o = $(".js-location-dropdown", e)).find(".search-locations__search-dropdown_group[data-group-name='" + t + "']"), n = "^" + $(this).val().toLowerCase(), i = (a = 0) === this.value.length, $(".js-location-item, .js-location-item-parent", r).each(function() {
                    return $(this).text().toLowerCase().trim().search(new RegExp(n)) < 0 ? $(this).hide() : ($(this).show(), a++)
                }), 0 < a ? o.removeClass("hide") : o.addClass("hide"), i && o.addClass("hide"), $(this).toggleClass("hide", i)
            }).trigger("input")
        }, e.prototype.bindBodyClick = function() {
            var a;
            if (a = ".js-search-locations-search-input", $(a).length) return $("body").on("click", function(e) {
                var t, n, i, r;
                if (t = $(".js-search-locations-city-wrap.active"), n = $(".js-location-dropdown", t), r = $(e.target).is(a), i = $(e.target).is(".js-location-dropdown .js-location-item, .js-location-dropdown .js-location-item-parent"), !r && !i) return n.addClass("hide")
            })
        }, e.prototype.bindLocationsSearchReset = function() {
            return $(".search-locations__search-reset").on("click", function() {
                return $(this).siblings(".js-search-locations-search-input").val("").addClass("hide")
            })
        }, e.prototype.bindLocationsPopupClose = function() {
            return $(document).on("click", ".search-container .close-reveal-modal, .search-container .reveal-modal-bg", (e = this, function() {
                return e.popupCloseWithoutApply()
            }));
            var e
        }, e.prototype.bindClosePopupByEsc = function() {
            return $(document).on("keydown", (t = this, function(e) {
                if (27 === e.keyCode && $("#js-search-locations").hasClass("reveal-modal_opened")) return t.popupCloseWithoutApply()
            }));
            var t
        }, e.prototype.popupCloseWithoutApply = function() {
            return setTimeout((t = this, function() {
                var e;
                return $(".js-chosen-locations-wrap").empty(), $("#js-search-locations .js-location-item-parent").removeClass("active selected"), $("#js-search-locations .js-location-item").removeClass("active selected"), t.selectCheckedLocations(), e = t.getSelectedLocationsFromCheckboxes(), setTimeout(function() {
                    var n;
                    return n = $(".js-search-locations-city-wrap.active .js-chosen-locations-wrap"), $(e).each(function() {
                        var e, t;
                        return t = (e = $(this)).data("id"), $(".js-search-locations-city-wrap.active").find("[data-id='" + t + "']").addClass("active"), n.append(e.addClass("active").clone())
                    })
                }, 0), t.setLocationsResetButtonState()
            }), 300);
            var t
        }, e
    }(), $(function() {
        if ($("#new_q").length) return window.searchLocations = new e
    })
}.call(this),//!location js end
function() {
    var e;
    e = function() {
        function e() {
            this.initializeSelectric()
        }
        return e.prototype.initializeSelectric = function() {
            return $(".js-selectric").selectric({
                responsive: !0,
                arrowButtonMarkup: "<span class='button'></span>",
                nativeOnMobile: !1,
                maxHeight: 386,
                onInit: (n = this, function(e) {
                    return setTimeout(function() {
                        return n.toggleResetBtnState(e)
                    }, 100)
                }),
                labelBuilder: function(e) {
                    var t, n, i, r;
                    return (t = e.element.closest("select")).closest(".selectric-multiple"), n = 0 === e.index, void 0 !== t.data("label") && n ? t.data("label") : "q_room_ids" === t.prop("id") && Array.isArray(t.val()) && 1 < t.val().length ? (r = e.text.substring(2), i = t.val()[t.val().length - 1], e.value === i ? e.value.replace(/\D+$/, "") + " " + r : e.value) : e.text
                },
                optionsItemBuilder: (i = this, function(e, n, t) {
                    return 0 === t && n[0].multiple && setTimeout(function() {
                        var e, t;
                        return (t = (e = $(n)).closest(".selectric-multiple").find('.selectric-items li[data-index="0"]')).addClass("selectric-reset-all"), i.bindClickSelectricResetAll(t, e), i.toggleResetBtnState(n)
                    }, 100), "<span>" + e.text + "</span>"
                }),
                onChange: (r = this, function(n) {
                    var i;
                    if ((i = $(n)).trigger("change"), i.closest(".selectric-multiple").length) return i.closest(".selectric-multiple").find(".label").css("color", "transparent"), setTimeout(function() {
                        var e, t;
                        return t = (e = i.closest(".selectric-multiple").find(".label")).text().split(", ").sort().join(", "), e.text(t), e.removeAttr("style"), r.toggleResetBtnState(n)
                    }, 100)
                }),
                onOpen: (t = this, function(e) {
                    return setTimeout(function() {
                        return t.setSelectricItemsWidth(e)
                    }, 0)
                })
            });
            var t, r, i, n
        }, e.prototype.bindClickSelectricResetAll = function(t, n) {
            return t.on("click", (i = this, function(e) {
                return e.preventDefault(), e.stopPropagation(), t.addClass("selected"), n.val([]), n.selectric("refresh"), i.bindLabelClick()
            }));
            var i
        }, e.prototype.toggleResetBtnState = function(e) {
            var t, n;
            if ((n = (t = $(e)).closest(".selectric-multiple").find(".selectric-reset-all")).length) return Array.isArray(t.val()) && 0 < t.val().length ? n.removeClass("selected") : n.addClass("selected")
        }, e.prototype.bindLabelClick = function() {
            return $(document).one("click", ".selectric", function() {
                var e;
                if ((e = $(this).closest(".selectric-multiple").find("select")).length) return e.selectric("open")
            })
        }, e.prototype.setSelectricItemsWidth = function(e) {
            var t, n, i, r, a, o, s, l, u;
            if (n = (t = (r = $(e).closest(".selectric-wrapper")).find(".selectric-items")).find("ul li span"), i = t.find("ul"), u = r.find(".selectric").width(), o = t.width() - i.width(), t.width("auto"), s = t.width() < u, l = t.width() - u < 5, a = Math.max.apply(Math, n.map(function() {
                    return $(this).outerWidth()
                }).get()), (s || l) && t.outerWidth(u), t.width() < a + o) return t.outerWidth(a + o)
        }, e
    }(), $(function() {
        if ($("#new_q").length) return new e
    })
}.call(this),
function() {
    $(function() {
        return $(document).on("change", "#sorting_dropdown.custom", function(e) {
            var t;
            return t = $(e.currentTarget).find(":selected"), window.location.search = "sorting=" + t.val()
        }), $(".residences_sorting #sort_by > option:first").hide()
    })
}.call(this),
function() {
    var e;
    e = function(e) {
        var t, n, i, r;
        if (!(t = $(e)).hasClass("active")) return i = $(".statistics .content .active"), r = $(".statistics .header .active"), n = $('a[href="' + e + '"]').parent("li"), r.removeClass("active"), n.addClass("active"), i.removeClass("active"), t.addClass("active")
    }, $(function() {
        return window.location.hash && e(window.location.hash), $(document).on("click", ".statistics .header a", function() {
            return e($(this).attr("href"))
        })
    })
}.call(this),
function() {
    var i;
    i = function(e, n, i, r) {
        return e.find(".price").each(function(e, t) {
            return n ? ($(t).find(".price-val").text($(t).attr(i)), $(t).find(".price-cur").after("<span class='unit-az'>/m\xb2</span><span class='unit-ru'>/\u043c\xb2</span>")) : ($(t).find(".price-val").text($(t).attr(r)), $(t).find(".unit-az, .unit-ru").remove())
        })
    }, $(function() {
        var n;
        if (n = ".left_case, .right_case", $("#js-main-col").on("click", n, function() {
                var e, t;
                if ((e = $(this)).parent().find(n).toggleClass("active_link"), t = e.hasClass("left_case"), i(e.closest(".js-switcher-container"), t, "data-sqm", "data-full-price"), 0 < $(".residences_sorting").length) return $("#sqm_format").val(t)
            }), 0 < $(".residences_sorting").length && "true" === $("#sqm_format").val()) return $(".left_case, .right_case").removeClass("active_link"), $(".right_case").addClass("active_link"), i($(".js-switcher-container"), !0, "data-sqm", "data-full-price")
    })
}.call(this),
function() {
    $(function() {
        return $(".tab").on("click", function(e) {
            if (e.preventDefault(), $(".tab_selected")[0] !== $(this)[0]) return $(".tab_selected").removeClass("tab_selected"), $(this).addClass("tab_selected"), $(".tab-content_selected").removeClass("tab-content_selected"), $($(this).attr("href")).addClass("tab-content_selected")
        })
    })
}.call(this),
function() {
    $(document).on("click", "a[data-toggle]", function(e) {
        var t;
        return e.preventDefault(), e.stopPropagation(), t = $(this).attr("href"), $(t).toggle()
    }), $(document).on("click", "a[data-slide-toggle]", function(e) {
        var t;
        return e.preventDefault(), t = $(this).attr("href"), $(t).slideToggle()
    }), $(document).on("click", "*[data-checkbox-mirror]", function(e) {
        var t;
        return e.preventDefault(), (t = $(this).find(":checkbox")).prop({
            checked: !t.prop("checked")
        }), $(this).toggleClass("selected")
    })
}.call(this),
function() {
    window.MakeVippedAd = function() {
        function e() {
            this.bindRevealOpen(), this.bindModalAdSelectFormSubmit(), this.bindVipItClick(), this.bindModalPayFormSubmit(), this.openModalIfHashIsVipped()
        }
        return e.prototype.bindRevealOpen = function() {
            return $("#vipped_modal.modal-ad-select").on("reveal:open", function() {
                return setTimeout(function() {
                    return $("#vip_ad_number").trigger("focus")
                }, 0)
            })
        }, e.prototype.bindModalAdSelectFormSubmit = function() {
            return $("#vipped_modal.modal-ad-select form").on({
                submit: function(e) {
                    var t;
                    if (e.preventDefault(), t = $("#vip_ad_number").val(), /^\d+$/.test(t)) return window.location = "/items/" + t + "#vipped"
                }
            })
        }, e.prototype.bindVipItClick = function() {
            return $("#vip_it").on({
                click: function() {
                    return $("#vipped_modal").reveal({
                        animation: "fade"
                    }), !1
                }
            })
        }, e.prototype.bindModalPayFormSubmit = function() {
            return $("#vipped_modal .pay form").on({
                submit: function() {
                    return history.pushState(null, document.title, "#vipped")
                }
            })
        }, e.prototype.openModalIfHashIsVipped = function() {
            if ("#vipped" === window.location.hash) return $("#vipped_modal").reveal({
                animation: "fade"
            })
        }, e
    }(), $(function() {
        return new window.MakeVippedAd
    })
}.call(this),
function() {
    var i, r;
    i = function() {
        return $(".amount").filter(":checked").each(function() {
            return this.checked = !1, this.setAttribute("checked", !1)
        })
    }, r = function(e) {
        var t, n, i, r, a, o;
        if (t = e.find(".custom-price_input"), 0 < e.find(".amount-container input[type=radio]").filter(":checked").length) return e.submit();
        switch (a = null, o = t.val(), i = t.data("errors"), r = e.parent().is("[data-provider=portmanat]"), !1) {
            case 0 !== o.length:
                a = i.empty;
                break;
            case !(o < 1):
                a = i.minimum;
                break;
            case !(1e3 < o && r):
                a = i.portmanat;
                break;
            case !(5e3 < o):
                a = i.maximum;
                break;
            default:
                a = null
        }
        return null !== a ? (n = "<span class='custom-price_error'>" + a + "</span>", t.addClass("error"), t.parent().find(".custom-price_error").remove(), t.parent().append(n)) : (t.removeClass("error"), t.parent().find(
            ".custom-price_error").remove(), t.val(+o), window.masks.map(function(e) {
            return e.updateValue()
        }), e.submit())
    }, $(function() {
        var e, n, t;
        if (n = $(".custom-price_input"), t = $(".custom-price_placeholder"), 0 < n.length) return t.on("click", function() {
            return n.trigger("focus")
        }), e = $(".js-custom-price-placeholder"), n.on("change input", function() {
            return e.empty(), $("<input>").attr("type", "hidden").attr("name", "payment[amount]").attr("value", $(this).val()).appendTo(e), $("<input>").attr("type", "hidden").attr("name", "payment[service_id]").attr("value", "wallet").appendTo(e)
        }).on("focus", function() {
            return t.addClass("input-focus"), i()
        }).on("focusout", function() {
            return 0 === $(this).val().length ? (n.attr("data-checked", !1), t.removeClass("input-focus"), e.empty()) : n.attr("data-checked", !0)
        }).on("paste", function(e) {
            return e.preventDefault()
        }).on("keypress", function(e) {
            if (13 === e.which) return r($(this).closest("[data-provider]"))
        }), $(".amount").on("click", function() {
            return e.empty(), n.val(""), n.trigger("focusout"), n.removeClass("error"), n.parent().find(".custom-price_error").remove()
        }), $(".az-payments-form-i input, .custom-price_input").on("click input change", function() {
            var t, e;
            return t = null, (e = $(this).parents("[data-provider]").find(".custom-price_input").val()) && 0 < e.length && (t = e), n.removeClass("error"), n.parent().find(".custom-price_error").remove(), n.val(t), t && window.masks.map(function(e) {
                return e.typedValue = t.toString()
            })
        }), $(".profile-wallet_pay_form-container").find("button").on("click", function(e) {
            return e.preventDefault(), r($(this).closest("[data-provider]").find("form"))
        }), window.masks = [], n.each(function() {
            return window.masks.push(new window.IMask(this, {
                mask: "0000"
            }))
        }), $(".close-modal").on("click", function() {
            return $(this).closest(".reveal-modal_opened").trigger("reveal:close")
        })
    })
}.call(this),
function() {
    window.adriverExtentionLoad = function(e, t, n) {
        if (0 === e) return document.getElementById(n).style.height = "0"
    }
}.call(this),
function() {
    $(function() {
        var i, e, n, r, t, a;
        return $(".loading").hide(), e = $("body"), r = ".agency-filters-i", t = ".js-agencies-row-show-group", a = ".agencies_sorting", i = $(".agency-filters"), n = function() {
            return $("html, body").animate({
                scrollTop: i.offset().top
            }, 200)
        }, e.on("ajax:beforeSend", r, function() {
            var e;
            return e = $(this).closest(".agency-filters-section").find(".agency-filters--results"), $(r).removeClass("active"), $(this).addClass("active"), this.loading_timeout = setTimeout(function() {
                return e.find(".loading").show(), i.addClass("blocked")
            }, 500)
        }), e.on("ajax:success", r, function(e) {
            var t, n;
            return n = e.originalEvent.detail[2], t = $(this).closest(".agency-filters-section").find(".agency-filters--results"), clearTimeout(this.loading_timeout), t.html(n.responseText), t.find(".loading").hide(), i.removeClass("blocked"), window.turnBookmarkingOn($(".items-i")), window.initializeSwipeCarousel()
        }), e.on("ajax:error", r, function() {
            var e;
            return e = $(this).closest(".agency-filters-section").find(".agency-filters--results"), clearTimeout(this.loading_timeout), e.find(".loading").hide(), i.removeClass("blocked")
        }), e.on("click", ".js-agencies-row-show-all", function(e) {
            var t;
            return e.preventDefault(), t = $(this).attr("data-category"), i.find('[data-category="' + t + '"]')[0].click(), n()
        }), e.on("click", t, function(e) {
            var t;
            return e.preventDefault(), $(r).removeClass("active"), t = $(this).attr("data-category"), i.find('[data-category="' + t + '"]').addClass("active"), n()
        }), e.on("ajax:beforeSend", a, function() {
            var e;
            return e = $(this).closest(".agency-filters-section").find(".agency-filters--results"), this.loading_timeout = setTimeout(function() {
                return e.find(".loading").show(), i.addClass("blocked")
            }, 500)
        }), e.on("ajax:success", a, function(e) {
            var t, n;
            return n = e.originalEvent.detail[2], t = $(this).closest(".agency-filters-section").find(".agency-filters--results"), clearTimeout(this.loading_timeout), t.find(".agencies-row--list").html(n.responseText), t.find(".loading").hide(), i.removeClass("blocked"), window.turnBookmarkingOn($(".items-i")), window.initializeSwipeCarousel()
        }), e.on("ajax:error", a, function() {
            var e;
            return e = $(this).closest(".agency-filters-section").find(".agency-filters--results"), clearTimeout(this.loading_timeout), e.find(".loading").hide(), i.removeClass("blocked")
        }), e.on("ajax:beforeSend", t, function() {
            var e;
            return e = $(this).closest(".agency-filters--results"), this.loading_timeout = setTimeout(function() {
                return e.find(".loading").show(), i.addClass("blocked")
            }, 500)
        }), e.on("ajax:success", t, function(e) {
            var t, n;
            return n = e.originalEvent.detail[2], t = $(this).closest(".agency-filters--results"), clearTimeout(this.loading_timeout), t.html(n.responseText), t.find(".loading").hide(), i.removeClass("blocked"), window.turnBookmarkingOn($(".items-i")), window.initializeSwipeCarousel()
        }), e.on("ajax:error", t, function() {
            var e;
            return e = $(this).closest(".agency-filters--results"), clearTimeout(this.loading_timeout), e.find(".loading").hide(), i.removeClass("blocked")
        })
    })
}.call(this),
function() {
    window.clearBookmarksData = function() {
        return $("[data-user-bookmark-ids]").remove()
    }, window.turnBookmarkingOn = function(e) {
        return 0 < $(".bookmarks").length ? $(".bookmarks").on({
            "ajax:success": function() {
                var e;
                return e = $(this).closest(".items-i"), $(".bookmarks").fadeOut("fast", function() {
                    if (e.remove(), $(".bookmarks").fadeIn(), !$(".bookmarks .items-i").length) return $(".bookmarks").addClass("empty")
                })
            }
        }, ".remove_bookmark") : e.find(".bookmarking").on({
            "ajax:beforeSend": function() {
                var e;
                return (e = $(this).closest(".bookmarking")).data("loading", !0), setTimeout(function() {
                    if (e.data("loading")) return e.addClass("loading")
                }, 500)
            },
            "ajax:error": function() {
                return alert("Error. Please try again")
            },
            "ajax:success": function(e) {
                var t;
                return t = e.originalEvent.detail[0], $(this).closest(".bookmarking").data("loading", !1).removeClass("loading").toggleClass("added").html(t)
            }
        }, ".add_bookmark, .remove_bookmark"), $("[data-user-bookmark-ids]").each(function() {
            var e, t, n;
            return e = $(this).attr("data-user-bookmark-ids"), n = '<a class="remove_bookmark" data-remote="true" data-remote="true" rel="nofollow" data-method="delete" href="/bookmarks/', t = '?card_view=true"></a>', $(e).each(function() {
                var e;
                return e = $(this).attr("data-item-id"), $(this).find(".bookmarking").each(function() {
                    return $(this).addClass("added").html(n + e + t)
                })
            })
        })
    }, $(function() {
        return window.turnBookmarkingOn($(".items-i, #js-item-show"))
    })
}.call(this),
function() {
    var e;
    e = function() {
        return $(".ad-form .btn").off("click.btn_loading").on("click.btn_loading", function() {
            return $(this).addClass("btn_loading")
        })
    }, $(function() {
        return e(), $(document).on("setup", e)
    })
}.call(this),
function() {
    $.fn.clear_form_errors = function() {
        return this.find("span.error").text("")
    }, $.fn.clear_form_fields = function() {
        return this.find("[type='text'], [type='tel'], [type='email'], [type='range']").prop({
            value: ""
        }), this.find("[type='radio'], [type='checkbox']").prop({
            checked: !1
        })
    }, $.fn.render_form_errors = function(i, e) {
        var r;
        return (r = this).clear_form_errors(), $.each(e, function(t, e) {
            var n;
            return (n = r.find("input, select, textarea").filter(function() {
                var e;
                if (e = $(this).attr("name")) return e.match(new RegExp(i + "\\[" + t + "\\(?"))
            })).parent().addClass("has-error"), n.parent().find("span.error").text($.map(e, function(e) {
                return e.charAt(0).toUpperCase() + e.slice(1)
            }).join("<br />"))
        })
    }
}.call(this),
function() {
    $(function() {
        return $("[data-real-value]").each(function() {
            var e;
            return (e = $(this)).val(e.attr("data-real-value"))
        })
    })
}.call(this),
function() {
    var e, t;
    t = function() {
        var e;
        if ((e = $("#item_floor, #item_floors, #item_price")).length) return e.each(function() {
            return new window.IMask(this, {
                mask: Number,
                signed: !1,
                scale: 0
            })
        })
    }, e = function() {
        var e;
        if ((e = $(".js-square-validate")).length) return e.each(function() {
            return new window.IMask(this, {
                mask: Number,
                scale: 2,
                signed: !1,
                normalizeZeros: !0,
                radix: ".",
                mapToRadix: [","]
            })
        })
    }, $(function() {
        return t(), e()
    })
}.call(this),
function() {
    window.Detector = {
        phoneOrTablet: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
        android: /Android/i.test(navigator.userAgent),
        ios: /iPhone|iPad|iPod/i.test(navigator.userAgent),
        svg: document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image", "1.1")
    }
}.call(this),
function(c) {
    c(function() {
        c(document).on("click", "[data-reveal-id]", function(e) {
            e.preventDefault();
            var t = c(this).attr("data-reveal-id");
            c("#" + t).reveal(c(this).data())
        })
    }), c.fn.reveal = function(u) {
        var e = {
            animation: "fadeAndPop",
            animationSpeed: 300,
            closeOnBackgroundClick: !0,
            dismissModalClass: "close-reveal-modal"
        };
        return u = c.extend({}, e, u), this.each(function() {
            function e() {
                l.off("click.modalEvent"), c("." + u.dismissModalClass).off("click.modalEvent"), s || (i(), r = (c(window).height() - o) / 2, "fadeAndPop" != u.animation && "fade" != u.animation || a.addClass("reveal-modal_opening"), "fadeAndPop" == u.animation && (a.css({
                    top: 0 - o + "px",
                    opacity: "0",
                    visibility: "visible"
                }), l.fadeIn(u.animationSpeed / 2), a.delay(u.animationSpeed / 2).animate({
                    top: r + "px",
                    opacity: 1
                }, u.animationSpeed, function() {
                    n(), a.removeClass("reveal-modal_opening").addClass("reveal-modal_opened")
                })), "fade" == u.animation && (a.css({
                    opacity: "0",
                    visibility: "visible",
                    top: r + "px"
                }), l.fadeIn(u.animationSpeed / 2), a.delay(u.animationSpeed / 2).animate({
                    opacity: "1"
                }, u.animationSpeed, function() {
                    n(), a.removeClass("reveal-modal_opening").addClass("reveal-modal_opened")
                })), "none" == u.animation && (a.css({
                    visibility: "visible",
                    top: r + "px"
                }), l.css({
                    display: "block"
                }), n(), a.addClass("reveal-modal_opened"))), a.off("reveal:open", e)
            }

            function t() {
                if (s) return !1;
                i(), r = (c(window).height() - o) / 2, "fadeAndPop" != u.animation && "fade" != u.animation || a.addClass("reveal-modal_closing"), "fadeAndPop" == u.animation && (l.delay(u.animationSpeed).fadeOut(u.animationSpeed), a.animate({
                    top: 0 - o + "px",
                    opacity: "0"
                }, u.animationSpeed / 2, function() {
                    a.css({
                        top: r + "px",
                        opacity: "1",
                        visibility: "hidden"
                    }), n(), a.removeClass("reveal-modal_opened reveal-modal_closing")
                })), "fade" == u.animation && (l.delay(u.animationSpeed).fadeOut(u.animationSpeed), a.animate({
                    opacity: "0"
                }, u.animationSpeed, function() {
                    a.css({
                        opacity: "1",
                        visibility: "hidden",
                        top: r + "px"
                    }), n(), a.removeClass("reveal-modal_opened reveal-modal_closing")
                })), "none" == u.animation && (a.css({
                    visibility: "hidden",
                    top: r + "px"
                }), l.css({
                    display: "none"
                }), a.removeClass("reveal-modal_opened")), a.off("reveal:close", t)
            }

            function n() {
                s = !1
            }

            function i() {
                s = !0
            }
            var r, a = c(this),
                o = a.height(),
                s = !1,
                l = c(".reveal-modal-bg");
            0 == l.length && (l = c('<div class="reveal-modal-bg" />').insertAfter(a)).fadeTo("fast", "0.8"), a.on("reveal:open", e), a.on("reveal:close", t), a.trigger("reveal:open");
            c("." + u.dismissModalClass).on("click.modalEvent", function() {
                a.trigger("reveal:close")
            });
            u.closeOnBackgroundClick && (l.css({
                cursor: "pointer"
            }), l.on("click.modalEvent", function() {
                a.trigger("reveal:close")
            })), c("body").on("keyup", function(e) {
                27 === e.which && a.trigger("reveal:close")
            })
        })
    }
}(jQuery),
function() {
    $(function() {
        var e;
        if (0 < $(".item-edit_photos-btn").length) return e = $(".item-edit_photos-btn"), $(".pond-img-list").prepend(e), e.css({
            display: "inline-block"
        }), e.on("click", function() {
            return $(".pond-new-img-button").trigger("click")
        }), $(document).on("click", ".pond-img-delete", function() {
            return setTimeout(function() {
                if (0 === $(".pond-img-list").find(".pond-img").length) return e.addClass("item-edit_photos-btn--centered")
            }, 200)
        }).on("change", ".pond-new-img-field", function() {
            return setTimeout(function() {
                if (0 < $(".pond-img-list").find(".pond-img").length) return e.removeClass("item-edit_photos-btn--centered")
            }, 200)
        })
    })
}.call(this),
function() {
    Detector.phoneOrTablet || (document.documentElement.className += " is-hover")
}.call(this),
function() {
    window.MakeFeaturedAd = function() {
        function e() {
            this.bindRevealOpen(), this.bindModalAdSelectFormSubmit(), this.bindModalPayFormSubmit(), this.openModalIfHashIsFeatured()
        }
        return e.prototype.bindRevealOpen = function() {
            return $(".modal-ad-select").on("reveal:open", function() {
                return setTimeout(function() {
                    return $("#ad_number").trigger("focus")
                }, 0)
            })
        }, e.prototype.bindModalAdSelectFormSubmit = function() {
            return $(".modal-ad-select form").on({
                submit: function(e) {
                    var t;
                    if (e.preventDefault(), t = $("#ad_number").val(), /^\d+$/.test(t)) return window.location = "/items/" + t + "#featured"
                }
            })
        }, e.prototype.bindModalPayFormSubmit = function() {
            return $("#modal .pay form").on({
                submit: function() {
                    return history.pushState(null, document.title, "#featured")
                }
            })
        }, e.prototype.openModalIfHashIsFeatured = function() {
            if ("#featured" === window.location.hash) return $("#modal").reveal({
                animation: "fade"
            })
        }, e
    }(), $(function() {
        return new window.MakeFeaturedAd
    })
}.call(this),
function() {
    var e;
    e = function() {
        function e(e) {
            this.LOADER = "<div id='js-home-page-row-loading' class='home-page-row-loading'><span></span><span></span><span></span></div>", this.ajaxPending = !1, this.container = e, this.containerJq = $(e), this.itemsCount = $(".items-i").length, this.updateCurrentPosition(), this.loadSection(this.position), this.bindScroll()
        }
        return e.prototype.updateCurrentPosition = function() {
            return this.position = $("[data-row-position]").filter(":last").data("row-position")
        }, e.prototype.loadSection = function(e) {
            var t, n, i;
            if (this.loadSectionCondition()) return this.ajaxPending = !0, $.ajax({
                url: "/rows/" + e + "/next",
                method: "GET",
                dataType: "html",
                context: this.containerJq[0],
                beforeSend: (i = this, function() {
                    return i.containerJq.append(i.LOADER), i.itemsCount = $(".items-i").length, i.setFiltersBgHeight()
                }),
                success: (n = this, function(e) {
                    var t;
                    return n.containerJq.find("#js-home-page-row-loading").remove(), n.containerJq.append(e), n.ajaxPending = !1, t = $(".items-i").slice(n.itemsCount), n.updateCurrentPosition(), n.loadSection(n.position), n.initializeScripts(t)
                }),
                error: (t = this, function() {
                    return t.containerJq.find("#js-home-page-row-loading").remove()
                })
            })
        }, e.prototype.loadSectionCondition = function() {
            var e, t;
            return e = 0 < $("section[data-last-row='true']").length, t = "/" === window.location.pathname, $("#js-main-col").hasClass("loading"), this.loadPointReached($(this.container)) && !this.ajaxPending && !e && t
        }, e.prototype.loadPointReached = function(e) {
            return $(window).scrollTop() >= e.offset().top + e.outerHeight() - window.innerHeight
        }, e.prototype.initializeScripts = function(e) {
            var t;
            return window.initializeSwipeCarousel(), window.turnBookmarkingOn(e), 0 < (t = $(".js-slider-row").filter(":last").find(".row-slider_btn")).length && new window.RowSlider(t), this.setFiltersBgHeight()
        }, e.prototype.bindScroll = function() {
            return $(window).on("scroll", (e = this, function() {
                return e.loadSection(e.position)
            }));
            var e
        }, e.prototype.setFiltersBgHeight = function() {
            return setTimeout(function() {
                return window.searchFormRow.setFiltersBgHeight()
            }, 200)
        }, e
    }(), $(function() {
        if ("/" === window.location.pathname) return new e("#js-main-col")
    })
}.call(this)
