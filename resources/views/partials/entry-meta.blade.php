<a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn inline-flex items-center">
  <img alt="blog" src="https://dummyimage.com/104x104"
    class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
  <span class="byline author vcard flex-grow flex flex-col pl-4">
    <span class="title-font font-medium text-gray-900">{{ get_the_author() }}</span>
    <time class="updated text-gray-400 text-xs tracking-widest mt-0.5" datetime="{{ get_post_time('c', true) }}">
      {{ get_the_date() }}
    </time>
  </span>
</a>