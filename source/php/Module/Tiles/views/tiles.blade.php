<section id="{{ $sectionID }}" class="section-tiles">
    <div class="container container-fullwidth">
        <div class="c-tiles grid no-gutter" data-packery='{ "itemSelector": ".js-tiles__grid", "percentPosition": true, "transitionDuration": 500, "gutter" : 0 }'>
            @foreach ($tiles as $tile)
                @if($tile->image)
                    <div class="js-tiles__grid {{$tile->grid}}">
                        <div class="c-tiles__tile {{$tile->tile}} c-tiles__image" style="background-image: url('{{$tile->image}}');">
                            @if($tile->url)
                                <a class="c-tiles__link" href="{{$tile->url}}">
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="js-tiles__grid {{$tile->grid}}">
                        <div class="c-tiles__tile {{$tile->tile}}">
                            <a class="c-tiles__link" href="{{$tile->url}}">
                                @if($tile->title || $tile->content)
                                    <div class="c-tiles__content">
                                        @if($tile->title)
                                            <h4>{{$tile->title}}</h4>
                                        @endif
                                        @if($tile->content)
                                            <p>{{$tile->content}}</p>
                                        @endif
                                        <hr class="c-tiles__divider">
                                    </div>
                                @endif
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
</section>
