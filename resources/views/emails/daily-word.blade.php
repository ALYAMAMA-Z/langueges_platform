<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word of the Day</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .word {
            text-align: center;
            font-size: 48px;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0;
        }
        .translation {
            text-align: center;
            font-size: 24px;
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        .definition, .example {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #95a5a6;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📖 Word of the Day</h1>
            <p>Hello {{ $user->name }}!</p>
        </div>
        
        <div class="word">
            {{ $dailyWord->word_en }}
        </div>
        
        <div class="translation">
            {{ $dailyWord->word_ar }}
        </div>
        
        <div class="definition">
            <strong>📝 Meaning:</strong><br>
            {{ $dailyWord->definition_en }}
            <hr>
            <strong>المعنى:</strong><br>
            {{ $dailyWord->definition_ar }}
        </div>
        
        <div class="example">
            <strong>💡 Example:</strong><br>
            {{ $dailyWord->example_en }}
            <hr>
            <strong>مثال:</strong><br>
            {{ $dailyWord->example_ar }}
        </div>
        
        <div style="text-align: center;">
            <a href="{{ url('/') }}" class="btn">
                📚 Learn More
            </a>
        </div>
        
        <div class="footer">
            This email was sent automatically from Language Learning Platform.<br>
            To change notification settings, please log in to your account.
        </div>
    </div>
</body>
</html>