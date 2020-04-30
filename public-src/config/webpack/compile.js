/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

'use strict'

const glob = require('glob')
const path = require('path')

const autoprefixer = require('autoprefixer')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const VueLoaderPlugin = require('vue-loader/lib/plugin')

module.exports = function (env) {

    if (env.production) {
        env.vars = {
            fileExtensionPrefix: '.min',
            sassOptions: {},
            mode: 'production',
        }
    }

    if (env.debug) {
        env.vars = {
            fileExtensionPrefix: '',
            sassOptions: {
                outputStyle: 'expanded',
                sourceComments: true,
                sourceMapEmbed: true,
            },
            mode: 'development',
        }
    }

    return {
        entry() {
            let files = {}

            for (let file of glob.sync('public-src/js/*.js')) {
                files[path.basename(file, '.js')] = './' + file
            }

            return files
        },
        output: {
            filename: 'js/compiled/[name]' + env.vars.fileExtensionPrefix + '.js',
            chunkFilename: 'js/compiled/[name]' + env.vars.fileExtensionPrefix + '.js?v=[hash]',
            path: path.resolve('public'),
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
                                    corejs: 3,
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
                        MiniCssExtractPlugin.loader,
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
                                sassOptions: env.vars.sassOptions,
                            },
                        },
                    ],
                },
            ],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: 'css/compiled/[name]' + env.vars.fileExtensionPrefix + '.css',
                chunkFilename: 'css/compiled/[name]' + env.vars.fileExtensionPrefix + '.css?v=[hash]',
            }),
            new VueLoaderPlugin(),
        ],
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js',
            },
        },
        optimization: {
            splitChunks: {
                chunks: 'all',
            },
        },
        devtool: false,
        mode: env.vars.mode,
    }
}
