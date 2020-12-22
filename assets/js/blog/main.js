document.getElementById("btn-search-post").addEventListener("click", function () {
    fetch(BASE_URL + 'blog/search?search=' + document.getElementById("input-search-post").value + "&category_id=" + document.getElementById("list-categories").value)
            .then(response => response.text())
            .then(res => document.getElementById("post_search").innerHTML = res);
});

function production() {
    // google analitica
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '/assets/js/analytics.js', 'ga');

    ga('create', 'UA-42574954-1', 'auto');
    ga('send', 'pageview');


}

if (ENVIRONMENT !== "development")
    production()