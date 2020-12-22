<script type="application/ld+json">
    {
        "@context": "http://schema.org/",
        "@type": "Article",
        "mainEntityOfPage": "<?php echo base_url() . 'blog/' . $post->c_url_clean . '/' . $post->url_clean ?>",
        "name": "<?php echo $post->title ?>",
        "headline": "<?php echo $post->description ?>",
        "datePublished": "<?php echo $post->date ?>",
        "description": "<?php echo $post->description ?>",
        "sameAs" : [
            "https://twitter.com/LibreDesarrollo",
            "https://www.facebook.com/desarrollolibre.net",
            "https://www.youtube.com/channel/UCx2k2IT5x9j5MRXhMrlL96A",
            "https://github.com/libredesarrollo",
            "https://es.pinterest.com/desarrollolibre/",
            ],
        "publisher": {
            "@type": "Organization",
            "name": "DesarrolloLibre",
            "logo": {
                "@type": "ImageObject",
                "url": "https://www.desarrollolibre.net/assets/img/logo.png",
                "width": 886,
                "height": 625
            }
        },
        "author": {
            "@type": "Person",
            "name": "Andres Cruz Yoris"
        },
        "url": "<?php $url ?>",
        "thumbnailUrl": "<?php echo image_post($post->post_id) ?>",
        "articleSection": "<?php echo $post->category ?>",
        "creator": "Andres Cruz Yoris",
        "keywords": "<?php echo $post->category ?>"
    }
</script>