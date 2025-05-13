<div class="language-switcher">
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="mdi mdi-translate"></i> 
            {{ session('locale') == 'fr' ? __('messages.french') : __('messages.english') }}
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
            <a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('language.switch', 'en') }}">
                <i class="mdi mdi-flag-outline"></i> {{ __('messages.english') }}
            </a>
            <a class="dropdown-item {{ session('locale') == 'fr' ? 'active' : '' }}" href="{{ route('language.switch', 'fr') }}">
                <i class="mdi mdi-flag-outline"></i> {{ __('messages.french') }}
            </a>
        </div>
    </div>
</div>
