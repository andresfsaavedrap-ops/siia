const path = require("path");

module.exports = {
	entry: "./assets/js/src/index.js",
	output: {
		path: path.resolve(__dirname, "assets/dist"),
		filename: "bundle.js",
		publicPath: "/assets/dist/"
	},
	mode: process.env.NODE_ENV || "development",
	devServer: {
		static: {
			directory: path.join(__dirname, "./"),
		},
		compress: true,
		port: 9000,
		hot: true,
		open: false // Cambiar a false para proyectos PHP
	},
	module: {
		rules: [
			{
				test: /\.css$/,
				use: ["style-loader", "css-loader"]
			},
			{
				test: /\.(png|svg|jpg|jpeg|gif)$/i,
				type: 'asset/resource'
			},
			{
				test: /\.(woff|woff2|eot|ttf|otf)$/i,
				type: 'asset/resource'
			}
		]
	},
	resolve: {
		alias: {
			'@': path.resolve(__dirname, 'assets/js/src')
		}
	}
};
