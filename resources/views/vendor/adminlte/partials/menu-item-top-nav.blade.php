
@if (is_array($item))
    <li class="{{ $item['top_nav_class'] }}">    
        @if (isset($item['submenu']))
            <ul class="dropdown-menu" role="menu">
                @foreach($item['submenu'] as $subitem)
                    @if (is_string($subitem))
                        @if($subitem == '-')
                            <li role="separator" class="divider"></li>
                        @else
                            <li class="dropdown-header">{{ $subitem }}</li>
                        @endif
                    @else
                    <li class="{{ $subitem['top_nav_class'] }}">
                        <a href="{{ $subitem['href'] }}">
                            <i class="fa fa-{{ isset($subitem['icon']) ? $subitem['icon'] : 'circle-o' }} {{ isset($subitem['icon_color']) ? 'text-' . $subitem['icon_color'] : '' }}"></i>
                            {{ $subitem['text'] }}
                            @if (isset($subitem['label']))
                                <span class="label label-{{ isset($subitem['label_color']) ? $subitem['label_color'] : 'primary' }}">{{ $subitem['label'] }}</span>
                            @endif
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </li>
@endif
