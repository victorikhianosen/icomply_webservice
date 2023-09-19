var P = "top",
    V = "bottom",
    H = "right",
    x = "left",
    $e = "auto",
    Bt = [P, V, H, x],
    At = "start",
    It = "end",
    Js = "clippingParents",
    Cn = "viewport",
    Dt = "popper",
    Qs = "reference",
    mn = Bt.reduce(function (e, t) {
        return e.concat([t + "-" + At, t + "-" + It]);
    }, []),
    Nn = [].concat(Bt, [$e]).reduce(function (e, t) {
        return e.concat([t, t + "-" + At, t + "-" + It]);
    }, []),
    Zs = "beforeRead",
    tr = "read",
    er = "afterRead",
    nr = "beforeMain",
    sr = "main",
    rr = "afterMain",
    ir = "beforeWrite",
    or = "write",
    ar = "afterWrite",
    cr = [Zs, tr, er, nr, sr, rr, ir, or, ar];
function Q(e) {
    return e ? (e.nodeName || "").toLowerCase() : null;
}
function F(e) {
    if (e == null) return window;
    if (e.toString() !== "[object Window]") {
        var t = e.ownerDocument;
        return (t && t.defaultView) || window;
    }
    return e;
}
function Tt(e) {
    var t = F(e).Element;
    return e instanceof t || e instanceof Element;
}
function B(e) {
    var t = F(e).HTMLElement;
    return e instanceof t || e instanceof HTMLElement;
}
function Dn(e) {
    if (typeof ShadowRoot > "u") return !1;
    var t = F(e).ShadowRoot;
    return e instanceof t || e instanceof ShadowRoot;
}
function yi(e) {
    var t = e.state;
    Object.keys(t.elements).forEach(function (n) {
        var s = t.styles[n] || {},
            r = t.attributes[n] || {},
            i = t.elements[n];
        !B(i) ||
            !Q(i) ||
            (Object.assign(i.style, s),
            Object.keys(r).forEach(function (o) {
                var a = r[o];
                a === !1
                    ? i.removeAttribute(o)
                    : i.setAttribute(o, a === !0 ? "" : a);
            }));
    });
}
function Ai(e) {
    var t = e.state,
        n = {
            popper: {
                position: t.options.strategy,
                left: "0",
                top: "0",
                margin: "0",
            },
            arrow: { position: "absolute" },
            reference: {},
        };
    return (
        Object.assign(t.elements.popper.style, n.popper),
        (t.styles = n),
        t.elements.arrow && Object.assign(t.elements.arrow.style, n.arrow),
        function () {
            Object.keys(t.elements).forEach(function (s) {
                var r = t.elements[s],
                    i = t.attributes[s] || {},
                    o = Object.keys(
                        t.styles.hasOwnProperty(s) ? t.styles[s] : n[s]
                    ),
                    a = o.reduce(function (u, c) {
                        return (u[c] = ""), u;
                    }, {});
                !B(r) ||
                    !Q(r) ||
                    (Object.assign(r.style, a),
                    Object.keys(i).forEach(function (u) {
                        r.removeAttribute(u);
                    }));
            });
        }
    );
}
const Ln = {
    name: "applyStyles",
    enabled: !0,
    phase: "write",
    fn: yi,
    effect: Ai,
    requires: ["computeStyles"],
};
function X(e) {
    return e.split("-")[0];
}
var yt = Math.max,
    Ce = Math.min,
    Pt = Math.round;
function gn() {
    var e = navigator.userAgentData;
    return e != null && e.brands && Array.isArray(e.brands)
        ? e.brands
              .map(function (t) {
                  return t.brand + "/" + t.version;
              })
              .join(" ")
        : navigator.userAgent;
}
function lr() {
    return !/^((?!chrome|android).)*safari/i.test(gn());
}
function xt(e, t, n) {
    t === void 0 && (t = !1), n === void 0 && (n = !1);
    var s = e.getBoundingClientRect(),
        r = 1,
        i = 1;
    t &&
        B(e) &&
        ((r = (e.offsetWidth > 0 && Pt(s.width) / e.offsetWidth) || 1),
        (i = (e.offsetHeight > 0 && Pt(s.height) / e.offsetHeight) || 1));
    var o = Tt(e) ? F(e) : window,
        a = o.visualViewport,
        u = !lr() && n,
        c = (s.left + (u && a ? a.offsetLeft : 0)) / r,
        l = (s.top + (u && a ? a.offsetTop : 0)) / i,
        h = s.width / r,
        g = s.height / i;
    return {
        width: h,
        height: g,
        top: l,
        right: c + h,
        bottom: l + g,
        left: c,
        x: c,
        y: l,
    };
}
function Rn(e) {
    var t = xt(e),
        n = e.offsetWidth,
        s = e.offsetHeight;
    return (
        Math.abs(t.width - n) <= 1 && (n = t.width),
        Math.abs(t.height - s) <= 1 && (s = t.height),
        { x: e.offsetLeft, y: e.offsetTop, width: n, height: s }
    );
}
function ur(e, t) {
    var n = t.getRootNode && t.getRootNode();
    if (e.contains(t)) return !0;
    if (n && Dn(n)) {
        var s = t;
        do {
            if (s && e.isSameNode(s)) return !0;
            s = s.parentNode || s.host;
        } while (s);
    }
    return !1;
}
function st(e) {
    return F(e).getComputedStyle(e);
}
function Ti(e) {
    return ["table", "td", "th"].indexOf(Q(e)) >= 0;
}
function ft(e) {
    return ((Tt(e) ? e.ownerDocument : e.document) || window.document)
        .documentElement;
}
function Ie(e) {
    return Q(e) === "html"
        ? e
        : e.assignedSlot || e.parentNode || (Dn(e) ? e.host : null) || ft(e);
}
function is(e) {
    return !B(e) || st(e).position === "fixed" ? null : e.offsetParent;
}
function wi(e) {
    var t = /firefox/i.test(gn()),
        n = /Trident/i.test(gn());
    if (n && B(e)) {
        var s = st(e);
        if (s.position === "fixed") return null;
    }
    var r = Ie(e);
    for (Dn(r) && (r = r.host); B(r) && ["html", "body"].indexOf(Q(r)) < 0; ) {
        var i = st(r);
        if (
            i.transform !== "none" ||
            i.perspective !== "none" ||
            i.contain === "paint" ||
            ["transform", "perspective"].indexOf(i.willChange) !== -1 ||
            (t && i.willChange === "filter") ||
            (t && i.filter && i.filter !== "none")
        )
            return r;
        r = r.parentNode;
    }
    return null;
}
function ee(e) {
    for (var t = F(e), n = is(e); n && Ti(n) && st(n).position === "static"; )
        n = is(n);
    return n &&
        (Q(n) === "html" || (Q(n) === "body" && st(n).position === "static"))
        ? t
        : n || wi(e) || t;
}
function $n(e) {
    return ["top", "bottom"].indexOf(e) >= 0 ? "x" : "y";
}
function Jt(e, t, n) {
    return yt(e, Ce(t, n));
}
function Oi(e, t, n) {
    var s = Jt(e, t, n);
    return s > n ? n : s;
}
function fr() {
    return { top: 0, right: 0, bottom: 0, left: 0 };
}
function dr(e) {
    return Object.assign({}, fr(), e);
}
function hr(e, t) {
    return t.reduce(function (n, s) {
        return (n[s] = e), n;
    }, {});
}
var Si = function (t, n) {
    return (
        (t =
            typeof t == "function"
                ? t(Object.assign({}, n.rects, { placement: n.placement }))
                : t),
        dr(typeof t != "number" ? t : hr(t, Bt))
    );
};
function Ci(e) {
    var t,
        n = e.state,
        s = e.name,
        r = e.options,
        i = n.elements.arrow,
        o = n.modifiersData.popperOffsets,
        a = X(n.placement),
        u = $n(a),
        c = [x, H].indexOf(a) >= 0,
        l = c ? "height" : "width";
    if (!(!i || !o)) {
        var h = Si(r.padding, n),
            g = Rn(i),
            m = u === "y" ? P : x,
            p = u === "y" ? V : H,
            _ =
                n.rects.reference[l] +
                n.rects.reference[u] -
                o[u] -
                n.rects.popper[l],
            b = o[u] - n.rects.reference[u],
            y = ee(i),
            T = y ? (u === "y" ? y.clientHeight || 0 : y.clientWidth || 0) : 0,
            S = _ / 2 - b / 2,
            v = h[m],
            w = T - g[l] - h[p],
            O = T / 2 - g[l] / 2 + S,
            C = Jt(v, O, w),
            R = u;
        n.modifiersData[s] =
            ((t = {}), (t[R] = C), (t.centerOffset = C - O), t);
    }
}
function Ni(e) {
    var t = e.state,
        n = e.options,
        s = n.element,
        r = s === void 0 ? "[data-popper-arrow]" : s;
    r != null &&
        ((typeof r == "string" &&
            ((r = t.elements.popper.querySelector(r)), !r)) ||
            (ur(t.elements.popper, r) && (t.elements.arrow = r)));
}
const pr = {
    name: "arrow",
    enabled: !0,
    phase: "main",
    fn: Ci,
    effect: Ni,
    requires: ["popperOffsets"],
    requiresIfExists: ["preventOverflow"],
};
function Mt(e) {
    return e.split("-")[1];
}
var Di = { top: "auto", right: "auto", bottom: "auto", left: "auto" };
function Li(e, t) {
    var n = e.x,
        s = e.y,
        r = t.devicePixelRatio || 1;
    return { x: Pt(n * r) / r || 0, y: Pt(s * r) / r || 0 };
}
function os(e) {
    var t,
        n = e.popper,
        s = e.popperRect,
        r = e.placement,
        i = e.variation,
        o = e.offsets,
        a = e.position,
        u = e.gpuAcceleration,
        c = e.adaptive,
        l = e.roundOffsets,
        h = e.isFixed,
        g = o.x,
        m = g === void 0 ? 0 : g,
        p = o.y,
        _ = p === void 0 ? 0 : p,
        b = typeof l == "function" ? l({ x: m, y: _ }) : { x: m, y: _ };
    (m = b.x), (_ = b.y);
    var y = o.hasOwnProperty("x"),
        T = o.hasOwnProperty("y"),
        S = x,
        v = P,
        w = window;
    if (c) {
        var O = ee(n),
            C = "clientHeight",
            R = "clientWidth";
        if (
            (O === F(n) &&
                ((O = ft(n)),
                st(O).position !== "static" &&
                    a === "absolute" &&
                    ((C = "scrollHeight"), (R = "scrollWidth"))),
            (O = O),
            r === P || ((r === x || r === H) && i === It))
        ) {
            v = V;
            var L =
                h && O === w && w.visualViewport
                    ? w.visualViewport.height
                    : O[C];
            (_ -= L - s.height), (_ *= u ? 1 : -1);
        }
        if (r === x || ((r === P || r === V) && i === It)) {
            S = H;
            var N =
                h && O === w && w.visualViewport
                    ? w.visualViewport.width
                    : O[R];
            (m -= N - s.width), (m *= u ? 1 : -1);
        }
    }
    var $ = Object.assign({ position: a }, c && Di),
        Y = l === !0 ? Li({ x: m, y: _ }, F(n)) : { x: m, y: _ };
    if (((m = Y.x), (_ = Y.y), u)) {
        var I;
        return Object.assign(
            {},
            $,
            ((I = {}),
            (I[v] = T ? "0" : ""),
            (I[S] = y ? "0" : ""),
            (I.transform =
                (w.devicePixelRatio || 1) <= 1
                    ? "translate(" + m + "px, " + _ + "px)"
                    : "translate3d(" + m + "px, " + _ + "px, 0)"),
            I)
        );
    }
    return Object.assign(
        {},
        $,
        ((t = {}),
        (t[v] = T ? _ + "px" : ""),
        (t[S] = y ? m + "px" : ""),
        (t.transform = ""),
        t)
    );
}
function Ri(e) {
    var t = e.state,
        n = e.options,
        s = n.gpuAcceleration,
        r = s === void 0 ? !0 : s,
        i = n.adaptive,
        o = i === void 0 ? !0 : i,
        a = n.roundOffsets,
        u = a === void 0 ? !0 : a,
        c = {
            placement: X(t.placement),
            variation: Mt(t.placement),
            popper: t.elements.popper,
            popperRect: t.rects.popper,
            gpuAcceleration: r,
            isFixed: t.options.strategy === "fixed",
        };
    t.modifiersData.popperOffsets != null &&
        (t.styles.popper = Object.assign(
            {},
            t.styles.popper,
            os(
                Object.assign({}, c, {
                    offsets: t.modifiersData.popperOffsets,
                    position: t.options.strategy,
                    adaptive: o,
                    roundOffsets: u,
                })
            )
        )),
        t.modifiersData.arrow != null &&
            (t.styles.arrow = Object.assign(
                {},
                t.styles.arrow,
                os(
                    Object.assign({}, c, {
                        offsets: t.modifiersData.arrow,
                        position: "absolute",
                        adaptive: !1,
                        roundOffsets: u,
                    })
                )
            )),
        (t.attributes.popper = Object.assign({}, t.attributes.popper, {
            "data-popper-placement": t.placement,
        }));
}
const In = {
    name: "computeStyles",
    enabled: !0,
    phase: "beforeWrite",
    fn: Ri,
    data: {},
};
var he = { passive: !0 };
function $i(e) {
    var t = e.state,
        n = e.instance,
        s = e.options,
        r = s.scroll,
        i = r === void 0 ? !0 : r,
        o = s.resize,
        a = o === void 0 ? !0 : o,
        u = F(t.elements.popper),
        c = [].concat(t.scrollParents.reference, t.scrollParents.popper);
    return (
        i &&
            c.forEach(function (l) {
                l.addEventListener("scroll", n.update, he);
            }),
        a && u.addEventListener("resize", n.update, he),
        function () {
            i &&
                c.forEach(function (l) {
                    l.removeEventListener("scroll", n.update, he);
                }),
                a && u.removeEventListener("resize", n.update, he);
        }
    );
}
const Pn = {
    name: "eventListeners",
    enabled: !0,
    phase: "write",
    fn: function () {},
    effect: $i,
    data: {},
};
var Ii = { left: "right", right: "left", bottom: "top", top: "bottom" };
function ve(e) {
    return e.replace(/left|right|bottom|top/g, function (t) {
        return Ii[t];
    });
}
var Pi = { start: "end", end: "start" };
function as(e) {
    return e.replace(/start|end/g, function (t) {
        return Pi[t];
    });
}
function xn(e) {
    var t = F(e),
        n = t.pageXOffset,
        s = t.pageYOffset;
    return { scrollLeft: n, scrollTop: s };
}
function Mn(e) {
    return xt(ft(e)).left + xn(e).scrollLeft;
}
function xi(e, t) {
    var n = F(e),
        s = ft(e),
        r = n.visualViewport,
        i = s.clientWidth,
        o = s.clientHeight,
        a = 0,
        u = 0;
    if (r) {
        (i = r.width), (o = r.height);
        var c = lr();
        (c || (!c && t === "fixed")) && ((a = r.offsetLeft), (u = r.offsetTop));
    }
    return { width: i, height: o, x: a + Mn(e), y: u };
}
function Mi(e) {
    var t,
        n = ft(e),
        s = xn(e),
        r = (t = e.ownerDocument) == null ? void 0 : t.body,
        i = yt(
            n.scrollWidth,
            n.clientWidth,
            r ? r.scrollWidth : 0,
            r ? r.clientWidth : 0
        ),
        o = yt(
            n.scrollHeight,
            n.clientHeight,
            r ? r.scrollHeight : 0,
            r ? r.clientHeight : 0
        ),
        a = -s.scrollLeft + Mn(e),
        u = -s.scrollTop;
    return (
        st(r || n).direction === "rtl" &&
            (a += yt(n.clientWidth, r ? r.clientWidth : 0) - i),
        { width: i, height: o, x: a, y: u }
    );
}
function kn(e) {
    var t = st(e),
        n = t.overflow,
        s = t.overflowX,
        r = t.overflowY;
    return /auto|scroll|overlay|hidden/.test(n + r + s);
}
function _r(e) {
    return ["html", "body", "#document"].indexOf(Q(e)) >= 0
        ? e.ownerDocument.body
        : B(e) && kn(e)
        ? e
        : _r(Ie(e));
}
function Qt(e, t) {
    var n;
    t === void 0 && (t = []);
    var s = _r(e),
        r = s === ((n = e.ownerDocument) == null ? void 0 : n.body),
        i = F(s),
        o = r ? [i].concat(i.visualViewport || [], kn(s) ? s : []) : s,
        a = t.concat(o);
    return r ? a : a.concat(Qt(Ie(o)));
}
function En(e) {
    return Object.assign({}, e, {
        left: e.x,
        top: e.y,
        right: e.x + e.width,
        bottom: e.y + e.height,
    });
}
function ki(e, t) {
    var n = xt(e, !1, t === "fixed");
    return (
        (n.top = n.top + e.clientTop),
        (n.left = n.left + e.clientLeft),
        (n.bottom = n.top + e.clientHeight),
        (n.right = n.left + e.clientWidth),
        (n.width = e.clientWidth),
        (n.height = e.clientHeight),
        (n.x = n.left),
        (n.y = n.top),
        n
    );
}
function cs(e, t, n) {
    return t === Cn ? En(xi(e, n)) : Tt(t) ? ki(t, n) : En(Mi(ft(e)));
}
function Vi(e) {
    var t = Qt(Ie(e)),
        n = ["absolute", "fixed"].indexOf(st(e).position) >= 0,
        s = n && B(e) ? ee(e) : e;
    return Tt(s)
        ? t.filter(function (r) {
              return Tt(r) && ur(r, s) && Q(r) !== "body";
          })
        : [];
}
function Hi(e, t, n, s) {
    var r = t === "clippingParents" ? Vi(e) : [].concat(t),
        i = [].concat(r, [n]),
        o = i[0],
        a = i.reduce(function (u, c) {
            var l = cs(e, c, s);
            return (
                (u.top = yt(l.top, u.top)),
                (u.right = Ce(l.right, u.right)),
                (u.bottom = Ce(l.bottom, u.bottom)),
                (u.left = yt(l.left, u.left)),
                u
            );
        }, cs(e, o, s));
    return (
        (a.width = a.right - a.left),
        (a.height = a.bottom - a.top),
        (a.x = a.left),
        (a.y = a.top),
        a
    );
}
function mr(e) {
    var t = e.reference,
        n = e.element,
        s = e.placement,
        r = s ? X(s) : null,
        i = s ? Mt(s) : null,
        o = t.x + t.width / 2 - n.width / 2,
        a = t.y + t.height / 2 - n.height / 2,
        u;
    switch (r) {
        case P:
            u = { x: o, y: t.y - n.height };
            break;
        case V:
            u = { x: o, y: t.y + t.height };
            break;
        case H:
            u = { x: t.x + t.width, y: a };
            break;
        case x:
            u = { x: t.x - n.width, y: a };
            break;
        default:
            u = { x: t.x, y: t.y };
    }
    var c = r ? $n(r) : null;
    if (c != null) {
        var l = c === "y" ? "height" : "width";
        switch (i) {
            case At:
                u[c] = u[c] - (t[l] / 2 - n[l] / 2);
                break;
            case It:
                u[c] = u[c] + (t[l] / 2 - n[l] / 2);
                break;
        }
    }
    return u;
}
function kt(e, t) {
    t === void 0 && (t = {});
    var n = t,
        s = n.placement,
        r = s === void 0 ? e.placement : s,
        i = n.strategy,
        o = i === void 0 ? e.strategy : i,
        a = n.boundary,
        u = a === void 0 ? Js : a,
        c = n.rootBoundary,
        l = c === void 0 ? Cn : c,
        h = n.elementContext,
        g = h === void 0 ? Dt : h,
        m = n.altBoundary,
        p = m === void 0 ? !1 : m,
        _ = n.padding,
        b = _ === void 0 ? 0 : _,
        y = dr(typeof b != "number" ? b : hr(b, Bt)),
        T = g === Dt ? Qs : Dt,
        S = e.rects.popper,
        v = e.elements[p ? T : g],
        w = Hi(Tt(v) ? v : v.contextElement || ft(e.elements.popper), u, l, o),
        O = xt(e.elements.reference),
        C = mr({
            reference: O,
            element: S,
            strategy: "absolute",
            placement: r,
        }),
        R = En(Object.assign({}, S, C)),
        L = g === Dt ? R : O,
        N = {
            top: w.top - L.top + y.top,
            bottom: L.bottom - w.bottom + y.bottom,
            left: w.left - L.left + y.left,
            right: L.right - w.right + y.right,
        },
        $ = e.modifiersData.offset;
    if (g === Dt && $) {
        var Y = $[r];
        Object.keys(N).forEach(function (I) {
            var pt = [H, V].indexOf(I) >= 0 ? 1 : -1,
                _t = [P, V].indexOf(I) >= 0 ? "y" : "x";
            N[I] += Y[_t] * pt;
        });
    }
    return N;
}
function Fi(e, t) {
    t === void 0 && (t = {});
    var n = t,
        s = n.placement,
        r = n.boundary,
        i = n.rootBoundary,
        o = n.padding,
        a = n.flipVariations,
        u = n.allowedAutoPlacements,
        c = u === void 0 ? Nn : u,
        l = Mt(s),
        h = l
            ? a
                ? mn
                : mn.filter(function (p) {
                      return Mt(p) === l;
                  })
            : Bt,
        g = h.filter(function (p) {
            return c.indexOf(p) >= 0;
        });
    g.length === 0 && (g = h);
    var m = g.reduce(function (p, _) {
        return (
            (p[_] = kt(e, {
                placement: _,
                boundary: r,
                rootBoundary: i,
                padding: o,
            })[X(_)]),
            p
        );
    }, {});
    return Object.keys(m).sort(function (p, _) {
        return m[p] - m[_];
    });
}
function Bi(e) {
    if (X(e) === $e) return [];
    var t = ve(e);
    return [as(e), t, as(t)];
}
function ji(e) {
    var t = e.state,
        n = e.options,
        s = e.name;
    if (!t.modifiersData[s]._skip) {
        for (
            var r = n.mainAxis,
                i = r === void 0 ? !0 : r,
                o = n.altAxis,
                a = o === void 0 ? !0 : o,
                u = n.fallbackPlacements,
                c = n.padding,
                l = n.boundary,
                h = n.rootBoundary,
                g = n.altBoundary,
                m = n.flipVariations,
                p = m === void 0 ? !0 : m,
                _ = n.allowedAutoPlacements,
                b = t.options.placement,
                y = X(b),
                T = y === b,
                S = u || (T || !p ? [ve(b)] : Bi(b)),
                v = [b].concat(S).reduce(function (St, it) {
                    return St.concat(
                        X(it) === $e
                            ? Fi(t, {
                                  placement: it,
                                  boundary: l,
                                  rootBoundary: h,
                                  padding: c,
                                  flipVariations: p,
                                  allowedAutoPlacements: _,
                              })
                            : it
                    );
                }, []),
                w = t.rects.reference,
                O = t.rects.popper,
                C = new Map(),
                R = !0,
                L = v[0],
                N = 0;
            N < v.length;
            N++
        ) {
            var $ = v[N],
                Y = X($),
                I = Mt($) === At,
                pt = [P, V].indexOf(Y) >= 0,
                _t = pt ? "width" : "height",
                k = kt(t, {
                    placement: $,
                    boundary: l,
                    rootBoundary: h,
                    altBoundary: g,
                    padding: c,
                }),
                z = pt ? (I ? H : x) : I ? V : P;
            w[_t] > O[_t] && (z = ve(z));
            var ce = ve(z),
                mt = [];
            if (
                (i && mt.push(k[Y] <= 0),
                a && mt.push(k[z] <= 0, k[ce] <= 0),
                mt.every(function (St) {
                    return St;
                }))
            ) {
                (L = $), (R = !1);
                break;
            }
            C.set($, mt);
        }
        if (R)
            for (
                var le = p ? 3 : 1,
                    Ye = function (it) {
                        var zt = v.find(function (fe) {
                            var gt = C.get(fe);
                            if (gt)
                                return gt.slice(0, it).every(function (ze) {
                                    return ze;
                                });
                        });
                        if (zt) return (L = zt), "break";
                    },
                    Yt = le;
                Yt > 0;
                Yt--
            ) {
                var ue = Ye(Yt);
                if (ue === "break") break;
            }
        t.placement !== L &&
            ((t.modifiersData[s]._skip = !0),
            (t.placement = L),
            (t.reset = !0));
    }
}
const gr = {
    name: "flip",
    enabled: !0,
    phase: "main",
    fn: ji,
    requiresIfExists: ["offset"],
    data: { _skip: !1 },
};
function ls(e, t, n) {
    return (
        n === void 0 && (n = { x: 0, y: 0 }),
        {
            top: e.top - t.height - n.y,
            right: e.right - t.width + n.x,
            bottom: e.bottom - t.height + n.y,
            left: e.left - t.width - n.x,
        }
    );
}
function us(e) {
    return [P, H, V, x].some(function (t) {
        return e[t] >= 0;
    });
}
function Wi(e) {
    var t = e.state,
        n = e.name,
        s = t.rects.reference,
        r = t.rects.popper,
        i = t.modifiersData.preventOverflow,
        o = kt(t, { elementContext: "reference" }),
        a = kt(t, { altBoundary: !0 }),
        u = ls(o, s),
        c = ls(a, r, i),
        l = us(u),
        h = us(c);
    (t.modifiersData[n] = {
        referenceClippingOffsets: u,
        popperEscapeOffsets: c,
        isReferenceHidden: l,
        hasPopperEscaped: h,
    }),
        (t.attributes.popper = Object.assign({}, t.attributes.popper, {
            "data-popper-reference-hidden": l,
            "data-popper-escaped": h,
        }));
}
const Er = {
    name: "hide",
    enabled: !0,
    phase: "main",
    requiresIfExists: ["preventOverflow"],
    fn: Wi,
};
function Ui(e, t, n) {
    var s = X(e),
        r = [x, P].indexOf(s) >= 0 ? -1 : 1,
        i =
            typeof n == "function"
                ? n(Object.assign({}, t, { placement: e }))
                : n,
        o = i[0],
        a = i[1];
    return (
        (o = o || 0),
        (a = (a || 0) * r),
        [x, H].indexOf(s) >= 0 ? { x: a, y: o } : { x: o, y: a }
    );
}
function Ki(e) {
    var t = e.state,
        n = e.options,
        s = e.name,
        r = n.offset,
        i = r === void 0 ? [0, 0] : r,
        o = Nn.reduce(function (l, h) {
            return (l[h] = Ui(h, t.rects, i)), l;
        }, {}),
        a = o[t.placement],
        u = a.x,
        c = a.y;
    t.modifiersData.popperOffsets != null &&
        ((t.modifiersData.popperOffsets.x += u),
        (t.modifiersData.popperOffsets.y += c)),
        (t.modifiersData[s] = o);
}
const br = {
    name: "offset",
    enabled: !0,
    phase: "main",
    requires: ["popperOffsets"],
    fn: Ki,
};
function Yi(e) {
    var t = e.state,
        n = e.name;
    t.modifiersData[n] = mr({
        reference: t.rects.reference,
        element: t.rects.popper,
        strategy: "absolute",
        placement: t.placement,
    });
}
const Vn = {
    name: "popperOffsets",
    enabled: !0,
    phase: "read",
    fn: Yi,
    data: {},
};
function zi(e) {
    return e === "x" ? "y" : "x";
}
function qi(e) {
    var t = e.state,
        n = e.options,
        s = e.name,
        r = n.mainAxis,
        i = r === void 0 ? !0 : r,
        o = n.altAxis,
        a = o === void 0 ? !1 : o,
        u = n.boundary,
        c = n.rootBoundary,
        l = n.altBoundary,
        h = n.padding,
        g = n.tether,
        m = g === void 0 ? !0 : g,
        p = n.tetherOffset,
        _ = p === void 0 ? 0 : p,
        b = kt(t, { boundary: u, rootBoundary: c, padding: h, altBoundary: l }),
        y = X(t.placement),
        T = Mt(t.placement),
        S = !T,
        v = $n(y),
        w = zi(v),
        O = t.modifiersData.popperOffsets,
        C = t.rects.reference,
        R = t.rects.popper,
        L =
            typeof _ == "function"
                ? _(Object.assign({}, t.rects, { placement: t.placement }))
                : _,
        N =
            typeof L == "number"
                ? { mainAxis: L, altAxis: L }
                : Object.assign({ mainAxis: 0, altAxis: 0 }, L),
        $ = t.modifiersData.offset ? t.modifiersData.offset[t.placement] : null,
        Y = { x: 0, y: 0 };
    if (O) {
        if (i) {
            var I,
                pt = v === "y" ? P : x,
                _t = v === "y" ? V : H,
                k = v === "y" ? "height" : "width",
                z = O[v],
                ce = z + b[pt],
                mt = z - b[_t],
                le = m ? -R[k] / 2 : 0,
                Ye = T === At ? C[k] : R[k],
                Yt = T === At ? -R[k] : -C[k],
                ue = t.elements.arrow,
                St = m && ue ? Rn(ue) : { width: 0, height: 0 },
                it = t.modifiersData["arrow#persistent"]
                    ? t.modifiersData["arrow#persistent"].padding
                    : fr(),
                zt = it[pt],
                fe = it[_t],
                gt = Jt(0, C[k], St[k]),
                ze = S
                    ? C[k] / 2 - le - gt - zt - N.mainAxis
                    : Ye - gt - zt - N.mainAxis,
                _i = S
                    ? -C[k] / 2 + le + gt + fe + N.mainAxis
                    : Yt + gt + fe + N.mainAxis,
                qe = t.elements.arrow && ee(t.elements.arrow),
                mi = qe
                    ? v === "y"
                        ? qe.clientTop || 0
                        : qe.clientLeft || 0
                    : 0,
                Xn = (I = $ == null ? void 0 : $[v]) != null ? I : 0,
                gi = z + ze - Xn - mi,
                Ei = z + _i - Xn,
                Jn = Jt(m ? Ce(ce, gi) : ce, z, m ? yt(mt, Ei) : mt);
            (O[v] = Jn), (Y[v] = Jn - z);
        }
        if (a) {
            var Qn,
                bi = v === "x" ? P : x,
                vi = v === "x" ? V : H,
                Et = O[w],
                de = w === "y" ? "height" : "width",
                Zn = Et + b[bi],
                ts = Et - b[vi],
                Ge = [P, x].indexOf(y) !== -1,
                es = (Qn = $ == null ? void 0 : $[w]) != null ? Qn : 0,
                ns = Ge ? Zn : Et - C[de] - R[de] - es + N.altAxis,
                ss = Ge ? Et + C[de] + R[de] - es - N.altAxis : ts,
                rs =
                    m && Ge ? Oi(ns, Et, ss) : Jt(m ? ns : Zn, Et, m ? ss : ts);
            (O[w] = rs), (Y[w] = rs - Et);
        }
        t.modifiersData[s] = Y;
    }
}
const vr = {
    name: "preventOverflow",
    enabled: !0,
    phase: "main",
    fn: qi,
    requiresIfExists: ["offset"],
};
function Gi(e) {
    return { scrollLeft: e.scrollLeft, scrollTop: e.scrollTop };
}
function Xi(e) {
    return e === F(e) || !B(e) ? xn(e) : Gi(e);
}
function Ji(e) {
    var t = e.getBoundingClientRect(),
        n = Pt(t.width) / e.offsetWidth || 1,
        s = Pt(t.height) / e.offsetHeight || 1;
    return n !== 1 || s !== 1;
}
function Qi(e, t, n) {
    n === void 0 && (n = !1);
    var s = B(t),
        r = B(t) && Ji(t),
        i = ft(t),
        o = xt(e, r, n),
        a = { scrollLeft: 0, scrollTop: 0 },
        u = { x: 0, y: 0 };
    return (
        (s || (!s && !n)) &&
            ((Q(t) !== "body" || kn(i)) && (a = Xi(t)),
            B(t)
                ? ((u = xt(t, !0)), (u.x += t.clientLeft), (u.y += t.clientTop))
                : i && (u.x = Mn(i))),
        {
            x: o.left + a.scrollLeft - u.x,
            y: o.top + a.scrollTop - u.y,
            width: o.width,
            height: o.height,
        }
    );
}
function Zi(e) {
    var t = new Map(),
        n = new Set(),
        s = [];
    e.forEach(function (i) {
        t.set(i.name, i);
    });
    function r(i) {
        n.add(i.name);
        var o = [].concat(i.requires || [], i.requiresIfExists || []);
        o.forEach(function (a) {
            if (!n.has(a)) {
                var u = t.get(a);
                u && r(u);
            }
        }),
            s.push(i);
    }
    return (
        e.forEach(function (i) {
            n.has(i.name) || r(i);
        }),
        s
    );
}
function to(e) {
    var t = Zi(e);
    return cr.reduce(function (n, s) {
        return n.concat(
            t.filter(function (r) {
                return r.phase === s;
            })
        );
    }, []);
}
function eo(e) {
    var t;
    return function () {
        return (
            t ||
                (t = new Promise(function (n) {
                    Promise.resolve().then(function () {
                        (t = void 0), n(e());
                    });
                })),
            t
        );
    };
}
function no(e) {
    var t = e.reduce(function (n, s) {
        var r = n[s.name];
        return (
            (n[s.name] = r
                ? Object.assign({}, r, s, {
                      options: Object.assign({}, r.options, s.options),
                      data: Object.assign({}, r.data, s.data),
                  })
                : s),
            n
        );
    }, {});
    return Object.keys(t).map(function (n) {
        return t[n];
    });
}
var fs = { placement: "bottom", modifiers: [], strategy: "absolute" };
function ds() {
    for (var e = arguments.length, t = new Array(e), n = 0; n < e; n++)
        t[n] = arguments[n];
    return !t.some(function (s) {
        return !(s && typeof s.getBoundingClientRect == "function");
    });
}
function Pe(e) {
    e === void 0 && (e = {});
    var t = e,
        n = t.defaultModifiers,
        s = n === void 0 ? [] : n,
        r = t.defaultOptions,
        i = r === void 0 ? fs : r;
    return function (a, u, c) {
        c === void 0 && (c = i);
        var l = {
                placement: "bottom",
                orderedModifiers: [],
                options: Object.assign({}, fs, i),
                modifiersData: {},
                elements: { reference: a, popper: u },
                attributes: {},
                styles: {},
            },
            h = [],
            g = !1,
            m = {
                state: l,
                setOptions: function (y) {
                    var T = typeof y == "function" ? y(l.options) : y;
                    _(),
                        (l.options = Object.assign({}, i, l.options, T)),
                        (l.scrollParents = {
                            reference: Tt(a)
                                ? Qt(a)
                                : a.contextElement
                                ? Qt(a.contextElement)
                                : [],
                            popper: Qt(u),
                        });
                    var S = to(no([].concat(s, l.options.modifiers)));
                    return (
                        (l.orderedModifiers = S.filter(function (v) {
                            return v.enabled;
                        })),
                        p(),
                        m.update()
                    );
                },
                forceUpdate: function () {
                    if (!g) {
                        var y = l.elements,
                            T = y.reference,
                            S = y.popper;
                        if (ds(T, S)) {
                            (l.rects = {
                                reference: Qi(
                                    T,
                                    ee(S),
                                    l.options.strategy === "fixed"
                                ),
                                popper: Rn(S),
                            }),
                                (l.reset = !1),
                                (l.placement = l.options.placement),
                                l.orderedModifiers.forEach(function (N) {
                                    return (l.modifiersData[N.name] =
                                        Object.assign({}, N.data));
                                });
                            for (
                                var v = 0;
                                v < l.orderedModifiers.length;
                                v++
                            ) {
                                if (l.reset === !0) {
                                    (l.reset = !1), (v = -1);
                                    continue;
                                }
                                var w = l.orderedModifiers[v],
                                    O = w.fn,
                                    C = w.options,
                                    R = C === void 0 ? {} : C,
                                    L = w.name;
                                typeof O == "function" &&
                                    (l =
                                        O({
                                            state: l,
                                            options: R,
                                            name: L,
                                            instance: m,
                                        }) || l);
                            }
                        }
                    }
                },
                update: eo(function () {
                    return new Promise(function (b) {
                        m.forceUpdate(), b(l);
                    });
                }),
                destroy: function () {
                    _(), (g = !0);
                },
            };
        if (!ds(a, u)) return m;
        m.setOptions(c).then(function (b) {
            !g && c.onFirstUpdate && c.onFirstUpdate(b);
        });
        function p() {
            l.orderedModifiers.forEach(function (b) {
                var y = b.name,
                    T = b.options,
                    S = T === void 0 ? {} : T,
                    v = b.effect;
                if (typeof v == "function") {
                    var w = v({ state: l, name: y, instance: m, options: S }),
                        O = function () {};
                    h.push(w || O);
                }
            });
        }
        function _() {
            h.forEach(function (b) {
                return b();
            }),
                (h = []);
        }
        return m;
    };
}
var so = Pe(),
    ro = [Pn, Vn, In, Ln],
    io = Pe({ defaultModifiers: ro }),
    oo = [Pn, Vn, In, Ln, br, gr, vr, pr, Er],
    Hn = Pe({ defaultModifiers: oo });
const yr = Object.freeze(
    Object.defineProperty(
        {
            __proto__: null,
            afterMain: rr,
            afterRead: er,
            afterWrite: ar,
            applyStyles: Ln,
            arrow: pr,
            auto: $e,
            basePlacements: Bt,
            beforeMain: nr,
            beforeRead: Zs,
            beforeWrite: ir,
            bottom: V,
            clippingParents: Js,
            computeStyles: In,
            createPopper: Hn,
            createPopperBase: so,
            createPopperLite: io,
            detectOverflow: kt,
            end: It,
            eventListeners: Pn,
            flip: gr,
            hide: Er,
            left: x,
            main: sr,
            modifierPhases: cr,
            offset: br,
            placements: Nn,
            popper: Dt,
            popperGenerator: Pe,
            popperOffsets: Vn,
            preventOverflow: vr,
            read: tr,
            reference: Qs,
            right: H,
            start: At,
            top: P,
            variationPlacements: mn,
            viewport: Cn,
            write: or,
        },
        Symbol.toStringTag,
        { value: "Module" }
    )
);
/*!
 * Bootstrap v5.3.1 (https://getbootstrap.com/)
 * Copyright 2011-2023 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
 */ const ot = new Map(),
    Xe = {
        set(e, t, n) {
            ot.has(e) || ot.set(e, new Map());
            const s = ot.get(e);
            if (!s.has(t) && s.size !== 0) {
                console.error(
                    `Bootstrap doesn't allow more than one instance per element. Bound instance: ${
                        Array.from(s.keys())[0]
                    }.`
                );
                return;
            }
            s.set(t, n);
        },
        get(e, t) {
            return (ot.has(e) && ot.get(e).get(t)) || null;
        },
        remove(e, t) {
            if (!ot.has(e)) return;
            const n = ot.get(e);
            n.delete(t), n.size === 0 && ot.delete(e);
        },
    },
    ao = 1e6,
    co = 1e3,
    bn = "transitionend",
    Ar = (e) => (
        e &&
            window.CSS &&
            window.CSS.escape &&
            (e = e.replace(/#([^\s"#']+)/g, (t, n) => `#${CSS.escape(n)}`)),
        e
    ),
    lo = (e) =>
        e == null
            ? `${e}`
            : Object.prototype.toString
                  .call(e)
                  .match(/\s([a-z]+)/i)[1]
                  .toLowerCase(),
    uo = (e) => {
        do e += Math.floor(Math.random() * ao);
        while (document.getElementById(e));
        return e;
    },
    fo = (e) => {
        if (!e) return 0;
        let { transitionDuration: t, transitionDelay: n } =
            window.getComputedStyle(e);
        const s = Number.parseFloat(t),
            r = Number.parseFloat(n);
        return !s && !r
            ? 0
            : ((t = t.split(",")[0]),
              (n = n.split(",")[0]),
              (Number.parseFloat(t) + Number.parseFloat(n)) * co);
    },
    Tr = (e) => {
        e.dispatchEvent(new Event(bn));
    },
    tt = (e) =>
        !e || typeof e != "object"
            ? !1
            : (typeof e.jquery < "u" && (e = e[0]), typeof e.nodeType < "u"),
    ct = (e) =>
        tt(e)
            ? e.jquery
                ? e[0]
                : e
            : typeof e == "string" && e.length > 0
            ? document.querySelector(Ar(e))
            : null,
    jt = (e) => {
        if (!tt(e) || e.getClientRects().length === 0) return !1;
        const t =
                getComputedStyle(e).getPropertyValue("visibility") ===
                "visible",
            n = e.closest("details:not([open])");
        if (!n) return t;
        if (n !== e) {
            const s = e.closest("summary");
            if ((s && s.parentNode !== n) || s === null) return !1;
        }
        return t;
    },
    lt = (e) =>
        !e ||
        e.nodeType !== Node.ELEMENT_NODE ||
        e.classList.contains("disabled")
            ? !0
            : typeof e.disabled < "u"
            ? e.disabled
            : e.hasAttribute("disabled") &&
              e.getAttribute("disabled") !== "false",
    wr = (e) => {
        if (!document.documentElement.attachShadow) return null;
        if (typeof e.getRootNode == "function") {
            const t = e.getRootNode();
            return t instanceof ShadowRoot ? t : null;
        }
        return e instanceof ShadowRoot
            ? e
            : e.parentNode
            ? wr(e.parentNode)
            : null;
    },
    Ne = () => {},
    ne = (e) => {
        e.offsetHeight;
    },
    Or = () =>
        window.jQuery && !document.body.hasAttribute("data-bs-no-jquery")
            ? window.jQuery
            : null,
    Je = [],
    ho = (e) => {
        document.readyState === "loading"
            ? (Je.length ||
                  document.addEventListener("DOMContentLoaded", () => {
                      for (const t of Je) t();
                  }),
              Je.push(e))
            : e();
    },
    W = () => document.documentElement.dir === "rtl",
    K = (e) => {
        ho(() => {
            const t = Or();
            if (t) {
                const n = e.NAME,
                    s = t.fn[n];
                (t.fn[n] = e.jQueryInterface),
                    (t.fn[n].Constructor = e),
                    (t.fn[n].noConflict = () => (
                        (t.fn[n] = s), e.jQueryInterface
                    ));
            }
        });
    },
    M = (e, t = [], n = e) => (typeof e == "function" ? e(...t) : n),
    Sr = (e, t, n = !0) => {
        if (!n) {
            M(e);
            return;
        }
        const s = 5,
            r = fo(t) + s;
        let i = !1;
        const o = ({ target: a }) => {
            a === t && ((i = !0), t.removeEventListener(bn, o), M(e));
        };
        t.addEventListener(bn, o),
            setTimeout(() => {
                i || Tr(t);
            }, r);
    },
    Fn = (e, t, n, s) => {
        const r = e.length;
        let i = e.indexOf(t);
        return i === -1
            ? !n && s
                ? e[r - 1]
                : e[0]
            : ((i += n ? 1 : -1),
              s && (i = (i + r) % r),
              e[Math.max(0, Math.min(i, r - 1))]);
    },
    po = /[^.]*(?=\..*)\.|.*/,
    _o = /\..*/,
    mo = /::\d+$/,
    Qe = {};
let hs = 1;
const Cr = { mouseenter: "mouseover", mouseleave: "mouseout" },
    go = new Set([
        "click",
        "dblclick",
        "mouseup",
        "mousedown",
        "contextmenu",
        "mousewheel",
        "DOMMouseScroll",
        "mouseover",
        "mouseout",
        "mousemove",
        "selectstart",
        "selectend",
        "keydown",
        "keypress",
        "keyup",
        "orientationchange",
        "touchstart",
        "touchmove",
        "touchend",
        "touchcancel",
        "pointerdown",
        "pointermove",
        "pointerup",
        "pointerleave",
        "pointercancel",
        "gesturestart",
        "gesturechange",
        "gestureend",
        "focus",
        "blur",
        "change",
        "reset",
        "select",
        "submit",
        "focusin",
        "focusout",
        "load",
        "unload",
        "beforeunload",
        "resize",
        "move",
        "DOMContentLoaded",
        "readystatechange",
        "error",
        "abort",
        "scroll",
    ]);
function Nr(e, t) {
    return (t && `${t}::${hs++}`) || e.uidEvent || hs++;
}
function Dr(e) {
    const t = Nr(e);
    return (e.uidEvent = t), (Qe[t] = Qe[t] || {}), Qe[t];
}
function Eo(e, t) {
    return function n(s) {
        return (
            Bn(s, { delegateTarget: e }),
            n.oneOff && d.off(e, s.type, t),
            t.apply(e, [s])
        );
    };
}
function bo(e, t, n) {
    return function s(r) {
        const i = e.querySelectorAll(t);
        for (let { target: o } = r; o && o !== this; o = o.parentNode)
            for (const a of i)
                if (a === o)
                    return (
                        Bn(r, { delegateTarget: o }),
                        s.oneOff && d.off(e, r.type, t, n),
                        n.apply(o, [r])
                    );
    };
}
function Lr(e, t, n = null) {
    return Object.values(e).find(
        (s) => s.callable === t && s.delegationSelector === n
    );
}
function Rr(e, t, n) {
    const s = typeof t == "string",
        r = s ? n : t || n;
    let i = $r(e);
    return go.has(i) || (i = e), [s, r, i];
}
function ps(e, t, n, s, r) {
    if (typeof t != "string" || !e) return;
    let [i, o, a] = Rr(t, n, s);
    t in Cr &&
        (o = ((p) =>
            function (_) {
                if (
                    !_.relatedTarget ||
                    (_.relatedTarget !== _.delegateTarget &&
                        !_.delegateTarget.contains(_.relatedTarget))
                )
                    return p.call(this, _);
            })(o));
    const u = Dr(e),
        c = u[a] || (u[a] = {}),
        l = Lr(c, o, i ? n : null);
    if (l) {
        l.oneOff = l.oneOff && r;
        return;
    }
    const h = Nr(o, t.replace(po, "")),
        g = i ? bo(e, n, o) : Eo(e, o);
    (g.delegationSelector = i ? n : null),
        (g.callable = o),
        (g.oneOff = r),
        (g.uidEvent = h),
        (c[h] = g),
        e.addEventListener(a, g, i);
}
function vn(e, t, n, s, r) {
    const i = Lr(t[n], s, r);
    i && (e.removeEventListener(n, i, !!r), delete t[n][i.uidEvent]);
}
function vo(e, t, n, s) {
    const r = t[n] || {};
    for (const [i, o] of Object.entries(r))
        i.includes(s) && vn(e, t, n, o.callable, o.delegationSelector);
}
function $r(e) {
    return (e = e.replace(_o, "")), Cr[e] || e;
}
const d = {
    on(e, t, n, s) {
        ps(e, t, n, s, !1);
    },
    one(e, t, n, s) {
        ps(e, t, n, s, !0);
    },
    off(e, t, n, s) {
        if (typeof t != "string" || !e) return;
        const [r, i, o] = Rr(t, n, s),
            a = o !== t,
            u = Dr(e),
            c = u[o] || {},
            l = t.startsWith(".");
        if (typeof i < "u") {
            if (!Object.keys(c).length) return;
            vn(e, u, o, i, r ? n : null);
            return;
        }
        if (l) for (const h of Object.keys(u)) vo(e, u, h, t.slice(1));
        for (const [h, g] of Object.entries(c)) {
            const m = h.replace(mo, "");
            (!a || t.includes(m)) &&
                vn(e, u, o, g.callable, g.delegationSelector);
        }
    },
    trigger(e, t, n) {
        if (typeof t != "string" || !e) return null;
        const s = Or(),
            r = $r(t),
            i = t !== r;
        let o = null,
            a = !0,
            u = !0,
            c = !1;
        i &&
            s &&
            ((o = s.Event(t, n)),
            s(e).trigger(o),
            (a = !o.isPropagationStopped()),
            (u = !o.isImmediatePropagationStopped()),
            (c = o.isDefaultPrevented()));
        const l = Bn(new Event(t, { bubbles: a, cancelable: !0 }), n);
        return (
            c && l.preventDefault(),
            u && e.dispatchEvent(l),
            l.defaultPrevented && o && o.preventDefault(),
            l
        );
    },
};
function Bn(e, t = {}) {
    for (const [n, s] of Object.entries(t))
        try {
            e[n] = s;
        } catch {
            Object.defineProperty(e, n, {
                configurable: !0,
                get() {
                    return s;
                },
            });
        }
    return e;
}
function _s(e) {
    if (e === "true") return !0;
    if (e === "false") return !1;
    if (e === Number(e).toString()) return Number(e);
    if (e === "" || e === "null") return null;
    if (typeof e != "string") return e;
    try {
        return JSON.parse(decodeURIComponent(e));
    } catch {
        return e;
    }
}
function Ze(e) {
    return e.replace(/[A-Z]/g, (t) => `-${t.toLowerCase()}`);
}
const et = {
    setDataAttribute(e, t, n) {
        e.setAttribute(`data-bs-${Ze(t)}`, n);
    },
    removeDataAttribute(e, t) {
        e.removeAttribute(`data-bs-${Ze(t)}`);
    },
    getDataAttributes(e) {
        if (!e) return {};
        const t = {},
            n = Object.keys(e.dataset).filter(
                (s) => s.startsWith("bs") && !s.startsWith("bsConfig")
            );
        for (const s of n) {
            let r = s.replace(/^bs/, "");
            (r = r.charAt(0).toLowerCase() + r.slice(1, r.length)),
                (t[r] = _s(e.dataset[s]));
        }
        return t;
    },
    getDataAttribute(e, t) {
        return _s(e.getAttribute(`data-bs-${Ze(t)}`));
    },
};
class se {
    static get Default() {
        return {};
    }
    static get DefaultType() {
        return {};
    }
    static get NAME() {
        throw new Error(
            'You have to implement the static method "NAME", for each component!'
        );
    }
    _getConfig(t) {
        return (
            (t = this._mergeConfigObj(t)),
            (t = this._configAfterMerge(t)),
            this._typeCheckConfig(t),
            t
        );
    }
    _configAfterMerge(t) {
        return t;
    }
    _mergeConfigObj(t, n) {
        const s = tt(n) ? et.getDataAttribute(n, "config") : {};
        return {
            ...this.constructor.Default,
            ...(typeof s == "object" ? s : {}),
            ...(tt(n) ? et.getDataAttributes(n) : {}),
            ...(typeof t == "object" ? t : {}),
        };
    }
    _typeCheckConfig(t, n = this.constructor.DefaultType) {
        for (const [s, r] of Object.entries(n)) {
            const i = t[s],
                o = tt(i) ? "element" : lo(i);
            if (!new RegExp(r).test(o))
                throw new TypeError(
                    `${this.constructor.NAME.toUpperCase()}: Option "${s}" provided type "${o}" but expected type "${r}".`
                );
        }
    }
}
const yo = "5.3.1";
class q extends se {
    constructor(t, n) {
        super(),
            (t = ct(t)),
            t &&
                ((this._element = t),
                (this._config = this._getConfig(n)),
                Xe.set(this._element, this.constructor.DATA_KEY, this));
    }
    dispose() {
        Xe.remove(this._element, this.constructor.DATA_KEY),
            d.off(this._element, this.constructor.EVENT_KEY);
        for (const t of Object.getOwnPropertyNames(this)) this[t] = null;
    }
    _queueCallback(t, n, s = !0) {
        Sr(t, n, s);
    }
    _getConfig(t) {
        return (
            (t = this._mergeConfigObj(t, this._element)),
            (t = this._configAfterMerge(t)),
            this._typeCheckConfig(t),
            t
        );
    }
    static getInstance(t) {
        return Xe.get(ct(t), this.DATA_KEY);
    }
    static getOrCreateInstance(t, n = {}) {
        return (
            this.getInstance(t) || new this(t, typeof n == "object" ? n : null)
        );
    }
    static get VERSION() {
        return yo;
    }
    static get DATA_KEY() {
        return `bs.${this.NAME}`;
    }
    static get EVENT_KEY() {
        return `.${this.DATA_KEY}`;
    }
    static eventName(t) {
        return `${t}${this.EVENT_KEY}`;
    }
}
const tn = (e) => {
        let t = e.getAttribute("data-bs-target");
        if (!t || t === "#") {
            let n = e.getAttribute("href");
            if (!n || (!n.includes("#") && !n.startsWith("."))) return null;
            n.includes("#") &&
                !n.startsWith("#") &&
                (n = `#${n.split("#")[1]}`),
                (t = n && n !== "#" ? n.trim() : null);
        }
        return Ar(t);
    },
    E = {
        find(e, t = document.documentElement) {
            return [].concat(...Element.prototype.querySelectorAll.call(t, e));
        },
        findOne(e, t = document.documentElement) {
            return Element.prototype.querySelector.call(t, e);
        },
        children(e, t) {
            return [].concat(...e.children).filter((n) => n.matches(t));
        },
        parents(e, t) {
            const n = [];
            let s = e.parentNode.closest(t);
            for (; s; ) n.push(s), (s = s.parentNode.closest(t));
            return n;
        },
        prev(e, t) {
            let n = e.previousElementSibling;
            for (; n; ) {
                if (n.matches(t)) return [n];
                n = n.previousElementSibling;
            }
            return [];
        },
        next(e, t) {
            let n = e.nextElementSibling;
            for (; n; ) {
                if (n.matches(t)) return [n];
                n = n.nextElementSibling;
            }
            return [];
        },
        focusableChildren(e) {
            const t = [
                "a",
                "button",
                "input",
                "textarea",
                "select",
                "details",
                "[tabindex]",
                '[contenteditable="true"]',
            ]
                .map((n) => `${n}:not([tabindex^="-"])`)
                .join(",");
            return this.find(t, e).filter((n) => !lt(n) && jt(n));
        },
        getSelectorFromElement(e) {
            const t = tn(e);
            return t && E.findOne(t) ? t : null;
        },
        getElementFromSelector(e) {
            const t = tn(e);
            return t ? E.findOne(t) : null;
        },
        getMultipleElementsFromSelector(e) {
            const t = tn(e);
            return t ? E.find(t) : [];
        },
    },
    xe = (e, t = "hide") => {
        const n = `click.dismiss${e.EVENT_KEY}`,
            s = e.NAME;
        d.on(document, n, `[data-bs-dismiss="${s}"]`, function (r) {
            if (
                (["A", "AREA"].includes(this.tagName) && r.preventDefault(),
                lt(this))
            )
                return;
            const i = E.getElementFromSelector(this) || this.closest(`.${s}`);
            e.getOrCreateInstance(i)[t]();
        });
    },
    Ao = "alert",
    To = "bs.alert",
    Ir = `.${To}`,
    wo = `close${Ir}`,
    Oo = `closed${Ir}`,
    So = "fade",
    Co = "show";
class Me extends q {
    static get NAME() {
        return Ao;
    }
    close() {
        if (d.trigger(this._element, wo).defaultPrevented) return;
        this._element.classList.remove(Co);
        const n = this._element.classList.contains(So);
        this._queueCallback(() => this._destroyElement(), this._element, n);
    }
    _destroyElement() {
        this._element.remove(), d.trigger(this._element, Oo), this.dispose();
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = Me.getOrCreateInstance(this);
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                n[t](this);
            }
        });
    }
}
xe(Me, "close");
K(Me);
const No = "button",
    Do = "bs.button",
    Lo = `.${Do}`,
    Ro = ".data-api",
    $o = "active",
    ms = '[data-bs-toggle="button"]',
    Io = `click${Lo}${Ro}`;
class ke extends q {
    static get NAME() {
        return No;
    }
    toggle() {
        this._element.setAttribute(
            "aria-pressed",
            this._element.classList.toggle($o)
        );
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = ke.getOrCreateInstance(this);
            t === "toggle" && n[t]();
        });
    }
}
d.on(document, Io, ms, (e) => {
    e.preventDefault();
    const t = e.target.closest(ms);
    ke.getOrCreateInstance(t).toggle();
});
K(ke);
const Po = "swipe",
    Wt = ".bs.swipe",
    xo = `touchstart${Wt}`,
    Mo = `touchmove${Wt}`,
    ko = `touchend${Wt}`,
    Vo = `pointerdown${Wt}`,
    Ho = `pointerup${Wt}`,
    Fo = "touch",
    Bo = "pen",
    jo = "pointer-event",
    Wo = 40,
    Uo = { endCallback: null, leftCallback: null, rightCallback: null },
    Ko = {
        endCallback: "(function|null)",
        leftCallback: "(function|null)",
        rightCallback: "(function|null)",
    };
class De extends se {
    constructor(t, n) {
        super(),
            (this._element = t),
            !(!t || !De.isSupported()) &&
                ((this._config = this._getConfig(n)),
                (this._deltaX = 0),
                (this._supportPointerEvents = !!window.PointerEvent),
                this._initEvents());
    }
    static get Default() {
        return Uo;
    }
    static get DefaultType() {
        return Ko;
    }
    static get NAME() {
        return Po;
    }
    dispose() {
        d.off(this._element, Wt);
    }
    _start(t) {
        if (!this._supportPointerEvents) {
            this._deltaX = t.touches[0].clientX;
            return;
        }
        this._eventIsPointerPenTouch(t) && (this._deltaX = t.clientX);
    }
    _end(t) {
        this._eventIsPointerPenTouch(t) &&
            (this._deltaX = t.clientX - this._deltaX),
            this._handleSwipe(),
            M(this._config.endCallback);
    }
    _move(t) {
        this._deltaX =
            t.touches && t.touches.length > 1
                ? 0
                : t.touches[0].clientX - this._deltaX;
    }
    _handleSwipe() {
        const t = Math.abs(this._deltaX);
        if (t <= Wo) return;
        const n = t / this._deltaX;
        (this._deltaX = 0),
            n &&
                M(
                    n > 0
                        ? this._config.rightCallback
                        : this._config.leftCallback
                );
    }
    _initEvents() {
        this._supportPointerEvents
            ? (d.on(this._element, Vo, (t) => this._start(t)),
              d.on(this._element, Ho, (t) => this._end(t)),
              this._element.classList.add(jo))
            : (d.on(this._element, xo, (t) => this._start(t)),
              d.on(this._element, Mo, (t) => this._move(t)),
              d.on(this._element, ko, (t) => this._end(t)));
    }
    _eventIsPointerPenTouch(t) {
        return (
            this._supportPointerEvents &&
            (t.pointerType === Bo || t.pointerType === Fo)
        );
    }
    static isSupported() {
        return (
            "ontouchstart" in document.documentElement ||
            navigator.maxTouchPoints > 0
        );
    }
}
const Yo = "carousel",
    zo = "bs.carousel",
    dt = `.${zo}`,
    Pr = ".data-api",
    qo = "ArrowLeft",
    Go = "ArrowRight",
    Xo = 500,
    qt = "next",
    Ct = "prev",
    Lt = "left",
    ye = "right",
    Jo = `slide${dt}`,
    en = `slid${dt}`,
    Qo = `keydown${dt}`,
    Zo = `mouseenter${dt}`,
    ta = `mouseleave${dt}`,
    ea = `dragstart${dt}`,
    na = `load${dt}${Pr}`,
    sa = `click${dt}${Pr}`,
    xr = "carousel",
    pe = "active",
    ra = "slide",
    ia = "carousel-item-end",
    oa = "carousel-item-start",
    aa = "carousel-item-next",
    ca = "carousel-item-prev",
    Mr = ".active",
    kr = ".carousel-item",
    la = Mr + kr,
    ua = ".carousel-item img",
    fa = ".carousel-indicators",
    da = "[data-bs-slide], [data-bs-slide-to]",
    ha = '[data-bs-ride="carousel"]',
    pa = { [qo]: ye, [Go]: Lt },
    _a = {
        interval: 5e3,
        keyboard: !0,
        pause: "hover",
        ride: !1,
        touch: !0,
        wrap: !0,
    },
    ma = {
        interval: "(number|boolean)",
        keyboard: "boolean",
        pause: "(string|boolean)",
        ride: "(boolean|string)",
        touch: "boolean",
        wrap: "boolean",
    };
class re extends q {
    constructor(t, n) {
        super(t, n),
            (this._interval = null),
            (this._activeElement = null),
            (this._isSliding = !1),
            (this.touchTimeout = null),
            (this._swipeHelper = null),
            (this._indicatorsElement = E.findOne(fa, this._element)),
            this._addEventListeners(),
            this._config.ride === xr && this.cycle();
    }
    static get Default() {
        return _a;
    }
    static get DefaultType() {
        return ma;
    }
    static get NAME() {
        return Yo;
    }
    next() {
        this._slide(qt);
    }
    nextWhenVisible() {
        !document.hidden && jt(this._element) && this.next();
    }
    prev() {
        this._slide(Ct);
    }
    pause() {
        this._isSliding && Tr(this._element), this._clearInterval();
    }
    cycle() {
        this._clearInterval(),
            this._updateInterval(),
            (this._interval = setInterval(
                () => this.nextWhenVisible(),
                this._config.interval
            ));
    }
    _maybeEnableCycle() {
        if (this._config.ride) {
            if (this._isSliding) {
                d.one(this._element, en, () => this.cycle());
                return;
            }
            this.cycle();
        }
    }
    to(t) {
        const n = this._getItems();
        if (t > n.length - 1 || t < 0) return;
        if (this._isSliding) {
            d.one(this._element, en, () => this.to(t));
            return;
        }
        const s = this._getItemIndex(this._getActive());
        if (s === t) return;
        const r = t > s ? qt : Ct;
        this._slide(r, n[t]);
    }
    dispose() {
        this._swipeHelper && this._swipeHelper.dispose(), super.dispose();
    }
    _configAfterMerge(t) {
        return (t.defaultInterval = t.interval), t;
    }
    _addEventListeners() {
        this._config.keyboard &&
            d.on(this._element, Qo, (t) => this._keydown(t)),
            this._config.pause === "hover" &&
                (d.on(this._element, Zo, () => this.pause()),
                d.on(this._element, ta, () => this._maybeEnableCycle())),
            this._config.touch &&
                De.isSupported() &&
                this._addTouchEventListeners();
    }
    _addTouchEventListeners() {
        for (const s of E.find(ua, this._element))
            d.on(s, ea, (r) => r.preventDefault());
        const n = {
            leftCallback: () => this._slide(this._directionToOrder(Lt)),
            rightCallback: () => this._slide(this._directionToOrder(ye)),
            endCallback: () => {
                this._config.pause === "hover" &&
                    (this.pause(),
                    this.touchTimeout && clearTimeout(this.touchTimeout),
                    (this.touchTimeout = setTimeout(
                        () => this._maybeEnableCycle(),
                        Xo + this._config.interval
                    )));
            },
        };
        this._swipeHelper = new De(this._element, n);
    }
    _keydown(t) {
        if (/input|textarea/i.test(t.target.tagName)) return;
        const n = pa[t.key];
        n && (t.preventDefault(), this._slide(this._directionToOrder(n)));
    }
    _getItemIndex(t) {
        return this._getItems().indexOf(t);
    }
    _setActiveIndicatorElement(t) {
        if (!this._indicatorsElement) return;
        const n = E.findOne(Mr, this._indicatorsElement);
        n.classList.remove(pe), n.removeAttribute("aria-current");
        const s = E.findOne(
            `[data-bs-slide-to="${t}"]`,
            this._indicatorsElement
        );
        s && (s.classList.add(pe), s.setAttribute("aria-current", "true"));
    }
    _updateInterval() {
        const t = this._activeElement || this._getActive();
        if (!t) return;
        const n = Number.parseInt(t.getAttribute("data-bs-interval"), 10);
        this._config.interval = n || this._config.defaultInterval;
    }
    _slide(t, n = null) {
        if (this._isSliding) return;
        const s = this._getActive(),
            r = t === qt,
            i = n || Fn(this._getItems(), s, r, this._config.wrap);
        if (i === s) return;
        const o = this._getItemIndex(i),
            a = (m) =>
                d.trigger(this._element, m, {
                    relatedTarget: i,
                    direction: this._orderToDirection(t),
                    from: this._getItemIndex(s),
                    to: o,
                });
        if (a(Jo).defaultPrevented || !s || !i) return;
        const c = !!this._interval;
        this.pause(),
            (this._isSliding = !0),
            this._setActiveIndicatorElement(o),
            (this._activeElement = i);
        const l = r ? oa : ia,
            h = r ? aa : ca;
        i.classList.add(h), ne(i), s.classList.add(l), i.classList.add(l);
        const g = () => {
            i.classList.remove(l, h),
                i.classList.add(pe),
                s.classList.remove(pe, h, l),
                (this._isSliding = !1),
                a(en);
        };
        this._queueCallback(g, s, this._isAnimated()), c && this.cycle();
    }
    _isAnimated() {
        return this._element.classList.contains(ra);
    }
    _getActive() {
        return E.findOne(la, this._element);
    }
    _getItems() {
        return E.find(kr, this._element);
    }
    _clearInterval() {
        this._interval &&
            (clearInterval(this._interval), (this._interval = null));
    }
    _directionToOrder(t) {
        return W() ? (t === Lt ? Ct : qt) : t === Lt ? qt : Ct;
    }
    _orderToDirection(t) {
        return W() ? (t === Ct ? Lt : ye) : t === Ct ? ye : Lt;
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = re.getOrCreateInstance(this, t);
            if (typeof t == "number") {
                n.to(t);
                return;
            }
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                n[t]();
            }
        });
    }
}
d.on(document, sa, da, function (e) {
    const t = E.getElementFromSelector(this);
    if (!t || !t.classList.contains(xr)) return;
    e.preventDefault();
    const n = re.getOrCreateInstance(t),
        s = this.getAttribute("data-bs-slide-to");
    if (s) {
        n.to(s), n._maybeEnableCycle();
        return;
    }
    if (et.getDataAttribute(this, "slide") === "next") {
        n.next(), n._maybeEnableCycle();
        return;
    }
    n.prev(), n._maybeEnableCycle();
});
d.on(window, na, () => {
    const e = E.find(ha);
    for (const t of e) re.getOrCreateInstance(t);
});
K(re);
const ga = "collapse",
    Ea = "bs.collapse",
    ie = `.${Ea}`,
    ba = ".data-api",
    va = `show${ie}`,
    ya = `shown${ie}`,
    Aa = `hide${ie}`,
    Ta = `hidden${ie}`,
    wa = `click${ie}${ba}`,
    nn = "show",
    $t = "collapse",
    _e = "collapsing",
    Oa = "collapsed",
    Sa = `:scope .${$t} .${$t}`,
    Ca = "collapse-horizontal",
    Na = "width",
    Da = "height",
    La = ".collapse.show, .collapse.collapsing",
    yn = '[data-bs-toggle="collapse"]',
    Ra = { parent: null, toggle: !0 },
    $a = { parent: "(null|element)", toggle: "boolean" };
class Zt extends q {
    constructor(t, n) {
        super(t, n), (this._isTransitioning = !1), (this._triggerArray = []);
        const s = E.find(yn);
        for (const r of s) {
            const i = E.getSelectorFromElement(r),
                o = E.find(i).filter((a) => a === this._element);
            i !== null && o.length && this._triggerArray.push(r);
        }
        this._initializeChildren(),
            this._config.parent ||
                this._addAriaAndCollapsedClass(
                    this._triggerArray,
                    this._isShown()
                ),
            this._config.toggle && this.toggle();
    }
    static get Default() {
        return Ra;
    }
    static get DefaultType() {
        return $a;
    }
    static get NAME() {
        return ga;
    }
    toggle() {
        this._isShown() ? this.hide() : this.show();
    }
    show() {
        if (this._isTransitioning || this._isShown()) return;
        let t = [];
        if (
            (this._config.parent &&
                (t = this._getFirstLevelChildren(La)
                    .filter((a) => a !== this._element)
                    .map((a) => Zt.getOrCreateInstance(a, { toggle: !1 }))),
            (t.length && t[0]._isTransitioning) ||
                d.trigger(this._element, va).defaultPrevented)
        )
            return;
        for (const a of t) a.hide();
        const s = this._getDimension();
        this._element.classList.remove($t),
            this._element.classList.add(_e),
            (this._element.style[s] = 0),
            this._addAriaAndCollapsedClass(this._triggerArray, !0),
            (this._isTransitioning = !0);
        const r = () => {
                (this._isTransitioning = !1),
                    this._element.classList.remove(_e),
                    this._element.classList.add($t, nn),
                    (this._element.style[s] = ""),
                    d.trigger(this._element, ya);
            },
            o = `scroll${s[0].toUpperCase() + s.slice(1)}`;
        this._queueCallback(r, this._element, !0),
            (this._element.style[s] = `${this._element[o]}px`);
    }
    hide() {
        if (
            this._isTransitioning ||
            !this._isShown() ||
            d.trigger(this._element, Aa).defaultPrevented
        )
            return;
        const n = this._getDimension();
        (this._element.style[n] = `${
            this._element.getBoundingClientRect()[n]
        }px`),
            ne(this._element),
            this._element.classList.add(_e),
            this._element.classList.remove($t, nn);
        for (const r of this._triggerArray) {
            const i = E.getElementFromSelector(r);
            i && !this._isShown(i) && this._addAriaAndCollapsedClass([r], !1);
        }
        this._isTransitioning = !0;
        const s = () => {
            (this._isTransitioning = !1),
                this._element.classList.remove(_e),
                this._element.classList.add($t),
                d.trigger(this._element, Ta);
        };
        (this._element.style[n] = ""),
            this._queueCallback(s, this._element, !0);
    }
    _isShown(t = this._element) {
        return t.classList.contains(nn);
    }
    _configAfterMerge(t) {
        return (t.toggle = !!t.toggle), (t.parent = ct(t.parent)), t;
    }
    _getDimension() {
        return this._element.classList.contains(Ca) ? Na : Da;
    }
    _initializeChildren() {
        if (!this._config.parent) return;
        const t = this._getFirstLevelChildren(yn);
        for (const n of t) {
            const s = E.getElementFromSelector(n);
            s && this._addAriaAndCollapsedClass([n], this._isShown(s));
        }
    }
    _getFirstLevelChildren(t) {
        const n = E.find(Sa, this._config.parent);
        return E.find(t, this._config.parent).filter((s) => !n.includes(s));
    }
    _addAriaAndCollapsedClass(t, n) {
        if (t.length)
            for (const s of t)
                s.classList.toggle(Oa, !n), s.setAttribute("aria-expanded", n);
    }
    static jQueryInterface(t) {
        const n = {};
        return (
            typeof t == "string" && /show|hide/.test(t) && (n.toggle = !1),
            this.each(function () {
                const s = Zt.getOrCreateInstance(this, n);
                if (typeof t == "string") {
                    if (typeof s[t] > "u")
                        throw new TypeError(`No method named "${t}"`);
                    s[t]();
                }
            })
        );
    }
}
d.on(document, wa, yn, function (e) {
    (e.target.tagName === "A" ||
        (e.delegateTarget && e.delegateTarget.tagName === "A")) &&
        e.preventDefault();
    for (const t of E.getMultipleElementsFromSelector(this))
        Zt.getOrCreateInstance(t, { toggle: !1 }).toggle();
});
K(Zt);
const gs = "dropdown",
    Ia = "bs.dropdown",
    wt = `.${Ia}`,
    jn = ".data-api",
    Pa = "Escape",
    Es = "Tab",
    xa = "ArrowUp",
    bs = "ArrowDown",
    Ma = 2,
    ka = `hide${wt}`,
    Va = `hidden${wt}`,
    Ha = `show${wt}`,
    Fa = `shown${wt}`,
    Vr = `click${wt}${jn}`,
    Hr = `keydown${wt}${jn}`,
    Ba = `keyup${wt}${jn}`,
    Rt = "show",
    ja = "dropup",
    Wa = "dropend",
    Ua = "dropstart",
    Ka = "dropup-center",
    Ya = "dropdown-center",
    bt = '[data-bs-toggle="dropdown"]:not(.disabled):not(:disabled)',
    za = `${bt}.${Rt}`,
    Ae = ".dropdown-menu",
    qa = ".navbar",
    Ga = ".navbar-nav",
    Xa = ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)",
    Ja = W() ? "top-end" : "top-start",
    Qa = W() ? "top-start" : "top-end",
    Za = W() ? "bottom-end" : "bottom-start",
    tc = W() ? "bottom-start" : "bottom-end",
    ec = W() ? "left-start" : "right-start",
    nc = W() ? "right-start" : "left-start",
    sc = "top",
    rc = "bottom",
    ic = {
        autoClose: !0,
        boundary: "clippingParents",
        display: "dynamic",
        offset: [0, 2],
        popperConfig: null,
        reference: "toggle",
    },
    oc = {
        autoClose: "(boolean|string)",
        boundary: "(string|element)",
        display: "string",
        offset: "(array|string|function)",
        popperConfig: "(null|object|function)",
        reference: "(string|element|object)",
    };
class J extends q {
    constructor(t, n) {
        super(t, n),
            (this._popper = null),
            (this._parent = this._element.parentNode),
            (this._menu =
                E.next(this._element, Ae)[0] ||
                E.prev(this._element, Ae)[0] ||
                E.findOne(Ae, this._parent)),
            (this._inNavbar = this._detectNavbar());
    }
    static get Default() {
        return ic;
    }
    static get DefaultType() {
        return oc;
    }
    static get NAME() {
        return gs;
    }
    toggle() {
        return this._isShown() ? this.hide() : this.show();
    }
    show() {
        if (lt(this._element) || this._isShown()) return;
        const t = { relatedTarget: this._element };
        if (!d.trigger(this._element, Ha, t).defaultPrevented) {
            if (
                (this._createPopper(),
                "ontouchstart" in document.documentElement &&
                    !this._parent.closest(Ga))
            )
                for (const s of [].concat(...document.body.children))
                    d.on(s, "mouseover", Ne);
            this._element.focus(),
                this._element.setAttribute("aria-expanded", !0),
                this._menu.classList.add(Rt),
                this._element.classList.add(Rt),
                d.trigger(this._element, Fa, t);
        }
    }
    hide() {
        if (lt(this._element) || !this._isShown()) return;
        const t = { relatedTarget: this._element };
        this._completeHide(t);
    }
    dispose() {
        this._popper && this._popper.destroy(), super.dispose();
    }
    update() {
        (this._inNavbar = this._detectNavbar()),
            this._popper && this._popper.update();
    }
    _completeHide(t) {
        if (!d.trigger(this._element, ka, t).defaultPrevented) {
            if ("ontouchstart" in document.documentElement)
                for (const s of [].concat(...document.body.children))
                    d.off(s, "mouseover", Ne);
            this._popper && this._popper.destroy(),
                this._menu.classList.remove(Rt),
                this._element.classList.remove(Rt),
                this._element.setAttribute("aria-expanded", "false"),
                et.removeDataAttribute(this._menu, "popper"),
                d.trigger(this._element, Va, t);
        }
    }
    _getConfig(t) {
        if (
            ((t = super._getConfig(t)),
            typeof t.reference == "object" &&
                !tt(t.reference) &&
                typeof t.reference.getBoundingClientRect != "function")
        )
            throw new TypeError(
                `${gs.toUpperCase()}: Option "reference" provided type "object" without a required "getBoundingClientRect" method.`
            );
        return t;
    }
    _createPopper() {
        if (typeof yr > "u")
            throw new TypeError(
                "Bootstrap's dropdowns require Popper (https://popper.js.org)"
            );
        let t = this._element;
        this._config.reference === "parent"
            ? (t = this._parent)
            : tt(this._config.reference)
            ? (t = ct(this._config.reference))
            : typeof this._config.reference == "object" &&
              (t = this._config.reference);
        const n = this._getPopperConfig();
        this._popper = Hn(t, this._menu, n);
    }
    _isShown() {
        return this._menu.classList.contains(Rt);
    }
    _getPlacement() {
        const t = this._parent;
        if (t.classList.contains(Wa)) return ec;
        if (t.classList.contains(Ua)) return nc;
        if (t.classList.contains(Ka)) return sc;
        if (t.classList.contains(Ya)) return rc;
        const n =
            getComputedStyle(this._menu)
                .getPropertyValue("--bs-position")
                .trim() === "end";
        return t.classList.contains(ja) ? (n ? Qa : Ja) : n ? tc : Za;
    }
    _detectNavbar() {
        return this._element.closest(qa) !== null;
    }
    _getOffset() {
        const { offset: t } = this._config;
        return typeof t == "string"
            ? t.split(",").map((n) => Number.parseInt(n, 10))
            : typeof t == "function"
            ? (n) => t(n, this._element)
            : t;
    }
    _getPopperConfig() {
        const t = {
            placement: this._getPlacement(),
            modifiers: [
                {
                    name: "preventOverflow",
                    options: { boundary: this._config.boundary },
                },
                { name: "offset", options: { offset: this._getOffset() } },
            ],
        };
        return (
            (this._inNavbar || this._config.display === "static") &&
                (et.setDataAttribute(this._menu, "popper", "static"),
                (t.modifiers = [{ name: "applyStyles", enabled: !1 }])),
            { ...t, ...M(this._config.popperConfig, [t]) }
        );
    }
    _selectMenuItem({ key: t, target: n }) {
        const s = E.find(Xa, this._menu).filter((r) => jt(r));
        s.length && Fn(s, n, t === bs, !s.includes(n)).focus();
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = J.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof n[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                n[t]();
            }
        });
    }
    static clearMenus(t) {
        if (t.button === Ma || (t.type === "keyup" && t.key !== Es)) return;
        const n = E.find(za);
        for (const s of n) {
            const r = J.getInstance(s);
            if (!r || r._config.autoClose === !1) continue;
            const i = t.composedPath(),
                o = i.includes(r._menu);
            if (
                i.includes(r._element) ||
                (r._config.autoClose === "inside" && !o) ||
                (r._config.autoClose === "outside" && o) ||
                (r._menu.contains(t.target) &&
                    ((t.type === "keyup" && t.key === Es) ||
                        /input|select|option|textarea|form/i.test(
                            t.target.tagName
                        )))
            )
                continue;
            const a = { relatedTarget: r._element };
            t.type === "click" && (a.clickEvent = t), r._completeHide(a);
        }
    }
    static dataApiKeydownHandler(t) {
        const n = /input|textarea/i.test(t.target.tagName),
            s = t.key === Pa,
            r = [xa, bs].includes(t.key);
        if ((!r && !s) || (n && !s)) return;
        t.preventDefault();
        const i = this.matches(bt)
                ? this
                : E.prev(this, bt)[0] ||
                  E.next(this, bt)[0] ||
                  E.findOne(bt, t.delegateTarget.parentNode),
            o = J.getOrCreateInstance(i);
        if (r) {
            t.stopPropagation(), o.show(), o._selectMenuItem(t);
            return;
        }
        o._isShown() && (t.stopPropagation(), o.hide(), i.focus());
    }
}
d.on(document, Hr, bt, J.dataApiKeydownHandler);
d.on(document, Hr, Ae, J.dataApiKeydownHandler);
d.on(document, Vr, J.clearMenus);
d.on(document, Ba, J.clearMenus);
d.on(document, Vr, bt, function (e) {
    e.preventDefault(), J.getOrCreateInstance(this).toggle();
});
K(J);
const Fr = "backdrop",
    ac = "fade",
    vs = "show",
    ys = `mousedown.bs.${Fr}`,
    cc = {
        className: "modal-backdrop",
        clickCallback: null,
        isAnimated: !1,
        isVisible: !0,
        rootElement: "body",
    },
    lc = {
        className: "string",
        clickCallback: "(function|null)",
        isAnimated: "boolean",
        isVisible: "boolean",
        rootElement: "(element|string)",
    };
class Br extends se {
    constructor(t) {
        super(),
            (this._config = this._getConfig(t)),
            (this._isAppended = !1),
            (this._element = null);
    }
    static get Default() {
        return cc;
    }
    static get DefaultType() {
        return lc;
    }
    static get NAME() {
        return Fr;
    }
    show(t) {
        if (!this._config.isVisible) {
            M(t);
            return;
        }
        this._append();
        const n = this._getElement();
        this._config.isAnimated && ne(n),
            n.classList.add(vs),
            this._emulateAnimation(() => {
                M(t);
            });
    }
    hide(t) {
        if (!this._config.isVisible) {
            M(t);
            return;
        }
        this._getElement().classList.remove(vs),
            this._emulateAnimation(() => {
                this.dispose(), M(t);
            });
    }
    dispose() {
        this._isAppended &&
            (d.off(this._element, ys),
            this._element.remove(),
            (this._isAppended = !1));
    }
    _getElement() {
        if (!this._element) {
            const t = document.createElement("div");
            (t.className = this._config.className),
                this._config.isAnimated && t.classList.add(ac),
                (this._element = t);
        }
        return this._element;
    }
    _configAfterMerge(t) {
        return (t.rootElement = ct(t.rootElement)), t;
    }
    _append() {
        if (this._isAppended) return;
        const t = this._getElement();
        this._config.rootElement.append(t),
            d.on(t, ys, () => {
                M(this._config.clickCallback);
            }),
            (this._isAppended = !0);
    }
    _emulateAnimation(t) {
        Sr(t, this._getElement(), this._config.isAnimated);
    }
}
const uc = "focustrap",
    fc = "bs.focustrap",
    Le = `.${fc}`,
    dc = `focusin${Le}`,
    hc = `keydown.tab${Le}`,
    pc = "Tab",
    _c = "forward",
    As = "backward",
    mc = { autofocus: !0, trapElement: null },
    gc = { autofocus: "boolean", trapElement: "element" };
class jr extends se {
    constructor(t) {
        super(),
            (this._config = this._getConfig(t)),
            (this._isActive = !1),
            (this._lastTabNavDirection = null);
    }
    static get Default() {
        return mc;
    }
    static get DefaultType() {
        return gc;
    }
    static get NAME() {
        return uc;
    }
    activate() {
        this._isActive ||
            (this._config.autofocus && this._config.trapElement.focus(),
            d.off(document, Le),
            d.on(document, dc, (t) => this._handleFocusin(t)),
            d.on(document, hc, (t) => this._handleKeydown(t)),
            (this._isActive = !0));
    }
    deactivate() {
        this._isActive && ((this._isActive = !1), d.off(document, Le));
    }
    _handleFocusin(t) {
        const { trapElement: n } = this._config;
        if (t.target === document || t.target === n || n.contains(t.target))
            return;
        const s = E.focusableChildren(n);
        s.length === 0
            ? n.focus()
            : this._lastTabNavDirection === As
            ? s[s.length - 1].focus()
            : s[0].focus();
    }
    _handleKeydown(t) {
        t.key === pc && (this._lastTabNavDirection = t.shiftKey ? As : _c);
    }
}
const Ts = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",
    ws = ".sticky-top",
    me = "padding-right",
    Os = "margin-right";
class An {
    constructor() {
        this._element = document.body;
    }
    getWidth() {
        const t = document.documentElement.clientWidth;
        return Math.abs(window.innerWidth - t);
    }
    hide() {
        const t = this.getWidth();
        this._disableOverFlow(),
            this._setElementAttributes(this._element, me, (n) => n + t),
            this._setElementAttributes(Ts, me, (n) => n + t),
            this._setElementAttributes(ws, Os, (n) => n - t);
    }
    reset() {
        this._resetElementAttributes(this._element, "overflow"),
            this._resetElementAttributes(this._element, me),
            this._resetElementAttributes(Ts, me),
            this._resetElementAttributes(ws, Os);
    }
    isOverflowing() {
        return this.getWidth() > 0;
    }
    _disableOverFlow() {
        this._saveInitialAttribute(this._element, "overflow"),
            (this._element.style.overflow = "hidden");
    }
    _setElementAttributes(t, n, s) {
        const r = this.getWidth(),
            i = (o) => {
                if (
                    o !== this._element &&
                    window.innerWidth > o.clientWidth + r
                )
                    return;
                this._saveInitialAttribute(o, n);
                const a = window.getComputedStyle(o).getPropertyValue(n);
                o.style.setProperty(n, `${s(Number.parseFloat(a))}px`);
            };
        this._applyManipulationCallback(t, i);
    }
    _saveInitialAttribute(t, n) {
        const s = t.style.getPropertyValue(n);
        s && et.setDataAttribute(t, n, s);
    }
    _resetElementAttributes(t, n) {
        const s = (r) => {
            const i = et.getDataAttribute(r, n);
            if (i === null) {
                r.style.removeProperty(n);
                return;
            }
            et.removeDataAttribute(r, n), r.style.setProperty(n, i);
        };
        this._applyManipulationCallback(t, s);
    }
    _applyManipulationCallback(t, n) {
        if (tt(t)) {
            n(t);
            return;
        }
        for (const s of E.find(t, this._element)) n(s);
    }
}
const Ec = "modal",
    bc = "bs.modal",
    U = `.${bc}`,
    vc = ".data-api",
    yc = "Escape",
    Ac = `hide${U}`,
    Tc = `hidePrevented${U}`,
    Wr = `hidden${U}`,
    Ur = `show${U}`,
    wc = `shown${U}`,
    Oc = `resize${U}`,
    Sc = `click.dismiss${U}`,
    Cc = `mousedown.dismiss${U}`,
    Nc = `keydown.dismiss${U}`,
    Dc = `click${U}${vc}`,
    Ss = "modal-open",
    Lc = "fade",
    Cs = "show",
    sn = "modal-static",
    Rc = ".modal.show",
    $c = ".modal-dialog",
    Ic = ".modal-body",
    Pc = '[data-bs-toggle="modal"]',
    xc = { backdrop: !0, focus: !0, keyboard: !0 },
    Mc = {
        backdrop: "(boolean|string)",
        focus: "boolean",
        keyboard: "boolean",
    };
class Vt extends q {
    constructor(t, n) {
        super(t, n),
            (this._dialog = E.findOne($c, this._element)),
            (this._backdrop = this._initializeBackDrop()),
            (this._focustrap = this._initializeFocusTrap()),
            (this._isShown = !1),
            (this._isTransitioning = !1),
            (this._scrollBar = new An()),
            this._addEventListeners();
    }
    static get Default() {
        return xc;
    }
    static get DefaultType() {
        return Mc;
    }
    static get NAME() {
        return Ec;
    }
    toggle(t) {
        return this._isShown ? this.hide() : this.show(t);
    }
    show(t) {
        this._isShown ||
            this._isTransitioning ||
            d.trigger(this._element, Ur, { relatedTarget: t })
                .defaultPrevented ||
            ((this._isShown = !0),
            (this._isTransitioning = !0),
            this._scrollBar.hide(),
            document.body.classList.add(Ss),
            this._adjustDialog(),
            this._backdrop.show(() => this._showElement(t)));
    }
    hide() {
        !this._isShown ||
            this._isTransitioning ||
            d.trigger(this._element, Ac).defaultPrevented ||
            ((this._isShown = !1),
            (this._isTransitioning = !0),
            this._focustrap.deactivate(),
            this._element.classList.remove(Cs),
            this._queueCallback(
                () => this._hideModal(),
                this._element,
                this._isAnimated()
            ));
    }
    dispose() {
        d.off(window, U),
            d.off(this._dialog, U),
            this._backdrop.dispose(),
            this._focustrap.deactivate(),
            super.dispose();
    }
    handleUpdate() {
        this._adjustDialog();
    }
    _initializeBackDrop() {
        return new Br({
            isVisible: !!this._config.backdrop,
            isAnimated: this._isAnimated(),
        });
    }
    _initializeFocusTrap() {
        return new jr({ trapElement: this._element });
    }
    _showElement(t) {
        document.body.contains(this._element) ||
            document.body.append(this._element),
            (this._element.style.display = "block"),
            this._element.removeAttribute("aria-hidden"),
            this._element.setAttribute("aria-modal", !0),
            this._element.setAttribute("role", "dialog"),
            (this._element.scrollTop = 0);
        const n = E.findOne(Ic, this._dialog);
        n && (n.scrollTop = 0),
            ne(this._element),
            this._element.classList.add(Cs);
        const s = () => {
            this._config.focus && this._focustrap.activate(),
                (this._isTransitioning = !1),
                d.trigger(this._element, wc, { relatedTarget: t });
        };
        this._queueCallback(s, this._dialog, this._isAnimated());
    }
    _addEventListeners() {
        d.on(this._element, Nc, (t) => {
            if (t.key === yc) {
                if (this._config.keyboard) {
                    this.hide();
                    return;
                }
                this._triggerBackdropTransition();
            }
        }),
            d.on(window, Oc, () => {
                this._isShown && !this._isTransitioning && this._adjustDialog();
            }),
            d.on(this._element, Cc, (t) => {
                d.one(this._element, Sc, (n) => {
                    if (
                        !(
                            this._element !== t.target ||
                            this._element !== n.target
                        )
                    ) {
                        if (this._config.backdrop === "static") {
                            this._triggerBackdropTransition();
                            return;
                        }
                        this._config.backdrop && this.hide();
                    }
                });
            });
    }
    _hideModal() {
        (this._element.style.display = "none"),
            this._element.setAttribute("aria-hidden", !0),
            this._element.removeAttribute("aria-modal"),
            this._element.removeAttribute("role"),
            (this._isTransitioning = !1),
            this._backdrop.hide(() => {
                document.body.classList.remove(Ss),
                    this._resetAdjustments(),
                    this._scrollBar.reset(),
                    d.trigger(this._element, Wr);
            });
    }
    _isAnimated() {
        return this._element.classList.contains(Lc);
    }
    _triggerBackdropTransition() {
        if (d.trigger(this._element, Tc).defaultPrevented) return;
        const n =
                this._element.scrollHeight >
                document.documentElement.clientHeight,
            s = this._element.style.overflowY;
        s === "hidden" ||
            this._element.classList.contains(sn) ||
            (n || (this._element.style.overflowY = "hidden"),
            this._element.classList.add(sn),
            this._queueCallback(() => {
                this._element.classList.remove(sn),
                    this._queueCallback(() => {
                        this._element.style.overflowY = s;
                    }, this._dialog);
            }, this._dialog),
            this._element.focus());
    }
    _adjustDialog() {
        const t =
                this._element.scrollHeight >
                document.documentElement.clientHeight,
            n = this._scrollBar.getWidth(),
            s = n > 0;
        if (s && !t) {
            const r = W() ? "paddingLeft" : "paddingRight";
            this._element.style[r] = `${n}px`;
        }
        if (!s && t) {
            const r = W() ? "paddingRight" : "paddingLeft";
            this._element.style[r] = `${n}px`;
        }
    }
    _resetAdjustments() {
        (this._element.style.paddingLeft = ""),
            (this._element.style.paddingRight = "");
    }
    static jQueryInterface(t, n) {
        return this.each(function () {
            const s = Vt.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof s[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                s[t](n);
            }
        });
    }
}
d.on(document, Dc, Pc, function (e) {
    const t = E.getElementFromSelector(this);
    ["A", "AREA"].includes(this.tagName) && e.preventDefault(),
        d.one(t, Ur, (r) => {
            r.defaultPrevented ||
                d.one(t, Wr, () => {
                    jt(this) && this.focus();
                });
        });
    const n = E.findOne(Rc);
    n && Vt.getInstance(n).hide(), Vt.getOrCreateInstance(t).toggle(this);
});
xe(Vt);
K(Vt);
const kc = "offcanvas",
    Vc = "bs.offcanvas",
    rt = `.${Vc}`,
    Kr = ".data-api",
    Hc = `load${rt}${Kr}`,
    Fc = "Escape",
    Ns = "show",
    Ds = "showing",
    Ls = "hiding",
    Bc = "offcanvas-backdrop",
    Yr = ".offcanvas.show",
    jc = `show${rt}`,
    Wc = `shown${rt}`,
    Uc = `hide${rt}`,
    Rs = `hidePrevented${rt}`,
    zr = `hidden${rt}`,
    Kc = `resize${rt}`,
    Yc = `click${rt}${Kr}`,
    zc = `keydown.dismiss${rt}`,
    qc = '[data-bs-toggle="offcanvas"]',
    Gc = { backdrop: !0, keyboard: !0, scroll: !1 },
    Xc = {
        backdrop: "(boolean|string)",
        keyboard: "boolean",
        scroll: "boolean",
    };
class ut extends q {
    constructor(t, n) {
        super(t, n),
            (this._isShown = !1),
            (this._backdrop = this._initializeBackDrop()),
            (this._focustrap = this._initializeFocusTrap()),
            this._addEventListeners();
    }
    static get Default() {
        return Gc;
    }
    static get DefaultType() {
        return Xc;
    }
    static get NAME() {
        return kc;
    }
    toggle(t) {
        return this._isShown ? this.hide() : this.show(t);
    }
    show(t) {
        if (
            this._isShown ||
            d.trigger(this._element, jc, { relatedTarget: t }).defaultPrevented
        )
            return;
        (this._isShown = !0),
            this._backdrop.show(),
            this._config.scroll || new An().hide(),
            this._element.setAttribute("aria-modal", !0),
            this._element.setAttribute("role", "dialog"),
            this._element.classList.add(Ds);
        const s = () => {
            (!this._config.scroll || this._config.backdrop) &&
                this._focustrap.activate(),
                this._element.classList.add(Ns),
                this._element.classList.remove(Ds),
                d.trigger(this._element, Wc, { relatedTarget: t });
        };
        this._queueCallback(s, this._element, !0);
    }
    hide() {
        if (!this._isShown || d.trigger(this._element, Uc).defaultPrevented)
            return;
        this._focustrap.deactivate(),
            this._element.blur(),
            (this._isShown = !1),
            this._element.classList.add(Ls),
            this._backdrop.hide();
        const n = () => {
            this._element.classList.remove(Ns, Ls),
                this._element.removeAttribute("aria-modal"),
                this._element.removeAttribute("role"),
                this._config.scroll || new An().reset(),
                d.trigger(this._element, zr);
        };
        this._queueCallback(n, this._element, !0);
    }
    dispose() {
        this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose();
    }
    _initializeBackDrop() {
        const t = () => {
                if (this._config.backdrop === "static") {
                    d.trigger(this._element, Rs);
                    return;
                }
                this.hide();
            },
            n = !!this._config.backdrop;
        return new Br({
            className: Bc,
            isVisible: n,
            isAnimated: !0,
            rootElement: this._element.parentNode,
            clickCallback: n ? t : null,
        });
    }
    _initializeFocusTrap() {
        return new jr({ trapElement: this._element });
    }
    _addEventListeners() {
        d.on(this._element, zc, (t) => {
            if (t.key === Fc) {
                if (this._config.keyboard) {
                    this.hide();
                    return;
                }
                d.trigger(this._element, Rs);
            }
        });
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = ut.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                n[t](this);
            }
        });
    }
}
d.on(document, Yc, qc, function (e) {
    const t = E.getElementFromSelector(this);
    if ((["A", "AREA"].includes(this.tagName) && e.preventDefault(), lt(this)))
        return;
    d.one(t, zr, () => {
        jt(this) && this.focus();
    });
    const n = E.findOne(Yr);
    n && n !== t && ut.getInstance(n).hide(),
        ut.getOrCreateInstance(t).toggle(this);
});
d.on(window, Hc, () => {
    for (const e of E.find(Yr)) ut.getOrCreateInstance(e).show();
});
d.on(window, Kc, () => {
    for (const e of E.find("[aria-modal][class*=show][class*=offcanvas-]"))
        getComputedStyle(e).position !== "fixed" &&
            ut.getOrCreateInstance(e).hide();
});
xe(ut);
K(ut);
const Jc = /^aria-[\w-]*$/i,
    qr = {
        "*": ["class", "dir", "id", "lang", "role", Jc],
        a: ["target", "href", "title", "rel"],
        area: [],
        b: [],
        br: [],
        col: [],
        code: [],
        div: [],
        em: [],
        hr: [],
        h1: [],
        h2: [],
        h3: [],
        h4: [],
        h5: [],
        h6: [],
        i: [],
        img: ["src", "srcset", "alt", "title", "width", "height"],
        li: [],
        ol: [],
        p: [],
        pre: [],
        s: [],
        small: [],
        span: [],
        sub: [],
        sup: [],
        strong: [],
        u: [],
        ul: [],
    },
    Qc = new Set([
        "background",
        "cite",
        "href",
        "itemtype",
        "longdesc",
        "poster",
        "src",
        "xlink:href",
    ]),
    Zc = /^(?!javascript:)(?:[a-z0-9+.-]+:|[^&:/?#]*(?:[/?#]|$))/i,
    tl = (e, t) => {
        const n = e.nodeName.toLowerCase();
        return t.includes(n)
            ? Qc.has(n)
                ? !!Zc.test(e.nodeValue)
                : !0
            : t.filter((s) => s instanceof RegExp).some((s) => s.test(n));
    };
function el(e, t, n) {
    if (!e.length) return e;
    if (n && typeof n == "function") return n(e);
    const r = new window.DOMParser().parseFromString(e, "text/html"),
        i = [].concat(...r.body.querySelectorAll("*"));
    for (const o of i) {
        const a = o.nodeName.toLowerCase();
        if (!Object.keys(t).includes(a)) {
            o.remove();
            continue;
        }
        const u = [].concat(...o.attributes),
            c = [].concat(t["*"] || [], t[a] || []);
        for (const l of u) tl(l, c) || o.removeAttribute(l.nodeName);
    }
    return r.body.innerHTML;
}
const nl = "TemplateFactory",
    sl = {
        allowList: qr,
        content: {},
        extraClass: "",
        html: !1,
        sanitize: !0,
        sanitizeFn: null,
        template: "<div></div>",
    },
    rl = {
        allowList: "object",
        content: "object",
        extraClass: "(string|function)",
        html: "boolean",
        sanitize: "boolean",
        sanitizeFn: "(null|function)",
        template: "string",
    },
    il = {
        entry: "(string|element|function|null)",
        selector: "(string|element)",
    };
class ol extends se {
    constructor(t) {
        super(), (this._config = this._getConfig(t));
    }
    static get Default() {
        return sl;
    }
    static get DefaultType() {
        return rl;
    }
    static get NAME() {
        return nl;
    }
    getContent() {
        return Object.values(this._config.content)
            .map((t) => this._resolvePossibleFunction(t))
            .filter(Boolean);
    }
    hasContent() {
        return this.getContent().length > 0;
    }
    changeContent(t) {
        return (
            this._checkContent(t),
            (this._config.content = { ...this._config.content, ...t }),
            this
        );
    }
    toHtml() {
        const t = document.createElement("div");
        t.innerHTML = this._maybeSanitize(this._config.template);
        for (const [r, i] of Object.entries(this._config.content))
            this._setContent(t, i, r);
        const n = t.children[0],
            s = this._resolvePossibleFunction(this._config.extraClass);
        return s && n.classList.add(...s.split(" ")), n;
    }
    _typeCheckConfig(t) {
        super._typeCheckConfig(t), this._checkContent(t.content);
    }
    _checkContent(t) {
        for (const [n, s] of Object.entries(t))
            super._typeCheckConfig({ selector: n, entry: s }, il);
    }
    _setContent(t, n, s) {
        const r = E.findOne(s, t);
        if (r) {
            if (((n = this._resolvePossibleFunction(n)), !n)) {
                r.remove();
                return;
            }
            if (tt(n)) {
                this._putElementInTemplate(ct(n), r);
                return;
            }
            if (this._config.html) {
                r.innerHTML = this._maybeSanitize(n);
                return;
            }
            r.textContent = n;
        }
    }
    _maybeSanitize(t) {
        return this._config.sanitize
            ? el(t, this._config.allowList, this._config.sanitizeFn)
            : t;
    }
    _resolvePossibleFunction(t) {
        return M(t, [this]);
    }
    _putElementInTemplate(t, n) {
        if (this._config.html) {
            (n.innerHTML = ""), n.append(t);
            return;
        }
        n.textContent = t.textContent;
    }
}
const al = "tooltip",
    cl = new Set(["sanitize", "allowList", "sanitizeFn"]),
    rn = "fade",
    ll = "modal",
    ge = "show",
    ul = ".tooltip-inner",
    $s = `.${ll}`,
    Is = "hide.bs.modal",
    Gt = "hover",
    on = "focus",
    fl = "click",
    dl = "manual",
    hl = "hide",
    pl = "hidden",
    _l = "show",
    ml = "shown",
    gl = "inserted",
    El = "click",
    bl = "focusin",
    vl = "focusout",
    yl = "mouseenter",
    Al = "mouseleave",
    Tl = {
        AUTO: "auto",
        TOP: "top",
        RIGHT: W() ? "left" : "right",
        BOTTOM: "bottom",
        LEFT: W() ? "right" : "left",
    },
    wl = {
        allowList: qr,
        animation: !0,
        boundary: "clippingParents",
        container: !1,
        customClass: "",
        delay: 0,
        fallbackPlacements: ["top", "right", "bottom", "left"],
        html: !1,
        offset: [0, 6],
        placement: "top",
        popperConfig: null,
        sanitize: !0,
        sanitizeFn: null,
        selector: !1,
        template:
            '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        title: "",
        trigger: "hover focus",
    },
    Ol = {
        allowList: "object",
        animation: "boolean",
        boundary: "(string|element)",
        container: "(string|element|boolean)",
        customClass: "(string|function)",
        delay: "(number|object)",
        fallbackPlacements: "array",
        html: "boolean",
        offset: "(array|string|function)",
        placement: "(string|function)",
        popperConfig: "(null|object|function)",
        sanitize: "boolean",
        sanitizeFn: "(null|function)",
        selector: "(string|boolean)",
        template: "string",
        title: "(string|element|function)",
        trigger: "string",
    };
class Ut extends q {
    constructor(t, n) {
        if (typeof yr > "u")
            throw new TypeError(
                "Bootstrap's tooltips require Popper (https://popper.js.org)"
            );
        super(t, n),
            (this._isEnabled = !0),
            (this._timeout = 0),
            (this._isHovered = null),
            (this._activeTrigger = {}),
            (this._popper = null),
            (this._templateFactory = null),
            (this._newContent = null),
            (this.tip = null),
            this._setListeners(),
            this._config.selector || this._fixTitle();
    }
    static get Default() {
        return wl;
    }
    static get DefaultType() {
        return Ol;
    }
    static get NAME() {
        return al;
    }
    enable() {
        this._isEnabled = !0;
    }
    disable() {
        this._isEnabled = !1;
    }
    toggleEnabled() {
        this._isEnabled = !this._isEnabled;
    }
    toggle() {
        if (this._isEnabled) {
            if (
                ((this._activeTrigger.click = !this._activeTrigger.click),
                this._isShown())
            ) {
                this._leave();
                return;
            }
            this._enter();
        }
    }
    dispose() {
        clearTimeout(this._timeout),
            d.off(this._element.closest($s), Is, this._hideModalHandler),
            this._element.getAttribute("data-bs-original-title") &&
                this._element.setAttribute(
                    "title",
                    this._element.getAttribute("data-bs-original-title")
                ),
            this._disposePopper(),
            super.dispose();
    }
    show() {
        if (this._element.style.display === "none")
            throw new Error("Please use show on visible elements");
        if (!(this._isWithContent() && this._isEnabled)) return;
        const t = d.trigger(this._element, this.constructor.eventName(_l)),
            s = (
                wr(this._element) || this._element.ownerDocument.documentElement
            ).contains(this._element);
        if (t.defaultPrevented || !s) return;
        this._disposePopper();
        const r = this._getTipElement();
        this._element.setAttribute("aria-describedby", r.getAttribute("id"));
        const { container: i } = this._config;
        if (
            (this._element.ownerDocument.documentElement.contains(this.tip) ||
                (i.append(r),
                d.trigger(this._element, this.constructor.eventName(gl))),
            (this._popper = this._createPopper(r)),
            r.classList.add(ge),
            "ontouchstart" in document.documentElement)
        )
            for (const a of [].concat(...document.body.children))
                d.on(a, "mouseover", Ne);
        const o = () => {
            d.trigger(this._element, this.constructor.eventName(ml)),
                this._isHovered === !1 && this._leave(),
                (this._isHovered = !1);
        };
        this._queueCallback(o, this.tip, this._isAnimated());
    }
    hide() {
        if (
            !this._isShown() ||
            d.trigger(this._element, this.constructor.eventName(hl))
                .defaultPrevented
        )
            return;
        if (
            (this._getTipElement().classList.remove(ge),
            "ontouchstart" in document.documentElement)
        )
            for (const r of [].concat(...document.body.children))
                d.off(r, "mouseover", Ne);
        (this._activeTrigger[fl] = !1),
            (this._activeTrigger[on] = !1),
            (this._activeTrigger[Gt] = !1),
            (this._isHovered = null);
        const s = () => {
            this._isWithActiveTrigger() ||
                (this._isHovered || this._disposePopper(),
                this._element.removeAttribute("aria-describedby"),
                d.trigger(this._element, this.constructor.eventName(pl)));
        };
        this._queueCallback(s, this.tip, this._isAnimated());
    }
    update() {
        this._popper && this._popper.update();
    }
    _isWithContent() {
        return !!this._getTitle();
    }
    _getTipElement() {
        return (
            this.tip ||
                (this.tip = this._createTipElement(
                    this._newContent || this._getContentForTemplate()
                )),
            this.tip
        );
    }
    _createTipElement(t) {
        const n = this._getTemplateFactory(t).toHtml();
        if (!n) return null;
        n.classList.remove(rn, ge),
            n.classList.add(`bs-${this.constructor.NAME}-auto`);
        const s = uo(this.constructor.NAME).toString();
        return (
            n.setAttribute("id", s),
            this._isAnimated() && n.classList.add(rn),
            n
        );
    }
    setContent(t) {
        (this._newContent = t),
            this._isShown() && (this._disposePopper(), this.show());
    }
    _getTemplateFactory(t) {
        return (
            this._templateFactory
                ? this._templateFactory.changeContent(t)
                : (this._templateFactory = new ol({
                      ...this._config,
                      content: t,
                      extraClass: this._resolvePossibleFunction(
                          this._config.customClass
                      ),
                  })),
            this._templateFactory
        );
    }
    _getContentForTemplate() {
        return { [ul]: this._getTitle() };
    }
    _getTitle() {
        return (
            this._resolvePossibleFunction(this._config.title) ||
            this._element.getAttribute("data-bs-original-title")
        );
    }
    _initializeOnDelegatedTarget(t) {
        return this.constructor.getOrCreateInstance(
            t.delegateTarget,
            this._getDelegateConfig()
        );
    }
    _isAnimated() {
        return (
            this._config.animation ||
            (this.tip && this.tip.classList.contains(rn))
        );
    }
    _isShown() {
        return this.tip && this.tip.classList.contains(ge);
    }
    _createPopper(t) {
        const n = M(this._config.placement, [this, t, this._element]),
            s = Tl[n.toUpperCase()];
        return Hn(this._element, t, this._getPopperConfig(s));
    }
    _getOffset() {
        const { offset: t } = this._config;
        return typeof t == "string"
            ? t.split(",").map((n) => Number.parseInt(n, 10))
            : typeof t == "function"
            ? (n) => t(n, this._element)
            : t;
    }
    _resolvePossibleFunction(t) {
        return M(t, [this._element]);
    }
    _getPopperConfig(t) {
        const n = {
            placement: t,
            modifiers: [
                {
                    name: "flip",
                    options: {
                        fallbackPlacements: this._config.fallbackPlacements,
                    },
                },
                { name: "offset", options: { offset: this._getOffset() } },
                {
                    name: "preventOverflow",
                    options: { boundary: this._config.boundary },
                },
                {
                    name: "arrow",
                    options: { element: `.${this.constructor.NAME}-arrow` },
                },
                {
                    name: "preSetPlacement",
                    enabled: !0,
                    phase: "beforeMain",
                    fn: (s) => {
                        this._getTipElement().setAttribute(
                            "data-popper-placement",
                            s.state.placement
                        );
                    },
                },
            ],
        };
        return { ...n, ...M(this._config.popperConfig, [n]) };
    }
    _setListeners() {
        const t = this._config.trigger.split(" ");
        for (const n of t)
            if (n === "click")
                d.on(
                    this._element,
                    this.constructor.eventName(El),
                    this._config.selector,
                    (s) => {
                        this._initializeOnDelegatedTarget(s).toggle();
                    }
                );
            else if (n !== dl) {
                const s =
                        n === Gt
                            ? this.constructor.eventName(yl)
                            : this.constructor.eventName(bl),
                    r =
                        n === Gt
                            ? this.constructor.eventName(Al)
                            : this.constructor.eventName(vl);
                d.on(this._element, s, this._config.selector, (i) => {
                    const o = this._initializeOnDelegatedTarget(i);
                    (o._activeTrigger[i.type === "focusin" ? on : Gt] = !0),
                        o._enter();
                }),
                    d.on(this._element, r, this._config.selector, (i) => {
                        const o = this._initializeOnDelegatedTarget(i);
                        (o._activeTrigger[i.type === "focusout" ? on : Gt] =
                            o._element.contains(i.relatedTarget)),
                            o._leave();
                    });
            }
        (this._hideModalHandler = () => {
            this._element && this.hide();
        }),
            d.on(this._element.closest($s), Is, this._hideModalHandler);
    }
    _fixTitle() {
        const t = this._element.getAttribute("title");
        t &&
            (!this._element.getAttribute("aria-label") &&
                !this._element.textContent.trim() &&
                this._element.setAttribute("aria-label", t),
            this._element.setAttribute("data-bs-original-title", t),
            this._element.removeAttribute("title"));
    }
    _enter() {
        if (this._isShown() || this._isHovered) {
            this._isHovered = !0;
            return;
        }
        (this._isHovered = !0),
            this._setTimeout(() => {
                this._isHovered && this.show();
            }, this._config.delay.show);
    }
    _leave() {
        this._isWithActiveTrigger() ||
            ((this._isHovered = !1),
            this._setTimeout(() => {
                this._isHovered || this.hide();
            }, this._config.delay.hide));
    }
    _setTimeout(t, n) {
        clearTimeout(this._timeout), (this._timeout = setTimeout(t, n));
    }
    _isWithActiveTrigger() {
        return Object.values(this._activeTrigger).includes(!0);
    }
    _getConfig(t) {
        const n = et.getDataAttributes(this._element);
        for (const s of Object.keys(n)) cl.has(s) && delete n[s];
        return (
            (t = { ...n, ...(typeof t == "object" && t ? t : {}) }),
            (t = this._mergeConfigObj(t)),
            (t = this._configAfterMerge(t)),
            this._typeCheckConfig(t),
            t
        );
    }
    _configAfterMerge(t) {
        return (
            (t.container =
                t.container === !1 ? document.body : ct(t.container)),
            typeof t.delay == "number" &&
                (t.delay = { show: t.delay, hide: t.delay }),
            typeof t.title == "number" && (t.title = t.title.toString()),
            typeof t.content == "number" && (t.content = t.content.toString()),
            t
        );
    }
    _getDelegateConfig() {
        const t = {};
        for (const [n, s] of Object.entries(this._config))
            this.constructor.Default[n] !== s && (t[n] = s);
        return (t.selector = !1), (t.trigger = "manual"), t;
    }
    _disposePopper() {
        this._popper && (this._popper.destroy(), (this._popper = null)),
            this.tip && (this.tip.remove(), (this.tip = null));
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = Ut.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof n[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                n[t]();
            }
        });
    }
}
K(Ut);
const Sl = "popover",
    Cl = ".popover-header",
    Nl = ".popover-body",
    Dl = {
        ...Ut.Default,
        content: "",
        offset: [0, 8],
        placement: "right",
        template:
            '<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
        trigger: "click",
    },
    Ll = { ...Ut.DefaultType, content: "(null|string|element|function)" };
class Wn extends Ut {
    static get Default() {
        return Dl;
    }
    static get DefaultType() {
        return Ll;
    }
    static get NAME() {
        return Sl;
    }
    _isWithContent() {
        return this._getTitle() || this._getContent();
    }
    _getContentForTemplate() {
        return { [Cl]: this._getTitle(), [Nl]: this._getContent() };
    }
    _getContent() {
        return this._resolvePossibleFunction(this._config.content);
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = Wn.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof n[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                n[t]();
            }
        });
    }
}
K(Wn);
const Rl = "scrollspy",
    $l = "bs.scrollspy",
    Un = `.${$l}`,
    Il = ".data-api",
    Pl = `activate${Un}`,
    Ps = `click${Un}`,
    xl = `load${Un}${Il}`,
    Ml = "dropdown-item",
    Nt = "active",
    kl = '[data-bs-spy="scroll"]',
    an = "[href]",
    Vl = ".nav, .list-group",
    xs = ".nav-link",
    Hl = ".nav-item",
    Fl = ".list-group-item",
    Bl = `${xs}, ${Hl} > ${xs}, ${Fl}`,
    jl = ".dropdown",
    Wl = ".dropdown-toggle",
    Ul = {
        offset: null,
        rootMargin: "0px 0px -25%",
        smoothScroll: !1,
        target: null,
        threshold: [0.1, 0.5, 1],
    },
    Kl = {
        offset: "(number|null)",
        rootMargin: "string",
        smoothScroll: "boolean",
        target: "element",
        threshold: "array",
    };
class Ve extends q {
    constructor(t, n) {
        super(t, n),
            (this._targetLinks = new Map()),
            (this._observableSections = new Map()),
            (this._rootElement =
                getComputedStyle(this._element).overflowY === "visible"
                    ? null
                    : this._element),
            (this._activeTarget = null),
            (this._observer = null),
            (this._previousScrollData = {
                visibleEntryTop: 0,
                parentScrollTop: 0,
            }),
            this.refresh();
    }
    static get Default() {
        return Ul;
    }
    static get DefaultType() {
        return Kl;
    }
    static get NAME() {
        return Rl;
    }
    refresh() {
        this._initializeTargetsAndObservables(),
            this._maybeEnableSmoothScroll(),
            this._observer
                ? this._observer.disconnect()
                : (this._observer = this._getNewObserver());
        for (const t of this._observableSections.values())
            this._observer.observe(t);
    }
    dispose() {
        this._observer.disconnect(), super.dispose();
    }
    _configAfterMerge(t) {
        return (
            (t.target = ct(t.target) || document.body),
            (t.rootMargin = t.offset ? `${t.offset}px 0px -30%` : t.rootMargin),
            typeof t.threshold == "string" &&
                (t.threshold = t.threshold
                    .split(",")
                    .map((n) => Number.parseFloat(n))),
            t
        );
    }
    _maybeEnableSmoothScroll() {
        this._config.smoothScroll &&
            (d.off(this._config.target, Ps),
            d.on(this._config.target, Ps, an, (t) => {
                const n = this._observableSections.get(t.target.hash);
                if (n) {
                    t.preventDefault();
                    const s = this._rootElement || window,
                        r = n.offsetTop - this._element.offsetTop;
                    if (s.scrollTo) {
                        s.scrollTo({ top: r, behavior: "smooth" });
                        return;
                    }
                    s.scrollTop = r;
                }
            }));
    }
    _getNewObserver() {
        const t = {
            root: this._rootElement,
            threshold: this._config.threshold,
            rootMargin: this._config.rootMargin,
        };
        return new IntersectionObserver((n) => this._observerCallback(n), t);
    }
    _observerCallback(t) {
        const n = (o) => this._targetLinks.get(`#${o.target.id}`),
            s = (o) => {
                (this._previousScrollData.visibleEntryTop = o.target.offsetTop),
                    this._process(n(o));
            },
            r = (this._rootElement || document.documentElement).scrollTop,
            i = r >= this._previousScrollData.parentScrollTop;
        this._previousScrollData.parentScrollTop = r;
        for (const o of t) {
            if (!o.isIntersecting) {
                (this._activeTarget = null), this._clearActiveClass(n(o));
                continue;
            }
            const a =
                o.target.offsetTop >= this._previousScrollData.visibleEntryTop;
            if (i && a) {
                if ((s(o), !r)) return;
                continue;
            }
            !i && !a && s(o);
        }
    }
    _initializeTargetsAndObservables() {
        (this._targetLinks = new Map()), (this._observableSections = new Map());
        const t = E.find(an, this._config.target);
        for (const n of t) {
            if (!n.hash || lt(n)) continue;
            const s = E.findOne(decodeURI(n.hash), this._element);
            jt(s) &&
                (this._targetLinks.set(decodeURI(n.hash), n),
                this._observableSections.set(n.hash, s));
        }
    }
    _process(t) {
        this._activeTarget !== t &&
            (this._clearActiveClass(this._config.target),
            (this._activeTarget = t),
            t.classList.add(Nt),
            this._activateParents(t),
            d.trigger(this._element, Pl, { relatedTarget: t }));
    }
    _activateParents(t) {
        if (t.classList.contains(Ml)) {
            E.findOne(Wl, t.closest(jl)).classList.add(Nt);
            return;
        }
        for (const n of E.parents(t, Vl))
            for (const s of E.prev(n, Bl)) s.classList.add(Nt);
    }
    _clearActiveClass(t) {
        t.classList.remove(Nt);
        const n = E.find(`${an}.${Nt}`, t);
        for (const s of n) s.classList.remove(Nt);
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = Ve.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                n[t]();
            }
        });
    }
}
d.on(window, xl, () => {
    for (const e of E.find(kl)) Ve.getOrCreateInstance(e);
});
K(Ve);
const Yl = "tab",
    zl = "bs.tab",
    Ot = `.${zl}`,
    ql = `hide${Ot}`,
    Gl = `hidden${Ot}`,
    Xl = `show${Ot}`,
    Jl = `shown${Ot}`,
    Ql = `click${Ot}`,
    Zl = `keydown${Ot}`,
    tu = `load${Ot}`,
    eu = "ArrowLeft",
    Ms = "ArrowRight",
    nu = "ArrowUp",
    ks = "ArrowDown",
    cn = "Home",
    Vs = "End",
    vt = "active",
    Hs = "fade",
    ln = "show",
    su = "dropdown",
    ru = ".dropdown-toggle",
    iu = ".dropdown-menu",
    un = ":not(.dropdown-toggle)",
    ou = '.list-group, .nav, [role="tablist"]',
    au = ".nav-item, .list-group-item",
    cu = `.nav-link${un}, .list-group-item${un}, [role="tab"]${un}`,
    Gr =
        '[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]',
    fn = `${cu}, ${Gr}`,
    lu = `.${vt}[data-bs-toggle="tab"], .${vt}[data-bs-toggle="pill"], .${vt}[data-bs-toggle="list"]`;
class Ht extends q {
    constructor(t) {
        super(t),
            (this._parent = this._element.closest(ou)),
            this._parent &&
                (this._setInitialAttributes(this._parent, this._getChildren()),
                d.on(this._element, Zl, (n) => this._keydown(n)));
    }
    static get NAME() {
        return Yl;
    }
    show() {
        const t = this._element;
        if (this._elemIsActive(t)) return;
        const n = this._getActiveElem(),
            s = n ? d.trigger(n, ql, { relatedTarget: t }) : null;
        d.trigger(t, Xl, { relatedTarget: n }).defaultPrevented ||
            (s && s.defaultPrevented) ||
            (this._deactivate(n, t), this._activate(t, n));
    }
    _activate(t, n) {
        if (!t) return;
        t.classList.add(vt), this._activate(E.getElementFromSelector(t));
        const s = () => {
            if (t.getAttribute("role") !== "tab") {
                t.classList.add(ln);
                return;
            }
            t.removeAttribute("tabindex"),
                t.setAttribute("aria-selected", !0),
                this._toggleDropDown(t, !0),
                d.trigger(t, Jl, { relatedTarget: n });
        };
        this._queueCallback(s, t, t.classList.contains(Hs));
    }
    _deactivate(t, n) {
        if (!t) return;
        t.classList.remove(vt),
            t.blur(),
            this._deactivate(E.getElementFromSelector(t));
        const s = () => {
            if (t.getAttribute("role") !== "tab") {
                t.classList.remove(ln);
                return;
            }
            t.setAttribute("aria-selected", !1),
                t.setAttribute("tabindex", "-1"),
                this._toggleDropDown(t, !1),
                d.trigger(t, Gl, { relatedTarget: n });
        };
        this._queueCallback(s, t, t.classList.contains(Hs));
    }
    _keydown(t) {
        if (![eu, Ms, nu, ks, cn, Vs].includes(t.key)) return;
        t.stopPropagation(), t.preventDefault();
        const n = this._getChildren().filter((r) => !lt(r));
        let s;
        if ([cn, Vs].includes(t.key)) s = n[t.key === cn ? 0 : n.length - 1];
        else {
            const r = [Ms, ks].includes(t.key);
            s = Fn(n, t.target, r, !0);
        }
        s && (s.focus({ preventScroll: !0 }), Ht.getOrCreateInstance(s).show());
    }
    _getChildren() {
        return E.find(fn, this._parent);
    }
    _getActiveElem() {
        return this._getChildren().find((t) => this._elemIsActive(t)) || null;
    }
    _setInitialAttributes(t, n) {
        this._setAttributeIfNotExists(t, "role", "tablist");
        for (const s of n) this._setInitialAttributesOnChild(s);
    }
    _setInitialAttributesOnChild(t) {
        t = this._getInnerElement(t);
        const n = this._elemIsActive(t),
            s = this._getOuterElement(t);
        t.setAttribute("aria-selected", n),
            s !== t && this._setAttributeIfNotExists(s, "role", "presentation"),
            n || t.setAttribute("tabindex", "-1"),
            this._setAttributeIfNotExists(t, "role", "tab"),
            this._setInitialAttributesOnTargetPanel(t);
    }
    _setInitialAttributesOnTargetPanel(t) {
        const n = E.getElementFromSelector(t);
        n &&
            (this._setAttributeIfNotExists(n, "role", "tabpanel"),
            t.id &&
                this._setAttributeIfNotExists(n, "aria-labelledby", `${t.id}`));
    }
    _toggleDropDown(t, n) {
        const s = this._getOuterElement(t);
        if (!s.classList.contains(su)) return;
        const r = (i, o) => {
            const a = E.findOne(i, s);
            a && a.classList.toggle(o, n);
        };
        r(ru, vt), r(iu, ln), s.setAttribute("aria-expanded", n);
    }
    _setAttributeIfNotExists(t, n, s) {
        t.hasAttribute(n) || t.setAttribute(n, s);
    }
    _elemIsActive(t) {
        return t.classList.contains(vt);
    }
    _getInnerElement(t) {
        return t.matches(fn) ? t : E.findOne(fn, t);
    }
    _getOuterElement(t) {
        return t.closest(au) || t;
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = Ht.getOrCreateInstance(this);
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                n[t]();
            }
        });
    }
}
d.on(document, Ql, Gr, function (e) {
    ["A", "AREA"].includes(this.tagName) && e.preventDefault(),
        !lt(this) && Ht.getOrCreateInstance(this).show();
});
d.on(window, tu, () => {
    for (const e of E.find(lu)) Ht.getOrCreateInstance(e);
});
K(Ht);
const uu = "toast",
    fu = "bs.toast",
    ht = `.${fu}`,
    du = `mouseover${ht}`,
    hu = `mouseout${ht}`,
    pu = `focusin${ht}`,
    _u = `focusout${ht}`,
    mu = `hide${ht}`,
    gu = `hidden${ht}`,
    Eu = `show${ht}`,
    bu = `shown${ht}`,
    vu = "fade",
    Fs = "hide",
    Ee = "show",
    be = "showing",
    yu = { animation: "boolean", autohide: "boolean", delay: "number" },
    Au = { animation: !0, autohide: !0, delay: 5e3 };
class He extends q {
    constructor(t, n) {
        super(t, n),
            (this._timeout = null),
            (this._hasMouseInteraction = !1),
            (this._hasKeyboardInteraction = !1),
            this._setListeners();
    }
    static get Default() {
        return Au;
    }
    static get DefaultType() {
        return yu;
    }
    static get NAME() {
        return uu;
    }
    show() {
        if (d.trigger(this._element, Eu).defaultPrevented) return;
        this._clearTimeout(),
            this._config.animation && this._element.classList.add(vu);
        const n = () => {
            this._element.classList.remove(be),
                d.trigger(this._element, bu),
                this._maybeScheduleHide();
        };
        this._element.classList.remove(Fs),
            ne(this._element),
            this._element.classList.add(Ee, be),
            this._queueCallback(n, this._element, this._config.animation);
    }
    hide() {
        if (!this.isShown() || d.trigger(this._element, mu).defaultPrevented)
            return;
        const n = () => {
            this._element.classList.add(Fs),
                this._element.classList.remove(be, Ee),
                d.trigger(this._element, gu);
        };
        this._element.classList.add(be),
            this._queueCallback(n, this._element, this._config.animation);
    }
    dispose() {
        this._clearTimeout(),
            this.isShown() && this._element.classList.remove(Ee),
            super.dispose();
    }
    isShown() {
        return this._element.classList.contains(Ee);
    }
    _maybeScheduleHide() {
        this._config.autohide &&
            (this._hasMouseInteraction ||
                this._hasKeyboardInteraction ||
                (this._timeout = setTimeout(() => {
                    this.hide();
                }, this._config.delay)));
    }
    _onInteraction(t, n) {
        switch (t.type) {
            case "mouseover":
            case "mouseout": {
                this._hasMouseInteraction = n;
                break;
            }
            case "focusin":
            case "focusout": {
                this._hasKeyboardInteraction = n;
                break;
            }
        }
        if (n) {
            this._clearTimeout();
            return;
        }
        const s = t.relatedTarget;
        this._element === s ||
            this._element.contains(s) ||
            this._maybeScheduleHide();
    }
    _setListeners() {
        d.on(this._element, du, (t) => this._onInteraction(t, !0)),
            d.on(this._element, hu, (t) => this._onInteraction(t, !1)),
            d.on(this._element, pu, (t) => this._onInteraction(t, !0)),
            d.on(this._element, _u, (t) => this._onInteraction(t, !1));
    }
    _clearTimeout() {
        clearTimeout(this._timeout), (this._timeout = null);
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const n = He.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof n[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                n[t](this);
            }
        });
    }
}
xe(He);
K(He);
function Xr(e, t) {
    return function () {
        return e.apply(t, arguments);
    };
}
const { toString: Tu } = Object.prototype,
    { getPrototypeOf: Kn } = Object,
    Fe = ((e) => (t) => {
        const n = Tu.call(t);
        return e[n] || (e[n] = n.slice(8, -1).toLowerCase());
    })(Object.create(null)),
    Z = (e) => ((e = e.toLowerCase()), (t) => Fe(t) === e),
    Be = (e) => (t) => typeof t === e,
    { isArray: Kt } = Array,
    te = Be("undefined");
function wu(e) {
    return (
        e !== null &&
        !te(e) &&
        e.constructor !== null &&
        !te(e.constructor) &&
        j(e.constructor.isBuffer) &&
        e.constructor.isBuffer(e)
    );
}
const Jr = Z("ArrayBuffer");
function Ou(e) {
    let t;
    return (
        typeof ArrayBuffer < "u" && ArrayBuffer.isView
            ? (t = ArrayBuffer.isView(e))
            : (t = e && e.buffer && Jr(e.buffer)),
        t
    );
}
const Su = Be("string"),
    j = Be("function"),
    Qr = Be("number"),
    je = (e) => e !== null && typeof e == "object",
    Cu = (e) => e === !0 || e === !1,
    Te = (e) => {
        if (Fe(e) !== "object") return !1;
        const t = Kn(e);
        return (
            (t === null ||
                t === Object.prototype ||
                Object.getPrototypeOf(t) === null) &&
            !(Symbol.toStringTag in e) &&
            !(Symbol.iterator in e)
        );
    },
    Nu = Z("Date"),
    Du = Z("File"),
    Lu = Z("Blob"),
    Ru = Z("FileList"),
    $u = (e) => je(e) && j(e.pipe),
    Iu = (e) => {
        let t;
        return (
            e &&
            ((typeof FormData == "function" && e instanceof FormData) ||
                (j(e.append) &&
                    ((t = Fe(e)) === "formdata" ||
                        (t === "object" &&
                            j(e.toString) &&
                            e.toString() === "[object FormData]"))))
        );
    },
    Pu = Z("URLSearchParams"),
    xu = (e) =>
        e.trim ? e.trim() : e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "");
function oe(e, t, { allOwnKeys: n = !1 } = {}) {
    if (e === null || typeof e > "u") return;
    let s, r;
    if ((typeof e != "object" && (e = [e]), Kt(e)))
        for (s = 0, r = e.length; s < r; s++) t.call(null, e[s], s, e);
    else {
        const i = n ? Object.getOwnPropertyNames(e) : Object.keys(e),
            o = i.length;
        let a;
        for (s = 0; s < o; s++) (a = i[s]), t.call(null, e[a], a, e);
    }
}
function Zr(e, t) {
    t = t.toLowerCase();
    const n = Object.keys(e);
    let s = n.length,
        r;
    for (; s-- > 0; ) if (((r = n[s]), t === r.toLowerCase())) return r;
    return null;
}
const ti = (() =>
        typeof globalThis < "u"
            ? globalThis
            : typeof self < "u"
            ? self
            : typeof window < "u"
            ? window
            : global)(),
    ei = (e) => !te(e) && e !== ti;
function Tn() {
    const { caseless: e } = (ei(this) && this) || {},
        t = {},
        n = (s, r) => {
            const i = (e && Zr(t, r)) || r;
            Te(t[i]) && Te(s)
                ? (t[i] = Tn(t[i], s))
                : Te(s)
                ? (t[i] = Tn({}, s))
                : Kt(s)
                ? (t[i] = s.slice())
                : (t[i] = s);
        };
    for (let s = 0, r = arguments.length; s < r; s++)
        arguments[s] && oe(arguments[s], n);
    return t;
}
const Mu = (e, t, n, { allOwnKeys: s } = {}) => (
        oe(
            t,
            (r, i) => {
                n && j(r) ? (e[i] = Xr(r, n)) : (e[i] = r);
            },
            { allOwnKeys: s }
        ),
        e
    ),
    ku = (e) => (e.charCodeAt(0) === 65279 && (e = e.slice(1)), e),
    Vu = (e, t, n, s) => {
        (e.prototype = Object.create(t.prototype, s)),
            (e.prototype.constructor = e),
            Object.defineProperty(e, "super", { value: t.prototype }),
            n && Object.assign(e.prototype, n);
    },
    Hu = (e, t, n, s) => {
        let r, i, o;
        const a = {};
        if (((t = t || {}), e == null)) return t;
        do {
            for (r = Object.getOwnPropertyNames(e), i = r.length; i-- > 0; )
                (o = r[i]),
                    (!s || s(o, e, t)) && !a[o] && ((t[o] = e[o]), (a[o] = !0));
            e = n !== !1 && Kn(e);
        } while (e && (!n || n(e, t)) && e !== Object.prototype);
        return t;
    },
    Fu = (e, t, n) => {
        (e = String(e)),
            (n === void 0 || n > e.length) && (n = e.length),
            (n -= t.length);
        const s = e.indexOf(t, n);
        return s !== -1 && s === n;
    },
    Bu = (e) => {
        if (!e) return null;
        if (Kt(e)) return e;
        let t = e.length;
        if (!Qr(t)) return null;
        const n = new Array(t);
        for (; t-- > 0; ) n[t] = e[t];
        return n;
    },
    ju = (
        (e) => (t) =>
            e && t instanceof e
    )(typeof Uint8Array < "u" && Kn(Uint8Array)),
    Wu = (e, t) => {
        const s = (e && e[Symbol.iterator]).call(e);
        let r;
        for (; (r = s.next()) && !r.done; ) {
            const i = r.value;
            t.call(e, i[0], i[1]);
        }
    },
    Uu = (e, t) => {
        let n;
        const s = [];
        for (; (n = e.exec(t)) !== null; ) s.push(n);
        return s;
    },
    Ku = Z("HTMLFormElement"),
    Yu = (e) =>
        e.toLowerCase().replace(/[-_\s]([a-z\d])(\w*)/g, function (n, s, r) {
            return s.toUpperCase() + r;
        }),
    Bs = (
        ({ hasOwnProperty: e }) =>
        (t, n) =>
            e.call(t, n)
    )(Object.prototype),
    zu = Z("RegExp"),
    ni = (e, t) => {
        const n = Object.getOwnPropertyDescriptors(e),
            s = {};
        oe(n, (r, i) => {
            t(r, i, e) !== !1 && (s[i] = r);
        }),
            Object.defineProperties(e, s);
    },
    qu = (e) => {
        ni(e, (t, n) => {
            if (j(e) && ["arguments", "caller", "callee"].indexOf(n) !== -1)
                return !1;
            const s = e[n];
            if (j(s)) {
                if (((t.enumerable = !1), "writable" in t)) {
                    t.writable = !1;
                    return;
                }
                t.set ||
                    (t.set = () => {
                        throw Error(
                            "Can not rewrite read-only method '" + n + "'"
                        );
                    });
            }
        });
    },
    Gu = (e, t) => {
        const n = {},
            s = (r) => {
                r.forEach((i) => {
                    n[i] = !0;
                });
            };
        return Kt(e) ? s(e) : s(String(e).split(t)), n;
    },
    Xu = () => {},
    Ju = (e, t) => ((e = +e), Number.isFinite(e) ? e : t),
    dn = "abcdefghijklmnopqrstuvwxyz",
    js = "0123456789",
    si = { DIGIT: js, ALPHA: dn, ALPHA_DIGIT: dn + dn.toUpperCase() + js },
    Qu = (e = 16, t = si.ALPHA_DIGIT) => {
        let n = "";
        const { length: s } = t;
        for (; e--; ) n += t[(Math.random() * s) | 0];
        return n;
    };
function Zu(e) {
    return !!(
        e &&
        j(e.append) &&
        e[Symbol.toStringTag] === "FormData" &&
        e[Symbol.iterator]
    );
}
const tf = (e) => {
        const t = new Array(10),
            n = (s, r) => {
                if (je(s)) {
                    if (t.indexOf(s) >= 0) return;
                    if (!("toJSON" in s)) {
                        t[r] = s;
                        const i = Kt(s) ? [] : {};
                        return (
                            oe(s, (o, a) => {
                                const u = n(o, r + 1);
                                !te(u) && (i[a] = u);
                            }),
                            (t[r] = void 0),
                            i
                        );
                    }
                }
                return s;
            };
        return n(e, 0);
    },
    ef = Z("AsyncFunction"),
    nf = (e) => e && (je(e) || j(e)) && j(e.then) && j(e.catch),
    f = {
        isArray: Kt,
        isArrayBuffer: Jr,
        isBuffer: wu,
        isFormData: Iu,
        isArrayBufferView: Ou,
        isString: Su,
        isNumber: Qr,
        isBoolean: Cu,
        isObject: je,
        isPlainObject: Te,
        isUndefined: te,
        isDate: Nu,
        isFile: Du,
        isBlob: Lu,
        isRegExp: zu,
        isFunction: j,
        isStream: $u,
        isURLSearchParams: Pu,
        isTypedArray: ju,
        isFileList: Ru,
        forEach: oe,
        merge: Tn,
        extend: Mu,
        trim: xu,
        stripBOM: ku,
        inherits: Vu,
        toFlatObject: Hu,
        kindOf: Fe,
        kindOfTest: Z,
        endsWith: Fu,
        toArray: Bu,
        forEachEntry: Wu,
        matchAll: Uu,
        isHTMLForm: Ku,
        hasOwnProperty: Bs,
        hasOwnProp: Bs,
        reduceDescriptors: ni,
        freezeMethods: qu,
        toObjectSet: Gu,
        toCamelCase: Yu,
        noop: Xu,
        toFiniteNumber: Ju,
        findKey: Zr,
        global: ti,
        isContextDefined: ei,
        ALPHABET: si,
        generateString: Qu,
        isSpecCompliantForm: Zu,
        toJSONObject: tf,
        isAsyncFn: ef,
        isThenable: nf,
    };
function A(e, t, n, s, r) {
    Error.call(this),
        Error.captureStackTrace
            ? Error.captureStackTrace(this, this.constructor)
            : (this.stack = new Error().stack),
        (this.message = e),
        (this.name = "AxiosError"),
        t && (this.code = t),
        n && (this.config = n),
        s && (this.request = s),
        r && (this.response = r);
}
f.inherits(A, Error, {
    toJSON: function () {
        return {
            message: this.message,
            name: this.name,
            description: this.description,
            number: this.number,
            fileName: this.fileName,
            lineNumber: this.lineNumber,
            columnNumber: this.columnNumber,
            stack: this.stack,
            config: f.toJSONObject(this.config),
            code: this.code,
            status:
                this.response && this.response.status
                    ? this.response.status
                    : null,
        };
    },
});
const ri = A.prototype,
    ii = {};
[
    "ERR_BAD_OPTION_VALUE",
    "ERR_BAD_OPTION",
    "ECONNABORTED",
    "ETIMEDOUT",
    "ERR_NETWORK",
    "ERR_FR_TOO_MANY_REDIRECTS",
    "ERR_DEPRECATED",
    "ERR_BAD_RESPONSE",
    "ERR_BAD_REQUEST",
    "ERR_CANCELED",
    "ERR_NOT_SUPPORT",
    "ERR_INVALID_URL",
].forEach((e) => {
    ii[e] = { value: e };
});
Object.defineProperties(A, ii);
Object.defineProperty(ri, "isAxiosError", { value: !0 });
A.from = (e, t, n, s, r, i) => {
    const o = Object.create(ri);
    return (
        f.toFlatObject(
            e,
            o,
            function (u) {
                return u !== Error.prototype;
            },
            (a) => a !== "isAxiosError"
        ),
        A.call(o, e.message, t, n, s, r),
        (o.cause = e),
        (o.name = e.name),
        i && Object.assign(o, i),
        o
    );
};
const sf = null;
function wn(e) {
    return f.isPlainObject(e) || f.isArray(e);
}
function oi(e) {
    return f.endsWith(e, "[]") ? e.slice(0, -2) : e;
}
function Ws(e, t, n) {
    return e
        ? e
              .concat(t)
              .map(function (r, i) {
                  return (r = oi(r)), !n && i ? "[" + r + "]" : r;
              })
              .join(n ? "." : "")
        : t;
}
function rf(e) {
    return f.isArray(e) && !e.some(wn);
}
const of = f.toFlatObject(f, {}, null, function (t) {
    return /^is[A-Z]/.test(t);
});
function We(e, t, n) {
    if (!f.isObject(e)) throw new TypeError("target must be an object");
    (t = t || new FormData()),
        (n = f.toFlatObject(
            n,
            { metaTokens: !0, dots: !1, indexes: !1 },
            !1,
            function (_, b) {
                return !f.isUndefined(b[_]);
            }
        ));
    const s = n.metaTokens,
        r = n.visitor || l,
        i = n.dots,
        o = n.indexes,
        u = (n.Blob || (typeof Blob < "u" && Blob)) && f.isSpecCompliantForm(t);
    if (!f.isFunction(r)) throw new TypeError("visitor must be a function");
    function c(p) {
        if (p === null) return "";
        if (f.isDate(p)) return p.toISOString();
        if (!u && f.isBlob(p))
            throw new A("Blob is not supported. Use a Buffer instead.");
        return f.isArrayBuffer(p) || f.isTypedArray(p)
            ? u && typeof Blob == "function"
                ? new Blob([p])
                : Buffer.from(p)
            : p;
    }
    function l(p, _, b) {
        let y = p;
        if (p && !b && typeof p == "object") {
            if (f.endsWith(_, "{}"))
                (_ = s ? _ : _.slice(0, -2)), (p = JSON.stringify(p));
            else if (
                (f.isArray(p) && rf(p)) ||
                ((f.isFileList(p) || f.endsWith(_, "[]")) && (y = f.toArray(p)))
            )
                return (
                    (_ = oi(_)),
                    y.forEach(function (S, v) {
                        !(f.isUndefined(S) || S === null) &&
                            t.append(
                                o === !0
                                    ? Ws([_], v, i)
                                    : o === null
                                    ? _
                                    : _ + "[]",
                                c(S)
                            );
                    }),
                    !1
                );
        }
        return wn(p) ? !0 : (t.append(Ws(b, _, i), c(p)), !1);
    }
    const h = [],
        g = Object.assign(of, {
            defaultVisitor: l,
            convertValue: c,
            isVisitable: wn,
        });
    function m(p, _) {
        if (!f.isUndefined(p)) {
            if (h.indexOf(p) !== -1)
                throw Error("Circular reference detected in " + _.join("."));
            h.push(p),
                f.forEach(p, function (y, T) {
                    (!(f.isUndefined(y) || y === null) &&
                        r.call(t, y, f.isString(T) ? T.trim() : T, _, g)) ===
                        !0 && m(y, _ ? _.concat(T) : [T]);
                }),
                h.pop();
        }
    }
    if (!f.isObject(e)) throw new TypeError("data must be an object");
    return m(e), t;
}
function Us(e) {
    const t = {
        "!": "%21",
        "'": "%27",
        "(": "%28",
        ")": "%29",
        "~": "%7E",
        "%20": "+",
        "%00": "\0",
    };
    return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g, function (s) {
        return t[s];
    });
}
function Yn(e, t) {
    (this._pairs = []), e && We(e, this, t);
}
const ai = Yn.prototype;
ai.append = function (t, n) {
    this._pairs.push([t, n]);
};
ai.toString = function (t) {
    const n = t
        ? function (s) {
              return t.call(this, s, Us);
          }
        : Us;
    return this._pairs
        .map(function (r) {
            return n(r[0]) + "=" + n(r[1]);
        }, "")
        .join("&");
};
function af(e) {
    return encodeURIComponent(e)
        .replace(/%3A/gi, ":")
        .replace(/%24/g, "$")
        .replace(/%2C/gi, ",")
        .replace(/%20/g, "+")
        .replace(/%5B/gi, "[")
        .replace(/%5D/gi, "]");
}
function ci(e, t, n) {
    if (!t) return e;
    const s = (n && n.encode) || af,
        r = n && n.serialize;
    let i;
    if (
        (r
            ? (i = r(t, n))
            : (i = f.isURLSearchParams(t)
                  ? t.toString()
                  : new Yn(t, n).toString(s)),
        i)
    ) {
        const o = e.indexOf("#");
        o !== -1 && (e = e.slice(0, o)),
            (e += (e.indexOf("?") === -1 ? "?" : "&") + i);
    }
    return e;
}
class cf {
    constructor() {
        this.handlers = [];
    }
    use(t, n, s) {
        return (
            this.handlers.push({
                fulfilled: t,
                rejected: n,
                synchronous: s ? s.synchronous : !1,
                runWhen: s ? s.runWhen : null,
            }),
            this.handlers.length - 1
        );
    }
    eject(t) {
        this.handlers[t] && (this.handlers[t] = null);
    }
    clear() {
        this.handlers && (this.handlers = []);
    }
    forEach(t) {
        f.forEach(this.handlers, function (s) {
            s !== null && t(s);
        });
    }
}
const Ks = cf,
    li = {
        silentJSONParsing: !0,
        forcedJSONParsing: !0,
        clarifyTimeoutError: !1,
    },
    lf = typeof URLSearchParams < "u" ? URLSearchParams : Yn,
    uf = typeof FormData < "u" ? FormData : null,
    ff = typeof Blob < "u" ? Blob : null,
    df = (() => {
        let e;
        return typeof navigator < "u" &&
            ((e = navigator.product) === "ReactNative" ||
                e === "NativeScript" ||
                e === "NS")
            ? !1
            : typeof window < "u" && typeof document < "u";
    })(),
    hf = (() =>
        typeof WorkerGlobalScope < "u" &&
        self instanceof WorkerGlobalScope &&
        typeof self.importScripts == "function")(),
    G = {
        isBrowser: !0,
        classes: { URLSearchParams: lf, FormData: uf, Blob: ff },
        isStandardBrowserEnv: df,
        isStandardBrowserWebWorkerEnv: hf,
        protocols: ["http", "https", "file", "blob", "url", "data"],
    };
function pf(e, t) {
    return We(
        e,
        new G.classes.URLSearchParams(),
        Object.assign(
            {
                visitor: function (n, s, r, i) {
                    return G.isNode && f.isBuffer(n)
                        ? (this.append(s, n.toString("base64")), !1)
                        : i.defaultVisitor.apply(this, arguments);
                },
            },
            t
        )
    );
}
function _f(e) {
    return f
        .matchAll(/\w+|\[(\w*)]/g, e)
        .map((t) => (t[0] === "[]" ? "" : t[1] || t[0]));
}
function mf(e) {
    const t = {},
        n = Object.keys(e);
    let s;
    const r = n.length;
    let i;
    for (s = 0; s < r; s++) (i = n[s]), (t[i] = e[i]);
    return t;
}
function ui(e) {
    function t(n, s, r, i) {
        let o = n[i++];
        const a = Number.isFinite(+o),
            u = i >= n.length;
        return (
            (o = !o && f.isArray(r) ? r.length : o),
            u
                ? (f.hasOwnProp(r, o) ? (r[o] = [r[o], s]) : (r[o] = s), !a)
                : ((!r[o] || !f.isObject(r[o])) && (r[o] = []),
                  t(n, s, r[o], i) && f.isArray(r[o]) && (r[o] = mf(r[o])),
                  !a)
        );
    }
    if (f.isFormData(e) && f.isFunction(e.entries)) {
        const n = {};
        return (
            f.forEachEntry(e, (s, r) => {
                t(_f(s), r, n, 0);
            }),
            n
        );
    }
    return null;
}
const gf = { "Content-Type": void 0 };
function Ef(e, t, n) {
    if (f.isString(e))
        try {
            return (t || JSON.parse)(e), f.trim(e);
        } catch (s) {
            if (s.name !== "SyntaxError") throw s;
        }
    return (n || JSON.stringify)(e);
}
const Ue = {
    transitional: li,
    adapter: ["xhr", "http"],
    transformRequest: [
        function (t, n) {
            const s = n.getContentType() || "",
                r = s.indexOf("application/json") > -1,
                i = f.isObject(t);
            if (
                (i && f.isHTMLForm(t) && (t = new FormData(t)), f.isFormData(t))
            )
                return r && r ? JSON.stringify(ui(t)) : t;
            if (
                f.isArrayBuffer(t) ||
                f.isBuffer(t) ||
                f.isStream(t) ||
                f.isFile(t) ||
                f.isBlob(t)
            )
                return t;
            if (f.isArrayBufferView(t)) return t.buffer;
            if (f.isURLSearchParams(t))
                return (
                    n.setContentType(
                        "application/x-www-form-urlencoded;charset=utf-8",
                        !1
                    ),
                    t.toString()
                );
            let a;
            if (i) {
                if (s.indexOf("application/x-www-form-urlencoded") > -1)
                    return pf(t, this.formSerializer).toString();
                if (
                    (a = f.isFileList(t)) ||
                    s.indexOf("multipart/form-data") > -1
                ) {
                    const u = this.env && this.env.FormData;
                    return We(
                        a ? { "files[]": t } : t,
                        u && new u(),
                        this.formSerializer
                    );
                }
            }
            return i || r
                ? (n.setContentType("application/json", !1), Ef(t))
                : t;
        },
    ],
    transformResponse: [
        function (t) {
            const n = this.transitional || Ue.transitional,
                s = n && n.forcedJSONParsing,
                r = this.responseType === "json";
            if (t && f.isString(t) && ((s && !this.responseType) || r)) {
                const o = !(n && n.silentJSONParsing) && r;
                try {
                    return JSON.parse(t);
                } catch (a) {
                    if (o)
                        throw a.name === "SyntaxError"
                            ? A.from(
                                  a,
                                  A.ERR_BAD_RESPONSE,
                                  this,
                                  null,
                                  this.response
                              )
                            : a;
                }
            }
            return t;
        },
    ],
    timeout: 0,
    xsrfCookieName: "XSRF-TOKEN",
    xsrfHeaderName: "X-XSRF-TOKEN",
    maxContentLength: -1,
    maxBodyLength: -1,
    env: { FormData: G.classes.FormData, Blob: G.classes.Blob },
    validateStatus: function (t) {
        return t >= 200 && t < 300;
    },
    headers: { common: { Accept: "application/json, text/plain, */*" } },
};
f.forEach(["delete", "get", "head"], function (t) {
    Ue.headers[t] = {};
});
f.forEach(["post", "put", "patch"], function (t) {
    Ue.headers[t] = f.merge(gf);
});
const zn = Ue,
    bf = f.toObjectSet([
        "age",
        "authorization",
        "content-length",
        "content-type",
        "etag",
        "expires",
        "from",
        "host",
        "if-modified-since",
        "if-unmodified-since",
        "last-modified",
        "location",
        "max-forwards",
        "proxy-authorization",
        "referer",
        "retry-after",
        "user-agent",
    ]),
    vf = (e) => {
        const t = {};
        let n, s, r;
        return (
            e &&
                e
                    .split(
                        `
`
                    )
                    .forEach(function (o) {
                        (r = o.indexOf(":")),
                            (n = o.substring(0, r).trim().toLowerCase()),
                            (s = o.substring(r + 1).trim()),
                            !(!n || (t[n] && bf[n])) &&
                                (n === "set-cookie"
                                    ? t[n]
                                        ? t[n].push(s)
                                        : (t[n] = [s])
                                    : (t[n] = t[n] ? t[n] + ", " + s : s));
                    }),
            t
        );
    },
    Ys = Symbol("internals");
function Xt(e) {
    return e && String(e).trim().toLowerCase();
}
function we(e) {
    return e === !1 || e == null ? e : f.isArray(e) ? e.map(we) : String(e);
}
function yf(e) {
    const t = Object.create(null),
        n = /([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;
    let s;
    for (; (s = n.exec(e)); ) t[s[1]] = s[2];
    return t;
}
const Af = (e) => /^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim());
function hn(e, t, n, s, r) {
    if (f.isFunction(s)) return s.call(this, t, n);
    if ((r && (t = n), !!f.isString(t))) {
        if (f.isString(s)) return t.indexOf(s) !== -1;
        if (f.isRegExp(s)) return s.test(t);
    }
}
function Tf(e) {
    return e
        .trim()
        .toLowerCase()
        .replace(/([a-z\d])(\w*)/g, (t, n, s) => n.toUpperCase() + s);
}
function wf(e, t) {
    const n = f.toCamelCase(" " + t);
    ["get", "set", "has"].forEach((s) => {
        Object.defineProperty(e, s + n, {
            value: function (r, i, o) {
                return this[s].call(this, t, r, i, o);
            },
            configurable: !0,
        });
    });
}
class Ke {
    constructor(t) {
        t && this.set(t);
    }
    set(t, n, s) {
        const r = this;
        function i(a, u, c) {
            const l = Xt(u);
            if (!l) throw new Error("header name must be a non-empty string");
            const h = f.findKey(r, l);
            (!h ||
                r[h] === void 0 ||
                c === !0 ||
                (c === void 0 && r[h] !== !1)) &&
                (r[h || u] = we(a));
        }
        const o = (a, u) => f.forEach(a, (c, l) => i(c, l, u));
        return (
            f.isPlainObject(t) || t instanceof this.constructor
                ? o(t, n)
                : f.isString(t) && (t = t.trim()) && !Af(t)
                ? o(vf(t), n)
                : t != null && i(n, t, s),
            this
        );
    }
    get(t, n) {
        if (((t = Xt(t)), t)) {
            const s = f.findKey(this, t);
            if (s) {
                const r = this[s];
                if (!n) return r;
                if (n === !0) return yf(r);
                if (f.isFunction(n)) return n.call(this, r, s);
                if (f.isRegExp(n)) return n.exec(r);
                throw new TypeError("parser must be boolean|regexp|function");
            }
        }
    }
    has(t, n) {
        if (((t = Xt(t)), t)) {
            const s = f.findKey(this, t);
            return !!(
                s &&
                this[s] !== void 0 &&
                (!n || hn(this, this[s], s, n))
            );
        }
        return !1;
    }
    delete(t, n) {
        const s = this;
        let r = !1;
        function i(o) {
            if (((o = Xt(o)), o)) {
                const a = f.findKey(s, o);
                a && (!n || hn(s, s[a], a, n)) && (delete s[a], (r = !0));
            }
        }
        return f.isArray(t) ? t.forEach(i) : i(t), r;
    }
    clear(t) {
        const n = Object.keys(this);
        let s = n.length,
            r = !1;
        for (; s--; ) {
            const i = n[s];
            (!t || hn(this, this[i], i, t, !0)) && (delete this[i], (r = !0));
        }
        return r;
    }
    normalize(t) {
        const n = this,
            s = {};
        return (
            f.forEach(this, (r, i) => {
                const o = f.findKey(s, i);
                if (o) {
                    (n[o] = we(r)), delete n[i];
                    return;
                }
                const a = t ? Tf(i) : String(i).trim();
                a !== i && delete n[i], (n[a] = we(r)), (s[a] = !0);
            }),
            this
        );
    }
    concat(...t) {
        return this.constructor.concat(this, ...t);
    }
    toJSON(t) {
        const n = Object.create(null);
        return (
            f.forEach(this, (s, r) => {
                s != null &&
                    s !== !1 &&
                    (n[r] = t && f.isArray(s) ? s.join(", ") : s);
            }),
            n
        );
    }
    [Symbol.iterator]() {
        return Object.entries(this.toJSON())[Symbol.iterator]();
    }
    toString() {
        return Object.entries(this.toJSON()).map(([t, n]) => t + ": " + n)
            .join(`
`);
    }
    get [Symbol.toStringTag]() {
        return "AxiosHeaders";
    }
    static from(t) {
        return t instanceof this ? t : new this(t);
    }
    static concat(t, ...n) {
        const s = new this(t);
        return n.forEach((r) => s.set(r)), s;
    }
    static accessor(t) {
        const s = (this[Ys] = this[Ys] = { accessors: {} }).accessors,
            r = this.prototype;
        function i(o) {
            const a = Xt(o);
            s[a] || (wf(r, o), (s[a] = !0));
        }
        return f.isArray(t) ? t.forEach(i) : i(t), this;
    }
}
Ke.accessor([
    "Content-Type",
    "Content-Length",
    "Accept",
    "Accept-Encoding",
    "User-Agent",
    "Authorization",
]);
f.freezeMethods(Ke.prototype);
f.freezeMethods(Ke);
const nt = Ke;
function pn(e, t) {
    const n = this || zn,
        s = t || n,
        r = nt.from(s.headers);
    let i = s.data;
    return (
        f.forEach(e, function (a) {
            i = a.call(n, i, r.normalize(), t ? t.status : void 0);
        }),
        r.normalize(),
        i
    );
}
function fi(e) {
    return !!(e && e.__CANCEL__);
}
function ae(e, t, n) {
    A.call(this, e ?? "canceled", A.ERR_CANCELED, t, n),
        (this.name = "CanceledError");
}
f.inherits(ae, A, { __CANCEL__: !0 });
function Of(e, t, n) {
    const s = n.config.validateStatus;
    !n.status || !s || s(n.status)
        ? e(n)
        : t(
              new A(
                  "Request failed with status code " + n.status,
                  [A.ERR_BAD_REQUEST, A.ERR_BAD_RESPONSE][
                      Math.floor(n.status / 100) - 4
                  ],
                  n.config,
                  n.request,
                  n
              )
          );
}
const Sf = G.isStandardBrowserEnv
    ? (function () {
          return {
              write: function (n, s, r, i, o, a) {
                  const u = [];
                  u.push(n + "=" + encodeURIComponent(s)),
                      f.isNumber(r) &&
                          u.push("expires=" + new Date(r).toGMTString()),
                      f.isString(i) && u.push("path=" + i),
                      f.isString(o) && u.push("domain=" + o),
                      a === !0 && u.push("secure"),
                      (document.cookie = u.join("; "));
              },
              read: function (n) {
                  const s = document.cookie.match(
                      new RegExp("(^|;\\s*)(" + n + ")=([^;]*)")
                  );
                  return s ? decodeURIComponent(s[3]) : null;
              },
              remove: function (n) {
                  this.write(n, "", Date.now() - 864e5);
              },
          };
      })()
    : (function () {
          return {
              write: function () {},
              read: function () {
                  return null;
              },
              remove: function () {},
          };
      })();
function Cf(e) {
    return /^([a-z][a-z\d+\-.]*:)?\/\//i.test(e);
}
function Nf(e, t) {
    return t ? e.replace(/\/+$/, "") + "/" + t.replace(/^\/+/, "") : e;
}
function di(e, t) {
    return e && !Cf(t) ? Nf(e, t) : t;
}
const Df = G.isStandardBrowserEnv
    ? (function () {
          const t = /(msie|trident)/i.test(navigator.userAgent),
              n = document.createElement("a");
          let s;
          function r(i) {
              let o = i;
              return (
                  t && (n.setAttribute("href", o), (o = n.href)),
                  n.setAttribute("href", o),
                  {
                      href: n.href,
                      protocol: n.protocol ? n.protocol.replace(/:$/, "") : "",
                      host: n.host,
                      search: n.search ? n.search.replace(/^\?/, "") : "",
                      hash: n.hash ? n.hash.replace(/^#/, "") : "",
                      hostname: n.hostname,
                      port: n.port,
                      pathname:
                          n.pathname.charAt(0) === "/"
                              ? n.pathname
                              : "/" + n.pathname,
                  }
              );
          }
          return (
              (s = r(window.location.href)),
              function (o) {
                  const a = f.isString(o) ? r(o) : o;
                  return a.protocol === s.protocol && a.host === s.host;
              }
          );
      })()
    : (function () {
          return function () {
              return !0;
          };
      })();
function Lf(e) {
    const t = /^([-+\w]{1,25})(:?\/\/|:)/.exec(e);
    return (t && t[1]) || "";
}
function Rf(e, t) {
    e = e || 10;
    const n = new Array(e),
        s = new Array(e);
    let r = 0,
        i = 0,
        o;
    return (
        (t = t !== void 0 ? t : 1e3),
        function (u) {
            const c = Date.now(),
                l = s[i];
            o || (o = c), (n[r] = u), (s[r] = c);
            let h = i,
                g = 0;
            for (; h !== r; ) (g += n[h++]), (h = h % e);
            if (((r = (r + 1) % e), r === i && (i = (i + 1) % e), c - o < t))
                return;
            const m = l && c - l;
            return m ? Math.round((g * 1e3) / m) : void 0;
        }
    );
}
function zs(e, t) {
    let n = 0;
    const s = Rf(50, 250);
    return (r) => {
        const i = r.loaded,
            o = r.lengthComputable ? r.total : void 0,
            a = i - n,
            u = s(a),
            c = i <= o;
        n = i;
        const l = {
            loaded: i,
            total: o,
            progress: o ? i / o : void 0,
            bytes: a,
            rate: u || void 0,
            estimated: u && o && c ? (o - i) / u : void 0,
            event: r,
        };
        (l[t ? "download" : "upload"] = !0), e(l);
    };
}
const $f = typeof XMLHttpRequest < "u",
    If =
        $f &&
        function (e) {
            return new Promise(function (n, s) {
                let r = e.data;
                const i = nt.from(e.headers).normalize(),
                    o = e.responseType;
                let a;
                function u() {
                    e.cancelToken && e.cancelToken.unsubscribe(a),
                        e.signal && e.signal.removeEventListener("abort", a);
                }
                f.isFormData(r) &&
                    (G.isStandardBrowserEnv || G.isStandardBrowserWebWorkerEnv
                        ? i.setContentType(!1)
                        : i.setContentType("multipart/form-data;", !1));
                let c = new XMLHttpRequest();
                if (e.auth) {
                    const m = e.auth.username || "",
                        p = e.auth.password
                            ? unescape(encodeURIComponent(e.auth.password))
                            : "";
                    i.set("Authorization", "Basic " + btoa(m + ":" + p));
                }
                const l = di(e.baseURL, e.url);
                c.open(
                    e.method.toUpperCase(),
                    ci(l, e.params, e.paramsSerializer),
                    !0
                ),
                    (c.timeout = e.timeout);
                function h() {
                    if (!c) return;
                    const m = nt.from(
                            "getAllResponseHeaders" in c &&
                                c.getAllResponseHeaders()
                        ),
                        _ = {
                            data:
                                !o || o === "text" || o === "json"
                                    ? c.responseText
                                    : c.response,
                            status: c.status,
                            statusText: c.statusText,
                            headers: m,
                            config: e,
                            request: c,
                        };
                    Of(
                        function (y) {
                            n(y), u();
                        },
                        function (y) {
                            s(y), u();
                        },
                        _
                    ),
                        (c = null);
                }
                if (
                    ("onloadend" in c
                        ? (c.onloadend = h)
                        : (c.onreadystatechange = function () {
                              !c ||
                                  c.readyState !== 4 ||
                                  (c.status === 0 &&
                                      !(
                                          c.responseURL &&
                                          c.responseURL.indexOf("file:") === 0
                                      )) ||
                                  setTimeout(h);
                          }),
                    (c.onabort = function () {
                        c &&
                            (s(new A("Request aborted", A.ECONNABORTED, e, c)),
                            (c = null));
                    }),
                    (c.onerror = function () {
                        s(new A("Network Error", A.ERR_NETWORK, e, c)),
                            (c = null);
                    }),
                    (c.ontimeout = function () {
                        let p = e.timeout
                            ? "timeout of " + e.timeout + "ms exceeded"
                            : "timeout exceeded";
                        const _ = e.transitional || li;
                        e.timeoutErrorMessage && (p = e.timeoutErrorMessage),
                            s(
                                new A(
                                    p,
                                    _.clarifyTimeoutError
                                        ? A.ETIMEDOUT
                                        : A.ECONNABORTED,
                                    e,
                                    c
                                )
                            ),
                            (c = null);
                    }),
                    G.isStandardBrowserEnv)
                ) {
                    const m =
                        (e.withCredentials || Df(l)) &&
                        e.xsrfCookieName &&
                        Sf.read(e.xsrfCookieName);
                    m && i.set(e.xsrfHeaderName, m);
                }
                r === void 0 && i.setContentType(null),
                    "setRequestHeader" in c &&
                        f.forEach(i.toJSON(), function (p, _) {
                            c.setRequestHeader(_, p);
                        }),
                    f.isUndefined(e.withCredentials) ||
                        (c.withCredentials = !!e.withCredentials),
                    o && o !== "json" && (c.responseType = e.responseType),
                    typeof e.onDownloadProgress == "function" &&
                        c.addEventListener(
                            "progress",
                            zs(e.onDownloadProgress, !0)
                        ),
                    typeof e.onUploadProgress == "function" &&
                        c.upload &&
                        c.upload.addEventListener(
                            "progress",
                            zs(e.onUploadProgress)
                        ),
                    (e.cancelToken || e.signal) &&
                        ((a = (m) => {
                            c &&
                                (s(!m || m.type ? new ae(null, e, c) : m),
                                c.abort(),
                                (c = null));
                        }),
                        e.cancelToken && e.cancelToken.subscribe(a),
                        e.signal &&
                            (e.signal.aborted
                                ? a()
                                : e.signal.addEventListener("abort", a)));
                const g = Lf(l);
                if (g && G.protocols.indexOf(g) === -1) {
                    s(
                        new A(
                            "Unsupported protocol " + g + ":",
                            A.ERR_BAD_REQUEST,
                            e
                        )
                    );
                    return;
                }
                c.send(r || null);
            });
        },
    Oe = { http: sf, xhr: If };
f.forEach(Oe, (e, t) => {
    if (e) {
        try {
            Object.defineProperty(e, "name", { value: t });
        } catch {}
        Object.defineProperty(e, "adapterName", { value: t });
    }
});
const Pf = {
    getAdapter: (e) => {
        e = f.isArray(e) ? e : [e];
        const { length: t } = e;
        let n, s;
        for (
            let r = 0;
            r < t &&
            ((n = e[r]), !(s = f.isString(n) ? Oe[n.toLowerCase()] : n));
            r++
        );
        if (!s)
            throw s === !1
                ? new A(
                      `Adapter ${n} is not supported by the environment`,
                      "ERR_NOT_SUPPORT"
                  )
                : new Error(
                      f.hasOwnProp(Oe, n)
                          ? `Adapter '${n}' is not available in the build`
                          : `Unknown adapter '${n}'`
                  );
        if (!f.isFunction(s)) throw new TypeError("adapter is not a function");
        return s;
    },
    adapters: Oe,
};
function _n(e) {
    if (
        (e.cancelToken && e.cancelToken.throwIfRequested(),
        e.signal && e.signal.aborted)
    )
        throw new ae(null, e);
}
function qs(e) {
    return (
        _n(e),
        (e.headers = nt.from(e.headers)),
        (e.data = pn.call(e, e.transformRequest)),
        ["post", "put", "patch"].indexOf(e.method) !== -1 &&
            e.headers.setContentType("application/x-www-form-urlencoded", !1),
        Pf.getAdapter(e.adapter || zn.adapter)(e).then(
            function (s) {
                return (
                    _n(e),
                    (s.data = pn.call(e, e.transformResponse, s)),
                    (s.headers = nt.from(s.headers)),
                    s
                );
            },
            function (s) {
                return (
                    fi(s) ||
                        (_n(e),
                        s &&
                            s.response &&
                            ((s.response.data = pn.call(
                                e,
                                e.transformResponse,
                                s.response
                            )),
                            (s.response.headers = nt.from(
                                s.response.headers
                            )))),
                    Promise.reject(s)
                );
            }
        )
    );
}
const Gs = (e) => (e instanceof nt ? e.toJSON() : e);
function Ft(e, t) {
    t = t || {};
    const n = {};
    function s(c, l, h) {
        return f.isPlainObject(c) && f.isPlainObject(l)
            ? f.merge.call({ caseless: h }, c, l)
            : f.isPlainObject(l)
            ? f.merge({}, l)
            : f.isArray(l)
            ? l.slice()
            : l;
    }
    function r(c, l, h) {
        if (f.isUndefined(l)) {
            if (!f.isUndefined(c)) return s(void 0, c, h);
        } else return s(c, l, h);
    }
    function i(c, l) {
        if (!f.isUndefined(l)) return s(void 0, l);
    }
    function o(c, l) {
        if (f.isUndefined(l)) {
            if (!f.isUndefined(c)) return s(void 0, c);
        } else return s(void 0, l);
    }
    function a(c, l, h) {
        if (h in t) return s(c, l);
        if (h in e) return s(void 0, c);
    }
    const u = {
        url: i,
        method: i,
        data: i,
        baseURL: o,
        transformRequest: o,
        transformResponse: o,
        paramsSerializer: o,
        timeout: o,
        timeoutMessage: o,
        withCredentials: o,
        adapter: o,
        responseType: o,
        xsrfCookieName: o,
        xsrfHeaderName: o,
        onUploadProgress: o,
        onDownloadProgress: o,
        decompress: o,
        maxContentLength: o,
        maxBodyLength: o,
        beforeRedirect: o,
        transport: o,
        httpAgent: o,
        httpsAgent: o,
        cancelToken: o,
        socketPath: o,
        responseEncoding: o,
        validateStatus: a,
        headers: (c, l) => r(Gs(c), Gs(l), !0),
    };
    return (
        f.forEach(Object.keys(Object.assign({}, e, t)), function (l) {
            const h = u[l] || r,
                g = h(e[l], t[l], l);
            (f.isUndefined(g) && h !== a) || (n[l] = g);
        }),
        n
    );
}
const hi = "1.4.0",
    qn = {};
["object", "boolean", "number", "function", "string", "symbol"].forEach(
    (e, t) => {
        qn[e] = function (s) {
            return typeof s === e || "a" + (t < 1 ? "n " : " ") + e;
        };
    }
);
const Xs = {};
qn.transitional = function (t, n, s) {
    function r(i, o) {
        return (
            "[Axios v" +
            hi +
            "] Transitional option '" +
            i +
            "'" +
            o +
            (s ? ". " + s : "")
        );
    }
    return (i, o, a) => {
        if (t === !1)
            throw new A(
                r(o, " has been removed" + (n ? " in " + n : "")),
                A.ERR_DEPRECATED
            );
        return (
            n &&
                !Xs[o] &&
                ((Xs[o] = !0),
                console.warn(
                    r(
                        o,
                        " has been deprecated since v" +
                            n +
                            " and will be removed in the near future"
                    )
                )),
            t ? t(i, o, a) : !0
        );
    };
};
function xf(e, t, n) {
    if (typeof e != "object")
        throw new A("options must be an object", A.ERR_BAD_OPTION_VALUE);
    const s = Object.keys(e);
    let r = s.length;
    for (; r-- > 0; ) {
        const i = s[r],
            o = t[i];
        if (o) {
            const a = e[i],
                u = a === void 0 || o(a, i, e);
            if (u !== !0)
                throw new A(
                    "option " + i + " must be " + u,
                    A.ERR_BAD_OPTION_VALUE
                );
            continue;
        }
        if (n !== !0) throw new A("Unknown option " + i, A.ERR_BAD_OPTION);
    }
}
const On = { assertOptions: xf, validators: qn },
    at = On.validators;
class Re {
    constructor(t) {
        (this.defaults = t),
            (this.interceptors = { request: new Ks(), response: new Ks() });
    }
    request(t, n) {
        typeof t == "string" ? ((n = n || {}), (n.url = t)) : (n = t || {}),
            (n = Ft(this.defaults, n));
        const { transitional: s, paramsSerializer: r, headers: i } = n;
        s !== void 0 &&
            On.assertOptions(
                s,
                {
                    silentJSONParsing: at.transitional(at.boolean),
                    forcedJSONParsing: at.transitional(at.boolean),
                    clarifyTimeoutError: at.transitional(at.boolean),
                },
                !1
            ),
            r != null &&
                (f.isFunction(r)
                    ? (n.paramsSerializer = { serialize: r })
                    : On.assertOptions(
                          r,
                          { encode: at.function, serialize: at.function },
                          !0
                      )),
            (n.method = (
                n.method ||
                this.defaults.method ||
                "get"
            ).toLowerCase());
        let o;
        (o = i && f.merge(i.common, i[n.method])),
            o &&
                f.forEach(
                    ["delete", "get", "head", "post", "put", "patch", "common"],
                    (p) => {
                        delete i[p];
                    }
                ),
            (n.headers = nt.concat(o, i));
        const a = [];
        let u = !0;
        this.interceptors.request.forEach(function (_) {
            (typeof _.runWhen == "function" && _.runWhen(n) === !1) ||
                ((u = u && _.synchronous), a.unshift(_.fulfilled, _.rejected));
        });
        const c = [];
        this.interceptors.response.forEach(function (_) {
            c.push(_.fulfilled, _.rejected);
        });
        let l,
            h = 0,
            g;
        if (!u) {
            const p = [qs.bind(this), void 0];
            for (
                p.unshift.apply(p, a),
                    p.push.apply(p, c),
                    g = p.length,
                    l = Promise.resolve(n);
                h < g;

            )
                l = l.then(p[h++], p[h++]);
            return l;
        }
        g = a.length;
        let m = n;
        for (h = 0; h < g; ) {
            const p = a[h++],
                _ = a[h++];
            try {
                m = p(m);
            } catch (b) {
                _.call(this, b);
                break;
            }
        }
        try {
            l = qs.call(this, m);
        } catch (p) {
            return Promise.reject(p);
        }
        for (h = 0, g = c.length; h < g; ) l = l.then(c[h++], c[h++]);
        return l;
    }
    getUri(t) {
        t = Ft(this.defaults, t);
        const n = di(t.baseURL, t.url);
        return ci(n, t.params, t.paramsSerializer);
    }
}
f.forEach(["delete", "get", "head", "options"], function (t) {
    Re.prototype[t] = function (n, s) {
        return this.request(
            Ft(s || {}, { method: t, url: n, data: (s || {}).data })
        );
    };
});
f.forEach(["post", "put", "patch"], function (t) {
    function n(s) {
        return function (i, o, a) {
            return this.request(
                Ft(a || {}, {
                    method: t,
                    headers: s ? { "Content-Type": "multipart/form-data" } : {},
                    url: i,
                    data: o,
                })
            );
        };
    }
    (Re.prototype[t] = n()), (Re.prototype[t + "Form"] = n(!0));
});
const Se = Re;
class Gn {
    constructor(t) {
        if (typeof t != "function")
            throw new TypeError("executor must be a function.");
        let n;
        this.promise = new Promise(function (i) {
            n = i;
        });
        const s = this;
        this.promise.then((r) => {
            if (!s._listeners) return;
            let i = s._listeners.length;
            for (; i-- > 0; ) s._listeners[i](r);
            s._listeners = null;
        }),
            (this.promise.then = (r) => {
                let i;
                const o = new Promise((a) => {
                    s.subscribe(a), (i = a);
                }).then(r);
                return (
                    (o.cancel = function () {
                        s.unsubscribe(i);
                    }),
                    o
                );
            }),
            t(function (i, o, a) {
                s.reason || ((s.reason = new ae(i, o, a)), n(s.reason));
            });
    }
    throwIfRequested() {
        if (this.reason) throw this.reason;
    }
    subscribe(t) {
        if (this.reason) {
            t(this.reason);
            return;
        }
        this._listeners ? this._listeners.push(t) : (this._listeners = [t]);
    }
    unsubscribe(t) {
        if (!this._listeners) return;
        const n = this._listeners.indexOf(t);
        n !== -1 && this._listeners.splice(n, 1);
    }
    static source() {
        let t;
        return {
            token: new Gn(function (r) {
                t = r;
            }),
            cancel: t,
        };
    }
}
const Mf = Gn;
function kf(e) {
    return function (n) {
        return e.apply(null, n);
    };
}
function Vf(e) {
    return f.isObject(e) && e.isAxiosError === !0;
}
const Sn = {
    Continue: 100,
    SwitchingProtocols: 101,
    Processing: 102,
    EarlyHints: 103,
    Ok: 200,
    Created: 201,
    Accepted: 202,
    NonAuthoritativeInformation: 203,
    NoContent: 204,
    ResetContent: 205,
    PartialContent: 206,
    MultiStatus: 207,
    AlreadyReported: 208,
    ImUsed: 226,
    MultipleChoices: 300,
    MovedPermanently: 301,
    Found: 302,
    SeeOther: 303,
    NotModified: 304,
    UseProxy: 305,
    Unused: 306,
    TemporaryRedirect: 307,
    PermanentRedirect: 308,
    BadRequest: 400,
    Unauthorized: 401,
    PaymentRequired: 402,
    Forbidden: 403,
    NotFound: 404,
    MethodNotAllowed: 405,
    NotAcceptable: 406,
    ProxyAuthenticationRequired: 407,
    RequestTimeout: 408,
    Conflict: 409,
    Gone: 410,
    LengthRequired: 411,
    PreconditionFailed: 412,
    PayloadTooLarge: 413,
    UriTooLong: 414,
    UnsupportedMediaType: 415,
    RangeNotSatisfiable: 416,
    ExpectationFailed: 417,
    ImATeapot: 418,
    MisdirectedRequest: 421,
    UnprocessableEntity: 422,
    Locked: 423,
    FailedDependency: 424,
    TooEarly: 425,
    UpgradeRequired: 426,
    PreconditionRequired: 428,
    TooManyRequests: 429,
    RequestHeaderFieldsTooLarge: 431,
    UnavailableForLegalReasons: 451,
    InternalServerError: 500,
    NotImplemented: 501,
    BadGateway: 502,
    ServiceUnavailable: 503,
    GatewayTimeout: 504,
    HttpVersionNotSupported: 505,
    VariantAlsoNegotiates: 506,
    InsufficientStorage: 507,
    LoopDetected: 508,
    NotExtended: 510,
    NetworkAuthenticationRequired: 511,
};
Object.entries(Sn).forEach(([e, t]) => {
    Sn[t] = e;
});
const Hf = Sn;
function pi(e) {
    const t = new Se(e),
        n = Xr(Se.prototype.request, t);
    return (
        f.extend(n, Se.prototype, t, { allOwnKeys: !0 }),
        f.extend(n, t, null, { allOwnKeys: !0 }),
        (n.create = function (r) {
            return pi(Ft(e, r));
        }),
        n
    );
}
const D = pi(zn);
D.Axios = Se;
D.CanceledError = ae;
D.CancelToken = Mf;
D.isCancel = fi;
D.VERSION = hi;
D.toFormData = We;
D.AxiosError = A;
D.Cancel = D.CanceledError;
D.all = function (t) {
    return Promise.all(t);
};
D.spread = kf;
D.isAxiosError = Vf;
D.mergeConfig = Ft;
D.AxiosHeaders = nt;
D.formToJSON = (e) => ui(f.isHTMLForm(e) ? new FormData(e) : e);
D.HttpStatusCode = Hf;
D.default = D;
const Ff = D;
window.axios = Ff;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
