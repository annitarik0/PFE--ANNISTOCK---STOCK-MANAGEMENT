<div class="container-fluid navbar-card">
    <div class="row">
        <div class="col-xl-12">
            <div class="card {{ $bgColor ?? 'bg-primary' }} mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white">
                            <i class="mdi {{ $icon ?? 'mdi-information' }} mr-1"></i> {{ $title ?? 'Information' }}
                        </h6>
                        @if(isset($count))
                        <h4 class="mb-3 mt-0 float-right">{{ $count }}</h4>
                        @endif
                    </div>
                    @if(isset($subtitle))
                    <div>
                        @if(isset($badge))
                        <span class="badge badge-light {{ $badgeClass ?? '' }}">
                            <i class="mdi {{ $badgeIcon ?? 'mdi-information' }}"></i> {{ $badge }}
                        </span>
                        @endif
                        <span class="ml-2 text-white">{{ $subtitle }}</span>
                    </div>
                    @endif
                </div>
                <div class="p-3">
                    @if(isset($linkUrl) && isset($linkIcon))
                    <div class="float-right">
                        <a href="{{ $linkUrl }}" class="text-white"><i class="mdi {{ $linkIcon }} h5"></i></a>
                    </div>
                    @endif
                    <p class="font-14 m-0 text-white">
                        {{ $slot }}
                    </p>
                    @if(isset($footerLeft) && isset($footerRight))
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="font-12 text-white">{{ $footerLeft }}</span>
                        <span class="font-12 text-white">{{ $footerRight }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
