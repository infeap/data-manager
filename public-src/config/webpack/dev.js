/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

'use strict'

const glob = require('glob')
const path = require('path')

const autoprefixer = require('autoprefixer')
const VueLoaderPlugin = require('vue-loader/lib/plugin')
const webpack = require('webpack')

module.exports = function (env) {

    return {
        devServer: {
            disableHostCheck: true,
            headers: {
                'Access-Control-Allow-Origin': '*',
            },
            hot: true,
            https: true,
        },
        entry() {
            let files = {}

            for (let file of glob.sync('public-src/js/*.js')) {
                files[path.basename(file, '.js')] = './' + file
            }

            return files
        },
        output: {
            filename: 'js/compiled/[name].js',
            chunkFilename: 'js/compiled/[name].js?v=[hash]',
            path: path.resolve('public'),
            publicPath: 'https://localhost:8080/',
        },
        module: {
            rules: [
                {
                    include: [
                        path.resolve('public-src/js/'),
                    ],
                    test: /\.js$/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            cacheDirectory: true,
                            presets: [
                                ['@babel/preset-env', {
                                    useBuiltIns: 'usage',
                                    corejs: 2,
                                }],
                            ],
                        },
                    },
                },
                {
                    include: [
                        path.resolve('public-src/js/'),
                    ],
                    test: /\.vue$/,
                    use: [
                        'vue-loader',
                    ],
                },
                {
                    include: [
                        path.resolve('public-src/css/'),
                        path.resolve('public-src/js/'),
                    ],
                    test: /\.scss$/,
                    use: [
                        'style-loader',
                        {
                            loader: 'css-loader',
                            options: {
                                url: false,
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                plugins: [
                                    autoprefixer,
                                ],
                            },
                        },
                        {
                            loader: 'string-replace-loader',
                            options: {
                                search: 'url\\(([a-z\\-]+)\\/',
                                replace: 'url(../../$1/',
                                flags: 'gi',
                            },
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sassOptions: {
                                    outputStyle: 'expanded',
                                    sourceComments: true,
                                    sourceMapEmbed: true,
                                },
                            },
                        },
                    ],
                },
            ],
        },
        plugins: [
            new VueLoaderPlugin(),
            new webpack.DefinePlugin({
                __debug__: true,
                __develop__: true,
            }),
        ],
        resolve: {
            alias: {
                'jquery-slim$': 'jquery/dist/jquery.slim',
                'vue$': 'vue/dist/vue.runtime.esm',
            },
        },
        optimization: {
            splitChunks: {
                chunks: 'all',
            },
        },
        devtool: false,
        mode: 'development',
    }
}
