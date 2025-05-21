<?php

use Livewire\Volt\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\Mail;

new class extends Component {
    public $name;
    public $email;
    public $phone;
    public $preferred_date;
    public $preferred_time;
    public $message;
    public $property;

    public function mount($property)
    {
        $this->property = $property;
    }

    public function bookTour()
    {
        try {
            $validated = $this->validate([
                'name' => 'required|min:3',
                'email' => 'required|email',
                'phone' => 'required',
                'preferred_date' => 'required|date|after:today',
                'preferred_time' => 'required',
                'message' => 'nullable'
            ]);

            // \App\Models\PropertyTour::create([
            //     'property_id' => $this->property->id,
            //     'name' => $this->name,
            //     'email' => $this->email,
            //     'phone' => $this->phone,
            //     'preferred_date' => $this->preferred_date,
            //     'preferred_time' => $this->preferred_time,
            //     'message' => $this->message,
            // ]);

            Mail::to(env('CONTACT_EMAIL'))->send(new \App\Mail\InspectionBooking(
                property: $this->property,
                name: $this->name,
                email: $this->email,
                phone: $this->phone,
                preferred_date: $this->preferred_date,
                preferred_time: $this->preferred_time,
                message: $this->message,
            ));

            $this->reset(['name', 'email', 'phone', 'preferred_date', 'preferred_time', 'message']);
            LivewireAlert::text('Your property tour request has been sent successfully. We will get back to you shortly.')->success()->toast()->show();
        } catch (\Exception $e) {
            LivewireAlert::text('An error occurred while sending your request. Please try again.')->error()->toast()->show();
        }
    }
}; ?>

<div class="bg-white rounded-xl p-8 border border-gray-100">
    <h3 class="text-2xl font-bold mb-6 text-black">Schedule a Property Tour</h3>

    <div class="flex justify-between mb-8">
        <a href="tel:+234{{ $property->agent->phone ?? '8000000000' }}"
            class="flex items-center justify-center gap-2 bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-full transition duration-300 flex-1 mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            Call
        </a>
        <a href="https://wa.me/234{{ $property->agent->phone ?? '8000000000' }}"
            class="flex items-center justify-center gap-2 bg-black hover:bg-gray-800 text-[#FFF114] px-6 py-3 rounded-full transition duration-300 flex-1 ml-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
            WhatsApp
        </a>
    </div>

    <form wire:submit.prevent="bookTour" class="space-y-6">
        <div>
            <input wire:model.live="name" type="text"
                class="w-full px-0 py-3 border-b-2 border-gray-200 focus:border-[#FFF114] transition-colors duration-300 bg-transparent focus:outline-none"
                placeholder="Your full name">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <input wire:model.live="email" type="email"
                class="w-full px-0 py-3 border-b-2 border-gray-200 focus:border-[#FFF114] transition-colors duration-300 bg-transparent focus:outline-none"
                placeholder="Your email address">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <input wire:model.live="phone" type="tel"
                class="w-full px-0 py-3 border-b-2 border-gray-200 focus:border-[#FFF114] transition-colors duration-300 bg-transparent focus:outline-none"
                placeholder="Your phone number">
            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <input wire:model.live="preferred_date" type="date"
                class="w-full px-0 py-3 border-b-2 border-gray-200 focus:border-[#FFF114] transition-colors duration-300 bg-transparent focus:outline-none">
            @error('preferred_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <select wire:model.live="preferred_time"
                class="w-full px-0 py-3 border-b-2 border-gray-200 focus:border-[#FFF114] transition-colors duration-300 bg-transparent focus:outline-none">
                <option value="">Select Preferred Time</option>
                <option value="morning">Morning (9AM - 12PM)</option>
                <option value="afternoon">Afternoon (12PM - 4PM)</option>
                <option value="evening">Evening (4PM - 7PM)</option>
            </select>
            @error('preferred_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <textarea wire:model.live="message" rows="4"
                class="w-full px-0 py-3 border-b-2 border-gray-200 focus:border-[#FFF114] transition-colors duration-300 bg-transparent focus:outline-none"
                placeholder="Any additional message..."></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button wire:click="bookTour"
            class="cursor-pointer w-full bg-[#FFF114] hover:bg-yellow-300 text-black font-medium px-8 py-4 rounded-full transition duration-300">
            Schedule Tour
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="mailto:{{ $property->agent->email ?? 'contact@example.com' }}"
            class="text-gray-500 hover:text-black transition duration-300 text-sm">
            Or email us directly at {{ $property->agent->email ?? 'contact@example.com' }}
        </a>
    </div>
</div>
