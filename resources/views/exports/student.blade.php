<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }

        .header {
            background-color: #4A90E2;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .section {
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .section-header {
            background-color: #f7f7f7;
            padding: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #555;
        }

        .section-content {
            padding: 15px;
        }

        .field {
            display: flex;
            margin-bottom: 10px;
        }

        .field-label {
            width: 30%;
            font-weight: bold;
            color: #666;
        }

        .field-value {
            width: 70%;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Student Details</h1>
        </div>

        <div class="section">
            <div class="section-header">Personal Information</div>
            <div class="section-content">
                <div class="field">
                    <div class="field-label">First Name:</div>
                    <div class="field-value">{{ $data['first_name'] }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Middle Name:</div>
                    <div class="field-value">{{ $data['middle_name'] ?? '-' }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Last Name:</div>
                    <div class="field-value">{{ $data['last_name'] ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">Contact Information</div>
            <div class="section-content">
                <div class="field">
                    <div class="field-label">Phone:</div>
                    <div class="field-value">{{ $data['phone'] }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Address:</div>
                    <div class="field-value">{{ $data['address'] }}</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">Classroom Information</div>
            <div class="section-content">
                <div class="field">
                    <div class="field-label">Classroom:</div>
                    <div class="field-value">{{ $data['classroom']['name'] ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
