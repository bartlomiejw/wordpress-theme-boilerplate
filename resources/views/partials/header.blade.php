<header class="text-gray-600 body-font">
  <div class="container mx-auto flex flex-wrap flex-col md:flex-row items-center">
    @php
    $customLogoId = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $customLogoId , 'full' );
    @endphp
    @if ($customLogoId)
    <a class="brand title-font font-medium items-center text-gray-900" href="{{ home_url('/') }}">
      <img src="{{ $image[0] }}" class="mr-5" alt="{{ htmlspecialchars(get_the_title()) }}">
      {{-- <span class="text-xl text-gray-900">{{ $siteName }}</span> --}}
    </a>
    @else
    <a class="brand flex title-font font-medium items-center text-gray-900" href="{{ home_url('/') }}">
      <span class="text-xl">{{ $siteName }}</span>
    </a>
    @endif
    <nav class="nav-primary py-5 md:ml-auto flex flex-wrap items-center text-base justify-center">
      @if (has_nav_menu('primary_navigation'))
      @php
      $defaults = array(
      'theme_location' => 'primary_navigation',
      'menu_class' => 'md:ml-auto flex flex-wrap items-center text-base justify-center',
      'link_class' => 'mr-5 hover:text-gray-900',
      // 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
      'depth' => 2,
      // 'menu' => '',
      // 'container' => '',
      // 'container_class' => '',
      // 'container_id' => '',
      // 'menu_id' => '',
      // 'echo' => true,
      // 'before' => '',
      // 'after' => '',
      // 'list_item_class' => '',
      // 'link_before' => '<span>',
        // 'link_after' => '</span>',
      'walker' => ''
      );
      @endphp
      {!! wp_nav_menu($defaults) !!}
      @endif
      {{-- <a class="mr-5 hover:text-gray-900">First Link</a>
      <a class="mr-5 hover:text-gray-900">Second Link</a>
      <a class="mr-5 hover:text-gray-900">Third Link</a>
      <a class="mr-5 hover:text-gray-900">Fourth Link</a> --}}
    </nav>
    <button
      class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">Button
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
      </svg>
    </button>
  </div>
</header>