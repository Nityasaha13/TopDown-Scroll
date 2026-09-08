document.addEventListener("DOMContentLoaded", function () {

    var HEX = /^#([A-Fa-f0-9]{3}){1,2}$/;

    /**
     * <input type="color"> only accepts the 6-digit form, so #abc has to be
     * expanded before it is assigned or the swatch silently falls back to black.
     */
    function toSixDigit(hex) {
        var short = /^#([A-Fa-f0-9]{3})$/.exec(hex);

        if (!short) {
            return hex;
        }

        return "#" + short[1].replace(/./g, function (character) {
            return character + character;
        });
    }

    /*
     * Each colour setting is a pair inside one .tdsc-color__field: a native
     * swatch, and the text input that actually gets submitted. Pairing them by
     * container rather than by id means new colour settings need no JS changes.
     */
    var fields = document.querySelectorAll(".tdsc-color__field");

    Array.prototype.forEach.call(fields, function (field) {

        var swatch = field.querySelector(".customColorInput__select-input");
        var text = field.querySelector(".customColorInput__text-input");

        if (!swatch || !text) {
            return;
        }

        // Saved values may be in the short form; line the swatch up on load.
        if (HEX.test(text.value)) {
            swatch.value = toSixDigit(text.value);
        }

        swatch.addEventListener("input", function () {
            text.value = swatch.value;
        });

        text.addEventListener("input", function () {
            // Only mirror a complete value, so typing "#0" does not reset the swatch.
            if (HEX.test(text.value)) {
                swatch.value = toSixDigit(text.value);
            }
        });
    });
});
