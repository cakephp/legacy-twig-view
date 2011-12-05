{# do all the normal $channel stuff in controller... #}
{# the below is untested, but should work. #}
{{ rss.header() }}
{{ rss.document(rss.channel([], channel, content_for_layout)) }}