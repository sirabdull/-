<!DOCTYPE html>
<html>

<head>
    <title>Property Enquiry Notification</title>
</head>

<body>
    <h2>New Property Enquiry</h2>

    <p>Hello Admin,</p>

    <p>A new property enquiry has been received with the following details:</p>

    <div style="margin: 20px 0;">
        <p><strong>Name:</strong> {{ $enquiry->name }}</p>
        <p><strong>Email:</strong> {{ $enquiry->email }}</p>
        <p><strong>Phone:</strong> {{ $enquiry->phone }}</p>
        <p><strong>Message:</strong> {{ $enquiry->message }}</p>
    </div>

    <div style="margin: 20px 0;">
        <h3>Property Details:</h3>
        <img src="{{ asset($property->image) }}" alt="{{ $property->title }}"
            style="max-width: 300px; margin-bottom: 15px;">
        <p><strong>Property ID:</strong> {{ $property->id }}</p>
        <p><strong>Property Title:</strong> {{ $property->title }}</p>
        <p><strong>Property Location:</strong> {{ $property->location }}</p>
    </div>

    <p>Please respond to this enquiry as soon as possible.</p>

    <p>Best regards,<br>
        {{ config('app.name') }}</p>
</body>

</html>
