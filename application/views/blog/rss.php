<?php header("Content-type: text/xml"); ?>

<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title>Últimas novedades Blog - [Desarrollo Libre]</title>
        <link>http://www.desarrollolibre.net</link>
        <description>
            Trucos que pueden necesitar los programadores para aprender o profundizar en el desarrollo de aplicaciones.
        </description>
        <language>es-es</language>
        <copyright>DesarrolloLibre.com</copyright>
        <atom:link href="https://desarrollolibre.net/blog/rss" rel="self" type="application/rss+xml"/>

        <?php foreach ($posts as $a) { ?>
            <item>
                <title><?php echo $a->title ?></title>
                <description>
                    <?php echo $a->description ?>
                </description>
                <link>
                <?php echo url_post_by_id($a->post_id) ?>
                </link>
                <pubDate><?php echo $a->date ?></pubDate>
                <guid>
                    <?php echo url_post_by_id($a->post_id) ?>
                </guid>
            </item>

        <?php } ?>

    </channel>
</rss>