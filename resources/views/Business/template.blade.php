{{-- resources/views/contracts/template.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <title>Contract</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .contract-content {
            margin: 20px;
        }

        h2 {
            text-align: center;
        }

        .details,
        .signatures {
            margin-top: 20px;
        }

        .signature-field {
            margin-top: 30px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
        }

        p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="contract-content">
        <h2>Contract</h2>
        <div class="details">
            <p><strong>Business Name:</strong> {{ $business->name }}</p>
            <p><strong>Business Email:</strong> {{ $business->email }}</p>
            <p><strong>Client Name:</strong> {{ $clientName }}</p>
            <p><strong>Client Email:</strong> {{ $clientEmail }}</p>
            <p><strong>Advertentie Title:</strong> {{ $advertentie->titel }}</p>
            <p><strong>Date:</strong> {{ $date }}</p>
        </div>
        <div class="signatures">
            <div class="signature-field">
                <div class="signature-line"></div>
                <p>Signature Business</p>
            </div>
            <div class="signature-field">
                <div class="signature-line"></div>
                <p>Signature Client</p>
            </div>
        </div>
    </div>
</body>

</html>
