const webpack = require('webpack');
const path = require('path');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
	context: path.resolve(__dirname, './src/assets/js'),
	entry: {
		app_main:'./app_main.js',
		app_dashboard:'./app_dashboard.js',
		app_config:'./app_config.js',
	},
	output: {
		path: path.resolve(__dirname, 'public/assets/js'),
		filename: "[name].js"
	},
	mode: 'production',
	resolve: {
		alias: {
			// jquery: "jquery/src/jquery",
			'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
		}
	},
	plugins: [
		new webpack.ProvidePlugin({
			$: "jquery",
			jQuery: "jquery"
		}),
		new VueLoaderPlugin()
	],
	module: {
		rules: [
		//{
		//	//test: require.resolve("some-module"),
		//	test: require.resolve("./node_modules/slider-pro/dist/js/jquery.sliderPro.js"),
		//	use: "imports-loader?$=jquery"
		//},
		{
			test: /\.css$/,
			use: [
				'style-loader',
				'css-loader'
			]
		},
		{
			test: /\.scss$/,
			use: [
				'style-loader',
				'css-loader',
				'sass-loader'
			]
		},
		{
			test: /\.vue$/,
			use: [
				'vue-loader'
			]
		},
		]
	}
};

