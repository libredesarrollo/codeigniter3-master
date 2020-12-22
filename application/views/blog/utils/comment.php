<div class="comments"> <?php if (ENVIRONMENT !== "development") { ?> <script type="text/javascript">
            var addthis_config = {
                "data_track_addressbar": true
            };
        </script>
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            var disqus_shortname = 'desarrollolibre';
            (function() {
                var dsq = document.createElement('script');
                dsq.type = 'text/javascript';
                dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script> <?php } ?>
</div>