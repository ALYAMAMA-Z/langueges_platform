<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>شهادة إتمام - {{ $course->title_ar }}</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 50px;
            background: white;
        }
        .certificate {
            border: 10px solid #3498db;
            padding: 40px;
            text-align: center;
        }
        h1 {
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 30px;
        }
        h2 {
            color: #3498db;
            font-size: 28px;
            margin: 30px 0;
        }
        p {
            font-size: 18px;
            line-height: 1.8;
        }
        .signature {
            margin-top: 50px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
            font-style: italic;
        }
        .date {
            margin-top: 30px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>شهادة تقدير</h1>
        
        <p>تشهد منصة تعلم اللغات بأن</p>
        
        <h2>{{ $user->name }}</h2>
        
        <p>قد أتم بنجاح كورس</p>
        
        <h2>{{ $course->title_ar }}</h2>
        
        <p>وذلك بعد إتمام جميع متطلبات الكورس بنجاح.</p>
        
        <div class="signature">
            إدارة منصة تعلم اللغات
        </div>
        
        <div class="date">
            تاريخ الإصدار: {{ now()->format('d / m / Y') }}
        </div>
    </div>
</body>
</html>