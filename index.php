<!--
    This file is part of the
    Infeap Data Manager (https://www.infeap.org/data-manager)
    open source project.

    @copyright   2018-2020 Tobias Krebs and the Infeap Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3



    The official entry point to this application is public/start.php

    Apache's document root should be set to the public/ directory!
-->

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="application-name" content="Infeap Data Manager">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="favicon.ico">
        <link rel="stylesheet" href="<?php if (! isset($fromPublic)) { echo 'public/'; } ?>css/compiled/foundation.min.css">
        <title>Infeap Data Manager / Setup</title>
    </head>

    <body class="inf-has-basic-message">
        <article class="inf-basic-message">
            <header>
                <figure>
                    <svg id="inf-logo" width="160" height="44" viewBox="0 0 160 44">
                        <title>Infeap</title>
                        <path d="M273.29,246.71h-5.37V214.19h5.37Z" transform="translate(-225.88 -211.94)" />
                        <path d="M284.23,222.54l.14,2.8a8.16,8.16,0,0,1,6.72-3.24q7.2,0,7.33,8.64v16h-5.18V231.05a5.15,5.15,0,0,0-.95-3.4,3.86,3.86,0,0,0-3.1-1.11,5,5,0,0,0-4.67,3v17.2h-5.17V222.54Z" transform="translate(-225.88 -211.94)" />
                        <path d="M305.51,246.71V226.56H302v-4h3.51v-2.21a8.46,8.46,0,0,1,2.14-6.2,7.92,7.92,0,0,1,6-2.19,11.35,11.35,0,0,1,2.9.4l-.13,4.24a9.69,9.69,0,0,0-2-.18c-2.47,0-3.71,1.34-3.71,4v2.14h4.69v4h-4.69v20.15Z" transform="translate(-225.88 -211.94)" />
                        <path d="M328.81,247.16a10.45,10.45,0,0,1-8-3.25,12.12,12.12,0,0,1-3.06-8.66v-.67a15,15,0,0,1,1.33-6.46,10.49,10.49,0,0,1,3.74-4.44,9.6,9.6,0,0,1,5.37-1.58,8.86,8.86,0,0,1,7.28,3.15q2.56,3.15,2.57,8.91v2.19H323a7.37,7.37,0,0,0,1.91,4.73,5.57,5.57,0,0,0,4.2,1.74,6.9,6.9,0,0,0,5.8-3l2.79,2.79A9.49,9.49,0,0,1,334,246,11.15,11.15,0,0,1,328.81,247.16Zm-.62-20.71a4.25,4.25,0,0,0-3.44,1.57,8.31,8.31,0,0,0-1.68,4.35h9.87V232a6.75,6.75,0,0,0-1.38-4.12A4.25,4.25,0,0,0,328.19,226.45Z" transform="translate(-225.88 -211.94)" />
                        <path d="M355.85,246.71a8.47,8.47,0,0,1-.6-2.26,7.86,7.86,0,0,1-6.05,2.71,7.94,7.94,0,0,1-5.67-2.08,6.81,6.81,0,0,1-2.19-5.14,7,7,0,0,1,2.74-5.93q2.73-2.06,7.83-2.06h3.17v-1.59a4.33,4.33,0,0,0-1-3,3.88,3.88,0,0,0-3.05-1.13,4.43,4.43,0,0,0-2.9.93,2.9,2.9,0,0,0-1.12,2.35h-5.18a6.28,6.28,0,0,1,1.25-3.72,8.52,8.52,0,0,1,3.42-2.71,11.68,11.68,0,0,1,4.83-1,9.41,9.41,0,0,1,6.46,2.13,7.78,7.78,0,0,1,2.47,6v10.9a12.93,12.93,0,0,0,.87,5.2v.38Zm-5.69-3.91a5.73,5.73,0,0,0,2.89-.78,5.06,5.06,0,0,0,2-2.1v-4.56h-2.79a7.37,7.37,0,0,0-4.33,1,3.46,3.46,0,0,0-1.44,3,3.22,3.22,0,0,0,1,2.49A3.71,3.71,0,0,0,350.16,242.8Z" transform="translate(-225.88 -211.94)" />
                        <path d="M385.88,234.87q0,5.61-2.43,8.95a8.19,8.19,0,0,1-12.6.72V256h-5.18V222.54h4.78l.21,2.46a7.48,7.48,0,0,1,6.2-2.9,7.76,7.76,0,0,1,6.62,3.29q2.4,3.3,2.4,9.15Zm-5.16-.47a10.44,10.44,0,0,0-1.38-5.74,4.4,4.4,0,0,0-3.93-2.12,4.75,4.75,0,0,0-4.56,2.75V240a4.78,4.78,0,0,0,4.61,2.81,4.4,4.4,0,0,0,3.86-2.08Q380.72,238.64,380.72,234.4Z" transform="translate(-225.88 -211.94)" />
                        <path d="M248.32,224.18c-.16-.19-.27-.07-.37,0L234.77,238c-.1.11-.21.23,0,.4a9.31,9.31,0,0,0,13.43-.17A10.42,10.42,0,0,0,248.32,224.18Z" transform="translate(-225.88 -211.94)" />
                        <path d="M235.28,231.87l-6.38-6.68c-.1-.1-.21-.22-.38,0a10.43,10.43,0,0,0,0,13.89c.17.18.28.07.38,0l6.38-6.68A.35.35,0,0,0,235.28,231.87Z" transform="translate(-225.88 -211.94)" />
                        <path d="M241.19,225.78a4.65,4.65,0,0,0-6.46,0c-.17.17-.06.28,0,.39l3,3.12a.29.29,0,0,0,.42,0l3-3.12C241.25,226.06,241.36,226,241.19,225.78Z" transform="translate(-225.88 -211.94)" />
                    </svg>

                    <figcaption>Data Manager &nbsp;/&nbsp; Setup</figcaption>
                </figure>
            </header>

            <main>
                <section>
                    <?php

                    if (! isset($heading)) {
                        $heading = 'Apache setup required';
                    }

                    printf('<h1>%s</h1>',
                        $heading);

                    if (isset($text)) {
                        printf('<p>%s</p>',
                            $text);
                    } else {
                        echo '<p>The Apache HTTP Server module <b>mod_rewrite</b> must be installed and enabled to be used in <b>.htaccess</b> files – but seems not to.</p>';
                        echo '<p>Please ask your server\'s administrator to enable it.</p>';
                    }

                    ?>
                </section>
            </main>

            <footer>
                <a href="https://www.infeap.org/data-manager" target="_blank" rel="external noreferrer noopener">Infeap Website</a>
                <a href="https://www.infeap.org/data-manager/help?search=<?php echo urlencode($heading); ?>" target="_blank" rel="external noreferrer noopener">Help</a>
            </footer>
        </article>
    </body>
</html>
