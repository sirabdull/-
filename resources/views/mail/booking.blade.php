<!DOCTYPE html>
<html>

<head>
    <title>Property Tour Booking</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #000; margin-bottom: 20px;">New Property Tour Booking</h2>

        <div style="background: #f9f9f9; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3 style="margin-top: 0;">Property Details</h3>
            <p><strong>Property:</strong> {{ $property->title }}</p>
            <p><strong>Location:</strong> {{ $property->location }}</p>
            <p><strong>Price:</strong> ₦{{ number_format($property->price) }}</p>
        </div>

        <div style="background: #f9f9f9; padding: 20px; border-radius: 5px;">
            <h3 style="margin-top: 0;">Booking Details</h3>
            <p><strong>Client Name:</strong> {{ $name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Phone:</strong> {{ $phone }}</p>
            <p><strong>Preferred Date:</strong> {{ date('d M, Y', strtotime($preferred_date)) }}</p>
            <p><strong>Preferred Time:</strong> {{ ucfirst($preferred_time) }}</p>
            @if($message)
                <p><strong>Additional Message:</strong><br>{{ $message }}</p>
            @endif
        </div>

        <div style="margin-top: 20px; font-size: 14px; color: #666;">
            <p>Please contact the client to confirm the tour booking.</p>
        </div>
    </div>
</body>

</html>
