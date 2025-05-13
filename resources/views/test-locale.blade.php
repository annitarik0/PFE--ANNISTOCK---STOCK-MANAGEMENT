<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Locale</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #333;
        }
        .locale-info {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .translation-test {
            margin-top: 20px;
        }
        .translation-item {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #4e73df;
        }
        .language-switcher {
            margin-top: 20px;
            padding: 10px;
            background-color: #eef;
            border-radius: 5px;
        }
        .language-switcher a {
            display: inline-block;
            margin-right: 10px;
            padding: 5px 10px;
            background-color: #4e73df;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        .language-switcher a.active {
            background-color: #2e53bf;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Locale Test Page</h1>
        
        <div class="locale-info">
            <p><strong>Current Locale:</strong> {{ app()->getLocale() }}</p>
            <p><strong>Session Locale:</strong> {{ session('locale') }}</p>
            <p><strong>Cookie Locale:</strong> {{ request()->cookie('locale') }}</p>
        </div>
        
        <div class="translation-test">
            <h2>Translation Test</h2>
            
            <div class="translation-item">
                <strong>Dashboard:</strong> {{ __('messages.dashboard') }}
            </div>
            
            <div class="translation-item">
                <strong>Products:</strong> {{ __('messages.products') }}
            </div>
            
            <div class="translation-item">
                <strong>Categories:</strong> {{ __('messages.categories') }}
            </div>
            
            <div class="translation-item">
                <strong>Orders:</strong> {{ __('messages.orders') }}
            </div>
            
            <div class="translation-item">
                <strong>Users:</strong> {{ __('messages.users') }}
            </div>
        </div>
        
        <div class="language-switcher">
            <h3>Change Language</h3>
            <a href="{{ route('locale.change', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">English</a>
            <a href="{{ route('locale.change', 'fr') }}" class="{{ app()->getLocale() == 'fr' ? 'active' : '' }}">Français</a>
        </div>
    </div>
</body>
</html>
