const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
module.exports = {
    ...defaultConfig,
    entry: {
        'block': './src/js/block.js',
        'editor': './src/sass/editor.scss',
        'frontend': './src/sass/frontend.scss',
        'admin': './src/sass/admin.scss'
    },
    output: {
        path: __dirname + '/build/',
        filename: '[name].js'
    }
};
