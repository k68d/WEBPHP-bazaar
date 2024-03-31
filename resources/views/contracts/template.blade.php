{{-- resources/views/contracts/template.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contract</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>

<body>
    <h1>Contract</h1>
    <p><strong>{{ __('texts.user_1') }}:</strong> {{ $userOne->name }}</p>
    <p><strong>{{ __('texts.user_2') }}:</strong> {{ $userTwo->name }}</p>
    <p><strong>{{ __('texts.description') }}:</strong> {{ $description }}</p>
    <p><strong>{{ __('texts.contract_date') }}:</strong> {{ $contractDate->format('Y-m-d') }}</p>
    <p><strong>{{ __('texts.status') }}:</strong> {{ $status }}</p>
    <p><strong>{{ __('texts.additional_info') }}:</strong> {{ $additionalInfo }}</p>

    <div class="signatures">
        <p>{{ __('texts.signature_user_1') }}: _______________________________</p>
        <p>{{ __('texts.signature_user_2') }}: _______________________________</p>
    </div>
</body>

</html>
