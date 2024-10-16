(function (blocks, element, blockEditor, components, i18n) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var ColorPicker = components.ColorPicker;
    var __ = i18n.__;

    registerBlockType("greenoffice/quote-block", {
        title: __("Green Office", "rrze-green-office"),
        icon: "format-quote",
        category: "widgets",
        attributes: {
            cssClasses: {
                type: "string",
                default: ""
            },
            backgroundColor: {
                type: "string",
                default: "#ffffff"
            },
            borderColor: {
                type: "string",
                default: "#000000"
            }
        },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            return [
                el(
                    InspectorControls,
                    { key: "inspector" },
                    el(
                        PanelBody,
                        { title: __("Block Settings", "rrze-green-office"), initialOpen: true },
                        el(TextControl, {
                            label: __("CSS Classes", "rrze-green-office"),
                            value: attributes.cssClasses,
                            onChange: function (newVal) {
                                setAttributes({ cssClasses: newVal });
                            }
                        }),
                        el("div", { style: { marginBottom: "20px" } }, 
                            el(ColorPicker, {
                                label: __("Background Color", "rrze-green-office"),
                                color: attributes.backgroundColor,
                                onChangeComplete: function (newColor) {
                                    setAttributes({ backgroundColor: newColor.hex });
                                },
                                disableAlpha: true
                            })
                        ),
                        el("div", { style: { marginBottom: "20px" } }, 
                            el(ColorPicker, {
                                label: __("Border Color", "rrze-green-office"),
                                color: attributes.borderColor,
                                onChangeComplete: function (newColor) {
                                    setAttributes({ borderColor: newColor.hex });
                                },
                                disableAlpha: true
                            })
                        )
                    )
                ),
                el(
                    "blockquote",
                    {
                        className: "rrze-green-office " + attributes.cssClasses,
                        style: {
                            backgroundColor: attributes.backgroundColor,
                            borderColor: attributes.borderColor,
                            borderStyle: "solid"
                        },
                        lang: "de"
                    },
                    el(
                        "p",
                        {},
                        el(
                            "span",
                            { className: "wouf-ucfirst" },
                            __("Wuff!", "rrze-green-office")
                        ),
                        " ",
                        el(
                            "span",
                            { className: "wouf-ucfirst wouf-uppercase" },
                            __("Wuff!", "rrze-green-office")
                        )
                    ),
                    el("cite", {}, "🐶 Green Office")
                )
            ];
        },
        save: function () {
            return null; // Rendered in PHP on the frontend
        }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.i18n
);
