/*
 * International Telephone Input v10.0.2
 * https://github.com/jackocnr/intl-tel-input.git
 * Licensed under the MIT license
 */
! function(a) {
    "function" == typeof define && define.amd ? define(["jquery"], function(b) {
        a(b, window, document)
    }) : "object" == typeof module && module.exports ? module.exports = a(require("jquery"), window, document) : a(jQuery, window, document)
}(function(a, b, c, d) {
    "use strict";

    function e(b, c) {
        this.a = a(b), this.b = a.extend({}, h, c), this.ns = "." + f + g++, this.d = Boolean(b.setSelectionRange), this.e = Boolean(a(b).attr("placeholder"))
    }
    var f = "intlTelInput",
        g = 1,
        h = {
            allowDropdown: !0,
            autoHideDialCode: !0,
            autoPlaceholder: "polite",
            customPlaceholder: null,
            dropdownContainer: "",
            excludeCountries: [],
            formatOnDisplay: !0,
            geoIpLookup: null,
            initialCountry: "",
            nationalMode: !0,
            onlyCountries: [],
            placeholderNumberType: "MOBILE",
            preferredCountries: ["az"],
            separateDialCode: !1,
            utilsScript: ""
        },
        i = {
            b: 38,
            c: 40,
            d: 13,
            e: 27,
            f: 43,
            A: 65,
            Z: 90,
            j: 32,
            k: 9
        },
        j = ["800", "822", "833", "844", "855", "866", "877", "880", "881", "882", "883", "884", "885", "886", "887", "888", "889"];
    a(b).on("load", function() {
        a.fn[f].windowLoaded = !0
    }), e.prototype = {
        _a: function() {
            return this.b.nationalMode && (this.b.autoHideDialCode = !1), this.b.separateDialCode && (this.b.autoHideDialCode = this.b.nationalMode = !1), this.g = /Android.+Mobile|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent), this.g && (a("body").addClass("iti-mobile"), this.b.dropdownContainer || (this.b.dropdownContainer = "body")), this.h = new a.Deferred, this.i = new a.Deferred, this._b(), this._f(), this._h(), this._i(), this._i2(), [this.h, this.i]
        },
        _b: function() {
            this._d(), this._d2(), this._e()
        },
        _c: function(a, b, c) {
            b in this.q || (this.q[b] = []);
            var d = c || 0;
            this.q[b][d] = a
        },
        _c2: function(b, c) {
            var d;
            for (d = 0; d < b.length; d++) b[d] = b[d].toLowerCase();
            for (this.p = [], d = 0; d < k.length; d++) c(a.inArray(k[d].iso2, b)) && this.p.push(k[d])
        },
        _d: function() {
            this.b.onlyCountries.length ? this._c2(this.b.onlyCountries, function(a) {
                return a != -1
            }) : this.b.excludeCountries.length ? this._c2(this.b.excludeCountries, function(a) {
                return a == -1
            }) : this.p = k
        },
        _d2: function() {
            this.q = {};
            for (var a = 0; a < this.p.length; a++) {
                var b = this.p[a];
                if (this._c(b.iso2, b.dialCode, b.priority), b.areaCodes)
                    for (var c = 0; c < b.areaCodes.length; c++) this._c(b.iso2, b.dialCode + b.areaCodes[c])
            }
        },
        _e: function() {
            this.preferredCountries = [];
            for (var a = 0; a < this.b.preferredCountries.length; a++) {
                var b = this.b.preferredCountries[a].toLowerCase(),
                    c = this._y(b, !1, !0);
                c && this.preferredCountries.push(c)
            }
        },
        _f: function() {
            this.a.attr("autocomplete", "off");
            var b = "intl-tel-input";
            this.b.allowDropdown && (b += " allow-dropdown"), this.b.separateDialCode && (b += " separate-dial-code"), this.a.wrap(a("<div>", {
                "class": b
            })), this.k = a("<div>", {
                "class": "flag-container"
            }).insertBefore(this.a);
            var c = a("<div>", {
                "class": "selected-flag"
            });
            c.appendTo(this.k), this.l = a("<div>", {
                "class": "iti-flag"
            }).appendTo(c), this.b.separateDialCode && (this.t = a("<div>", {
                "class": "selected-dial-code"
            }).appendTo(c)), this.b.allowDropdown ? (c.attr("tabindex", "0"), a("<div>", {
                "class": "iti-arrow"
            }).appendTo(c), this.m = a("<ul>", {
                "class": "country-list hide"
            }), this.preferredCountries.length && (this._g(this.preferredCountries, "preferred"), a("<li>", {
                "class": "divider"
            }).appendTo(this.m)), this._g(this.p, ""), this.o = this.m.children(".country"), this.b.dropdownContainer ? this.dropdown = a("<div>", {
                "class": "intl-tel-input iti-container"
            }).append(this.m) : this.m.appendTo(this.k)) : this.o = a()
        },
        _g: function(a, b) {
            for (var c = "", d = 0; d < a.length; d++) {
                var e = a[d];
                c += "<li class='country " + b + "' data-dial-code='" + e.dialCode + "' data-country-code='" + e.iso2 + "'>", c += "<div class='flag-box'><div class='iti-flag " + e.iso2 + "'></div></div>", c += "<span class='country-name'>" + e.name + "</span>", c += "<span class='dial-code'>+" + e.dialCode + "</span>", c += "</li>"
            }
            this.m.append(c)
        },

        _h: function() {
            var a = this.a.val();
            this._af(a) && !this._isRegionlessNanp(a) ? this._v(a) : "auto" !== this.b.initialCountry && (this.b.initialCountry ? this._z(this.b.initialCountry.toLowerCase()) : (this.j = this.preferredCountries.length ? this.preferredCountries[0].iso2 : this.p[0].iso2, a || this._z(this.j)), a || this.b.nationalMode || this.b.autoHideDialCode || this.b.separateDialCode || this.a.val("+" + this.s.dialCode)), a && this._u(a)
        },
        _i: function() {
            this._j(), this.b.autoHideDialCode && this._l(), this.b.allowDropdown && this._i1()
        },
        _i1: function() {
            var a = this,
                b = this.a.closest("label");
            b.length && b.on("click" + this.ns, function(b) {
                a.m.hasClass("hide") ? a.a.focus() : b.preventDefault()
            });
            var c = this.l.parent();
            c.on("click" + this.ns, function(b) {
                !a.m.hasClass("hide") || a.a.prop("disabled") || a.a.prop("readonly") || a._n()
            }), this.k.on("keydown" + a.ns, function(b) {
                var c = a.m.hasClass("hide");
                !c || b.which != i.b && b.which != i.c && b.which != i.j && b.which != i.d || (b.preventDefault(), b.stopPropagation(), a._n()), b.which == i.k && a._ac()
            })
        },
        _i2: function() {
            var c = this;
            this.b.utilsScript ? a.fn[f].windowLoaded ? a.fn[f].loadUtils(this.b.utilsScript, this.i) : a(b).on("load", function() {
                a.fn[f].loadUtils(c.b.utilsScript, c.i)
            }) : this.i.resolve(), "auto" === this.b.initialCountry ? this._i3() : this.h.resolve()
        },
        _i3: function() {
            a.fn[f].autoCountry ? this.handleAutoCountry() : a.fn[f].startedLoadingAutoCountry || (a.fn[f].startedLoadingAutoCountry = !0, "function" == typeof this.b.geoIpLookup && this.b.geoIpLookup(function(b) {
                a.fn[f].autoCountry = b.toLowerCase(), setTimeout(function() {
                    a(".intl-tel-input input").intlTelInput("handleAutoCountry")
                })
            }))
        },
        _j: function() {
            var a = this;
            this.a.on("keyup" + this.ns, function() {
                a._v(a.a.val()) && a._triggerCountryChange()
            }), this.a.on("cut" + this.ns + " paste" + this.ns, function() {
                setTimeout(function() {
                    a._v(a.a.val()) && a._triggerCountryChange()
                })
            })
        },
        _j2: function(a) {
            var b = this.a.attr("maxlength");
            return b && a.length > b ? a.substr(0, b) : a
        },
        _l: function() {
            var b = this;
            this.a.on("mousedown" + this.ns, function(a) {
                b.a.is(":focus") || b.a.val() || (a.preventDefault(), b.a.focus())
            }), this.a.on("focus" + this.ns, function(a) {
                b.a.val() || b.a.prop("readonly") || !b.s.dialCode || (b.a.val("+" + b.s.dialCode), b.a.one("keypress.plus" + b.ns, function(a) {
                    a.which == i.f && b.a.val("")
                }), setTimeout(function() {
                    var a = b.a[0];
                    if (b.d) {
                        var c = b.a.val().length;
                        a.setSelectionRange(c, c)
                    }
                }))
            });
            var c = this.a.prop("form");
            c && a(c).on("submit" + this.ns, function() {
                b._removeEmptyDialCode()
            }), this.a.on("blur" + this.ns, function() {
                b._removeEmptyDialCode()
            })
        },
        _removeEmptyDialCode: function() {
            var a = this.a.val(),
                b = "+" == a.charAt(0);
            if (b) {
                var c = this._m(a);
                c && this.s.dialCode != c || this.a.val("")
            }
            this.a.off("keypress.plus" + this.ns)
        },
        _m: function(a) {
            return a.replace(/\D/g, "")
        },
        _n: function() {
            this._o();
            var a = this.m.children(".active");
            a.length && (this._x(a), this._ad(a)), this._p(), this.l.children(".iti-arrow").addClass("up")
        },
        _o: function() {
            var c = this;
            if (this.b.dropdownContainer && this.dropdown.appendTo(this.b.dropdownContainer), this.n = this.m.removeClass("hide").outerHeight(), !this.g) {
                var d = this.a.offset(),
                    e = d.top,
                    f = a(b).scrollTop(),
                    g = e + this.a.outerHeight() + this.n < f + a(b).height(),
                    h = e - this.n > f;
                if (this.m.toggleClass("dropup", !g && h), this.b.dropdownContainer) {
                    var i = !g && h ? 0 : this.a.innerHeight();
                    this.dropdown.css({
                        top: e + i,
                        left: d.left
                    }), a(b).on("scroll" + this.ns, function() {
                        c._ac()
                    })
                }
            }
        },
        _p: function() {
            var b = this;
            this.m.on("mouseover" + this.ns, ".country", function(c) {
                b._x(a(this))
            }), this.m.on("click" + this.ns, ".country", function(c) {
                b._ab(a(this))
            });
            var d = !0;
            a("html").on("click" + this.ns, function(a) {
                d || b._ac(), d = !1
            });
            var e = "",
                f = null;
            a(c).on("keydown" + this.ns, function(a) {
                a.preventDefault(), a.which == i.b || a.which == i.c ? b._q(a.which) : a.which == i.d ? b._r() : a.which == i.e ? b._ac() : (a.which >= i.A && a.which <= i.Z || a.which == i.j) && (f && clearTimeout(f), e += String.fromCharCode(a.which), b._s(e), f = setTimeout(function() {
                    e = ""
                }, 1e3))
            })
        },
        _q: function(a) {
            var b = this.m.children(".highlight").first(),
                c = a == i.b ? b.prev() : b.next();
            c.length && (c.hasClass("divider") && (c = a == i.b ? c.prev() : c.next()), this._x(c), this._ad(c))
        },
        _r: function() {
            var a = this.m.children(".highlight").first();
            a.length && this._ab(a)
        },
        _s: function(a) {
            for (var b = 0; b < this.p.length; b++)
                if (this._t(this.p[b].name, a)) {
                    var c = this.m.children("[data-country-code=" + this.p[b].iso2 + "]").not(".preferred");
                    this._x(c), this._ad(c, !0);
                    break
                }
        },
        _t: function(a, b) {
            return a.substr(0, b.length).toUpperCase() == b
        },
        _u: function(a) {
            if (this.b.formatOnDisplay && b.intlTelInputUtils && this.s) {
                var c = this.b.separateDialCode || !this.b.nationalMode && "+" == a.charAt(0) ? intlTelInputUtils.numberFormat.INTERNATIONAL : intlTelInputUtils.numberFormat.NATIONAL;
                a = intlTelInputUtils.formatNumber(a, this.s.iso2, c)
            }
            a = this._ah(a), this.a.val(a)
        },
        _v: function(b) {
            b && this.b.nationalMode && this.s && "1" == this.s.dialCode && "+" != b.charAt(0) && ("1" != b.charAt(0) && (b = "1" + b), b = "+" + b);
            var c = this._af(b),
                d = null,
                e = this._m(b);
            if (c) {
                var f = this.q[this._m(c)],
                    g = this.s && a.inArray(this.s.iso2, f) != -1,
                    h = "+1" == c && e.length >= 4;
                if ((!g || h) && !this._isRegionlessNanp(e))
                    for (var i = 0; i < f.length; i++)
                        if (f[i]) {
                            d = f[i];
                            break
                        }
            } else "+" == b.charAt(0) && e.length ? d = "" : b && "+" != b || (d = this.j);
            return null !== d && this._z(d)
        },
        _isRegionlessNanp: function(a) {
            var b = this._m(a);
            if ("1" == b.charAt(0)) {
                var c = b.substr(1, 3);
                return j.indexOf(c) > -1
            }
            return !1
        },
        _x: function(a) {
            this.o.removeClass("highlight"), a.addClass("highlight")
        },
        _y: function(a, b, c) {
            for (var d = b ? k : this.p, e = 0; e < d.length; e++)
                if (d[e].iso2 == a) return d[e];
            if (c) return null;
            throw new Error("No country data for '" + a + "'")
        },
        _z: function(a) {
            var b = this.s && this.s.iso2 ? this.s : {};
            this.s = a ? this._y(a, !1, !1) : {}, this.s.iso2 && (this.j = this.s.iso2), this.l.attr("class", "iti-flag " + a);
            var c = a ? this.s.name + ": +" + this.s.dialCode : "Unknown";
            if (this.l.parent().attr("title", c), this.b.separateDialCode) {
                var d = this.s.dialCode ? "+" + this.s.dialCode : "",
                    e = this.a.parent();
                b.dialCode && e.removeClass("iti-sdc-" + (b.dialCode.length + 1)), d && e.addClass("iti-sdc-" + d.length), this.t.text(d)
            }
            return this._aa(), this.o.removeClass("active"), a && this.o.find(".iti-flag." + a).first().closest(".country").addClass("active"), b.iso2 !== a
        },
        _aa: function() {
            var a = "aggressive" === this.b.autoPlaceholder || !this.e && (this.b.autoPlaceholder === !0 || "polite" === this.b.autoPlaceholder);
            if (b.intlTelInputUtils && a && this.s) {
                var c = intlTelInputUtils.numberType[this.b.placeholderNumberType],
                    d = this.s.iso2 ? intlTelInputUtils.getExampleNumber(this.s.iso2, this.b.nationalMode, c) : "";
                d = this._ah(d), "function" == typeof this.b.customPlaceholder && (d = this.b.customPlaceholder(d, this.s)), this.a.attr("placeholder", d)
            }
        },
        _ab: function(a) {
            var b = this._z(a.attr("data-country-code"));
            if (this._ac(), this._ae(a.attr("data-dial-code"), !0), this.a.focus(), this.d) {
                var c = this.a.val().length;
                this.a[0].setSelectionRange(c, c)
            }
            b && this._triggerCountryChange()
        },
        _ac: function() {
            this.m.addClass("hide"), this.l.children(".iti-arrow").removeClass("up"), a(c).off(this.ns), a("html").off(this.ns), this.m.off(this.ns), this.b.dropdownContainer && (this.g || a(b).off("scroll" + this.ns), this.dropdown.detach())
        },
        _ad: function(a, b) {
            var c = this.m,
                d = c.height(),
                e = c.offset().top,
                f = e + d,
                g = a.outerHeight(),
                h = a.offset().top,
                i = h + g,
                j = h - e + c.scrollTop(),
                k = d / 2 - g / 2;
            if (h < e) b && (j -= k), c.scrollTop(j);
            else if (i > f) {
                b && (j += k);
                var l = d - g;
                c.scrollTop(j - l)
            }
        },
        _ae: function(a, b) {
            var c, d = this.a.val();
            if (a = "+" + a, "+" == d.charAt(0)) {
                var e = this._af(d);
                c = e ? d.replace(e, a) : a
            } else {
                if (this.b.nationalMode || this.b.separateDialCode) return;
                if (d) c = a + d;
                else {
                    if (!b && this.b.autoHideDialCode) return;
                    c = a
                }
            }
            this.a.val(c)
        },
        _af: function(b) {
            var c = "";
            if ("+" == b.charAt(0))
                for (var d = "", e = 0; e < b.length; e++) {
                    var f = b.charAt(e);
                    if (a.isNumeric(f) && (d += f, this.q[d] && (c = b.substr(0, e + 1)), 4 == d.length)) break
                }
            return c
        },
        _ag: function() {
            var a, b = this.a.val(),
                c = this.s.dialCode;
            return a = this.b.separateDialCode ? "+" + c : c && "1" == c.charAt(0) && 4 == c.length && c.substr(1) != b.substr(0, 3) ? c.substr(1) : "", a + b
        },
        _ah: function(a) {
            if (this.b.separateDialCode) {
                var b = this._af(a);
                if (b) {
                    null !== this.s.areaCodes && (b = "+" + this.s.dialCode);
                    var c = " " === a[b.length] || "-" === a[b.length] ? b.length + 1 : b.length;
                    a = a.substr(c)
                }
            }
            return this._j2(a)
        },
        _triggerCountryChange: function() {
            this.a.trigger("countrychange", this.s)
        },
        handleAutoCountry: function() {
            "auto" === this.b.initialCountry && (this.j = a.fn[f].autoCountry, this.a.val() || this.setCountry(this.j), this.h.resolve())
        },
        handleUtils: function() {
            b.intlTelInputUtils && (this.a.val() && this._u(this.a.val()), this._aa()), this.i.resolve()
        },
        destroy: function() {
            if (this.allowDropdown && (this._ac(), this.l.parent().off(this.ns), this.a.closest("label").off(this.ns)), this.b.autoHideDialCode) {
                var b = this.a.prop("form");
                b && a(b).off(this.ns)
            }
            this.a.off(this.ns);
            var c = this.a.parent();
            c.before(this.a).remove()
        },
        getExtension: function() {
            return b.intlTelInputUtils ? intlTelInputUtils.getExtension(this._ag(), this.s.iso2) : ""
        },
        getNumber: function(a) {
            return b.intlTelInputUtils ? intlTelInputUtils.formatNumber(this._ag(), this.s.iso2, a) : ""
        },
        getNumberType: function() {
            return b.intlTelInputUtils ? intlTelInputUtils.getNumberType(this._ag(), this.s.iso2) : -99
        },
        getSelectedCountryData: function() {
            return this.s || {}
        },
        getValidationError: function() {
            return b.intlTelInputUtils ? intlTelInputUtils.getValidationError(this._ag(), this.s.iso2) : -99
        },
        isValidNumber: function() {
            var c = a.trim(this._ag()),
                d = this.b.nationalMode ? this.s.iso2 : "";
            return b.intlTelInputUtils ? intlTelInputUtils.isValidNumber(c, d) : null
        },
        setCountry: function(a) {
            a = a.toLowerCase(), this.l.hasClass(a) || (this._z(a), this._ae(this.s.dialCode, !1), this._triggerCountryChange())
        },
        setNumber: function(a) {
            var b = this._v(a);
            this._u(a), b && this._triggerCountryChange()
        }
    }, a.fn[f] = function(b) {
        var c = arguments;
        if (b === d || "object" == typeof b) {
            var g = [];
            return this.each(function() {
                if (!a.data(this, "plugin_" + f)) {
                    var c = new e(this, b),
                        d = c._a();
                    g.push(d[0]), g.push(d[1]), a.data(this, "plugin_" + f, c)
                }
            }), a.when.apply(null, g)
        }
        if ("string" == typeof b && "_" !== b[0]) {
            var h;
            return this.each(function() {
                var d = a.data(this, "plugin_" + f);
                d instanceof e && "function" == typeof d[b] && (h = d[b].apply(d, Array.prototype.slice.call(c, 1))), "destroy" === b && a.data(this, "plugin_" + f, null)
            }), h !== d ? h : this
        }
    }, a.fn[f].getCountryData = function() {
        return k
    }, a.fn[f].loadUtils = function(b, c) {
        a.fn[f].loadedUtilsScript ? c && c.resolve() : (a.fn[f].loadedUtilsScript = !0, a.ajax({
            type: "GET",
            url: b,
            complete: function() {
                a(".intl-tel-input input").intlTelInput("handleUtils")
            },
            dataType: "script",
            cache: !0
        }))
    }, a.fn[f].version = "10.0.2", a.fn[f].defaults = h;
    for (var k = [
        ["Azerbaijan (Azərbaycan)", "az", "994"],
        ["Georgia (საქართველო)", "ge", "995"],
        ["Iran (‫ایران‬‎)", "ir", "98"],
        ["Russia (Россия)", "ru", "7", 0],
        ["Turkey (Türkiye)", "tr", "90"],
        ["United Kingdom", "gb", "44", 0],
        ["United States", "us", "1", 0],
    ], l = 0; l < k.length; l++) {
        var m = k[l];
        k[l] = {
            name: m[0],
            iso2: m[1],
            dialCode: m[2],
            priority: m[3] || 0,
            areaCodes: m[4] || null
        }
    }
});
