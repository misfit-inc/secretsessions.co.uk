! function(a, b, c) {
    function d(b, c) {
        this.element = b, this.settings = a.extend({}, f, c), this._defaults = f, this._name = e, this.init()
    }
    var e = "fullScreenNav",
        f = {
            closeMenuBtnClass: ".close-menu-btn",
            menuBtn: ".open-menu-btn",
            openClass: ".open"
        };
    d.prototype = {
        init: function() {
            var d = this,
                e = c.documentElement.clientHeight,
                f = a(this.element).find("ul a"),
                g = e / f.length,
                h = this.settings.closeMenuBtnClass.split(".")[1],
                i = a("<a>", {
                    "class": h,
                    text: this.settings.closeMenuBtnText,
                    href: "#"
                });
            this.sizeLinks(f, g, this.settings), i.insertBefore(a(this.element).children("ul")), a(b).on("resize.fullScreenNav", function() {
                var a = c.documentElement.clientHeight,
                    b = a / f.length;
                d.sizeLinks(f, b, d.settings)
            }), a(this.settings.menuBtn).add(i).add(f).on("click", function() {
                d.toggleMenu(this.element, this.settings)
            })
        },
        sizeLinks: function(a, b, c) {
            a.css({
                height: b / c.baseFontSize + "rem",
                "line-height": b / c.baseFontSize + "rem",
                "font-size": b / c.fontSizeDivisor / c.baseFontSize + "rem"
            })
        },
        toggleMenu: function() {
            var b = this.settings.openClass.split(".")[1];
            a(this.element).toggleClass(b)
        }
    }, a.fn[e] = function(b) {
        return this.each(function() {
            a.data(this, "plugin_" + e) || a.data(this, "plugin_" + e, new d(this, b))
        }), this
    }
}(jQuery, window, document);